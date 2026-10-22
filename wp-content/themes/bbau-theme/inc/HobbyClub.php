<?php
/*
 Template Name: Hobby Club
 */

get_header();
$upload    = wp_get_upload_dir();
$chair_img = $upload['baseurl'] . '/2026/03/drsang.jpg';
$secy_img  = $upload['baseurl'] . '2026/03/Subhash-Photo.jpg';
$sop_links = array(
    array( 'label' => 'SoP of Hobby Club',                 'url' => '#' ),
    array( 'label' => 'Hobby Club Guidelines',             'url' => '#' ),
    array( 'label' => 'Hobby Club Registration Form',      'url' => '#' ),
);
$categories = array(
    array(
        'name'  => 'ARTS & EXPRESSION',
        'class' => 'hc-arts',
        'icon'  => '&#127912;',
        'courses' => array(
            array(1,  'Music', '', 'Prof Raj Shree , Dr. Siddharth Mukherjee', '8562988463, 7706844511', 'rajshree.dit@bbau.ac.in, butku9@gmail.com', '&#9835;'),
            array(3,  'Painting', '', 'Dr. Monica Sharma', '9717386785', 'monashimla@gmail.com', '&#127912;'),
            array(4,  'Photography', '', 'Dr Arvind Kumar', '8423221741', 'arvindbbau2@gmail.com', '&#128247;'),
            array(7,  'Creative Writing', '', 'Dr. Yusuf Akhter', '8263875486', 'dr.yusuf@bbau.ac.in', '&#9998;'),
            array(15, 'Prosody & Chanting', '(वाक्-कौशलम्: छन्द पर्व स्वर-साधना)', 'Dr. Ramesh Chandra Nailwal', '9773683877', 'rameshnailwal2035@gmail.com', '&#127908;'),
        ),
    ),
    array(
        'name'  => 'NATURE & GREEN CRAFTS',
        'class' => 'hc-nature',
        'icon'  => '&#127807;',
        'courses' => array(
            array(2,  'Urban Gardening', '', 'Dr. Ravi Shankar Verma', '9453966994', 'ravihort.009@gmail.com', '&#127793;'),
            array(14, 'Terrarium & Horticultural Craft', '', 'Dr Rubeelata', '9621067244', 'rubyhort@gmail.com', '&#127807;'),
            array(17, 'Eco Art Studio', '(Where Creativity Meets Sustainability)', 'Prof. Shalini Agarwal', '9411195938', 'drshaluagarwal@gmail.com', '&#9851;'),
            array(18, 'Apiculture', '(Buzz and Bloom)', 'Dr Neeshma Jaiswal', '8528794158', 'neeshma8feb@gmail.com', '&#128029;'),
            array(19, 'Aquarium & Fish Craft', '', 'Dr Sandhya Bharti', '9305008071', 'sandhyabharti54@gmail.com', '&#128031;'),
            array(20, 'Cocoon Craft', '', 'Prof Venkatesh Kumar', '9838616937', 'drvenkateshkumarr@gmail.com', '&#9986;'),
        ),
    ),
    array(
        'name'  => 'WELLNESS & BODY',
        'class' => 'hc-wellness',
        'icon'  => '&#10084;',
        'courses' => array(
            array(6,  'Yoga Therapy', '', 'Dr. Deepeshwar Singh', '9036367402', 'deepeshwar.singh@gmail.com', '&#129496;'),
            array(9,  'Mental Health and Wellbeing', '', 'Prof. U.V. Kiran', '8922007101', 'druvkiran@gmail.com', '&#129504;'),
            array(10, 'Naturopathy Wellness', '', 'Dr. Naveen G Halappa', '6206510269', 'drnaveenhalappa@gmail.com', '&#127802;'),
            array(13, 'Sports (Any)', '', 'Dr. Manoj Dhadwal', '7080879999', 'bbausportsection@gmail.com', '&#127942;'),
        ),
    ),
    array(
        'name'  => 'SKILLS & COMMUNITY',
        'class' => 'hc-skills',
        'icon'  => '&#128101;',
        'courses' => array(
            array(5,  'Digital Literacy and Competency', '', 'Dr Amit Kumar Singh', '9873306857', 'amit.scss@gmail.com', '&#128187;'),
            array(8,  'Community Service', '', 'Dr. Manjari Raj Oraon', '9899981878', 'manjariraj2011@gmail.com', '&#129309;'),
            array(11, 'Baker Craft', '(No Oven No Problem)', 'Prof Neetu Singh', '9336458933', 'neetubbau@gmail.com', '&#127856;'),
            array(12, 'Disaster Risk Reduction (DRR)', '', 'Dr Vikas Srivastava', '9936967817', 'vikasafmcite@yahoo.co.in', '&#9888;'),
            array(16, 'AI Club', '', 'Prof. Babita Pandey', '9779683494', 'pandey.babita80@gmail.com', '&#129302;'),
        ),
    ),
);
?>

