<?php
/**
 * 
 * Template Name: Affidavit Portal
 *
 */
defined('ABSPATH') || exit;
get_header();

$api_base = getenv('DJANGO_MEDIA_URL');
?>

<main id="primary" class="antiragging-portal">
    <?php get_template_part('banners/new-banner'); ?>

    <section class="ar-trust" aria-label="Portal benefits">
        <div class="container ar-trust-grid">
            <div><span class="ar-trust-icon"><i class="fas fa-shield-alt"></i></span><strong>Safe &amp;
                    confidential</strong><small>Your information is protected.</small></div>
            <div><span class="ar-trust-icon"><i class="fas fa-file-upload"></i></span><strong>Easy
                    submission</strong><small>Complete the process online.</small></div>
            <div><span class="ar-trust-icon"><i class="fas fa-user-check"></i></span><strong>Digital
                    verification</strong><small>Reviewed by the University.</small></div>
            <div><span class="ar-trust-icon"><i class="fas fa-search-location"></i></span><strong>Real-time
                    tracking</strong><small>Check your submission status.</small></div>
        </div>
    </section>
    <div class="container">
        <?php get_template_part('template-parts/breadcrumb'); ?>
        <?php get_template_part('menu/menu');?>
    </div>

    <section class="ar-section" id="about">
        <div class="container">
            <div class="ar-section-heading"><span class="ar-kicker">HOW IT WORKS</span>
                <h2>Safe campus, shared responsibility</h2>
                <p>Ragging is prohibited. Students and parents can use this portal to submit affidavits,
                    read official guidance and reach the appropriate support channel.</p>
            </div>
            <div class="ar-feature-grid">
                <article class="ar-feature"><span class="ar-feature-icon"><i class="fas fa-upload"></i></span>
                    <h3>Online submission</h3>
                    <p>Submit student and parent affidavits in a few simple steps.</p><a href="#submit-affidavit">Start
                        now <i class="fas fa-arrow-right"></i></a>
                </article>
                <article class="ar-feature"><span class="ar-feature-icon"><i class="fas fa-check-circle"></i></span>
                    <h3>Check Status</h3>
                    <p>Track the status of your affidavit submission in real-time.</p><a href="#track-status">Track
                        Status<i class="fas fa-arrow-right"></i></a>
                </article>
                <article class="ar-feature"><span class="ar-feature-icon"><i class="fas fa-file-pdf"></i></span>
                    <h3>Sample affidavits</h3>
                    <p>Download official student and parent affidavit formats.</p><a href="#resources">Download samples
                        <i class="fas fa-arrow-right"></i></a>
                </article>
                <article class="ar-feature"><span class="ar-feature-icon"><i class="fas fa-book"></i></span>
                    <h3>Submission Guidelines</h3>
                    <p>Read important instructions and guidelines before submitting.</p><a href="#materials">View
                        Guidelines <i class="fas fa-arrow-right"></i></a>
                </article>
                <article class="ar-feature"><span class="ar-feature-icon"><i class="fas fa-question-circle"></i></span>
                    <h3>FAQs</h3>
                    <p>Find answers to common questions about submission.</p><a href="#faqs">View FAQs <i
                            class="fas fa-arrow-right"></i></a>
                </article>
            </div>
        </div>
    </section>

    <section class="ar-section ar-section-soft" id="submit-affidavit">
        <div class="ar-container ar-two-col">
            <div class="ar-section-heading"><span class="ar-kicker">ONLINE SUBMISSION</span>
                <h2>Submit your affidavits online</h2>
                <p>Upload signed student and parent affidavits as a PDF or Word document. Keep the tracking ID you
                    receive after
                    submission.</p>
                <div class="ar-notice"><strong>Before you submit</strong><br>Ensure both documents are signed, legible
                    and less than 10 MB each.</div>
            </div>
            <form class="ar-form" id="ar-affidavit-form" enctype="multipart/form-data">
                <div class="ar-form-message" role="status" hidden></div>
                <div class="ar-form-grid">
                    <label>Student Name *<input required name="student_name" type="text"></label>
                    <label>Roll Number *<input required name="roll_number" id="roll_number" type="text"></label>
                    <label>Enrollment Number *<input required name="enrollment_number" type="text"></label>
                    <label>Program / Course Name<input name="program_name" type="text"></label>
                    <label>Department *
                        <select required name="department" id="ar_department">
                            <option value="">Select Department</option>
                        </select>
                    </label>
                    <label>Student Phone *<input required name="student_phone" id="student_phone" type="tel"
                            inputmode="numeric" maxlength="10" pattern="[6-9][0-9]{9}"
                            title="10-digit mobile number"></label>
                    <label>Student Email *<input required name="student_email" id="student_email" type="email"></label>
                    <label>Parent/Guardian Name *<input required name="parent_name" type="text"></label>
                    <label>Parent/Guardian Phone *<input required name="parent_phone" id="parent_phone" type="tel"
                            inputmode="numeric" maxlength="10" pattern="[6-9][0-9]{9}"
                            title="10-digit mobile number"></label>
                    <label>Student Affidavit (PDF/Doc) *<input required name="student_affidavit" type="file"
                            accept="application/pdf,.pdf,.doc,.docx"></label>
                    <label>Parent Affidavit (PDF/Doc) *<input required name="parent_affidavit" type="file"
                            accept="application/pdf,.pdf,.doc,.docx"></label>
                </div>
                <label class="ar-check"><input required type="checkbox" name="declaration_accepted" value="true"> I
                    confirm that the information and documents submitted are correct.</label>
                <button class="ar-button ar-button-primary" type="submit">Submit securely <i
                        class="fas fa-arrow-right"></i></button>
            </form>
        </div>
    </section>

    <section class="ar-section" id="track-status">
        <div class="ar-container ar-two-col ar-track-row">
            <div><span class="ar-kicker">TRACK YOUR SUBMISSION</span>
                <h2>Check affidavit status</h2>
                <p>Enter the tracking ID received after submitting your affidavits.</p>
            </div>
            <form class="ar-track-form" id="ar-track-form"><label class="screen-reader-text"
                    for="ar-tracking-id">Tracking ID</label><input id="ar-tracking-id" required
                    placeholder="Example: ARA-202608-0001"><button class="ar-button ar-button-primary"
                    type="submit">Track status</button>
                <div class="ar-track-result" role="status" hidden></div>
            </form>
        </div>
    </section>

    <section class="ar-section ar-section-soft" id="materials">
        <div class="ar-container">
            <div class="ar-section-heading"><span class="ar-kicker">SUBMISSION GUIDELINES</span>
                <h2>Resources and guidelines</h2>
            </div>
            <div class="ar-content-grid" id="ar-documents">
                <div class="ar-loading"><i class="fas fa-spinner fa-spin"></i> Loading submission guidelines…</div>
            </div>
        </div>
    </section>


    <section class="ar-section" id="resources">
        <div class="ar-container">
            <div class="ar-section-heading"><span class="ar-kicker">SAMPLE AFFIDAVITS</span>
                <h2>Sample affidavits for students and parents</h2>
            </div>
            <div class="ar-content-grid" id="ar-materials">
                <div class="ar-loading"><i class="fas fa-spinner fa-spin"></i> Loading sample affidavits…</div>
            </div>
        </div>
    </section>

    <section class="ar-section ar-section-soft" id="faqs">
        <div class="ar-container">
            <div class="ar-section-heading"><span class="ar-kicker">QUESTIONS &amp; ANSWERS</span>
                <h2>Frequently asked questions</h2>
            </div>
            <div class="ar-faq-accordion" id="ar-faqs">
                <div class="ar-loading">Loading frequently asked questions…</div>
            </div>
        </div>
    </section>

    <!-- <section class="ar-section ar-section-soft" id="helplines">
            <div class="ar-container">
                <div class="ar-section-heading"><span class="ar-kicker">NEED HELP?</span>
                    <h2>Helplines and emergency contacts</h2>
                </div>
                <div class="ar-helpline-grid" id="ar-helplines">
                    <div class="ar-loading">Loading helplines…</div>
                </div>
            </div>
        </section> -->
