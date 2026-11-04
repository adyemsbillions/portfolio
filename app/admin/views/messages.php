<?php $title = 'Messages'; require __DIR__ . '/layout_top.php'; ?>
<header class="page-head"><div><span class="kicker">Inbox</span><h1>Messages</h1></div></header>

<?php if (empty($messages)): ?>
  <p class="empty">No messages yet. They'll appear here when someone uses your contact form.</p>
<?php else: ?>
  <div class="msg-grid">
    <?php foreach ($messages as $m): ?>
      <article class="msg-card <?= $m['is_read'] ? '' : 'unread' ?>">
        <div class="msg-top">
          <div>
            <b><?= e($m['name']) ?></b>
            <?php if ($m['email']): ?><a href="mailto:<?= e($m['email']) ?>" class="muted small"><?= e($m['email']) ?></a><?php endif; ?>
          </div>
          <span class="muted small"><?= e(date('M j, Y · g:i a', strtotime($m['created_at']))) ?></span>
        </div>
        <p class="msg-body"><?= nl2br(e($m['body'])) ?></p>
        <div class="msg-actions">
          <?php if ($m['email']): ?><a href="mailto:<?= e($m['email']) ?>" class="btn btn-ghost">Reply</a><?php endif; ?>
          <form method="post" action="<?= url('admin/messages/delete/' . $m['id']) ?>" onsubmit="return confirm('Delete this message?')">
            <?= csrf_field() ?><button class="btn btn-ghost danger">Delete</button>
          </form>
        </div>
      </article>
    <?php endforeach; ?>
  </div>
<?php endif; ?>
<?php require __DIR__ . '/layout_bottom.php'; ?>
