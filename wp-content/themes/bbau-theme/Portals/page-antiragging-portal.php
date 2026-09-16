<?php
/**
 * Template Name: Anti-Ragging Portal
 *
 **/
defined('ABSPATH') || exit;
get_header();

$api_base = getenv('DJANGO_MEDIA_URL');
?>

<main id="primary" class="antiragging-portal">
    <?php get_template_part('banners/new-banner'); ?>



    <!-- TRUST BADGES BAR -->
    <section class="ar-trust" aria-label="Portal highlights">
        <div class="container ar-trust-grid">
            <div><span class="ar-trust-icon"><i class="fas fa-shield-alt"></i></span><strong>Zero
                    Tolerance</strong><small>Strict adherence to UGC Anti-Ragging norms.</small></div>
            <div><span class="ar-trust-icon"><i class="fas fa-user-shield"></i></span><strong>100%
                    Confidential</strong><small>Complainant details are kept safe.</small></div>
            <div><span class="ar-trust-icon"><i class="fas fa-phone-alt"></i></span><strong>24x7
                    Helpline</strong><small>Immediate assistance &amp; support.</small></div>
            <div><span class="ar-trust-icon"><i class="fas fa-users-cog"></i></span><strong>Active
                    Committee</strong><small>Prompt investigation &amp; response.</small></div>
        </div>
    </section>

    <!-- CORE PORTAL SECTIONS / QUICK NAVIGATION GRID -->
    <section class="ar-section ar-section-soft" id="portal-services">
        <?php get_template_part('template-parts/breadcrumb'); ?>
        <?php get_template_part('menu/menu');?>

        <div class="container">
            <div class="ar-section-heading">
                <span class="ar-kicker">EXPLORE RESOURCES &amp; SERVICES</span>
                <h2>Anti-Ragging Information Hub</h2>
                <p>Access official guidelines, committee details, emergency helplines, affidavits, and complaint
                    reporting mechanisms.</p>
            </div>

            <div class="ar-feature-grid">
                <!-- UGC Regulations -->
                <article class="ar-feature">
                    <span class="ar-feature-icon"><i class="fas fa-gavel"></i></span>
                    <h3>UGC Regulations</h3>
                    <p>Read official UGC regulations on curbing the menace of ragging in higher educational
                        institutions.</p>
                    <a href="#resources-tab" onclick="switchCategory('ugc_regulations')">View Regulations <i
                            class="fas fa-arrow-right"></i></a>
                </article>

                <!-- University Policy -->
                <article class="ar-feature">
                    <span class="ar-feature-icon"><i class="fas fa-university"></i></span>
                    <h3>University Policy</h3>
                    <p>BBAU's anti-ragging policy, campus safety norms, and code of conduct for students and staff.</p>
                    <a href="#resources-tab" onclick="switchCategory('university_policy')">View Policy <i
                            class="fas fa-arrow-right"></i></a>
                </article>

                <!-- Committee & Squad -->
                <article class="ar-feature">
                    <span class="ar-feature-icon"><i class="fas fa-users"></i></span>
                    <h3>Committee &amp; Squad</h3>
                    <p>Details of Anti-Ragging Committee and Squad members across university departments.</p>
                    <a href="#committee-members">View Members <i class="fas fa-arrow-right"></i></a>
                </article>

                <!-- Complaint Mechanism -->
                <article class="ar-feature">
                    <span class="ar-feature-icon"><i class="fas fa-bullhorn"></i></span>
                    <h3>Complaint Mechanism</h3>
                    <p>Report ragging incidents online. Your identity will be kept completely confidential.</p>
                    <a href="/complaint-management-portal/" target="_blank">Report Incident <i
                            class="fas fa-external-link-alt"></i></a>
                </article>

                <!-- Affidavits -->
                <article class="ar-feature">
                    <span class="ar-feature-icon"><i class="fas fa-file-contract"></i></span>
                    <h3>Affidavits Portal</h3>
                    <p>Download and submit anti-ragging affidavits for students and parents as per UGC mandates.</p>
                    <a href="/affidavit-portal/" target="_blank">Affidavit Portal <i
                            class="fas fa-external-link-alt"></i></a>
                </article>

                <!-- Awareness Materials -->
                <article class="ar-feature">
                    <span class="ar-feature-icon"><i class="fas fa-book-open"></i></span>
                    <h3>Awareness Materials</h3>
                    <p>Posters, booklets, brochures, and awareness videos to educate and prevent ragging.</p>
                    <a href="#resources-tab" onclick="switchCategory('awareness_material')">Explore Materials <i
                            class="fas fa-arrow-right"></i></a>
                </article>

                <!-- FAQs -->
                <article class="ar-feature">
                    <span class="ar-feature-icon"><i class="fas fa-question-circle"></i></span>
                    <h3>FAQs</h3>
                    <p>Find clear answers to common questions regarding ragging rules, rights, and actions.</p>
                    <a href="#faqs">View FAQs <i class="fas fa-arrow-right"></i></a>
                </article>

                <!-- Hostel Safety -->
                <article class="ar-feature">
                    <span class="ar-feature-icon"><i class="fas fa-building"></i></span>
                    <h3>Hostel Safety</h3>
                    <p>Information on hostel security, wardens, safety measures, and monitoring systems.</p>
                    <a href="/hostels/" target="_blank">Hostel Safety <i class="fas fa-external-link-alt"></i></a>
                </article>

                <!-- Annual Compliance Reports -->
                <article class="ar-feature">
                    <span class="ar-feature-icon"><i class="fas fa-chart-bar"></i></span>
                    <h3>Annual Compliance Reports</h3>
                    <p>Review annual anti-ragging reports and metrics submitted to the UGC.</p>
                    <a href="#resources-tab" onclick="switchCategory('annual_report')">View Reports <i
                            class="fas fa-arrow-right"></i></a>
                </article>

                <!-- Emergency Contacts -->
                <article class="ar-feature">
                    <span class="ar-feature-icon"><i class="fas fa-phone-volume"></i></span>
                    <h3>Emergency Contacts</h3>
                    <p>Important helpline numbers and contacts for immediate emergency assistance.</p>
                    <a href="#contact-helplines">View Helplines <i class="fas fa-arrow-right"></i></a>
                </article>
            </div>
        </div>
    </section>

    <!-- COMMITTEE & SQUAD MEMBERS SECTION -->
    <section class="ar-section" id="committee-members">
        <div class="ar-container">
            <div class="ar-section-heading">
                <span class="ar-kicker">ADMINISTRATION</span>
                <h2>Anti-Ragging Committee &amp; Squad</h2>
                <p>The Anti-Ragging Committee and Squad ensure round-the-clock monitoring and vigilance on campus.</p>
            </div>

            <div class="ar-tab-buttons">
                <button class="ar-tab-btn active" onclick="filterCommittee('committee', this)"><i
                        class="fas fa-user-shield"></i> Anti-Ragging Committee</button>
                <button class="ar-tab-btn" onclick="filterCommittee('squad', this)"><i class="fas fa-users"></i>
                    Anti-Ragging Squad</button>
            </div>

            <div class="ar-search-bar">
                <i class="fas fa-search"></i>
                <input type="text" id="committee-search" placeholder="Search by name or designation...">
            </div>

            <div id="committee-grid" class="ar-committee-list">
                <p class="ar-loading"><i class="fas fa-spinner fa-spin"></i> Loading committee details...</p>
            </div>
            <div id="committee-load-more-wrap" style="text-align:center; margin-top:20px; display:none;">
                <button id="committee-load-more" class="ar-button ar-button-outline" type="button">Show More</button>
            </div>
        </div>
    </section>

    <!-- RESOURCES & DOWNLOADS SECTION -->
    <section class="ar-section ar-section-soft" id="resources-tab">
        <div class="ar-container">
            <div class="ar-section-heading">
                <span class="ar-kicker">DOCUMENTS &amp; POLICIES</span>
                <h2>Anti-Ragging Resources &amp; Downloads</h2>
                <p>Download official regulations, awareness materials, policies, and annual reports.</p>
            </div>

            <div class="ar-tab-buttons" id="resource-tab-buttons">
                <button class="ar-tab-btn active" data-category="all" onclick="switchCategory('all', this)">All</button>
                <button class="ar-tab-btn" data-category="ugc_regulations"
                    onclick="switchCategory('ugc_regulations', this)">UGC Regulations</button>
                <button class="ar-tab-btn" data-category="university_policy"
                    onclick="switchCategory('university_policy', this)">University Policy</button>
                <button class="ar-tab-btn" data-category="awareness_material"
                    onclick="switchCategory('awareness_material', this)">Awareness Materials</button>
                <!-- <button class="ar-tab-btn" data-category="hostel_safety"
                    onclick="switchCategory('hostel_safety', this)">Hostel Safety</button> -->
                <button class="ar-tab-btn" data-category="annual_report"
                    onclick="switchCategory('annual_report', this)">Annual Reports</button>
            </div>

            <div id="resource-items" class="ar-resource-list">
                <p class="ar-loading"><i class="fas fa-spinner fa-spin"></i> Loading resources...</p>
            </div>
            <div id="resource-load-more-wrap" style="text-align:center; margin-top:20px; display:none;">
                <button id="resource-load-more" class="ar-button ar-button-outline" type="button">Show More</button>
            </div>
        </div>
    </section>

    <!-- COMPLAINT / INCIDENT REPORTING FORM -->
    <!-- <section class="ar-section" id="report-ragging">
        <div class="ar-container ar-two-col">
            <div>
                <span class="ar-kicker">CONFIDENTIAL REPORTING</span>
                <h2>Report a Ragging Incident</h2>
                <p>If you have experienced or witnessed any form of ragging on campus or hostels, report it immediately
                    using this confidential form.</p>
                <div class="ar-notice">
                    <i class="fas fa-user-secret" style="color: var(--ar-gold); margin-right: 8px;"></i>
                    <strong>Strict Confidentiality Guaranteed:</strong> Your identity will be protected and disclosed
                    only to designated investigating officers if necessary.
                </div>
            </div>

            <div class="ar-form">
                <form id="antiragging-complaint-form" enctype="multipart/form-data">
                    <label class="ar-check" style="margin-bottom:16px;">
                        <input type="checkbox" id="complainant_anonymous" name="is_anonymous"> Report anonymously (name,
                        phone and email will not be recorded)
                    </label>
                    <div class="ar-form-grid">
                        <label>Complainant Name (Optional)
                            <input name="complainant_name" id="complainant_name" type="text"
                                placeholder="Leave blank to remain anonymous">
                        </label>
                        <label>Contact Phone (Optional)
                            <input name="phone" id="complainant_phone" type="tel" inputmode="numeric" maxlength="10"
                                placeholder="10-digit mobile number">
                        </label>
                        <label>Email Address (Optional)
                            <input name="email" id="complainant_email" type="email"
                                placeholder="e.g. student@bbau.ac.in">
                        </label>
                        <label>Incident Location *
                            <input required name="location" type="text"
                                placeholder="e.g. Hostel No. 3 / Department Premises">
                        </label>
                        <label style="grid-column: 1 / -1;">Incident Description *
                            <textarea required name="description" rows="4"
                                placeholder="Provide full details of the incident including date, time, and persons involved..."></textarea>
                        </label>
                        <label style="grid-column: 1 / -1;">Evidence (Optional)
                            <input name="evidence" type="file" accept="application/pdf,.pdf,.doc,.docx,image/*">
                        </label>
                    </div>
                    <button class="ar-button ar-button-primary"
                        style="margin-top: 16px; width: 100%; justify-content: center;" type="submit">
                        <i class="fas fa-paper-plane"></i> Submit Incident Report
                    </button>
                    <div id="complaint-form-message" class="ar-track-result" style="margin-top: 16px; display: none;"
                        aria-live="polite"></div>
                </form>
            </div>
        </div>
    </section> -->

    <!-- EMERGENCY CONTACTS & HELPLINES -->
    <section class="ar-section ar-section-dark" id="contact-helplines">
        <div class="ar-container">
            <div class="ar-section-heading">
                <span class="ar-eyebrow" style="color: var(--ar-gold);"><i class="fas fa-phone-alt"></i> EMERGENCY
                    SUPPORT</span>
                <h2 style="color: #fff;">Important Helplines &amp; Contacts</h2>
                <p style="color: rgba(255,255,255,0.8);">Reach out immediately for emergency support or
                    assistance.</p>
            </div>

            <div id="emergency-grid" class="ar-helpline-grid">
                <p class="ar-loading" style="color: rgba(255,255,255,0.7);"><i class="fas fa-spinner fa-spin"></i>
                    Loading emergency contacts...</p>
            </div>
        </div>
    </section>

    <!-- FAQS SECTION -->
    <section class="ar-section" id="faqs">
        <div class="ar-container">
            <div class="ar-section-heading">
                <span class="ar-kicker">FREQUENTLY ASKED QUESTIONS</span>
                <h2>Know Your Rights &amp; FAQ</h2>
                <p>Find answers to common questions regarding anti-ragging rules, guidelines, and helpline support.</p>
            </div>

            <div id="ar-faqs-list" class="ar-faq-accordion">
                <p class="ar-loading"><i class="fas fa-spinner fa-spin"></i> Loading FAQs...</p>
            </div>
        </div>
    </section>