</main>

<div class="ar-success-modal" id="ar-success-modal" hidden role="dialog" aria-modal="true"
    aria-labelledby="ar-success-title">
    <div class="ar-success-backdrop" data-ar-close-success></div>
    <div class="ar-success-dialog">
        <button class="ar-success-close" type="button" aria-label="Close" data-ar-close-success>&times;</button>
        <div class="ar-success-check"><i class="fas fa-check"></i></div>
        <h2 id="ar-success-title">Affidavit submitted successfully</h2>
        <p>Please save this tracking ID to check your verification status later.</p>
        <div class="ar-tracking-highlight">
            <small>YOUR TRACKING ID</small>
            <strong id="ar-success-tracking-id"></strong>
        </div>
        <div class="ar-success-actions">
            <button class="ar-button ar-button-secondary" type="button" id="ar-copy-tracking-id"><i
                    class="fas fa-copy"></i> Copy tracking ID</button>
            <!-- <button class="ar-button ar-button-secondary" type="button" data-ar-close-success>Continue</button> -->
        </div>
        <span class="ar-copy-feedback" id="ar-copy-feedback" role="status" hidden>Tracking ID copied.</span>
    </div>
</div>

<style>
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
    font: 16px/1.55 system-ui, -apple-system, "Segoe UI", sans-serif
}

