<?php
/*
Template Name: Vigilance Portal Template
*/
defined('ABSPATH') || exit;
get_header();

$api_base = getenv('DJANGO_API_URL'); 
$api_public_base = getenv('DJANGO_MEDIA_URL');

$faqs_response = wp_remote_get("{$api_base}/api/v1/vigilance/faqs/", ['timeout' => 10]);
$faqs_data = [];
if (!is_wp_error($faqs_response) && wp_remote_retrieve_response_code($faqs_response) === 200) {
    $faqs_body = json_decode(wp_remote_retrieve_body($faqs_response), true);
    $faqs_data = isset($faqs_body['results']) ? $faqs_body['results'] : $faqs_body;
}

$docs_response = wp_remote_get("{$api_base}/api/v1/vigilance/documents/", ['timeout' => 10]);
$docs_data = [];
if (!is_wp_error($docs_response) && wp_remote_retrieve_response_code($docs_response) === 200) {
    $docs_body = json_decode(wp_remote_retrieve_body($docs_response), true);
    $docs_data = isset($docs_body['results']) ? $docs_body['results'] : $docs_body;
}
?>

<?php if (!empty($faqs_data)): ?>
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "FAQPage",
    "mainEntity": [
        <?php
    $faq_entities = [];
    foreach ($faqs_data as $faq) {
        $faq_entities[] = '{
            "@type": "Question",
            "name": ' . json_encode(wp_strip_all_tags($faq['question'])) . ',
            "acceptedAnswer": {
                "@type": "Answer",
                "text": ' . json_encode(wp_strip_all_tags($faq['answer'])) . '
            }
        }';
    }
    echo implode(',', $faq_entities);
    ?>
    ]
}
</script>
<?php endif; ?>

