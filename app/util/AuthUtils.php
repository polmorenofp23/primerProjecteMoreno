<?php

require_once DAO_PATH . 'UserDAO.php';

/**
 * Static authentication helpers.
 *
 * These helpers centralize authentication logic (login checks, existence checks)
 * and reuse the `UserDAO` for data access. Keep methods static for easy use
 * from controllers.
 */
class AuthUtils
{
    /**
     * Authenticate a user by username or email and plain password.
     * Returns a User instance on success, or null on failure.
     *
     * @param string $identifier Username or email
     * @param string $password Plain-text password to verify
     * @return User|null
     */
    public static function authenticate(string $identifier, string $password)
    {
        $dao = new UserDAO();

        $user = $dao->getUserByUsername($identifier);
        if (!$user) {
            $user = $dao->getUserByEmail($identifier);
        }

        if (!$user) return null;

        if ($user->verifyPassword($password)) {
            return $user;
        }

        return null;
    }

    /**
     * Check whether a username already exists in the database.
     */
    public static function existsByUsername(string $username): bool
    {
        $dao = new UserDAO();
        $user = $dao->getUserByUsername($username);
        return $user !== null;
    }

    /**
     * Check whether an email already exists in the database.
     */
    public static function existsByEmail(string $email): bool
    {
        $dao = new UserDAO();
        $user = $dao->getUserByEmail($email);
        return $user !== null;
    }
}
