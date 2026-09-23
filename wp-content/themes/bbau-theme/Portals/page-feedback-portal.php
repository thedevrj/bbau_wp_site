<?php
/*
Template Name: Student Feedback Portal
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
                    <h2 class="fc-main-title"><?php echo get_the_title(); ?></h2>
                    <p class="fc-lead-text">
                        Online Portal for submitting your valuable feedback regarding various university facilities
                    </p>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- TAB NAVIGATION -->
            <div class="col-12 mb-4">
                <div class="vigilance-tabs text-center">
                    <button class="vig-tab-btn active" data-target="register-section">File Feedback</button>
                    <button class="vig-tab-btn" data-target="track-section">Track Status</button>
                </div>
            </div>

            <div class="col-lg-10 mx-auto">
                <!-- 1. REGISTER SECTION -->
                <div id="register-section" class="vig-section active">
                    <div class="vig-card">
                        <div class="vig-card-header text-center">
                            <h3>Students Feedback Form</h3>
                        </div>
                        <div class="vig-card-body">
                            <div id="fdbk-success" class="alert alert-success" style="display:none;">
                                <h4><i class="fas fa-check-circle me-2"></i> Feedback Submitted Successfully</h4>
                                <p>Your feedback has been registered. Please save your Tracking ID for future reference:
                                </p>
                                <div class="tracking-id-display" id="tracking-id-text"></div>
                            </div>

                            <form id="fdbk-form" enctype="multipart/form-data">
                                <div class="mb-3 text-end text-muted small">
                                    <span class="text-danger fw-bold">*</span> Indicates a required field
                                </div>

                                <!-- Feedback Subject -->
                                <h5 class="mb-3 mt-4 text-secondary border-bottom pb-2">Feedback Subject</h5>
                                <div class="mb-3">
                                    <label class="form-label">Subject of your Feedback <span
                                            class="text-danger fw-bold">*</span></label>
                                    <select id="subject_of_feedback" name="subject_of_feedback"
                                        class="form-select vig-input custom-select-danger" required
                                        onchange="toggleOtherField(this, 'other_nature_wrapper', 'others_subject_of_feedback')">
                                        <option value="">Select Subject</option>
                                        <option value="academic">Academic</option>
                                        <option value="infrastructure">Infrastructure</option>
                                        <option value="hostel">Hostel</option>
                                        <option value="extracurricular">Extracurricular Activities</option>
                                        <option value="administration">Administration</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                                <div class="mb-3" id="other_nature_wrapper" style="display:none;">
                                    <label class="form-label">Please specify the subject of Feedback <span
                                            class="text-danger fw-bold">*</span></label>
                                    <input type="text" id="others_subject_of_feedback" name="others_subject_of_feedback"
                                        class="form-control vig-input">
                                </div>

                                <!-- Student Details -->
                                <h5 class="mb-3 mt-4 text-secondary border-bottom pb-2">Student Details</h5>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Name of Student <span
                                                class="text-danger fw-bold">*</span></label>
                                        <input type="text" id="name_of_student" name="name_of_student"
                                            class="form-control vig-input" placeholder="Name of Student" required>
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
                                </div>

                                <!-- Academic Details -->
                                <h5 class="mb-3 mt-4 text-secondary border-bottom pb-2">Academic Details</h5>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Course Name <span
                                                class="text-danger fw-bold">*</span></label>
                                        <select id="course_name" name="course_name" class="form-select vig-input"
                                            required>
                                            <option value="">Select Courses</option>
                                            <option value="ug">Undergraduate</option>
                                            <option value="pg">Postgraduate</option>
                                            <option value="phd">Ph.D.</option>
                                            <option value="diploma">Diploma</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Roll No. <span
                                                class="text-danger fw-bold">*</span></label>
                                        <input type="text" id="roll_no" name="roll_no" class="form-control vig-input"
                                            required>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Enrollment No. <span
                                                class="text-danger fw-bold">*</span></label>
                                        <input type="text" id="enrollment_no" name="enrollment_no"
                                            class="form-control vig-input" required>
                                    </div>
                                </div>

                                <!-- Contact Information -->
                                <h5 class="mb-3 mt-4 text-secondary border-bottom pb-2">Contact Information</h5>
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
                                            placeholder="e.g. 226001" minlength="6" maxlength="6" pattern="\d{6}"
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Contact No <span
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

                                <!-- Feedback Section -->
                                <h5 class="mb-3 mt-4 text-secondary border-bottom pb-2">Feedback Details</h5>
                                <div class="mb-3">
                                    <label class="form-label">Feedback <span
                                            class="text-danger fw-bold">*</span></label>
                                    <textarea id="feedback_text" name="feedback_text" class="form-control vig-input"
                                        rows="8" maxlength="2000" placeholder="Feedback (Max 2000 characters)"
                                        required></textarea>
                                    <div class="form-text text-end" id="charCount">0/2000 characters</div>
                                </div>

                                <!-- Attachments -->
                                <div class="row mt-4">
                                    <div class="col-md-6 mb-4">
                                        <label class="form-label">Signature <span class="text-danger fw-bold">*</span>
                                            <span class="text-muted small">(Only jpeg, jpg or png)</span></label>
                                        <div class="file-drop-area"
                                            onclick="document.getElementById('signature_image').click()">
                                            <i class="fas fa-file-signature fa-2x mb-2 text-primary"></i>
                                            <span class="file-message d-block">Click to upload signature</span>
                                            <input type="file" id="signature_image" name="signature_image"
                                                accept=".jpg,.jpeg,.png" style="display:none;" required
                                                onchange="updateFileText(this, 'signature-text')">
                                            <div id="signature-text" class="mt-2 small text-muted"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <label class="form-label">Attachment <span class="text-muted small">(Only PDF,
                                                if any)</span></label>
                                        <div class="file-drop-area"
                                            onclick="document.getElementById('uploaded_files').click()">
                                            <i class="fas fa-cloud-upload-alt fa-2x mb-2 text-primary"></i>
                                            <span class="file-message d-block">Click to upload files</span>
                                            <input type="file" id="uploaded_files" name="uploaded_files" multiple
                                                accept=".pdf" style="display:none;"
                                                onchange="updateFileText(this, 'attachment-text')">
                                            <div id="attachment-text" class="mt-2 small text-muted"></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Declaration -->
                                <div class="mb-4 bg-light p-3 rounded border">
                                    <h6 class="mb-2 text-secondary">DECLARATION:</h6>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="true"
                                            id="declaration_accepted" name="declaration_accepted" required>
                                        <label class="form-check-label text-muted" for="declaration_accepted">
                                            I hereby state that the facts mentioned above are true to the best of my
                                            knowledge and belief.
                                        </label>
                                    </div>
                                </div>

                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary vig-submit-btn" id="submit-btn"
                                        style="min-width: 200px; border-radius: 6px;">Submit your Feedback</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- 2. TRACK STATUS SECTION -->
                <div id="track-section" class="vig-section" style="display:none;">
                    <div class="vig-card">
                        <div class="vig-card-header text-center">
                            <h3>Track Feedback Status</h3>
                            <p class="text-muted">Enter your Tracking ID to view the current status</p>
                        </div>
                        <div class="vig-card-body">
                            <form id="track-status-form">
                                <div class="mb-4">
                                    <label class="form-label fw-bold">Tracking ID <span
                                            class="text-danger">*</span></label>
                                    <input type="text" id="track_id"
                                        class="form-control vig-input text-center text-uppercase fs-5"
                                        placeholder="e.g., FDBK-202507-0001" required>
                                </div>
                                <button type="submit" class="btn btn-primary w-100 vig-submit-btn" id="track-btn">Check
                                    Status</button>
                            </form>

                            <div id="status-result" class="mt-4 p-4 rounded text-center"
                                style="display:none; background: #f8fafc; border: 1px solid #e2e8f0;">
                                <h5 class="text-secondary mb-3">Current Status</h5>
                                <div id="status-badge" class="badge fs-6 px-4 py-2 mb-3"></div>
                                <p class="text-muted mb-0">Subject: <strong id="subject-display"
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

<div class="portal-tracking-modal" id="portal-tracking-modal" hidden role="dialog" aria-modal="true"
    aria-labelledby="portal-tracking-title">
    <div class="portal-tracking-backdrop" data-close-tracking-modal></div>
    <div class="portal-tracking-dialog"><button class="portal-tracking-close" type="button" aria-label="Close"
            data-close-tracking-modal>&times;</button>
        <div class="portal-tracking-check"><i class="fas fa-check"></i></div>
        <h2 id="portal-tracking-title">Feedback submitted successfully</h2>
        <p>Please save this tracking ID for future reference.</p>
        <div class="portal-tracking-value"><small>TRACKING ID</small><strong id="portal-tracking-value"></strong></div>
        <button class="btn btn-primary" type="button" id="portal-copy-tracking"><i class="fas fa-copy"></i> Copy
            tracking ID</button> <span id="portal-copy-feedback" class="portal-copy-feedback" hidden>Tracking ID
            copied.</span>
    </div>
</div>
<style>
:root {
    --fc-maroon: #8B1A1A;
    --fc-maroon-dark: #5c1010;
    --fc-gold: #c9a84c;
    --fc-cream: #fdfaf6;
}

.vigilance-portal {
    background: var(--fc-cream);
    min-height: 80vh;
    font-family: 'Nunito', sans-serif;
}

.fc-main-title {
    font-family: 'Merriweather', serif !important;
    color: var(--fc-maroon-dark);
    font-size: 32px;
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
    color: #475569;
    line-height: 1.4;
    margin: 0 auto;
}

/* Tabs */
.vigilance-tabs {
    display: inline-flex;
    background: #fff;
    padding: 8px;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
}