<?php get_template_part('banners/new-banner'); ?>
<div class="vigilance-portal py-5">
    <div class="container">
        <?php get_template_part('template-parts/breadcrumb'); ?>


        <!-- INTRO -->
        <div class="row align-items-center mb-5 g-4">
            <div class="col-lg-12">
                <div class="fc-section-intro text-center">
                    <h2 class="fc-main-title">Vigilance Cell</h2>
                    <p class="fc-lead-text">
                        The Vigilance Portal provides a transparent, secure, and easily accessible channel for members
                        report corruption, malpractice, or procedural lapses directly to the University Vigilance Cell.
                    </p>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- TAB NAVIGATION -->
            <div class="col-12 mb-4">
                <div class="vigilance-tabs text-center">
                    <button class="vig-tab-btn active" data-target="register-section">File a Complaint</button>
                    <button class="vig-tab-btn" data-target="track-section">Track Status</button>
                    <button class="vig-tab-btn" data-target="policies-section">Policies & SOPs</button>
                    <button class="vig-tab-btn" data-target="faq-section">FAQs</button>
                </div>
            </div>

            <div class="col-lg-9 mx-auto">
                <!-- 1. REGISTER COMPLAINT SECTION -->
                <div id="register-section" class="vig-section active">
                    <div class="vig-card">
                        <div class="vig-card-header text-center">
                            <h3>Register a New Complaint</h3>
                        </div>
                        <div class="vig-card-body">
                            <div id="vigilance-success" class="alert alert-success" style="display:none;">
                                <h4><i class="fas fa-check-circle me-2"></i> Complaint Submitted Successfully</h4>
                                <p>Your complaint has been registered. Please save your Tracking ID for future
                                    reference:</p>
                                <div class="tracking-id-display" id="tracking-id-text"></div>
                            </div>

                            <form id="vigilance-form" enctype="multipart/form-data">
                                <div class="mb-3 text-end text-muted small">
                                    <span class="text-danger fw-bold">*</span> Indicates a required field
                                </div>
                                <div class="vig-checkbox-group mb-4">
                                    <input type="checkbox" id="is_anonymous" name="is_anonymous">
                                    <label for="is_anonymous">Submit Anonymously (Hide personal details)</label>
                                </div>

                                <div id="personal-details-section">
                                    <div class="mb-3">
                                        <label class="form-label">Full Name<span class="text-danger fw-bold">&nbsp;*</span></label>
                                        <input type="text" id="name" name="name" class="form-control vig-input">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Email Address<span class="text-danger fw-bold">&nbsp;*</span></label>
                                        <input type="email" id="email" name="email" class="form-control vig-input"
                                            placeholder="abc@gmail.com">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Phone Number<span class="text-danger fw-bold">&nbsp;*</span></label>
                                        <input type="text" id="phone" name="phone" class="form-control vig-input"
                                            placeholder="1234567890" minlength="10" maxlength="10" pattern="\d{10}" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Complaint Category <span class="text-danger fw-bold">*</span></label>
                                    <select id="category" name="category" class="form-select vig-input" required>
                                        <option value="">Select a category</option>
                                        <option value="corruption">Corruption</option>
                                        <option value="malpractice">Malpractice</option>
                                        <option value="procedural_lapse">Procedural Lapse</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Complaint Details <span class="text-danger fw-bold">*</span></label>
                                    <textarea id="description" name="description" class="form-control vig-input"
                                        rows="5" required></textarea>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Upload Evidence (Optional)</label>
                                    <div class="file-drop-area"
                                        onclick="document.getElementById('uploaded_files').click()">
                                        <i class="fas fa-cloud-upload-alt fa-2x mb-2 text-primary"></i>
                                        <span class="file-message d-block">Click to upload files (PDF, JPG, PNG)</span>
                                        <input type="file" id="uploaded_files" name="uploaded_files" multiple
                                            accept=".pdf,.jpg,.jpeg,.png" style="display:none;"
                                            onchange="updateFileText(this)">
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary w-100 vig-submit-btn"
                                    id="submit-btn">Submit Complaint</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- 2. TRACK STATUS SECTION -->
                <div id="track-section" class="vig-section" style="display:none;">
                    <div class="vig-card">
                        <div class="vig-card-header text-center">
                            <h3>Track Complaint Status</h3>
                            <p class="text-muted">Enter your Tracking ID to view the current status</p>
                        </div>
                        <div class="vig-card-body">
                            <form id="track-status-form">
                                <div class="mb-4">
                                    <label class="form-label">Tracking ID <span class="text-danger fw-bold">*</span></label>
                                    <input type="text" id="track_id"
                                        class="form-control vig-input text-center text-uppercase fs-5"
                                        placeholder="e.g., VIG-202XXX-XX" required>
                                </div>
                                <button type="submit" class="btn btn-primary w-100 vig-submit-btn" id="track-btn">Check
                                    Status</button>
                            </form>

                            <div id="status-result" class="mt-4 p-4 rounded text-center"
                                style="display:none; background: #f8fafc; border: 1px solid #e2e8f0;">
                                <h5 class="text-secondary mb-3">Current Status</h5>
                                <div id="status-badge" class="badge fs-6 px-4 py-2 mb-3"></div>
                                <p class="text-muted mb-0">Submitted on: <strong id="status-date"
                                        class="text-dark"></strong></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 3. RESOURCES SECTION -->
                <div id="policies-section" class="vig-section" style="display:none;">
                    <div class="vig-card">
                        <div class="vig-card-header text-center">
                            <h3>Policies & SOPs</h3>
                        </div>
                        <div class="vig-card-body p-0">
                            <ul id="documents-list" class="m-0 p-0" style="list-style:none;">
                                <?php if (empty($docs_data)): ?>
                                <li class="text-center py-4 text-muted">No documents available.</li>
                                <?php else: ?>
                                <?php foreach ($docs_data as $doc): ?>
                                <li class="vig-doc-item d-flex justify-content-between align-items-center py-2 px-4">
                                    <div class="d-flex align-items-center" style="gap: 20px;">
                                        <div class="vig-doc-icon">
                                            <i class="fas fa-file-pdf"></i>
                                        </div>
                                        <div>
                                            <div class="vig-doc-title"><?php echo esc_html($doc['title']); ?></div>
                                            <span
                                                class="vig-doc-badge text-uppercase"><?php echo esc_html(str_replace('_', ' ', $doc['document_type'])); ?></span>
                                        </div>
                                    </div>
                                    <a href="<?php echo esc_url($doc['file']); ?>" target="_blank" class="vig-doc-btn">
                                        <i class="fas fa-download"></i> View Document
                                    </a>
                                </li>
                                <?php endforeach; ?>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- 4. FAQ SECTION -->
                <div id="faq-section" class="vig-section" style="display:none;">
                    <div class="vig-card">
                        <div class="vig-card-header text-center">
                            <h3>Frequently Asked Questions</h3>
                        </div>
                        <div class="vig-card-body p-4">
                            <div class="accordion" id="faqAccordion">
                                <?php if (empty($faqs_data)): ?>
                                <div class="text-center py-4 text-muted">No FAQs available.</div>
                                <?php else: ?>
                                <div class="material-accordion-container">
                                    <?php foreach ($faqs_data as $idx => $faq): ?>
                                    <div class="material-accordion-item">
                                        <button class="material-accordion-header" type="button"
                                            onclick="window.toggleMaterialAccordion(this)">
                                            <span><?php echo esc_html($faq['question']); ?></span>
                                            <i class="fas fa-chevron-down material-accordion-icon"></i>
                                        </button>
                                        <div class="material-accordion-body-wrapper"
                                            style="max-height: 0; overflow: hidden; transition: max-height 0.3s ease;">
                                            <div class="material-accordion-body">
                                                <?php echo wp_kses_post($faq['answer']); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
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
    padding: 30px;
}

