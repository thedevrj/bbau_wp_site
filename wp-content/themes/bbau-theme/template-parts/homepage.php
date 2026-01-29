<?php 
/*
Template name: Homepage Template
*/  
get_header();
defined( 'ABSPATH' ) || exit;
?>

<div class="container-fluid p-0 homepage-template">

    <?php
    // Start the Loop.
    if ( have_posts() ) :
        the_content();
    endif;
    ?>
</div>
<?php 
get_footer();
?>