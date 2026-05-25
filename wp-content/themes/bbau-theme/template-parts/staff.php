<?php
/* Template Name: Staff Page */
get_header();
?>

<?php get_template_part('banners/about-banner'); ?>
<section class="container-fluid page-bg page-template-about-bg py-5 overflow-hidden">
    <?php get_template_part('template-parts/breadcrumb'); ?>

<div class="staff-page">
    <div class="container"> <!-- ✅ OPEN CONTAINER -->

        <!-- MENU -->
        <?php get_template_part('menu/menu'); ?>

        <!-- TITLE -->
        <h2 class="staff-title">
            <?php 
                if(get_field('heading')){
                    the_field('heading');
                } else {
                    the_title();
                }
            ?>
        </h2>

        <!-- STAFF GRID -->
        <div class="staff-grid">

            <?php if(have_rows('staff_list')): ?>
                <?php while(have_rows('staff_list')): the_row(); ?>

                    <div class="staff-card">

                        <!-- LEFT IMAGE -->
                        <div class="staff-left">
                            <?php 
                                $photo = get_sub_field('image');

                                if($photo): 
                                    if(is_array($photo)){
                                        $img_url = $photo['url'];
                                    } else {
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

                            <div class="staff-info email pt-2">
                                <i class="fa-solid fa-envelope"></i>
                                <a class="link-new" href="mailto:<?php the_sub_field('email'); ?>">
                                    <?php the_sub_field('email'); ?>
                                </a>
                            </div>

                            <div class="staff-info phone">
                                <i class="fa-solid fa-phone"></i>
                                <a class="link-new" href="tel:<?php the_sub_field('phone'); ?>">
                                    <?php the_sub_field('phone'); ?>
                                </a>
                            </div>

                        </div>

                    </div>

                <?php endwhile; ?>
            <?php else: ?>
                <p style="text-align:center;">No staff added yet</p>
            <?php endif; ?>

        </div>

    </div> <!-- ✅ CLOSE CONTAINER -->
</div>
<style>
/* ================= PAGE ================= */

.staff-page{
padding: 10px; 20px;
font-family:'DM Sans',sans-serif;
}

.staff-page .container{
max-width:1400px;
margin:auto;
padding-left:15px;
padding-right:15px;
}

/* TITLE */

.staff-title{
color:#853030;
margin-bottom:35px;
}

/* ================= GRID ================= */

.staff-grid{

display:grid;

grid-template-columns:
repeat(4,1fr);

gap:25px;

width:100%;

}

/* ================= CARD ================= */

.staff-card{

display:flex;

height:190px;

background:#ffffff;

border-radius:18px;

overflow:hidden;

border:1px solid #eeeeee;

transition:.3s;

}

.staff-card:hover{

transform:
translateY(-5px);

box-shadow:
0 10px 25px rgba(0,0,0,.08);

}

/* ================= IMAGE ================= */

.staff-left{

width:50%;

height:100%;

}

.staff-left img{

width:100%;

height:100%;

object-fit:cover;

display:block;

}

.staff-avatar{

width:100%;

height:100%;

background:#8b3a1c;

display:flex;

justify-content:center;

align-items:center;

color:#fff;

font-size:28px;

}

/* ================= CONTENT ================= */

.staff-right{

width:50%;

padding:16px;

display:flex;

flex-direction:column;

justify-content:center;

gap:8px;

}

/* NAME */

.staff-name{

font-size:18px;

font-weight:700;

color:#111827;

}

/* DESIGNATION */

.staff-designation{

display:inline-block;

width:fit-content;

padding:8px 16px;

border-radius:30px;

background:#fbe7df;

color:#8b3a1c;

font-size:13px;

}

/* INFO */

.staff-info{

font-size:13px;

display:flex;

align-items:center;

gap:8px;

}

.staff-info i{

color:#853030;

}

.staff-info a{

color:#004a99;

text-decoration:none;

word-break:break-word;

}

.staff-info a:hover{

text-decoration:underline;

}

/* ================= LARGE ================= */

@media(max-width:1300px){

.staff-grid{

grid-template-columns:
repeat(3,1fr);

}

}

/* ================= TABLET ================= */

@media(max-width:992px){

.staff-grid{

grid-template-columns:
repeat(2,1fr);

}

}

/* ================= MOBILE ================= */

@media(max-width:600px){

.staff-grid{

grid-template-columns:
1fr;

}

.staff-card{

flex-direction:column;

height:auto;

}

.staff-left{

width:100%;

height:220px;

}

.staff-right{

width:100%;

}

}

/* ================= SMALL MOBILE ================= */

@media(max-width:400px){

.staff-title{

font-size:28px;

}

.staff-name{

font-size:16px;

}

.staff-info{

font-size:12px;

}

}
</style>
<?php get_footer(); ?>