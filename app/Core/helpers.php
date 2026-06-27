<?php

function e(?string $value): string
{
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

function redirect(string $path): void
{
    header('Location: ' . $path);
    exit;
}

function render(string $view, array $data = [], string $layout = 'layouts/main'): void
{
    extract($data);

    ob_start();
    require __DIR__ . '/../Views/' . $view . '.php';
    $content = ob_get_clean();

    require __DIR__ . '/../Views/' . $layout . '.php';
}

function partial(string $view, array $data = []): void
{
    extract($data);
    require __DIR__ . '/../Views/partials/' . $view . '.php';
}

function flash(string $key, string $message): void
{
    $_SESSION['_flash'][$key] = $message;
}

function get_flash(string $key): ?string
{
    $message = $_SESSION['_flash'][$key] ?? null;
    unset($_SESSION['_flash'][$key]);
    return $message;
}

function is_logged_in(): bool
{
    return !empty($_SESSION['user_id']);
}

function require_login(): void
{
    if (!is_logged_in()) {
        flash('error', 'Please login first.');
        redirect('/login');
    }
}

function check_session_timeout(): void
{
    $timeout = 1800; // 30 phút

    if (!empty($_SESSION['last_activity'])) {
        if (time() - $_SESSION['last_activity'] > $timeout) {
            $_SESSION = [];
            session_destroy();

            session_start();
            flash('error', 'Your session has expired. Please login again.');
            redirect('/login');
        }
    }

    $_SESSION['last_activity'] = time();
}