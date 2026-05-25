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

<!-- IMAGE -->
<div class="staff-left">

<?php

$photo=get_sub_field('image');

if($photo):

if(is_array($photo)){

$img_url=$photo['url'];

}else{

$img_url=$photo;

}

?>

<img src="<?php echo esc_url($img_url); ?>" alt="">

<?php else: ?>

<div class="staff-avatar">

<?php echo strtoupper(substr(get_sub_field('name'),0,1)); ?>

</div>

<?php endif; ?>

</div>


<!-- CONTENT -->

<div class="staff-right">

<div class="staff-name">

<?php the_sub_field('name'); ?>

</div>

<div class="staff-designation">

<?php the_sub_field('designation'); ?>

</div>

<div class="staff-info email pt-2">

<i class="fa-solid fa-envelope"></i>

<a
class="link-new"
href="mailto:<?php the_sub_field('email'); ?>">

<?php the_sub_field('email'); ?>

</a>

</div>


<div class="staff-info phone">

<i class="fa-solid fa-phone"></i>

<a
class="link-new"
href="tel:<?php the_sub_field('phone'); ?>">

<?php the_sub_field('phone'); ?>

</a>

</div>

</div>

</div>

<?php endwhile; ?>

<?php else: ?>

<p style="text-align:center;">

No staff added yet

</p>

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
margin-bottom:35px;
}

/* GRID */

.staff-grid{
display:grid;
grid-template-columns:repeat(4,1fr);
gap:25px;
}

/* CARD */

.staff-card{
display:flex;
background:#fff;
border-radius:18px;
overflow:hidden;
border:1px solid #eee;
transition:.3s;
min-height:220px;
}

.staff-card:hover{
transform:translateY(-5px);
box-shadow:0 10px 25px rgba(0,0,0,.08);
}

/* IMAGE */

.staff-left{
width:45%;
flex-shrink:0;
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
align-items:center;
justify-content:center;
color:#fff;
font-size:28px;
}

/* RIGHT */

.staff-right{
width:55%;
padding:18px;
display:flex;
flex-direction:column;
justify-content:center;
gap:10px;
overflow:hidden;
min-width:0;
}

/* NAME */

.staff-name{
font-size:18px;
font-weight:700;
line-height:1.4;
color:#1b1b1b;
word-break:break-word;
}

/* DESIGNATION */

.staff-designation{
padding:8px 16px;
background:#fbe7df;
color:#8b3a1c;
border-radius:30px;
font-size:13px;
width:fit-content;
max-width:100%;
}

/* INFO */

.staff-info{
display:flex;
align-items:flex-start;
gap:10px;
font-size:14px;
min-width:0;
}

/* ICON */

.staff-info i{
color:#853030;
margin-top:4px;
flex-shrink:0;
}

/* LINKS */

.staff-info a{
text-decoration:none;
color:#004aad;
display:block;
max-width:100%;
overflow-wrap:anywhere;
word-break:break-word;
line-height:1.5;
}

.staff-info a:hover{
text-decoration:underline;
}

/* DESKTOP */

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

@media(max-width:600px){

.staff-grid{
grid-template-columns:1fr;
}

.staff-card{
flex-direction:column;
}

.staff-left,
.staff-right{
width:100%;
}

.staff-left{
height:260px;
}

.staff-right{
padding:20px;
}

.staff-name{
font-size:20px;
}

.staff-info{
font-size:14px;
}

}

/* SMALL */

@media(max-width:420px){

.staff-right{
padding:16px;
}

.staff-name{
font-size:18px;
}

.staff-designation{
font-size:12px;
}

.staff-info{
font-size:13px;
}

}

</style>

<?php get_footer(); ?>