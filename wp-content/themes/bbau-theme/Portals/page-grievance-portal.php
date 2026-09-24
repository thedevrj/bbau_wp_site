<?php
/*
Template Name: Grievance Redressal Portal 
*/
defined('ABSPATH') || exit;
get_header();

$api_base = getenv('DJANGO_API_URL'); 
$api_public_base = getenv('DJANGO_MEDIA_URL');

?>

<?php get_template_part('banners/new-banner'); ?>
<div class="vigilance-portal py-5">
    <div class="container">
        <?php get_template_part('template-parts/breadcrumb'); ?>

        <!-- INTRO -->
        <div class="row align-items-center mb-5 g-4">
            <div class="col-lg-12">
                <div class="fc-section-intro text-center">
                    <h2 class="fc-main-title"><?php echo get_the_title();?></h2>
                    <p class="fc-lead-text">
                        The <?php echo get_the_title();?> provides a transparent and accessible channel for
                        students, faculty, and staff to register their grievances.
                    </p>
                </div>
            </div>
        </div>

        <!-- PORTAL OVERVIEW -->
        <section class="grv-overview" aria-labelledby="grv-overview-title">
            <div class="grv-overview-copy">
                <span class="grv-eyebrow"><i class="fas fa-shield-alt" aria-hidden="true"></i>Grievance redressal</span>
                <h2 id="grv-overview-title">A simple way to raise and track your concern.</h2>
                <p>Submit a complaint, attach supporting documents, and follow its progress using your tracking
                    ID.</p>
                <div class="grv-overview-actions">
                    <button type="button" class="grv-action grv-action-primary" data-grievance-tab="register-section"><i
                            class="fas fa-pen" aria-hidden="true"></i> File a Grievance</button>
                    <button type="button" class="grv-action grv-action-secondary" data-grievance-tab="track-section"><i
                            class="fas fa-search" aria-hidden="true"></i> Track Status</button>
                </div>
            </div>

            <div class="grv-stats" aria-label="Grievance statistics" aria-live="polite">
                <div class="grv-stats-header">
                    <span><i class="fas fa-chart-line" aria-hidden="true"></i> Complaints overview</span>
                    <small id="grievance-stats-message"></small>
                </div>
                <article class="grv-stat-card">
                    <i class="fas fa-file-alt" aria-hidden="true"></i>
                    <span class="grv-stat-value" data-grievance-stat="total">—</span>
                    <span>Total grievances</span>
                </article>
                <article class="grv-stat-card grv-stat-resolved">
                    <i class="fas fa-check-circle" aria-hidden="true"></i>
                    <span class="grv-stat-value" data-grievance-stat="resolved">—</span>
                    <span>Resolved</span>
                </article>
                <article class="grv-stat-card grv-stat-progress">
                    <i class="fas fa-clock" aria-hidden="true"></i>
                    <span class="grv-stat-value" data-grievance-stat="in_progress">—</span>
                    <span>In progress</span>
                </article>
                <article class="grv-stat-card grv-stat-pending">
                    <i class="fas fa-hourglass-half" aria-hidden="true"></i>
                    <span class="grv-stat-value" data-grievance-stat="pending">—</span>
                    <span>Pending review</span>
                </article>
            </div>
        </section>

        <section class="grv-process" aria-labelledby="grv-process-title">
            <div class="grv-process-heading">
                <span class="grv-eyebrow">How it works</span>
            </div>
            <ol class="grv-process-steps">
                <li><span class="grv-step-icon"><i class="fas fa-file-signature"
                            aria-hidden="true"></i></span><strong>Register</strong><small>Submit your complaint and
                        contact details.</small></li>
                <li><span class="grv-step-icon"><i class="fas fa-cloud-upload-alt"
                            aria-hidden="true"></i></span><strong>Add evidence</strong><small>Upload documents that
                        support your concern.</small></li>
                <li><span class="grv-step-icon"><i class="fas fa-receipt" aria-hidden="true"></i></span><strong>Get
                        tracking ID</strong><small>Save the ID issued after successful submission.</small></li>
                <li><span class="grv-step-icon"><i class="fas fa-user-check"
                            aria-hidden="true"></i></span><strong>Review &amp; action</strong><small>The concerned
                        office reviews and acts on it.</small></li>
                <li><span class="grv-step-icon"><i class="fas fa-check-double"
                            aria-hidden="true"></i></span><strong>Resolution</strong><small>Track the outcome with your
                        tracking ID.</small></li>
            </ol>
        </section>

        <div class="row">
            <!-- TAB NAVIGATION -->
            <div class="col-12 mb-4">
                <div class="vigilance-tabs text-center">
                    <button class="vig-tab-btn active" data-target="register-section">File a Grievance</button>
                    <button class="vig-tab-btn" data-target="track-section">Track Status</button>
                </div>
            </div>

            <div class="col-lg-10 mx-auto">
                <!-- 1. REGISTER GRIEVANCE SECTION -->
                <div id="register-section" class="vig-section active">
                    <div class="vig-card">
                        <div class="vig-card-header text-center">
                            <h3>Register a New Grievance</h3>
                        </div>
                        <div class="vig-card-body">
                            <div id="grievance-success" class="alert alert-success" style="display:none;">
                                <h4><i class="fas fa-check-circle me-2"></i> Grievance Submitted Successfully</h4>
                                <p>Your grievance has been registered. Please save your Tracking ID for future
                                    reference:</p>
                                <div class="tracking-id-display" id="tracking-id-text"></div>
                            </div>

                            <form id="grievance-form" enctype="multipart/form-data">
                                <div class="mb-3 text-end text-muted small">
                                    <span class="text-danger fw-bold">*</span> Indicates a required field
                                </div>

                                <!-- Classification -->
                                <h5 class="mb-3 mt-4 text-secondary border-bottom pb-2">Classification</h5>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Nature of Grievance <span
                                                class="text-danger fw-bold">*</span></label>
                                        <select id="nature_of_grievance" name="nature_of_grievance"
                                            class="form-select vig-input" required
                                            onchange="toggleOtherField(this, 'other_nature_wrapper', 'others_nature_of_grievance')">
                                            <option value="">Select</option>

                                            <option value="ragging">Ragging Related Complaint</option>
                                            <option value="admission">Admission Related Complaint</option>
                                            <option value="examination">Examination Related Complaint</option>
                                            <option value="unfair_means">Unfair Means Related Complaint</option>
                                            <option value="scholarship">Scholarship Related Complaint</option>
                                            <option value="other">Other</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3" id="other_nature_wrapper" style="display:none;">
                                        <label class="form-label">Specify Other Nature <span
                                                class="text-danger fw-bold">*</span></label>
                                        <input type="text" id="others_nature_of_grievance"
                                            name="others_nature_of_grievance" class="form-control vig-input"
                                            placeholder="Specify details">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Complainant Type <span
                                                class="text-danger fw-bold">*</span></label>
                                        <select id="complainant_type" name="complainant_type"
                                            class="form-select vig-input" required
                                            onchange="toggleOtherField(this, 'other_complainant_wrapper', 'others_complainant_type')">
                                            <option value="">Select</option>
                                            <option value="student">Student</option>
                                            <option value="faculty">Faculty</option>
                                            <option value="non_teaching_staff">Non Teaching Staff</option>
                                            <option value="other">Other</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3" id="other_complainant_wrapper" style="display:none;">
                                        <label class="form-label">Specify Other Complainant <span
                                                class="text-danger fw-bold">*</span></label>
                                        <input type="text" id="others_complainant_type" name="others_complainant_type"
                                            class="form-control vig-input" placeholder="Specify details">
                                    </div>
                                </div>

                                <!-- Personal Information -->
                                <h5 class="mb-3 mt-4 text-secondary border-bottom pb-2">Personal Information</h5>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Name of Complainant <span
                                                class="text-danger fw-bold">*</span></label>
                                        <input type="text" id="name_of_complainant" name="name_of_complainant"
                                            class="form-control vig-input" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Aadhaar Number <span
                                                class="text-danger fw-bold">*</span></label>
                                        <input type="text" id="aadhaar_number" name="aadhaar_number"
                                            class="form-control vig-input" minlength="12" maxlength="12"
                                            pattern="\d{12}" placeholder="12-digit Aadhaar number"
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Enrollment / Official ID No. <span
                                                class="text-danger fw-bold">*</span></label>
                                        <input type="text" id="enrollment_id" name="enrollment_id"
                                            class="form-control vig-input" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Date of Birth <span
                                                class="text-danger fw-bold">*</span></label>
                                        <input type="date" id="date_of_birth" name="date_of_birth"
                                            class="form-control vig-input" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Gender <span
                                                class="text-danger fw-bold">*</span></label>
                                        <select id="gender" name="gender" class="form-select vig-input" required>
                                            <option value="">Select Gender</option>
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                            <option value="other">Other</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Father's Name <span
                                                class="text-danger fw-bold">*</span></label>
                                        <input type="text" id="fathers_name" name="fathers_name"
                                            class="form-control vig-input" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Mother's Name</label>
                                        <input type="text" id="mothers_name" name="mothers_name"
                                            class="form-control vig-input">
                                    </div>
                                </div>

                                <!-- Address and Contact -->
                                <h5 class="mb-3 mt-4 text-secondary border-bottom pb-2">Address & Contact Information
                                </h5>
                                <div class="mb-3">
                                    <label class="form-label">Permanent Address <span
                                            class="text-danger fw-bold">*</span></label>
                                    <textarea id="permanent_address" name="permanent_address"
                                        class="form-control vig-input" rows="3" required></textarea>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">State <span
                                                class="text-danger fw-bold">*</span></label>
                                        <input type="text" id="state" name="state" class="form-control vig-input"
                                            placeholder="e.g. Uttar Pradesh" required>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">City <span
                                                class="text-danger fw-bold">*</span></label>
                                        <input type="text" id="city" name="city" class="form-control vig-input"
                                            placeholder="e.g. Lucknow" required>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Pincode <span
                                                class="text-danger fw-bold">*</span></label>
                                        <input type="text" id="pincode" name="pincode" class="form-control vig-input"
                                            minlength="6" maxlength="6" pattern="\d{6}" placeholder="e.g. 226025"
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Contact No. <span
                                                class="text-danger fw-bold">*</span></label>
                                        <input type="tel" id="contact_number" name="contact_number"
                                            class="form-control vig-input" minlength="10" maxlength="10"
                                            pattern="\d{10}" oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                            required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Email <span
                                                class="text-danger fw-bold">*</span></label>
                                        <input type="email" id="email" name="email" class="form-control vig-input"
                                            required>
                                    </div>
                                </div>

                                <!-- Grievance Details -->
                                <h5 class="mb-3 mt-4 text-secondary border-bottom pb-2">Grievance Details</h5>
                                <div class="mb-3">
                                    <label class="form-label">Complaint <span
                                            class="text-danger fw-bold">*</span></label>
                                    <textarea id="complaint_text" name="complaint_text" class="form-control vig-input"
                                        rows="5" maxlength="500" placeholder="Max 500 characters" required></textarea>
                                    <div class="form-text text-end" id="charCount">0/500 characters</div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <label class="form-label">Attachment<small class="text-muted"> (Only pdf, doc,
                                                docx)</small></label>
                                        <div class="file-drop-area"
                                            onclick="document.getElementById('uploaded_files').click()">
                                            <i class="fas fa-cloud-upload-alt fa-2x mb-2 text-primary"></i>
                                            <span class="file-message d-block">Click to upload files</span>
                                            <input type="file" id="uploaded_files" name="uploaded_files" multiple
                                                accept=".pdf,.doc,.docx" style="display:none;"
                                                onchange="updateFileText(this, 'attachment-text')">
                                            <div id="attachment-text" class="mt-2 small text-muted"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <label class="form-label">Signature <span class="text-danger fw-bold">*</span>
                                            <small class="text-muted">(Only jpeg, jpg or png)</small></label>
                                        <div class="file-drop-area"
                                            onclick="document.getElementById('signature_image').click()">
                                            <i class="fas fa-signature fa-2x mb-2 text-primary"></i>
                                            <span class="file-message d-block">Click to upload signature</span>
                                            <input type="file" id="signature_image" name="signature_image"
                                                accept=".jpg,.jpeg,.png" style="display:none;" required
                                                onchange="updateFileText(this, 'signature-text')">
                                            <div id="signature-text" class="mt-2 small text-muted"></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Declaration -->
                                <div class="mb-4 bg-light p-3 rounded border">
                                    <h6 class="mb-2 text-uppercase text-secondary">Declaration:</h6>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="true"
                                            id="declaration_accepted" name="declaration_accepted" required>
                                        <label class="form-check-label text-muted" for="declaration_accepted">
                                            I hereby state that the facts mentioned above are true to the best of my
                                            knowledge and belief.
                                        </label>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary w-100 vig-submit-btn"
                                    id="submit-btn">Submit Grievance</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- 2. TRACK STATUS SECTION -->
                <div id="track-section" class="vig-section" style="display:none;">
                    <div class="vig-card">
                        <div class="vig-card-header text-center">
                            <h3>Track Grievance Status</h3>
                            <p class="text-muted">Enter your Tracking ID to view the current status</p>
                        </div>
                        <div class="vig-card-body">
                            <form id="track-status-form">
                                <div class="mb-4">
                                    <label class="form-label">Tracking ID <span
                                            class="text-danger fw-bold">*</span></label>
                                    <input type="text" id="track_id"
                                        class="form-control vig-input text-center text-uppercase fs-5"
                                        placeholder="e.g., GRV-202507-0001" required>
                                </div>
                                <button type="submit" class="btn btn-primary w-100 vig-submit-btn" id="track-btn">Check
                                    Status</button>
                            </form>

                            <div id="status-result" class="mt-4 p-4 rounded text-center"
                                style="display:none; background: #f8fafc; border: 1px solid #e2e8f0;">
                                <h5 class="text-secondary mb-3">Current Status</h5>
                                <div id="status-badge" class="badge fs-6 px-4 py-2 mb-3"></div>
                                <p class="text-muted mb-0">Nature of Grievance: <strong id="nature-display"
                                        class="text-dark"></strong></p>
                                <p class="text-muted mb-0">Submitted on: <strong id="status-date"
                                        class="text-dark"></strong></p>

                                <div id="history-timeline" class="mt-4 text-start">
                                    <h6 class="text-secondary mb-3 border-bottom pb-2">Action History</h6>
                                    <ul class="list-group list-group-flush" id="history-list">
                                        <!-- History items appended here -->
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="ar-success-modal" id="ar-success-modal" hidden role="dialog" aria-modal="true"
    aria-labelledby="ar-success-title">
    <div class="ar-success-backdrop" data-ar-close-success></div>
    <div class="ar-success-dialog">
        <button class="ar-success-close" type="button" aria-label="Close" data-ar-close-success>&times;</button>
        <div class="ar-success-check"><i class="fas fa-check"></i></div>
        <h2 id="ar-success-title">Grievance submitted successfully</h2>
        <p>Please save this tracking ID to check your grievance status later.</p>
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
:root {
    --fc-maroon: #173d6b;
    --fc-maroon-dark: #101722;
    --fc-gold: #d6a531;
    --fc-cream: #f5f7fb;
    --fc-ink: #172033;
    --fc-muted: #657083;
    --fc-line: #e5e9ef;
    --fc-soft-blue: #edf3fa;
}