.ar-container {
    width: min(1120px, 92%);
    margin: auto
}

.ar-eyebrow,
.ar-kicker {
    font-size: .76rem;
    font-weight: 700;
    letter-spacing: .13em
}

.ar-eyebrow {
    color: #f0d47d
}

.ar-button {
    display: inline-flex;
    align-items: center;
    gap: 18px;
    border: 0;
    border-radius: 4px;
    padding: 13px 19px;
    font-weight: 750;
    text-decoration: none;
    cursor: pointer
}

.ar-button-primary {
    background: var(--ar-gold);
    color: var(--ar-ink)
}

.ar-button-ghost {
    border: 1px solid rgba(255, 255, 255, .6);
    background: transparent;
    color: #fff
}

.ar-trust {
    background: #fff;
    border-bottom: 1px solid var(--ar-line)
}

.ar-trust-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px
}

.ar-trust-grid>div {
    display: grid;
    grid-template-columns: 44px 1fr;
    column-gap: 10px;
    align-items: center;
    padding: 18px 0
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
    font-weight: 700
}

.ar-trust-grid strong,
.ar-trust-grid small {
    grid-column: 2
}

.ar-trust-grid small {
    color: var(--ar-muted);
    font-size: .78rem
}

.ar-trust-icon {
    grid-row: 1/3;
    grid-column: 1
}

.ar-section {
    padding: 30px 0
}

.ar-section-soft {
    background: #fff
}

.ar-section-heading {
    max-width: 720px;
    margin-bottom: 30px
}

.ar-kicker {
    color: var(--ar-brand)
}

.ar-section h2 {
    font-size: clamp(1.8rem, 3.5vw, 2.7rem);
    line-height: 1.12;
    margin: 10px 0 14px
}

.ar-section p {
    color: var(--ar-muted)
}

.ar-feature-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 18px
}

.ar-feature {
    padding: 20px 15px;
    text-align: center;
    background: #fff;
    border: 1px solid var(--ar-line);
    border-radius: 10px;
    box-shadow: 0 5px 18px rgba(20, 40, 70, .05)
}

.ar-feature-icon {
    margin: 0 auto 15px
}

.ar-feature h3 {
    font-size: 1.05rem
}

.ar-feature a,
.ar-resource {
    color: var(--ar-brand);
    font-weight: 700;
    text-decoration: none
}

.ar-feature p {
    font-size: .9rem
}

.ar-two-col {
    display: grid;
    grid-template-columns: 1fr;
    gap: 10px;
    align-items: start
}

.ar-notice {
    margin-top: 24px;
    border-left: 4px solid var(--ar-gold);
    background: #fff8df;
    padding: 16px 18px;
    font-size: .9rem
}

.ar-form {
    background: #fff;
    border: 1px solid var(--ar-line);
    border-radius: 7px;
    padding: 26px;
    box-shadow: 0 5px 18px rgba(20, 40, 70, .05)
}

.ar-form-message {
    display: block;
    margin: 0 0 22px;
    border-radius: 8px;
    padding: 16px 18px;
    font-size: 1rem;
    font-weight: 700;
    line-height: 1.45;
}

.ar-form-message.is-success {
    border: 2px solid #198754;
    background: #e8f7ee;
    color: #0d5c35;
    box-shadow: 0 4px 12px rgba(25, 135, 84, .16);
}

.ar-form-message.is-error {
    border: 1px solid #dc3545;
    background: #fff0f1;
    color: #8b1e2d;
}

.ar-success-modal[hidden] {
    display: none;
}

.ar-success-modal {
    position: fixed;
    inset: 0;
    z-index: 99999;
    display: grid;
    place-items: center;
    padding: 20px;
}

.ar-success-backdrop {
    position: absolute;
    inset: 0;
    background: rgba(8, 20, 35, .72);
    backdrop-filter: blur(3px);
}

