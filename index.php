<?php
require_once __DIR__ . '/includes/captcha.php';
require_once __DIR__ . '/includes/functions.php';
$captcha = mq_captcha_generate();
$featuredProjects = get_featured_projects();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta Tags -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="WG5Bsmvk86dyYyFinW3ybaoLnIxuQDHE0MGdH2VK">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Shahid Rasheed - Full-Stack Web Developer building dynamic, responsive web applications with Laravel, PHP and modern web technologies.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="./">
    <meta property="og:title" content="Shahid Rasheed | Full-Stack Web Developer">
    <meta property="og:description" content="Full-Stack Web Developer building dynamic, responsive web applications with Laravel, PHP and modern web technologies.">
    <meta property="og:image" content="assets/uploads/sections/black-image.png?v=nobg">
    <meta property="og:image:secure_url" content="assets/uploads/sections/black-image.png?v=nobg">
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="Shahid Rasheed">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Shahid Rasheed | Full-Stack Web Developer">
    <meta name="twitter:description" content="Full-Stack Web Developer building dynamic, responsive web applications with Laravel, PHP and modern web technologies.">
    <meta name="twitter:image" content="assets/uploads/sections/black-image.png?v=nobg">
    <!-- Title -->
    <title>Shahid Rasheed | Full-Stack Web Developer</title>
    <!-- Favicon -->
    <link rel="icon" href="favicon.ico" sizes="any">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="assets/favicon-96x96.png">
    <link rel="apple-touch-icon" sizes="180x180" href="assets/apple-touch-icon.png">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Henny+Penny&family=Poppins:wght@700&family=Roboto:wght@400;700&family=Saira+Stencil+One&display=swap" rel="stylesheet">
    <!-- Styles -->
    <link rel="stylesheet" href="assets/frontend/css/swiper-bundle.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="assets/frontend/css/style.css?v=amber7">
    <!-- Canonical -->
    <link rel="canonical" href="./">
        <!-- Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-H4NB3WWFEZ"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'G-H4NB3WWFEZ');
    </script>
    </head>
<body id="top" class="dark_theme">
        <div class="scroll-fx" aria-hidden="true">
        <div class="scroll-fx-orbs">
            <span class="scroll-fx-orb orb-1"></span>
            <span class="scroll-fx-orb orb-2"></span>
            <span class="scroll-fx-orb orb-3"></span>
        </div>
        <div class="scroll-progress-top"><span class="scroll-progress-fill"></span></div>
    </div>
        <!-- Preloader -->
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
    <!-- Header -->
<header class="header">
    <div class="container">
        <p class="h1 logo">
            <a href="./">
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
                <li><a href="#home" class="navbar-link" data-section="home">Home.</a></li>
                                <li><a href="#about" class="navbar-link" data-section="about">About.</a></li>
                                                <li><a href="#services" class="navbar-link" data-section="services">Services.</a></li>
                                                <li><a href="#portfolio" class="navbar-link" data-section="portfolio">Portfolio.</a></li>
                                                <li><a href="#feedback" class="navbar-link" data-section="feedback">Testimonial.</a></li>
                                                                <li><a href="#contact" class="navbar-link" data-section="contact">Contact.</a></li>
                            </ul>
        </nav>
    </div>
</header>    <main>
          
    <article class="container">
      <!-- #HERO-->
      <section class="hero reveal-section has-circuit" id="home">
        <div class="section-circuit" aria-hidden="true">
  <svg class="section-circuit-svg" viewBox="0 0 1200 800" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg">
    <g class="section-circuit-lines" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
      <path class="circuit-path" d="M 0 420 H 90 V 310 H 210 V 220 H 360 V 150 H 520"/>
      <path class="circuit-path" d="M 90 310 H 180 V 390 H 290 V 500 H 430"/>
      <path class="circuit-path" d="M 210 220 V 120 H 340 V 60 H 500"/>
      <path class="circuit-path" d="M 360 150 V 280 H 470 V 360 H 590"/>
      <path class="circuit-path" d="M 180 390 V 470 H 80"/>
      <path class="circuit-path" d="M 1200 380 H 1110 V 290 H 990 V 200 H 840 V 130 H 680"/>
      <path class="circuit-path" d="M 1110 290 H 1020 V 370 H 910 V 480 H 770"/>
      <path class="circuit-path" d="M 990 200 V 100 H 860 V 40 H 700"/>
      <path class="circuit-path" d="M 840 130 V 260 H 730 V 340 H 610"/>
      <path class="circuit-path" d="M 520 150 H 620 V 240 H 720"/>
      <path class="circuit-path" d="M 590 360 H 680 V 440 H 780 V 520"/>
    </g>
    <g class="section-circuit-nodes">
      <circle class="circuit-node circuit-node--solid" cx="90" cy="310" r="4"/>
      <circle class="circuit-node circuit-node--ring" cx="210" cy="220" r="5"/>
      <circle class="circuit-node circuit-node--solid" cx="360" cy="150" r="4"/>
      <circle class="circuit-node circuit-node--ring" cx="290" cy="500" r="5"/>
      <circle class="circuit-node circuit-node--solid" cx="430" cy="500" r="4"/>
      <circle class="circuit-node circuit-node--ring" cx="340" cy="60" r="5"/>
      <circle class="circuit-node circuit-node--solid" cx="590" cy="360" r="4"/>
      <circle class="circuit-node circuit-node--accent" cx="720" cy="240" r="5"/>
      <circle class="circuit-node circuit-node--ring" cx="780" cy="520" r="5"/>
      <circle class="circuit-node circuit-node--solid" cx="1110" cy="290" r="4"/>
      <circle class="circuit-node circuit-node--ring" cx="990" cy="200" r="5"/>
      <circle class="circuit-node circuit-node--solid" cx="840" cy="130" r="4"/>
      <circle class="circuit-node circuit-node--ring" cx="910" cy="480" r="5"/>
      <circle class="circuit-node circuit-node--accent" cx="730" cy="340" r="5"/>
    </g>
  </svg>
