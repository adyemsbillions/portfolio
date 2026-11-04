<?php
/** Shared top of every admin page (except login). $active + $title expected. */
$active = $active ?? '';
$title  = $title ?? 'Admin';
$f = flash();
$unread = (int) db()->query('SELECT COUNT(*) FROM messages WHERE is_read = 0')->fetchColumn();
$nav = [
    ''           => ['Dashboard', 'grid'],
    'content'    => ['Site content', 'edit'],
    'projects'   => ['Projects', 'folder'],
    'skills'     => ['Skills', 'star'],
    'experience' => ['Experience', 'briefcase'],
    'messages'   => ['Messages', 'mail'],
    'password'   => ['Password', 'lock'],
];
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= e($title) ?> · adyems admin</title>
<link href="https://fonts.googleapis.com/css2?family=Archivo:wght@400;500;600;700;800&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?= asset('css/admin.css') ?>">
<link rel="icon" type="image/png" href="<?= asset('img/favicon.png') ?>">
</head>
<body>
<div class="admin">
  <aside class="sidebar">
    <a href="<?= url('admin') ?>" class="side-brand"><img src="<?= e(logo_src()) ?>" alt="" class="brand-logo logo-invert"><?= e(setting('brand', 'adyems')) ?><span>/ admin</span></a>
    <nav class="side-nav">
      <?php foreach ($nav as $key => [$label, $icon]): ?>
        <a href="<?= url('admin/' . $key) ?>" class="<?= $active === $key ? 'on' : '' ?>">
          <?= admin_icon($icon) ?><span><?= $label ?></span>
          <?php if ($key === 'messages' && $unread): ?><b class="badge"><?= $unread ?></b><?php endif; ?>
        </a>
      <?php endforeach; ?>
    </nav>
    <div class="side-foot">
      <a href="<?= url() ?>" target="_blank" class="side-link">View site &#8599;</a>
      <a href="<?= url('admin/logout') ?>" class="side-link">Log out</a>
    </div>
  </aside>
  <main class="content">
    <?php if ($f): ?><div class="flash flash-<?= e($f['type']) ?>"><?= e($f['msg']) ?></div><?php endif; ?>
