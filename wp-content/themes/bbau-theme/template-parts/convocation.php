<?php
/*
Template Name: Convocation Chronicle
*/

defined('ABSPATH') || exit;

get_header();
?>

<!-- Banner -->
<?php get_template_part('banners/about-banner'); ?>

<div class="container-fluid page-bg page-template-about-bg py-lg-5">

    <!-- Breadcrumb -->
    <?php get_template_part('template-parts/breadcrumb'); ?>

    <div class="container">

        <div class="convocation-wrap">

            <!-- ================= HERO ================= -->

            <div class="convocation-hero">

                <div class="convocation-top">

                    <div class="convocation-icon">
                        <i class="fa-solid fa-graduation-cap"></i>
                    </div>

                    <div>

                        <div class="convocation-subtitle">
                            Babasaheb Bhimrao Ambedkar University
                        </div>

                        <h1 class="convocation-title">
                            Convocation Chronicle
                        </h1>

                        <div class="convocation-year-line">
                            Celebrating Academic Excellence • 2015 – 2017
                        </div>

                    </div>

                </div>

            </div>

            <!-- ================= ABOUT ================= -->

            <div class="convocation-section">

                <div class="section-heading-wrap">
                    <h2 class="section-heading">About the Convocation</h2>
                </div>

                <p class="convocation-text">
                    The Annual Convocation of Babasaheb Bhimrao Ambedkar University is one of the most cherished milestones in a student’s academic journey. It is the day when years of dedication, perseverance and learning are formally recognised as graduates receive their degrees, diplomas and medals from distinguished national leaders and dignitaries.
                </p>

                <div class="convocation-main-image">
                    <img src="https://images.unsplash.com/photo-1523050854058-8df90110c9f1?q=80&w=1200&auto=format&fit=crop"
                         alt="Convocation">
                </div>

            </div>

            <!-- ================= 2017 ================= -->

            <div class="convocation-year-section">

                <div class="year-banner">

                    <div class="year-number">
                        2017
                    </div>

                    <div>

                        <div class="year-badge">
                            Chief Guest
                        </div>

                        <div class="year-name">
                            Hon’ble President of India
                        </div>

                        <div class="year-role">
                            Shri Ram Nath Kovind
                        </div>

                    </div>

                </div>

                <div class="convocation-grid">

                    <div class="convocation-card big-card">

                        <img src="https://images.unsplash.com/photo-1523580846011-d3a5bc25702b?q=80&w=1200&auto=format&fit=crop"
                             alt="2017">

                        <div class="card-caption">
                            Degree Conferral Ceremony
                        </div>

                    </div>

                    <div class="side-grid">

                        <div class="convocation-card small-card">

                            <img src="https://images.unsplash.com/photo-1513258496099-48168024aec0?q=80&w=1200&auto=format&fit=crop"
                                 alt="2017">

                            <div class="card-caption">
                                Award Ceremony
                            </div>

                        </div>

                        <div class="convocation-card small-card">

                            <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?q=80&w=1200&auto=format&fit=crop"
                                 alt="2017">

                            <div class="card-caption">
                                Presidential Address
                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <!-- ================= 2016 ================= -->

            <div class="convocation-year-section">

                <div class="year-banner">

                    <div class="year-number">
                        2016
                    </div>

                    <div>

                        <div class="year-badge">
                            Chief Guest
                        </div>

                        <div class="year-name">
                            Shri Narendra Modi
                        </div>

                        <div class="year-role">
                            Prime Minister of India
                        </div>

                    </div>

                </div>

                <div class="two-grid">

                    <div class="convocation-card medium-card">

                        <img src="https://images.unsplash.com/photo-1498243691581-b145c3f54a5a?q=80&w=1200&auto=format&fit=crop"
                             alt="2016">

                        <div class="card-caption">
                            PM Addressing Students
                        </div>

                    </div>

                    <div class="convocation-card medium-card">

                        <img src="https://images.unsplash.com/photo-1511578314322-379afb476865?q=80&w=1200&auto=format&fit=crop"
                             alt="2016">

                        <div class="card-caption">
                            Medal Distribution
                        </div>

                    </div>

                </div>

            </div>

            <!-- ================= 2015 ================= -->

            <div class="convocation-year-section">

                <div class="year-banner">

                    <div class="year-number">
                        2015
                    </div>

                    <div>

                        <div class="year-badge">
                            Annual Convocation
                        </div>

                        <div class="year-name">
                            Distinguished Guest of Honour
                        </div>

                        <div class="year-role">
                            BBAU Lucknow
                        </div>

                    </div>

                </div>

                <div class="two-grid">

                    <div class="convocation-card medium-card">

                        <img src="https://images.unsplash.com/photo-1517486808906-6ca8b3f04846?q=80&w=1200&auto=format&fit=crop"
                             alt="2015">

                        <div class="card-caption">
                            Academic Procession
                        </div>

                    </div>

                    <div class="convocation-card medium-card">

                        <img src="https://images.unsplash.com/photo-1524178232363-1fb2b075b655?q=80&w=1200&auto=format&fit=crop"
                             alt="2015">

                        <div class="card-caption">
                            Degree Award Ceremony
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<style>

