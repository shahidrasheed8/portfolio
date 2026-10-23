$(function () {
  var preloaderHidden = false;
  var preloaderStart = Date.now();
  var PRELOADER_MIN_MS = 500;
  var PRELOADER_MAX_MS = 3500;

  function hidePreloader() {
    if (preloaderHidden) {
      return;
    }

    var wait = Math.max(0, PRELOADER_MIN_MS - (Date.now() - preloaderStart));

    setTimeout(function () {
      if (preloaderHidden) {
        return;
      }

      preloaderHidden = true;
      $("#preloader").fadeOut("slow", function () {
        $(this).remove();
      });
    }, wait);
  }

  hidePreloader();
  $(window).on("load", hidePreloader);
  setTimeout(hidePreloader, PRELOADER_MAX_MS);
});

function elemToggleFunc(elem) {
  elem.classList.toggle("active");
}

/**
 * header sticky & go to top
 */
var header = document.querySelector(".header");
var goTopBtn = document.querySelector("[data-go-top]");

if (header) {
  window.addEventListener("scroll", function () {
    if (window.scrollY >= 10) {
      header.classList.add("active");
      if (goTopBtn) {
        goTopBtn.classList.add("active");
      }
    } else {
      header.classList.remove("active");
      if (goTopBtn) {
        goTopBtn.classList.remove("active");
      }
    }

    updateScrollFx();
  });
}

function updateScrollFx() {
  var fx = document.querySelector(".scroll-fx");
  if (!fx || !fx._sections) {
    return;
  }

  var fill = fx.querySelector(".scroll-progress-fill");
  var navSections = fx._navSections || [];

  var scrollTop = window.scrollY;
  var docHeight = document.documentElement.scrollHeight - window.innerHeight;
  var progress = docHeight > 0 ? Math.min(scrollTop / docHeight, 1) : 0;

  if (fill) {
    fill.style.width = progress * 100 + "%";
  }

  document.documentElement.style.setProperty("--scroll-progress", progress);
  document.documentElement.style.setProperty("--scroll-y", scrollTop + "px");

  var markerLine = scrollTop + window.innerHeight * 0.42;
  var activeId = navSections.length ? navSections[0].id : null;

  navSections.forEach(function (item) {
    if (item.section.offsetTop <= markerLine) {
      activeId = item.id;
    }
  });

  navSections.forEach(function (item) {
    item.link.classList.toggle("is-active", item.id === activeId);
  });
}

function initScrollFx() {
  var fx = document.querySelector(".scroll-fx");
  if (!fx) {
    return;
  }

  var sections = Array.from(document.querySelectorAll("main section[id]"));

  if (!sections.length) {
    return;
  }

  fx._sections = sections;
  fx._navSections = Array.from(document.querySelectorAll(".navbar-link[data-section]"))
    .map(function (link) {
      return {
        id: link.dataset.section,
        section: document.getElementById(link.dataset.section),
        link: link,
      };
    })
    .filter(function (item) {
      return item.section;
    });

  updateScrollFx();
  window.addEventListener("resize", updateScrollFx);
}

/**
 * scroll reveal, circuit bg & skill section animation
 */
function initCircuitObserver() {
  var sections = document.querySelectorAll(".has-circuit");

  if (!sections.length) {
    return;
  }

  if (!("IntersectionObserver" in window)) {
    sections.forEach(function (section) {
      section.classList.add("is-circuit-visible");
    });
    return;
  }

  var circuitObserver = new IntersectionObserver(
    function (entries) {
      entries.forEach(function (entry) {
        entry.target.classList.toggle("is-circuit-visible", entry.isIntersecting);
      });
    },
    { threshold: 0.2, rootMargin: "0px 0px -50px 0px" }
  );

  sections.forEach(function (section) {
    circuitObserver.observe(section);
  });
}