.ar-success-dialog {
    position: relative;
    width: min(500px, 100%);
    padding: 34px 30px 30px;
    border-radius: 12px;
    background: #fff;
    text-align: center;
    box-shadow: 0 18px 60px rgba(0, 0, 0, .3);
    animation: ar-success-pop .18s ease-out;
}

.ar-success-close {
    position: absolute;
    top: 8px;
    right: 13px;
    border: 0;
    background: transparent;
    color: #657083;
    font-size: 30px;
    line-height: 1;
    cursor: pointer;
}

.ar-success-check {
    width: 58px;
    height: 58px;
    display: grid;
    place-items: center;
    margin: 0 auto 14px;
    border-radius: 50%;
    background: #d9f3e4;
    color: #198754;
    font-size: 1.55rem;
}

.ar-success-dialog h2 {
    margin: 0 0 8px;
    color: #172033;
    font-size: 1.55rem;
}

.ar-success-dialog p {
    margin: 0 auto 20px;
    color: #657083;
}

.ar-tracking-highlight {
    margin: 20px 0;
    padding: 18px 16px;
    border: 2px dashed #d6a531;
    border-radius: 8px;
    background: #fff9e6;
}

.ar-tracking-highlight small {
    display: block;
    margin-bottom: 6px;
    color: #856404;
    font-size: .75rem;
    font-weight: 800;
    letter-spacing: .12em;
}

.ar-tracking-highlight strong {
    display: block;
    color: #172033;
    font-size: clamp(1.3rem, 5vw, 1.0rem);
    word-break: break-word;
}

.ar-success-actions {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    gap: 10px;
}

.ar-button-secondary {
    border: 1px solid #cfd6e1;
    background: #f5f7fb;
    color: #172033;
}

.ar-copy-feedback {
    display: block;
    margin-top: 12px;
    color: #198754;
    font-size: .85rem;
    font-weight: 700;
}

@keyframes ar-success-pop {
    from {
        opacity: 0;
        transform: scale(.94);
    }

    to {
        opacity: 1;
        transform: scale(1);
    }
}

body.ar-modal-open {
    overflow: hidden;
}

.ar-form-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 16px
}

.ar-form label {
    display: flex;
    flex-direction: column;
    gap: 6px;
    font-size: .88rem;
    font-weight: 700
}

.ar-form input,
.ar-form select,
.ar-track-form input {
    border: 1px solid #cfd6e1;
    border-radius: 4px;
    padding: 11px 12px;
    font: inherit;
    background: #fff
}

.ar-check {
    flex-direction: row !important;
    align-items: center;
    margin: 20px 0;
    font-weight: 500 !important
}

.ar-check input {
    width: 18px
}

.ar-track-row {
    align-items: center
}

.ar-track-form {
    display: flex;
    flex-wrap: wrap;
    gap: 10px
}

.ar-track-form input {
    flex: 1 1 240px
}

.ar-track-result {
    flex-basis: 100%;
    margin-top: 15px;
    background: #fff;
    border: 1px solid var(--ar-line);
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0 4px 14px rgba(20, 40, 70, .06);
}

.ar-track-meta {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 12px;
    padding-bottom: 16px;
    border-bottom: 1px solid var(--ar-line);
    margin-bottom: 18px;
}

.ar-track-meta-item small {
    display: block;
    color: var(--ar-muted);
    font-size: 0.78rem;
    text-transform: uppercase;
    font-weight: 700;
}

.ar-track-meta-item strong {
    font-size: 0.95rem;
    color: var(--ar-ink);
}

