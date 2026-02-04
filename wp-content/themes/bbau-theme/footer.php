<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package BBAU_Theme
 */
// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>


<!-- ================= FOOTER ================= -->
<footer class="site-footer">
 <div class="footer-inner">
    <div class="container">
        <div class="row footer-main">

            <!-- COLUMN 1 -->
            <div class="col-xl-2 col-lg-3 col-md-6 col-sm-12 footer-col">
                <h4>University</h4>
				<?php
               wp_nav_menu(array(
                   'theme_location' => 'footer_university_menu',
                   'menu_class'     => 'p-0 m-0 list-unstyled hide-list',
                   'container'      => false,
                   'link_before'    => '',
                   'link_after'     => '',
                   'fallback_cb'    => false,
                   'depth'          => 1,
               ));
               ?>
            </div>

            <!-- COLUMN 2 -->
            <div class="col-xl-2 col-lg-3 col-md-6 col-sm-12 footer-col">
                <h4>Quick Links</h4>
                <?php
               wp_nav_menu(array(
                   'theme_location' => 'quick_links_1',
                   'menu_class'     => 'p-0 m-0 list-unstyled hide-list',
                   'container'      => false,
                   'link_before'    => '',
                   'link_after'     => '',
                   'fallback_cb'    => false,
                   'depth'          => 1,
               ));
               ?>
            </div>

            <!-- COLUMN 3 -->
            <div class="col-xl-2 col-lg-3 col-md-6 col-sm-12 footer-col">
                <h4>Quick Links</h4>
                <?php
               wp_nav_menu(array(
                   'theme_location' => 'quick_links_2',
                   'menu_class'     => 'p-0 m-0 list-unstyled hide-list',
                   'container'      => false,
                   'link_before'    => '',
                   'link_after'     => '',
                   'fallback_cb'    => false,
                   'depth'          => 1,
               ));
               ?>
            </div>

            <!-- COLUMN 4 -->
            <div class="col-xl-6 col-lg-3 col-md-6 col-sm-12 footer-col footer-contact">
                <h4>Babasaheb Bhimrao Ambedkar University</h4>
                <p class="text-center">
                    Vidya Vihar, Raebareli Road,<br>
                    Lucknow, Uttar Pradesh - 226025<br>
                    Toll Free: <a href="tel:18001805789">1800-180-5789</a><br>
                    Email: <a href="mailto:info@bbau.ac.in">info@bbau.ac.in</a>
                </p>
                <h6><strong>Emergency Numbers:</strong></h6>
                <p class="footer-emergency">
                    Police: <a href="tel:0512-259-7309">0512-259-7309</a><br>
                    Health Center: <a href="tel:0512-259-7777">0512-259-7777</a><br>
                    Fire Station: <a href="tel:+919454418642">(+91) 9454418642</a>
                </p>
                <div class="footer-social">
                    <a target="_blank" href="https://www.facebook.com/bbauSocmedia/"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/social-media/facebook.png" alt="facebook"></a>
                    <a target="_blank" href="https://www.youtube.com/@bbaulucknow1866"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/social-media/youtube.png" alt="youtube"></a>
                    <a target="_blank" href="#"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/social-media/instagram.png" alt="instagram"></a>
                </div>
            </div>
        </div>

        </div>
    </div>

    <!-- BOTTOM BAR -->
    <div class="pb-4 footer-bottom">
		<span>
		<i class="icon-copyright2"></i> <?php echo date("Y"); ?> Computer Centre,<a href="/copyright-policy">Babasaheb Bhimrao Ambedkar University</a></span> |
		<a href="/disclainer">Disclaimer</a> |
        <a href="/help">Help</a>
    </div>

</footer>
</body>
</html>
