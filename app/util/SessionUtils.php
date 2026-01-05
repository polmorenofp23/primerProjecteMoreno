<?php

require_once DAO_PATH . 'UserDAO.php';
require_once MODEL_PATH . 'User.php';

class SessionUtils
{
	/**
	 * Ensure the session "tool" is started
	 */
	public static function ensureStarted(): void
	{
		if (session_status() !== PHP_SESSION_ACTIVE) {
			session_start();
		}
	}

	/**
	 * Marks the user as authenticated (stores the id in the session)
	 */
	public static function login(int $userId): void
	{
		self::ensureStarted();
		$_SESSION['id_user'] = $userId;
		session_regenerate_id(true);
	}

	/**
	 * Log out of the current user
	 */
	public static function logout(): void
	{
		self::ensureStarted();
		if (!self::isLogged()) { return; } 
		unset($_SESSION['id_user']);
		session_regenerate_id(true);
	}

	/**
	 * Returns bool of if there's a user logged
	 */
	public static function isLogged(): bool
	{
		self::ensureStarted();
		return !empty($_SESSION['id_user']);
	}

    /**
	 * Require a user logged, if not redirect to given URL
	 */
	public static function requireLogin(string $redirect = '?controller=Auth&action=showLogin'): void
	{
		if (!self::isLogged()) {
			header('Location: ' . $redirect);
			exit;
		}
	}
    
	/**
	 * Returns the logged userId
	 */
	public static function getUserId(): ?int
	{
		self::ensureStarted();
		return isset($_SESSION['id_user']) ? (int)$_SESSION['id_user'] : null;
	}

	/**
	 * Returns the logged User object
	 */
	public static function getSessionUser()
	{
		$id = self::getUserId();
		if ($id === null) return null;
		$dao = new UserDAO();
		return $dao->getUserById($id);
	}
	
	/**
	 * Returns whether the logged user is an admin
	 */
	public static function isAdmin(): bool
	{
		$user = self::getSessionUser();
		return $user !== null && $user->getRole() === 'admin';
	}

	/**
	 * Require the current user to be an admin
	 */
	public static function requireAdmin(string $redirect = '?controller=product&action=index'): void
	{
		if (!self::isAdmin()) {
			self::setFlashHttpResponse(403, 'Forbidden access, it\'s only for administrators.');
			header('Location: ' . $redirect);
			exit;
		}
	}

	/**
	 * Store a temporary http response (code + message) in session to be shown after redirect
	 */
	public static function setFlashHttpResponse(int $code, ?string $message = null): void
	{
		self::ensureStarted();
		$_SESSION['http_response'] = ['code' => $code, 'message' => $message];
	}

	/**
	 * Retrieve and clear the flash http response from session. Returns array|null
	 */
	public static function getFlashHttpResponse(): ?array
	{
		self::ensureStarted();
		if (!isset($_SESSION['http_response'])) return null;
		$httpResponse = $_SESSION['http_response'];
		unset($_SESSION['http_response']);
		return is_array($httpResponse) ? $httpResponse : null;
	}

	/**
	 * Destroys the session completely
	 */
	public static function destroy(): void
	{
		self::ensureStarted();
		session_unset();
		session_destroy();
	}
}