<?php get_template_part('banners/about-banner'); ?>

<div class="container-fluid page-bg py-lg-5 overflow-hidden hobby-club-page">
    <?php get_template_part('template-parts/breadcrumb'); ?>

    <div class="container">
        <div class="menu-wrapper">
            <?php get_template_part('menu/menu'); ?>
        </div>

        <div class="hc-wrap">
            <div class="hc-header">
                <div class="hc-person">
                    <img src="<?php echo esc_url( $chair_img ); ?>" alt="Prof. Sangeeta Saxena" />
                    <div><small>Chairperson</small><strong>Prof. Sangeeta Saxena</strong></div>
                </div>
                <div class="hc-title">
                    <span class="ti">&#128101;</span>
                    <div>
                        <h3>University Hobby Clubs </h3>
                        <p>Courses Identified for the PG III (July to Dec 2026)</p>
                    </div>
                </div>
                <div class="hc-person">
                    <img src="<?php echo esc_url( $secy_img ); ?>" alt="Prof. Subhash Mishra" />
                    <div><small>Member Secretary</small><strong>Prof. Subhash Mishra</strong></div>
                </div>
            </div>
            <div class="hc-info">
                <div class="cell"><span class="calbox">&#128197;</span>
                    <div><b>Classes:</b> Every Friday 3.00 PM to 5.00 PM</div></div>
                <div class="cell"><span class="ic">&#127891;</span>
                    <div><b>02 Credit Audit Pass Hobby Course</b><br />(02 hrs/week equivalent)</div></div>
                <div class="cell">
                    <div>For PG students in II and III semester<br />(on voluntary basis)</div></div>
            </div>
            <?php foreach ( $categories as $cat ) : ?>
                <div class="hc-cat <?php echo esc_attr( $cat['class'] ); ?>">
                    <div class="hc-cat-head">
                        <span class="hc-cat-icon"><?php echo $cat['icon']; ?></span>
                        <h4 class="hc-cat-title"><?php echo esc_html( $cat['name'] ); ?></h4>
                    </div>
                    <div class="hc-grid">
                        <?php foreach ( $cat['courses'] as $c ) :
                            list( $no, $title, $sub, $coord, $phone, $email, $icon ) = $c;
                            $emails      = array_map( 'trim', explode( ',', $email ) );
                            $first_email = $emails[0];
                        ?>
                            <div class="hc-card">
                                <div class="hc-top">
                                    <span class="hc-icon"><?php echo $icon; ?></span>
                                    <div class="hc-head">
                                        <h5><?php echo (int) $no; ?>. <?php echo esc_html( $title ); ?></h5>
                                        <?php if ( $sub !== '' ) : ?>
                                            <small><?php echo esc_html( $sub ); ?></small>
                                        <?php endif; ?>
                                        <span class="hc-code"><?php echo esc_html( sprintf( 'HB %03d', $no ) ); ?></span>
                                    </div>
                                </div>
                                <p class="hc-label">Faculty Coordinator: <span><?php echo esc_html( $coord ); ?></span></p>
                                <p class="hc-line"><i>&#9742;</i><span><?php echo esc_html( $phone ); ?></span></p>
                                <p class="hc-line"><i>&#9993;</i>
                                    <a href="mailto:<?php echo esc_attr( $first_email ); ?>"><?php echo esc_html( $email ); ?></a></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
            <div class="hc-notes">
                <div class="hc-n1">
                    <span class="hc-nicon">&#128196;</span>
                    <div><b>Note:</b><br />These hobby courses are for the session 2025-26. Clubs and Clubs initiated hobby courses may be added or discontinued depending upon student interest, feasibility, and institutional requirements.</div>
                </div>
                <div class="hc-n2">
                    <span class="hc-nicon">&#8505;</span>
                    <div><b>Note: Audit Pass Course</b> means a course designed to be audited, not graded. Successful completion of an audit course generally means fulfilling certain requirements, such as attendance, participation, or a final assessment, without a traditional numerical grade.</div>
                </div>
                <div class="hc-n3">
                    <ol>
                        <li>Taken for personal enrichment and knowledge gain, not for a degree.</li>
                        <li>Not graded (pass or fail based on requirements).</li>
                        <li>Typically involves attendance, participation or other requirements.</li>
                        <li>Performance assessed by fulfilment of specific requirements, not GPA.</li>
                        <li>Classes every Friday afternoon 3.00 &ndash; 5.00 PM.</li>
                    </ol>
                </div>
            </div>
            <div class="hc-sop">
                <h3 class="hc-sop-title">SoP of Hobby Club</h3>
                <ul class="hc-sop-list">
                    <?php foreach ( $sop_links as $link ) : ?>
                        <li>
                            <a href="<?php echo esc_url( $link['url'] ); ?>" target="_blank" rel="noopener noreferrer">
                                <?php echo esc_html( $link['label'] ); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

        </div>
    </div>
