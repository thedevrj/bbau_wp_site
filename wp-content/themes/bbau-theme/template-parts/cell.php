<?php
/*
Template Name: Cell Cards Page
*/

get_header();
?>

<!-- Banner -->
<?php get_template_part('banners/about-banner'); ?>

<section class="container-fluid page-bg page-template-about-bg py-5 overflow-hidden">
    <?php get_template_part('template-parts/breadcrumb'); ?>

<!-- Menu -->
<?php get_template_part('template-parts/page-menu'); ?>


<div class="container">

    <div class="cell-cards-wrapper">

        <?php if(have_rows('cell_items')): ?>

        <div class="cell-cards-grid">

            <?php while(have_rows('cell_items')): the_row();

$name=get_sub_field('cell_name');

$bg=get_sub_field('card_background_color');

$icon_bg=get_sub_field('icon_box_background_color');

$icon_color=get_sub_field('icon_color');

$hover=get_sub_field('button_hover_color');

$link=get_sub_field('view_more_link');

$bg=$bg?:'#F1EFE8';

$icon_bg=$icon_bg?:'#D3D1C7';

$icon_color=$icon_color?:'#2C2C2A';

$hover=$hover?:'#444441';

?>



            <div class="cell-card" style="
--bg:<?php echo esc_attr($bg); ?>;
--iconbg:<?php echo esc_attr($icon_bg); ?>;
--icon:<?php echo esc_attr($icon_color); ?>;
--hover:<?php echo esc_attr($hover); ?>;
">



                <div class="cell-icon">

                    <svg viewBox="0 0 24 24" fill="none" stroke="var(--icon)" stroke-width="2">

                        <circle cx="12" cy="12" r="10" />

                        <circle cx="12" cy="12" r="3" />

                    </svg>

                </div>



                <h3>

                    <?php echo esc_html($name); ?>

                </h3>



                <?php if($link): ?>

                <a href="<?php echo esc_url($link); ?>" class="view-btn">

                    View More

                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">

                        <line x1="5" y1="12" x2="19" y2="12" />

                        <polyline points="12 5 19 12 12 19" />

                    </svg>

                </a>

                <?php endif; ?>


            </div>



            <?php endwhile; ?>

        </div>

        <?php else: ?>

        <div class="empty">

            No Cards Added

        </div>

        <?php endif; ?>

    </div>

</div>

<style>
/* KEEP YOUR EXISTING CSS SAME */
.cell-cards-wrapper {

    padding: 60px 0;

}



.cell-cards-grid {

    display: grid;

    grid-template-columns:
        repeat(5, 1fr);

    gap: 18px;

}



.cell-card {

    background: var(--bg);

    padding: 22px;

    border-radius: 18px;

    display: flex;

    flex-direction: column;

    gap: 18px;

    transition: .3s;

    min-height: 220px;

}



.cell-card:hover {

    transform: translateY(-8px);

}



.cell-icon {

    width: 52px;

    height: 52px;

    background: var(--iconbg);

    border-radius: 12px;

    display: flex;

    justify-content: center;

    align-items: center;

}



.cell-icon svg {

    width: 26px;

    height: 26px;

}



.cell-card h3 {

    margin: 0;

    font-size: 18px;

    font-weight: 600;

    line-height: 1.5;

    color: #222;

    font-family:
        "Poppins",
        sans-serif;

}



.view-btn {

    margin-top: auto;

    display: inline-flex;

    align-items: center;

    gap: 8px;

    padding: 10px 18px;

    border-radius: 30px;

    background: #fff;

    text-decoration: none;

    font-size: 13px;

    font-weight: 600;

    color: #555;

    border: 1px solid rgba(0, 0, 0, .15);

    transition: .3s;

    width: fit-content;

}



.view-btn svg {

    width: 14px;

    height: 14px;

}



.view-btn:hover {

    background: var(--hover);

    color: #fff;

}



.empty {

    padding: 100px;

    text-align: center;

    font-size: 20px;

}



@media(max-width:1199px) {

    .cell-cards-grid {

        grid-template-columns:
            repeat(4, 1fr);

    }

}



@media(max-width:991px) {

    .cell-cards-grid {

        grid-template-columns:
            repeat(3, 1fr);

    }

}



@media(max-width:767px) {

    .cell-cards-grid {


    grid-template-columns:
            repeat(2, 1fr);

    }

}



@media(max-width:480px) {

    .cell-cards-grid {

        grid-template-columns:
            1fr;

    }

}
</style>


<?php get_footer(); ?>