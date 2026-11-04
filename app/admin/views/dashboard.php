<?php $title = 'Dashboard'; require __DIR__ . '/layout_top.php'; ?>
<header class="page-head">
  <div>
    <span class="kicker">Overview</span>
    <h1>Hi <?= e(current_admin()['username']) ?> &#128075;</h1>
  </div>
  <a href="<?= url() ?>" target="_blank" class="btn btn-ghost">View live site &#8599;</a>
</header>

<div class="cards">
  <a href="<?= url('admin/projects') ?>" class="stat-card"><span class="n"><?= $counts['projects'] ?? 0 ?></span><span class="l">Projects</span></a>
  <a href="<?= url('admin/skills') ?>" class="stat-card"><span class="n"><?= $counts['skills'] ?? 0 ?></span><span class="l">Skills</span></a>
  <a href="<?= url('admin/experience') ?>" class="stat-card"><span class="n"><?= $counts['experiences'] ?? 0 ?></span><span class="l">Experience</span></a>
  <a href="<?= url('admin/messages') ?>" class="stat-card accent"><span class="n"><?= $counts['messages'] ?? 0 ?></span><span class="l">Messages<?php if (!empty($counts['unread'])): ?> · <?= $counts['unread'] ?> new<?php endif; ?></span></a>
</div>

<section class="panel">
  <div class="panel-head"><h2>Recent messages</h2><a href="<?= url('admin/messages') ?>" class="link">View all</a></div>
  <?php if (empty($recent)): ?>
    <p class="empty">No messages yet.</p>
  <?php else: ?>
    <ul class="msg-list">
      <?php foreach ($recent as $m): ?>
        <li>
          <div><b><?= e($m['name']) ?></b> <span class="muted"><?= e($m['email']) ?></span></div>
          <p><?= e(mb_strimwidth($m['body'], 0, 120, '…')) ?></p>
          <span class="muted date"><?= e(date('M j, Y · g:i a', strtotime($m['created_at']))) ?></span>
        </li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>
</section>

<section class="panel tips">
  <div class="panel-head"><h2>Quick start</h2></div>
  <ul class="tip-list">
    <li>Edit your name, hero text, bio and socials in <a href="<?= url('admin/content') ?>">Site content</a>.</li>
    <li>Add or update work in <a href="<?= url('admin/projects') ?>">Projects</a> — each supports any number of optional links.</li>
    <li>Change your login in <a href="<?= url('admin/password') ?>">Password</a>.</li>
  </ul>
</section>
<?php require __DIR__ . '/layout_bottom.php'; ?>