</div>
        <figure class="hero-banner">
          <img src="assets/uploads/sections/black-image.png?v=nobg" alt="Shahid Rasheed" class="w-100" fetchpriority="high">
        </figure>
        <a href="testimonials/" class="hero-rating-card" aria-label="Client rating 5 out of 5">
          <strong class="hero-rating-card__score">5.0</strong>
          <span class="hero-rating-card__stars" aria-hidden="true">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
          </span>
          <span class="hero-rating-card__label">Loved By Clients</span>
          <span class="hero-rating-card__year">Est. 2023</span>
        </a>
           <div class="hero-content">
                        <h1 class="h2 hero-title" data-hero-rotator>
                          <span class="hero-title-slide is-active">
                            <span class="hero-title-line"><span class="hero-code-word"><span class="hero-title-accent">C</span>reate</span>. <span class="hero-code-word"><span class="hero-title-accent">O</span>rganize</span>.</span>
                            <span class="hero-title-line"><span class="hero-code-word"><span class="hero-title-accent">D</span>evelop</span>. <span class="hero-code-word"><span class="hero-title-accent">E</span>xecute</span>.</span>
                          </span>
                          <span class="hero-title-slide">
                            <span class="hero-title-line"><span class="hero-code-word"><span class="hero-title-accent">D</span>esign</span>. <span class="hero-code-word"><span class="hero-title-accent">B</span>uild</span>.</span>
                            <span class="hero-title-line"><span class="hero-code-word"><span class="hero-title-accent">L</span>aunch</span>. <span class="hero-code-word"><span class="hero-title-accent">S</span>cale</span>.</span>
                          </span>
                          <span class="hero-title-slide">
                            <span class="hero-title-line"><span class="hero-code-word"><span class="hero-title-accent">C</span>ode</span>. <span class="hero-code-word"><span class="hero-title-accent">C</span>raft</span>.</span>
                            <span class="hero-title-line"><span class="hero-code-word"><span class="hero-title-accent">S</span>hip</span>. <span class="hero-code-word"><span class="hero-title-accent">D</span>eliver</span>.</span>
                          </span>
                        </h1>
                        <div class="hero-actions">
                          <a href="#contact" class="btn btn-primary">LET&#039;S BUILD</a>
                          <a href="assets/uploads/resume/shahid_rasheed.docx" class="btn btn-outline-primary" download="Shahid_Rasheed_Resume.docx">
                            <i class="fas fa-download"></i> Download Resume
                          </a>
                        </div>
          </div>
          <ul class="hero-social-list">
                                                <li>
                        <a href="https://www.linkedin.com/in/shahidrasheed8/" class="hero-social-link" target="_blank">
                            <i class="fab fa-linkedin"></i>
                            <div class="tooltip">LinkedIn</div>
                        </a>
                    </li>
                                    <li>
                        <a href="https://github.com/shahidrasheed8" class="hero-social-link" target="_blank">
                            <i class="fab fa-github"></i>
                            <div class="tooltip">GitHub</div>
                        </a>
                    </li>
                                    <li>
                        <a href="https://twitter.com/shahidxbhatti" class="hero-social-link" target="_blank">
                            <i class="fab fa-twitter"></i>
                            <div class="tooltip">Twitter</div>
                        </a>
                    </li>
                                      </ul>
                    <div class="hero-stats" id="stats">
            <ul class="stats-list">
                            <li>
                <a href="#" class="stats-card">
                  <div class="card-icon">
                    <img src="assets/uploads/stats/1699859475.png" loading="lazy" alt="Years of Experience">
                  </div>
                  <h2 class="h2 card-title">
                    <strong class="stat-line">
                      <span class="stat-counter-box" style="--stat-digits: 1">
                        <span class="stat-counter" data-target="3">0</span><span class="stat-suffix">+</span>
                      </span>
                      <span class="stat-name">Years of Experience</span>
                    </strong>
                  </h2>
                </a>
              </li>
                            <li>
                <a href="#" class="stats-card">
                  <div class="card-icon">
                    <img src="assets/uploads/stats/1699859505.png" loading="lazy" alt="Completed Project">
                  </div>
                  <h2 class="h2 card-title">
                    <strong class="stat-line">
                      <span class="stat-counter-box" style="--stat-digits: 2">
                        <span class="stat-counter" data-target="20">0</span><span class="stat-suffix">+</span>
                      </span>
                      <span class="stat-name">Completed Project</span>
                    </strong>
                  </h2>
                </a>
              </li>
                            <li>
                <a href="#" class="stats-card">
                  <div class="card-icon">
                    <img src="assets/uploads/stats/1699859551.png" loading="lazy" alt="Satisfied Clients">
                  </div>
                  <h2 class="h2 card-title">
                    <strong class="stat-line">
                      <span class="stat-counter-box" style="--stat-digits: 2">
                        <span class="stat-counter" data-target="10">0</span><span class="stat-suffix">+</span>
                      </span>
                      <span class="stat-name">Technologies</span>
                    </strong>
                  </h2>
                </a>
              </li>
                          </ul>
          </div>
                  </section>

      <!--- #ABOUT -->
            <section class="about reveal-section" id="about">
        <figure class="about-banner">
          <div class="background-shape">
           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200" preserveAspectRatio="none">
            <path d="M60,30 C60,100 140,0 140,60 C140,100 0,100 60,30" fill="transparent"></path>
          </svg>
        </div>
        <img src="assets/uploads/sections/black-image.png?v=nobg" loading="lazy" alt="Shahid Rasheed" class="w-100">
      </figure>
      <div class="section-content">
        <div class="text-center">
          <p class="section-subtitle">About me</p>
        </div>
        <h2 class="h3 section-title">Need a <span class="section-title-accent">Creative</span> Project?<br>I can Help You!</h2>
        <p class="section-text">
          <p style="color:#efefef">I'm Shahid Rasheed, a Laravel &amp; PHP developer who enjoys turning ideas into real, working web applications.</p>
          <p style="color:#efefef">I specialize in Laravel, PHP, and modern web technologies, building solutions that are clean on the backend and smooth on the frontend. Over the years I've worked on both personal and client projects — from CRMs and HR systems to property platforms and short-stay booking apps — and I genuinely enjoy solving problems through code.</p>
          <p style="color:#efefef">I care about writing code that's easy to maintain, not just code that works today. Every project I take on gets the same attention to detail, from planning the structure to the final deployment.</p>
          <p style="color:#efefef">When I'm not coding, I'm usually exploring new tools and techniques to keep improving how I build things.</p>
        </p>
              </div>
    </section>
    
    <!--- #SKILLS -->
            <section class="skills reveal-section" id="skills" data-active-tab="skills">
        <div class="section-content" data-skill-certificate-box>
          <div class="skills-content">
            <p class="section-subtitle">MY SKILL</p>
            <h2 class="h3 section-title">What My <span class="section-title-accent">Programming Skill</span> Set Included?</h2>
            <p class="section-text">
              I am familiar and work on a daily basis with HTML, CSS, JavaScript, Bootstrap, Blade, PHP, Laravel and other modern web technologies.
            </p>
          </div>
          <div class="certificates-content">
            <p class="section-subtitle">MY EXPERIENCE</p>
            <h2 class="h3 section-title">Where I <span class="section-title-accent">Work</span> And What I Build</h2>
            <p class="section-text">
              Full-stack delivery for clients and freelance partners — from database design to deployment, with clean, reliable code that scales.
            </p>
          </div>
          <div class="skills-toggle" data-toggle-box>
            <button type="button" class="toggle-btn active" data-toggle-btn data-tab="skills">Skills</button>
            <button type="button" class="toggle-btn" data-toggle-btn data-tab="certificates">Experience</button>
          </div>
        </div>
        <div class="skills-box" data-skills-box>
                    <div class="skills-game-bar" data-skills-game-bar>
            <p class="skills-play-hint">Arrange the icons in their original order — mini puzzle!</p>
            <p class="skills-game-progress" data-skills-progress>0 / 18 in correct position</p>
            <button type="button" class="btn btn-secondary skills-shuffle-btn" data-skills-shuffle>Shuffle Again</button>
          </div>
                    <ul class="skills-list" data-skills-sortable>
                        <li class="skill-item" style="--i: 0" data-order="0">
              <div class="tooltip">HTML5</div>
              <div class="skill-card">
                <div class="card-icon">
                  <img src="assets/uploads/skills/68aadffddf8861756028925.png" height="50" width="50" alt="HTML5">
                </div>
              </div>
            </li>
                        <li class="skill-item" style="--i: 1" data-order="1">
              <div class="tooltip">CSS3</div>
              <div class="skill-card">
                <div class="card-icon">
                  <img src="assets/uploads/skills/68aadfdf708611756028895.png" height="50" width="50" alt="CSS3">
                </div>
              </div>
            </li>
                        <li class="skill-item" style="--i: 2" data-order="2">
              <div class="tooltip">JavaScript</div>
              <div class="skill-card">
                <div class="card-icon">
                  <img src="assets/uploads/skills/68aadfac8b4401756028844.png" height="50" width="50" alt="JavaScript">
                </div>
              </div>
            </li>
                        <li class="skill-item" style="--i: 3" data-order="3">
              <div class="tooltip">Bootstrap</div>
              <div class="skill-card">
                <div class="card-icon">
                  <img src="assets/uploads/skills/68aadf9fd26211756028831.png" height="50" width="50" alt="Bootstrap">
                </div>
              </div>
            </li>
                        <li class="skill-item" style="--i: 4" data-order="4">
              <div class="tooltip">jQuery</div>
              <div class="skill-card">
                <div class="card-icon">
                  <img src="assets/uploads/skills/68aae0f2f19cf1756029170.png" height="50" width="50" alt="jQuery">
                </div>
              </div>
            </li>
                        <li class="skill-item" style="--i: 5" data-order="5">
              <div class="tooltip">PHP</div>
              <div class="skill-card">
                <div class="card-icon">
                  <img src="assets/uploads/skills/68aadeefd044d1756028655.png" height="50" width="50" alt="PHP">
                </div>
              </div>
            </li>
                        <li class="skill-item" style="--i: 6" data-order="6">
              <div class="tooltip">Laravel</div>
              <div class="skill-card">
                <div class="card-icon">
                  <img src="assets/uploads/skills/68aae04d03f291756029005.png" height="50" width="50" alt="Laravel">
                </div>
              </div>
            </li>
                        <li class="skill-item" style="--i: 7" data-order="7">
              <div class="tooltip">MySQL</div>
              <div class="skill-card">
                <div class="card-icon">
                  <img src="assets/uploads/skills/68aadf1a77b741756028698.png" height="50" width="50" alt="MySQL">
                </div>
              </div>
            </li>
                        <li class="skill-item" style="--i: 8" data-order="8">
              <div class="tooltip">AJAX</div>
              <div class="skill-card">
                <div class="card-icon">
                  <img src="assets/uploads/skills/68aae215c7a111756029461.png" height="50" width="50" alt="AJAX">
                </div>
              </div>
            </li>
                        <li class="skill-item" style="--i: 9" data-order="9">
              <div class="tooltip">Vue.js</div>
              <div class="skill-card">
                <div class="card-icon">
                  <img src="assets/uploads/skills/6a4743854064a1783055237.png" height="50" width="50" alt="Vue.js">
                </div>
              </div>
            </li>
                        <li class="skill-item" style="--i: 10" data-order="10">
              <div class="tooltip">WordPress</div>
              <div class="skill-card">
                <div class="card-icon">
                  <img src="assets/uploads/skills/68aae25ac3dbe1756029530.png" height="50" width="50" alt="WordPress">
                </div>
              </div>
            </li>
                        <li class="skill-item" style="--i: 11" data-order="11">
              <div class="tooltip">GitHub</div>
              <div class="skill-card">
                <div class="card-icon">
                  <img src="assets/uploads/skills/68aade97030c31756028567.png" height="50" width="50" alt="GitHub">
                </div>
              </div>
            </li>
                        <li class="skill-item" style="--i: 12" data-order="12">
              <div class="tooltip">CLI</div>
              <div class="skill-card">
                <div class="card-icon">
                  <img src="assets/uploads/skills/68aae26ddecbb1756029549.png" height="50" width="50" alt="CLI">
                </div>
              </div>
            </li>
                        <li class="skill-item" style="--i: 13" data-order="13">
              <div class="tooltip">AI Tool</div>
              <div class="skill-card">
                <div class="card-icon">
                  <img src="assets/uploads/skills/6a43b2de41f2f1782821598.png" height="50" width="50" alt="AI Tool">
                </div>
              </div>
            </li>
                        <li class="skill-item" style="--i: 14" data-order="14">
              <div class="tooltip">ChatGPT</div>
              <div class="skill-card">
                <div class="card-icon">
                  <img src="assets/uploads/skills/6a43b373764431782821747.png" height="50" width="50" alt="ChatGPT">
                </div>
              </div>
            </li>
                        <li class="skill-item" style="--i: 15" data-order="15">
              <div class="tooltip">Cloude</div>
              <div class="skill-card">
                <div class="card-icon">
                  <img src="assets/uploads/skills/6a43b3829de011782821762.png" height="50" width="50" alt="Cloude">
                </div>
              </div>
            </li>
                        <li class="skill-item" style="--i: 16" data-order="16">
              <div class="tooltip">Cursor AI</div>
              <div class="skill-card">
                <div class="card-icon">
                  <img src="assets/uploads/skills/6a43b3bdd51f21782821821.png" height="50" width="50" alt="Cursor AI">
                </div>
              </div>
            </li>
                        <li class="skill-item" style="--i: 17" data-order="17">
              <div class="tooltip">SEO</div>
              <div class="skill-card">
                <div class="card-icon">
                  <img src="assets/uploads/skills/6a43b4b9c0a001782822073.png" height="50" width="50" alt="SEO">
                </div>
              </div>
            </li>
                      </ul>
          <figure class="certificates-list">
            <div id="slider2" class="card__contents">
             <div class="swiper-wrapper">
                              <article class="swiper-slide">
                <div class="experience-slide">
                  <p class="experience-slide__label">Experience</p>
                  <h3 class="experience-slide__title">Backend Developer</h3>
                  <p class="experience-slide__meta">Media Junkie · Lahore · August 2025 – Present</p>
                  <p class="experience-slide__text">Leading enterprise HR and task management work, real-time chat, and biometric attendance integrations.</p>
                </div>
              </article>
                             <article class="swiper-slide">
                <div class="experience-slide">
                  <p class="experience-slide__label">Experience</p>
                  <h3 class="experience-slide__title">Laravel Developer</h3>
                  <p class="experience-slide__meta">Reownlogics · Lahore · March 2024 – August 2025</p>
                  <p class="experience-slide__text">Built Laravel 8/10/11 backends, payment gateways, real-time notifications, HRMS, CRM and fan platforms.</p>
                </div>
              </article>
                             <article class="swiper-slide">
                <div class="experience-slide">
                  <p class="experience-slide__label">Experience</p>
                  <h3 class="experience-slide__title">Junior Web Developer</h3>
                  <p class="experience-slide__meta">Finjineers · Lahore · January 2023 – March 2024</p>
                  <p class="experience-slide__text">Built responsive interfaces, Laravel backends, MySQL databases and APIs for frontend-backend communication.</p>
                </div>
              </article>
                             <article class="swiper-slide">
                <div class="experience-slide">
                  <p class="experience-slide__label">Education</p>
                  <h3 class="experience-slide__title">Associate's Degree in Computer Science</h3>
                  <p class="experience-slide__meta">University of the Punjab, Lahore · October 2018 – April 2020</p>
                  <p class="experience-slide__text">Computer Science foundation from the University of the Punjab, Lahore, Pakistan.</p>
                </div>
              </article>
                          </div>
          </div>
        </figure>
      </div>
    </section>
    
     <!--- #Services -->
            <section class="services reveal-section" id="services">
        <div class="section-content services-header">
          <p class="section-subtitle">Services</p>
          <h2 class="h3 section-title">What I <span class="section-title-accent">Offer</span></h2>
                    <p class="section-text">Frontend, backend and full-stack solutions — from database design to deployment.</p>
                  </div>
        <ul class="services-list">
                                        <li class="service-item is-featured" style="--i: 0">
            <a href="#contact"
               class="service-card">
              <div class="service-card-icon">
                <img src="assets/uploads/services/1699855916.png" loading="lazy" alt="Frontend Development">
              </div>
              <div class="service-card-body">
                <div class="service-card-head">
                                    <span class="service-badge">Popular</span>
                                    <h3 class="h4 service-card-title">Frontend Development</h3>
                </div>
                                <p class="service-card-desc">Responsive, accessible interfaces with HTML, CSS, JavaScript and Bootstrap.</p>
                              </div>
            </a>
          </li>
                              <li class="service-item is-featured" style="--i: 1">
            <a href="#contact"
               class="service-card">
              <div class="service-card-icon">
                <img src="assets/uploads/services/1699856197.png" loading="lazy" alt="Backend Development">
              </div>
              <div class="service-card-body">
                <div class="service-card-head">
                                    <span class="service-badge">Popular</span>
                                    <h3 class="h4 service-card-title">Backend Development</h3>
                </div>
                                <p class="service-card-desc">Robust PHP and Laravel APIs and apps — clean, reliable and easy to maintain.</p>
                              </div>
            </a>
          </li>
                              <li class="service-item is-featured" style="--i: 2">
            <a href="#contact"
               class="service-card">
              <div class="service-card-icon">
                <img src="assets/uploads/services/1699856792.png" loading="lazy" alt="Full-Stack Solutions">
              </div>
              <div class="service-card-body">
                <div class="service-card-head">
                                    <span class="service-badge">Popular</span>
                                    <h3 class="h4 service-card-title">Full-Stack Solutions</h3>
                </div>
                                <p class="service-card-desc">Complete apps from database design to deployment, such as HR and CRM platforms.</p>
                              </div>
            </a>
          </li>
                              <li class="service-item" style="--i: 3">
            <a href="#contact"
               class="service-card">
              <div class="service-card-icon">
                <img src="assets/uploads/services/1699856464.png" loading="lazy" alt="E-Commerce Development">
              </div>
              <div class="service-card-body">
                <div class="service-card-head">
                                    <h3 class="h4 service-card-title">E-Commerce Development</h3>
                </div>
                                <p class="service-card-desc">Online stores that are easy for customers to shop and simple for you to run.</p>
                              </div>
            </a>
          </li>
                              <li class="service-item" style="--i: 4">
            <a href="#contact"
               class="service-card">
              <div class="service-card-icon">
                <img src="assets/uploads/services/1699856815.png" loading="lazy" alt="API Integration">
              </div>
              <div class="service-card-body">
                <div class="service-card-head">
                                    <h3 class="h4 service-card-title">API Integration</h3>
                </div>
                                <p class="service-card-desc">Connect your site or app with payment gateways, CRMs, and other third party tools.</p>
                              </div>
            </a>
          </li>
                              <li class="service-item" style="--i: 5">
            <a href="#contact"
               class="service-card">
              <div class="service-card-icon">
                <img src="assets/uploads/services/68a819811299c1755847041.png" loading="lazy" alt="Security Enhancements">
              </div>
              <div class="service-card-body">
                <div class="service-card-head">
                                    <h3 class="h4 service-card-title">Security Enhancements</h3>
                </div>
                                <p class="service-card-desc">Better protection for your site with secure logins, updates, and security fixes.</p>
                              </div>
            </a>
          </li>
                  </ul>
      </section>
      
      <!--- #PROJECTS -->
            <section class="project reveal-section" id="portfolio">
          <p class="subtitle">Portfolio</p>
          <h2 class="h3 portfolio-title">Featured <span class="section-title-accent">Work</span></h2>
        <div class="project-list project-list--grid" >
    <?php foreach ($featuredProjects as $project): ?>
    <?php $slug = (string) ($project['slug'] ?? ''); ?>
    <div class="project-card-item col-lg-3">
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
        <div class="project-btn">
          <a href="projects/" class="btn btn-primary">View All Projects</a>
        </div>
      </section>
      
      <!--- #GITHUB ACTIVITY -->
      
      <!--- Testimonial -->
            <section class="testimonial-section reveal-section" id="feedback">
        <div class="section-content">
        <p class="section-subtitle">Feedback</p>
        <h2 class="h3 portfolio-title">How I <span class="section-title-accent">Work</span> With Clients</h2>
        <div class="testimonial-source-links">