</main>

<style>
/* IDENTICAL DESIGN SYSTEM & COLOR PALETTE FROM AFFIDAVIT PORTAL */
.antiragging-portal {
    --ar-ink: #172033;
    --ar-muted: #657083;
    --ar-brand: #173d6b;
    --ar-dark: #101722;
    --ar-gold: #d6a531;
    --ar-line: #e5e9ef;
    --ar-soft: #f5f7fb;
    color: var(--ar-ink);
    background: var(--ar-soft);
    font: 16px/1.55 system-ui, -apple-system, "Segoe UI", sans-serif;
}

.ar-container {
    width: min(1120px, 92%);
    margin: auto;
}

.ar-eyebrow,
.ar-kicker {
    font-size: .76rem;
    font-weight: 700;
    letter-spacing: .13em;
    text-transform: uppercase;
}

.ar-eyebrow {
    color: #f0d47d;
}

.ar-kicker {
    color: var(--ar-brand);
}

.ar-button {
    display: inline-flex;
    align-items: center;
    gap: 12px;
    border: 0;
    border-radius: 4px;
    padding: 13px 19px;
    font-weight: 750;
    text-decoration: none;
    cursor: pointer;
    transition: all 0.2s ease;
}

.ar-button-primary {
    background: var(--ar-gold);
    color: var(--ar-ink);
}

