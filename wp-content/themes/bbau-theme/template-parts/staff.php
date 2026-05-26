<?php
/* Template Name: Staff Page */

get_header();
?>

<?php get_template_part('banners/about-banner'); ?>

<section class="container-fluid page-bg page-template-about-bg py-5 overflow-hidden">

<?php get_template_part('template-parts/breadcrumb'); ?>

<div class="staff-page">
<div class="container">

<!-- MENU -->
<?php get_template_part('menu/menu'); ?>

<!-- TITLE -->
<h2 class="staff-title">
<?php
if(get_field('heading')){
the_field('heading');
}else{
the_title();
}
?>
</h2>

<!-- GRID -->
<div class="staff-grid">

<?php if(have_rows('staff_list')): ?>
<?php while(have_rows('staff_list')): the_row(); ?>

<div class="staff-card">

<!-- BAND -->
<div class="staff-band"></div>

<!-- AVATAR -->
<div class="staff-avatar-wrap">
<?php
$photo = get_sub_field('image');
if($photo):
$img_url = is_array($photo) ? $photo['url'] : $photo;
?>
<div class="staff-circle">
<img src="<?php echo esc_url($img_url); ?>" alt="">
</div>
<?php else: ?>
<div class="staff-circle staff-circle-av">
<?php echo strtoupper(substr(get_sub_field('name'), 0, 1)); ?>
</div>
<?php endif; ?>
</div>

<!-- BODY -->
<div class="staff-body">

<div class="staff-name">
<?php the_sub_field('name'); ?>
</div>

<div class="staff-badge">
<?php the_sub_field('designation'); ?>
</div>

<div class="staff-info">
<i class="fa-solid fa-envelope"></i>
<a class="link-new" href="mailto:<?php the_sub_field('email'); ?>">
<?php the_sub_field('email'); ?>
</a>
</div>

<div class="staff-info">
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
</div>
</div>
</section>

<style>

/* ================= PAGE ================= */

.staff-page{
padding:10px 20px;
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
margin-bottom:30px;
}

/* GRID */

.staff-grid{
display:grid;
grid-template-columns:repeat(5,1fr);
gap:20px;
}

/* CARD */

.staff-card{
background:#fff;
border-radius:14px;
border:1px solid #eee;
overflow:hidden;
transition:transform .2s,box-shadow .2s;
}

.staff-card:hover{
transform:translateY(-4px);
box-shadow:0 8px 22px rgba(0,0,0,.08);
}

/* BAND */

.staff-band{
height:70px;
background:#853030;
}

/* AVATAR WRAP */

.staff-avatar-wrap{
display:flex;
justify-content:center;
margin-top:-30px;
margin-bottom:8px;
}

/* CIRCLE */

.staff-circle{
width:100px;
height:100px;
border-radius:50%;
overflow:hidden;
border:3px solid #fff;
}

.staff-circle img{
width:100%;
height:100%;
object-fit:cover;
display:block;
}

/* AVATAR FALLBACK */

.staff-circle-av{
width:60px;
height:60px;
border-radius:50%;
background:#8b3a1c;
border:3px solid #fff;
display:flex;
align-items:center;
justify-content:center;
color:#fff;
font-size:22px;
font-weight:600;
}

/* BODY */

.staff-body{
padding:0 16px 18px;
display:flex;
flex-direction:column;
align-items:center;
gap:6px;
text-align:center;
}

/* NAME */

.staff-name{
font-size:15px;
font-weight:700;
color:#1b1b1b;
line-height:1.3;
}

/* BADGE */

.staff-badge{
padding:4px 14px;
background:#fbe7df;
color:#8b3a1c;
border-radius:30px;
font-size:12px;
width:fit-content;
max-width:100%;
}

/* INFO */

.staff-info{
display:flex;
align-items:center;
gap:7px;
font-size:13px;
}

/* ICON */

.staff-info i{
color:#853030;
font-size:13px;
flex-shrink:0;
}

/* LINK */

.staff-info a{
text-decoration:none;
color:#004aad;
word-break:break-all;
line-height:1.4;
}

.staff-info a:hover{
text-decoration:underline;
}

/* 1300px */

@media(max-width:1300px){
.staff-grid{
grid-template-columns:repeat(3,1fr);
}
}

/* TABLET */

@media(max-width:992px){
.staff-grid{
grid-template-columns:repeat(2,1fr);
}
}

/* MOBILE */

@media(max-width:540px){
.staff-grid{
grid-template-columns:1fr;
}
}

</style>

<?php get_footer(); ?>