function initStatCounters() {
  var counters = document.querySelectorAll(".stat-counter");

  if (!counters.length) {
    return;
  }

  var reducedMotion = window.matchMedia("(prefers-reduced-motion: reduce)").matches;

  function runCounter(el, delay) {
    var target = parseInt(el.dataset.target, 10) || 0;

    if (reducedMotion || el.dataset.animated === "true") {
      el.textContent = target;
      el.dataset.animated = "true";
      return;
    }

    setTimeout(function () {
      if (el.dataset.animated === "true") {
        return;
      }

      el.dataset.animated = "true";

      var duration = 1800;
      var startTime = null;

      function step(timestamp) {
        if (!startTime) {
          startTime = timestamp;
        }

        var progress = Math.min((timestamp - startTime) / duration, 1);
        var eased = 1 - Math.pow(1 - progress, 3);

        el.textContent = Math.floor(eased * target);

        if (progress < 1) {
          requestAnimationFrame(step);
        } else {
          el.textContent = target;
        }
      }

      requestAnimationFrame(step);
    }, delay || 0);
  }

  function startCounters() {
    counters.forEach(function (el, index) {
      runCounter(el, index * 120);
    });
  }

  var statsBlock = document.querySelector(".hero-stats");

  if (!statsBlock || !("IntersectionObserver" in window)) {
    startCounters();
    return;
  }

  var counterObserver = new IntersectionObserver(
    function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          startCounters();
          counterObserver.unobserve(entry.target);
        }
      });
    },
    { threshold: 0.25 }
  );

  counterObserver.observe(statsBlock);
}

/**
 * Soft shimmer placeholder until images finish loading (about + project cards)
 */
function initImagePlaceholders() {
  function markLoaded(img) {
    var frame = img.closest(".about-banner, .custom-card");
    if (frame) {
      frame.classList.add("is-img-loaded");
    }
  }

  document.querySelectorAll(".about-banner img, .custom-card__img").forEach(function (img) {
    if (img.complete && img.naturalWidth > 0) {
      markLoaded(img);
      return;
    }

    img.addEventListener("load", function () {
      markLoaded(img);
    }, { once: true });

    img.addEventListener("error", function () {
      markLoaded(img);
    }, { once: true });
  });
}

/**
 * project card hover scroll — constant speed for any image height
 */
function initProjectCardScroll() {
  var SCROLL_SPEED = 150;
  var MIN_DURATION = 2;
  var resizeTimer;

  function getCardHeight(card) {
    var value = getComputedStyle(card).getPropertyValue("--card-preview-height").trim();
    var parsed = parseFloat(value);

    return Number.isFinite(parsed) ? parsed : 450;
  }

  function setImageDuration(img) {
    var card = img.closest(".custom-card");
    if (!card) {
      return;
    }

    function apply() {
      var cardHeight = getCardHeight(card);
      var imgHeight = img.getBoundingClientRect().height;

      if (!imgHeight) {
        return;
      }

      var distance = Math.max(0, imgHeight - cardHeight);

      if (distance === 0) {
        img.style.setProperty("--scroll-duration", "0s");
        return;
      }

      var duration = Math.max(MIN_DURATION, distance / SCROLL_SPEED);
      img.style.setProperty("--scroll-duration", duration + "s");
    }

    if (img.complete && img.naturalHeight) {
      apply();
    } else {
      img.addEventListener("load", apply, { once: true });
    }
  }

  function initAll() {
    document.querySelectorAll(".custom-card__img").forEach(setImageDuration);
  }

  initAll();

  window.addEventListener("resize", function () {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(initAll, 150);
  });
}

document.addEventListener("DOMContentLoaded", function () {
  initScrollFx();
  initCircuitObserver();
  initStatCounters();
  initImagePlaceholders();
  initProjectCardScroll();

  if (!("IntersectionObserver" in window)) {
    document.querySelectorAll(".reveal-section, #skills, #services").forEach(function (el) {
      el.classList.add("is-visible", "is-inview", "is-circuit-visible");
    });
    return;
  }

  var revealObserver = new IntersectionObserver(
    function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          if (entry.target.id === "skills" || entry.target.id === "services") {
            entry.target.classList.add("is-inview", "is-visible");
          } else {
            entry.target.classList.add("is-visible");
          }
          revealObserver.unobserve(entry.target);
        }
      });
    },
    { threshold: 0.15, rootMargin: "0px 0px -40px 0px" }
  );

  document.querySelectorAll(".reveal-section").forEach(function (section) {
    revealObserver.observe(section);
  });
});