.vigilance-portal {
    background: linear-gradient(180deg, #f8faff 0, var(--fc-cream) 320px);
    min-height: 80vh;
    color: var(--fc-ink);
    font-family: system-ui, -apple-system, "Segoe UI", sans-serif;
}

.fc-main-title {
    font-family: 'Merriweather', serif !important;
    color: var(--fc-maroon-dark);
    font-size: clamp(1.8rem, 3vw, 2.3rem);
    position: relative;
    display: inline-block;
}

.fc-main-title::after {
    content: '';
    position: absolute;
    left: 50%;
    transform: translateX(-50%);
    bottom: -6px;
    width: 60px;
    height: 4px;
    background: var(--fc-gold);
    border-radius: 2px;
}

.fc-lead-text {
    max-width: 760px;
    color: var(--fc-muted);
    line-height: 1.65;
    margin: 0 auto;
}

/* Portal overview and live grievance statistics */
.grv-overview {
    position: relative;
    display: grid;
    grid-template-columns: minmax(0, 1.25fr) minmax(350px, 1fr);
    overflow: hidden;
    margin-bottom: 28px;
    border: 1px solid #1f4c82;
    border-radius: 22px;
    background: linear-gradient(125deg, #0d172b 0%, #102b51 48%, #1a4b80 100%);
    box-shadow: 0 20px 46px rgba(16, 42, 77, 0.2);
}

.grv-overview::before,
.grv-overview::after {
    content: '';
    position: absolute;
    z-index: 0;
    border-radius: 50%;
    pointer-events: none;
}

.grv-overview::before {
    width: 330px;
    height: 330px;
    top: -185px;
    right: 26%;
    border: 46px solid rgba(214, 165, 49, 0.1);
}

.grv-overview::after {
    width: 210px;
    height: 210px;
    right: -80px;
    bottom: -110px;
    background: rgba(255, 255, 255, 0.045);
}

.grv-overview-copy {
    position: relative;
    z-index: 1;
    padding: 36px;
}

.grv-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    color: #f0d47d;
    font-size: 0.74rem;
    font-weight: 700;
    letter-spacing: 0.09em;
    text-transform: uppercase;
}

.grv-overview h2,
.grv-process h2 {
    margin: 9px 0 12px;
    color: var(--fc-maroon-dark);
    font-family: 'Merriweather', serif;
    font-size: 1.55rem;
    line-height: 1.35;
}

.grv-overview h2 {
    max-width: 610px;
    color: #fff;
    font-size: clamp(1.55rem, 2.6vw, 2.05rem);
}

.grv-overview p {
    max-width: 570px;
    margin: 0;
    color: rgba(255, 255, 255, 0.78);
    line-height: 1.65;
}

.grv-overview-actions {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-top: 22px;
}

.grv-action {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    min-height: 44px;
    padding: 10px 16px;
    border-radius: 8px;
    font-weight: 700;
    font-size: 0.88rem;
    cursor: pointer;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.grv-action:hover {
    transform: translateY(-1px);
}

.grv-action:focus-visible,
.vig-tab-btn:focus-visible,
.vig-submit-btn:focus-visible {
    outline: 3px solid rgba(214, 165, 49, 0.45);
    outline-offset: 3px;
}

.grv-action-primary {
    border: 1px solid var(--fc-gold);
    background: var(--fc-gold);
    color: #101722;
    box-shadow: 0 6px 14px rgba(214, 165, 49, 0.22);
}

.grv-action-secondary {
    border: 1px solid rgba(255, 255, 255, 0.62);
    background: rgba(255, 255, 255, 0.08);
    color: #fff;
}

.grv-action-secondary:hover {
    background: rgba(255, 255, 255, 0.16);
    color: #fff;
}

.grv-stats {
    position: relative;
    z-index: 1;
    align-content: center;
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 10px;
    padding: 22px;
    background: rgba(5, 14, 30, 0.2);
    border-left: 1px solid rgba(255, 255, 255, 0.14);
}

.grv-stats-header {
    grid-column: 1 / -1;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    padding: 0 2px 5px;
    color: #fff;
    font-size: 0.78rem;
    font-weight: 700;
}

.grv-stats-header span {
    display: inline-flex;
    align-items: center;
    gap: 7px;
}

.grv-stats-header i {
    color: var(--fc-gold);
}

.grv-stats-header small {
    color: rgba(255, 255, 255, 0.66);
    font-size: 0.68rem;
    font-weight: 600;
}

.grv-stat-card {
    display: flex;
    flex-direction: column;
    justify-content: center;
    min-height: 116px;
    padding: 18px;
    border: 1px solid rgba(255, 255, 255, 0.13);
    border-radius: 12px;
    background: rgba(255, 255, 255, 0.09);
    box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.07);
    color: rgba(255, 255, 255, 0.78);
    font-size: 0.78rem;
}

.grv-stat-card:nth-of-type(2n) {
    border-right: 1px solid rgba(255, 255, 255, 0.13);
}

.grv-stat-card:nth-of-type(n + 3) {
    border-bottom: 1px solid rgba(255, 255, 255, 0.13);
}

.grv-stat-card>i {
    margin-bottom: 10px;
    color: var(--fc-gold);
    font-size: 1.05rem;
}

.grv-stat-value {
    margin-bottom: 2px;
    color: #fff;
    font-size: 2rem;
    font-weight: 700;
    line-height: 1.1;
}

.grv-process {
    margin-bottom: 32px;
    padding: 26px 28px;
    border: 1px solid var(--fc-line);
    border-radius: 14px;
    background: #fff;
}

.grv-process-heading {
    text-align: center;
}

.grv-process .grv-eyebrow {
    color: var(--fc-maroon);
}

.grv-process-heading h2 {
    margin-bottom: 24px;
    font-size: 1.3rem;
}

.grv-process-steps {
    display: grid;
    grid-template-columns: repeat(5, minmax(0, 1fr));
    gap: 16px;
    padding: 0;
    margin: 0;
    list-style: none;
    counter-reset: grievance-step;
}

.grv-process-steps li {
    position: relative;
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    color: var(--fc-muted);
    counter-increment: grievance-step;
}

.grv-process-steps li::after {
    content: '';
    position: absolute;
    top: 22px;
    left: calc(50% + 31px);
    width: calc(100% - 45px);
    height: 1px;
    background: #cbd9e9;
}

.grv-process-steps li:last-child::after {
    display: none;
}

.grv-step-icon {
    position: relative;
    z-index: 1;
    display: grid;
    place-items: center;
    width: 46px;
    height: 46px;
    margin-bottom: 10px;
    border: 1px solid #cbd9e9;
    border-radius: 50%;
    background: var(--fc-soft-blue);
    color: var(--fc-maroon);
}

.grv-process-steps strong {
    margin-bottom: 4px;
    color: var(--fc-maroon-dark);
    font-size: 0.84rem;
}

.grv-process-steps small {
    max-width: 145px;
    font-size: 0.74rem;
    line-height: 1.4;
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

/* Tabs */
.vigilance-tabs {
    display: inline-flex;
    gap: 4px;
    padding: 6px;
    border: 1px solid var(--fc-line);
    border-radius: 10px;
    background: #fff;
    box-shadow: 0 5px 15px rgba(20, 40, 70, 0.06);
}

.vig-tab-btn {
    border: none;
    background: transparent;
    min-height: 42px;
    padding: 10px 22px;
    color: var(--fc-muted);
    border-radius: 6px;
    font-weight: 700;
    transition: all 0.3s;
}

.vig-tab-btn.active {
    background: var(--fc-maroon);
    color: #fff;
    box-shadow: 0 4px 10px rgba(23, 61, 107, 0.22);
}

/* Cards & Forms */
.vig-card {
    background: #fff;
    border: 1px solid var(--fc-line);
    border-radius: 14px;
    box-shadow: 0 12px 28px rgba(20, 40, 70, 0.07);
    overflow: hidden;
}

.vig-card-header {
    position: relative;
    padding: 22px;
    border-bottom: 1px solid var(--fc-line);
    background: linear-gradient(90deg, #fff, var(--fc-soft-blue));
}

.vig-card-header::before {
    content: '';
    position: absolute;
    inset: 0 auto 0 0;
    width: 4px;
    background: var(--fc-gold);
}

.vig-card-header h3 {
    margin: 0;
    color: var(--fc-maroon-dark);
    font-family: 'Merriweather', serif;
    font-size: 24px;
}

.vig-card-body {
    padding: 30px;
}

.vig-card-body h5 {
    margin-top: 34px !important;
    color: var(--fc-maroon) !important;
    font-size: 0.9rem;
    font-weight: 700;
    letter-spacing: 0.02em;
}

.vig-input {
    border: 1px solid #d6e0eb;
    border-radius: 7px;
    padding: 12px 15px;
    background-color: #fbfcfe;
}

.vig-input:focus {
    border-color: var(--fc-maroon);
    box-shadow: 0 0 0 3px rgba(23, 61, 107, 0.14);
    background-color: #fff;
}

.file-drop-area {
    border: 2px dashed #b9cce0;
    border-radius: 10px;
    padding: 30px;
    text-align: center;
    background: var(--fc-soft-blue);
    cursor: pointer;
    transition: all 0.3s;
}

.file-drop-area:hover {
    border-color: var(--fc-maroon);
    background: #fff;
}

.vig-submit-btn {
    background: var(--fc-maroon);
    border: none;
    padding: 14px;
    font-weight: 700;
    border-radius: 8px;
    letter-spacing: 0.5px;
}

.vig-submit-btn:hover {
    background: var(--fc-maroon-dark);
}

.tracking-id-display {
    font-size: 28px;
    font-weight: 700;
    color: var(--fc-maroon);
    background: var(--fc-soft-blue);
    padding: 10px;
    border-radius: 8px;
    display: inline-block;
    border: 2px dashed #9fb3cc;
    margin: 15px 0;
}

/* RESPONSIVENESS */
@media (max-width: 768px) {
    .grv-overview {
        grid-template-columns: 1fr;
    }

    .grv-overview-copy {
        padding: 28px;
    }

    .grv-stats {
        border-top: 1px solid rgba(255, 255, 255, 0.14);
        border-left: 0;
    }

    .grv-process-steps {
        grid-template-columns: repeat(3, minmax(0, 1fr));
        row-gap: 24px;
    }

    .grv-process-steps li::after {
        display: none;
    }

    .vigilance-tabs {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 5px;
    }

    .vig-tab-btn {
        flex: 1 1 auto;
        padding: 8px 12px;
        font-size: 14px;
    }

    .vig-card-body {
        padding: 20px;
    }
}

@media (max-width: 480px) {

    .grv-overview-copy,
    .grv-process {
        padding: 22px;
    }

    .grv-overview h2 {
        font-size: 1.32rem;
    }

    .grv-overview-actions,
    .grv-action {
        width: 100%;
    }

    .grv-stats,
    .grv-process-steps {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    .grv-stat-card {
        min-height: 124px;
        padding: 18px;
    }

    .grv-process-steps li:last-child {
        grid-column: 1 / -1;
    }

    .fc-main-title {
        font-size: 24px;
    }

    .vig-card-header h3 {
        font-size: 20px;
    }

    .vig-card-body {
        padding: 15px;
    }

    .tracking-id-display {
        font-size: 22px;
    }

    .file-drop-area {
        padding: 20px 10px;
    }
}
</style>

<?php get_template_part('template-parts/portal-form-validation'); ?>
<script>
// XSS Sanitization Helper
function escapeHTML(str) {
    if (!str) return '';
    return String(str).replace(/[&<>'"]/g,
        tag => ({
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            "'": '&#39;',
            '"': '&quot;'
        } [tag] || tag)
    );
}

// Logic to handle conditionally required "Other" text fields
function toggleOtherField(selectElem, wrapperId, inputId) {
    const wrapper = document.getElementById(wrapperId);
    const input = document.getElementById(inputId);
    if (selectElem.value === 'other') {
        wrapper.style.display = 'block';
        input.required = true;
    } else {
        wrapper.style.display = 'none';
        input.required = false;
        input.value = '';
    }
}

// Update file text below upload area
function updateFileText(input, textId) {
    const display = document.getElementById(textId);
    if (input.files && input.files.length > 1) {
        display.innerHTML = `<strong>${input.files.length}</strong> files selected.`;
    } else if (input.files && input.files.length === 1) {
        display.innerHTML = `Selected: <strong>${input.files[0].name}</strong>`;
    } else {
        display.innerHTML = '';
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const apiBase = "<?php echo esc_js($api_public_base); ?>";

    // Character count for complaint text
    const complaintText = document.getElementById('complaint_text');
    const charCount = document.getElementById('charCount');
    complaintText.addEventListener('input', function() {
        charCount.textContent = `${this.value.length}/500 characters`;
    });

    // Tab Switching Logic with Deep Linking
    const tabBtns = document.querySelectorAll('.vig-tab-btn');
    const sections = document.querySelectorAll('.vig-section');

    function switchTab(targetId, updateHistory = true) {
        const btn = Array.from(tabBtns).find(b => b.dataset.target === targetId);
        if (!btn) return;

        tabBtns.forEach(b => b.classList.remove('active'));
        sections.forEach(s => s.style.display = 'none');

        btn.classList.add('active');
        document.getElementById(targetId).style.display = 'block';

        if (updateHistory) {
            const tabName = targetId.replace('-section', '');
            const url = new URL(window.location);
            url.searchParams.set('tab', tabName);
            window.history.pushState({
                tab: targetId
            }, '', url);
        }
    }

    tabBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            switchTab(btn.dataset.target);
        });
    });

    const urlParams = new URLSearchParams(window.location.search);
    const initialTab = urlParams.get('tab');
    if (initialTab) {
        const targetId = initialTab + '-section';
        switchTab(targetId, false);
    } else {
        window.history.replaceState({
            tab: 'register-section'
        }, '', window.location.href);
    }

    window.addEventListener('popstate', (e) => {
        if (e.state && e.state.tab) {
            switchTab(e.state.tab, false);
        } else {
            switchTab('register-section', false);
        }
    });

    document.querySelectorAll('[data-grievance-tab]').forEach(action => {
        action.addEventListener('click', () => {
            const targetId = action.dataset.grievanceTab;
            switchTab(targetId);
            document.getElementById(targetId).scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        });
    });

    // Public aggregate-only data: this endpoint must not return complaint records.
    async function loadGrievanceStats() {
        const statElements = document.querySelectorAll('[data-grievance-stat]');
        const statusMessage = document.getElementById('grievance-stats-message');
        if (!statElements.length) return;

        try {
            // Support both singular and plural route conventions used by the grievance API.
            const endpoints = [
                `${apiBase}/api/v1/portals/grievance/stats/`,
                `${apiBase}/api/v1/portals/grievances/stats/`
            ];
            let payload = null;

            for (const endpoint of endpoints) {
                const response = await fetch(endpoint, {
                    headers: {
                        Accept: 'application/json'
                    }
                });
                if (!response.ok) continue;

                const candidate = await response.json();
                const values = candidate.stats || candidate.data || candidate;
                const countKeys = ['total', 'total_grievances', 'total_complaints', 'count', 'resolved',
                    'in_progress', 'pending'
                ];
                const hasStats = values && typeof values === 'object' && !Array.isArray(values) &&
                    (countKeys.some(key => values[key] !== undefined) || values.status_counts || values
                        .counts);
                if (hasStats) {
                    payload = candidate;
                    break;
                }
            }

            if (!payload) throw new Error('Unable to load grievance statistics.');

            const stats = payload.stats || payload.data || payload;
            const statusCounts = stats.status_counts || stats.counts || {};
            const aliases = {
                total: ['total', 'total_grievances', 'total_complaints', 'count'],
                resolved: ['resolved', 'resolved_count'],
                in_progress: ['in_progress', 'in_progress_count', 'under_review', 'forwarded'],
                pending: ['pending', 'pending_count', 'awaiting_review', 'open']
            };

            Object.entries(aliases).forEach(([name, keys]) => {
                const value = keys.map(key => stats[key] ?? statusCounts[key]).find(value =>
                    value !== undefined && value !== null);
                const target = document.querySelector(`[data-grievance-stat="${name}"]`);
                if (target && value !== undefined) {
                    const number = Number(value);
                    target.textContent = Number.isFinite(number) ? number.toLocaleString('en-IN') :
                        value;
                }
            });

        } catch (error) {
            if (statusMessage) statusMessage.textContent = 'Live statistics are currently unavailable';
            console.warn('Grievance statistics are unavailable.', error);
        }
    }

    loadGrievanceStats();

    // Grievance Submission
    document.getElementById('grievance-form').addEventListener('submit', async function(e) {
        e.preventDefault();

        // Extra Validation
        const aadhaar = document.getElementById('aadhaar_number').value;
        if (aadhaar && !/^\d{12}$/.test(aadhaar)) {
            alert('Aadhaar number must be exactly 12 digits.');
            return;
        }

        const contactNumber = document.getElementById('contact_number').value;
        if (contactNumber && !/^\d{10}$/.test(contactNumber)) {
            alert('Contact number must be exactly 10 digits.');
            return;
        }

        const emailInput = document.getElementById('email').value;
        if (emailInput && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailInput)) {
            alert('Please enter a valid email address.');
            return;
        }

        const btn = document.getElementById('submit-btn');
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Submitting...';

        const formData = new FormData(this);

        // Sanitize all string fields before submitting to prevent XSS payloads
        for (let [key, value] of formData.entries()) {
            if (typeof value === 'string') {
                formData.set(key, escapeHTML(value.trim()));
            }
        }

        // Delete empty file inputs to avoid DRF errors
        const filesInput = document.getElementById('uploaded_files');
        if (filesInput.files.length === 0) {
            formData.delete('uploaded_files');
        }

        try {
            const response = await fetch(`${apiBase}/api/v1/portals/grievance/submit/`, {
                method: 'POST',
                body: formData
            });

            if (response.ok) {
                const data = await response.json();
                document.getElementById('grievance-form').style.display = 'none';
                document.getElementById('tracking-id-text').innerText = data.tracking_id;
                document.getElementById('grievance-success').style.display = 'block';
                showGrievanceTrackingPopup(data.tracking_id);
                window.scrollTo(0, document.getElementById('grievance-success').offsetTop - 100);
            } else {
                const err = await response.json();
                console.error('Validation Error:', err);

                // Show form errors in a basic alert for now
                let errorMsgs = [];
                for (const [key, value] of Object.entries(err)) {
                    errorMsgs.push(`${key}: ${value}`);
                }
                alert('Submission failed. Please check the inputs:\n' + errorMsgs.join('\n'));
            }
        } catch (error) {
            console.error('Error:', error);
            alert('A network error occurred. Please try again later.');
        } finally {
            btn.disabled = false;
            btn.innerText = 'Submit Grievance';
        }
    });

    // Tracking Status
    document.getElementById('track-status-form').addEventListener('submit', async function(e) {
        e.preventDefault();
        const btn = document.getElementById('track-btn');
        const trackingId = document.getElementById('track_id').value.trim();
        const resultDiv = document.getElementById('status-result');
        const historyList = document.getElementById('history-list');

        btn.disabled = true;
        btn.innerText = 'Checking...';
        resultDiv.style.display = 'none';
        historyList.innerHTML = '';

        try {
            const response = await fetch(
                `${apiBase}/api/v1/portals/grievance/status/${trackingId}/`);

            if (response.ok) {
                const data = await response.json();
                resultDiv.style.display = 'block';

                const getStatusColor = (status) => {
                    const colors = {
                        'pending': 'warning',
                        'under_review': 'info',
                        'resolved': 'success',
                        'forwarded': 'primary',
                        'closed': 'secondary',
                        'rejected': 'danger'
                    };
                    return colors[status] || 'secondary';
                };

                const badge = document.getElementById('status-badge');
                badge.className = `badge fs-6 px-4 py-2 mb-3 bg-${getStatusColor(data.status)}`;
                badge.innerText = data.status_display;

                document.getElementById('nature-display').innerText = data.nature_display || data
                    .nature_of_grievance;

                const date = new Date(data.submitted_at);
                document.getElementById('status-date').innerText = date.toLocaleDateString(
                    'en-IN', {
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit'
                    });

                // Populate History
                if (data.history && data.history.length > 0) {
                    data.history.forEach(log => {
                        const logDate = new Date(log.date);
                        const dateStr = logDate.toLocaleDateString('en-IN', {
                            year: 'numeric',
                            month: 'short',
                            day: 'numeric',
                            hour: '2-digit',
                            minute: '2-digit'
                        });
                        const badgeColor = getStatusColor(log.status);

                        const safeStatusDisplay = escapeHTML(log.status_display);
                        const safeDescription = escapeHTML(log.description);

                        const li = document.createElement('li');
                        li.className = 'list-group-item bg-transparent px-0 py-3';
                        li.innerHTML = `
                            <div class="d-flex w-100 justify-content-between align-items-center mb-1">
                                <span class="badge bg-${badgeColor}">${safeStatusDisplay}</span>
                                <small class="text-muted">${dateStr}</small>
                            </div>
                            <p class="mb-1 text-dark small">${safeDescription}</p>
                        `;
                        historyList.appendChild(li);
                    });
                }
            } else {
                alert('Grievance not found or invalid Tracking ID.');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('A network error occurred while checking status.');
        } finally {
            btn.disabled = false;
            btn.innerText = 'Check Status';
        }
    });
});
    const grievanceModal = document.getElementById('ar-success-modal');
    const grievanceTrackingId = document.getElementById('ar-success-tracking-id');
    const grievanceCopyButton = document.getElementById('ar-copy-tracking-id');
    const grievanceCopyFeedback = document.getElementById('ar-copy-feedback');

    function showGrievanceTrackingPopup(trackingId) {
        grievanceTrackingId.textContent = trackingId || 'Please contact support';
        grievanceModal.hidden = false;
        document.body.classList.add('ar-modal-open');
        grievanceModal.querySelector('.ar-success-close').focus();
    }

    function closeGrievanceTrackingPopup() {
        grievanceModal.hidden = true;
        document.body.classList.remove('ar-modal-open');
    }

    grievanceModal.querySelectorAll('[data-ar-close-success]').forEach(function(button) {
        button.addEventListener('click', closeGrievanceTrackingPopup);
    });

    grievanceCopyButton.addEventListener('click', async function() {
        const trackingId = grievanceTrackingId.textContent;
        try {
            await navigator.clipboard.writeText(trackingId);
            grievanceCopyFeedback.hidden = false;
            setTimeout(function() { grievanceCopyFeedback.hidden = true; }, 2500);
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
            grievanceCopyFeedback.textContent = copied ? 'Tracking ID copied.' : 'Please select and copy the tracking ID above.';
            grievanceCopyFeedback.hidden = false;
        }
    });
</script>

<?php get_footer(); ?>
