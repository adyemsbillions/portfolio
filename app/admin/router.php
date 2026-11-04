<?php
/**
 * Admin router. Included from index.php when the path starts with /admin.
 * $seg and $method are available from the front controller.
 */

function admin_view(string $name, array $data = []): void
{
    global $seg;
    extract($data);
    $active = $seg[1] ?? '';
    require __DIR__ . '/views/' . $name . '.php';
}

$action = $seg[1] ?? '';

/* ---------- Login / logout (no auth required) ---------- */
if ($action === 'login') {
    if ($method === 'POST') {
        verify_csrf();
        if (attempt_login(trim($_POST['username'] ?? ''), $_POST['password'] ?? '')) {
            redirect('admin');
        }
        flash('Wrong username or password.', 'error');
        redirect('admin/login');
    }
    if (is_logged_in()) redirect('admin');
    admin_view('login');
    return;
}

if ($action === 'logout') {
    logout();
    redirect('admin/login');
}

/* ---------- Everything below requires login ---------- */
require_login();

switch ($action) {

    /* ===== Dashboard ===== */
    case '':
        $counts = [
            'projects'    => (int) db()->query('SELECT COUNT(*) FROM projects')->fetchColumn(),
            'skills'      => (int) db()->query('SELECT COUNT(*) FROM skills')->fetchColumn(),
            'experiences' => (int) db()->query('SELECT COUNT(*) FROM experiences')->fetchColumn(),
            'messages'    => (int) db()->query('SELECT COUNT(*) FROM messages')->fetchColumn(),
            'unread'      => (int) db()->query('SELECT COUNT(*) FROM messages WHERE is_read = 0')->fetchColumn(),
        ];
        $recent = db()->query('SELECT * FROM messages ORDER BY created_at DESC LIMIT 5')->fetchAll();
        admin_view('dashboard', compact('counts', 'recent'));
        break;

    /* ===== Site content (settings) ===== */
    case 'content':
        if ($method === 'POST') {
            verify_csrf();
            foreach ($_POST as $k => $v) {
                if (in_array($k, ['csrf', 'avatar_reset', 'logo_reset'], true)) continue;
                set_setting($k, is_array($v) ? implode(',', $v) : trim($v));
            }
            // Images: a ticked "reset" goes back to the built-in default, otherwise keep or replace.
            foreach (['avatar', 'logo'] as $img) {
                $value = !empty($_POST[$img . '_reset']) ? '' : handle_upload($img . '_file', setting($img));
                set_setting($img, (string) $value);
            }
            flash('Content saved.');
            redirect('admin/content');
        }
        admin_view('content');
        break;

    /* ===== Change password ===== */
    case 'password':
        if ($method === 'POST') {
            verify_csrf();
            $cur = $_POST['current'] ?? ''; $new = $_POST['new'] ?? ''; $conf = $_POST['confirm'] ?? '';
            $admin = db()->prepare('SELECT * FROM admins WHERE id = ?');
            $admin->execute([current_admin()['id']]);
            $row = $admin->fetch();
            if (!password_verify($cur, $row['password_hash'])) {
                flash('Current password is incorrect.', 'error');
            } elseif (strlen($new) < 6) {
                flash('New password must be at least 6 characters.', 'error');
            } elseif ($new !== $conf) {
                flash('New passwords do not match.', 'error');
            } else {
                db()->prepare('UPDATE admins SET password_hash = ? WHERE id = ?')
                    ->execute([password_hash($new, PASSWORD_DEFAULT), $row['id']]);
                flash('Password updated.');
            }
            redirect('admin/password');
        }
        admin_view('password');
        break;

    /* ===== Projects ===== */
    case 'projects':
        $sub = $seg[2] ?? '';
        if ($sub === 'save' && $method === 'POST') {
            verify_csrf();
            save_project();
            flash('Project saved.');
            redirect('admin/projects');
        }
        if ($sub === 'delete' && isset($seg[3]) && $method === 'POST') {
            verify_csrf();
            db()->prepare('DELETE FROM projects WHERE id = ?')->execute([(int)$seg[3]]);
            flash('Project deleted.');
            redirect('admin/projects');
        }
        if ($sub === 'new') {
            admin_view('project_form', ['project' => null, 'links' => []]);
            break;
        }
        if ($sub === 'edit' && isset($seg[3])) {
            $st = db()->prepare('SELECT * FROM projects WHERE id = ?');
            $st->execute([(int)$seg[3]]);
            $project = $st->fetch();
            if (!$project) redirect('admin/projects');
            $lk = db()->prepare('SELECT * FROM project_links WHERE project_id = ? ORDER BY sort_order');
            $lk->execute([$project['id']]);
            admin_view('project_form', ['project' => $project, 'links' => $lk->fetchAll()]);
            break;
        }
        $projects = db()->query('SELECT * FROM projects ORDER BY sort_order, id')->fetchAll();
        admin_view('projects', compact('projects'));
        break;

    /* ===== Skills ===== */
    case 'skills':
        $sub = $seg[2] ?? '';
        if ($sub === 'save' && $method === 'POST') {
            verify_csrf();
            $id = (int)($_POST['id'] ?? 0);
            $fields = [trim($_POST['num'] ?? ''), trim($_POST['title'] ?? ''), trim($_POST['category'] ?? ''),
                       trim($_POST['items'] ?? ''), trim($_POST['icon'] ?? 'layers'), (int)($_POST['sort_order'] ?? 0)];
            if ($id) {
                $fields[] = $id;
                db()->prepare('UPDATE skills SET num=?,title=?,category=?,items=?,icon=?,sort_order=? WHERE id=?')->execute($fields);
            } else {
                db()->prepare('INSERT INTO skills (num,title,category,items,icon,sort_order) VALUES (?,?,?,?,?,?)')->execute($fields);
            }
            flash('Skill saved.');
            redirect('admin/skills');
        }
        if ($sub === 'delete' && isset($seg[3]) && $method === 'POST') {
            verify_csrf();
            db()->prepare('DELETE FROM skills WHERE id = ?')->execute([(int)$seg[3]]);
            flash('Skill deleted.');
            redirect('admin/skills');
        }
        $skills = db()->query('SELECT * FROM skills ORDER BY sort_order, id')->fetchAll();
        admin_view('skills', compact('skills'));
        break;

    /* ===== Experience ===== */
    case 'experience':
        $sub = $seg[2] ?? '';
        if ($sub === 'save' && $method === 'POST') {
            verify_csrf();
            $id = (int)($_POST['id'] ?? 0);
            $fields = [trim($_POST['company'] ?? ''), trim($_POST['role'] ?? ''), trim($_POST['period'] ?? ''),
                       trim($_POST['description'] ?? ''), (int)($_POST['sort_order'] ?? 0)];
            if ($id) {
                $fields[] = $id;
                db()->prepare('UPDATE experiences SET company=?,role=?,period=?,description=?,sort_order=? WHERE id=?')->execute($fields);
            } else {
                db()->prepare('INSERT INTO experiences (company,role,period,description,sort_order) VALUES (?,?,?,?,?)')->execute($fields);
            }
            flash('Experience saved.');
            redirect('admin/experience');
        }
        if ($sub === 'delete' && isset($seg[3]) && $method === 'POST') {
            verify_csrf();
            db()->prepare('DELETE FROM experiences WHERE id = ?')->execute([(int)$seg[3]]);
            flash('Experience deleted.');
            redirect('admin/experience');
        }
        $experiences = db()->query('SELECT * FROM experiences ORDER BY sort_order, id')->fetchAll();
        admin_view('experience', compact('experiences'));
        break;

    /* ===== Messages ===== */
    case 'messages':
        $sub = $seg[2] ?? '';
        if ($sub === 'read' && isset($seg[3])) {
            db()->prepare('UPDATE messages SET is_read = 1 WHERE id = ?')->execute([(int)$seg[3]]);
            redirect('admin/messages');
        }
        if ($sub === 'delete' && isset($seg[3]) && $method === 'POST') {
            verify_csrf();
            db()->prepare('DELETE FROM messages WHERE id = ?')->execute([(int)$seg[3]]);
            flash('Message deleted.');
            redirect('admin/messages');
        }
        $messages = db()->query('SELECT * FROM messages ORDER BY created_at DESC')->fetchAll();
        // mark all as read on view
        db()->query('UPDATE messages SET is_read = 1 WHERE is_read = 0');
        admin_view('messages', compact('messages'));
        break;

    default:
        http_response_code(404);
        admin_view('dashboard', ['counts' => [], 'recent' => []]);
}

