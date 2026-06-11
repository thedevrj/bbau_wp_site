<?php
// Variables inherited from centresingle.php: $centre_data
$head = isset($centre_data['head']) ? $centre_data['head'] : null;
$about_html = isset($centre_data['about']) ? $centre_data['about'] : '';
$media_base = getenv('DJANGO_MEDIA_URL');

?>

<!--  HOD CARD -->
<?php if ($head): ?>
<div class="head-card">
    <div class="head-left">
        <div class="avatar">
            <img src="<?php echo esc_url($media_base . $head['photo'] ); ?>" alt="HOD Photo">
        </div>
    </div>

    <?php $leadership_title = $centre_data['head_title'] ?: 'HOD'; ?>
    <div class="head-right">
        <div class="name"><?php echo esc_html($head['name']); ?></div>
        <div class="role"><?php echo ($leadership_title === 'HOD') ? 'Head of Centre' : 'Coordinator'; ?></div>

        <div class="contacts">
            <?php if(!empty($head['phone1'])): ?>
            <div class="contact-row">
                <span class="label">Phone:</span>
                <span class="icon"><i class="fa fa-phone" aria-hidden="true"></i></span>
                <span class="value">
                    <a href="tel:<?php echo esc_html($head['phone1']); ?>"><?php echo esc_html($head['phone1']); ?></a></span>
            </div>
            <?php endif; ?>

            <?php if(!empty($head['phone2'])): ?>
            <div class="contact-row">
                <span class="label">Phone:</span>
                <span class="icon"><i class="fa fa-phone" aria-hidden="true"></i></span>
                <span class="value">
                    <a href="tel:<?php echo esc_html($head['phone2']); ?>"><?php echo esc_html($head['phone2']); ?></a></span>
            </div>
            <?php endif; ?>

            <?php if(!empty($head['insti_email'])): ?>
            <div class="contact-row">
                <span class="label">Email:</span>
                <span class="icon"><i class="fa fa-envelope" aria-hidden="true"></i></span>
                <span class="value">
                    <a
                        href="mailto:<?php echo esc_attr($head['insti_email']); ?>"><?php echo esc_html($head['insti_email']); ?></a>
                </span>
            </div>
            <?php endif; ?>

            <?php if(!empty($head['other_email'])): ?>
            <div class="contact-row">
                <span class="label">Email:</span>
                <span class="icon"><i class="fa fa-envelope" aria-hidden="true"></i></span>
                <span class="value">
                    <a
                        href="mailto:<?php echo esc_attr($head['other_email']); ?>"><?php echo esc_html($head['other_email']); ?></a>
                </span>
            </div>
            <?php endif; ?>

            <?php 
            /* 
              // FALLBACK CONTACT LOGIC
               If no HOD phone/email exists, show department contacts instead.
               
               if(empty($head['phone1']) && empty($head['insti_email']) && !empty($centre_data['contact_phone'])) {
                    echo '<div class="contact-row fallback">';
                    echo '<span class="label">Dept:</span>';
                    echo '<span class="value">' . esc_html($centre_data['contact_phone']) . '</span>';
                    echo '</div>';
               }
            */
            ?>
        </div>
    </div>
</div>
<?php endif; ?>

<!--  INTRODUCTION -->
<?php if (!empty($about_html)): ?>
<div class="section">
    <h3>Introduction of the Centre</h3>
    <?php echo wp_kses_post($about_html); ?>
</div>
<?php endif; ?>