<?php

require_once DAO_PATH . 'ProductDAO.php';
require_once DAO_PATH . 'DiscountDAO.php';
require_once DAO_PATH . 'UserTypeDAO.php';
require_once DAO_PATH . 'UserDAO.php';
require_once UTIL_PATH . 'SessionUtils.php';
require_once MODEL_PATH . 'User.php';

class GeneralController
{
    /**
     * Show the home page
     */
    public function home()
    {
        $view = 'general/home.php';
        
        $productDAO = new ProductDAO();
        $products = $productDAO->getAllProducts();
        $topRatedProducts = $productDAO->getTopRatedProducts(5);
        $newestProducts = $productDAO->getNewestProducts(5);
        
        include_once VIEW_PATH . 'main.php';
    }

    /**
     * Show the membership page
     */
    public function membership()
    {
        $view = 'general/membership.php';
        
        $discountDAO = new DiscountDAO();
        $userTypeDAO = new UserTypeDAO();
        
        $membershipUserType = $userTypeDAO->getUserTypesByFilter(['name' => 'membership'])[0];
        $membershipDiscount = $discountDAO->getDiscountByUserType((int)$membershipUserType->getId());
        
        include_once VIEW_PATH . 'main.php';
    }

    /**
     * Upgrade user to membership
     */
    public function becomeMember()
    {
        if (!SessionUtils::isLogged()) {
            SessionUtils::setFlashHttpResponse(401, 'You must be logged in to upgrade to membership');
            header('Location: ?controller=Auth&action=showLogin');
            exit;
        }

        try {
            $userTypeDAO = new UserTypeDAO();
            $membershipTypes = $userTypeDAO->getUserTypesByFilter(['name' => 'membership']);
            if (empty($membershipTypes)) {
                throw new Exception('Membership type not found');
            }

            $membershipTypeId = $membershipTypes[0]->getId();
            $userId = SessionUtils::getUserId();
            $userDAO = new UserDAO();
            $user = $userDAO->getUserById($userId);
            if (!$user) {
                throw new Exception('User not found');
            }

            if ((int)$user->getUserTypeId() === (int)$membershipTypeId) {
                SessionUtils::setFlashHttpResponse(200, 'You are already a member');
                header('Location: ?controller=General&action=home');
                exit;
            }

            $user->setUserTypeId($membershipTypeId);
            
            if ($userDAO->updateUser($user)) {
                SessionUtils::setFlashHttpResponse(200, 'Congratulations! You are now a member of Bees Cavern!');
                header('Location: ?controller=General&action=home');
                exit;
            } else {
                throw new Exception('Failed to update user membership');
            }
        } catch (Exception $e) {
            SessionUtils::setFlashHttpResponse(500, 'Error upgrading to membership: ' . $e->getMessage());
            header('Location: ?controller=General&action=membership');
            exit;
        }
    }
}