.vig-tab-btn {
    border: none;
    background: transparent;
    padding: 10px 24px;
    font-weight: 700;
    color: #475569;
    border-radius: 8px;
    transition: all 0.3s;
}

.vig-tab-btn.active {
    background: var(--fc-maroon);
    color: #fff;
}

/* Cards & Forms */
.vig-card {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.06);
    border: 1px solid rgba(226, 217, 204, 0.6);
    overflow: hidden;
}

.vig-card-header {
    background: #fafaf9;
    padding: 20px;
    border-bottom: 1px solid rgba(226, 217, 204, 0.6);
}

.vig-card-header h3 {
    margin: 0;
    color: var(--fc-maroon-dark);
    font-family: 'Merriweather', serif;
    font-size: 24px;
}

.vig-card-body {
    padding: 40px;
}

.vig-input {
    border: 1px solid #cbd5e1;
    border-radius: 2px;
    padding: 10px 15px;
    background-color: #fff;
}

.vig-input:focus {
    border-color: var(--fc-gold);
    box-shadow: 0 0 0 1px rgba(201, 168, 76, 0.5);
}

/* .custom-select-danger {
    border: 2px solid #dc3545;
}

.custom-select-danger:focus {
    border-color: #dc3545;
    box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
} */

.vig-submit-btn {
    background: #337ab7;
    color: white;
    border: none;
    padding: 12px 24px;
    font-weight: 500;
    transition: all 0.3s;
}