$(document).ready(function () {
  $("#success-message").delay(3000).slideUp();
});

/**
 * navbar toggle
 */
var navToggleBtn = document.querySelector("[data-nav-toggle-btn]");
var navbar = document.querySelector("[data-navbar]");
var navLinks = document.querySelectorAll(".navbar-link");

function closeMenu() {
  if (navbar) {
    navbar.classList.remove("active");
  }
  if (navToggleBtn) {
    navToggleBtn.classList.remove("active");
  }
  document.body.style.overflow = "";
}

if (navToggleBtn && navbar) {
  navToggleBtn.addEventListener("click", function () {
    elemToggleFunc(navToggleBtn);
    elemToggleFunc(navbar);
    document.body.style.overflow = document.body.style.overflow === "hidden" ? "" : "hidden";
  });
}

navLinks.forEach(function (link) {
  link.addEventListener("click", closeMenu);
});

/**
 * skills / certificates tab toggle
 */
document.addEventListener("DOMContentLoaded", function () {
  var skillsSection = document.querySelector("#skills[data-active-tab]");

  if (!skillsSection) {
    return;
  }

  var toggleBtns = skillsSection.querySelectorAll("[data-toggle-btn]");
  var certificateSwiper = null;

  function initCertificateSwiper() {
    if (certificateSwiper || !skillsSection.querySelector("#slider2")) {
      return;
    }

    certificateSwiper = new Swiper("#slider2", {
      loop: true,
      spaceBetween: 32,
      grabCursor: true,
      autoplay: {
        delay: 3000,
        disableOnInteraction: false,
      },
      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      },
      breakpoints: {
        600: { slidesPerView: 1 },
        968: { slidesPerView: 1 },
      },
    });
    var slider2El = document.querySelector("#slider2");
    if (slider2El) {
      slider2El.addEventListener("mouseenter", function () {
        if (certificateSwiper) certificateSwiper.autoplay.stop();
      });
      slider2El.addEventListener("mouseleave", function () {
        if (certificateSwiper) certificateSwiper.autoplay.start();
      });
    }
  }

  function setSkillsTab(tab) {
    skillsSection.setAttribute("data-active-tab", tab);

    toggleBtns.forEach(function (btn) {
      btn.classList.toggle("active", btn.dataset.tab === tab);
    });

    if (tab === "certificates") {
      initCertificateSwiper();
      if (certificateSwiper) {
        certificateSwiper.update();
      }
    }
  }

  toggleBtns.forEach(function (btn) {
    btn.addEventListener("click", function () {
      if (btn.dataset.tab) {
        setSkillsTab(btn.dataset.tab);
      }
    });
  });

  var skillsList = skillsSection.querySelector("[data-skills-sortable]");
  if (skillsList && typeof Sortable !== "undefined") {
    var progressEl = skillsSection.querySelector("[data-skills-progress]");
    var shuffleBtn = skillsSection.querySelector("[data-skills-shuffle]");
    var skillItems = Array.from(skillsList.querySelectorAll(".skill-item"));
    var totalSkills = skillItems.length;
    var sortableInstance = null;
    var gameSolved = false;

    function shuffleArray(list) {
      var copy = list.slice();
      for (var i = copy.length - 1; i > 0; i--) {
        var j = Math.floor(Math.random() * (i + 1));
        var temp = copy[i];
        copy[i] = copy[j];
        copy[j] = temp;
      }
      return copy;
    }

    function isOrderSolved(nodes) {
      var list = nodes || Array.from(skillsList.querySelectorAll(".skill-item"));
      return list.every(function (item, index) {
        return parseInt(item.dataset.order, 10) === index;
      });
    }

    function countCorrectSkills() {
      return Array.from(skillsList.querySelectorAll(".skill-item")).filter(function (item, index) {
        return parseInt(item.dataset.order, 10) === index;
      }).length;
    }

    function updateSkillsProgress() {
      var correct = countCorrectSkills();

      if (progressEl) {
        progressEl.textContent = correct + " / " + totalSkills + " in correct position";
      }

      Array.from(skillsList.querySelectorAll(".skill-item")).forEach(function (item, index) {
        var inPlace = parseInt(item.dataset.order, 10) === index;
        item.classList.toggle("is-correct-slot", inPlace);
        item.classList.toggle("is-wrong-slot", !inPlace);
      });

      if (!gameSolved && totalSkills > 1 && isOrderSolved()) {
        gameSolved = true;
        skillsSection.classList.add("is-skills-solved");

        if (sortableInstance) {
          sortableInstance.option("disabled", true);
        }

        if (typeof Swal !== "undefined") {
          Swal.fire({
            icon: "success",
            title: "Well done!",
            text: "You arranged all skills in the correct order!",
            confirmButtonText: "Play Again",
            confirmButtonColor: "#e8a33d",
            background: "#1a1a1a",
            color: "#ffffff",
          }).then(function () {
            resetSkillsGame();
          });
        }
      }
    }

    function shuffleSkillItems(ensureDifferent) {
      var shuffled = shuffleArray(skillItems);

      if (ensureDifferent !== false) {
        var attempts = 0;
        while (isOrderSolved(shuffled) && attempts < 25) {
          shuffled = shuffleArray(skillItems);
          attempts++;
        }
      }

      shuffled.forEach(function (item) {
        skillsList.appendChild(item);
      });

      skillsSection.classList.add("is-skills-played");
      updateSkillsProgress();
    }

    function resetSkillsGame() {
      gameSolved = false;
      skillsSection.classList.remove("is-skills-solved");

      if (sortableInstance) {
        sortableInstance.option("disabled", false);
      }

      shuffleSkillItems(true);
    }

    if (totalSkills > 1) {
      skillsList.classList.add("is-game-pending");
      shuffleSkillItems(true);
      skillsList.classList.remove("is-game-pending");

      sortableInstance = Sortable.create(skillsList, {
        animation: 220,
        draggable: ".skill-item",
        ghostClass: "skill-item-ghost",
        chosenClass: "skill-item-chosen",
        delay: 120,
        delayOnTouchOnly: true,
        onStart: function () {
          skillsSection.classList.add("is-skills-sorting");
        },
        onEnd: function () {
          skillsSection.classList.remove("is-skills-sorting");
          skillsSection.classList.add("is-skills-played");
          updateSkillsProgress();
        },
      });

      if (shuffleBtn) {
        shuffleBtn.addEventListener("click", function () {
          resetSkillsGame();
        });
      }
    }
  }
});

