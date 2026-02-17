<?php
   /**
    * Template Name: Key Documents
    */
   
   // Exit if accessed directly.
   defined( 'ABSPATH' ) || exit;
   get_header();
   ?>
<main class="key-documents-page">
    <!-- Banner -->
    <?php get_template_part( 'banners/about-banner' ); ?>
    <!-- End Banner -->
    <div class="container-fluid py-lg-5 page-bg page-template-about-bg overflow-hidden">
        <?php get_template_part('template-parts/breadcrumb'); ?>
        <div class="container px-lg-3 px-0 py-4 max_xl_w_1280 position-relative">
            <div class="row py-lg-2 py-3">

                <div class="col-lg-12">
                    <h3 class="mb-3">Annual Reports</h3>

                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>S. No </th>
                                <th>Year</th>
                                <th>English Reports</th>
                                <th>Hindi Reports</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php if(have_rows('annual_reports')) :
                            $i=1; 
                            while (have_rows('annual_reports')) : the_row();
                            $year = get_sub_field('year');
                            $report_title = get_sub_field('reports_headings');
                            $english_reports = get_sub_field('english_reports');
                            $hindi_reports = get_sub_field('hindi_reports');
                            $new_tab = get_sub_field('new_tab');?>
                            <tr>
                                <td><?php echo $i++; ?></td>
                                <td><?php echo esc_html( $year ); ?></td>
                                <td>
                                    <?php  if($english_reports) : ?>
                                    <a class="link-new" target="<?php echo $new_tab ? '_blank' : '_self'; ?>"
                                        href="<?php echo esc_url( $english_reports ); ?>">
                                        <i class="icon-file-pdf1"></i>&nbsp;<?php echo $report_title; ?> (English)</a></td>
                                        <?php endif; ?>
                                <td>
                                    <?php if($hindi_reports) : ?>
                                     <a class="link-new" target="<?php echo $new_tab ? '_blank' : '_self'; ?>"
                                        href="<?php echo esc_url( $hindi_reports ); ?>">
                                        <i class="icon-file-pdf1"></i>&nbsp;<?php echo $report_title; ?> (Hindi)</a>
                                        <? endif; ?>
                                    
                                    </td>
                            </tr>
                            <?php
                        endwhile;
                        endif; ?>
                        </tbody>
                    </table>

                    <h3 class="mb-3">Newsletter BBAU</h3>

                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>S. No </th>
                                <th>Year</th>
                                <th>Newsletter Links</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(have_rows('bbau_newsletter')) :
                            $i=1; 
                            while (have_rows('bbau_newsletter')) : the_row();
                            $year = get_sub_field('year');
                            $newsletter_title = get_sub_field('newsletter_heading');
                            $newsletter_link = get_sub_field('newsletter_upload');
                            $new_tab = get_sub_field('new_tab');?>
                            <tr>
                                <td><?php echo $i++; ?></td>
                                <td><?php echo esc_html( $year ); ?></td>
                                <td><a class="link-new" target="<?php echo $new_tab ? '_blank' : '_self'; ?>"
                                        href="<?php echo esc_url( $newsletter_link ); ?>">
                                        <i class="icon-file-pdf1"></i>&nbsp;<?php echo $newsletter_title; ?></a></td>
                            </tr>
                            <?php
                        endwhile;
                        endif; ?>
                        </tbody>
                    </table>

                    <h3 class="mb-3">Research Journals</h3>

                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>S. No </th>
                                <th>Year</th>
                                <th>Research Journals Links</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(have_rows('journals')) :
                            $i=1; 
                            while (have_rows('journals')) : the_row();
                            $year = get_sub_field('year');
                            $report_title = get_sub_field('journal_title');
                            $journal_link = get_sub_field('journals');
                            $new_tab = get_sub_field('new_tab');?>
                            <tr>
                                <td><?php echo $i++; ?></td>
                                <td><?php echo esc_html( $year ); ?></td>
                                <td><a class="link-new" target="<?php echo $new_tab ? '_blank' : '_self'; ?>"
                                        href="<?php echo esc_url( $journal_link ); ?>">
                                        <i class="icon-file-pdf1"></i>&nbsp;<?php echo $report_title; ?></a></td>

                            </tr>
                            <?php
                        endwhile;
                        endif; ?>
                        </tbody>
                    </table>



                </div>
            </div>
        </div>
    </div>
</main>
<?php get_footer(); ?>