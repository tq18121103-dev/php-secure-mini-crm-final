<?php

namespace App\Controllers;

use App\Core\Database;

class HealthController
{
    public function index(): void
    {
        header('Content-Type: application/json');

        Database::getConnection();

        echo json_encode([
            'status' => 'ok',
            'database' => 'connected',
            'app' => 'Secure Mini CRM',
        ]);
    }
}