/* ---------- helper: save a project + its links ---------- */
function save_project(): void
{
    $id    = (int)($_POST['id'] ?? 0);
    $title = trim($_POST['title'] ?? 'Untitled');
    $slug  = trim($_POST['slug'] ?? '');
    $slug  = $slug !== '' ? slugify($slug) : slugify($title);

    // ensure slug is unique
    $check = db()->prepare('SELECT id FROM projects WHERE slug = ? AND id <> ?');
    $check->execute([$slug, $id]);
    if ($check->fetch()) $slug .= '-' . substr(md5(uniqid()), 0, 4);

    $image = handle_upload('image_file', $_POST['image'] ?? '');

    $data = [
        $title, $slug, trim($_POST['badge'] ?? ''), trim($_POST['signal_label'] ?? ''),
        trim($_POST['description'] ?? ''), trim($_POST['tags'] ?? ''),
        trim($_POST['meta1_label'] ?? ''), trim($_POST['meta1_value'] ?? ''),
        trim($_POST['meta2_label'] ?? ''), trim($_POST['meta2_value'] ?? ''),
        trim($_POST['meta3_label'] ?? ''), trim($_POST['meta3_value'] ?? ''),
        in_array($_POST['accent'] ?? 'dark', ['dark', 'purple']) ? $_POST['accent'] : 'dark',
        $image ?? '', (int)($_POST['sort_order'] ?? 0),
    ];

    if ($id) {
        $data[] = $id;
        db()->prepare('UPDATE projects SET title=?,slug=?,badge=?,signal_label=?,description=?,tags=?,
            meta1_label=?,meta1_value=?,meta2_label=?,meta2_value=?,meta3_label=?,meta3_value=?,accent=?,image=?,sort_order=? WHERE id=?')
            ->execute($data);
        $pid = $id;
    } else {
        db()->prepare('INSERT INTO projects (title,slug,badge,signal_label,description,tags,
            meta1_label,meta1_value,meta2_label,meta2_value,meta3_label,meta3_value,accent,image,sort_order)
            VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)')->execute($data);
        $pid = (int) db()->lastInsertId();
    }

    // rebuild links from the repeated fields
    db()->prepare('DELETE FROM project_links WHERE project_id = ?')->execute([$pid]);
    $labels = $_POST['link_label'] ?? [];
    $urls   = $_POST['link_url'] ?? [];
    $ins = db()->prepare('INSERT INTO project_links (project_id, label, url, sort_order) VALUES (?,?,?,?)');
    $order = 0;
    foreach ($labels as $i => $label) {
        $label = trim($label);
        $u = trim($urls[$i] ?? '');
        if ($label !== '' && $u !== '') {
            $ins->execute([$pid, $label, $u, $order++]);
        }
    }
}
