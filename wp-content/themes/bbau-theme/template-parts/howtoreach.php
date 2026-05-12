<?php
/**
 * Template Name: How to Reach BBAU
 * Description: How to Reach page for BBAU Lucknow
 */
get_header();
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
/* ── RESET & BASE ── */
.bbau-reach-wrap *, .bbau-reach-wrap *::before, .bbau-reach-wrap *::after,
.bbau-hero *, .bbau-hero *::before, .bbau-hero *::after {
  box-sizing: border-box;
}

/* ── FULL-WIDTH HERO (outside max-width wrapper) ── */
.bbau-hero {
  background: #1a3a5c;
  padding: 3.5rem 2rem 3rem;
  text-align: center;
  position: relative;
  overflow: hidden;
  margin-bottom: 2rem;
  width: 100%;
}
.bbau-hero-circle-1 {
  position: absolute;
  width: 320px; height: 320px;
  border-radius: 50%;
  background: rgba(255,255,255,0.04);
  top: -80px; right: -80px;
  pointer-events: none;
}
.bbau-hero-circle-2 {
  position: absolute;
  width: 200px; height: 200px;
  border-radius: 50%;
  background: rgba(255,255,255,0.04);
  bottom: -60px; left: -60px;
  pointer-events: none;
}
.bbau-hero-circle-3 {
  position: absolute;
  width: 160px; height: 160px;
  border-radius: 50%;
  background: rgba(255,255,255,0.03);
  top: 50%; right: 15%;
  transform: translateY(-50%);
  pointer-events: none;
}
.bbau-hero-tag {
  display: inline-block;
  background: rgba(255,255,255,0.12);
  color: #a8cce8;
  font-size: 11px;
  font-weight: 600;
  letter-spacing: 2.5px;
  text-transform: uppercase;
  padding: 5px 16px;
  border-radius: 20px;
  margin-bottom: 14px;
}
.bbau-hero h1 {
  color: #fff !important;
  font-size: 34px !important;
  font-weight: 700 !important;
  line-height: 1.25 !important;
  margin-bottom: 8px !important;
  border: none !important;
  padding: 0 !important;
  max-width: 700px;
  margin-left: auto !important;
  margin-right: auto !important;
}
.bbau-hero-sub {
  color: #8ab8d8;
  font-size: 15px;
  margin-bottom: 1.5rem;
}
.bbau-hero-address {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  background: rgba(255,255,255,0.1);
  border: 1px solid rgba(255,255,255,0.2);
  border-radius: 30px;
  padding: 9px 20px;
  font-size: 13px;
  color: #d0e8f5;
}
.bbau-hero-address i { color: #7ab3d4; }

/* ── MAIN WRAPPER ── */
.bbau-reach-wrap {
  font-family: 'Source Sans 3', Arial, sans-serif;
  color: #1a1a1a;
  max-width: auto;
  margin: 0 auto;
  padding: 2rem 1.5rem 3rem;
}

/* ── SECTION LABEL ── */
.bbau-section-label {
  font-size: 11px;
  font-weight: 600;
  letter-spacing: 2px;
  text-transform: uppercase;
  color: #888;
  margin-bottom: 1rem;
  display: flex;
  align-items: center;
  gap: 7px;
}

/* ── TRANSPORT GRID ── */
.bbau-transport-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
  gap: 14px;
  margin-bottom: 2rem;
}
.bbau-card {
  background: #fff;
  border: 1px solid #e5e8ec;
  border-radius: 14px;
  padding: 1.25rem;
  position: relative;
  overflow: hidden;
  transition: transform 0.18s ease, box-shadow 0.18s ease;
}
.bbau-card:hover {
  transform: translateY(-3px);
  box-shadow: 0 6px 20px rgba(0,0,0,0.08);
}
.bbau-card::before {
  content: '';
  position: absolute;
  top: 0; left: 0; right: 0;
  height: 4px;
  border-radius: 14px 14px 0 0;
}
.bbau-card.bbau-train::before { background: #1a6fc4; }
.bbau-card.bbau-road::before  { background: #2e8b57; }
.bbau-card.bbau-air::before   { background: #9b59b6; }
.bbau-card.bbau-bus::before   { background: #e67e22; }

.bbau-card-icon {
  width: 44px; height: 44px;
  border-radius: 10px;
  display: flex; align-items: center; justify-content: center;
  margin-bottom: 12px;
  font-size: 20px;
}
.bbau-card.bbau-train .bbau-card-icon { background: #e8f0fb; color: #1a6fc4; }
.bbau-card.bbau-road  .bbau-card-icon { background: #e8f6ee; color: #2e8b57; }
.bbau-card.bbau-air   .bbau-card-icon { background: #f3eafa; color: #9b59b6; }
.bbau-card.bbau-bus   .bbau-card-icon { background: #fef3e2; color: #e67e22; }

.bbau-card-title {
  font-size: 15px;
  font-weight: 600;
  color: #1a1a1a;
  margin-bottom: 6px;
}
.bbau-badge {
  display: inline-block;
  font-size: 11px;
  font-weight: 600;
  padding: 3px 10px;
  border-radius: 12px;
  margin-bottom: 10px;
}
.bbau-card.bbau-train .bbau-badge { background: #e8f0fb; color: #1a6fc4; }
.bbau-card.bbau-road  .bbau-badge { background: #e8f6ee; color: #2e8b57; }
.bbau-card.bbau-air   .bbau-badge { background: #f3eafa; color: #9b59b6; }
.bbau-card.bbau-bus   .bbau-badge { background: #fef3e2; color: #e67e22; }

.bbau-step {
  font-size: 12.5px;
  color: #666;
  display: flex;
  align-items: flex-start;
  gap: 8px;
  margin-bottom: 6px;
  line-height: 1.5;
}
.bbau-step i {
  margin-top: 3px;
  font-size: 10px;
  flex-shrink: 0;
  color: #bbb;
}

/* ── DIVIDER ── */
.bbau-divider {
  border: none;
  border-top: 1px solid #e5e8ec;
  margin: 1.75rem 0;
}

/* ── QUICK INFO GRID ── */
.bbau-info-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(210px, 1fr));
  gap: 12px;
  margin-bottom: 1.5rem;
}
.bbau-info-box {
  background: #fff;
  border: 1px solid #e5e8ec;
  border-radius: 10px;
  padding: 14px 16px;
  display: flex;
  align-items: flex-start;
  gap: 12px;
}
.bbau-info-icon {
  width: 36px; height: 36px;
  border-radius: 8px;
  background: #eef3fb;
  color: #1a6fc4;
  display: flex; align-items: center; justify-content: center;
  font-size: 15px;
  flex-shrink: 0;
}
.bbau-info-label {
  font-size: 11px;
  font-weight: 600;
  letter-spacing: 1px;
  text-transform: uppercase;
  color: #999;
  margin-bottom: 4px;
}
.bbau-info-val {
  font-size: 14px;
  font-weight: 600;
  color: #1a1a1a;
}

/* ── MAP BUTTON ── */
.bbau-map-btn {
  display: flex !important;
  align-items: center;
  justify-content: center;
  gap: 10px;
  width: 100%;
  padding: 14px;
  background: #1a3a5c !important;
  color: #fff !important;
  border: none !important;
  border-radius: 10px;
  font-size: 15px !important;
  font-weight: 600;
  text-decoration: none !important;
  cursor: pointer;
  transition: background 0.2s;
}
.bbau-map-btn:hover {
  background: #254e7a !important;
  color: #fff !important;
  text-decoration: none !important;
}

/* ── TIP BOX ── */
.bbau-tip {
  background: #fffbf0;
  border: 1px solid #f5c842;
  border-left: 4px solid #f5c842;
  border-radius: 8px;
  padding: 14px 18px;
  margin-top: 1.25rem;
  display: flex;
  gap: 12px;
  align-items: flex-start;
}
.bbau-tip > i {
  font-size: 18px;
  color: #e6a817;
  margin-top: 2px;
  flex-shrink: 0;
}
.bbau-tip-label {
  font-size: 11px;
  font-weight: 700;
  letter-spacing: 1px;
  text-transform: uppercase;
  color: #a07800;
  margin-bottom: 5px;
}
.bbau-tip-text {
  font-size: 13px;
  color: #7a5e00;
  line-height: 1.6;
}

/* ── MAP EMBED ── */
.bbau-map-section { margin-top: 2rem; }
.bbau-map-embed {
  width: 100%;
  height: 380px;
  border: 1px solid #e5e8ec;
  border-radius: 14px;
  display: block;
  margin-top: 1rem;
}

/* ── CONTACT STRIP ── */
.bbau-contact-strip {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 12px;
  margin-top: 2rem;
  background: #fff;
  border: 1px solid #e5e8ec;
  border-radius: 14px;
  padding: 1.5rem;
}
.bbau-contact-item {
  display: flex;
  align-items: flex-start;
  gap: 10px;
}
.bbau-contact-icon {
  width: 38px; height: 38px;
  border-radius: 8px;
  background: #e8f0fb;
  color: #1a6fc4;
  display: flex; align-items: center; justify-content: center;
  font-size: 16px;
  flex-shrink: 0;
}
.bbau-contact-label {
  font-size: 11px;
  font-weight: 600;
  letter-spacing: 1px;
  text-transform: uppercase;
  color: #999;
  margin-bottom: 3px;
}
.bbau-contact-val {
  font-size: 13px;
  font-weight: 500;
  color: #1a1a1a;
}
.bbau-contact-val a {
  color: #1a6fc4;
  text-decoration: none;
}
.bbau-contact-val a:hover { text-decoration: underline; }

/* ── RESPONSIVE ── */
@media (max-width: 768px) {
  .bbau-hero h1 { font-size: 24px !important; }
  .bbau-transport-grid { grid-template-columns: 1fr 1fr; }
  .bbau-info-grid { grid-template-columns: 1fr 1fr; }
}
@media (max-width: 480px) {
  .bbau-reach-wrap { padding: 1rem 1rem 2rem; }
  .bbau-hero { padding: 2rem 1rem 1.75rem; }
  .bbau-hero h1 { font-size: 20px !important; }
  .bbau-transport-grid { grid-template-columns: 1fr; }
  .bbau-info-grid { grid-template-columns: 1fr; }
  .bbau-contact-strip { grid-template-columns: 1fr; }
}
</style>

<?php
// ── Config (edit these values) ────────────────────────────────────
$bbau_phone      = get_theme_mod('bbau_phone',   '+91-522-2440700');
$bbau_email      = get_theme_mod('bbau_email',   'registrar@bbau.ac.in');
$bbau_address    = get_theme_mod('bbau_address', 'Vidya Vihar, Raebareli Road, Lucknow – 226025, U.P.');
$bbau_maps_url   = get_theme_mod('bbau_maps_url', 'https://maps.google.com/?q=Babasaheb+Bhimrao+Ambedkar+University+Lucknow');
$bbau_maps_embed = get_theme_mod('bbau_maps_embed', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3560.47!2d80.9899!3d26.7553!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x399be3b6b2a7d9e7%3A0x0!2sBabasaheb+Bhimrao+Ambedkar+University!5e0!3m2!1sen!2sin!4v1234567890');

// ── Transport modes ───────────────────────────────────────────────
$bbau_transport = [
  [
    'class'      => 'bbau-train',
    'icon_class' => 'fa-solid fa-train',
    'title'      => 'By Train',
    'badge'      => '~14–18 km',
    'steps'      => [
      'Alight at Lucknow Junction (NR) or Charbagh Railway Station',
      'Take auto-rickshaw or cab towards Raebareli Road',
      'Ask for BBAU / Vidya Vihar — approx. 30–45 min ride',
    ],
  ],
  [
    'class'      => 'bbau-road',
    'icon_class' => 'fa-solid fa-car',
    'title'      => 'By Car / Cab',
    'badge'      => 'Via NH-30',
    'steps'      => [
      'Drive south on Raebareli Road (NH-30) from city centre',
      'Follow BBAU / Vidya Vihar signboards on the highway',
      'Ola, Uber, and Rapido available from Hazratganj & Charbagh',
    ],
  ],
  [
    'class'      => 'bbau-air',
    'icon_class' => 'fa-solid fa-plane',
    'title'      => 'By Air',
    'badge'      => '~30 km',
    'steps'      => [
      'Land at Chaudhary Charan Singh International Airport',
      'Board a pre-paid taxi or cab to Raebareli Road, BBAU',
      'Journey takes approx. 50–60 min depending on traffic',
    ],
  ],
  [
    'class'      => 'bbau-bus',
    'icon_class' => 'fa-solid fa-bus',
    'title'      => 'By Bus',
    'badge'      => 'UPSRTC',
    'steps'      => [
      'Board a Lucknow–Raebareli UPSRTC bus from Charbagh Bus Stand',
      'De-board at the BBAU / Vidya Vihar stop on the highway',
      'City minibuses on Raebareli Road also stop near campus',
    ],
  ],
];

// ── Quick reference ───────────────────────────────────────────────
$bbau_quick = [
  ['icon_class' => 'fa-solid fa-city',           'label' => 'From City Centre',     'value' => '~14–18 km · 30–40 min'],
  ['icon_class' => 'fa-solid fa-plane-arrival',  'label' => 'From Airport',         'value' => '~30 km · 50–60 min'],
  ['icon_class' => 'fa-solid fa-train',          'label' => 'Nearest Railway Stn.', 'value' => 'Lucknow Junction / Charbagh'],
  ['icon_class' => 'fa-solid fa-road',           'label' => 'Main Road',            'value' => 'Raebareli Road (NH-30)'],
];

// ── Contact info ──────────────────────────────────────────────────
$bbau_contacts = [
  ['icon_class' => 'fa-solid fa-phone',        'label' => 'Phone',   'value' => $bbau_phone,  'href' => 'tel:' . $bbau_phone],
  ['icon_class' => 'fa-solid fa-envelope',     'label' => 'Email',   'value' => $bbau_email,  'href' => 'mailto:' . $bbau_email],
  ['icon_class' => 'fa-solid fa-location-dot', 'label' => 'Address', 'value' => $bbau_address,'href' => ''],
  ['icon_class' => 'fa-solid fa-globe',        'label' => 'Website', 'value' => 'www.bbau.ac.in', 'href' => home_url()],
];
?>

<!-- HERO — full width -->
<div class="bbau-hero">
  <div class="bbau-hero-circle-1"></div>
  <div class="bbau-hero-circle-2"></div>
  <div class="bbau-hero-circle-3"></div>
  <div class="bbau-hero-tag">Lucknow, Uttar Pradesh</div>
  <h1>Babasaheb Bhimrao Ambedkar University</h1>
  <p class="bbau-hero-sub">How to Reach BBAU</p>
  <div class="bbau-hero-address">
    <i class="fa-solid fa-location-dot"></i>
    <?php echo esc_html($bbau_address); ?>
  </div>
</div>

<!-- MAIN CONTENT -->
 <div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-10">
<div class="bbau-reach-wrap">

  <!-- TRANSPORT CARDS -->
  <p class="bbau-section-label">
    <i class="fa-solid fa-route"></i> By Mode of Transport
  </p>

  <div class="bbau-transport-grid">
    <?php foreach ($bbau_transport as $t) : ?>
    <div class="bbau-card <?php echo esc_attr($t['class']); ?>">
      <div class="bbau-card-icon">
        <i class="<?php echo esc_attr($t['icon_class']); ?>"></i>
      </div>
      <div class="bbau-card-title"><?php echo esc_html($t['title']); ?></div>
      <span class="bbau-badge"><?php echo esc_html($t['badge']); ?></span>
      <?php foreach ($t['steps'] as $step) : ?>
      <div class="bbau-step">
        <i class="fa-solid fa-circle-dot"></i>
        <?php echo esc_html($step); ?>
      </div>
      <?php endforeach; ?>
    </div>
    <?php endforeach; ?>
  </div>

  <hr class="bbau-divider">

  <!-- QUICK REFERENCE -->
  <p class="bbau-section-label">
    <i class="fa-solid fa-circle-info"></i> Quick Reference
  </p>

  <div class="bbau-info-grid">
    <?php foreach ($bbau_quick as $info) : ?>
    <div class="bbau-info-box">
      <div class="bbau-info-icon">
        <i class="<?php echo esc_attr($info['icon_class']); ?>"></i>
      </div>
      <div>
        <div class="bbau-info-label"><?php echo esc_html($info['label']); ?></div>
        <div class="bbau-info-val"><?php echo esc_html($info['value']); ?></div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>

  <!-- MAP BUTTON -->
  <a class="bbau-map-btn"
     href="<?php echo esc_url($bbau_maps_url); ?>"
     target="_blank"
     rel="noopener noreferrer">
    <i class="fa-solid fa-map-location-dot"></i>
    Open in Google Maps
  </a>

  <!-- TIP BOX -->
  <div class="bbau-tip">
    <i class="fa-solid fa-lightbulb"></i>
    <div>
      <div class="bbau-tip-label">Visitor Tip</div>
      <div class="bbau-tip-text">
        Search <strong>"BBAU Vidya Vihar"</strong> on Google Maps for the exact main gate location.
        Autos and e-rickshaws are available from Telibagh and Indira Nagar for the last mile to campus.
      </div>
    </div>
  </div>

  <!-- MAP EMBED -->
  <div class="bbau-map-section">
    <p class="bbau-section-label">
      <i class="fa-solid fa-map"></i> Campus Location
    </p>
    <iframe
      class="bbau-map-embed"
      src="<?php echo esc_url($bbau_maps_embed); ?>"
      allowfullscreen=""
      loading="lazy"
      referrerpolicy="no-referrer-when-downgrade"
      title="BBAU Lucknow Campus Map">
    </iframe>
  </div>

  <!-- CONTACT STRIP -->
  <div class="bbau-contact-strip">
    <?php foreach ($bbau_contacts as $c) : ?>
    <div class="bbau-contact-item">
      <div class="bbau-contact-icon">
        <i class="<?php echo esc_attr($c['icon_class']); ?>"></i>
      </div>
      <div>
        <div class="bbau-contact-label"><?php echo esc_html($c['label']); ?></div>
        <div class="bbau-contact-val">
          <?php if (!empty($c['href'])) : ?>
            <a href="<?php echo esc_url($c['href']); ?>"
               <?php echo strpos($c['href'], 'http') === 0 ? 'target="_blank" rel="noopener"' : ''; ?>>
              <?php echo esc_html($c['value']); ?>
            </a>
          <?php else : ?>
            <?php echo esc_html($c['value']); ?>
          <?php endif; ?>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
</div><!-- end .bbau-reach-wrap -->
        </div><!-- end .col-lg-10 -->
    </div><!-- end .row -->
</div><!-- end .bbau-reach-wrap -->

<?php get_footer(); ?>