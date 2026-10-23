<?php
require_once dirname(__DIR__) . '/includes/functions.php';

$slug = strtolower(trim((string) ($_GET['slug'] ?? '')));
$project = $slug !== '' ? get_project_by_slug($slug) : null;

if (!$project) {
    http_response_code(404);
}

$base = site_base();
$title = $project ? ($project['title'] . ' | Shahid Rasheed') : 'Project not found | Shahid Rasheed';
$description = $project['description'] ?? 'Project details from Shahid Rasheed.';
$image = $project ? project_image_url($project['image'] ?? '') : ($base . 'assets/uploads/sections/black-image.png?v=nobg');
$detail = $project ? project_detail_fields($project) : null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= e($description) ?>">
    <title><?= e($title) ?></title>
    <link rel="icon" href="<?= e($base) ?>favicon.ico" sizes="any">
    <link href="https://fonts.googleapis.com/css2?family=Henny+Penny&family=Poppins:wght@700&family=Roboto:wght@400;700&family=Saira+Stencil+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= e($base) ?>assets/frontend/css/swiper-bundle.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="<?= e($base) ?>assets/frontend/css/style.css?v=amber6">
</head>
<body id="top" class="dark_theme">
<header class="header">
    <div class="container">
        <p class="h1 logo">
            <a href="<?= e($base) ?>">
                <span>S</span><span>hahid</span><span>R</span><span>asheed</span><span>.</span>
            </a>
        </p>
        <button class="nav-toggle-btn" title="Toggle Menu" data-nav-toggle-btn>
            <span class="one"></span><span class="two"></span><span class="three"></span>
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
<article class="container">
  <section class="project-detail" id="project-detail">
    <?php if (!$detail): ?>
    <header class="project-meta-card">
      <div class="project-meta-card__inner">
        <h1 class="h3 section-title">Project not found</h1>
        <p class="section-text" style="margin-top:16px;">This project is no longer available.</p>
      </div>
    </header>
    <?php else: ?>
    <div class="pd-page">
      <header class="pd-page__header">
        <?php if (!empty($detail['category_label'])): ?>
        <span class="project-category-badge"><?= e($detail['category_label']) ?></span>
        <?php endif; ?>
        <h1 class="pd-page__title"><?= e($detail['title']) ?></h1>
      </header>
      <div class="pd-page__body">
        <?php require dirname(__DIR__) . '/includes/project-detail-body.php'; ?>
      </div>
    </div>
    <?php endif; ?>
    <div class="project-back">
      <a href="<?= e($base) ?>projects/" class="btn btn-outline-primary"><i class="fas fa-arrow-left mr-1"></i> Back to Projects</a>
    </div>
  </section>
</article>
</main>
<footer class="footer">
    <div class="container">
        <div class="logo">
            <a href="<?= e($base) ?>"><span>S</span><span>hahid</span><span>R</span><span>asheed</span><span>.</span></a>
        </div>
        <p class="copyright">© 2026 <a href="<?= e($base) ?>">Shahid Rasheed</a>. All rights reserved.</p>
    </div>
</footer>
<a href="mailto:shahidrasheedsmm@gmail.com?subject=Project%20Inquiry%20%E2%80%94%20Shahid%20Rasheed&amp;body=Hi%20Shahid%2C%0A%0AI%20found%20your%20portfolio%20and%20would%20like%20to%20discuss%20a%20project.%0A%0AProject%20type%3A%20%0ABudget%3A%20%0ATimeline%3A%20%0A%0AThanks!" class="email-float" title="Email Shahid" aria-label="Email Shahid">
    <i class="fas fa-envelope"></i>
</a>
<a href="https://wa.me/923062872169?text=Hi%20Shahid%2C%20I%20found%20your%20portfolio%20and%20would%20like%20to%20discuss%20a%20project." class="whatsapp-float" target="_blank" rel="noopener noreferrer" title="Chat on WhatsApp" aria-label="Chat on WhatsApp">
    <i class="fab fa-whatsapp"></i>
</a>
<script src="<?= e($base) ?>assets/frontend/js/jquery.min.js"></script>
<script src="<?= e($base) ?>assets/frontend/js/script.js?v=amber6"></script>
</body>
</html>