<a href="https://www.linkedin.com/in/shahidrasheed8/" class="testimonial-source-link" target="_blank" rel="noopener noreferrer">
  <i class="fab fa-linkedin"></i>
  <span>LinkedIn</span>
</a>
<a href="https://github.com/shahidrasheed8" class="testimonial-source-link" target="_blank" rel="noopener noreferrer">
  <i class="fab fa-github"></i>
  <span>GitHub</span>
</a>
</div>
        </div>
        <div class="testimonial">
         <div class="card__container swiper">
          <div id="slider1" class="card__content">
            <div class="swiper-wrapper">
                            <article class="card__article swiper-slide">
                <div class="card__data">
  <div class="card__header">
    <h3 class="card__name">Why work with me</h3>
        <div class="card__rating">Communication first</div>
  </div>
  <div class="card__name">
    <p>I am a great communicator and love to invest the necessary time to understand the customer's problem very well before writing a single line of code.</p>
  </div>
</div>
              </article>
                            <article class="card__article swiper-slide">
                <div class="card__data">
  <div class="card__header">
    <h3 class="card__name">Approach</h3>
        <div class="card__rating">Full-stack delivery</div>
  </div>
  <div class="card__name">
    <p>From database design to deployment, I deliver complete web applications end to end — clean, reliable and built to scale with your business.</p>
  </div>
