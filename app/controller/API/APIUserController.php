<?php

require_once DAO_PATH . 'UserDAO.php';
require_once DAO_PATH . 'UserTypeDAO.php';
require_once UTIL_PATH . 'JsonUtils.php';

class APIUserController
{
    /**
     * List users with optional filters
     * Filters: username, email, role, user_type_id, ids (comma separated)
     */
    // GET /?controller=api&resource=User
    public function index()
    {
        $uDao = new UserDAO();
        $filters = [];

        if (isset($_GET['username']) && $_GET['username'] !== '') {
            $filters['username'] = trim($_GET['username']);
        }
        if (isset($_GET['email']) && $_GET['email'] !== '') {
            $filters['email'] = trim($_GET['email']);
        }
        if (isset($_GET['role']) && $_GET['role'] !== '') {
            $filters['role'] = trim($_GET['role']);
        }
        if (isset($_GET['user_type_id']) && $_GET['user_type_id'] !== '') {
            $filters['id_user_type'] = (int)$_GET['user_type_id'];
        }
        if (isset($_GET['ids']) && $_GET['ids'] !== '') {
            $filters['id'] = array_map('intval', array_map('trim', explode(',', $_GET['ids'])));
        }

        $orderBy = $_GET['order_by'] ?? null;
        $users = $uDao->getUsersByFilter($filters, $orderBy);
        JsonUtils::jsonResponse(JsonUtils::serializeArray($users, 'serializeUser', $this));
    }

    /**
     * Retrieve a single user by ID
     */
    // GET /?controller=api&resource=User&id=123
    public function show($id)
    {
        $uDao = new UserDAO();
        $user = $uDao->getUserById((int)$id);
        if (!$user) {
            return JsonUtils::jsonError('User not found', ['data' => null], 404);
        }
        JsonUtils::jsonResponse(JsonUtils::serializeItem($user, 'serializeUser', $this));
    }

    /**
     * Update user fields
     */
    // PUT/PATCH /?controller=api&resource=User&id=123
    public function update($id)
    {
        $uDao = new UserDAO();
        $user = $uDao->getUserById((int)$id);
        if (!$user) {
            return JsonUtils::jsonError('User not found', ['data' => null], 404);
        }

        $data = JsonUtils::readJsonBody();
        if ($data === null) {
            return JsonUtils::jsonError('Invalid JSON body', ['data' => null], 400);
        }

        $changed = false;

        if (array_key_exists('username', $data)) {
            $user->setUsername(trim((string)$data['username']));
            $changed = true;
        }
        if (array_key_exists('role', $data)) {
            $user->setRole(trim((string)$data['role']));
            $changed = true;
        }
        if (array_key_exists('userTypeId', $data)) {
            $user->setUserTypeId((int)$data['userTypeId']);
            $changed = true;
        }

        if (!$changed) {
            return JsonUtils::jsonError('No changes provided', ['data' => null], 400);
        }

        $ok = $uDao->updateUser($user);
        if (!$ok) {
            return JsonUtils::jsonError('Failed to update user', ['data' => null], 500);
        }

        $updated = $uDao->getUserById((int)$id);
        $response = JsonUtils::serializeItem($updated, 'serializeUser', $this);
        return JsonUtils::jsonResponse($response);
    }

    /**
     * Delete user by ID
     */
    // DELETE /?controller=api&resource=User&id=123
    public function destroy($id)
    {
        $uDao = new UserDAO();
        $deleted = $uDao->deleteUser((int)$id);
        if (!$deleted) {
            return JsonUtils::jsonError('User not found', ['data' => null], 404);
        }
        return JsonUtils::jsonResponse(['deleted' => true]);
    }

    /**
     * List all user types
     */
    // GET /?controller=api&resource=User&action=getUserTypes
    public function getUserTypes()
    {
        $utDao = new UserTypeDAO();
        $types = $utDao->getAllUserTypes();
        JsonUtils::jsonResponse(JsonUtils::serializeArray($types, 'serializeUserType', $this));
    }

    /**
     * Create a new user type
     */
    // POST /?controller=api&resource=User&action=createUserType
    public function createUserType()
    {
        $data = JsonUtils::readJsonBody();
        if ($data === null) {
            return JsonUtils::jsonError('Invalid JSON body', ['data' => null], 400);
        }

        $name = trim($data['name'] ?? '');
        $description = isset($data['description']) ? trim($data['description']) : null;

        $errors = [];
        if ($name === '') $errors[] = 'name is required';
        if (!empty($errors)) {
            return JsonUtils::jsonError('Validation error', ['errors' => $errors], 422);
        }

        $userType = new UserType([
            'name' => $name,
            'description' => $description,
        ]);

        $utDao = new UserTypeDAO();
        $createdId = $utDao->createUserType($userType);
        if (!$createdId) {
            return JsonUtils::jsonError('Failed to create user type', ['data' => null], 500);
        }

        $createdUserType = $utDao->getUserTypeById((int)$createdId);
        $response = JsonUtils::serializeItem($createdUserType, 'serializeUserType', $this);
        return JsonUtils::jsonResponse($response, 201);
    }

    // ---------- Helpers ----------
    public function serializeUser($user)
    {
        if (!$user) return null;
        return [
            'id' => $user->getId(),
            'userTypeId' => $user->getUserTypeId(),
            'username' => $user->getUsername(),
            'role' => $user->getRole(),
            'email' => $user->getEmail(),
            'firstName' => $user->getFirstName(),
            'lastName' => $user->getLastName(),
            'phone' => $user->getPhone(),
            'address' => $user->getAddress(),
            'birthDate' => $user->getBirthDate(),
            'registeredAt' => $user->getRegisteredAt(),
        ];
    }

    public function serializeUserType($type)
    {
        if (!$type) return null;
        return [
            'id' => $type->getId(),
            'name' => $type->getName(),
            'description' => $type->getDescription(),
        ];
    }
}