.vig-input {
    border-radius: 6px !important;
    padding: 6px 10px !important;
    background-color: #f8fafc;
}

.vig-input:focus {
    border-color: var(--fc-gold);
    box-shadow: 0 0 0 3px rgba(201, 168, 76, 0.2);
    background-color: #fff;
}

.vig-checkbox-group {
    padding: 15px;
    border-radius: 8px;
    border: 2px dashed #cbd5e1;
    display: flex;
    align-items: center;
    gap: 10px;
}

.vig-checkbox-group label {
    margin: 0;
    font-weight: 600;
    color: #334155;
    cursor: pointer;
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
    font-weight: 800;
    color: var(--fc-maroon);
    background: #fff;
    padding: 10px;
    border-radius: 8px;
    display: inline-block;
    border: 2px dashed var(--fc-gold);
    margin: 15px 0;
}

/* Fully Custom Material Accordion */
.material-accordion-container {
    border: 1px solid rgba(226, 217, 204, 0.6);
    border-radius: 12px;
    background: #fff;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.02);
}

.material-accordion-item {
    border-bottom: 1px solid rgba(226, 217, 204, 0.6);
    background: #fff;
    display: block;
    transition: all 0.3s ease;
    box-shadow: inset 0 0 0 0 var(--fc-maroon);
}

.material-accordion-item.active {
    box-shadow: inset 4px 0 0 0 var(--fc-maroon);
}

.material-accordion-item:last-child {
    border-bottom: none;
}

.material-accordion-header {
    background: transparent;
    border: none;
    padding: 18px 24px;
    font-weight: 700;
    font-size: 1.05rem;
    color: #334155;
    font-family: 'Nunito', sans-serif;
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 100%;
    cursor: pointer;
    transition: all 0.3s ease;
    outline: none !important;
    text-align: left;
}

.material-accordion-header:hover {
    background: rgba(201, 168, 76, 0.05);
    /* subtle gold tint */
    color: var(--fc-maroon);
}

