<?php

namespace App\Controllers;

use App\Services\OrderService;

class OrderController
{
    private OrderService $service;

    public function __construct()
    {
        $this->service = new OrderService();
    }

    public function index(): void
    {
        require_login();

        $keyword = trim($_GET['keyword'] ?? '');
        $page = (int) ($_GET['page'] ?? 1);
        $limit = 5;

        $result = $this->service->list($keyword, $page, $limit);

        render('orders/index', [
            'title' => 'Orders',
            'orders' => $result['orders'],
            'keyword' => $keyword,
            'page' => $result['page'],
            'totalPages' => $result['totalPages'],
        ]);
    }

    public function create(): void
    {
        require_login();
        require_admin();

        render('orders/create', [
            'title' => 'Create Order',
            'errors' => $_SESSION['errors'] ?? [],
            'old' => $_SESSION['old'] ?? [],
        ]);

        unset($_SESSION['errors'], $_SESSION['old']);
    }

    public function store(): void
    {
        require_login();
        require_admin();

        verify_csrf();

        $data = $this->input();

        $result = $this->service->create($data);

        if (!$result['success']) {
            $_SESSION['errors'] = $result['errors'];
            $_SESSION['old'] = $data;

            redirect('/orders/create');
        }

        flash('success', 'Order created successfully.');

        redirect('/orders');
    }

    public function edit(): void
    {
        require_login();
        require_admin();

        $id = (int) ($_GET['id'] ?? 0);

        $order = $this->service->find($id);

        if (!$order) {
            http_response_code(404);
            render('errors/404', ['title' => '404 Not Found']);
            return;
        }

        render('orders/edit', [
            'title' => 'Edit Order',
            'order' => $order,
            'errors' => $_SESSION['errors'] ?? [],
            'old' => $_SESSION['old'] ?? [],
        ]);

        unset($_SESSION['errors'], $_SESSION['old']);
    }

    public function update(): void
    {
        require_login();
        require_admin();

        verify_csrf();

        $id = (int) ($_POST['id'] ?? 0);
        $data = $this->input();

        $result = $this->service->update($id, $data);

        if (!$result['success']) {
            $_SESSION['errors'] = $result['errors'];
            $_SESSION['old'] = $data;

            redirect('/orders/edit?id=' . $id);
        }

        flash('success', 'Order updated successfully.');

        redirect('/orders');
    }

    public function delete(): void
    {
        require_login();
        require_admin();
        
        verify_csrf();

        $id = (int) ($_POST['id'] ?? 0);

        $this->service->delete($id);

        flash('success', 'Order deleted successfully.');

        redirect('/orders');
    }

    private function input(): array
    {
        return [
            'order_code' => trim($_POST['order_code'] ?? ''),
            'lead_id' => trim($_POST['lead_id'] ?? ''),
            'amount' => trim($_POST['amount'] ?? ''),
            'order_status' => trim($_POST['order_status'] ?? ''),
        ];
    }
}