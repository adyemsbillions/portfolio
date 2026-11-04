<?php $title = 'Projects'; require __DIR__ . '/layout_top.php'; ?>
<header class="page-head">
  <div><span class="kicker">Work</span><h1>Projects</h1></div>
  <a href="<?= url('admin/projects/new') ?>" class="btn btn-solid">+ New project</a>
</header>

<?php if (empty($projects)): ?>
  <p class="empty">No projects yet. <a href="<?= url('admin/projects/new') ?>">Add your first one.</a></p>
<?php else: ?>
<div class="table">
  <div class="tr th"><span>#</span><span>Title</span><span>Badge</span><span>Tags</span><span class="right">Actions</span></div>
  <?php foreach ($projects as $i => $p): ?>
    <div class="tr">
      <span class="muted"><?= str_pad((string)($i+1),2,'0',STR_PAD_LEFT) ?></span>
      <span><b><?= e($p['title']) ?></b><br><span class="muted small">/project/<?= e($p['slug']) ?></span></span>
      <span><?= e($p['badge']) ?></span>
      <span class="muted small"><?= e($p['tags']) ?></span>
      <span class="right actions">
        <a href="<?= url('project/' . $p['slug']) ?>" target="_blank" class="icon-btn" title="View">&#8599;</a>
        <a href="<?= url('admin/projects/edit/' . $p['id']) ?>" class="icon-btn" title="Edit">Edit</a>
        <form method="post" action="<?= url('admin/projects/delete/' . $p['id']) ?>" onsubmit="return confirm('Delete this project?')">
          <?= csrf_field() ?>
          <button class="icon-btn danger" title="Delete">Delete</button>
        </form>
      </span>
    </div>
  <?php endforeach; ?>
</div>
<?php endif; ?>
<?php require __DIR__ . '/layout_bottom.php'; ?>
