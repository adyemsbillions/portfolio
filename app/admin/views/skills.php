<?php $title = 'Skills'; require __DIR__ . '/layout_top.php';
$icons = ['server','monitor','database','layout','tool','layers'];
?>
<header class="page-head"><div><span class="kicker">Capabilities</span><h1>Skills</h1></div></header>

<div class="accordion">
  <?php foreach ($skills as $s): ?>
    <details class="panel">
      <summary><b><?= e($s['num']) ?></b> <?= e($s['title']) ?> <span class="muted small"><?= e($s['category']) ?></span></summary>
      <form method="post" action="<?= url('admin/skills/save') ?>">
        <?= csrf_field() ?>
        <input type="hidden" name="id" value="<?= e($s['id']) ?>">
        <div class="field-grid">
          <label class="field">Number<input type="text" name="num" value="<?= e($s['num']) ?>"></label>
          <label class="field">Title<input type="text" name="title" value="<?= e($s['title']) ?>"></label>
          <label class="field">Category<input type="text" name="category" value="<?= e($s['category']) ?>"></label>
          <label class="field">Icon
            <select name="icon"><?php foreach ($icons as $ic): ?><option <?= $s['icon']===$ic?'selected':'' ?>><?= $ic ?></option><?php endforeach; ?></select>
          </label>
          <label class="field">Sort order<input type="number" name="sort_order" value="<?= e($s['sort_order']) ?>"></label>
          <label class="field full">Items (one per line)<textarea name="items" rows="3"><?= e($s['items']) ?></textarea></label>
        </div>
        <div class="form-foot">
          <button class="btn btn-solid">Save</button>
        </div>
      </form>
      <form method="post" action="<?= url('admin/skills/delete/' . $s['id']) ?>" class="row-delete" onsubmit="return confirm('Delete this skill?')">
        <?= csrf_field() ?><button class="btn btn-ghost danger">Delete</button>
      </form>
    </details>
  <?php endforeach; ?>
</div>

<details class="panel add">
  <summary>+ Add a skill</summary>
  <form method="post" action="<?= url('admin/skills/save') ?>">
    <?= csrf_field() ?>
    <div class="field-grid">
      <label class="field">Number<input type="text" name="num" placeholder="06"></label>
      <label class="field">Title<input type="text" name="title" required></label>
      <label class="field">Category<input type="text" name="category"></label>
      <label class="field">Icon
        <select name="icon"><?php foreach ($icons as $ic): ?><option><?= $ic ?></option><?php endforeach; ?></select>
      </label>
      <label class="field">Sort order<input type="number" name="sort_order" value="0"></label>
      <label class="field full">Items (one per line)<textarea name="items" rows="3"></textarea></label>
    </div>
    <div class="form-foot"><button class="btn btn-solid">Add skill</button></div>
  </form>
</details>
<?php require __DIR__ . '/layout_bottom.php'; ?>
