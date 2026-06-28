<?php

namespace App\Controllers;

use App\Services\AuthService;

class AuthController
{
    private AuthService $service;

    public function __construct()
    {
        $this->service = new AuthService();
    }

    public function login(): void
    {
        if (!empty($_SESSION['user_id'])) {
            redirect('/dashboard');
        }

        render('auth/login', [
            'title' => 'Login',
            'errors' => $_SESSION['errors'] ?? [],
            'old' => $_SESSION['old'] ?? [],
        ]);

        unset($_SESSION['errors'], $_SESSION['old']);
    }

    public function handleLogin(): void
    {
        verify_csrf();

        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        $result = $this->service->attempt($username, $password);

        if (!$result['success']) {
            $_SESSION['errors'] = $result['errors'];
            $_SESSION['old'] = [
                'username' => $username,
            ];

            redirect('/login');
        }

        session_regenerate_id(true);

        $_SESSION['user_id'] = $result['user']['id'];
        $_SESSION['username'] = $result['user']['username'];
        $_SESSION['role'] = $result['user']['role'];
        $_SESSION['last_activity'] = time();

        flash('success', 'Login successfully.');

        redirect('/dashboard');
    }

    public function logout(): void
    {
        verify_csrf();
        
        $_SESSION = [];

        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();

            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params['path'],
                $params['domain'] ?? '',
                $params['secure'] ?? false,
                $params['httponly'] ?? true
            );
        }

        session_destroy();

        redirect('/login');
    }
}