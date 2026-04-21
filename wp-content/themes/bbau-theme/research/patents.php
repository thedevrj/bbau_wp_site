<?php
/**
 * Template Name: Research Patents
 */

get_header();

$api_base = getenv('DJANGO_MEDIA_URL');

// Fetch Departments for Filters
$depts_url = $api_base . '/api/v1/departments/?page_size=500';
$depts_res = wp_remote_get($depts_url, array('timeout' => 10));
$departments = array();
if (!is_wp_error($depts_res) && wp_remote_retrieve_response_code($depts_res) === 200) {
    $decoded = json_decode(wp_remote_retrieve_body($depts_res), true);
    $departments = isset($decoded['results']) ? $decoded['results'] : (is_array($decoded) ? $decoded : array());
}

// Fetch Faculty for Filters
$fac_url = $api_base . '/api/v1/faculty/?page_size=500';
$fac_res = wp_remote_get($fac_url, array('timeout' => 10));
$faculty_list = array();
if (!is_wp_error($fac_res) && wp_remote_retrieve_response_code($fac_res) === 200) {
    $decoded = json_decode(wp_remote_retrieve_body($fac_res), true);
    $faculty_list = isset($decoded['results']) ? $decoded['results'] : (is_array($decoded) ? $decoded : array());
}
?>

