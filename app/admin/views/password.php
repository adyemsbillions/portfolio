<?php $title = 'Password'; require __DIR__ . '/layout_top.php'; ?>
<header class="page-head"><div><span class="kicker">Security</span><h1>Change password</h1></div></header>
<form method="post" action="<?= url('admin/password') ?>" class="panel narrow">
  <?= csrf_field() ?>
  <label class="field">Current password<input type="password" name="current" required></label>
  <label class="field">New password<input type="password" name="new" required></label>
  <label class="field">Confirm new password<input type="password" name="confirm" required></label>
  <div class="form-foot"><button type="submit" class="btn btn-solid">Update password</button></div>
</form>
<?php require __DIR__ . '/layout_bottom.php'; ?>