if (document.querySelector("#slider1")) {
  var feedbackSwiper = new Swiper("#slider1", {
    loop: true,
    spaceBetween: 32,
    grabCursor: true,
    autoplay: {
      delay: 3000,
      disableOnInteraction: false,
    },
    pagination: {
      el: ".swiper-pagination",
      clickable: true,
      dynamicBullets: true,
    },
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
    breakpoints: {
      600: { slidesPerView: 2 },
      968: { slidesPerView: 3 },
    },
  });
  document.querySelector("#slider1").addEventListener("mouseenter", function () {
    feedbackSwiper.autoplay.stop();
  });
  document.querySelector("#slider1").addEventListener("mouseleave", function () {
    feedbackSwiper.autoplay.start();
  });
}

if (document.querySelector("#slider3")) {
  var detailSwiper = new Swiper("#slider3", {
    loop: true,
    spaceBetween: 32,
    grabCursor: true,
    autoplay: {
      delay: 3000,
      disableOnInteraction: false,
    },
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
    breakpoints: {
      600: { slidesPerView: 1 },
      968: { slidesPerView: 1 },
    },
  });
  document.querySelector("#slider3").addEventListener("mouseenter", function () {
    detailSwiper.autoplay.stop();
  });
  document.querySelector("#slider3").addEventListener("mouseleave", function () {
    detailSwiper.autoplay.start();
  });
}

/**
 * service card → contact form prefill
 */
document.addEventListener("DOMContentLoaded", function () {
  var prefill = sessionStorage.getItem("prefillService");
  if (prefill) {
    var messageField = document.getElementById("message");
    if (messageField && !messageField.value.trim()) {
      messageField.value = "Hi, I am interested in your " + prefill + " service.\n\n";
    }
    sessionStorage.removeItem("prefillService");
  }
});

