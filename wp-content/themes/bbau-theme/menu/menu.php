<?php

$current_group = '';

if (isset($_COOKIE['current_menu']) && !empty($_COOKIE['current_menu'])) {
    $current_group = sanitize_text_field($_COOKIE['current_menu']);
}
if (!$current_group && isset($_GET['menu'])) {
    $current_group = sanitize_text_field($_GET['menu']);
}
if (!$current_group) {
    $current_group = get_field('menu_group');
}

if (!$current_group) return;

$all_menus = get_field('sidebar_menus', 'option');
if (!$all_menus) return;

$menu_items = [];
foreach ($all_menus as $menu) {
    if (empty($menu['menu_group'])) continue;
    if (strtolower(trim($menu['menu_group'])) === strtolower(trim($current_group))) {
        $menu_items = $menu['menu_items'];
        break;
    }
}

if (!$menu_items) return;

$menu_urls = [];
foreach ($menu_items as $mi) {
    if (is_object($mi['menu_page'])) {
        $menu_urls[] = get_permalink($mi['menu_page']->ID);
    } elseif (is_numeric($mi['menu_page'])) {
        $menu_urls[] = get_permalink($mi['menu_page']);
    } elseif (is_array($mi['menu_page'])) {
        $menu_urls[] = $mi['menu_page']['url'];
    }
}

$menu_urls_json = htmlspecialchars(json_encode($menu_urls), ENT_QUOTES, 'UTF-8');

?>

<div class="common-menu">
    <div class="menu-fade-left"></div>
    <button class="menu-scroll-btn menu-scroll-left" aria-label="Scroll left">&#8249;</button>

    <nav class="common-menu-nav">
        <?php foreach ($menu_items as $item):
            $page_link    = $item['menu_page'];
            $custom_label = $item['menu_label'];

            if (!$page_link) continue;

            if (is_object($page_link)) {
                $url   = get_permalink($page_link->ID);
                $title = $custom_label ?: $page_link->post_title;
            } elseif (is_array($page_link)) {
                $url   = $page_link['url'];
                $title = $custom_label ?: $page_link['title'];
            } elseif (is_numeric($page_link)) {
                $url   = get_permalink($page_link);
                $title = $custom_label ?: get_the_title($page_link);
            } else {
                $url   = $page_link;
                $title = $custom_label ?: 'Menu Item';
            }

            $final_url   = $url . '?menu=' . urlencode($current_group);
            $current_url = trailingslashit(get_permalink());
            $item_url    = trailingslashit($url);
            $active      = ($current_url === $item_url) ? 'active' : '';
        ?>
        <a class="common-menu-link <?php echo $active; ?>"
           href="<?php echo esc_url($final_url); ?>"
           data-menu="<?php echo esc_attr($current_group); ?>"
           data-pages='<?php echo $menu_urls_json; ?>'>
            <span class="dot"></span>
            <?php echo esc_html($title); ?>
        </a>
        <?php endforeach; ?>
    </nav>

    <button class="menu-scroll-btn menu-scroll-right" aria-label="Scroll right">&#8250;</button>
    <div class="menu-fade-right"></div>
</div>


<style>

/* ================= MENU ================= */
.common-menu {
  display: block;
  max-width: 100%;
  width: auto;
  background: transparent;
  border-radius: 12px;
  margin: 20px auto;
  overflow: hidden;
  position: relative;
}

