<?php
/*
Template Name: Schools Page
*/
defined('ABSPATH') || exit;
get_header();

/* ===============================
   API CONFIG
=============================== */
$api_base   = getenv('DJANGO_API_URL');
$media_base = getenv('DJANGO_MEDIA_URL');
$api_url    = $api_base . '/api/v1/schools/';

/* ===============================
   API CALL (SAFE)
=============================== */
$response = wp_remote_get($api_url, [
    'headers' => [
        'X-Forwarded-Host'  => $_SERVER['HTTP_HOST'],
        'X-Forwarded-Proto' => is_ssl() ? 'https' : 'http',
    ],
    'timeout' => 10,
]);

$schools  = json_decode(wp_remote_retrieve_body($response), true);
?>

<?php get_template_part('banners/about-banner'); ?>

<div class="schools-section page-bg">
    <div class="container">

        <!-- ================= BREADCRUMB ================= -->
        <div class="schools-breadcrumb-bar py-4">
            <div class="bc-inner">
                <?php get_template_part('template-parts/breadcrumb'); ?>
            </div>
        </div>

        <!-- ================= TITLE ================= -->
        <div class="schools-page-title">
            <div class="title-bar"></div>
            <h2>Schools</h2>
        </div>

        <!-- ================= SEARCH ================= -->
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

        <!-- ================= GRID ================= -->
        <div class="schools-masonry">

            <?php if (!empty($schools) && is_array($schools)): ?>

            <?php foreach ($schools as $school): 
                $name = $school['name'] ?? '';
                $slug = $school['slug'] ?? '';
                $img  = $school['image'] ?? '';
            ?>

            <a href="/schools/<?php echo esc_attr($slug); ?>"
                class="school-tile <?php echo empty($img) ? 'no-img' : ''; ?>"
                data-name="<?php echo esc_attr(strtolower($name)); ?>">

                <?php if (!empty($img)): ?>
                <img class="school-tile__img" src="<?php echo esc_url($media_base . $img); ?>"
                    alt="<?php echo esc_attr($name); ?>" loading="lazy">
                <?php endif; ?>

                <div class="school-tile__overlay"></div>

                <div class="school-tile__content">
                    <div class="school-tile__bar"></div>
                    <p class="school-tile__name"><?php echo esc_html($name); ?></p>
                </div>

            </a>

            <?php endforeach; ?>

            <?php else: ?>
            <p style="text-align:center; padding:40px;">No schools available.</p>
            <?php endif; ?>

            <!-- NO RESULTS -->
            <div class="schools-no-results" id="schoolsNoResults">
                <svg viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8" />
                    <line x1="21" y1="21" x2="16.65" y2="16.65" />
                </svg>
                No schools found for "<span id="noResultsTerm"></span>"
            </div>

        </div>

    </div>
</div>

<!-- ================= SEARCH SCRIPT ================= -->
<script>
(function() {
    const input = document.getElementById('schoolSearch');
    const clearBtn = document.getElementById('schoolSearchClear');
    const countEl = document.getElementById('schoolCount');
    const noResults = document.getElementById('schoolsNoResults');
    const tiles = Array.from(document.querySelectorAll('.school-tile'));
    const total = tiles.length;

    if (!input || !tiles.length) return;

    function updateCount(visible) {
        countEl.textContent = input.value.trim() === '' ?
            total + ' schools' :
            visible + ' of ' + total + ' schools';
    }

    function filter(term) {
        const q = term.trim().toLowerCase();
        let visible = 0;

        tiles.forEach(tile => {
            const name = tile.getAttribute('data-name') || '';
            if (q === '' || name.includes(q)) {
                tile.classList.remove('hidden');
                visible++;
            } else {
                tile.classList.add('hidden');
            }
        });

        if (visible === 0 && q !== '') {
            noResults.style.display = 'block';
            document.getElementById('noResultsTerm').textContent = term;
        } else {
            noResults.style.display = 'none';
        }

        clearBtn.style.display = q !== '' ? 'block' : 'none';
        updateCount(visible);
    }

    input.addEventListener('input', () => filter(input.value));

    clearBtn.addEventListener('click', () => {
        input.value = '';
        input.focus();
        filter('');
    });

    updateCount(total);
})();
</script>

<?php get_footer(); ?>