/**
 * portfolio category tab filter
 */
document.addEventListener("DOMContentLoaded", function () {
  var portfolioSection = document.querySelector("#portfolio[data-active-tab]");
  if (!portfolioSection) {
    return;
  }

  var tabBtns = portfolioSection.querySelectorAll("[data-portfolio-tab]");
  var cards = portfolioSection.querySelectorAll(".project-card-item");
  var emptyFiltered = portfolioSection.querySelector(".portfolio-empty-filtered");
  var currentTab = null;
  var filterTimer = null;
  var isFiltering = false;
  var FILTER_MS = 320;
  var STAGGER_MS = 45;
  var reducedMotion = window.matchMedia("(prefers-reduced-motion: reduce)").matches;

  cards.forEach(function (card) {
    if (card.hasAttribute("hidden")) {
      card.classList.add("portfolio-card--hidden");
      card.removeAttribute("hidden");
    }
  });

  function cardIsVisible(card) {
    return !card.classList.contains("portfolio-card--hidden");
  }

  function applyFilterState(tab) {
    var visibleCount = 0;

    cards.forEach(function (card) {
      var show = tab === "all" || card.dataset.category === tab;
      card.classList.toggle("portfolio-card--hidden", !show);
      card.setAttribute("aria-hidden", show ? "false" : "true");
      if (show) {
        visibleCount++;
      }
    });

    if (emptyFiltered) {
      emptyFiltered.hidden = visibleCount > 0;
    }
  }

  function resetCardMotion(card) {
    card.classList.remove("portfolio-card--leaving", "portfolio-card--entering");
    card.style.transitionDelay = "";
  }

  function filterProjects(tab, instant) {
    if (tab === currentTab && !instant) {
      return;
    }

    portfolioSection.setAttribute("data-active-tab", tab);

    tabBtns.forEach(function (btn) {
      btn.classList.toggle("active", btn.dataset.tab === tab);
    });

    if (instant || reducedMotion) {
      clearTimeout(filterTimer);
      isFiltering = false;
      cards.forEach(resetCardMotion);
      applyFilterState(tab);
      currentTab = tab;
      return;
    }

    if (isFiltering) {
      clearTimeout(filterTimer);
      cards.forEach(resetCardMotion);
    }

    isFiltering = true;

    var currentlyVisible = Array.from(cards).filter(cardIsVisible);

    currentlyVisible.forEach(function (card) {
      card.classList.add("portfolio-card--leaving");
    });

    filterTimer = setTimeout(function () {
      currentlyVisible.forEach(function (card) {
        card.classList.remove("portfolio-card--leaving");
      });

      applyFilterState(tab);

      var nowVisible = Array.from(cards).filter(cardIsVisible);

      nowVisible.forEach(function (card) {
        card.classList.add("portfolio-card--entering");
      });

      void portfolioSection.offsetWidth;

      nowVisible.forEach(function (card, index) {
        card.style.transitionDelay = index * STAGGER_MS + "ms";
        card.classList.remove("portfolio-card--entering");
      });

      filterTimer = setTimeout(function () {
        nowVisible.forEach(resetCardMotion);
        isFiltering = false;
        currentTab = tab;
      }, FILTER_MS + nowVisible.length * STAGGER_MS);
    }, FILTER_MS);
  }

  tabBtns.forEach(function (btn) {
    btn.addEventListener("click", function () {
      filterProjects(btn.dataset.tab);
    });
  });

  var params = new URLSearchParams(window.location.search);
  var initialTab = params.get("tab");
  var defaultTab = portfolioSection.getAttribute("data-active-tab");

  if (initialTab && portfolioSection.querySelector('[data-portfolio-tab][data-tab="' + initialTab + '"]')) {
    filterProjects(initialTab, true);
  } else if (defaultTab && portfolioSection.querySelector('[data-portfolio-tab][data-tab="' + defaultTab + '"]')) {
    filterProjects(defaultTab, true);
  } else {
    var firstTab = tabBtns[0];
    if (firstTab) {
      filterProjects(firstTab.dataset.tab, true);
    }
  }
});

