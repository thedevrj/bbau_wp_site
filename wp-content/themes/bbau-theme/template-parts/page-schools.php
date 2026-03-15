<?php
/*
Template Name: Schools Page
*/
defined('ABSPATH') || exit;
get_header();

/* Get API base URL from environment */
$api_base = getenv('DJANGO_API_URL');
/* Build endpoint */
$api_url = $api_base . '/api/v1/schools/';
/* Call API */
$response = wp_remote_get($api_url);
$schools = json_decode(wp_remote_retrieve_body($response), true);
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
            <img class="school-tile__img" src="<?php echo $api_base . $img; ?>" alt="<?php echo esc_attr($name); ?>"
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