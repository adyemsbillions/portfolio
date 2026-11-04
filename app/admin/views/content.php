<?php $title = 'Site content'; require __DIR__ . '/layout_top.php';
/** Grouped fields: key => [label, type] (type: text|textarea) */
$groups = [
  'Brand & hero' => [
    'brand'         => ['Brand / nav name', 'text'],
    'hero_pre'      => ['Hero line (before emphasis)', 'text'],
    'hero_emphasis' => ['Hero emphasis word (italic)', 'text'],
    'hero_post'     => ['Hero line (after emphasis)', 'text'],
    'hero_sub'      => ['Hero subtitle', 'textarea'],
    'owner_name'    => ['Your name (on card)', 'text'],
    'role_title'    => ['Role badge (on card)', 'text'],
    'location'      => ['Location', 'text'],
  ],
  'Stats bar' => [
    'stat_exp_value' => ['Experience value', 'text'],
    'stat_primary'   => ['Primary focus', 'text'],
    'stat_stack'     => ['Stack summary', 'text'],
  ],
  'Section headings' => [
    'capabilities_heading' => ['Capabilities heading', 'text'],
    'capabilities_sub'     => ['Capabilities subtitle', 'textarea'],
    'work_heading'         => ['Selected work heading', 'text'],
    'repos_url'            => ['"All repositories" link', 'text'],
    'exp_heading'          => ['Experience heading', 'text'],
    'exp_sub'              => ['Experience subtitle', 'textarea'],
  ],
  'Contact & socials' => [
    'contact_pre'      => ['Contact heading (line 1)', 'text'],
    'contact_emphasis' => ['Contact emphasis (italic)', 'text'],
    'contact_sub'      => ['Contact subtitle', 'textarea'],
    'email'            => ['Email', 'text'],
    'phone'            => ['Phone', 'text'],
    'whatsapp'         => ['WhatsApp number (digits only)', 'text'],
    'github_url'       => ['GitHub URL', 'text'],
    'linkedin_url'     => ['LinkedIn URL', 'text'],
    'twitter_url'      => ['X / Twitter URL', 'text'],
    'social_handle'    => ['Social handle', 'text'],
    'footer_note'      => ['Footer note', 'text'],
  ],
];
?>
<header class="page-head">
  <div><span class="kicker">Content</span><h1>Site content</h1></div>
  <button form="contentForm" type="submit" class="btn btn-solid">Save changes</button>
</header>

<form id="contentForm" method="post" action="<?= url('admin/content') ?>" enctype="multipart/form-data">
  <?= csrf_field() ?>

  <section class="panel">
    <div class="panel-head"><h2>Logo</h2></div>
    <div class="avatar-edit">
      <div class="avatar-preview"><img src="<?= e(logo_src()) ?>" alt="logo" class="contain"></div>
      <div>
        <label class="field">Upload a logo (optional — replaces the current one)
          <input type="file" name="logo_file" accept="image/*">
        </label>
        <p class="muted small">Use a PNG or SVG with a transparent background. It shows in the nav and the admin.</p>
        <?php if (setting('logo')): ?>
          <label class="check"><input type="checkbox" name="logo_reset" value="1"> Go back to the default logo</label>
        <?php endif; ?>
      </div>
    </div>
  </section>

  <section class="panel">
    <div class="panel-head"><h2>Hero avatar / photo</h2></div>
    <div class="avatar-edit">
      <div class="avatar-preview">
        <?php if (setting('avatar')): ?>
          <img src="<?= e(img_src(setting('avatar'))) ?>" alt="avatar">
        <?php else: ?>
          <span class="muted">Built-in illustration in use</span>
        <?php endif; ?>
      </div>
      <div>
        <label class="field">Upload an image (optional — replaces the illustration)
          <input type="file" name="avatar_file" accept="image/*">
        </label>
        <p class="muted small">Leave empty to keep the current one. Use a square image for best results.</p>
        <?php if (setting('avatar')): ?>
          <label class="check"><input type="checkbox" name="avatar_reset" value="1"> Go back to the built-in illustration</label>
        <?php endif; ?>
      </div>
    </div>
  </section>

  <?php foreach ($groups as $gname => $fields): ?>
    <section class="panel">
      <div class="panel-head"><h2><?= e($gname) ?></h2></div>
      <div class="field-grid">
        <?php foreach ($fields as $key => [$label, $type]): ?>
          <label class="field <?= $type === 'textarea' ? 'full' : '' ?>">
            <?= e($label) ?>
            <?php if ($type === 'textarea'): ?>
              <textarea name="<?= e($key) ?>" rows="3"><?= e(setting($key)) ?></textarea>
            <?php else: ?>
              <input type="text" name="<?= e($key) ?>" value="<?= e(setting($key)) ?>">
            <?php endif; ?>
          </label>
        <?php endforeach; ?>
      </div>
    </section>
  <?php endforeach; ?>

  <div class="form-foot"><button type="submit" class="btn btn-solid">Save changes</button></div>
</form>
<?php require __DIR__ . '/layout_bottom.php'; ?>
