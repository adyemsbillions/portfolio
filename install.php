<?php
/**
 * One-time installer. Open /install.php in your browser after setting
 * includes/config.php. It creates the tables and seeds starter content
 * from includes/seed_data.php. DELETE this file once it succeeds.
 */
require __DIR__ . '/includes/config.php';
require __DIR__ . '/includes/helpers.php'; // for slugify() and e()

$seed = require __DIR__ . '/includes/seed_data.php';
$messages = [];

try {
    // Connect without a database, then create it.
    $pdo = new PDO('mysql:host=' . DB_HOST . ';charset=' . DB_CHARSET, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `" . DB_NAME . "` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    $pdo->exec("USE `" . DB_NAME . "`");
    $messages[] = 'Database ready: ' . DB_NAME;

    $pdo->exec("CREATE TABLE IF NOT EXISTS settings (
        `key`   VARCHAR(100) PRIMARY KEY,
        `value` TEXT
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

    $pdo->exec("CREATE TABLE IF NOT EXISTS admins (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(60) UNIQUE NOT NULL,
        password_hash VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

    $pdo->exec("CREATE TABLE IF NOT EXISTS skills (
        id INT AUTO_INCREMENT PRIMARY KEY,
        num VARCHAR(8) DEFAULT '',
        category VARCHAR(120) DEFAULT '',
        title VARCHAR(160) NOT NULL,
        items TEXT,
        icon VARCHAR(40) DEFAULT 'layers',
        sort_order INT DEFAULT 0
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

    $pdo->exec("CREATE TABLE IF NOT EXISTS projects (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(160) NOT NULL,
        slug VARCHAR(180) UNIQUE NOT NULL,
        badge VARCHAR(80) DEFAULT '',
        signal_label VARCHAR(160) DEFAULT '',
        description TEXT,
        tags VARCHAR(255) DEFAULT '',
        meta1_label VARCHAR(40) DEFAULT '', meta1_value VARCHAR(60) DEFAULT '',
        meta2_label VARCHAR(40) DEFAULT '', meta2_value VARCHAR(60) DEFAULT '',
        meta3_label VARCHAR(40) DEFAULT '', meta3_value VARCHAR(60) DEFAULT '',
        accent VARCHAR(20) DEFAULT 'dark',
        image VARCHAR(255) DEFAULT '',
        sort_order INT DEFAULT 0,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

    $pdo->exec("CREATE TABLE IF NOT EXISTS project_links (
        id INT AUTO_INCREMENT PRIMARY KEY,
        project_id INT NOT NULL,
        label VARCHAR(80) NOT NULL,
        url VARCHAR(400) NOT NULL,
        sort_order INT DEFAULT 0,
        FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

    $pdo->exec("CREATE TABLE IF NOT EXISTS experiences (
        id INT AUTO_INCREMENT PRIMARY KEY,
        company VARCHAR(160) NOT NULL,
        role VARCHAR(160) DEFAULT '',
        period VARCHAR(80) DEFAULT '',
        description TEXT,
        sort_order INT DEFAULT 0
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

    $pdo->exec("CREATE TABLE IF NOT EXISTS messages (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(160),
        email VARCHAR(200),
        body TEXT,
        is_read TINYINT(1) DEFAULT 0,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

    $messages[] = 'Tables created.';

    // ---- Seed admin (only if none exists) ----
    if (!$pdo->query('SELECT COUNT(*) FROM admins')->fetchColumn()) {
        $pdo->prepare('INSERT INTO admins (username, password_hash) VALUES (?, ?)')
            ->execute(['admin', password_hash('admin123', PASSWORD_DEFAULT)]);
        $messages[] = 'Admin created — username: <b>admin</b>, password: <b>admin123</b> (change it after first login).';
    }

    // ---- Seed settings (only if empty) ----
    if (!$pdo->query('SELECT COUNT(*) FROM settings')->fetchColumn()) {
        $stmt = $pdo->prepare('INSERT INTO settings (`key`, `value`) VALUES (?, ?)');
        foreach ($seed['settings'] as $k => $v) {
            $stmt->execute([$k, $v]);
        }
        $messages[] = 'Settings seeded.';
    }

    // ---- Seed skills ----
    if (!$pdo->query('SELECT COUNT(*) FROM skills')->fetchColumn()) {
        $stmt = $pdo->prepare('INSERT INTO skills (num, title, category, items, icon, sort_order) VALUES (?,?,?,?,?,?)');
        foreach ($seed['skills'] as $i => $s) {
            $stmt->execute([$s[0], $s[1], $s[2], $s[3], $s[4], $i + 1]);
        }
        $messages[] = 'Skills seeded.';
    }

    // ---- Seed projects ----
    if (!$pdo->query('SELECT COUNT(*) FROM projects')->fetchColumn()) {
        $p = $pdo->prepare('INSERT INTO projects (title, slug, badge, signal_label, description, tags, meta1_label, meta1_value, meta2_label, meta2_value, meta3_label, meta3_value, accent, sort_order) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
        $l = $pdo->prepare('INSERT INTO project_links (project_id, label, url, sort_order) VALUES (?,?,?,?)');
        foreach ($seed['projects'] as $i => $pr) {
            $p->execute([
                $pr['title'], slugify($pr['title']), $pr['badge'], $pr['signal'], $pr['desc'], $pr['tags'],
                $pr['m'][0], $pr['m'][1], $pr['m'][2], $pr['m'][3], $pr['m'][4], $pr['m'][5], $pr['accent'], $i + 1,
            ]);
            $pid = $pdo->lastInsertId();
            foreach ($pr['links'] as $j => $lk) {
                $l->execute([$pid, $lk[0], $lk[1], $j]);
            }
        }
        $messages[] = 'Projects seeded.';
    }

    // ---- Seed experiences ----
    if (!$pdo->query('SELECT COUNT(*) FROM experiences')->fetchColumn()) {
        $stmt = $pdo->prepare('INSERT INTO experiences (company, role, period, description, sort_order) VALUES (?,?,?,?,?)');
        foreach ($seed['experiences'] as $i => $x) {
            $stmt->execute([$x[0], $x[1], $x[2], $x[3], $i + 1]);
        }
        $messages[] = 'Experience seeded.';
    }

    $ok = true;
} catch (Throwable $ex) {
    $ok = false;
    $error = $ex->getMessage();
}
$home = rtrim(str_replace('install.php', '', $_SERVER['PHP_SELF'] ?? '/'), '/');
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Install · <?= APP_NAME ?></title>
<style>
  body{font-family:ui-monospace,Menlo,Consolas,monospace;background:#0e0e10;color:#e8e8e8;max-width:640px;margin:40px auto;padding:0 20px;line-height:1.6}
  h1{color:#cbf94e} a{color:#8f7bff} .ok{color:#8ae28a} .err{color:#ff8a8a}
  .box{background:#17171b;border:1px solid #2a2a30;border-radius:12px;padding:20px;margin:16px 0}
  code{background:#000;padding:2px 6px;border-radius:4px}
</style>
</head>
<body>
<h1>adyems · installer</h1>
<?php if ($ok): ?>
  <div class="box">
    <?php foreach ($messages as $m): ?><div class="ok">✓ <?= $m ?></div><?php endforeach; ?>
  </div>
  <p>Done. Now:</p>
  <ol>
    <li><b>Delete this file</b> (<code>install.php</code>).</li>
    <li>Open your site: <a href="<?= e($home) ?>/">home page</a></li>
    <li>Log in at <a href="<?= e($home) ?>/admin">/admin</a> and change your password.</li>
  </ol>
<?php else: ?>
  <div class="box err">✗ <?= e($error) ?></div>
  <p>Check <code>includes/config.php</code> (DB host, user, password) and that MySQL is running, then reload.</p>
<?php endif; ?>
</body>
</html>
