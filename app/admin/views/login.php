<?php $f = flash(); ?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Log in · adyems admin</title>
<link href="https://fonts.googleapis.com/css2?family=Archivo:wght@400;600;700;800&family=Space+Mono&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?= asset('css/admin.css') ?>">
<link rel="icon" type="image/png" href="<?= asset('img/favicon.png') ?>">
</head>
<body class="login-body">
  <form class="login-card" method="post" action="<?= url('admin/login') ?>">
    <?= csrf_field() ?>
    <div class="login-brand"><img src="<?= e(logo_src()) ?>" alt="" class="brand-logo"><?= e(setting('brand', 'adyems')) ?> <span>/ admin</span></div>
    <h1>Welcome back.</h1>
    <?php if ($f): ?><div class="flash flash-<?= e($f['type']) ?>"><?= e($f['msg']) ?></div><?php endif; ?>
    <label>Username<input type="text" name="username" autofocus required></label>
    <label>Password<input type="password" name="password" required></label>
    <button type="submit">Log in &#8599;</button>
    <a href="<?= url() ?>" class="back">&#8598; Back to site</a>
  </form>
</body>
</html>
