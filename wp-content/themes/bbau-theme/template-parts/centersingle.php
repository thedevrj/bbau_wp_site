<?php
/*
Template Name: CIIE Page
*/
defined('ABSPATH') || exit;

get_header();
?>

<?php get_template_part('banners/about-banner'); ?>

<div class="ciie-page">

  <!-- BODY -->
  <div class="page-body">

    <!-- TOP SECTION -->
    <div class="top-section">

      <!-- LEFT: CARDS -->
      <div class="cards-column">

        <?php if (have_rows('members')): ?>
          <?php while (have_rows('members')): the_row(); ?>

            <div class="profile-card">

              <!-- IMAGE -->
              <div class="profile-photo">
                <img src="<?php echo get_sub_field('image')['url']; ?>" alt="">
              </div>

              <!-- CONTENT -->
              <div class="profile-content">

                <h3 class="profile-name"><?php echo get_sub_field('name'); ?></h3>
                <h6 class="profile-designation"><?php echo get_sub_field('designation'); ?></h6>

                <div class="profile-contacts">

                  <div class="contact-item">
                    <div class="contact-icon">📞</div>
                    <div>
                      <span class="contact-label">Phone</span>
                      <span class="contact-value"><?php echo get_sub_field('phone'); ?></span>
                    </div>
                  </div>

                  <div class="contact-item">
                    <div class="contact-icon">✉️</div>
                    <div>
                      <span class="contact-label">Email</span>
                      <span class="contact-value">
                        <a href="mailto:<?php echo get_sub_field('email'); ?>">
                          <?php echo get_sub_field('email'); ?>
                        </a>
                      </span>
                    </div>
                  </div>

                </div>

              </div>

            </div>

          <?php endwhile; ?>
        <?php endif; ?>

      </div>

      <!-- RIGHT: ABOUT -->
      <div class="side-text">
        <h3 class="section-title">About CIIE</h3>

        <?php echo get_field('about'); ?>
      </div>

    </div>

    <!-- FULL WIDTH -->
    <div class="full-width-section">
      <?php echo get_field('bottom_content'); ?>
    </div>

  </div>

</div>

<style>

/* ================= RESET ================= */
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

/* ================= PAGE ================= */
.ciie-page {
  background: #fdf9f4;
  font-family: 'Source Serif 4', serif;
  width: 100%;
}

/* ================= HEADER ================= */
.site-header {
  background: linear-gradient(135deg, #e8f4f8, #d0eaf5);
  border-bottom: 3px solid #8B0000;
  padding: 18px 40px;
  display: flex;
  align-items: center;
  gap: 15px;
}

.site-header .logo {
  width: 65px;
}

.site-header h1 {
  flex: 1;
  text-align: center;
  color: #8B0000;
  font-size: 22px;
  line-height: 1.3;
}

/* ================= MAIN CONTAINER ================= */
.page-body {
  width: 100%;
  padding: 30px 40px; /* fluid spacing */
}

/* ================= TOP SECTION ================= */
.top-section {
  display: flex;
  gap: 30px;
  align-items: flex-start;
}

/* LEFT COLUMN */
.cards-column {
  flex: 1;
  display: flex;
  flex-direction: column;
  gap: 20px;
}

/* RIGHT COLUMN */
.side-text {
  flex: 1;
}

/* SECTION TITLE */
.section-title {
  color: #8B0000;
  margin-bottom: 10px;
  font-size: 22px;
}

/* ================= CARD ================= */
.profile-card {
  display: flex;
  gap: 15px;
  background: #ffffff;
  padding: 15px;
  border-radius: 14px;
  border-left: 5px solid #8B0000;
  box-shadow: 0 6px 18px rgba(0,0,0,0.08);
  transition: 0.3s;
  width: 100%;
}

.profile-card:hover {
  transform: translateY(-4px);
}

/* IMAGE */
.profile-photo img {
  width: 170px;
  height: 180px;
  border-radius: 10px;
  object-fit: cover;
}

/* TEXT */
.profile-name {
  font-size: 24px;
  color: #8B0000;
  font-weight: 700;
}

.profile-designation {
  color: #c8a84b;
  margin-bottom: 6px;
}

/* CONTACT */
.contact-item {
  display: flex;
  gap: 8px;
  margin-top: 5px;
}

.contact-icon {
  width: 26px;
  height: 26px;
  background: #f5f0e8;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
}

/* ================= FULL WIDTH SECTION ================= */
/* SAME BACKGROUND FLOW */
.full-width-section {
  margin-top: 10px;
  padding: 0;
  background: transparent;
  width: 100%;
  line-height: 1.7;
}

/* ================= LARGE SCREEN ================= */
/* No extra padding for 1920 */
@media (min-width:1400px) {
  .page-body {
    padding: 30px 80px;
  }
}

/* ================= TABLET ================= */
@media (max-width:992px) {
  .top-section {
    flex-direction: column;
  }

  .page-body {
    padding: 25px 20px;
  }

  .cards-column,
  .side-text {
    width: 100%;
  }
}

/* ================= MOBILE ================= */
@media (max-width:768px) {

  .site-header {
    flex-direction: column;
    text-align: center;
    padding: 15px 20px;
  }

  .profile-card {
    flex-direction: column;
    text-align: center;
  }

  .profile-photo img {
    width: 100%;
    height: auto;
  }

  .page-body {
    padding: 20px 15px;
  }
}
</style>

<?php get_footer(); ?>