/* ================= WRAP ================= */

.convocation-wrap{
    background:#fff;
    border-radius:20px;
    overflow:hidden;
    box-shadow:0 5px 30px rgba(0,0,0,.08);
}

/* ================= HERO ================= */

.convocation-hero{
    background:linear-gradient(135deg,#081a35,#0e2b57);
    padding:60px;
}

.convocation-top{
    display:flex;
    align-items:center;
    gap:20px;
}

.convocation-icon{
    width:80px;
    height:80px;
    border-radius:50%;
    background:rgba(255,255,255,.08);
    display:flex;
    align-items:center;
    justify-content:center;
    border:1px solid rgba(255,255,255,.2);
    flex-shrink:0;
}

.convocation-icon i{
    color:#d4af37;
    font-size:34px;
}

.convocation-subtitle{
    color:#d4af37;
    letter-spacing:2px;
    font-size:13px;
    margin-bottom:8px;
    text-transform:uppercase;
}

.convocation-title{
    color:#fff;
    font-size:48px;
    font-weight:700;
    margin-bottom:10px;
    line-height:1.2;
}

.convocation-year-line{
    color:rgba(255,255,255,.7);
    font-size:15px;
}

/* ================= SECTIONS ================= */

.convocation-section,
.convocation-year-section{
    padding:45px;
}

.convocation-year-section + .convocation-year-section{
    border-top:1px solid #f0ece0;
}

.section-heading-wrap{
    display:flex;
    align-items:center;
    gap:12px;
    margin-bottom:20px;
}

.section-heading-wrap::before{
    content:'';
    width:5px;
    height:28px;
    background:#d4af37;
    border-radius:3px;
}

.section-heading{
    font-size:28px;
    font-weight:700;
    margin:0;
}

.convocation-text{
    font-size:16px;
    line-height:1.9;
    color:#444;
    margin-bottom:30px;
}

/* ================= MAIN IMAGE ================= */

.convocation-main-image img{
    width:100%;
    height:450px;
    object-fit:cover;
    border-radius:18px;
    display:block;
}

/* ================= YEAR BANNER ================= */

.year-banner{
    background:#0e2b57;
    border-radius:18px;
    padding:25px 30px;
    display:flex;
    align-items:center;
    gap:25px;
    margin-bottom:25px;
}

.year-number{
    font-size:70px;
    font-weight:700;
    color:#d4af37;
    line-height:1;
}

.year-badge{
    color:#d4af37;
    text-transform:uppercase;
    letter-spacing:2px;
    font-size:12px;
    margin-bottom:6px;
}

.year-name{
    color:#fff;
    font-size:26px;
    font-weight:700;
    line-height:1.3;
}

.year-role{
    color:#ddd;
    margin-top:5px;
    font-size:15px;
}

/* ================= GRID ================= */

.convocation-grid{
    display:grid;
    grid-template-columns:2fr 1fr;
    gap:20px;
}

.side-grid{
    display:flex;
    flex-direction:column;
    gap:20px;
}

.two-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:20px;
}

/* ================= CARD ================= */

.convocation-card{
    position:relative;
    overflow:hidden;
    border-radius:18px;
    background:#12223A;
}

.convocation-card img{
    width:100%;
    display:block;
    object-fit:cover;
    transition:transform .4s ease;
}

.convocation-card:hover img{
    transform:scale(1.04);
}

.big-card img{
    height:420px;
}

.small-card img{
    height:200px;
}

.medium-card img{
    height:300px;
}

.card-caption{
    position:absolute;
    left:0;
    right:0;
    bottom:0;
    padding:18px;
    color:#fff;
    font-weight:600;
    font-size:14px;
    background:linear-gradient(transparent, rgba(0,0,0,.8));
}

/* ================= RESPONSIVE ================= */

@media(max-width:991px){

    .convocation-grid,
    .two-grid{
        grid-template-columns:1fr;
    }

    .convocation-hero{
        padding:40px 25px;
    }

    .convocation-title{
        font-size:34px;
    }

    .convocation-section,
    .convocation-year-section{
        padding:25px;
    }

    .big-card img{
        height:280px;
    }

    .medium-card img{
        height:220px;
    }
}

@media(max-width:576px){

    .convocation-top{
        flex-direction:column;
        text-align:center;
    }

    .year-banner{
        flex-direction:column;
        text-align:center;
    }

    .year-number{
        font-size:52px;
    }

    .convocation-title{
        font-size:28px;
    }

    .section-heading{
        font-size:22px;
    }

    .convocation-main-image img{
        height:220px;
    }
}

</style>

<?php get_footer(); ?>