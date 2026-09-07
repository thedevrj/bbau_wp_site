<?php 
/*
Template name: Homepage Template
*/  
get_header();
defined( 'ABSPATH' ) || exit;

$api_base   = getenv('DJANGO_API_URL');
$media_base = getenv('DJANGO_MEDIA_URL');
$api_url = $api_base . "/api/v1/global-notices/?page_size=100";
$response = wp_remote_get($api_url, array('timeout' => 10));
$notices_data = array();

if ( ! is_wp_error( $response ) && wp_remote_retrieve_response_code( $response ) === 200 ) {
    $body = wp_remote_retrieve_body( $response );
    $decoded = json_decode( $body, true );
    $notices_data = isset($decoded['results']) ? $decoded['results'] : (is_array($decoded) ? $decoded : array());
}

$marquee_notices = array();
$announcement_notices = array();
$event_notices = array();
$appointment_notices = array();
$tender_notices = array();

foreach ( $notices_data as $notice ) {
    if ( !empty($notice['show_in_marquee']) ) {
        $marquee_notices[] = $notice;
    }
    
    $cats = isset($notice['categories']) && is_array($notice['categories']) ? $notice['categories'] : array();
    foreach ( $cats as $cat_raw ) {
        $cat = strtolower($cat_raw ?? '');
        if ( $cat === 'announcement' ) {
            $announcement_notices[] = $notice;
        } elseif ( $cat === 'event' ) {
            $event_notices[] = $notice;
        } elseif ( $cat === 'appointment' ) {
            $appointment_notices[] = $notice;
        } elseif ( $cat === 'tenders' || $cat === 'tender' ) {
            $tender_notices[] = $notice;
        }
    }
}

function get_notice_href($notice) {
    if (!empty($notice['attachment'])) return $notice['attachment'];
    if (!empty($notice['link'])) return $notice['link'];
    return '#';
}
?>

<!-- ================= HERO SECTION ================= -->
<section class="hero">
    <div class="hero-media">
        <video class="hero-video" id="heroVideo" autoplay muted loop playsinline>
            <source src="/wp-content/uploads/2026/01/BBAU-home-video-HD-1080p.mp4" type="video/mp4">
        </video>

        <div class="hero-slideshow" id="heroSlideshow">
            <div class="hero-slide" style="background-image:url('/wp-content/uploads/2026/09/covo1.jpeg')"></div>
            <div class="hero-slide" style="background-image:url('/wp-content/uploads/2026/09/batch_IMG_3169-scaled.jpg')"></div>
            <div class="hero-slide" style="background-image:url('/wp-content/uploads/2026/08/DSC_5814.jpg')"></div>
            <div class="hero-slide" style="background-image:url('/wp-content/uploads/2026/08/DSC_5923.jpg')"></div>
             <div class="hero-slide" style="background-image:url('/wp-content/uploads/2026/09/batch_DSC_6675-scaled.jpg')"></div>     
            <div class="hero-slide" style="background-image:url('/wp-content/uploads/2026/09/convo4.webp')"></div>
            <div class="hero-slide" style="background-image:url('/wp-content/uploads/2026/06/IMG_7011-scaled.jpg')"></div>
            <div class="hero-slide" style="background-image:url('/wp-content/uploads/2026/09/batch_IMG_3298-scaled.jpg')"></div>
            <div class="hero-slide" style="background-image:url('/wp-content/uploads/2026/09/batch_DSC_6681-scaled.jpg')"></div>
            <div class="hero-slide" style="background-image:url('/wp-content/uploads/2026/09/batch_DSC_6681-scaled.jpg')"></div>
        </div>

        <div class="hero-dots" id="heroDots"></div>
    </div>

    <div class="hero-rankings">
        <a href="/about-us/accreditation/" class="ranking-card nirf-card">
            <img src="/wp-content/themes/bbau-theme/assets/img/IQAC/nirf_logo.png" alt="NIRF Logo">
            <div class="ranking-info">
                <span class="ranking-title">NIRF </span>
                <span class="ranking-value">Rank 37</span>
            </div>
        </a>
        <a href="/about-us/accreditation/" class="ranking-card naac-card">
            <img src="/wp-content/themes/bbau-theme/assets/img/IQAC/naac_logo.png" alt="NAAC Logo">
            <div class="ranking-info">
                <span class="ranking-title">NAAC </span>
                <span class="ranking-value">Grade A++</span>
                <span class="ranking-sub">CGPA 3.72</span>
            </div>
        </a>
    </div>

    <div class="hero-caption">
        <p>
            “It is the education which is the right weapon to cut the social slavery and it is the
            education which will enlighten the downtrodden masses to come up and gain social status,
            economic betterment and political freedom.”
        </p>
        <p class="author">Dr. B. R. Ambedkar, Bharat Ratna</p>
    </div>
