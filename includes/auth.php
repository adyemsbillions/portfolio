<?php
/**
 * Admin authentication.
 */
function current_admin(): ?array
{
    return $_SESSION['admin'] ?? null;
}

function is_logged_in(): bool
{
    return !empty($_SESSION['admin']);
}

function require_login(): void
{
    if (!is_logged_in()) {
        redirect('admin/login');
    }
}

function attempt_login(string $username, string $password): bool
{
    $stmt = db()->prepare('SELECT * FROM admins WHERE username = ? LIMIT 1');
    $stmt->execute([$username]);
    $admin = $stmt->fetch();
    if ($admin && password_verify($password, $admin['password_hash'])) {
        $_SESSION['admin'] = ['id' => $admin['id'], 'username' => $admin['username']];
        session_regenerate_id(true);
        return true;
    }
    return false;
}

function logout(): void
{
    unset($_SESSION['admin']);
    session_regenerate_id(true);
}
