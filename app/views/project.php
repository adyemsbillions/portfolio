<?php
/** @var array $project @var array $links */
$pageTitle = $project['title'] . ' | ' . setting('brand', 'adyems');
require __DIR__ . '/partials/head.php';
require __DIR__ . '/partials/nav.php';
?>
<main>
  <section class="section project-page">
    <a href="<?= url() ?>#work" class="link-arrow">&#8598; Back to work</a>
    <div class="terminal terminal-<?= e($project['accent']) ?> single">
      <div class="terminal-bar">
        <span class="dots"><i></i><i></i><i></i></span>
        <span class="terminal-name"><?= e($project['title']) ?></span>
        <span class="dots-r">&bull;&bull;&bull;</span>
      </div>
      <div class="terminal-body">
        <span class="signal-label">Product signal</span>
        <h1 class="signal"><?= e($project['signal_label']) ?></h1>
        <p class="signal-desc"><?= e($project['description']) ?></p>
        <div class="terminal-meta">
          <?php foreach ([1, 2, 3] as $n): if ($project["meta{$n}_label"] === '' && $project["meta{$n}_value"] === '') continue; ?>
            <div class="tm"><span><?= e($project["meta{$n}_label"]) ?></span><b><?= e($project["meta{$n}_value"]) ?></b></div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>

    <div class="project-page-body">
      <span class="project-badge"><span class="live-dot"></span><?= e($project['badge']) ?></span>
      <h2 class="section-title"><?= e(strtoupper($project['title'])) ?></h2>
      <p class="section-sub"><?= e($project['description']) ?></p>
      <div class="tags">
        <?php foreach (array_filter(array_map('trim', explode(',', $project['tags']))) as $tag): ?>
          <span class="tag"><?= e($tag) ?></span>
        <?php endforeach; ?>
      </div>
      <div class="project-links">
        <?php foreach ($links as $lk): ?>
          <a href="<?= e($lk['url']) ?>" target="_blank" rel="noopener" class="link-arrow"><?= e($lk['label']) ?> &#8599;</a>
        <?php endforeach; ?>
      </div>
    </div>
  </section>
  <?php require __DIR__ . '/partials/footer.php'; ?>
</main>
