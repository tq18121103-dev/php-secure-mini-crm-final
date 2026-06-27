<?php

namespace App\Services;

use App\Repositories\UserRepository;

class AuthService
{
    private UserRepository $users;

    public function __construct()
    {
        $this->users = new UserRepository();
    }

    public function attempt(string $username, string $password): array
    {
        $errors = [];

        if ($username === '') {
            $errors['username'] = 'Username is required.';
        }

        if ($password === '') {
            $errors['password'] = 'Password is required.';
        }

        if (!empty($errors)) {
            return [
                'success' => false,
                'errors' => $errors,
                'user' => null,
            ];
        }

        $user = $this->users->findByUsername($username);

        if (!$user || !password_verify($password, $user['password'])) {
            return [
                'success' => false,
                'errors' => [
                    'general' => 'Username or password is incorrect.',
                ],
                'user' => null,
            ];
        }

        return [
            'success' => true,
            'errors' => [],
            'user' => $user,
        ];
    }
}