</div>
              </article>
                            <article class="card__article swiper-slide">
                <div class="card__data">
  <div class="card__header">
    <h3 class="card__name">Open to work</h3>
        <div class="card__rating">Freelance &amp; contract</div>
  </div>
  <div class="card__name">
    <p>Available for freelance projects. Let's build something great together — reach out via the contact form or connect on GitHub.</p>
  </div>
</div>
              </article>
                            <article class="card__article swiper-slide">
                <div class="card__data">
  <div class="card__header">
    <h3 class="card__name">Based in</h3>
        <div class="card__rating">Lahore, Pakistan</div>
  </div>
  <div class="card__name">
    <p>I help startups and companies bring their ideas to life with clean, reliable and scalable web applications using Laravel, PHP and modern web technologies.</p>
  </div>
</div>
              </article>
                          </div>
          </div>
         <div class="swiper-pagination"></div>
       </div>
     </div>
          <div class="testimonial-btn">
       <a href="#contact" class="btn btn-primary">Contact Me</a>
     </div>
        </section>
   
   <!--- #HIRE ON FIVERR -->
   
   <!--- #CONTACT -->
      <section class="contact reveal-section" id="contact">
    <div class="contact-content section-content">
      <div class="text-center">
        <p class="section-subtitle">CONTACT</p>
      </div>
      <h2 class="h3 section-title">Have a Project in Mind? Tell Me Your <span class="section-title-accent">Requirements</span></h2>
      <p class="section-text">
        <span style="color: rgb(255, 255, 255);">Need a website, web app, or custom feature? Share your goals, features, and timeline. I am available for freelance and remote projects.</span>
      </p>
      <ul class="contact-list">
        <li class="contact-list-item">
          <div class="contact-item-icon">
            <i class="fas fa-map-marker-alt"></i>
          </div>
          <div class="wrapper">
            <h3 class="h4 contact-item-title">Address:</h3>
            <address class="contact-info">
              Lahore, Pakistan
            </address>
          </div>
        </li>
                <li class="contact-list-item">
          <div class="contact-item-icon">
            <i class="fas fa-envelope"></i>
          </div>
          <div class="wrapper">
            <h3 class="h4 contact-item-title">Email:</h3>
            <a href="mailto:shahidrasheedsmm@gmail.com" class="contact-info">shahidrasheedsmm@gmail.com</a>
          </div>
        </li>
                <li class="contact-list-item">
          <div class="contact-item-icon">
            <i class="fas fa-phone-alt"></i>
          </div>
          <div class="wrapper">
            <h3 class="h4 contact-item-title">Phone:</h3>
            <a href="tel:+923062872169" class="contact-info">+92 306 287 2169</a>
          </div>
        </li>
        <li>
          <ul class="contact-social-list">
                                                <li>
                        <a href="https://www.linkedin.com/in/shahidrasheed8/" class="contact-social-link" target="_blank" rel="noopener noreferrer">
                            <div class="tooltip">LinkedIn</div>
                            <i class="fab fa-linkedin"></i>
                        </a>
                    </li>
                                    <li>
                        <a href="https://github.com/shahidrasheed8" class="contact-social-link" target="_blank" rel="noopener noreferrer">
                            <div class="tooltip">GitHub</div>
                            <i class="fab fa-github"></i>
                        </a>
                    </li>
                                    <li>
                        <a href="https://twitter.com/shahidxbhatti" class="contact-social-link" target="_blank" rel="noopener noreferrer">
                            <div class="tooltip">Twitter</div>
                            <i class="fab fa-twitter"></i>
                        </a>
                    </li>
                                      </ul>
        </li>
      </ul>

      <aside class="contact-highlight" aria-label="Contact information">
        <div class="contact-highlight-card">
          <h3 class="contact-highlight-title">Why hire me for your project?</h3>
          <ul class="contact-perks">
            <li class="contact-perk">
              <span class="contact-perk-icon" aria-hidden="true"><i class="fas fa-bolt"></i></span>
              <div>
                <strong>Communication first</strong>
                <p>I take time to understand the problem before writing a single line of code.</p>
              </div>
            </li>
            <li class="contact-perk">
              <span class="contact-perk-icon" aria-hidden="true"><i class="fas fa-laptop-code"></i></span>
              <div>
                <strong>Full-stack delivery</strong>
                <p>From database design to deployment — clean, reliable apps built to scale.</p>
              </div>
            </li>
            <li class="contact-perk">
              <span class="contact-perk-icon" aria-hidden="true"><i class="fas fa-paperclip"></i></span>
              <div>
                <strong>Open to work</strong>
                <p>Available for freelance and remote projects from Lahore, Pakistan.</p>
              </div>
            </li>
          </ul>
        </div>
      </aside>
    </div>
    <form class="submitForm contact-form" data-storeURL="contact.php" enctype="multipart/form-data">
        <div class="form-wrapper">
            <label for="name" class="form-label">Name</label>
            <div class="input-wrapper">
                <input type="text" name="name" id="name" placeholder="Your name" class="input-field" value="">
                <i class="fas fa-user"></i>
                <p></p>
            </div>
        </div>
        <div class="form-wrapper">
            <label for="email" class="form-label">Email</label>
            <div class="input-wrapper">
                <input type="email" name="email" id="email" placeholder="Your email" class="input-field" value="">
                <i class="fas fa-envelope"></i>
                <p></p>
            </div>
        </div>
        <div class="form-wrapper">
            <label for="message" class="form-label">Message</label>
            <div class="input-wrapper">
                <textarea name="message" id="message" placeholder="Tell me about your project..."
                          class="input-field"></textarea>
                <i class="fas fa-comments"></i>
                <p></p>
            </div>
        </div>
        <div class="form-wrapper">
            <label for="attachment" class="form-label">Project brief <span class="form-label-note">(PDF, Word, Text, or ZIP · max 5MB)</span></label>
            <div class="input-wrapper contact-file-wrapper">
                <input type="file" name="attachment" id="attachment" class="input-field contact-file-input" accept=".pdf,.doc,.docx,.txt,.zip,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,text/plain,application/zip,application/x-zip-compressed">
                <p></p>
            </div>
        </div>
        <div class="form-wrapper">
            <label for="captcha" class="form-label">Captcha</label>
            <div id="captcha-box" class="contact-captcha-box">
                <?php echo $captcha['html']; ?>
            </div>
            <div class="input-wrapper">
                <input type="text" name="captcha" id="captcha" maxlength="6" inputmode="numeric" pattern="[0-9]*" autocomplete="off" placeholder="Enter numbers shown above" class="input-field">
                <i class="fas fa-shield-alt"></i>
                <p></p>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">SEND</button>
    </form>
  </section>
  </article>
