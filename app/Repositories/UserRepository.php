<?php

namespace App\Repositories;

use App\Core\Database;
use PDO;

class UserRepository
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
    }

    public function findByUsername(string $username): ?array
    {
        $stmt = $this->pdo->prepare("
            SELECT *
            FROM users
            WHERE username = ?
            LIMIT 1
        ");

        $stmt->execute([$username]);

        return $stmt->fetch() ?: null;
    }
}