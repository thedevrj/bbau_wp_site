<?php $page_id = get_the_Id(); ?>
<div class="container-fluid position-relative px-0 overflow-hidden">
    <img src="<?php echo get_field('desktop_1x', $page_id); ?>"
        srcset="<?php echo get_field('desktop_1x', $page_id); ?>"
        class="img-fluid d-lg-block d-none h_xl_250 object-fit-cover" alt="<?php the_title();?> Banner" width="100%" height="250">

    <!-- Mobile Image (only show if mobile_1x exists) -->
    <?php if(get_field('mobile_1x', $page_id)) : ?>
    <img src="<?php echo get_field('mobile_1x', $page_id); ?>" srcset="<?php echo get_field('mobile_1x', $page_id); ?> "
        class="img-fluid d-lg-none h_sm_204" alt="<?php the_title();?> Banner" width="100%" height="204">
    <?php endif; ?>
    <div class="container">
        <div class="row">
            <div class="col-lg-12 mt-lg-0 mt-md-5 pe-md-0 pe-5 subpage-hero-text position-absolute max_xl_w_498">
                <h1
                    class="d-block mt-0 mb-0 color_white text_medium sm_text_32 sm_line_height_38 text_40 line_height_48 text-capitalize me-lg-0 me-5 pe-lg-0 pe-5">
                    <?php the_title();?></h1>

            </div>
        </div>
    </div>
</div>
<div id="main-content"></div>