</section>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const video      = document.getElementById("heroVideo");
    const slideshow  = document.getElementById("heroSlideshow");
    const slides     = slideshow ? slideshow.querySelectorAll(".hero-slide") : [];
    const dotsWrap   = document.getElementById("heroDots");

    const VIDEO_DURATION  = 10000; 
    const SLIDE_INTERVAL  = 5000;  
    const PHOTOS_PER_CYCLE = 2;    

    let slidePointer = 0; 
    if (dotsWrap && slides.length) {
        slides.forEach((_, i) => {
            const dot = document.createElement("span");
            dot.className = "dot";
            dot.dataset.index = i;
            dotsWrap.appendChild(dot);
        });
    }
    const dots = dotsWrap ? dotsWrap.querySelectorAll(".dot") : [];

    function setActiveDot(index) {
        dots.forEach((d, i) => d.classList.toggle("is-active", i === index));
    }

    function showSlide(index) {
        slides.forEach((s, i) => s.classList.toggle("is-active", i === index));
        setActiveDot(index);
    }

    function playVideoPhase() {
        if (dotsWrap) dotsWrap.classList.remove("is-visible");
        slides.forEach(s => s.classList.remove("is-active"));

        if (video) {
            video.currentTime = 0;
            video.muted = true;
            video.classList.remove("is-hidden");
            video.play().catch(() => {
                video.muted = true;
                video.play();
            });
        }

        setTimeout(playSlideshowPhase, VIDEO_DURATION);
    }

    function playSlideshowPhase() {
        if (!slides.length) {
            setTimeout(playVideoPhase, VIDEO_DURATION);
            return;
        }

        if (video) video.classList.add("is-hidden");
        setTimeout(() => { if (video) video.pause(); }, 1800);
        const total = slides.length;
        const pairIndices = [];
        for (let i = 0; i < PHOTOS_PER_CYCLE && i < total; i++) {
            pairIndices.push((slidePointer + i) % total);
        }
        let step = 0;
        showSlide(pairIndices[0]);
        if (dotsWrap) dotsWrap.classList.add("is-visible");

        const slideTimer = setInterval(() => {
            step++;

            if (step >= pairIndices.length) {
                
                clearInterval(slideTimer);
                slidePointer = (slidePointer + PHOTOS_PER_CYCLE) % total;
                playVideoPhase();
                return;
            }

            showSlide(pairIndices[step]);
        }, SLIDE_INTERVAL);
    }
    playVideoPhase();
});
</script>

<!-- ================= ANNOUNCEMENT BAR ================= -->
<div id="main-content" class="announce-bar">
    <div class="announce-container">
        <div class="announce-track">
            <?php if ( !empty($marquee_notices) ) : ?>
            <?php foreach ( $marquee_notices as $mn ) : ?>
            <span><a target="_blank"
                    href="<?php echo $media_base . esc_url(get_notice_href($mn)); ?>"><?php echo esc_html($mn['title']); ?></a></span>
            <?php endforeach; ?>
            <?php else: ?>
            <span><a href="#">No new marquee updates at this time.</a></span>
            <?php endif; ?>
        </div>
    </div>
</div>


