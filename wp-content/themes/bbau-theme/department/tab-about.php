<?php
// Variables inherited from departmentsingle.php: $dept_data
$hod = isset($dept_data['hod']) ? $dept_data['hod'] : null;
$about_html = isset($dept_data['about']) ? $dept_data['about'] : '';
$media_base = getenv('DJANGO_MEDIA_URL');

?>

<!--  HOD CARD -->
<?php if ($hod): ?>
<div class="hod-card">
    <div class="hod-left">
        <div class="avatar">
            <img src="<?php echo esc_url($media_base . $hod['photo'] ); ?>" alt="HOD Photo">
        </div>
    </div>

    <div class="hod-right">
        <div class="name"><?php echo esc_html($hod['name']); ?></div>
        <div class="role"> <?php echo esc_html($hod['designation'] ); ?></div>

        <div class="contacts">
            <?php if(!empty($hod['phone1'])): ?>
            <div class="contact-row">
                <span class="label">Phone:</span>
                <span class="icon">📞</span>
                <span class="value">
                    <a href="tel:<?php echo esc_html($hod['phone1']); ?>"><?php echo esc_html($hod['phone1']); ?></a></span>
            </div>
            <?php endif; ?>

            <?php if(!empty($hod['phone2'])): ?>
            <div class="contact-row">
                <span class="label">Phone:</span>
                <span class="icon">📞</span>
                <span class="value">
                    <a href="tel:<?php echo esc_html($hod['phone2']); ?>"><?php echo esc_html($hod['phone2']); ?></a></span>
            </div>
            <?php endif; ?>

            <?php if(!empty($hod['insti_email'])): ?>
            <div class="contact-row">
                <span class="label">Email:</span>
                <span class="icon">✉️</span>
                <span class="value">
                    <a
                        href="mailto:<?php echo esc_attr($hod['insti_email']); ?>"><?php echo esc_html($hod['insti_email']); ?></a>
                </span>
            </div>
            <?php endif; ?>

            <?php if(!empty($hod['other_email'])): ?>
            <div class="contact-row">
                <span class="label">Email:</span>
                <span class="icon">✉️</span>
                <span class="value">
                    <a
                        href="mailto:<?php echo esc_attr($hod['other_email']); ?>"><?php echo esc_html($hod['other_email']); ?></a>
                </span>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php endif; ?>

<!--  INTRODUCTION -->
<?php if (!empty($about_html)): ?>
<div class="section">
    <h3>Introduction of the Department</h3>
    <?php echo wp_kses_post($about_html); ?>
</div>
<?php endif; ?>