.material-accordion-item.active .material-accordion-header {
    background: var(--fc-cream);
    color: var(--fc-maroon);
}

.material-accordion-icon {
    transition: transform 0.3s ease, color 0.3s ease;
    color: #94a3b8;
    font-size: 0.9rem;
    margin-left: 15px;
}

.material-accordion-header:hover .material-accordion-icon {
    color: var(--fc-maroon);
}

.material-accordion-item.active .material-accordion-icon {
    color: var(--fc-maroon);
}

.material-accordion-body {
    padding: 0 24px 24px 24px;
    color: #475569;
    font-size: 1rem;
    line-height: 1.6;
    background: var(--fc-cream);
}

/* Custom Document List */
.vig-doc-item {
    border-bottom: 1px solid rgba(226, 217, 204, 0.6);
    background: #fff;
    transition: all 0.3s ease;
    border-left: 4px solid transparent;
}

.vig-doc-item:last-child {
    border-bottom: none;
}

.vig-doc-item:hover {
    background: #fafaf9;
    border-left: 4px solid var(--fc-gold);
}

.vig-doc-icon {
    font-size: 1.5rem;
    color: var(--fc-maroon);
    opacity: 0.8;
}

.vig-doc-title {
    font-size: 1.1rem;
    font-weight: 700;
    color: #334155;
    margin-bottom: 6px;
    font-family: 'Nunito', sans-serif;
}

.vig-doc-badge {
    display: inline-block;
    padding: 4px 10px;
    background: var(--fc-cream);
    color: var(--fc-maroon);
    border-radius: 4px;
    font-size: 0.75rem;
    font-weight: 800;
    letter-spacing: 0.5px;
    border: 1px solid rgba(201, 168, 76, 0.3);
}

.vig-doc-btn {
    background: #fff;
    color: var(--fc-maroon) !important;
    border: 2px solid var(--fc-maroon);
    border-radius: 50px;
    font-weight: 700;
    padding: 8px 20px;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.vig-doc-btn:hover {
    background: var(--fc-maroon);
    color: #fff !important;
    box-shadow: 0 4px 12px rgba(139, 26, 26, 0.2);
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

@media (max-width: 480px) {
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

    .vig-checkbox-group {
        align-items: flex-start;
    }

    .vig-checkbox-group label {
        font-size: 14px;
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
        }[tag] || tag)
    );
}

