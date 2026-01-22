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

<body <?php body_class(); ?>>
<?php astra_body_top(); ?>

<!-- ================= TOP BAR ================= -->
<div class="top-bar">
  <div class="top-bar-container d-flex justify-content-between align-items-center">

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

      <img
        src="/wp-content/uploads/2026/01/H-E-converter.png"
        alt="Language Toggle"
        class="lang-img"
      >

      <div class="search-box d-flex align-items-center">
        <input type="text" placeholder="Search" aria-label="Search">
        <span class="search-icon">🔍</span>
      </div>
    </div>

  </div>
</div>



<!-- ================= MAIN HEADER ================= -->
<header class="main-header">
  <div class="header-inner d-flex align-items-center justify-content-between">

    <!-- LEFT BRAND -->
    <div class="d-flex align-items-center">

      <img
        src="/wp-content/uploads/2026/01/logo.png"
        class="logo me-2"
        alt="University Logo"
      >

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

      <!-- HOME ICON -->
      <a href="/" class="nav-home" aria-label="Home">
        <img
          src="/wp-content/uploads/2026/01/Home.jpg"
          alt="Home"
        >
      </a>

      <a href="#">About</a>
      <a href="#">Administration</a>
      <a href="#">Academics</a>
      <a href="#">Research</a>
      <a href="#">Admission</a>
      <a href="#">Amenities</a>
      <a href="#">Students</a>
    </nav>

    <!-- RIGHT IMAGE -->
    <div class="header-photo d-none d-lg-block">
      <img
        src="/wp-content/uploads/2026/01/ambedkar.png"
        alt="Dr. B. R. Ambedkar"
      >
    </div>

  </div>
</header>
<?php astra_header_after(); ?>