(function () {
  var emailHref =
    "mailto:shahidrasheedsmm@gmail.com?subject=" +
    encodeURIComponent("Project Inquiry — Shahid Rasheed") +
    "&body=" +
    encodeURIComponent(
      "Hi Shahid,\n\nI found your portfolio and would like to discuss a project.\n\nProject type: \nBudget: \nTimeline: \n\nThanks!"
    );
  var waHref =
    "https://wa.me/923062872169?text=" +
    encodeURIComponent(
      "Hi Shahid, I found your portfolio and would like to discuss a project."
    );

  if (!document.querySelector(".email-float")) {
    var email = document.createElement("a");
    email.href = emailHref;
    email.className = "email-float";
    email.title = "Email Shahid";
    email.setAttribute("aria-label", "Email Shahid");
    email.innerHTML = '<i class="fas fa-envelope"></i>';
    document.body.appendChild(email);
  }

  if (!document.querySelector(".whatsapp-float")) {
    var link = document.createElement("a");
    link.href = waHref;
    link.className = "whatsapp-float";
    link.target = "_blank";
    link.rel = "noopener noreferrer";
    link.title = "Chat on WhatsApp";
    link.setAttribute("aria-label", "Chat on WhatsApp");
    link.innerHTML = '<i class="fab fa-whatsapp"></i>';
    document.body.appendChild(link);
  }
})();

(function () {
  var rotator = document.querySelector("[data-hero-rotator]");
  if (!rotator) {
    return;
  }

  var slides = rotator.querySelectorAll(".hero-title-slide");
  if (slides.length < 2) {
    return;
  }

  if (window.matchMedia("(prefers-reduced-motion: reduce)").matches) {
    return;
  }

  var index = 0;
  setInterval(function () {
    slides[index].classList.remove("is-active");
    index = (index + 1) % slides.length;
    slides[index].classList.add("is-active");
  }, 3200);
})();

(function () {
  var openButtons = document.querySelectorAll("[data-open-project]");
  var modals = document.querySelectorAll("[data-project-modal]");
  if (!openButtons.length || !modals.length) {
    return;
  }

  var lastFocus = null;

  function modalIdFromSlug(slug) {
    return "project-modal-" + String(slug || "").replace(/[^a-z0-9\-]/gi, "");
  }

  function closeModal(modal) {
    if (!modal || modal.hidden) {
      return;
    }
    modal.hidden = true;
    document.body.classList.remove("project-modal-open");
    if (lastFocus && typeof lastFocus.focus === "function") {
      lastFocus.focus();
    }
  }

  function closeAll() {
    modals.forEach(closeModal);
  }

  function openModal(slug) {
    var modal = document.getElementById(modalIdFromSlug(slug));
    if (!modal) {
      return false;
    }
    closeAll();
    lastFocus = document.activeElement;
    modal.hidden = false;
    document.body.classList.add("project-modal-open");
    var closeBtn = modal.querySelector(".project-modal__close");
    if (closeBtn) {
      closeBtn.focus();
    }
    return true;
  }

  openButtons.forEach(function (btn) {
    btn.addEventListener("click", function (event) {
      if (event.metaKey || event.ctrlKey || event.shiftKey || event.altKey || event.button === 1) {
        return;
      }
      var slug = btn.getAttribute("data-open-project");
      if (!slug) {
        return;
      }
      if (openModal(slug)) {
        event.preventDefault();
      }
    });
  });

  document.addEventListener("click", function (event) {
    var closer = event.target.closest("[data-close-project-modal]");
    if (closer) {
      closeAll();
    }
  });

  document.addEventListener("keydown", function (event) {
    if (event.key === "Escape") {
      closeAll();
    }
  });

  document.addEventListener("click", function (event) {
    var thumb = event.target.closest("[data-pd-shot]");
    if (!thumb) {
      return;
    }
    var src = thumb.getAttribute("data-pd-shot");
    var root = thumb.closest(".project-modal__body, .pd-page__body");
    if (!root || !src) {
      return;
    }
    var hero = root.querySelector(".pd-thumb-img");
    if (hero) {
      hero.src = src;
    }
    root.querySelectorAll("[data-pd-shot]").forEach(function (el) {
      el.classList.toggle("is-active", el === thumb);
    });
  });
})();
