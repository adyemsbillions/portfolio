<?php
$pageTitle = 'Not found | ' . setting('brand', 'adyems');
require __DIR__ . '/partials/head.php';
require __DIR__ . '/partials/nav.php';
?>
<main>
  <section class="section error-page">
    <span class="eyebrow">404</span>
    <h1 class="section-title big">This page<br>went missing.</h1>
    <p class="section-sub">The link may be broken or the page moved.</p>
    <a href="<?= url() ?>" class="btn-talk">Back home <span>&#8599;</span></a>
  </section>
</main>
<?php require __DIR__ . '/partials/footer.php'; ?>
