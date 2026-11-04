<?php $title = 'Experience'; require __DIR__ . '/layout_top.php'; ?>
<header class="page-head"><div><span class="kicker">Track record</span><h1>Experience</h1></div></header>

<div class="accordion">
  <?php foreach ($experiences as $x): ?>
    <details class="panel">
      <summary><b><?= e($x['company']) ?></b> <span class="muted small"><?= e($x['period']) ?></span></summary>
      <form method="post" action="<?= url('admin/experience/save') ?>">
        <?= csrf_field() ?>
        <input type="hidden" name="id" value="<?= e($x['id']) ?>">
        <div class="field-grid">
          <label class="field">Company<input type="text" name="company" value="<?= e($x['company']) ?>"></label>
          <label class="field">Role<input type="text" name="role" value="<?= e($x['role']) ?>"></label>
          <label class="field">Period<input type="text" name="period" value="<?= e($x['period']) ?>" placeholder="Jan 2025 - Nov 2025"></label>
          <label class="field">Sort order<input type="number" name="sort_order" value="<?= e($x['sort_order']) ?>"></label>
          <label class="field full">Description<textarea name="description" rows="3"><?= e($x['description']) ?></textarea></label>
        </div>
        <div class="form-foot"><button class="btn btn-solid">Save</button></div>
      </form>
      <form method="post" action="<?= url('admin/experience/delete/' . $x['id']) ?>" class="row-delete" onsubmit="return confirm('Delete this entry?')">
        <?= csrf_field() ?><button class="btn btn-ghost danger">Delete</button>
      </form>
    </details>
  <?php endforeach; ?>
</div>

<details class="panel add">
  <summary>+ Add experience</summary>
  <form method="post" action="<?= url('admin/experience/save') ?>">
    <?= csrf_field() ?>
    <div class="field-grid">
      <label class="field">Company<input type="text" name="company" required></label>
      <label class="field">Role<input type="text" name="role"></label>
      <label class="field">Period<input type="text" name="period" placeholder="Jan 2025 - Nov 2025"></label>
      <label class="field">Sort order<input type="number" name="sort_order" value="0"></label>
      <label class="field full">Description<textarea name="description" rows="3"></textarea></label>
    </div>
    <div class="form-foot"><button class="btn btn-solid">Add experience</button></div>
  </form>
</details>
<?php require __DIR__ . '/layout_bottom.php'; ?>