.ar-button-primary:hover {
    background: #c29427;
    color: var(--ar-ink);
}

.ar-button-ghost {
    border: 1px solid rgba(255, 255, 255, .6);
    background: transparent;
    color: #fff;
}

.ar-button-ghost:hover {
    background: rgba(255, 255, 255, 0.1);
    color: #fff;
}

.ar-trust {
    background: #fff;
    border-bottom: 1px solid var(--ar-line);
}

.ar-trust-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
}

.ar-trust-grid>div {
    display: grid;
    grid-template-columns: 44px 1fr;
    column-gap: 10px;
    align-items: center;
    padding: 18px 0;
}

.ar-feature-icon {
    margin: 0 auto 15px;
}

.ar-trust-icon,
.ar-feature-icon {
    display: grid;
    place-items: center;
    width: 44px;
    height: 44px;
    border-radius: 50%;
    background: #edf3fa;
    color: var(--ar-brand);
    font-size: 1.1rem;
    font-weight: 700;
}

.ar-trust-grid strong,
.ar-trust-grid small {
    grid-column: 2;
}

.ar-trust-grid small {
    color: var(--ar-muted);
    font-size: .78rem;
}

.ar-trust-icon {
    grid-row: 1/3;
    grid-column: 1;
}

.ar-section {
    padding: 30px 0;
}

.ar-section-soft {
    background: #fff;
}

.ar-section-dark {
    background: var(--ar-dark);
    color: #fff;
}

.ar-section-heading {
    max-width: 720px;
    margin-bottom: 30px;
}

.ar-section h2 {
    font-size: clamp(1.8rem, 3.5vw, 2.7rem);
    line-height: 1.12;
    margin: 10px 0 14px;
    font-weight: 700;
}

