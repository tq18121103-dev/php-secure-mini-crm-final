<?php

namespace App\Repositories;

use App\Core\Database;
use App\Core\DuplicateRecordException;
use PDO;
use PDOException;

class LeadRepository
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
    }

    public function paginate(string $keyword, int $limit, int $offset): array
    {
        $sql = "
            SELECT *
            FROM leads
        ";

        if ($keyword !== '') {
            $sql .= "
                WHERE lead_code LIKE :keyword
                   OR full_name LIKE :keyword
                   OR email LIKE :keyword
                   OR phone LIKE :keyword
                   OR source LIKE :keyword
                   OR status LIKE :keyword
            ";
        }

        $allowedSorts = [
            'id' => 'id',
            'lead_code' => 'lead_code',
            'full_name' => 'full_name',
            'email' => 'email',
            'source' => 'source',
            'status' => 'status',
            'created_at' => 'created_at',
        ];

        $sort = $_GET['sort'] ?? 'id';
        $direction = strtoupper($_GET['direction'] ?? 'DESC');

        $sortColumn = $allowedSorts[$sort] ?? 'id';

        if (!in_array($direction, ['ASC', 'DESC'], true)) {
            $direction = 'DESC';
        }

        $sql .= "
            ORDER BY $sortColumn $direction
            LIMIT :limit OFFSET :offset
        ";

        $stmt = $this->pdo->prepare($sql);

        if ($keyword !== '') {
            $stmt->bindValue(':keyword', '%' . $keyword . '%', PDO::PARAM_STR);
        }

        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function count(string $keyword = ''): int
    {
        $sql = "
            SELECT COUNT(*)
            FROM leads
        ";

        if ($keyword !== '') {
            $sql .= "
                WHERE lead_code LIKE :keyword
                   OR full_name LIKE :keyword
                   OR email LIKE :keyword
                   OR phone LIKE :keyword
                   OR source LIKE :keyword
                   OR status LIKE :keyword
            ";
        }

        $stmt = $this->pdo->prepare($sql);

        if ($keyword !== '') {
            $stmt->bindValue(':keyword', '%' . $keyword . '%', PDO::PARAM_STR);
        }

        $stmt->execute();

        return (int) $stmt->fetchColumn();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->pdo->prepare("
            SELECT *
            FROM leads
            WHERE id = ?
        ");

        $stmt->execute([$id]);

        return $stmt->fetch() ?: null;
    }

    public function create(array $data): void
    {
        try {
            $stmt = $this->pdo->prepare("
                INSERT INTO leads
                (
                    lead_code,
                    full_name,
                    email,
                    phone,
                    source,
                    status
                )
                VALUES
                (
                    :lead_code,
                    :full_name,
                    :email,
                    :phone,
                    :source,
                    :status
                )
            ");

            $stmt->execute([
                'lead_code' => $data['lead_code'],
                'full_name' => $data['full_name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'source' => $data['source'],
                'status' => $data['status'],
            ]);
        } catch (PDOException $e) {
            if ($e->getCode() === '23000') {
                throw new DuplicateRecordException(
                    'Lead code or email already exists.'
                );
            }

            throw $e;
        }
    }

    public function update(int $id, array $data): void
    {
        try {
            $stmt = $this->pdo->prepare("
                UPDATE leads
                SET
                    lead_code = :lead_code,
                    full_name = :full_name,
                    email = :email,
                    phone = :phone,
                    source = :source,
                    status = :status
                WHERE id = :id
            ");

            $stmt->execute([
                'id' => $id,
                'lead_code' => $data['lead_code'],
                'full_name' => $data['full_name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'source' => $data['source'],
                'status' => $data['status'],
            ]);
        } catch (PDOException $e) {
            if ($e->getCode() === '23000') {
                throw new DuplicateRecordException(
                    'Lead code or email already exists.'
                );
            }

            throw $e;
        }
    }

    public function delete(int $id): void
    {
        $stmt = $this->pdo->prepare("
            DELETE FROM leads
            WHERE id = ?
        ");

        $stmt->execute([$id]);
    }
}