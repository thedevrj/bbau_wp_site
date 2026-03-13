<?php
/*
Template Name: Schools Page
*/
defined('ABSPATH') || exit;
get_header();

$response = wp_remote_get('http://172.35.0.45:8001/api/v1/schools/');
$schools  = json_decode(wp_remote_retrieve_body($response), true);
?>

<?php get_template_part('banners/about-banner'); ?>

<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/schools.css">

<div class="schools-section">

    <div class="schools-breadcrumb-bar">
        <div class="bc-inner">
            <?php get_template_part('template-parts/breadcrumb'); ?>
        </div>
    </div>

    <div class="schools-page-title">
        <div class="title-bar"></div>
        <h2>Schools </h2>
    </div>

    <div class="schools-search-wrap">
        <div class="schools-search-box">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="8" />
                <line x1="21" y1="21" x2="16.65" y2="16.65" />
            </svg>
            <input type="text" id="schoolSearch" placeholder="Search schools..." autocomplete="off" />
            <button id="schoolSearchClear" aria-label="Clear">&#x2715;</button>
        </div>
        <div id="schoolCount" class="schools-count"></div>
    </div>

    <div class="schools-masonry">

        <?php
        $pattern    = [1, 2, 0, 0, 2, 1, 0, 0, 2, 0, 1, 2, 0, 0, 2, 1, 0, 0, 2, 0];
        $size_class = ['', 'tall', 'wide'];

        if (!empty($schools) && is_array($schools)):
            foreach ($schools as $i => $school):
                $idx  = $i % count($pattern);
                $sz   = $size_class[$pattern[$idx]];
                $name = $school['name']  ?? '';
                $slug = $school['slug']  ?? '';
                $img  = $school['image'] ?? '';
        ?>
        <a href="/schools/<?php echo esc_attr($slug); ?>"
            class="school-tile <?php echo esc_attr($sz); ?> <?php echo empty($img) ? 'no-img' : ''; ?>"
            data-name="<?php echo esc_attr(strtolower($name)); ?>">

            <?php if (!empty($img)): ?>
            <img class="school-tile__img" src="<?php echo esc_url($img); ?>" alt="<?php echo esc_attr($name); ?>"
                loading="lazy">
            <?php endif; ?>

            <div class="school-tile__overlay"></div>

            <div class="school-tile__content">
                <div class="school-tile__bar"></div>
                <p class="school-tile__name"><?php echo esc_html($name); ?></p>
            </div>

        </a>
        <?php
            endforeach;
        endif;
        ?>

        <div class="schools-no-results" id="schoolsNoResults">
            <svg viewBox="0 0 24 24">
                <circle cx="11" cy="11" r="8" />
                <line x1="21" y1="21" x2="16.65" y2="16.65" />
            </svg>
            No schools found for "<span id="noResultsTerm"></span>"
        </div>

    </div>

</div>

<script src="<?php echo get_template_directory_uri(); ?>/assets/js/schools.js"></script>


<style>
/* ============================================================
   SCHOOLS PAGE
   ============================================================ */

.schools-section {
    width: 100%;
    background: #f5f7fa;
    padding: 0 0 60px;
    font-family: 'Poppins', sans-serif;
}

/* ── BREADCRUMB ── */
.schools-breadcrumb-bar {
    background: #1f6f8b;
    padding: 0 40px;
    margin-bottom: 32px;
}

.schools-breadcrumb-bar .bc-inner {
    max-width: 1400px;
    margin: 0 auto;
    padding: 10px 0;
}

/* ── PAGE TITLE ── */
.schools-page-title {
    max-width: 1400px;
    margin: 0 auto 20px;
    padding: 0 40px;
    display: flex;
    align-items: center;
    gap: 14px;
}

.schools-page-title .title-bar {
    width: 4px;
    height: 36px;
    background: #e4cf10;
    border-radius: 2px;
    flex-shrink: 0;
}

/* ── SEARCH ── */
.schools-search-wrap {
    max-width: 1400px;
    margin: 0 auto 20px;
    padding: 0 40px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
}

.schools-search-box {
    display: flex;
    align-items: center;
    gap: 10px;
    background: #fff;
    border: 1.5px solid #d0dce3;
    border-radius: 50px;
    padding: 10px 18px;
    width: 360px;
    transition: border-color .2s, box-shadow .2s;
}

.schools-search-box:focus-within {
    border-color: #1f6f8b;
    box-shadow: 0 0 0 3px rgba(31, 111, 139, .12);
}

.schools-search-box svg {
    width: 18px;
    height: 18px;
    color: #888;
    flex-shrink: 0;
}

.schools-search-box input {
    border: none;
    outline: none;
    font-size: 14px;
    font-family: 'Poppins', sans-serif;
    color: #1a1a1a;
    background: transparent;
    flex: 1;
}

.schools-search-box input::placeholder {
    color: #aaa;
}

#schoolSearchClear {
    background: none;
    border: none;
    cursor: pointer;
    color: #aaa;
    font-size: 14px;
    padding: 0;
    line-height: 1;
    display: none;
    transition: color .2s;
}

