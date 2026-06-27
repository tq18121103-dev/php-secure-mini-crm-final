<?php

namespace App\Services;

use App\Core\DuplicateRecordException;
use App\Repositories\LeadRepository;

class LeadService
{
    private LeadRepository $repository;

    public function __construct()
    {
        $this->repository = new LeadRepository();
    }

    public function list(string $keyword, int $page, int $limit): array
    {
        $page = max(1, $page);
        $offset = ($page - 1) * $limit;

        $leads = $this->repository->paginate($keyword, $limit, $offset);
        $total = $this->repository->count($keyword);
        $totalPages = max(1, (int) ceil($total / $limit));

        if ($page > $totalPages) {
            $page = $totalPages;
            $offset = ($page - 1) * $limit;
            $leads = $this->repository->paginate($keyword, $limit, $offset);
        }

        return [
            'leads' => $leads,
            'page' => $page,
            'totalPages' => $totalPages,
        ];
    }

    public function find(int $id): ?array
    {
        return $this->repository->find($id);
    }

    public function create(array $data): array
    {
        $errors = $this->validate($data);

        if (!empty($errors)) {
            return [
                'success' => false,
                'errors' => $errors,
            ];
        }

        try {
            $this->repository->create($data);

            return [
                'success' => true,
                'errors' => [],
            ];
        } catch (DuplicateRecordException $e) {
            return [
                'success' => false,
                'errors' => [
                    'general' => $e->getMessage(),
                ],
            ];
        }
    }

    public function update(int $id, array $data): array
    {
        $errors = $this->validate($data);

        if (!empty($errors)) {
            return [
                'success' => false,
                'errors' => $errors,
            ];
        }

        try {
            $this->repository->update($id, $data);

            return [
                'success' => true,
                'errors' => [],
            ];
        } catch (DuplicateRecordException $e) {
            return [
                'success' => false,
                'errors' => [
                    'general' => $e->getMessage(),
                ],
            ];
        }
    }

    public function delete(int $id): void
    {
        $this->repository->delete($id);
    }

    private function validate(array $data): array
    {
        $errors = [];

        if ($data['lead_code'] === '') {
            $errors['lead_code'] = 'Lead code is required.';
        }

        if ($data['full_name'] === '') {
            $errors['full_name'] = 'Full name is required.';
        }

        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Invalid email.';
        }

        if ($data['phone'] === '') {
            $errors['phone'] = 'Phone is required.';
        }

        if ($data['source'] === '') {
            $errors['source'] = 'Source is required.';
        }

        $allowedStatuses = [
            'new',
            'contacted',
            'qualified',
            'lost',
            'customer',
        ];

        if ($data['status'] === '') {
            $errors['status'] = 'Status is required.';
        } elseif (!in_array($data['status'], $allowedStatuses, true)) {
            $errors['status'] = 'Invalid status.';
        }

        return $errors;
    }
}