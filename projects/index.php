<?php
require_once dirname(__DIR__) . '/includes/functions.php';

$projects = get_projects();
$categories = project_category_counts($projects);
$base = site_base();
$total = count($projects);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Browse my portfolio of Laravel, PHP, and full-stack projects.">
    <meta property="og:type" content="website">
    <meta property="og:title" content="Projects | Shahid Rasheed">
    <meta property="og:description" content="Browse my portfolio of Laravel, PHP, and full-stack projects.">
    <meta property="og:image" content="<?= e($base) ?>assets/uploads/sections/black-image.png?v=nobg">
    <title>Projects | Shahid Rasheed</title>
    <link rel="icon" href="<?= e($base) ?>favicon.ico" sizes="any">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= e($base) ?>assets/favicon-32x32.png">
    <link href="https://fonts.googleapis.com/css2?family=Henny+Penny&family=Poppins:wght@700&family=Roboto:wght@400;700&family=Saira+Stencil+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= e($base) ?>assets/frontend/css/swiper-bundle.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="<?= e($base) ?>assets/frontend/css/style.css?v=amber6">
    <link rel="canonical" href="<?= e($base) ?>projects/">
</head>
<body id="top" class="dark_theme">
<section id="preloader" class="preloader" aria-label="Loading">
    <div class="preloader__bg" aria-hidden="true">
        <span class="preloader-orb preloader-orb--1"></span>
        <span class="preloader-orb preloader-orb--2"></span>
    </div>
    <div class="preloader__content">
        <p class="preloader__brand logo">
            <span>S</span><span>hahid</span><span>R</span><span>asheed</span><span>.</span>
        </p>
        <div class="preloader__track" aria-hidden="true">
            <span class="preloader__track-fill"></span>
        </div>
        <div class="preloader__icon" aria-hidden="true">
            <i class="fas fa-code"></i>
        </div>
    </div>
</section>
<header class="header">
    <div class="container">
        <p class="h1 logo">
            <a href="<?= e($base) ?>">
                <span>S</span><span>hahid</span><span>R</span><span>asheed</span><span>.</span>
            </a>
        </p>
        <button class="nav-toggle-btn" title="Toggle Menu" data-nav-toggle-btn>
            <span class="one"></span>
            <span class="two"></span>
            <span class="three"></span>
        </button>
        <nav class="navbar" data-navbar>
            <ul class="navbar-list">
                <li><a href="<?= e($base) ?>#home" class="navbar-link">Home.</a></li>
                <li><a href="<?= e($base) ?>#about" class="navbar-link">About.</a></li>
                <li><a href="<?= e($base) ?>#services" class="navbar-link">Services.</a></li>
                <li><a href="<?= e($base) ?>#portfolio" class="navbar-link">Portfolio.</a></li>
                <li><a href="<?= e($base) ?>#feedback" class="navbar-link">Testimonial.</a></li>
                <li><a href="<?= e($base) ?>#contact" class="navbar-link">Contact.</a></li>
            </ul>
        </nav>
    </div>
</header>
<main>
<section class="project container" id="portfolio" data-active-tab="all">
  <header class="portfolio-header">
    <p class="subtitle">Portfolio</p>
    <h1 class="h3 portfolio-title"><span class="portfolio-code-word"><span class="portfolio-title-accent-projects">C</span>reate</span>. <span class="portfolio-code-word"><span class="portfolio-title-accent-projects">O</span>rganize</span>. <span class="portfolio-code-word"><span class="portfolio-title-accent-projects">D</span>evelop</span>. <span class="portfolio-code-word"><span class="portfolio-title-accent-projects">E</span>xecute</span>.</h1>
  </header>

    <div class="portfolio-tabs">
          <button type="button" class="toggle-btn active" data-portfolio-tab data-tab="all">All (<?= (int) $total ?>)</button>
          <?php foreach ($categories as $cat): ?>
          <button type="button" class="toggle-btn" data-portfolio-tab data-tab="<?= e($cat['key']) ?>"><?= e($cat['label']) ?> (<?= (int) $cat['count'] ?>)</button>
          <?php endforeach; ?>
      </div>

  <div class="project-list project-list--grid" id="project-grid">
    <?php foreach ($projects as $project): ?>
    <?php $slug = (string) ($project['slug'] ?? ''); ?>
    <div class="project-card-item col-lg-3" data-category="<?= e($project['category'] ?? 'other') ?>">
    <a href="<?= e(project_public_url($slug)) ?>" data-open-project="<?= e($slug) ?>" aria-haspopup="dialog">
      <div class="custom-card">
        <img src="<?= e(project_image_url($project['image'] ?? '')) ?>"
             alt="<?= e($project['title'] ?? '') ?>"
             loading="lazy"
             class="custom-card__img"
             width="400">
        <span class="project-card-view">View Details</span>
      </div>
    </a>
  </div>
    <?php endforeach; ?>
  </div>

  <p class="portfolio-empty portfolio-empty-filtered" hidden>No projects in this category.</p>
</section>
</main>
<footer class="footer">
    <div class="container">
        <div class="logo">
            <a href="<?= e($base) ?>">
                <span>S</span><span>hahid</span><span>R</span><span>asheed</span><span>.</span>
            </a>
        </div>
        <p class="copyright">
            © 2026 <a href="<?= e($base) ?>">Shahid Rasheed</a>. All rights reserved.
        </p>
    </div>
</footer>
<?php
$modalProjects = $projects;
require dirname(__DIR__) . '/includes/project-modals.php';
?>
<a href="mailto:shahidrasheedsmm@gmail.com?subject=Project%20Inquiry%20%E2%80%94%20Shahid%20Rasheed&amp;body=Hi%20Shahid%2C%0A%0AI%20found%20your%20portfolio%20and%20would%20like%20to%20discuss%20a%20project.%0A%0AProject%20type%3A%20%0ABudget%3A%20%0ATimeline%3A%20%0A%0AThanks!" class="email-float" title="Email Shahid" aria-label="Email Shahid">
    <i class="fas fa-envelope"></i>
</a>
<a href="https://wa.me/923062872169?text=Hi%20Shahid%2C%20I%20found%20your%20portfolio%20and%20would%20like%20to%20discuss%20a%20project." class="whatsapp-float" target="_blank" rel="noopener noreferrer" title="Chat on WhatsApp" aria-label="Chat on WhatsApp">
    <i class="fab fa-whatsapp"></i>
</a>
<a href="<?= e($base) ?>#top" class="go-top" data-go-top title="Go to Top">
    <i class="fas fa-arrow-up"></i>
</a>
<script src="<?= e($base) ?>assets/frontend/js/jquery.min.js"></script>
<script src="<?= e($base) ?>assets/frontend/js/script.js?v=amber6"></script>
</body>
</html>