/* ================= ARROW BUTTONS ================= */
.menu-scroll-btn {
  position: absolute;
  top: 0; bottom: 0;
  width: 32px;
  z-index: 10;
  border: none;
  cursor: pointer;
  background: #4a0d0d;
  color: #fff;
  font-size: 22px;
  line-height: 1;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: opacity .25s ease, background .2s ease;
  opacity: 0;
  pointer-events: none;
}
.menu-scroll-btn.show { opacity: 1; pointer-events: all; }
.menu-scroll-btn:hover { background: #3a0808; }
.menu-scroll-left  { left: 0;  border-radius: 12px 0 0 12px; }
.menu-scroll-right { right: 0; border-radius: 0 12px 12px 0; }

/* ================= FADE EDGES ================= */
.menu-fade-left,
.menu-fade-right {
  position: absolute;
  top: 0; bottom: 0;
  width: 30px;
  pointer-events: none;
  z-index: 9;
  opacity: 0;
  transition: opacity .3s ease;
}
.menu-fade-left  { left: 32px;  background: linear-gradient(to right, #5c1010, transparent); }
.menu-fade-right { right: 32px; background: linear-gradient(to left,  #5c1010, transparent); }
.menu-fade-left.show, .menu-fade-right.show { opacity: 1; }

/* ================= NAV ================= */
.common-menu-nav {
  display: flex;
  flex-wrap: nowrap;
  align-items: stretch;
  overflow-x: auto;
  overflow-y: hidden;
  -webkit-overflow-scrolling: touch;
  scroll-behavior: smooth;
  cursor: grab;
  scrollbar-width: none;
  /* default: full width, left-aligned for scroll mode */
  width: 100%;
  background: #5c1010;
  border-radius: 12px;
}
.common-menu-nav::-webkit-scrollbar { display: none; }
.common-menu-nav.is-dragging {
  cursor: grabbing;
  scroll-behavior: auto;
  user-select: none;
}

/*
 * FITS: nav shrinks to content width, centers itself
 * OVERFLOWS: nav stays full width, items scroll
 */
.common-menu-nav.is-fit {
  width: fit-content;
  margin: 0 auto;
}
.common-menu-nav.is-fit .common-menu-link {
  flex: 0 0 auto;
  min-width: 0;
}
.common-menu-nav:not(.is-fit) .common-menu-link {
  flex: 0 0 auto;
  min-width: 110px;
}

/* ================= LINKS ================= */
.common-menu-link {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  gap: 6px;
  padding: 12px 20px;
  font-size: 16px;
  font-weight: 700;
  text-align: center;
  white-space: nowrap;
  color: #e1ebf0 !important;
  text-decoration: none;
  border-right: 1px solid rgba(255,255,255,0.2);
  position: relative;
  transition: all .25s ease;
}
.common-menu-link:last-child { border-right: none; }

/* ================= DOT ================= */
.common-menu-link .dot {
  width: 6px; height: 6px;
  border-radius: 50%;
  background: #efbe1d;
  transition: all .25s ease;
}

/* ================= UNDERLINE ================= */
.common-menu-link::after {
  content: '';
  position: absolute;
  left: 10%; right: 10%; bottom: 0;
  height: 3px;
  background: linear-gradient(90deg, #1a2e3b, #2196a6);
  transform: scaleX(0);
  transform-origin: center;
  transition: transform .3s ease;
}

/* ================= HOVER ================= */
.common-menu-link:hover { background: #f5fafc; color: #441608 !important; }
.common-menu-link:hover .dot { background: #541c10 !important; }
.common-menu-link:hover::after { transform: scaleX(1); }

/* ================= ACTIVE ================= */
.common-menu-link.active { background: #eef6fa; color: #5a170f !important; font-weight: 600; }
.common-menu-link.active .dot { background: #5e1212 !important; }
.common-menu-link.active::after { transform: scaleX(1); }

/* ================= LARGE DESKTOP ================= */
@media (min-width: 1200px) {
  .common-menu-nav:not(.is-fit) .common-menu-link { min-width: 130px; }
}

/* ================= TABLET ================= */
@media (max-width: 992px) {
  .common-menu-nav:not(.is-fit) .common-menu-link {
    min-width: 110px;
    padding: 12px 16px;
    font-size: 12px;
  }
}

/* ================= MOBILE ================= */
@media (max-width: 768px) {
  .common-menu-nav:not(.is-fit) .common-menu-link {
    min-width: 100px;
    padding: 12px 14px;
    font-size: 12px;
  }
}

/* ================= SMALL MOBILE ================= */
@media (max-width: 480px) {
  .common-menu-nav:not(.is-fit) .common-menu-link {
    min-width: 85px;
    font-size: 11px;
    padding: 10px 12px;
  }
  .common-menu-nav:not(.is-fit) .common-menu-link .dot {
    width: 5px; height: 5px;
  }
}

/* ================= HOVER GLOW ================= */
.common-menu-nav:hover {
  box-shadow:
    0 8px 25px rgba(26, 46, 59, 0.12),
    0 0 10px rgba(33, 150, 166, 0.2);
}

</style>


<script>
(function () {

  var menu  = document.querySelector('.common-menu');
  if (!menu) return;

  var nav   = menu.querySelector('.common-menu-nav');
  var btnL  = menu.querySelector('.menu-scroll-left');
  var btnR  = menu.querySelector('.menu-scroll-right');
  var fadeL = menu.querySelector('.menu-fade-left');
  var fadeR = menu.querySelector('.menu-fade-right');
  var STEP  = 200;

  /* ---------- Fit check ---------- */
  function checkFit() {
    // Remove is-fit so links return to natural (content) width
    nav.classList.remove('is-fit');
    nav.style.width = '100%';

    var naturalWidth = 0;
    nav.querySelectorAll('.common-menu-link').forEach(function (link) {
      naturalWidth += link.scrollWidth;
    });

    if (naturalWidth <= nav.clientWidth) {
      nav.classList.add('is-fit');
      nav.style.width = '';
    }

    updateArrows();
  }

  /* ---------- Arrow visibility ---------- */
  function updateArrows() {
    var overflowing = nav.scrollWidth > nav.clientWidth + 4;
    var atStart     = nav.scrollLeft <= 4;
    var atEnd       = nav.scrollLeft >= nav.scrollWidth - nav.clientWidth - 4;

    btnL.classList.toggle('show',  overflowing && !atStart);
    btnR.classList.toggle('show',  overflowing && !atEnd);
    fadeL.classList.toggle('show', overflowing && !atStart);
    fadeR.classList.toggle('show', overflowing && !atEnd);
  }

  btnL.addEventListener('click', function () { nav.scrollLeft -= STEP; });
  btnR.addEventListener('click', function () { nav.scrollLeft += STEP; });
  nav.addEventListener('scroll', updateArrows);

  /* ---------- Respond to container resize ---------- */
  if (typeof ResizeObserver !== 'undefined') {
    new ResizeObserver(checkFit).observe(menu);
  } else {
    window.addEventListener('resize', checkFit);
  }

  /* ---------- Mouse drag ---------- */
  var drag = false, startX = 0, scrollStart = 0;

  nav.addEventListener('mousedown', function (e) {
    drag = true;
    startX      = e.pageX;
    scrollStart = nav.scrollLeft;
    nav.classList.add('is-dragging');
  });
  window.addEventListener('mousemove', function (e) {
    if (!drag) return;
    nav.scrollLeft = scrollStart - (e.pageX - startX);
  });
  window.addEventListener('mouseup', function () {
    drag = false;
    nav.classList.remove('is-dragging');
  });

  /* ---------- Touch swipe ---------- */
  nav.addEventListener('touchstart', function (e) {
    startX      = e.touches[0].pageX;
    scrollStart = nav.scrollLeft;
  }, { passive: true });
  nav.addEventListener('touchmove', function (e) {
    nav.scrollLeft = scrollStart - (e.touches[0].pageX - startX);
  }, { passive: true });

  /* ---------- Click: set active + scroll into view ---------- */
  nav.querySelectorAll('.common-menu-link').forEach(function (link) {
    link.addEventListener('click', function () {
      nav.querySelectorAll('.common-menu-link').forEach(function (l) {
        l.classList.remove('active');
      });
      link.classList.add('active');
      link.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
    });
  });

  /* ---------- Init ---------- */
  setTimeout(checkFit, 150);

})();
</script>