<?php
/* Template Name: Staff Page */
get_header();
?>
<?php get_template_part('banners/about-banner'); ?>
<div class="staff-page">
    <div class="container">

        <h2 class="staff-title">
            <?php 
    if(get_field('heading')){
      the_field('heading');
    } else {
      the_title(); // fallback
    }
  ?>
        </h2>

        <div class="staff-grid">

            <?php if(have_rows('staff_list')): ?>
            <?php while(have_rows('staff_list')): the_row(); ?>

            <div class="staff-card">

                <div class="staff-left">
                    <?php 
  $photo = get_sub_field('image');

  if($photo): 

    // If Image return format = ARRAY
    if(is_array($photo)){
      $img_url = $photo['url'];
    } else {
      // If return format = URL
      $img_url = $photo;
    }
  ?>
                    <img src="<?php echo esc_url($img_url); ?>" alt="">
                    <?php else: ?>
                    <div class="staff-avatar">
                        <?php echo strtoupper(substr(get_sub_field('name'),0,1)); ?>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- RIGHT CONTENT -->
                <div class="staff-right">

                    <div class="staff-name">
                        <?php the_sub_field('name'); ?>
                    </div>

                    <div class="staff-designation">
                        <?php the_sub_field('designation'); ?>
                    </div>

                    <div class="staff-info email">
                        <i class="fa-solid fa-envelope"></i>
                        <?php the_sub_field('email'); ?>
                    </div>

                    <div class="staff-info phone">
                        <i class="fa-solid fa-phone"></i>
                        <?php the_sub_field('phone'); ?>
                    </div>

                </div>

            </div>

            <?php endwhile; ?>
            <?php else: ?>
            <p style="text-align:center;">No staff added yet</p>
            <?php endif; ?>

        </div>

    </div>
</div>

<style>
/* ================= PAGE ================= */
.staff-page {
    background: #f8f4f2;
    padding: 60px 20px;
    font-family: 'DM Sans', sans-serif;
}

.container {
    max-width: 1300px;
    margin: auto;
}

/* TITLE */
.staff-title {
    color: #853030;
}

/* GRID */
.staff-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 25px;
}

/* CARD */
.staff-card {
    display: flex;
    height: 180px;
    background: #ffffff;
    border-radius: 16px;
    overflow: hidden;
    border: 1px solid #eee;
    transition: 0.3s ease;
}

.staff-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
}

/* LEFT IMAGE */
.staff-left {
    width: 50%;
    height: 100%;
}

.staff-left img {
    width: 100%;
    height: 100%;
    object-fit: fill;
}

/* AVATAR */
.staff-avatar {
    width: 100%;
    height: 100%;
    background: #8b3a1c;
    color: #fff;
    font-size: 26px;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* RIGHT */
.staff-right {
    width: 50%;
    padding: 14px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    gap: 6px;
}

/* NAME */
.staff-name {
    font-size: 15px;
    font-weight: 600;
    color: #1a1a1a;
}

/* DESIGNATION */
.staff-designation {
    font-size: 11px;
    background: #fbe7df;
    color: #8b3a1c;
    padding: 4px 10px;
    border-radius: 20px;
    display: inline-block;
    width: fit-content;
}

/* INFO */
.staff-info {
    font-size: 11px;
    color: #555;
}

.staff-info.email {
    color: #444;
}

.staff-info.phone {
    color: #666;
}
.staff-info i {
  margin-right: 6px;
  color: #853030;
  font-size: 12px;
}
/* ================= RESPONSIVE ================= */
/* ================= LARGE SCREEN (≤1200px) ================= */
@media (max-width: 1200px) {
  .staff-grid {
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
  }
}

/* ================= LAPTOP / TABLET (≤1024px) ================= */
@media (max-width: 1024px) {
  .staff-grid {
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
  }
}

/* ================= TABLET SMALL (≤768px) ================= */
@media (max-width: 768px) {
  .staff-grid {
    grid-template-columns: repeat(2, 1fr);
  }

  .staff-card {
    height: 160px; /* slightly compact */
  }
}

/* ================= MOBILE (≤600px) ================= */
@media (max-width: 600px) {
  .staff-grid {
    grid-template-columns: 1fr;
  }

  .staff-card {
    flex-direction: column;
    height: auto;
  }

  .staff-left {
    width: 100%;
    height: 200px;
  }

  .staff-right {
    width: 100%;
  }
}

/* ================= SMALL MOBILE (≤400px) ================= */
@media (max-width: 400px) {
  .staff-title {
    font-size: 26px;
  }

  .staff-name {
    font-size: 13px;
  }

  .staff-info {
    font-size: 10px;
  }
}
</style>

<?php get_footer(); ?>