#schoolSearchClear:hover {
    color: #1f6f8b;
}

.schools-count {
    font-size: 13px;
    color: #888;
    font-family: 'Poppins', sans-serif;
    white-space: nowrap;
}

/* ── MASONRY GRID ── */
.schools-masonry {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 40px;
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    grid-auto-rows: 200px;
    gap: 6px;
    background: #111;
    border-radius: 18px;
    overflow: hidden;
}

/* ── TILE ── */
.school-tile {
    position: relative;
    overflow: hidden;
    cursor: pointer;
    text-decoration: none;
    display: block;
    background: #1f6f8b;
}

.school-tile.tall {
    grid-row: span 2;
}

.school-tile.wide {
    grid-column: span 2;
}

.school-tile.hidden {
    display: none;
}

.school-tile__img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    transition: transform .5s ease;
}

.school-tile:hover .school-tile__img {
    transform: scale(1.08);
}

.school-tile__overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(to top,
            rgba(0, 0, 0, .88) 0%,
            rgba(0, 0, 0, .18) 55%,
            transparent 100%);
    transition: background .35s;
}

.school-tile:hover .school-tile__overlay {
    background: linear-gradient(to top,
            rgba(8, 55, 75, .93) 0%,
            rgba(8, 55, 75, .35) 55%,
            transparent 100%);
}

.school-tile.no-img .school-tile__overlay {
    background: rgba(8, 55, 75, .75);
}

.school-tile__content {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    padding: 18px 20px;
}

.school-tile__bar {
    width: 30px;
    height: 3px;
    background: #e4cf10;
    border-radius: 2px;
    margin-bottom: 9px;
    transform: scaleX(0);
    transform-origin: left;
    transition: transform .35s ease;
}

.school-tile:hover .school-tile__bar {
    transform: scaleX(1);
}

.school-tile__name {
    color: #ffffff;
    font-size: 18px;
    font-weight: 700;
    line-height: 1.35;
    text-shadow: 0 2px 12px rgba(0, 0, 0, .9);
    margin: 0;
}

/* ── NO RESULTS ── */
.schools-no-results {
    display: none;
    grid-column: 1 / -1;
    padding: 60px 20px;
    text-align: center;
    color: #fff;
    font-size: 16px;
    font-family: 'Poppins', sans-serif;
}

.schools-no-results svg {
    width: 48px;
    height: 48px;
    stroke: rgba(255, 255, 255, .4);
    fill: none;
    stroke-width: 1.5;
    display: block;
    margin: 0 auto 14px;
}

/* ── RESPONSIVE ── */
@media (max-width: 1024px) {
    .schools-masonry {
        grid-template-columns: repeat(2, 1fr);
        grid-auto-rows: 180px;
    }
}

@media (max-width: 640px) {
    .schools-masonry {
        grid-template-columns: repeat(2, 1fr);
        grid-auto-rows: 150px;
        padding: 0 16px;
        border-radius: 12px;
    }

    .school-tile__name {
        font-size: 14px;
    }

    .schools-breadcrumb-bar,
    .schools-page-title,
    .schools-search-wrap {
        padding-left: 16px;
        padding-right: 16px;
    }

    .schools-search-box {
        width: 100%;
    }

    .schools-search-wrap {
        flex-direction: column;
        align-items: flex-start;
    }
}
</style>

<script>
(function() {
    const input = document.getElementById('schoolSearch');
    const clearBtn = document.getElementById('schoolSearchClear');
    const countEl = document.getElementById('schoolCount');
    const noResults = document.getElementById('schoolsNoResults');
    const tiles = Array.from(document.querySelectorAll('.school-tile'));
    const total = tiles.length;

    if (!input || !tiles.length) return;

    /* ── update count label ── */
    function updateCount(visible) {
        countEl.textContent = input.value.trim() === '' ?
            total + ' schools' :
            visible + ' of ' + total + ' schools';
    }

    /* ── core filter function ── */
    function filter(term) {
        const q = term.trim().toLowerCase();
        let visible = 0;

        tiles.forEach(function(tile) {
            /* use data-name attr for fast lookup — no DOM traversal */
            var name = tile.getAttribute('data-name') || '';
            if (q === '' || name.includes(q)) {
                tile.classList.remove('hidden');
                visible++;
            } else {
                tile.classList.add('hidden');
            }
        });

        /* no results state */
        if (visible === 0 && q !== '') {
            noResults.style.display = 'block';
            document.getElementById('noResultsTerm').textContent = term;
        } else {
            noResults.style.display = 'none';
        }

        /* clear button */
        clearBtn.style.display = q !== '' ? 'block' : 'none';

        updateCount(visible);
    }

    /* ── events ── */
    input.addEventListener('input', function() {
        filter(input.value);
    });

    clearBtn.addEventListener('click', function() {
        input.value = '';
        input.focus();
        filter('');
    });

    /* ── init ── */
    updateCount(total);

}());
</script>
<?php get_footer(); ?>