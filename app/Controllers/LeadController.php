<?php

namespace App\Controllers;

use App\Services\LeadService;

class LeadController
{
    private LeadService $service;

    public function __construct()
    {
        $this->service = new LeadService();
    }

    public function index(): void
    {
        require_login();

        $keyword = trim($_GET['keyword'] ?? '');
        $page = (int) ($_GET['page'] ?? 1);
        $limit = 5;

        $result = $this->service->list($keyword, $page, $limit);

        render('leads/index', [
            'title' => 'Leads',
            'leads' => $result['leads'],
            'keyword' => $keyword,
            'page' => $result['page'],
            'totalPages' => $result['totalPages'],
        ]);
    }

    public function create(): void
    {
        require_login();

        render('leads/create', [
            'title' => 'Create Lead',
            'errors' => $_SESSION['errors'] ?? [],
            'old' => $_SESSION['old'] ?? [],
        ]);

        unset($_SESSION['errors'], $_SESSION['old']);
    }

    public function store(): void
    {
        require_login();

        $data = $this->input();

        $result = $this->service->create($data);

        if (!$result['success']) {
            $_SESSION['errors'] = $result['errors'];
            $_SESSION['old'] = $data;

            redirect('/leads/create');
        }

        flash('success', 'Lead created successfully.');

        redirect('/leads');
    }

    public function edit(): void
    {
        require_login();

        $id = (int) ($_GET['id'] ?? 0);

        $lead = $this->service->find($id);

        if (!$lead) {
            http_response_code(404);
            render('errors/404', ['title' => '404 Not Found']);
            return;
        }

        render('leads/edit', [
            'title' => 'Edit Lead',
            'lead' => $lead,
            'errors' => $_SESSION['errors'] ?? [],
            'old' => $_SESSION['old'] ?? [],
        ]);

        unset($_SESSION['errors'], $_SESSION['old']);
    }

    public function update(): void
    {
        require_login();

        $id = (int) ($_POST['id'] ?? 0);
        $data = $this->input();

        $result = $this->service->update($id, $data);

        if (!$result['success']) {
            $_SESSION['errors'] = $result['errors'];
            $_SESSION['old'] = $data;

            redirect('/leads/edit?id=' . $id);
        }

        flash('success', 'Lead updated successfully.');

        redirect('/leads');
    }

    public function delete(): void
    {
        require_login();

        $id = (int) ($_POST['id'] ?? 0);

        $this->service->delete($id);

        flash('success', 'Lead deleted successfully.');

        redirect('/leads');
    }

    private function input(): array
    {
        return [
            'lead_code' => trim($_POST['lead_code'] ?? ''),
            'full_name' => trim($_POST['full_name'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'phone' => trim($_POST['phone'] ?? ''),
            'source' => trim($_POST['source'] ?? ''),
            'status' => trim($_POST['status'] ?? ''),
        ];
    }
}