.ar-section p {
    color: var(--ar-muted);
}

/* CARDS DESIGN (EARLIER 4-COLUMN VERTICAL LAYOUT WITH TOP ICON) */
.ar-feature-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
    gap: 20px;
}

.ar-feature {
    background: #fff;
    padding: 24px 20px;
    border-radius: 10px;
    border: 1px solid var(--ar-line);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    display: flex;
    flex-direction: column;
    box-shadow: 0 4px 15px rgba(20, 40, 70, .04);
}

.ar-feature:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 24px rgba(20, 40, 70, .09);
}

.ar-feature h3 {
    font-size: 1.15rem;
    color: var(--ar-ink);
    margin-bottom: 8px;
    font-weight: 700;
}

.ar-feature p {
    font-size: .92rem;
    color: var(--ar-muted);
    flex-grow: 1;
    margin-bottom: 16px;
    line-height: 1.5;
}

.ar-feature a {
    color: var(--ar-brand);
    font-weight: 700;
    text-decoration: none;
    font-size: 0.92rem;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.ar-feature a:hover {
    color: var(--ar-gold);
}

/* TAB BUTTONS & COMMITTEE GRID */
.ar-tab-buttons {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 24px;
}

.ar-tab-btn {
    padding: 10px 20px;
    border: 1px solid var(--ar-line);
    background: #fff;
    color: var(--ar-ink);
    border-radius: 6px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.2s ease;
}

.ar-tab-btn.active {
    background: var(--ar-brand);
    color: #fff;
    border-color: var(--ar-brand);
}


.ar-search-bar {
    position: relative;
    max-width: 380px;
    margin-bottom: 18px;
}

.ar-search-bar i {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--ar-muted);
    font-size: 0.85rem;
}

.ar-search-bar input {
    width: 100%;
    padding: 10px 14px 10px 38px;
    border: 1px solid var(--ar-line);
    border-radius: 6px;
    font: inherit;
    background: #fff;
}

.ar-search-bar input:focus {
    outline: none;
    border-color: var(--ar-brand);
}

.ar-committee-list {
    background: #fff;
    border: 1px solid var(--ar-line);
    border-radius: 10px;
    overflow: hidden;
}

.ar-committee-row {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 14px 20px;
    border-bottom: 1px solid var(--ar-line);
    flex-wrap: wrap;
}

.ar-committee-row:last-child {
    border-bottom: none;
}

.ar-member-avatar {
    flex-shrink: 0;
    width: 42px;
    height: 42px;
    border-radius: 50%;
    background: var(--ar-brand);
    color: #fff;
    display: grid;
    place-items: center;
    font-weight: 700;
    font-size: 0.85rem;
    letter-spacing: 0.02em;
}

.ar-committee-identity {
    flex: 1 1 220px;
    min-width: 0;
}

.ar-committee-identity h4 {
    color: var(--ar-ink);
    margin: 0;
    font-size: 0.98rem;
    font-weight: 700;
    line-height: 1.3;
}

.ar-member-role {
    color: var(--ar-brand);
    font-weight: 700;
    font-size: 0.76rem;
    text-transform: uppercase;
    letter-spacing: 0.03em;
}

.ar-committee-contact {
    flex: 0 0 500px;
    display: grid;
    grid-template-columns: 132px minmax(0, 1fr);
    align-items: center;
    gap: 4px 18px;
}

.ar-committee-contact a {
    color: var(--ar-muted);
    text-decoration: none;
    font-size: 0.85rem;
    display: flex;
    align-items: center;
    gap: 7px;
    min-width: 0;
    white-space: nowrap;
}

.ar-committee-contact a:hover {
    color: var(--ar-brand);
}

.ar-committee-contact i {
    width: 14px;
    color: var(--ar-brand);
}

.ar-committee-no-contact {
    flex-shrink: 0;
    margin: 0;
    font-size: 0.8rem;
    color: var(--ar-muted);
    font-style: italic;
}

/* RESOURCES LIST (compact rows instead of large boxed cards) */
.ar-resource-list {
    background: #fff;
    border: 1px solid var(--ar-line);
    border-radius: 10px;
    overflow: hidden;
}

.ar-resource-row {
    display: flex;
    align-items: flex-start;
    gap: 16px;
    padding: 16px 20px;
    border-bottom: 1px solid var(--ar-line);
}

.ar-resource-row:last-child {
    border-bottom: none;
}

.ar-resource-icon {
    flex-shrink: 0;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: #edf3fa;
    color: var(--ar-brand);
    display: grid;
    place-items: center;
    font-size: 1rem;
}

.ar-resource-body {
    flex: 1;
    min-width: 0;
}

.ar-resource-tag {
    display: block;
    color: var(--ar-brand);
    font-weight: 700;
    font-size: 0.4rem;
    letter-spacing: 0.04em;
    text-transform: uppercase;
    margin-bottom: 2px;
}

.ar-resource-body h3 {
    margin: 0 0 4px;
    font-size: 1rem;
    color: var(--ar-ink);
}

.ar-resource-body p {
    margin: 0;
    font-size: 0.85rem;
    color: var(--ar-muted);
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
}

.ar-resource-download {
    flex-shrink: 0;
    align-self: center;
    color: var(--ar-brand) !important;
    font-weight: 700;
    font-size: 0.85rem;
    text-decoration: none;
    white-space: nowrap;
    border: 1px solid var(--ar-line);
    border-radius: 6px;
    padding: 8px 14px;
}

.ar-resource-download:hover {
    background: var(--ar-brand);
    color: #fff !important;
    border-color: var(--ar-brand);
}

