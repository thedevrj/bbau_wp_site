<?php
/**
 * Header for Astra Theme
 *
 * @package Astra
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>

    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@500&display=swap" rel="stylesheet">

    <?php wp_head(); ?>
</head>

<body>
    <!-- ================= TOP BAR ================= -->
    <div class="top-bar">
        <div class="container-xxl d-flex justify-content-between align-items-center">

            <!-- LEFT LINKS -->
            <div class="top-left d-flex gap-3 flex-wrap">
                <a href="#">Skip to main content</a>
                <a href="#">Faculty</a>
                <a href="#">Library</a>
                <a href="#">IQAC</a>
                <a href="#">Examination</a>
                <a href="#">Alumni</a>
                <a href="#">SamarthERP@BBAU</a>
                <a href="#">Accreditation</a>
                <a href="#">Login</a>
            </div>

            <!-- RIGHT CONTROLS -->
            <div class="top-right d-flex align-items-center gap-2">
                <span>A+</span>
                <span>A</span>
                <span>A-</span>

                <img src="/wp-content/uploads/2026/01/H-E-converter.png" alt="Language Toggle" class="lang-img">

                <div class="search-box">
                    <input type="text" placeholder="Search" aria-label="Search">
                    <span class="search-icon">🔍</span>
                </div>
            </div>

        </div>
    </div>

    <!-- ================= MAIN HEADER ================= -->
    <header class="main-header">
        <div class="container-xxl d-flex align-items-center justify-content-between position-relative">

            <!-- LEFT BRAND -->
            <div class="d-flex align-items-center">

                <img src="/wp-content/uploads/2026/01/logo.png" class="logo me-2" alt="University Logo">

                <div class="univ-name">
                    <div class="univ-hindi">
                        बाबासाहेब भीमराव अम्बेडकर विश्वविद्यालय
                    </div>

                    <div class="univ-english">
                        BABASAHEB BHIMRAO AMBEDKAR UNIVERSITY
                    </div>

                    <div class="univ-subtitle">
                        (A CENTRAL UNIVERSITY)
                    </div>
                </div>
            </div>

            <!-- NAVIGATION (DESKTOP) -->
            <nav class="header-nav d-none d-lg-flex">
                <ul class="menu">
                    <li>
                        <a href="/" class="nav-home" aria-label="Home">
                            <img src="/wp-content/uploads/2026/01/Home.jpg" alt="Home">
                        </a>
                    </li>
                    <!-- ABOUT (MEGA MENU) -->
                    <li class="dropdown mega">
                        <a href="#">About</a>

                        <div class="mega-menu">
                            <div class="mega-column">
                                <h6>ABOUT UNIVERSITY</h6>
                                <a href="#">Vision & Mission</a>
                                <a href="#">Act & Ordinances</a>
                                <a href="#">Former VCs</a>
                                <a href="#">Key Documents</a>
                                <a href="#">Accreditation & Ranking</a>
                                <a href="#">Kulgeet</a>
                                <a href="#">Map</a>
                                <a href="#">Seal</a>
                            </div>

                            <div class="mega-column">
                                <h6>UNIVERSITY GALLERYS</h6>
                                <a href="#">🏛 Event Gallery</a>
                                <a href="#">📰 Press/Media Gallery</a>
                                <a href="#">🎥 Video Gallery</a>
                            </div>
                        </div>
                    </li>

                    <!-- ADMINISTRATION -->
                    <li class="dropdown">
                        <a href="#">Administration</a>
                        <ul class="dropdown-menu">
                            <li><a href="#">Authorities</a></li>
                            <li><a href="#">Visitors</a></li>
                            <li><a href="#">Chancellor</a></li>
                            <li><a href="#">Vice Chancellor</a></li>
                            <li><a href="#">Registrar</a></li>
                            <li><a href="#">Finance Officer</a></li>
                            <li><a href="#">Controller Of Examination</a></li>
                            <li><a href="#">Dean Student Welfare</a></li>
                            <li><a href="#">Chief Proctor</a></li>
                            <li><a href="#">Chief Vigilance Officer</a></li>
                        </ul>
                    </li>

                    <!-- ACADEMICS -->
                    <li class="dropdown">
                        <a href="#">Academics</a>
                        <ul class="dropdown-menu">
                            <li><a href="#">Academic Affairs</a></li>
                            <li><a href="#">Programs</a></li>
                            <li><a href="#">Schools & Departments</a></li>
                            <li><a href="#">Satellite Centre (Amethi)</a></li>
                            <li><a href="#">Academic Calendar</a></li>
                            <li><a href="#">Holiday Calendar</a></li>
                            <li><a href="#">International Students</a></li>
                            <li><a href="#">Centres/Chairs</a></li>
                            <li><a href="#">Convocation</a></li>
                            <li><a href="#">Institutional Development Plan</a></li>
                            <li><a href="#">Downloads</a></li>
                        </ul>
                    </li>

                    <!-- RESEARCH -->
                    <li class="dropdown">
                        <a href="#">Research</a>
                        <ul class="dropdown-menu">
                            <li><a href="#">Research Areas</a></li>
                            <li><a href="#">Research Facilities</a></li>
                            <li><a href="#">Funded Research Project</a></li>
                            <li><a href="#">Patents</a></li>
                            <li><a href="#">Innovation & Partnership</a></li>
                            <li><a href="#">R&D Cell</a></li>
                        </ul>
                    </li>

                    <!-- ADMISSION -->
                    <li class="dropdown">
                        <a href="#">Admission </a>
                        <ul class="dropdown-menu">
                            <li><a href="#">UG Admission</a></li>
                            <li><a href="#">PG Admission</a></li>
                            <li><a href="#">Ph.D Admission</a></li>
                            <li><a href="#">Other Admission</a></li>
                            <li><a href="#">Admission Policy</a></li>
                            <li><a href="#">International Students</a></li>
                        </ul>
                    </li>

                    <!-- AMENITIES -->
                    <li class="dropdown">
                        <a href="#">Amenities</a>
                        <ul class="dropdown-menu">
                            <li><a href="#">Health Centre</a></li>
                            <li><a href="#">Computer Center</a></li>
                            <li><a href="#">Guest House</a></li>
                            <li><a href="#">Hostels</a></li>
                            <li><a href="#">Raj Bhasha Cell</a></li>
                            <li><a href="#">USIC</a></li>
                            <li><a href="#">Gender Cell</a></li>
                            <li><a href="#">Other Amenities</a></li>
                        </ul>
                    </li>

                    <!-- STUDENTS -->
                    <li class="dropdown">
                        <a href="#">Students</a>
                        <ul class="dropdown-menu long">
                            <li><a href="#">DSW</a></li>
                            <li><a href="#">Grievance Redressal</a></li>
                            <li><a href="#">Anti-Ragging</a></li>
                            <li><a href="#">Hostel Life</a></li>
                            <li><a href="#">Useful Forms</a></li>
                            <li><a href="#">Training & Placement</a></li>
                            <li><a href="#">Activities</a></li>
                            <li><a href="#">NSS</a></li>
                            <li><a href="#">NCC</a></li>
                            <li><a href="#">KBC / NAD Cell</a></li>
                            <li><a href="#">Counselling Centre</a></li>
                            <li><a href="#">Personality Centre</a></li>
                            <li><a href="#">Fellowship / Scholarship</a></li>
                            <li><a href="#">International Student Services</a></li>
                            <li><a href="#">SC/ST Cell</a></li>
                        </ul>
                    </li>

                </ul>

            </nav>


            <!-- RIGHT IMAGE -->
            <div class="header-photo d-none d-lg-block">
                <img src="/wp-content/uploads/2026/01/ambedkar.png" alt="Dr. B. R. Ambedkar">
            </div>

        </div>
    </header>
</body>

    <script>
    document.addEventListener("DOMContentLoaded", function() {

        if (window.innerWidth <= 991) {

            document.querySelectorAll(".dropdown > a").forEach(link => {
                link.addEventListener("click", function(e) {
                    e.preventDefault();
                    const submenu = this.nextElementSibling;
                    // Close other open menus
                    document.querySelectorAll(".dropdown-menu, .mega-menu").forEach(menu => {
                        if (menu !== submenu) {
                            menu.style.display = "none";
                        }
                    });
                    // Toggle current
                    submenu.style.display =
                        submenu.style.display === "block" ? "none" : "block";
                });
            });

        }

    });
    </script>