<!-- ================= UNIVERSITY AT A GLANCE ================= -->
<section class="glance-section">
    <div class="glance-overlay container-fluid">
        <div class="glance-container">
            <?php if( get_field('glance_heading') ): ?>
            <h2 class="glance-title"><?php echo get_field('glance_heading');?></h2>
            <?php endif; ?>

            <?php if(get_field('glance_description')): ?>
            <p class="glance-desc">
                <?php echo get_field('glance_description');?>
            </p>
            <?php endif; ?>
            <div class="glance-stats">
                <?php
                    if( have_rows('glance_stats') ):
                        while ( have_rows('glance_stats') ) : the_row(); ?>
                <div class="stat">
                    <div class="icon-box">
                        <img src="<?php echo get_sub_field('stats_icon');?>"
                            alt="<?php echo get_sub_field('stats_label');?>">
                    </div>
                    <div class="stat-text">
                        <span class="num count"
                            data-target="<?php echo preg_replace('/[^0-9]/', '', get_sub_field('stats_number')); ?>"
                            data-suffix="<?php echo strpos(get_sub_field('stats_number'), '+') !== false ? '+' : ''; ?>">
                            0
                        </span>

                        <span class="label"><?php echo get_sub_field('stats_label');?></span>
                    </div>
                </div>
                <?php endwhile;
                    endif;
                ?>
            </div>
        </div>
    </div>
</section>

<!-- ================= VICE CHANCELLOR DESK ================= -->
<section class="vc-section">
    <div class="vc-container">
        <!-- LEFT IMAGE (Slider) -->
        <div class="vc-image">
            <div class="vc-slider" aria-roledescription="carousel">
                <div class="vc-slider-track">
                    <?php if(have_rows('vc_slider_image')): 
                        while(have_rows('vc_slider_image')): the_row();?>
                    <div class="vc-slide">
                        <img src="<?php echo get_sub_field('vc_images'); ?>" alt="Vice Chancellor">
                    </div>
                    <?php endwhile; endif; ?>
                </div>
            </div>
        </div>

        <!-- RIGHT CONTENT -->
        <div class="vc-content">
            <h3><?php echo get_field('vc_desk_heading'); ?></h3>

            <?php if(get_field('vc_desk_content')): ?>
            <p class="vc-text">
                <?php echo get_field('vc_desk_content');?>
            </p>
            <?php endif; ?>

            <div class="vc-btn-wrap">
                <?php $link = get_field('vc_button_text'); 
                if( $link ): ?>
                <a href="<?php echo esc_url($link['url']); ?>"
                    target="<?php echo esc_attr($link['target'] ?: '_self'); ?>" class="vc-btn">
                    <?php echo esc_html($link['title']); ?>
                </a>
                <?php endif; ?>
            </div>
        </div>

    </div>
</section>

