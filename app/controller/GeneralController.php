<?php

require_once DAO_PATH . 'ProductDAO.php';
require_once DAO_PATH . 'DiscountDAO.php';
require_once DAO_PATH . 'UserTypeDAO.php';

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
}