.ar-status-badge {
    display: inline-block;
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.status-submitted {
    background: #fff3cd;
    color: #856404;
}

.status-under_verification,
.status-under_review {
    background: #d1ecf1;
    color: #0c5460;
}

.status-verified,
.status-resolved {
    background: #d4edda;
    color: #155724;
}

.status-rejected {
    background: #f8d7da;
    color: #721c24;
}

.ar-timeline-title {
    font-size: 0.95rem;
    font-weight: 750;
    color: var(--ar-brand);
    margin-bottom: 14px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.ar-timeline {
    position: relative;
    padding-left: 24px;
    margin: 0;
    list-style: none;
}

.ar-timeline::before {
    content: '';
    position: absolute;
    top: 6px;
    bottom: 6px;
    left: 7px;
    width: 2px;
    background: var(--ar-line);
}

.ar-timeline-item {
    position: relative;
    margin-bottom: 18px;
}

.ar-timeline-item:last-child {
    margin-bottom: 0;
}

.ar-timeline-dot {
    position: absolute;
    left: -24px;
    top: 4px;
    width: 16px;
    height: 16px;
    border-radius: 50%;
    background: var(--ar-brand);
    border: 3px solid #fff;
    box-shadow: 0 0 0 1px var(--ar-brand);
}

.ar-timeline-item:last-child .ar-timeline-dot {
    background: var(--ar-gold);
    box-shadow: 0 0 0 1px var(--ar-gold);
}

.ar-timeline-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 6px;
    margin-bottom: 4px;
}

.ar-timeline-header strong {
    font-size: 0.9rem;
    color: var(--ar-ink);
}

.ar-timeline-time {
    font-size: 0.78rem;
    color: var(--ar-muted);
}

.ar-timeline-desc {
    font-size: 0.85rem;
    color: var(--ar-muted);
    margin: 0;
    line-height: 1.45;
}

.ar-resource-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 0 28px
}

.ar-content-grid,
.ar-people-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 18px
}

.ar-content-card,
.ar-person-card,
.ar-helpline-card {
    display: block;
    background: #fff;
    border: 1px solid var(--ar-line);
    border-radius: 7px;
    padding: 20px;
    box-shadow: 0 5px 18px rgba(20, 40, 70, .05)
}

.ar-content-card h3,
.ar-person-card h3 {
    margin: 0 0 8px;
    font-size: 1.05rem
}

.ar-content-card p,
.ar-person-card p {
    font-size: .9rem;
    margin: 7px 0
}

.ar-content-card a {
    color: var(--ar-brand);
    font-weight: 700;
    text-decoration: none
}

.ar-person-card small {
    display: inline-block;
    color: var(--ar-brand);
    font-weight: 750;
    margin-bottom: 8px
}

.ar-helpline-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 18px
}

.ar-helpline-card strong,
.ar-helpline-card a {
    display: block
}

.ar-helpline-card a {
    color: var(--ar-brand);
    font-weight: 700;
    text-decoration: none
}

.ar-loading {
    color: var(--ar-muted);
    padding: 20px 0
}

.ar-faq-accordion {
    display: flex;
    flex-direction: column;
    gap: 10px
}

.ar-faq-item {
    background: #fff;
    border: 1px solid var(--ar-line);
    border-radius: 8px;
    overflow: hidden
}