<!-- ================= INFO SECTION ================= -->
<section class="info-section">
    <div class="info-container">

        <!-- ================= CARD 1 ================= -->
        <div class="info-col">
            <div class="info-card">
                <h3 class="info-title">Announcement</h3>
                <div class="info-scroll">
                    <?php if ( !empty($announcement_notices) ) : ?>
                    <?php foreach ( $announcement_notices as $an ) : $href = get_notice_href($an);
                    if (filter_var($href, FILTER_VALIDATE_URL)) {
                        $final_url = $href;
                    } else {
                        $final_url = $media_base . $href;
                    }
                    ?>
                    <a href="<?php echo esc_url($final_url); ?>" class="info-item" target="_blank"
                        rel="noopener noreferrer"><?php echo esc_html($an['title']); ?></a>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <span class="info-item" style="color:#777;">No announcements found.</span>
                    <?php endif; ?>
                </div>
            </div>
            <a href="/notices/?category=Announcement" class="info-btn orange">
                View All Announcements
                <span class="arrow-icon">
                    <svg viewBox="0 0 24 24">
                        <line x1="5" y1="12" x2="19" y2="12" />
                        <polyline points="12 5 19 12 12 19" />
                    </svg>
                </span>
            </a>
        </div>

        <!-- ================= CARD 2 ================= -->
        <div class="info-col">
            <div class="info-card">
                <h3 class="info-title">Events</h3>
                <div class="info-scroll">
                    <?php if ( !empty($event_notices) ) : ?>
                    <?php foreach ( $event_notices as $en ) : 
                    $href = get_notice_href($en);
                    if (filter_var($href, FILTER_VALIDATE_URL)) {
                        $final_url = $href;
                    } else {
                        $final_url = $media_base . $href;
                    }
                    ?>
                    <a href="<?php echo esc_url($final_url); ?>" class="info-item" target="_blank"
                        rel="noopener noreferrer"><?php echo esc_html($en['title']); ?></a>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <span class="info-item" style="color:#777;">No events found.</span>
                    <?php endif; ?>
                </div>
            </div>
            <a href="/notices/?category=Event" class="info-btn dark">
                View All Events
                <span class="arrow-icon">
                    <svg viewBox="0 0 24 24">
                        <line x1="5" y1="12" x2="19" y2="12" />
                        <polyline points="12 5 19 12 12 19" />
                    </svg>
                </span>
            </a>
        </div>

        <!-- ================= CARD 3 ================= -->
        <div class="info-col">
            <div class="info-card">
                <h3 class="info-title">Appointments</h3>
                <div class="info-scroll">
                    <?php if ( !empty($appointment_notices) ) : ?>
                    <?php foreach ( $appointment_notices as $ap ) : $href = get_notice_href($ap);
                    if (filter_var($href, FILTER_VALIDATE_URL)) {
                        $final_url = $href;
                    } else {
                        $final_url = $media_base . $href;
                    }
                    ?>
                    <a href="<?php echo esc_url($final_url); ?>" class="info-item" target="_blank"
                        rel="noopener noreferrer"><?php echo esc_html($ap['title']); ?></a>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <span class="info-item" style="color:#777;">No appointments found.</span>
                    <?php endif; ?>
                </div>
            </div>
            <a href="/career/" class="info-btn orange">
                View All Appointments
                <span class="arrow-icon">
                    <svg viewBox="0 0 24 24">
                        <line x1="5" y1="12" x2="19" y2="12" />
                        <polyline points="12 5 19 12 12 19" />
                    </svg>
                </span>
            </a>
        </div>

        <!-- ================= CARD 4 ================= -->
        <div class="info-col">
            <div class="info-card">
                <h3 class="info-title">Tenders</h3>
                <div class="info-scroll">
                    <?php if ( !empty($tender_notices) ) : ?>
                    <?php foreach ( $tender_notices as $tn ) : $href = get_notice_href($tn);
                    if (filter_var($href, FILTER_VALIDATE_URL)) {
                        $final_url = $href;
                    } else {
                        $final_url = $media_base . $href;
                    }
                    ?>
                    <a href="<?php echo esc_url($final_url); ?>" class="info-item" target="_blank"
                        rel="noopener noreferrer"><?php echo esc_html($tn['title']); ?></a>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <span class="info-item" style="color:#777;">No tenders found.</span>
                    <?php endif; ?>
                </div>
            </div>
            <a href="/notices/?category=Tenders" class="info-btn dark">
                View All Tenders
                <span class="arrow-icon">
                    <svg viewBox="0 0 24 24">
                        <line x1="5" y1="12" x2="19" y2="12" />
                        <polyline points="12 5 19 12 12 19" />
                    </svg>
                </span>
            </a>
        </div>

    </div>
</section>

<section class="auto-slider">
    <div class="auto-slider-container">

        <!-- start gap -->
        <div class="slider-gap"></div>

        <div class="slider-track">
            <?php if( have_rows('slider_image_section') ):
                while ( have_rows('slider_image_section') ) : the_row(); ?>

            <div class="slider-card">
                <img src="<?php echo get_sub_field('slider_images'); ?>">
            </div>
            <?php endwhile;
            endif; ?>
        </div>

        <!-- end gap -->
        <div class="slider-gap"></div>

    </div>
</section>
<?php 
get_footer();
?>