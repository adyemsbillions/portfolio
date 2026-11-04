<?php $title = $project ? 'Edit project' : 'New project'; require __DIR__ . '/layout_top.php';
$p = $project ?? [];
$v = fn($k, $d = '') => e($p[$k] ?? $d);
?>
<header class="page-head">
  <div><span class="kicker">Work</span><h1><?= $project ? 'Edit project' : 'New project' ?></h1></div>
  <a href="<?= url('admin/projects') ?>" class="btn btn-ghost">&#8598; Back</a>
</header>

<form method="post" action="<?= url('admin/projects/save') ?>" enctype="multipart/form-data">
  <?= csrf_field() ?>
  <input type="hidden" name="id" value="<?= e($p['id'] ?? '') ?>">

  <section class="panel">
    <div class="panel-head"><h2>Basics</h2></div>
    <div class="field-grid">
      <label class="field">Title<input type="text" name="title" value="<?= $v('title') ?>" required></label>
      <label class="field">Slug (URL — leave blank to auto-generate)<input type="text" name="slug" value="<?= $v('slug') ?>" placeholder="my-project"></label>
      <label class="field">Badge (e.g. LIVE PRODUCT)<input type="text" name="badge" value="<?= $v('badge') ?>"></label>
      <label class="field">Sort order<input type="number" name="sort_order" value="<?= $v('sort_order', '0') ?>"></label>
      <label class="field full">Description<textarea name="description" rows="3"><?= $v('description') ?></textarea></label>
      <label class="field full">Tags (comma separated)<input type="text" name="tags" value="<?= $v('tags') ?>" placeholder="PHP, Laravel, MySQL"></label>
    </div>
  </section>

  <section class="panel">
    <div class="panel-head"><h2>Terminal card</h2></div>
    <div class="field-grid">
      <label class="field">Signal label<input type="text" name="signal_label" value="<?= $v('signal_label') ?>" placeholder="AUTH: DASHBOARD ONLINE"></label>
      <label class="field">Card colour
        <select name="accent">
          <option value="dark" <?= ($p['accent'] ?? 'dark')==='dark'?'selected':'' ?>>Dark</option>
          <option value="purple" <?= ($p['accent'] ?? '')==='purple'?'selected':'' ?>>Purple</option>
        </select>
      </label>
      <label class="field">Meta 1 label<input type="text" name="meta1_label" value="<?= $v('meta1_label') ?>"></label>
      <label class="field">Meta 1 value<input type="text" name="meta1_value" value="<?= $v('meta1_value') ?>"></label>
      <label class="field">Meta 2 label<input type="text" name="meta2_label" value="<?= $v('meta2_label') ?>"></label>
      <label class="field">Meta 2 value<input type="text" name="meta2_value" value="<?= $v('meta2_value') ?>"></label>
      <label class="field">Meta 3 label<input type="text" name="meta3_label" value="<?= $v('meta3_label') ?>"></label>
      <label class="field">Meta 3 value<input type="text" name="meta3_value" value="<?= $v('meta3_value') ?>"></label>
    </div>
  </section>

  <section class="panel">
    <div class="panel-head"><h2>Links <span class="muted small">— optional, add as many as you like</span></h2></div>
    <div id="links">
      <?php $rows = $links ?: [['label' => '', 'url' => '']]; foreach ($rows as $lk): ?>
        <div class="link-row">
          <input type="text" name="link_label[]" placeholder="Label (e.g. Open project)" value="<?= e($lk['label']) ?>">
          <input type="text" name="link_url[]" placeholder="https://..." value="<?= e($lk['url']) ?>">
          <button type="button" class="icon-btn danger" onclick="this.closest('.link-row').remove()">&times;</button>
        </div>
      <?php endforeach; ?>
    </div>
    <button type="button" class="btn btn-ghost" onclick="addLink()">+ Add link</button>
  </section>

  <section class="panel">
    <div class="panel-head"><h2>Thumbnail (optional)</h2></div>
    <?php if (!empty($p['image'])): ?><div class="avatar-preview small"><img src="<?= e(img_src($p['image'])) ?>" alt=""></div><?php endif; ?>
    <input type="hidden" name="image" value="<?= $v('image') ?>">
    <label class="field">Upload image<input type="file" name="image_file" accept="image/*"></label>
  </section>

  <div class="form-foot">
    <button type="submit" class="btn btn-solid">Save project</button>
    <a href="<?= url('admin/projects') ?>" class="btn btn-ghost">Cancel</a>
  </div>
</form>

<template id="linkTpl">
  <div class="link-row">
    <input type="text" name="link_label[]" placeholder="Label (e.g. Open project)">
    <input type="text" name="link_url[]" placeholder="https://...">
    <button type="button" class="icon-btn danger" onclick="this.closest('.link-row').remove()">&times;</button>
  </div>
</template>
<script>
function addLink(){
  var t=document.getElementById('linkTpl');
  document.getElementById('links').appendChild(t.content.cloneNode(true));
}
</script>
<?php require __DIR__ . '/layout_bottom.php'; ?>