.ar-faq-item[open] {
    border-color: var(--ar-brand, #173d6b);
    box-shadow: 0 4px 14px rgba(20, 40, 70, .06)
}

.ar-faq-item summary {
    list-style: none;
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 16px 18px;
    cursor: pointer;
    font-weight: 700;
    color: var(--ar-ink)
}

.ar-faq-item summary::-webkit-details-marker {
    display: none
}

.ar-faq-item summary:hover {
    background: #f8fafc
}

/* .ar-faq-icon {
    flex-shrink: 0;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    background: #edf3fa;
    color: var(--ar-brand, #173d6b);
    display: grid;
    place-items: center;
    font-size: .8rem
} */

.ar-faq-question {
    flex: 1
}

.ar-faq-chevron {
    flex-shrink: 0;
    color: var(--ar-muted);
    transition: transform .2s ease
}

.ar-faq-item[open] .ar-faq-chevron {
    transform: rotate(180deg);
    color: var(--ar-brand, #173d6b)
}

.ar-faq-answer {
    padding: 0 18px 18px 62px;
    color: var(--ar-muted);
    font-size: .92rem;
    line-height: 1.6
}

.screen-reader-text {
    position: absolute;
    width: 1px;
    height: 1px;
    padding: 0;
    margin: -1px;
    overflow: hidden;
    clip: rect(0, 0, 0, 0);
    white-space: nowrap;
    border: 0
}

@media(max-width:1024px) {
    .ar-feature-grid {
        grid-template-columns: repeat(3, 1fr);
    }
}

@media(max-width:800px) {

    .ar-feature-grid,
    .ar-content-grid,
    .ar-people-grid,
    .ar-helpline-grid {
        grid-template-columns: repeat(2, 1fr);
    }

    .ar-trust-grid {
        grid-template-columns: repeat(2, 1fr);
    }

    .ar-two-col {
        grid-template-columns: 1fr;
        gap: 25px;
    }
}

@media(max-width:560px) {
    .ar-faq-answer {
        padding-left: 18px;
    }

    .ar-feature-grid,
    .ar-trust-grid,
    .ar-form-grid,
    .ar-resource-grid,
    .ar-content-grid,
    .ar-people-grid,
    .ar-helpline-grid {
        grid-template-columns: 1fr;
    }

    .ar-section {
        padding: 40px 0;
    }

    .ar-form {
        padding: 18px;
    }

    .ar-track-form {
        flex-direction: column;
    }

    .ar-track-form input,
    .ar-track-form button {
        width: 100%;
    }
}
</style>

<script>
(function() {
    const apiBase = <?php echo wp_json_encode(esc_url_raw($api_base)); ?>.replace(/\/$/, '');
    const form = document.getElementById('ar-affidavit-form');
    const message = form.querySelector('.ar-form-message');

    ['student_phone', 'parent_phone'].forEach(id => {
        const input = document.getElementById(id);
        if (input) {
            input.addEventListener('input', function() {
                this.value = this.value.replace(/\D/g, '');
            });
        }
    });

    form.addEventListener('submit', async function(event) {
        event.preventDefault();
        const button = form.querySelector('button');
        message.hidden = false;
        message.textContent = '';

        const studentPhone = form.querySelector('[name="student_phone"]').value.trim();
        const parentPhone = form.querySelector('[name="parent_phone"]').value.trim();
        const studentEmail = form.querySelector('[name="student_email"]').value.trim();

        // Phone check: 10 digits
        const phoneRegex = /^[6-9]\d{9}$/;
        if (!phoneRegex.test(studentPhone)) {
            message.textContent = 'Student phone number must be a valid 10-digit number.';
            message.className = 'ar-form-message is-error';
            return;
        }
        if (parentPhone && !phoneRegex.test(parentPhone)) {
            message.textContent = 'Parent phone number must be a valid 10-digit number.';
            message.className = 'ar-form-message is-error';
            return;
        }

        // Email check
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(studentEmail)) {
            message.textContent = 'Please enter a valid email address.';
            message.className = 'ar-form-message is-error';
            return;
        }

        // File size check (matches the 10 MB notice above the form)
        const maxBytes = 5 * 1024 * 1024;
        const studentFile = form.querySelector('[name="student_affidavit"]').files[0];
        const parentFile = form.querySelector('[name="parent_affidavit"]').files[0];
        if (studentFile && studentFile.size > maxBytes) {
            message.textContent = 'Student affidavit file must be under 5 MB.';
            message.className = 'ar-form-message is-error';
            return;
        }
        if (parentFile && parentFile.size > maxBytes) {
            message.textContent = 'Parent affidavit file must be under 5 MB.';
            message.className = 'ar-form-message is-error';
            return;
        }

        button.disabled = true;
        button.textContent = 'Submitting…';
        try {
            const response = await fetch(apiBase + '/api/v1/affidavits/affidavits/', {
                method: 'POST',
                body: new FormData(form)
            });

            let data = null;
            try {
                data = await response.json();
            } catch (parseError) {
                data = null;
            }

            if (!response.ok) {
                let errStr = '';
                if (data && typeof data === 'object') {
                    errStr = Object.entries(data).map(([k, v]) =>
                        `${k}: ${Array.isArray(v) ? v.join(', ') : v}`).join(' | ');
                }
                throw new Error(errStr || 'Submission failed. Please try again in a few minutes.');
            }
            if (!data) {
                throw new Error(
                    'Submitted, but the server response could not be read. Please note the time and check with us if you don\'t receive confirmation.'
                );
            }

            const trackingId = data.tracking_id || '';
            message.innerHTML =
                '<i class="fas fa-check-circle"></i> Submitted successfully. Your tracking ID is <strong>' +
                escapeHtml(trackingId) + '</strong>';
            message.className = 'ar-form-message is-success';
            form.reset();
            showSuccessModal(trackingId);
        } catch (error) {
            message.textContent = error.message || 'Submission failed. Please try again.';
            message.className = 'ar-form-message is-error';
        }
        button.disabled = false;
        button.innerHTML = 'Submit securely <i class="fas fa-arrow-right"></i>';
    });

    document.getElementById('ar-track-form').addEventListener('submit', async function(event) {
        event.preventDefault();
        const id = document.getElementById('ar-tracking-id').value.trim();
        const result = this.querySelector('.ar-track-result');
        const trackButton = this.querySelector('button');
        result.hidden = false;
        result.innerHTML =
            '<p class="ar-loading" style="margin:0;"><i class="fas fa-spinner fa-spin"></i> Checking status…</p>';
        trackButton.disabled = true;
        try {
            const response = await fetch(apiBase + '/api/v1/affidavits/affidavits/track/' +
                encodeURIComponent(id) + '/');
            const data = await response.json();
            if (!response.ok) throw new Error(data.error || 'Tracking ID not found.');

            const statusClass = 'status-' + (data.status || '').toLowerCase();
            const statusDisplay = escapeHtml(data.status_display || (data.status || '').replace('_',
                ' ').toUpperCase());
            const studentName = escapeHtml(data.student_name || 'N/A');
            const rollNo = escapeHtml(data.roll_number || 'N/A');
            const deptName = escapeHtml(data.department_name || 'General');

            // Format Timeline
            let timelineHtml = '';
            const historyList = (data.history && Array.isArray(data.history) && data.history.length >
                0) ? data.history : [{
                date: data.submitted_on,
                status: data.status,
                status_display: statusDisplay,
                description: 'Affidavit submitted online by student.',
                remarks: data.remarks
            }];

            timelineHtml = historyList.map(item => {
                const itemDate = new Date(item.date);
                const dateStr = !isNaN(itemDate.getTime()) ? itemDate.toLocaleDateString(
                    'en-IN', {
                        year: 'numeric',
                        month: 'short',
                        day: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit'
                    }) : escapeHtml(item.date);

                const itemStatusClass = 'status-' + (item.status || '').toLowerCase();
                const itemStatusDisplay = escapeHtml(item.status_display || (item.status || '')
                    .replace('_', ' ').toUpperCase());
                const itemDesc = escapeHtml(item.description || item.remarks ||
                    'Status updated');

                return `
                    <li class="ar-timeline-item">
                        <span class="ar-timeline-dot"></span>
                        <div class="ar-timeline-content">
                            <div class="ar-timeline-header">
                                <div>
                                    <span class="ar-status-badge ${itemStatusClass}">${itemStatusDisplay}</span>
                                </div>
                                <span class="ar-timeline-time"><i class="far fa-clock"></i> ${dateStr}</span>
                            </div>
                            <p class="ar-timeline-desc">${itemDesc}</p>
                        </div>
                    </li>
                `;
            }).join('');

            result.innerHTML = `
                <div class="ar-track-meta">
                    <div class="ar-track-meta-item">
                        <small>Tracking ID</small>
                        <strong>${escapeHtml(data.tracking_id || id)}</strong>
                    </div>
                    <div class="ar-track-meta-item">
                        <small>Current Status</small>
                        <span class="ar-status-badge ${statusClass}">${statusDisplay}</span>
                    </div>
                    <div class="ar-track-meta-item">
                        <small>Student Name</small>
                        <strong>${studentName}</strong>
                    </div>
                    <div class="ar-track-meta-item">
                        <small>Roll / Dept</small>
                        <strong>${rollNo} (${deptName})</strong>
                    </div>
                </div>
                <div class="ar-timeline-title"><i class="fas fa-history"></i> Status History</div>
                <ul class="ar-timeline">
                    ${timelineHtml}
                </ul>
            `;
        } catch (error) {
            result.innerHTML =
                `<p style="color: #721c24; margin:0;"><i class="fas fa-exclamation-circle"></i> ${escapeHtml(error.message || 'Tracking ID not found.')}</p>`;
        }
        trackButton.disabled = false;
    });

    function escapeHtml(value) {
        const div = document.createElement('div');
        div.textContent = value || '';
        return div.innerHTML;
    }

    const successModal = document.getElementById('ar-success-modal');
    const successTrackingId = document.getElementById('ar-success-tracking-id');
    const copyTrackingButton = document.getElementById('ar-copy-tracking-id');
    const copyFeedback = document.getElementById('ar-copy-feedback');

    function showSuccessModal(trackingId) {
        successTrackingId.textContent = trackingId || 'Please contact support';
        successModal.hidden = false;
        document.body.classList.add('ar-modal-open');
        successModal.querySelector('.ar-success-close').focus();
    }

    function closeSuccessModal() {
        successModal.hidden = true;
        document.body.classList.remove('ar-modal-open');
    }

    successModal.querySelectorAll('[data-ar-close-success]').forEach(function(button) {
        button.addEventListener('click', closeSuccessModal);
    });

    copyTrackingButton.addEventListener('click', async function() {
        const trackingId = successTrackingId.textContent;
        try {
            await navigator.clipboard.writeText(trackingId);
            copyFeedback.hidden = false;
            setTimeout(function() {
                copyFeedback.hidden = true;
            }, 2500);
        } catch (error) {
            const fallback = document.createElement('textarea');
            fallback.value = trackingId;
            fallback.setAttribute('readonly', '');
            fallback.style.position = 'fixed';
            fallback.style.opacity = '0';
            document.body.appendChild(fallback);
            fallback.focus();
            fallback.select();
            const copied = document.execCommand('copy');
            fallback.remove();
            copyFeedback.textContent = copied ? 'Tracking ID copied.' : 'Please select and copy the tracking ID above.';
            copyFeedback.hidden = false;
        }
    });

    async function loadPortalContent() {
        // Load Guidelines
        try {
            const res = await fetch(apiBase + '/api/v1/affidavits/affidavit-guidelines/?page_size=100');
            if (res.ok) {
                const data = await res.json();
                const items = data.results || data;
                document.getElementById('ar-documents').innerHTML = items.map(function(item) {
                    return '<article class="ar-content-card"><h3>' + escapeHtml(item.title) +
                        '</h3><p>' + escapeHtml(item.content) + '</p></article>';
                }).join('') || '<p class="ar-loading">No guidelines currently published.</p>';
            }
        } catch (e) {
            document.getElementById('ar-documents').innerHTML =
                '<p class="ar-loading">Guidelines temporarily unavailable.</p>';
        }

        // Load Sample Affidavits
        try {
            const res = await fetch(apiBase + '/api/v1/affidavits/sample-affidavits/');
            if (res.ok) {
                const data = await res.json();
                const items = data.results || data;
                document.getElementById('ar-materials').innerHTML = items.map(function(item) {
                    const categoryLabel = item.affidavit_category === 'STUDENT' ? 'Student Sample' :
                        'Parent Sample';
                    return '<article class="ar-content-card"><h3>' + escapeHtml(item.title) +
                        '</h3><p>Category: ' + escapeHtml(categoryLabel) + '</p>' +
                        (item.file ? '<a target="_blank" rel="noopener" href="' + escapeHtml(item
                                .file) + '">Download Sample <i class="fas fa-arrow-right"></i></a>' :
                            '') +
                        '</article>';
                }).join('') || '<p class="ar-loading">No sample affidavits currently published.</p>';
            }
        } catch (e) {
            document.getElementById('ar-materials').innerHTML =
                '<p class="ar-loading">Sample affidavits temporarily unavailable.</p>';
        }

        // Load Departments dropdown
        try {
            const res = await fetch(apiBase + '/api/v1/departments/');
            if (res.ok) {
                const data = await res.json();
                const items = data.results || data;
                const deptSelect = document.getElementById('ar_department');
                if (deptSelect && Array.isArray(items)) {
                    deptSelect.innerHTML = '<option value="">Select Department</option>' + items.map(function(
                        dept) {
                        const displayName = dept.campus === 'Satellite Campus Amethi' ?
                            `${dept.name} (Amethi)` : dept.name;
                        return '<option value="' + escapeHtml(dept.id) + '">' + escapeHtml(
                                displayName) +
                            '</option>';
                    }).join('');
                }
            }
        } catch (e) {
            console.error('Failed to load departments:', e);
        }

        // Load FAQs
        try {
            const res = await fetch(apiBase + '/api/v1/affidavits/affidavit-faqs/?page_size=200');
            if (res.ok) {
                const data = await res.json();
                const items = data.results || data;
                document.getElementById('ar-faqs').innerHTML = items.map(function(item) {
                    return '<details class="ar-faq-item">' +
                        '<summary>' +
                        '<span class="ar-faq-question">' + escapeHtml(item.question) + '</span>' +
                        '<span class="ar-faq-chevron"><i class="fas fa-chevron-down"></i></span></summary>' +
                        '<div class="ar-faq-answer">' + escapeHtml(item.answer) + '</div></details>';
                }).join('') || '<p class="ar-loading">No FAQs currently published.</p>';
            }
        } catch (e) {
            document.getElementById('ar-faqs').innerHTML =
                '<p class="ar-loading">FAQs temporarily unavailable.</p>';
        }
    }

    loadPortalContent();
})();
</script>

<?php get_footer(); ?>