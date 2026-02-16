<?php 
/*
Template Name: VC Template
*/
   
// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
get_header();
?>
<?php get_template_part('banners/about-banner'); ?>
<div class="container-fluid page-bg page-template-about-bg py-lg-5 overflow-hidden">
    <?php get_template_part('template-parts/breadcrumb'); ?>
    <section class="vc-hero-modern">
        <div class="vc-hero-container">

            <div class="vc-hero-card">

                <!-- Left Image -->
                <div class="vc-hero-image">
                    <div class="vc-image-wrapper">
                        <img src="http://localhost:8080/wp-content/uploads/2026/02/Image-Vice-Chancellor.png"
                            alt="Vice Chancellor">
                    </div>
                </div>

                <!-- Right Content -->
                <div class="vc-hero-content">
                    <h1>Prof. Raj Kumar Mittal</h1>
                    <p class="vc-designation">Vice-Chancellor</p>

                    <p class="vc-description">
                        Distinguished academician and visionary leader with over 30 years of
                        experience in higher education, research, and institutional development.
                        Committed to excellence, innovation, and holistic growth of students and faculty.
                    </p>

                    <div class="vc-contact">
                        <p>📧 vc@bbau.ac.in</p>
                        <p>📞 +91-522-2440621</p>
                        <p>📍 Vidya Vihar, Rae Bareli Road, Lucknow - 226025</p>
                    </div>

                </div>

            </div>

        </div>
    </section>

    <section class="vc-message">
        <div class="vc-container1">
            <h2>Message from the Vice Chancellor</h2>
            <div class="vc-message-box">
                <p>
                    Welcome to Babasaheb Bhimrao Ambedkar University, a premier institution of higher learning dedicated
                    to
                    shaping the minds of future leaders. As we strive for excellence in education, research and
                    innovations,
                    we remain focused on fostering a culture of innovation, inclusivity, and social responsibility
                    essential
                    to navigate the complexities of the 21st century and provide the opportunity to everyone to realize
                    one’s full potential. Dr. Ambedkar’s philosophy of social justice and equality serves as a beacon,
                    guiding us in carrying out our teaching, research and extension activities to build an inclusive
                    society
                    where diverse voices are heard and valued. Our focus is to develop the capabilities of our students
                    to
                    enable them to understand and analyse the ever-changing environment in which they shall be living
                    and
                    working for effective decision making while maintaining the higher domains of human values.This
                    shall
                    enable us to realize the potential benefits of Panchkosha based education of character building and
                    holistic personality development of students. Efforts would be to create and provide
                    platforms/opportunities for the students through which they can hone their personality and explore
                    the
                    best in them. We plan to establish different hobby/activity clubs like dance, drama, music,
                    photography,
                    literary etc. in which students will participate and cultivate the passion of their choice thus
                    enabling
                    them to convert their passion into profession at a later stage. My efforts would be to work for
                    strengthening the values such as freedom of enquiry and creativity , social justice & inclusiveness
                    ,
                    diversity , prudent management of resources, innovations & entrepreneurship, engaged learning and
                    giving
                    back to society. BBAU, is committed to unleash the transformative potential of NEP-2020 , which
                    envisions higher education to be flexible, multidisciplinary and outcome-oriented promoting
                    interdisciplinary learning, research & innovation and strengthening the link between Higher
                    Education
                    Institutions (HEIs) and industry. All our efforts would be made to ensure quality teaching,
                    impactful
                    research having capacity to address societal problems and outreach activities by strengthening
                    physical
                    infrastructure, upgrading laboratories, leveraging ICT in teaching-learning & administrative
                    activities
                    and creating commensurate ecosystems. Priority would be towards skill development by involving
                    industries in the process.</p>
                <p>
                    Friends, as we embark on this exciting journey, I urge each one of you to embrace the spirit of
                    innovation, entrepreneurship, and social responsibility and work together to create BBAU not only a
                    centre of excellence but also a catalyst for positive change in our society and make this world more
                    inclusive, fair and liveable.</p>
                <p>
                    I am sure with enthusiasm, active engagement, volunteering and advocacy for change by all
                    stakeholders,
                    we can make BBAU an institution known for its capacity to transform the society and contribute
                    towards
                    building a prosperous and great Bharat.
                    Together, we can make a difference!
                </p>
            </div>
        </div>
    </section>
    <!-- <section class="vc-video">
    <div class="vc-container1">
        <h2>Address by the Vice Chancellor</h2>
        <div class="video-wrapper">
            <iframe src="https://www.youtube.com/embed/VIDEO_ID" frameborder="0" allowfullscreen>
            </iframe>
        </div>
    </div>
