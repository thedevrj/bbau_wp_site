<?php
/*
Template Name: CIIE Page
*/
defined('ABSPATH') || exit;

get_header();
?>

<?php get_template_part('banners/about-banner'); ?>

<section class="container-fluid py-5">

<?php get_template_part('template-parts/breadcrumb'); ?>

<div class="container">

<div class="menu-wrapper">
<?php get_template_part('menu/menu'); ?>
</div>

<div class="top-section">

<!-- LEFT -->
<div class="cards-column">

<?php if(have_rows('members')): ?>
<?php while(have_rows('members')): the_row(); ?>

<div class="profile-card">

<div class="profile-photo">

<?php
$image=get_sub_field('image');
if($image):
?>

<img
src="<?php echo esc_url($image['url']); ?>"
alt="">

<?php endif; ?>

</div>

<div class="profile-content">

<h3 class="profile-name">
<?php echo get_sub_field('name'); ?>
</h3>

<h6 class="profile-designation">
<?php echo get_sub_field('designation'); ?>
</h6>

<div class="profile-contacts">

<?php if(get_sub_field('phone')): ?>

<div class="contact-item">

<div class="contact-icon">
<i class="fa-solid fa-phone"></i>
</div>

<div>

<span class="contact-label">
Phone:
</span>

<span class="contact-value">

<a href="tel:<?php echo get_sub_field('phone'); ?>">

<?php echo get_sub_field('phone'); ?>

</a>

</span>

</div>

</div>

<?php endif; ?>


<?php if(get_sub_field('email')): ?>

<div class="contact-item">

<div class="contact-icon">
<i class="fa-solid fa-envelope"></i>
</div>

<div>

<span class="contact-label">
Email:
</span>

<span class="contact-value">

<a href="mailto:<?php echo get_sub_field('email'); ?>">

<?php echo get_sub_field('email'); ?>

</a>

</span>

</div>

</div>

<?php endif; ?>

</div>

</div>

</div>

<?php endwhile; ?>
<?php endif; ?>

</div>

<!-- RIGHT -->

<div class="side-text">

<h3 class="section-title">
About
</h3>

<?php echo get_field('about'); ?>

</div>

</div>

<div class="full-width-section">

<?php echo get_field('bottom_content'); ?>

</div>

</div>

</section>

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
}

.container{
max-width:1200px;
margin:auto;
padding:0 20px;
}

.menu-wrapper{
margin-bottom:30px;
}

.top-section{
display:flex;
gap:40px;
align-items:flex-start;
}

.cards-column{
flex:1;
display:flex;
flex-direction:column;
gap:20px;
}

.side-text{
flex:1;
}

.section-title{
font-size:24px;
font-weight:700;
margin-bottom:20px;
color:#8B0000;
}

.profile-card{

background:#fff;

display:flex;

gap:20px;

padding:25px;

border-left:5px solid #8B0000;

border-radius:14px;

box-shadow:
0 6px 20px rgba(0,0,0,.08);

transition:.3s;

}

.profile-card:hover{
transform:translateY(-4px);
}

.profile-photo img{

width:180px;

height:180px;

border-radius:12px;

object-fit:cover;

}

.profile-content{
flex:1;
}

.profile-name{

font-size:22px;

font-weight:700;

color:#8B0000;

margin-bottom:8px;

}

.profile-designation{

font-size:15px;

color:#b18c31;

margin-bottom:15px;

}

.profile-contacts{

display:flex;

flex-direction:column;

gap:12px;

}

.contact-item{

display:flex;

gap:10px;

align-items:center;

}

.contact-icon{

width:34px;

height:34px;

background:#f6f1ea;

border-radius:50%;

display:flex;

justify-content:center;

align-items:center;

}

.contact-value a{

color:#333;

text-decoration:none;

}

.contact-value a:hover{

text-decoration:underline;

}

.full-width-section{

margin-top:40px;

line-height:1.8;

}

@media(max-width:992px){

.top-section{
flex-direction:column;
}

.cards-column,
.side-text{
width:100%;
}

}

@media(max-width:768px){

.profile-card{
flex-direction:column;
text-align:center;
}

.profile-photo img{

width:100%;

height:auto;

}

.contact-item{
justify-content:center;
}

}

@media(max-width:480px){

.container{
padding:0 12px;
}

.profile-card{
padding:18px;
}

.profile-name{
font-size:18px;
}

}

</style>

<?php get_footer(); ?>