.ar-button-outline {
    background: transparent;
    color: var(--ar-brand);
    border: 1px solid var(--ar-brand);
}

.ar-button-outline:hover {
    background: var(--ar-brand);
    color: #fff;
}

/* TWO COL FORM & NOTICE */
.ar-two-col {
    display: grid;
    grid-template-columns: 1.1fr 0.9fr;
    gap: 36px;
    align-items: start;
}

/* 
.ar-notice {
    margin-top: 24px;
    border-left: 4px solid var(--ar-gold);
    background: #fff8df;
    padding: 16px 18px;
    font-size: .9rem;
    border-radius: 0 6px 6px 0;
} */

.ar-form {
    background: #fff;
    border: 1px solid var(--ar-line);
    border-radius: 7px;
    padding: 26px;
    box-shadow: 0 5px 18px rgba(20, 40, 70, .05);
}

.ar-form-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 16px;
}

.ar-form label {
    display: flex;
    flex-direction: column;
    gap: 6px;
    font-size: .88rem;
    font-weight: 700;
    color: var(--ar-ink);
}

.ar-form input,
.ar-form textarea,
.ar-form select {
    border: 1px solid #cfd6e1;
    border-radius: 4px;
    padding: 11px 12px;
    font: inherit;
    background: #fff;
    width: 100%;
}

.ar-check {
    flex-direction: row !important;
    align-items: center;
    gap: 8px;
    font-weight: 500 !important;
}

.ar-check input {
    width: 18px;
}

/* HELPLINES DARK GRID */
.ar-helpline-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 20px;
}

.ar-helpline-card {
    display: flex;
    align-items: flex-start;
    gap: 16px;
    min-width: 0;
    box-sizing: border-box;
    min-height: 148px;
    padding: 22px;
    background: linear-gradient(135deg, rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0.04));
    border: 1px solid rgba(255, 255, 255, 0.18);
    border-radius: 12px;
    box-shadow: 0 12px 26px rgba(0, 0, 0, 0.16);
}

.ar-helpline-icon {
    flex: 0 0 44px;
    width: 44px;
    height: 44px;
    display: grid;
    place-items: center;
    border-radius: 50%;
    background: rgba(225, 190, 0, 0.16);
    color: var(--ar-gold);
    font-size: 1.05rem;
}

.ar-helpline-content {
    min-width: 0;
    flex: 1;
}

.ar-helpline-role {
    margin: 0 0 3px;
    color: rgba(255, 255, 255, 0.68);
    font-size: 0.72rem;
    font-weight: 700;
    letter-spacing: 0.08em;
    text-transform: uppercase;
}

.ar-helpline-card h4 {
    color: #fff;
    margin: 0 0 12px;
    font-size: 1.05rem;
    line-height: 1.3;
}

.ar-helpline-call {
    display: flex;
    max-width: 100%;
    align-items: center;
    gap: 8px;
    color: var(--ar-gold);
    font-size: 0.8rem;
    font-weight: 600;
    text-decoration: none;
    overflow-wrap: anywhere;
    word-break: break-word;
}

.ar-helpline-call:hover {
    color: #ffe15a;
}

.ar-helpline-hours {
    display: flex;
    align-items: center;
    gap: 6px;
    margin-top: 12px;
    color: rgba(255, 255, 255, 0.7);
    font-size: 0.76rem;
}

.ar-helpline-hours i {
    color: var(--ar-gold);
}

/* FAQS ACCORDION */
.ar-faq-accordion {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.ar-faq-item {
    background: #fff;
    border: 1.5px solid var(--ar-line);
    border-radius: 8px;
    overflow: hidden;
}

.ar-faq-item[open] {
    border-color: var(--ar-brand);
    box-shadow: 0 4px 14px rgba(20, 40, 70, .06);
}

.ar-faq-item summary {
    list-style: none;
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 16px 18px;
    cursor: pointer;
    font-weight: 700;
    font-size: 0.9rem;
    color: var(--ar-ink);
}

.ar-faq-item summary::-webkit-details-marker {
    display: none;
}

.ar-faq-item summary:hover {
    background: #f8fafc;
}

.ar-faq-icon {
    flex-shrink: 0;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    background: #edf3fa;
    color: var(--ar-brand);
    display: grid;
    place-items: center;
    font-size: 0.8rem;
}

.ar-faq-question {
    flex: 1;
}

.ar-faq-chevron {
    flex-shrink: 0;
    color: var(--ar-muted);
    transition: transform 0.2s ease;
}

.ar-faq-item[open] .ar-faq-chevron {
    transform: rotate(180deg);
    color: var(--ar-brand);
}

.ar-faq-answer {
    padding: 0 18px 18px 62px;
    color: var(--ar-muted);
    font-size: 0.92rem;
    line-height: 1.6;
}

.ar-loading {
    text-align: center;
    padding: 30px;
    color: var(--ar-muted);
}

/* 
.ar-track-result {
    padding: 12px;
    background: #eef8f0;
    border-radius: 4px;
    color: #1b5e20;
    font-size: 0.95rem;
} */

/* RESPONSIVE MEDIA QUERIES */
@media (max-width: 1024px) {
    .ar-feature-grid {
        grid-template-columns: repeat(3, 1fr);
    }
}

@media (max-width: 768px) {
    .ar-trust-grid {
        grid-template-columns: repeat(2, 1fr);
    }

    .ar-feature-grid {
        grid-template-columns: repeat(2, 1fr);
    }

    .ar-two-col {
        grid-template-columns: 1fr;
    }

    .ar-resource-row {
        flex-wrap: wrap;
    }

    .ar-resource-download {
        margin-left: 56px;
    }

    .ar-faq-item summary {
        font-size: 0.75rem;
    }

    .ar-committee-contact {
        flex: 1 1 100%;
        width: calc(100% - 58px);
        margin-left: 58px;
        grid-template-columns: minmax(120px, 34%) minmax(0, 1fr);
    }

    /* Keep resource filters evenly sized instead of leaving uneven wrapped rows. */
    #resource-tab-buttons {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    #resource-tab-buttons .ar-tab-btn {
        min-width: 0;
        padding-inline: 12px;
        text-align: center;
    }
}