</section> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>

    <section class="vc-gallery">
        <div class="vc-container1">
            <div class="swiper vcSwiper">

                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <iframe width="560" height="315"
                            src="https://www.youtube.com/embed/qYwO4PLd7jw?si=NpaGRBqWGbMRQeOF"
                            title="YouTube video player" frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                    </div>
                    <div class="swiper-slide">
                        <iframe width="560" height="315"
                            src="https://www.youtube.com/embed/qYwO4PLd7jw?si=NpaGRBqWGbMRQeOF"
                            title="YouTube video player" frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                    </div>
                    <div class="swiper-slide">
                        <iframe width="560" height="315"
                            src="https://www.youtube.com/embed/qYwO4PLd7jw?si=NpaGRBqWGbMRQeOF"
                            title="YouTube video player" frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                    </div>
                    <div class="swiper-slide">
                        <iframe width="560" height="315"
                            src="https://www.youtube.com/embed/qYwO4PLd7jw?si=NpaGRBqWGbMRQeOF"
                            title="YouTube video player" frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                    </div>
                    <div class="swiper-slide">
                        <iframe width="560" height="315"
                            src="https://www.youtube.com/embed/qYwO4PLd7jw?si=NpaGRBqWGbMRQeOF"
                            title="YouTube video player" frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                    </div>
                </div>
                <div class="swiper-pagination"></div>

            </div>
        </div>
        <div class="vc-container1">

            <h2>Photo Gallery</h2>
            <div class="swiper vcSwiper">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <img src="http://localhost:8080/wp-content/uploads/2026/02/Image-Vice-Chancellor.png" alt="">
                    </div>
                    <div class="swiper-slide">
                        <img src="http://localhost:8080/wp-content/uploads/2026/02/Image-Vice-Chancellor.png" alt="">
                    </div>
                    <div class="swiper-slide">
                        <img src="http://localhost:8080/wp-content/uploads/2026/02/Image-Vice-Chancellor.png" alt="">
                    </div>
                    <div class="swiper-slide">
                        <img src="http://localhost:8080/wp-content/uploads/2026/02/Image-Vice-Chancellor.png" alt="">
                    </div>
                    <div class="swiper-slide">
                        <img src="http://localhost:8080/wp-content/uploads/2026/02/Image-Vice-Chancellor.png" alt="">
                    </div>
                </div>
                <div class="swiper-pagination"></div>

            </div>
        </div>
    </section>
    <section class="vc-lecture">
        <div class="vc-container1">
            <h2>Eminent Lecture Series</h2>

            <div class="lecture-grid">
                <div class="lecture-card">
                    <h4>Bharat's Agenda for Socio-economic Development</h4>
                    <p>Date: 02 May 2025</p>
                    <iframe width="560" height="315" src="https://www.youtube.com/embed/qYwO4PLd7jw?si=NpaGRBqWGbMRQeOF"
                        title="YouTube video player" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                </div>

                <div class="lecture-card">
                    <h4>A Tail of two biotechnologies: </h4>
                    <p>Date: 21 May 2025</p>
                    <iframe width="560" height="315" src="https://www.youtube.com/embed/qYwO4PLd7jw?si=NpaGRBqWGbMRQeOF"
                        title="YouTube video player" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                </div>
                <div class="lecture-card">
                    <h4>Climate Change</h4>
                    <p>Date: 30 July 2025</p>
                    <iframe width="560" height="315" src="https://www.youtube.com/embed/qYwO4PLd7jw?si=NpaGRBqWGbMRQeOF"
                        title="YouTube video player" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                </div>

            </div>
    </section>
</div>
<?php get_footer(); ?>

<script>
var swiper = new Swiper(".vcSwiper", {
    spaceBetween: 20,
    loop: true,
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
    breakpoints: {
        1020: {
            slidesPerView: 3
        },
        768: {
            slidesPerView: 2
        },
        480: {
            slidesPerView: 1
        }
    }
});
</script>
<style>
/* ===== VC MODERN HERO ===== */
.vc-container1 {
    max-width: 1200px;
    margin: 0 auto;
    padding: 60px 20px;
}

.vc-hero-modern {
    padding: 60px 20px;
    background: #f4f6f9;
}

.vc-hero-container {
    max-width: 1200px;
    margin: 0 auto;
}

.vc-hero-card {
    position: relative;
    display: flex;
    align-items: center;
    gap: 60px;
    padding: 60px;
    border-radius: 30px;
    background: linear-gradient(135deg, #2ca7c9, #1f7fa5);
    color: #ffffff;
    overflow: hidden;
}

/* Diagonal Accent Overlay */
.vc-hero-card::before {
    content: "";
    position: absolute;
    left: -150px;
    top: 0;
    width: 400px;
    height: 100%;
    background: rgba(255, 255, 255, 0.08);
    transform: skewX(-20deg);
}

/* Image */
.vc-hero-image {
    flex: 0 0 280px;
    position: relative;
    z-index: 2;
}

.vc-image-wrapper {
    width: 260px;
    height: 260px;
    border-radius: 50%;
    padding: 10px;
    background: #ffffff;
}

.vc-image-wrapper img {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    object-fit: cover;
}

/* Content */
.vc-hero-content {
    position: relative;
    z-index: 2;
    max-width: 600px;
}

.vc-hero-content h1 {
    font-size: 32px;
    margin-bottom: 6px;
}

.vc-designation {
    font-size: 18px;
    font-weight: 600;
    margin-bottom: 18px;
}

.vc-description {
    font-size: 16px;
    line-height: 1.7;
    margin-bottom: 20px;
    opacity: 0.95;
}

.vc-contact p {
    margin: 6px 0;
    font-size: 15px;
}

/* Responsive */
@media (max-width: 992px) {
    .vc-hero-card {
        flex-direction: column;
        text-align: center;
        padding: 40px 20px;
    }

    .vc-hero-card::before {
        display: none;
    }

    .vc-hero-image {
        margin-bottom: 20px;
    }
}


.vc-message-box {
    background: #f4f6f9;
    padding: 30px;
    border-left: 4px solid #002855;
    border-radius: 8px;
    line-height: 1.8;
}

/* Video */
.video-wrapper iframe {
    width: 100%;
    aspect-ratio: 16/9;
    border-radius: 12px;
}

/* Swiper */
.swiper-slide img {
    width: 100%;
    border-radius: 10px;
}

/* Lecture Cards */
.lecture-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 24px;
}

.lecture-card {
    background: #fff;
    padding: 24px;
    border-radius: 12px;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
}

/* Responsive */
@media (max-width: 768px) {
    .vc-profile {
        flex-direction: column;
        text-align: center;
    }

    .lecture-grid {
        grid-template-columns: 1fr;
    }
}
</style>