<main id="primary" class="site-main research-portal">
    <?php get_template_part('banners/about-banner'); ?>

    <div class="research-container container">
        <?php get_template_part('template-parts/breadcrumb');?>

        <!-- FILTER BAR -->
        <div class="filter-bar">
            <div class="patent-search-box">
                <i class="fas fa-search search-pt-icon"></i>
                <input type="text" id="patent-search" placeholder="Search by title or patent no..." autocomplete="off">
            </div>

            <select id="dept-filter" class="custom-select">
                <option value="">Filter by Departments</option>
                <?php foreach($departments as $dept): ?>
                <option value="<?php echo esc_attr($dept['slug']); ?>"><?php echo esc_html($dept['name']); ?></option>
                <?php endforeach; ?>
            </select>

            <select id="faculty-filter" class="custom-select">
                <option value="">Filter by Faculty</option>
                <?php foreach($faculty_list as $fac): ?>
                <option value="<?php echo esc_attr($fac['slug']); ?>"><?php echo esc_html($fac['name']); ?></option>
                <?php endforeach; ?>
            </select>

            <select id="status-filter" class="custom-select">
                <option value=""> Status</option>
                <option value="Filed">Filed</option>
                <option value="Published">Published</option>
                <option value="Granted">Granted</option>
            </select>
        </div>

        <div class="table-card">
            <div class="table-responsive">
                <table class="prog-table w-100" id="patents-table">
                    <thead>
                        <tr>
                            <th class="w-30">Title of Patent</th>
                            <th class="w-20">Inventor</th>
                            <th class="w-15">Patent No.</th>
                            <th class="w-15">Department</th>
                            <th class="w-10">Status</th>
                            <th class="w-10">Details</th>
                        </tr>
                    </thead>
                    <tbody id="patents-tbody">
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">
                                <i class="fas fa-spinner fa-spin me-2"></i> Loading patents...
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- PATENT MODAL -->
    <div id="patentModal" class="custom-modal">
        <div class="custom-modal-content">
            <span class="close-modal">&times;</span>
            <h2 id="modal-title" class="mb-3 modal-title-blue">Patent Title</h2>
            <div class="modal-meta mb-4 pb-3 modal-meta-custom">
                <span class="me-3"><i class="fas fa-user-tie"></i> <span id="modal-inventor"></span></span>
                <span class="me-3"><i class="fas fa-barcode"></i> <span id="modal-number"></span></span>
                <span><i class="fas fa-calendar-alt"></i> <span id="modal-date"></span></span>
            </div>
            <div id="modal-description" class="modal-body-content modal-desc-custom">
                <!-- Description HTML goes here -->
            </div>
        </div>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('patent-search');
    const deptFilter = document.getElementById('dept-filter');
    const facultyFilter = document.getElementById('faculty-filter');
    const statusFilter = document.getElementById('status-filter');
    const tbody = document.getElementById('patents-tbody');
    const apiBase = "<?php echo esc_js($api_base); ?>";

    // Modal Elements
    const modal = document.getElementById('patentModal');
    const closeBtn = document.querySelector('.close-modal');

    let patentsData = []; // Store fetched patents locally
    let debounceTimer;

    function fetchPatents() {
        const query = searchInput.value.toLowerCase().trim();
        const dept = deptFilter.value;
        const fac = facultyFilter.value;
        const status = statusFilter.value;

        let url = `${apiBase}/api/v1/patents/?page_size=500&`;
        if (query) url += `search=${encodeURIComponent(query)}&`;
        if (dept) url += `department__slug=${encodeURIComponent(dept)}&`;
        if (fac) url += `faculty__slug=${encodeURIComponent(fac)}&`;
        if (status) url += `status=${encodeURIComponent(status)}&`;

        tbody.innerHTML =
            `<tr><td colspan="6" class="text-center py-5 text-muted"><i class="fas fa-spinner fa-spin fa-2x mb-3 d-block"></i> Fetching records...</td></tr>`;

        fetch(url)
            .then(res => res.json())
            .then(data => {
                patentsData = data.results || data; // Handle paginated vs non-paginated
                renderTable(patentsData);
            })
            .catch(err => {
                console.error('Error fetching patents:', err);
                tbody.innerHTML =
                    `<tr><td colspan="6" class="text-danger text-center py-4">Failed to load patents. Please try again later.</td></tr>`;
            });
    }

    function renderTable(patents) {
        if (patents.length === 0) {
            tbody.innerHTML =
                `<tr><td colspan="6" class="text-center py-5 text-muted">No patents found matching your criteria.</td></tr>`;
            return;
        }

        const html = patents.map((p, index) => {
            const statusClass = (p.status || '').toLowerCase();
            return `
                <tr>
                    <td class="fw-bold fw-blue">${p.title}</td>
                    <td>${p.faculty_name || 'N/A'}</td>
                    <td>${p.patent_number || '-'}</td>
                    <td>${p.department_name || '-'}</td>
                    <td><span class="status-badge ${statusClass}">${p.status}</span></td>
                    <td class="text-center">
                        <button class="btn-view-desc" data-index="${index}"><i class="fas fa-eye"></i> View</button>
                    </td>
                </tr>
            `;
        }).join('');

        tbody.innerHTML = html;

        // Attach click listeners to view buttons
        document.querySelectorAll('.btn-view-desc').forEach(btn => {
            btn.addEventListener('click', function() {
                const pat = patentsData[this.getAttribute('data-index')];
                openModal(pat);
            });
        });
    }

    function openModal(pat) {
        document.getElementById('modal-title').textContent = pat.title;
        document.getElementById('modal-inventor').textContent = pat.faculty_name || 'Not specified';
        document.getElementById('modal-number').textContent = pat.patent_number || 'Not specified';
        document.getElementById('modal-date').textContent = pat.date_of_filing || pat.year || 'Not specified';

        const descEl = document.getElementById('modal-description');
        if (pat.description && pat.description.trim() !== '') {
            descEl.innerHTML = pat.description;
        } else {
            descEl.innerHTML =
                '<p class="text-muted fst-italic">No detailed description available for this patent.</p>';
        }

        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    closeBtn.addEventListener('click', () => {
        modal.style.display = 'none';
        document.body.style.overflow = '';
    });

    window.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.style.display = 'none';
            document.body.style.overflow = '';
        }
    });

    // Event Listeners for Filters
    searchInput.addEventListener('input', () => {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(fetchPatents, 400);
    });

    deptFilter.addEventListener('change', fetchPatents);
    facultyFilter.addEventListener('change', fetchPatents);
    statusFilter.addEventListener('change', fetchPatents);

    // Initial Fetch
    fetchPatents();
});
</script>

<?php include_once(get_template_directory() . '/research/styles-research.php'); ?>
<style>
:root {
    --theme-blue: #1e3a8a;
    --theme-amber: #b45309;
}

