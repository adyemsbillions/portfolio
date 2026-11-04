<?php
/**
 * Front controller. All clean URLs route through here (no .php in the browser).
 */

// PHP built-in dev server: let it serve real static files (css/js/images) directly.
if (PHP_SAPI === 'cli-server') {
    $file = __DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    if (is_file($file) && strpos(realpath($file), realpath(__DIR__ . '/assets')) === 0) {
        return false;
    }
}

require __DIR__ . '/includes/bootstrap.php';

// If not installed yet, point the user to the installer.
try {
    db()->query('SELECT 1 FROM settings LIMIT 1');
} catch (Throwable $e) {
    if (is_file(__DIR__ . '/install.php')) {
        redirect('install.php');
    }
    http_response_code(500);
    exit('Not installed. Add install.php and open /install.');
}

// ---- Parse the request path, base-folder aware ----
$uri  = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri  = urldecode($uri);
$base = base_path();
if ($base !== '' && strpos($uri, $base) === 0) {
    $uri = substr($uri, strlen($base));
}
$path = trim($uri, '/');
$seg  = $path === '' ? [] : explode('/', $path);
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

// ---- Admin area ----
if (($seg[0] ?? '') === 'admin') {
    require __DIR__ . '/app/admin/router.php';
    exit;
}

// ---- Public routes ----
if ($path === '') {
    require __DIR__ . '/app/controllers/home.php';
    exit;
}

if ($seg[0] === 'project' && isset($seg[1])) {
    $slug = $seg[1];
    $stmt = db()->prepare('SELECT * FROM projects WHERE slug = ? LIMIT 1');
    $stmt->execute([$slug]);
    $project = $stmt->fetch();
    if (!$project) {
        http_response_code(404);
        view('404');
        exit;
    }
    $links = db()->prepare('SELECT * FROM project_links WHERE project_id = ? ORDER BY sort_order');
    $links->execute([$project['id']]);
    view('project', ['project' => $project, 'links' => $links->fetchAll()]);
    exit;
}

if ($seg[0] === 'contact' && $method === 'POST') {
    verify_csrf();
    $name  = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $body  = trim($_POST['body'] ?? '');
    if ($name && $body) {
        db()->prepare('INSERT INTO messages (name, email, body) VALUES (?,?,?)')
            ->execute([$name, $email, $body]);
        flash('Thanks — your note is on its way. I\'ll get back to you.');
    } else {
        flash('Please add your name and a short note.', 'error');
    }
    redirect('#contact');
}

// ---- 404 ----
http_response_code(404);
view('404');
