<?php
/**
 * Footer template for Astra Theme
 *
 * @package Astra
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<footer class="site-footer bg-light border-top mt-4">
	<div class="container-xxl py-3">
		<div class="row align-items-center text-center text-md-start">

			<!-- LEFT -->
			<div class="col-md-6 mb-2 mb-md-0">
				<p class="mb-0 small">
					© <?php echo date('Y'); ?>  
					<strong>Babasaheb Bhimrao Ambedkar University</strong>
				</p>
			</div>

			<!-- RIGHT -->
			<div class="col-md-6 text-md-end">
				<p class="mb-0 small">
					Designed & Developed by  
					<span class="fw-semibold">Web Team, BBAU</span>
				</p>
			</div>

		</div>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
