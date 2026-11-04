<?php
/** @var array $skills @var array $projects @var array $experiences */
$pageTitle = 'Home | ' . setting('brand', 'adyems');
require __DIR__ . '/partials/head.php';
require __DIR__ . '/partials/nav.php';
$f = flash();
?>

<?php if ($f): ?>
  <div class="toast toast-<?= e($f['type']) ?>" id="toast"><?= e($f['msg']) ?></div>
<?php endif; ?>

<main>
  <!-- ================= HERO ================= -->
  <section class="hero">
    <div class="hero-left">
      <h1 class="hero-title">
        <?= e(setting('hero_pre')) ?>
        <em><?= e(setting('hero_emphasis')) ?></em> <span class="spark">&#10022;</span>
        <?= e(setting('hero_post')) ?>
      </h1>
      <p class="hero-sub"><?= e(setting('hero_sub')) ?></p>
      <div class="hero-scroll"><a href="#skills" aria-label="Scroll down">&#8600;</a></div>
    </div>

    <div class="hero-card">
      <div class="hero-card-top">
        <span><?= e(setting('owner_name')) ?></span>
        <span class="mono">&copy;<?= substr(date('Y'), 2) ?></span>
      </div>
      <div class="hero-badge"><?= e(setting('role_title')) ?></div>
      <div class="hero-avatar">
        <?php if (setting('avatar')): ?>
          <img src="<?= e(img_src(setting('avatar'))) ?>" alt="<?= e(setting('owner_name')) ?>">
        <?php else: ?>
          <?php require __DIR__ . '/partials/avatar.php'; ?>
        <?php endif; ?>
      </div>
      <div class="hero-card-bottom">
        <span class="mono">&#9680; <?= e(strtoupper(setting('location'))) ?></span>
        <a href="#contact" class="mono">SAY HELLO &#8599;</a>
      </div>
    </div>
  </section>

  <!-- stats bar -->
  <section class="stats">
    <div class="stat"><span class="stat-k">Experience</span><span class="stat-v"><?= e(setting('stat_exp_value')) ?></span></div>
    <div class="stat"><span class="stat-k">Primary</span><span class="stat-v"><?= e(setting('stat_primary')) ?></span></div>
    <div class="stat"><span class="stat-k">Stack</span><span class="stat-v"><?= e(setting('stat_stack')) ?></span></div>
    <div class="stat"><span class="stat-k">Base</span><span class="stat-v"><?= e(setting('location')) ?></span></div>
  </section>

  <!-- ================= CAPABILITIES / SKILLS ================= -->
  <section class="section" id="skills">
    <div class="section-head">
      <span class="eyebrow">02 / Capabilities</span>
      <h2 class="section-title"><?= e(setting('capabilities_heading')) ?></h2>
      <p class="section-sub"><?= e(setting('capabilities_sub')) ?></p>
    </div>
    <div class="skill-grid">
      <?php foreach ($skills as $s): ?>
        <article class="skill-card">
          <div class="skill-card-top">
            <span class="skill-num"><?= e($s['num']) ?></span>
            <span class="skill-icon"><?= skill_icon($s['icon']) ?></span>
          </div>
          <span class="skill-cat"><?= e($s['category']) ?></span>
          <h3 class="skill-title"><?= e($s['title']) ?></h3>
          <ul class="skill-items">
            <?php foreach (preg_split('/\r?\n/', trim($s['items'])) as $item): if (trim($item) === '') continue; ?>
              <li><?= e($item) ?></li>
            <?php endforeach; ?>
          </ul>
        </article>
      <?php endforeach; ?>
    </div>
  </section>

  <!-- ================= SELECTED WORK ================= -->
  <section class="section" id="work">
    <div class="section-head work-head">
      <div>
        <span class="eyebrow">01 / Selected work</span>
        <h2 class="section-title big"><?= e(setting('work_heading')) ?></h2>
      </div>
      <a href="<?= e(setting('repos_url')) ?>" target="_blank" rel="noopener" class="link-arrow">All repositories &#8599;</a>
    </div>

    <div class="projects">
      <?php foreach ($projects as $i => $p): ?>
        <article class="project">
          <div class="terminal terminal-<?= e($p['accent']) ?>">
            <div class="terminal-bar">
              <span class="dots"><i></i><i></i><i></i></span>
              <span class="terminal-name"><?= e($p['title']) ?></span>
              <span class="dots-r">&bull;&bull;&bull;</span>
            </div>
            <div class="terminal-body">
              <span class="signal-label">Product signal</span>
              <h3 class="signal"><?= e($p['signal_label']) ?></h3>
              <p class="signal-desc"><?= e($p['description']) ?></p>
              <div class="terminal-meta">
                <?php foreach ([1, 2, 3] as $n): if ($p["meta{$n}_label"] === '' && $p["meta{$n}_value"] === '') continue; ?>
                  <div class="tm"><span><?= e($p["meta{$n}_label"]) ?></span><b><?= e($p["meta{$n}_value"]) ?></b></div>
                <?php endforeach; ?>
              </div>
            </div>
          </div>

          <div class="project-info">
            <div class="project-index"><?= str_pad((string)($i + 1), 2, '0', STR_PAD_LEFT) ?></div>
            <span class="project-badge"><span class="live-dot"></span><?= e($p['badge']) ?></span>
            <h3 class="project-title"><?= e(strtoupper($p['title'])) ?></h3>
            <p class="project-desc"><?= e($p['description']) ?></p>
            <div class="tags">
              <?php foreach (array_filter(array_map('trim', explode(',', $p['tags']))) as $tag): ?>
                <span class="tag"><?= e($tag) ?></span>
              <?php endforeach; ?>
            </div>
            <div class="project-links">
              <?php foreach ($p['links'] as $lk): ?>
                <a href="<?= e($lk['url']) ?>" target="_blank" rel="noopener" class="link-arrow"><?= e($lk['label']) ?> &#8599;</a>
              <?php endforeach; ?>
            </div>
          </div>
        </article>
      <?php endforeach; ?>
    </div>
  </section>

  <!-- ================= EXPERIENCE ================= -->
  <section class="section" id="experience">
    <div class="exp-panel">
      <div class="exp-left">
        <span class="eyebrow lime">03 / Experience</span>
        <h2 class="section-title inverse"><?= e(setting('exp_heading')) ?></h2>
        <p class="section-sub inverse"><?= e(setting('exp_sub')) ?></p>
        <a href="#contact" class="link-arrow lime">Work with me &#8599;</a>
      </div>
      <div class="exp-list">
        <?php foreach ($experiences as $i => $x): ?>
          <div class="exp-item">
            <span class="exp-index"><?= str_pad((string)($i + 1), 2, '0', STR_PAD_LEFT) ?></span>
            <div class="exp-body">
              <?php if ($x['period'] !== ''): ?><span class="exp-period"><?= e(strtoupper($x['period'])) ?></span><?php endif; ?>
              <h3 class="exp-company"><?= e(strtoupper($x['company'])) ?></h3>
              <span class="exp-role"><?= e(strtoupper($x['role'])) ?></span>
              <p class="exp-desc"><?= e($x['description']) ?></p>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- ================= CONTACT ================= -->
  <section class="section contact-section" id="contact">
    <div class="contact-panel">
      <div class="contact-left">
        <span class="eyebrow">04 / Start a conversation</span>
        <h2 class="contact-title"><?= e(setting('contact_pre')) ?> <em><?= e(setting('contact_emphasis')) ?></em></h2>
        <p class="contact-sub"><?= e(setting('contact_sub')) ?></p>
        <div class="contact-meta">
          <a href="mailto:<?= e(setting('email')) ?>" class="mono">&#9993; <?= e(setting('email')) ?></a>
          <a href="tel:<?= e(preg_replace('/\s+/', '', setting('phone'))) ?>" class="mono">&#9742; <?= e(setting('phone')) ?></a>
          <?php if (setting('whatsapp')): ?>
            <a href="https://wa.me/<?= e(preg_replace('/\D/', '', setting('whatsapp'))) ?>" target="_blank" rel="noopener" class="mono">&#128172; WhatsApp</a>
          <?php endif; ?>
        </div>
      </div>

      <form class="contact-form" method="post" action="<?= url('contact') ?>">
        <?= csrf_field() ?>
        <label>Your name
          <input type="text" name="name" placeholder="<?= e(setting('owner_name')) ?>" required>
        </label>
        <label>Email address
          <input type="email" name="email" placeholder="you@company.com">
        </label>
        <label>What are we building?
          <textarea name="body" rows="4" placeholder="A short note about the project..." required></textarea>
        </label>
        <button type="submit" class="btn-send">Send project note &#8599;</button>
      </form>
    </div>

    <div class="social-row">
      <span class="mono">Find me online</span>
      <div class="social-links">
        <?php if (setting('github_url')): ?><a href="<?= e(setting('github_url')) ?>" target="_blank" rel="noopener" class="mono">GitHub &#8599;</a><?php endif; ?>
        <?php if (setting('linkedin_url')): ?><a href="<?= e(setting('linkedin_url')) ?>" target="_blank" rel="noopener" class="mono">LinkedIn &#8599;</a><?php endif; ?>
        <?php if (setting('twitter_url')): ?><a href="<?= e(setting('twitter_url')) ?>" target="_blank" rel="noopener" class="mono">X / Twitter &#8599;</a><?php endif; ?>
      </div>
    </div>
  </section>

  <footer class="footer">
    <span class="mono"><?= e(setting('footer_note')) ?></span>
    <a href="#" class="mono">Back to top &#8599;</a>
  </footer>
</main>

<?php require __DIR__ . '/partials/footer.php'; ?>
