<?php
// Variables inherited from departmentsingle.php: $dept_data
$thrust_areas_html = isset($dept_data['thrust_areas']) ? $dept_data['thrust_areas'] : '';
?>

<!-- THRUST AREAS -->
<?php if (!empty($thrust_areas_html)): ?>
<div class="section" style="margin-top: 30px;">
    <h3>Thrust Areas</h3>
    <?php echo wp_kses_post($thrust_areas_html); ?>
</div>
<?php endif; ?>