.vig-submit-btn:hover {
    background: #23527c;
    color: white;
}

.tracking-id-display {
    font-size: 28px;
    font-weight: 700;
    color: var(--fc-maroon);
    background: #fff;
    padding: 10px;
    border-radius: 8px;
    display: inline-block;
    border: 2px dashed var(--fc-gold);
    margin: 15px 0;
}

.file-drop-area {
    border: 2px dashed #cbd5e1;
    border-radius: 8px;
    padding: 30px;
    text-align: center;
    background: #f8fafc;
    cursor: pointer;
    transition: all 0.3s;
}

.file-drop-area:hover {
    border-color: var(--fc-maroon);
    background: #fff;
}

/* RESPONSIVENESS */
@media (max-width: 768px) {
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
//other field
function toggleOtherField(selectElem, wrapperId, inputId) {
    const wrapper = document.getElementById(wrapperId);
    const input = document.getElementById(inputId);
    if (selectElem.value === 'Other') {
        wrapper.style.display = 'block';
        input.required = true;
    } else {
        wrapper.style.display = 'none';
        input.required = false;
        input.value = '';
    }
}

// Update file text 
function updateFileText(input, textId) {
    const display = document.getElementById(textId);
    if (input.files && input.files.length > 1) {
        display.innerHTML = `<strong>${input.files.length}</strong> files selected.`;
    } else if (input.files && input.files.length === 1) {
        display.innerHTML = `<strong>${input.files[0].name}</strong>`;
    } else {
        display.innerHTML = 'No file chosen';
    }
}

function clearFile(inputId, textId) {
    document.getElementById(inputId).value = "";
    document.getElementById(textId).innerHTML = "No file chosen";
}

document.addEventListener('DOMContentLoaded', function() {
    const apiBase = "<?php echo esc_js($api_public_base); ?>";

    // Character count for feedback text
    const feedbackText = document.getElementById('feedback_text');
    const charCount = document.getElementById('charCount');
    feedbackText.addEventListener('input', function() {
        charCount.textContent = `${this.value.length}/2000 characters`;
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

    // Form Submission
    document.getElementById('fdbk-form').addEventListener('submit', async function(e) {
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
            const response = await fetch(`${apiBase}/api/v1/portals/feedback/submit/`, {
                method: 'POST',
                body: formData
            });

            if (response.ok) {
                const data = await response.json();
                document.getElementById('fdbk-form').style.display = 'none';
                document.getElementById('tracking-id-text').innerText = data.tracking_id;
                document.getElementById('fdbk-success').style.display = 'block';
                showPortalTrackingPopup(data.tracking_id);
                window.scrollTo(0, document.getElementById('fdbk-success').offsetTop - 100);
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
            btn.innerText = 'Save Feedback';
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
                `${apiBase}/api/v1/portals/feedback/status/${trackingId}/`);

            if (response.ok) {
                const data = await response.json();
                resultDiv.style.display = 'block';

                const getStatusColor = (status) => {
                    const colors = {
                        'pending': 'warning',
                        'under_review': 'info',
                        'action_taken': 'success',
                        'closed': 'secondary'
                    };
                    return colors[status] || 'secondary';
                };

                const badge = document.getElementById('status-badge');
                badge.className = `badge fs-6 px-4 py-2 mb-3 bg-${getStatusColor(data.status)}`;
                badge.innerText = data.status_display;

                const safeNature = escapeHTML(data.subject_display || data.subject_of_feedback);
                document.getElementById('subject-display').innerText = safeNature;

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
                alert('Feedback not found or invalid Tracking ID.');
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

function showPortalTrackingPopup(trackingId) {
    document.getElementById('portal-tracking-value').textContent = trackingId || '';
    document.getElementById('portal-tracking-modal').hidden = false;
    document.body.classList.add('portal-modal-open');
    document.querySelector('#portal-tracking-modal .portal-tracking-close').focus();
}

function closePortalTrackingPopup() {
    document.getElementById('portal-tracking-modal').hidden = true;
    document.body.classList.remove('portal-modal-open');
}
document.querySelectorAll('[data-close-tracking-modal]').forEach(function(button) {
    button.addEventListener('click', closePortalTrackingPopup);
});
document.getElementById('portal-copy-tracking').addEventListener('click', async function() {
    const id = document.getElementById('portal-tracking-value').textContent;
    try {
        await navigator.clipboard.writeText(id);
        document.getElementById('portal-copy-feedback').hidden = false;
    } catch (error) {
        window.prompt('Copy your tracking ID:', id);
    }
});
</script>

<?php get_footer(); ?>