document.addEventListener('DOMContentLoaded', function() {
    const apiBase = "<?php echo esc_js($api_public_base); ?>";

    // Pure JS Accordion Toggle to avoid Bootstrap conflicts
    window.toggleMaterialAccordion = function(btn) {
        const item = btn.parentElement;
        const bodyWrapper = item.querySelector('.material-accordion-body-wrapper');
        const icon = btn.querySelector('.material-accordion-icon');
        const isOpen = item.classList.contains('active');

        // Close all
        document.querySelectorAll('.material-accordion-item').forEach(otherItem => {
            otherItem.classList.remove('active');
            otherItem.querySelector('.material-accordion-body-wrapper').style.maxHeight = '0px';
            otherItem.querySelector('.material-accordion-icon').style.transform = 'rotate(0deg)';
        });

        // Open clicked if it wasn't open
        if (!isOpen) {
            item.classList.add('active');
            bodyWrapper.style.maxHeight = bodyWrapper.scrollHeight + "px";
            icon.style.transform = 'rotate(180deg)';
        }
    };

    // Tab Switching Logic with Deep Linking
    const tabBtns = document.querySelectorAll('.vig-tab-btn');
    const sections = document.querySelectorAll('.vig-section');

    function switchTab(targetId, updateHistory = true) {
        const btn = Array.from(tabBtns).find(b => b.dataset.target === targetId);
        if (!btn) return;

        // Remove active classes
        tabBtns.forEach(b => b.classList.remove('active'));
        sections.forEach(s => s.style.display = 'none');

        // Add active class
        btn.classList.add('active');
        document.getElementById(targetId).style.display = 'block';

        if (updateHistory) {
            const tabName = targetId.replace('-section', '');
            const url = new URL(window.location);
            url.searchParams.set('tab', tabName);
            window.history.pushState({ tab: targetId }, '', url);
        }
    }

    tabBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            switchTab(btn.dataset.target);
        });
    });

    // Handle initial load based on URL parameter
    const urlParams = new URLSearchParams(window.location.search);
    const initialTab = urlParams.get('tab');
    if (initialTab) {
        const targetId = initialTab + '-section';
        switchTab(targetId, false);
    } else {
        window.history.replaceState({ tab: 'register-section' }, '', window.location.href);
    }

    // Handle browser back/forward buttons
    window.addEventListener('popstate', (e) => {
        if (e.state && e.state.tab) {
            switchTab(e.state.tab, false);
        } else {
            switchTab('register-section', false);
        }
    });

    // Anonymous Toggle
    const anonymousToggle = document.getElementById('is_anonymous');
    const personalDetails = document.getElementById('personal-details-section');

    anonymousToggle.addEventListener('change', function() {
        if (this.checked) {
            personalDetails.style.opacity = '0.4';
            personalDetails.style.pointerEvents = 'none';
            document.getElementById('name').value = '';
            document.getElementById('email').value = '';
            document.getElementById('phone').value = '';
        } else {
            personalDetails.style.opacity = '1';
            personalDetails.style.pointerEvents = 'auto';
        }
    });

    // Complaint Submission
    document.getElementById('vigilance-form').addEventListener('submit', async function(e) {
        e.preventDefault();

        // Validation for non-anonymous submissions
        if (!anonymousToggle.checked) {
            const name = document.getElementById('name').value.trim();
            const email = document.getElementById('email').value.trim();
            const phone = document.getElementById('phone').value.trim();

            if (!name || !email || !phone) {
                alert(
                    'Please provide your Full Name, Email, and Phone number.');
                return;
            }

            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                alert('Please enter a valid email address.');
                return;
            }

            const phoneRegex = /^\d{10}$/;
            if (!phoneRegex.test(phone)) {
                alert('Please enter a valid 10-digit phone number.');
                return;
            }
        }

        const btn = document.getElementById('submit-btn');
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Submitting...';

        const formData = new FormData(this);
        
        // Sanitize string entries to prevent XSS payloads
        for (let [key, value] of formData.entries()) {
            if (typeof value === 'string') {
                formData.set(key, escapeHTML(value.trim()));
            }
        }
        formData.set('is_anonymous', anonymousToggle.checked ? 'True' : 'False');

        // Prevent DRF 400 Bad Request if no file is selected (FormData sends an empty file object otherwise)
        const fileInput = document.getElementById('uploaded_files');
        if (fileInput.files.length === 0) {
            formData.delete('uploaded_files');
        }

        try {
            const response = await fetch(`${apiBase}/api/v1/vigilance/complaints/`, {
                method: 'POST',
                body: formData
            });

            if (response.ok) {
                const data = await response.json();
                document.getElementById('vigilance-form').style.display = 'none';
                document.getElementById('tracking-id-text').innerText = data.tracking_id;
                document.getElementById('vigilance-success').style.display = 'block';
            } else {
                const err = await response.json();
                console.error('Validation Error:', err);
                alert('An error occurred. Please check your inputs and try again.');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('A network error occurred. Please try again later.');
        } finally {
            btn.disabled = false;
            btn.innerText = 'Submit Complaint';
        }
    });

    // Tracking Status
    document.getElementById('track-status-form').addEventListener('submit', async function(e) {
        e.preventDefault();
        const btn = document.getElementById('track-btn');
        const trackingId = document.getElementById('track_id').value.trim();
        const resultDiv = document.getElementById('status-result');

        btn.disabled = true;
        btn.innerText = 'Checking...';
        resultDiv.style.display = 'none';

        try {
            const response = await fetch(
                `${apiBase}/api/v1/vigilance/complaints/status/${trackingId}/`);

            if (response.ok) {
                const data = await response.json();
                resultDiv.style.display = 'block';
                resultDiv.className = 'mt-4 p-4 rounded bg-white border';

                const getStatusColor = (status) => {
                    const colors = {
                        'pending': 'warning',
                        'under_investigation': 'info',
                        'resolved': 'success',
                        'forwarded': 'primary',
                        'dismissed': 'danger'
                    };
                    return colors[status] || 'secondary';
                };

                let historyHtml = '';
                if (data.history && data.history.length > 0) {
                    historyHtml = `
                        <div class="mt-3">
                            <h6 class="text-secondary mb-4 text-uppercase fw-bold" style="letter-spacing: 1px; font-size: 0.85rem;">Status Timeline</h6>
                            <div class="timeline" style="border-left: 3px solid #e2e8f0; padding-left: 24px; margin-left: 12px;">
                    `;
                    data.history.forEach(item => {
                        const date = new Date(item.date).toLocaleString('en-US', {
                            year: 'numeric',
                            month: 'short',
                            day: 'numeric',
                            hour: '2-digit',
                            minute: '2-digit'
                        });
                        historyHtml += `
                            <div class="timeline-item position-relative mb-4">
                                <div class="timeline-dot bg-${getStatusColor(item.status)}" style="position: absolute; left: -31.5px; top: 4px; width: 12px; height: 12px; border-radius: 50%; border: 2px solid #fff; box-shadow: 0 0 0 2px var(--bs-${getStatusColor(item.status)}); "></div>
                                <div class="fw-bold text-${getStatusColor(item.status)} mb-1">${item.status_display || item.status}</div>
                                <div class="text-muted small mb-2"><i class="far fa-clock me-1"></i> ${date}</div>
                                <div class="text-secondary small bg-light p-3 rounded" style="border: 1px solid #f1f5f9; border-left: 3px solid var(--bs-${getStatusColor(item.status)});">${item.description}</div>
                            </div>
                        `;
                    });
                    historyHtml += `</div></div>`;
                }

                resultDiv.innerHTML = `
                    <h5 class="mb-4 text-dark border-bottom pb-3" style="font-family: 'Merriweather', serif;">Tracking Details</h5>
                    <div class="row mb-3">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <div class="text-muted small text-uppercase fw-bold mb-1">Tracking ID</div>
                            <div class="fs-6 fw-bold text-dark">${data.tracking_id}</div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-muted small text-uppercase fw-bold mb-1">Category</div>
                            <div class="">${data.category}</div>
                        </div>
                    </div>
                    <div class="mb-2">
                        <div class="text-muted small text-uppercase fw-bold mb-2">Current Status</div>
                        <span class="badge bg-${getStatusColor(data.status)} fs-6 px-4 py-2 text-uppercase shadow-sm rounded-pill">
                            ${data.status_display}
                        </span>
                    </div>
                    ${historyHtml}
                `;
            } else if (response.status === 404) {
                alert('Complaint not found. Please check your Tracking ID.');
            } else {
                alert('An error occurred. Please try again.');
            }
        } catch (error) {
            alert('A network error occurred.');
        } finally {
            btn.disabled = false;
            btn.innerText = 'Check Status';
        }
    });
});

function updateFileText(input) {
    const msg = input.parentElement.querySelector('.file-message');
    if (input.files && input.files.length > 1) {
        msg.innerText = input.files.length + ' files selected';
    } else if (input.files && input.files.length === 1) {
        msg.innerText = input.files[0].name;
    } else {
        msg.innerText = 'Click to upload files (PDF, JPG, PNG)';
    }
}
</script>

<?php get_footer(); ?>
