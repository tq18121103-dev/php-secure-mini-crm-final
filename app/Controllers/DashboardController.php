<?php

namespace App\Controllers;

class DashboardController
{
    public function index(): void
    {
        require_login();

        render('dashboard/index', [
            'title' => 'Dashboard',
        ]);
    }
}