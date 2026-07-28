<?php
/*
Template Name: Vigilance Portal Template
*/
defined('ABSPATH') || exit;
get_header();

$api_base = getenv('DJANGO_API_URL'); 
$api_public_base = getenv('DJANGO_MEDIA_URL') ;
?>

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
                        of the public
                        and University personnel to report corruption, malpractice, or procedural lapses directly to the
                        University Vigilance Cell.
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
                    <button class="vig-tab-btn" data-target="resources-section">Resources & SOPs</button>
                </div>
            </div>

            <div class="col-lg-8 mx-auto">
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
                                <div class="vig-checkbox-group mb-4">
                                    <input type="checkbox" id="is_anonymous" name="is_anonymous">
                                    <label for="is_anonymous">Submit Anonymously (Hide personal details)</label>
                                </div>

                                <div id="personal-details-section">
                                    <div class="mb-3">
                                        <label class="form-label">Full Name</label>
                                        <input type="text" id="name" name="name" class="form-control vig-input">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Email Address</label>
                                        <input type="email" id="email" name="email" class="form-control vig-input">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Phone Number</label>
                                        <input type="text" id="phone" name="phone" class="form-control vig-input">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Complaint Category *</label>
                                    <select id="category" name="category" class="form-select vig-input" required>
                                        <option value="">Select a category</option>
                                        <option value="corruption">Corruption</option>
                                        <option value="malpractice">Malpractice</option>
                                        <option value="procedural_lapse">Procedural Lapse</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Complaint Details *</label>
                                    <textarea id="description" name="description" class="form-control vig-input"
                                        rows="5" required></textarea>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Upload Evidence (Optional)</label>
                                    <div class="file-drop-area"
                                        onclick="document.getElementById('uploaded_files').click()">
                                        <i class="fas fa-cloud-upload-alt fa-3x mb-2 text-primary"></i>
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
                                    <input type="text" id="track_id"
                                        class="form-control vig-input text-center text-uppercase fs-5"
                                        placeholder="e.g., VIG-A1B2C3D4" required>
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
                <div id="resources-section" class="vig-section" style="display:none;">
                    <div class="vig-card">
                        <div class="vig-card-header text-center">
                            <h3>Resources & Information</h3>
                        </div>
                        <div class="vig-card-body text-center py-5">
                            <i class="fas fa-info-circle fa-4x text-muted mb-3"></i>
                            <h4>SOPs and Policies will be dynamically loaded here.</h4>
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
    font-size: 16px;
    line-height: 1.4;
    /* max-width: 1000px; */
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
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    padding: 12px 15px;
    background: #f8fafc;
}

.vig-input:focus {
    border-color: var(--fc-gold);
    box-shadow: 0 0 0 3px rgba(201, 168, 76, 0.2);
    background: #fff;
}

.vig-checkbox-group {
    background: #f1f5f9;
    padding: 15px;
    border-radius: 8px;
    border: 1px dashed #cbd5e1;
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const apiBase = "<?php echo esc_js($api_public_base); ?>";

    // Tab Switching Logic
    const tabBtns = document.querySelectorAll('.vig-tab-btn');
    const sections = document.querySelectorAll('.vig-section');

    tabBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            // Remove active classes
            tabBtns.forEach(b => b.classList.remove('active'));
            sections.forEach(s => s.style.display = 'none');

            // Add active class
            btn.classList.add('active');
            document.getElementById(btn.dataset.target).style.display = 'block';
        });
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
                    'Please provide your Full Name, Email, and Phone number, or choose to submit anonymously.');
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

                const badge = document.getElementById('status-badge');
                badge.innerText = data.status_display;

                // Color coding
                if (data.status === 'pending') {
                    badge.className = 'badge bg-warning text-dark fs-6 px-4 py-2 mb-3';
                } else if (data.status === 'resolved') {
                    badge.className = 'badge bg-success fs-6 px-4 py-2 mb-3';
                } else {
                    badge.className = 'badge bg-primary fs-6 px-4 py-2 mb-3';
                }

                document.getElementById('status-date').innerText = new Date(data.submitted_at)
                    .toLocaleDateString();
                resultDiv.style.display = 'block';
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