<script type="application/ld+json">{
    "@context": "https://schema.org",
    "@graph": [
        {
            "@type": "WebSite",
            "@id": "https://shahidrasheed.me#website",
            "url": "https://shahidrasheed.me",
            "name": "Shahid Rasheed",
            "description": "Full-Stack Web Developer building dynamic, responsive web applications with Laravel, PHP and modern web technologies.",
            "author": {
                "@id": "https://shahidrasheed.me#person"
            }
        },
        {
            "@type": "Person",
            "@id": "https://shahidrasheed.me#person",
            "name": "Shahid Rasheed",
            "url": "https://shahidrasheed.me",
            "image": "assets/uploads/sections/black-image.png?v=nobg",
            "jobTitle": "Full-Stack Web Developer",
            "description": "Full-Stack Web Developer building dynamic, responsive web applications with Laravel, PHP and modern web technologies.",
            "sameAs": [
                "https://www.linkedin.com/in/shahidrasheed8/",
                "https://github.com/shahidrasheed8",
                "https://twitter.com/shahidxbhatti"
            ],
            "email": "shahidrasheedsmm@gmail.com",
            "telephone": "+92 306 287 2169",
            "address": {
                "@type": "PostalAddress",
                "addressLocality": "Lahore",
                "addressCountry": "Pakistan"
            }
        }
    ]
}</script>
    </main>
    <!-- Footer -->