@media (max-width: 480px) {

    .ar-trust-grid,
    .ar-feature-grid {
        grid-template-columns: 1fr;
    }

    .ar-form-grid {
        grid-template-columns: 1fr;
    }

    .ar-resource-download {
        margin-left: 0;
        width: 100%;
        text-align: center;
    }

    .ar-faq-answer {
        padding-left: 18px;
    }

    .ar-committee-contact {
        width: 100%;
        margin-left: 0;
        grid-template-columns: 1fr;
        gap: 0px;
    }

    .ar-committee-contact a {
        white-space: normal;
        overflow-wrap: anywhere;
    }

    #resource-tab-buttons {
        grid-template-columns: 1fr;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const apiBase = "<?php echo esc_js($api_base); ?>";
    let committeeData = [];

    function escapeHtml(str) {
        if (!str) return '';
        return String(str)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;');
    }

    // Enforce digit-only input on phone numbers
    const phoneInput = document.getElementById('complainant_phone');
    if (phoneInput) {
        phoneInput.addEventListener('input', function() {
            this.value = this.value.replace(/\D/g, '');
        });
    }

    // When "Report anonymously" is checked, clear and lock the identity fields
    const anonCheckbox = document.getElementById('complainant_anonymous');
    const identityFields = ['complainant_name', 'complainant_phone', 'complainant_email'].map(id => document
        .getElementById(id));
    if (anonCheckbox) {
        anonCheckbox.addEventListener('change', function() {
            identityFields.forEach(field => {
                if (!field) return;
                field.disabled = this.checked;
                if (this.checked) field.value = '';
            });
        });
    }

    // Load Committee Members
    let committeeShownCount = 0;
    let activeCommitteeType = 'committee';
    const COMMITTEE_PAGE_SIZE = 6;

    async function loadCommittee() {
        try {
            const res = await fetch(apiBase +
                '/api/v1/antiragging/antiragging-committee-members/?page_size=100');
            if (res.ok) {
                const data = await res.json();
                committeeData = data.results || data;
                filterCommittee('committee');
            }
        } catch (e) {
            document.getElementById('committee-grid').innerHTML =
                '<p class="ar-loading">Committee details currently unavailable.</p>';
        }
    }


    function renderCommitteeRow(m) {
        const displayName = m.faculty_name || m.name || '';
        const nameWords = displayName.replace(/^(dr|mr|mrs|ms|prof|shri|smt)\.?\s+/i, '').split(/\s+/).filter(
            Boolean);
        const initials = nameWords.slice(0, 2).map(w => w[0]).join('').toUpperCase();
        const hasContact = m.phone || m.email;
        return `
        <div class="ar-committee-row">
            <span class="ar-member-avatar">${escapeHtml(initials || '?')}</span>
            <div class="ar-committee-identity">
                <h4>${escapeHtml(displayName)}</h4>
                ${m.affiliation ? `<div class="ar-member-affiliation">${escapeHtml(m.affiliation)}</div>` : ''}
                <div class="ar-member-role">${escapeHtml(m.designation || '')}</div>
                
                ${m.other_designation ? `<div class="ar-member-other-designation">${escapeHtml(m.other_designation)}</div>` : ''}
            </div>
            ${hasContact ? `
            <div class="ar-committee-contact">
                <div class="ar-contact-phone">
                ${m.phone ? '<a href="tel:' + escapeHtml(m.phone) + '"><i class="fas fa-phone"></i> ' + escapeHtml(m.phone) + '</a>' : ''}
                </div>
                <div class="ar-contact-email">
                ${m.email ? '<a href="mailto:' + escapeHtml(m.email) + '"><i class="fas fa-envelope"></i> ' + escapeHtml(m.email) + '</a>' : ''}
                </div>
            </div>` : ''}
        </div>`;
    }

    function currentCommitteeFilter() {
        const searchTerm = (document.getElementById('committee-search').value || '').trim().toLowerCase();
        let items = committeeData.filter(m => m.committee_type === activeCommitteeType);
        if (searchTerm) {
            items = items.filter(m => {
                const name = (m.faculty_name || m.name || '').toLowerCase();
                const designation = (m.designation || '').toLowerCase();
                return name.includes(searchTerm) || designation.includes(searchTerm);
            });
        }
        return items;
    }

    function renderCommitteeList() {
        const filtered = currentCommitteeFilter();
        const container = document.getElementById('committee-grid');
        const loadMoreWrap = document.getElementById('committee-load-more-wrap');
        const loadMoreBtn = document.getElementById('committee-load-more');

        if (filtered.length === 0) {
            container.innerHTML = '<p class="ar-loading">No members match your search.</p>';
            loadMoreWrap.style.display = 'none';
            return;
        }

        const visibleItems = filtered.slice(0, committeeShownCount);
        container.innerHTML = visibleItems.map(renderCommitteeRow).join('');

        if (filtered.length > committeeShownCount) {
            loadMoreWrap.style.display = 'block';
            loadMoreBtn.textContent = `Show More (${filtered.length - committeeShownCount} remaining)`;
        } else {
            loadMoreWrap.style.display = 'none';
        }
    }

    document.getElementById('committee-load-more').addEventListener('click', function() {
        committeeShownCount += COMMITTEE_PAGE_SIZE;
        renderCommitteeList();
    });

    document.getElementById('committee-search').addEventListener('input', function() {
        committeeShownCount = COMMITTEE_PAGE_SIZE;
        renderCommitteeList();
    });

    window.filterCommittee = function(type, el) {
        const buttons = document.querySelectorAll('#committee-members .ar-tab-btn');
        buttons.forEach(btn => btn.classList.remove('active'));
        const activeButton = el || Array.from(buttons).find(btn => btn.textContent.trim().toLowerCase()
            .includes(type));
        if (activeButton) activeButton.classList.add('active');

        activeCommitteeType = type;
        committeeShownCount = COMMITTEE_PAGE_SIZE;
        document.getElementById('committee-search').value = '';
        renderCommitteeList();
    };

    // Load Resources
    let resourceData = [];
    let resourceShownCount = 0;
    const RESOURCE_PAGE_SIZE = 6;

    const CATEGORY_META = {
        ugc_regulations: {
            label: 'UGC Regulations',
            icon: 'fa-gavel'
        },
        university_policy: {
            label: 'University Policy',
            icon: 'fa-university'
        },
        awareness_material: {
            label: 'Awareness Material',
            icon: 'fa-book-open'
        },
        // hostel_safety: {
        //     label: 'Hostel Safety',
        //     icon: 'fa-building'
        // },
        annual_report: {
            label: 'Annual Report',
            icon: 'fa-chart-bar'
        }
    };

    function renderResources(items) {
        const container = document.getElementById('resource-items');
        const loadMoreWrap = document.getElementById('resource-load-more-wrap');
        const loadMoreBtn = document.getElementById('resource-load-more');

        if (items.length === 0) {
            container.innerHTML = '<p class="ar-loading">No resources published in this category yet.</p>';
            loadMoreWrap.style.display = 'none';
            return;
        }

        const visibleItems = items.slice(0, resourceShownCount);
        container.innerHTML = visibleItems.map(r => {
            const meta = CATEGORY_META[r.category] || {
                label: r.category_display || r.category,
                icon: 'fa-file-alt'
            };
            return `
            <div class="ar-resource-row">
                <span class="ar-resource-icon"><i class="fas ${meta.icon}"></i></span>
                <div class="ar-resource-body">
                    <h3>${escapeHtml(r.title)}</h3>
                    <small class="ar-resource-tag">${escapeHtml(meta.label)}</small>
                    
                    ${r.description ? '<p>' + escapeHtml(r.description) + '</p>' : ''}
                </div>
                ${r.file ? '<a class="ar-resource-download" href="' + escapeHtml(r.file) + '" target="_blank" rel="noopener"><i class="fas fa-download"></i> Download</a>' : ''}
            </div>`;
        }).join('');

        if (items.length > resourceShownCount) {
            loadMoreWrap.style.display = 'block';
            loadMoreBtn.textContent = `Show More (${items.length - resourceShownCount} remaining)`;
        } else {
            loadMoreWrap.style.display = 'none';
        }
    }

    document.getElementById('resource-load-more').addEventListener('click', function() {
        resourceShownCount += RESOURCE_PAGE_SIZE;
        renderResources(window.currentResourceFilter());
    });

    async function loadResources() {
        try {
            const res = await fetch(apiBase + '/api/v1/antiragging/resources/?page_size=500');
            if (res.ok) {
                const data = await res.json();
                resourceData = data.results || data;
                resourceShownCount = RESOURCE_PAGE_SIZE;
                renderResources(resourceData);
            }
        } catch (e) {
            document.getElementById('resource-items').innerHTML =
                '<p class="ar-loading">Resources temporarily unavailable.</p>';
        }
    }

    let activeResourceCategory = 'all';
    window.currentResourceFilter = function() {
        return activeResourceCategory === 'all' ? resourceData : resourceData.filter(r => r.category ===
            activeResourceCategory);
    };

    // Filters the Resources grid by category and scrolls it into view.
    // Called both from the tab buttons in the Resources section and from
    // the "View Regulations" / "Explore Materials" / etc. links up top.
    window.switchCategory = function(category, el) {
        const tabButtons = document.querySelectorAll('#resource-tab-buttons .ar-tab-btn');
        tabButtons.forEach(btn => btn.classList.remove('active'));
        const activeButton = (el && el.classList && el.classList.contains('ar-tab-btn')) ?
            el :
            Array.from(tabButtons).find(btn => btn.dataset.category === category);
        if (activeButton) activeButton.classList.add('active');

        activeResourceCategory = category;
        resourceShownCount = RESOURCE_PAGE_SIZE;
        renderResources(window.currentResourceFilter());

        document.getElementById('resources-tab').scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });
    };

    // Load Emergency Contacts
    async function loadEmergencyContacts() {
        try {
            const res = await fetch(apiBase + '/api/v1/antiragging/emergency-contacts/');
            if (res.ok) {
                const data = await res.json();
                const items = data.results || data;
                const container = document.getElementById('emergency-grid');
                if (items.length === 0) {
                    container.innerHTML =
                        '<p class="ar-loading" style="color:rgba(255,255,255,0.7);">No helpline contacts published.</p>';
                    return;
                }
                container.innerHTML = items.map(c => `
                    <div class="ar-helpline-card">
                        <span class="ar-helpline-icon"><i class="fas fa-phone-alt" aria-hidden="true"></i></span>
                        <div class="ar-helpline-content">
                            <h4>${escapeHtml(c.name)}</h4>
                            ${c.role ? '<p class="ar-helpline-role">' + escapeHtml(c.role) + '</p>' : ''}
                            <a class="ar-helpline-call" href="tel:${escapeHtml(c.phone)}" aria-label="Call ${escapeHtml(c.name)} at ${escapeHtml(c.phone)}"><i class="fas fa-phone-alt" aria-hidden="true"></i>${escapeHtml(c.phone)}</a>
                            <a class="ar-helpline-call" href="mailto:${escapeHtml(c.email)}" aria-label="Email ${escapeHtml(c.name)} at ${escapeHtml(c.email)}"><i class="fas fa-envelope" aria-hidden="true"></i>${escapeHtml(c.email)}</a>
                            ${c.available_hours ? '<span class="ar-helpline-hours"><i class="far fa-clock" aria-hidden="true"></i>Available: ' + escapeHtml(c.available_hours) + '</span>' : ''}
                        </div>
                    </div>
                `).join('');
            }
        } catch (e) {
            document.getElementById('emergency-grid').innerHTML =
                '<p class="ar-loading" style="color:rgba(255,255,255,0.7);">Emergency contacts unavailable.</p>';
        }
    }

    // Load FAQs
    async function loadFAQs() {
        try {
            const res = await fetch(apiBase + '/api/v1/antiragging/antiragging-faqs/?page_size=500');
            if (res.ok) {
                const data = await res.json();
                const items = data.results || data;
                const container = document.getElementById('ar-faqs-list');
                if (items.length === 0) {
                    container.innerHTML = '<p class="ar-loading">No FAQs published.</p>';
                    return;
                }
                container.innerHTML = items.map(f => `
                    <details class="ar-faq-item">
                        <summary>
                            <span class="ar-faq-question">${escapeHtml(f.question)}</span>
                            <span class="ar-faq-chevron"><i class="fas fa-chevron-down"></i></span>
                        </summary>
                        <div class="ar-faq-answer">${escapeHtml(f.answer)}</div>
                    </details>
                `).join('');
            }
        } catch (e) {
            document.getElementById('ar-faqs-list').innerHTML =
                '<p class="ar-loading">FAQs temporarily unavailable.</p>';
        }
    }

    // Handle Incident Reporting Form
    /* const complaintForm = document.getElementById('antiragging-complaint-form');
     if (complaintForm) {
         complaintForm.addEventListener('submit', async function(e) {
             e.preventDefault();
             const msgBox = document.getElementById('complaint-form-message');
             const submitButton = complaintForm.querySelector('button[type="submit"]');
             const isAnonymous = document.getElementById('complainant_anonymous').checked;

             // Reset any styling left over from a previous error before this attempt
             msgBox.style.display = 'none';
             msgBox.style.background = '';
             msgBox.style.color = '';

             const rawFormData = new FormData(complaintForm);
             const locationText = (rawFormData.get('location') || '').trim();
             const descriptionText = (rawFormData.get('description') || '').trim();

             const payload = new FormData();
             payload.set('category', 'ragging');
             payload.set('is_anonymous', isAnonymous ? 'true' : 'false');
             payload.set('complainant_name', isAnonymous ? '' : (rawFormData.get(
                 'complainant_name') || '').trim());
             payload.set('phone', isAnonymous ? '' : (rawFormData.get('phone') || '').trim());
             payload.set('email', isAnonymous ? '' : (rawFormData.get('email') || '').trim());
             payload.set('description', `Location: ${locationText}\n\nDetails: ${descriptionText}`);
             const evidenceFile = complaintForm.querySelector('[name="evidence"]').files[0];
             if (evidenceFile) payload.set('evidence', evidenceFile);

             submitButton.disabled = true;
             const originalButtonHtml = submitButton.innerHTML;
             submitButton.innerHTML = 'Submitting…';

             try {
                 const res = await fetch(apiBase + '/api/v1/portals/grievances/', {
                     method: 'POST',
                     body: payload
                 });

                 let data = null;
                 try {
                     data = await res.json();
                 } catch (parseError) {
                     data = null;
                 }

                 if (!res.ok) {
                     throw new Error((data && data.detail) ||
                         'Failed to submit report. Please try again in a few minutes.');
                 }
                 if (!data) {
                     throw new Error(
                         'Submitted, but the server response could not be read. Please note the time and check with us if you don\'t receive confirmation.'
                     );
                 }

                 msgBox.textContent = 'Report submitted successfully. Your tracking code is: ' + (
                     data.tracking_id || data.id);
                 msgBox.style.display = 'block';
                 complaintForm.reset();
                 identityFields.forEach(field => {
                     if (field) field.disabled = false;
                 });
             } catch (err) {
                 msgBox.textContent = err.message || 'Submission failed. Please try again.';
                 msgBox.style.display = 'block';
                 msgBox.style.background = '#f8d7da';
                 msgBox.style.color = '#721c24';
             }
             submitButton.disabled = false;
             submitButton.innerHTML = originalButtonHtml;
         });
     }*/

    loadCommittee();
    loadResources();
    loadEmergencyContacts();
    loadFAQs();
});
</script>

<?php
get_footer();