</div>
<style>
    .hc-wrap { --navy: #12326b; }
.hc-wrap * { box-sizing: border-box; }

.hc-header { display: flex; align-items: center; gap: 14px; margin-bottom: 14px; }
.hc-person { flex: 0 0 24%; display: flex; align-items: center; justify-content: center; gap: 10px;
    background: #e8f0fb; border: 1px solid #c9d8f0; border-radius: 18px; padding: 8px 12px; text-align: center; }
.hc-wrap .hc-person img { width: 48px !important; height: 48px !important; max-width: 48px; border-radius: 50%;
    object-fit: cover; border: 2px solid #fff !important; margin: 0; padding: 0; }
.hc-person small { display: block; font-weight: 700; color: var(--navy); font-size: 14px; }
.hc-person strong { display: block; color: var(--navy); font-size: 17px; }
.hc-title { flex: 1; display: flex; align-items: center; justify-content: center; gap: 12px;
    background: var(--navy); color: #fff; border-radius: 28px; padding: 10px 20px; text-align: center;
    box-shadow: 0 2px 6px rgba(0,0,0,.25); }
.hc-title .ti { font-size: 36px; line-height: 1; }
.hc-title h2 { margin: 0; font-size: 32px; font-weight: 800; line-height: 1.1; color: #fff; }
.hc-title p { margin: 3px 0 0; font-size: 15px; font-weight: 600; color: #fff; }

.hc-info { display: flex; align-items: center; margin-bottom: 14px; padding: 6px 4px; }
.hc-info .cell { display: flex; align-items: center; gap: 12px; padding: 0 20px; font-size: 15px; color: var(--navy); }
.hc-info .cell + .cell { border-left: 2px solid var(--navy); }
.hc-info .cell:nth-child(1) { flex: 1.2; }
.hc-info .cell:nth-child(2), .hc-info .cell:nth-child(3) { flex: 1; }
.hc-info .ic { font-size: 26px; line-height: 1; }
.hc-info .calbox { width: 50px; height: 50px; flex: 0 0 50px; border-radius: 8px; background: var(--navy); color: #fff;
    display: flex; align-items: center; justify-content: center; font-size: 26px; }

.hc-cat { position: relative; margin: 28px 0 14px; padding: 28px 10px 10px; border: 2px solid var(--c);
    border-radius: 14px; background: linear-gradient(180deg, #fff 0%, var(--bg) 100%); }
.hc-cat-head { position: absolute; top: -18px; left: 6px; display: flex; align-items: center; }
.hc-cat-icon { width: 40px; height: 40px; border-radius: 50%; background: var(--c); color: #fff;
    display: flex; align-items: center; justify-content: center; font-size: 20px; border: 3px solid #fff;
    box-shadow: 0 0 0 2px var(--c); z-index: 2; }
.hc-cat-title { margin: 0 0 0 -14px; padding: 6px 40px 6px 26px; color: #fff; font-weight: 800;
    letter-spacing: .5px; font-size: 17px; border-radius: 0 25px 25px 0;
    background: linear-gradient(90deg, var(--c), var(--c2)); }
.hc-grid { display: grid; gap: 10px; }
.hc-arts .hc-grid { grid-template-columns: repeat(5, 1fr); }
.hc-nature .hc-grid { grid-template-columns: repeat(6, 1fr); }
.hc-wellness .hc-grid { grid-template-columns: repeat(4, 1fr); }
.hc-skills .hc-grid { grid-template-columns: repeat(5, 1fr); }

.hc-arts { --c: #7b2fbe; --c2: #a35ad6; --bg: #f6effc; }
.hc-nature { --c: #2e9e4f; --c2: #55bf73; --bg: #eef9f1; }
.hc-wellness { --c: #f08a1c; --c2: #f7a94f; --bg: #fff5e8; }
.hc-skills { --c: #c2185b; --c2: #e0508a; --bg: #fdeef5; }

/* Course card */
.hc-card { background: #fff; border: 1.5px solid var(--c); border-radius: 12px; padding: 10px; font-size: 12px;
    color: #222; box-shadow: 0 1px 3px rgba(0,0,0,.08); min-width: 0; }
.hc-top { display: flex; align-items: center; gap: 8px; margin-bottom: 6px; }
.hc-icon { flex: 0 0 52px; width: 52px; height: 52px; border-radius: 50%; background: var(--c); color: #fff;
    display: flex; align-items: center; justify-content: center; font-size: 26px;
    box-shadow: 0 0 0 3px #fff, 0 0 0 4px var(--c); }
.hc-head { flex: 1; min-width: 0; text-align: center; }
.hc-head h5 { margin: 0; font-size: 14px; font-weight: 700; color: var(--navy); line-height: 1.2; }
.hc-head small { display: block; font-size: 10px; color: #444; line-height: 1.2; margin-top: 2px; }
.hc-code { display: inline-block; margin-top: 4px; background: var(--c); color: #fff; font-size: 11px;
    font-weight: 700; border-radius: 12px; padding: 1px 10px; }
.hc-label { margin: 0 0 3px; font-size: 11.5px; color: var(--navy); font-weight: 700; }
.hc-label span { font-weight: 400; color: #222; }
.hc-line { margin: 2px 0; font-size: 11.5px; display: flex; align-items: flex-start; gap: 6px; word-break: break-all; }
.hc-line i { font-style: normal; color: var(--navy); font-size: 13px; flex: 0 0 16px; line-height: 1.2; }
.hc-line a { color: #222; text-decoration: none; }
.hc-line a:hover { text-decoration: underline; }
.hc-notes { display: flex; gap: 12px; margin-top: 16px; align-items: stretch; }
.hc-n1 { flex: 0 0 28%; background: var(--navy); color: #fff; border-radius: 10px; padding: 12px 14px; display: flex; gap: 10px; font-size: 12px; }
.hc-n2 { flex: 1; background: #e8f0fb; border: 1px solid #c9d8f0; border-radius: 10px; padding: 12px 14px; display: flex; gap: 10px; font-size: 12px; color: #222; }
.hc-n2 .hc-nicon { color: var(--navy); }
.hc-n3 { flex: 0 0 28%; border-left: 2px solid var(--navy); padding: 4px 0 4px 14px; font-size: 11.5px; color: #222; }
.hc-n3 ol { margin: 0; padding-left: 18px; }
.hc-nicon { font-size: 26px; line-height: 1; }
@media (max-width: 1199px) {
    .hc-arts .hc-grid, .hc-nature .hc-grid, .hc-skills .hc-grid { grid-template-columns: repeat(3, 1fr); }
    .hc-wellness .hc-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 991px) {
    .hc-header, .hc-info, .hc-notes { flex-direction: column; align-items: stretch; }
    .hc-person { flex: auto; }
    .hc-info .cell + .cell { border-left: 0; border-top: 2px solid var(--navy); padding-top: 8px; margin-top: 8px; }
    .hc-n1, .hc-n3 { flex: auto; }
    .hc-n3 { border-left: 0; padding-left: 0; }
    .hc-title h2 { font-size: 24px; }
    .hc-arts .hc-grid, .hc-nature .hc-grid, .hc-wellness .hc-grid, .hc-skills .hc-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 575px) {
    .hc-arts .hc-grid, .hc-nature .hc-grid, .hc-wellness .hc-grid, .hc-skills .hc-grid { grid-template-columns: 1fr; }
}
.hc-sop { margin-top: 24px; padding-top: 14px; border-top: 2px solid var(--navy); }
.hc-sop-title { margin: 0 0 10px; font-size: 22px; font-weight: 800; color: var(--navy); }
.hc-sop-list { margin: 0; padding-left: 20px; }
.hc-sop-list li { margin-bottom: 6px; font-size: 15px; }
.hc-sop-list a { color: var(--navy); text-decoration: underline; }
.hc-sop-list a:hover { color: #c2185b; }
</style>

<?php get_footer(); ?>