<footer class="footer">
    <div class="container">
        <div class="logo">
            <a href="./">
                <span>S</span><span>hahid</span><span>R</span><span>asheed</span><span>.</span>
            </a>
        </div>
        <p class="copyright">
                        © 2026 <a href="./">Shahid Rasheed</a>. All rights reserved.
        </p>
    </div>
</footer>

<?php
$modalProjects = $featuredProjects;
require __DIR__ . '/includes/project-modals.php';
?>

<!-- Contact floats -->
<a href="mailto:shahidrasheedsmm@gmail.com?subject=Project%20Inquiry%20%E2%80%94%20Shahid%20Rasheed&amp;body=Hi%20Shahid%2C%0A%0AI%20found%20your%20portfolio%20and%20would%20like%20to%20discuss%20a%20project.%0A%0AProject%20type%3A%20%0ABudget%3A%20%0ATimeline%3A%20%0A%0AThanks!" class="email-float" title="Email Shahid" aria-label="Email Shahid">
    <i class="fas fa-envelope"></i>
</a>
<a href="https://wa.me/923062872169?text=Hi%20Shahid%2C%20I%20found%20your%20portfolio%20and%20would%20like%20to%20discuss%20a%20project." class="whatsapp-float" target="_blank" rel="noopener noreferrer" title="Chat on WhatsApp" aria-label="Chat on WhatsApp">
    <i class="fab fa-whatsapp"></i>
</a>

<!-- Go to Top -->
<a href="#top" class="go-top" data-go-top title="Go to Top">
    <i class="fas fa-arrow-up"></i>
</a>

    <!-- Scripts -->
    <script src="assets/frontend/js/jquery.min.js"></script>
    <script src="assets/frontend/js/popper.min.js"></script>
    <script src="assets/admin/js/sweetalert2.js"></script>
    <script src="assets/frontend/js/swiper-bundle.min.js"></script>
        <script src="assets/frontend/js/Sortable.min.js"></script>
            <script src="assets/frontend/js/script.js?v=amber6"></script>
    <script src="assets/frontend/js/action.js"></script>
    <script>
document.addEventListener("DOMContentLoaded", function () {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });
    });
</script>
</body>
</html>
