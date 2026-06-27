<?php

namespace App\Controllers;

class HomeController
{
    public function index(): void
    {
        render('dashboard/index', [
            'title' => 'Secure Mini CRM',
        ]);
    }
}