/* FILTER BAR */
.filter-bar {
    background: white;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    margin-bottom: 30px;
    display: flex;
    gap: 15px;
    flex-wrap: nowrap;
    align-items: center;
    border: 1px solid #f1f5f9;
}

.w-30 { width: 30%; }
.w-20 { width: 20%; }
.w-15 { width: 15%; }
.w-10 { width: 10%; }
.fw-blue { color: var(--theme-blue); }

.modal-title-blue {
    color: var(--theme-blue);
    font-size: 1.5rem;
    font-weight: 700;
}

.modal-meta-custom {
    border-bottom: 1px solid #e2e8f0;
    font-size: 0.9rem;
    color: #64748b;
}

.modal-desc-custom {
    line-height: 1.8;
    color: #334155;
}

.patent-search-box {
    flex: 1;
    min-width: 200px;
    position: relative;
}

.search-pt-icon {
    position: absolute;
    left: 15px;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
}

.patent-search-box input {
    width: 100%;
    padding: 10px 15px 10px 40px;
    border-radius: 8px;
    border: 1px solid #cbd5e1;
    font-size: 0.95rem;
    transition: all 0.2s;
}

.patent-search-box input:focus {
    border-color: var(--theme-blue);
    outline: none;
    box-shadow: 0 0 0 3px rgba(30, 58, 138, 0.1);
}

.custom-select {
    flex: 1;
    padding: 10px 15px;
    border-radius: 8px;
    border: 1px solid #cbd5e1;
    color: #475569;
    background-color: #f8fafc;
    min-width: 120px;
    cursor: pointer;
}

/* TABLE CARD */
.table-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
    overflow: hidden;
    border: 1px solid #f1f5f9;
}

.table-responsive {
    overflow-x: auto;
}

.prog-table {
    width: 100%;
    border-collapse: collapse;
    min-width: 800px;
}

.prog-table th {
    background-color: #f8fafc;
    color: #475569;
    font-size: 0.8rem;
    text-transform: uppercase;
    font-weight: 700;
    letter-spacing: 0.05em;
    padding: 18px 20px;
    text-align: left;
    border-bottom: 2px solid #e2e8f0;
}

.prog-table td {
    padding: 18px 20px;
    border-bottom: 1px solid #f1f5f9;
    color: #334155;
    vertical-align: middle;
}

.prog-table tr:hover {
    background-color: #f8fafc;
}

/* BADGES AND BUTTONS */
.status-badge {
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    display: inline-block;
    white-space: nowrap;
}

.status-badge.filed {
    background: #e0f2fe;
    color: #0284c7;
}

.status-badge.published {
    background: #fef3c7;
    color: #d97706;
}

.status-badge.granted {
    background: #dcfce7;
    color: #166534;
}

.btn-view-desc {
    background: #f1f5f9;
    color: var(--theme-blue);
    border: none;
    padding: 8px 16px;
    border-radius: 6px;
    font-size: 0.85rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
    white-space: nowrap;
}

.btn-view-desc:hover {
    background: var(--theme-blue);
    color: white;
}

/* CUSTOM MODAL */
.custom-modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(15, 23, 42, 0.7);
    z-index: 10000;
    backdrop-filter: blur(4px);
    justify-content: center;
    align-items: center;
}

.custom-modal-content {
    background: white;
    border-radius: 16px;
    padding: 40px;
    width: 90%;
    max-width: 800px;
    max-height: 85vh;
    overflow-y: auto;
    position: relative;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    animation: modalFadeIn 0.3s ease-out;
}

.close-modal {
    position: absolute;
    top: 20px;
    right: 25px;
    font-size: 2rem;
    line-height: 1;
    color: #94a3b8;
    cursor: pointer;
    transition: color 0.2s;
}

.close-modal:hover {
    color: #ef4444;
}

@keyframes modalFadeIn {
    from {
        opacity: 0;
        transform: translateY(20px) scale(0.95);
    }

    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

@media (max-width: 768px) {
    .filter-bar {
        flex-direction: column;
    }

    .custom-select {
        width: 100%;
    }

    .custom-modal-content {
        padding: 25px;
        width: 95%;
    }
}
</style>

<?php get_footer(); ?>