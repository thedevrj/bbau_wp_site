<?php
/**
 * Template Name: Notice Portal
 *
 * @package BBAU_Theme
 */

get_header();

$media_base = getenv('DJANGO_MEDIA_URL');

// Reuse background from satellite campus if available, otherwise a placeholder
$banner_url = "/wp-content/uploads/2026/04/language.png"; 
?>

<div class="satellite-campus-portal notice-portal-brand">

    <div class="sc-hero" style="background-image: url('<?php echo esc_url($banner_url); ?>');">
        <div class="sc-hero-overlay">
            <div class="sc-hero-card">
                <span class="sc-badge">University Bulletin</span>
                <h1>Notice Portal</h1>
                <div class="sc-hero-line"></div>
            </div>
        </div>
    </div>

    <div class="container py-5">
        <!-- SEARCH & FILTER BAR -->
        <div class="sc-content-card mb-4">
            <div class="row g-3">
                <div class="col-lg-4 col-md-6">
                    <div class="sc-search-wrap">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <input type="text" id="notice-search" class="form-control"
                            placeholder="Search announcements...">
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <select id="notice-timeline" class="form-select sc-select">
                        <option value="all">Any Time</option>
                        <option value="7">Last 7 Days</option>
                        <option value="15">Last 15 Days</option>
                        <option value="30">Last 30 Days</option>
                    </select>
                </div>
                <div class="col-lg-3 col-md-6">
                    <select id="notice-sort" class="form-select sc-select">
                        <option value="desc">Newest First</option>
                        <option value="asc">Oldest First</option>
                    </select>
                </div>
                <div class="col-lg-2 col-md-6">
                    <button id="reset-filters" class="btn sc-btn-gold w-100">Reset</button>
                </div>
            </div>
        </div>

        <div class="row g-5">
            <!-- LEFT: CATEGORIES & STAFF -->
            <div class="col-lg-4">
                <aside class="sc-sidebar">
                    <section class="sc-section mb-3">
                        <h2 class="sc-section-title">Categories</h2>
                        <div class="sc-category-list" id="category-list">
                            <a href="#" class="sc-cat-item active" data-cat="">
                                <span>All Notifications</span>
                                <i class="fa-solid fa-chevron-right"></i>
                            </a>
                            <a href="#" class="sc-cat-item" data-cat="Announcement">
                                <span>Announcements</span>
                                <i class="fa-solid fa-chevron-right"></i>
                            </a>
                            <a href="#" class="sc-cat-item" data-cat="Event">
                                <span>Events</span>
                                <i class="fa-solid fa-chevron-right"></i>
                            </a>
                            <a href="#" class="sc-cat-item" data-cat="Appointment">
                                <span>Appointments</span>
                                <i class="fa-solid fa-chevron-right"></i>
                            </a>
                            <a href="#" class="sc-cat-item" data-cat="Tenders">
                                <span>Tenders</span>
                                <i class="fa-solid fa-chevron-right"></i>
                            </a>
                        </div>
                    </section>

                    <section class="sc-section">
                        <h2 class="sc-section-title">Secure Access</h2>
                        <div class="sc-content-card text-center" id="staff-auth-card">
                            <div id="auth-unlogged">
                                <p class=" text-muted mb-3">Faculty and Staff login for internal notices.</p>
                                <button class="btn sc-btn-midnight w-100" onclick="toggleModal('login-modal', true)">
                                    <i class="fa-solid fa-user-lock me-2"></i> Login
                                </button>
                            </div>
                            <div id="auth-logged" class="d-none">
                                <div class="sc-user-brief mb-3">
                                    <div class="sc-user-avatar"><i class="fa-solid fa-user-tie"></i></div>
                                    <h4 id="logged-username" class="mb-0">Authorized User</h4>
                                    <span class="sc-status-dot">Verified Session</span>
                                </div>
                                <button class="btn sc-btn-gold w-100 mb-2 d-none" id="tab-private" data-tab="private">
                                    Dashboard
                                </button>
                                <button class="btn btn-outline-danger btn-sm w-100" id="btn-logout">Logout</button>
                            </div>
                        </div>
                    </section>
                </aside>
            </div>

            <!-- RIGHT: NOTICES LIST -->
            <div class="col-lg-8">
                <section class="sc-section">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2 class="sc-section-title mb-0">Latest Updates</h2>
                        <span class="sc-count-badge" id="result-count">0</span>
                    </div>

                    <div id="notices-list" class="sc-notice-grid">
                        <!-- Shimmers -->
                        <div class="sc-shimmer"></div>
                        <div class="sc-shimmer"></div>
                        <div class="sc-shimmer"></div>
                    </div>
                    <nav id="notice-pagination" class="notice-pagination" aria-label="Notice pages"></nav>
                </section>
            </div>
        </div>
    </div>
</div>

<!-- Login Modal -->
<div class="sc-modal" id="login-modal">
    <div class="sc-modal-overlay" onclick="toggleModal('login-modal', false)"></div>
    <div class="sc-modal-box">
        <button class="sc-modal-close" onclick="toggleModal('login-modal', false)">&times;</button>
        <div class="sc-modal-header">
            <h3>Portal Authentication</h3>
            <p class="sc-modal-subtitle">Secure access for Faculty & Staff</p>
        </div>
        <div class="sc-modal-body">
            <form id="staff-login-form">
                <div class="sc-input-group">
                    <label class="sc-input-label">Username</label>
                    <input type="text" name="username" class="sc-input" placeholder="Enter your Username" required
                        autocomplete="username">
                </div>
                <div class="sc-input-group">
                    <label class="sc-input-label">Password</label>
                    <input type="password" name="password" class="sc-input" placeholder="••••••••" required
                        autocomplete="current-password">
                </div>
                <div id="login-error" class="alert alert-danger d-none mb-4"></div>
                <button type="submit" class="btn-sc-submit" id="btn-login-submit">
                    Login
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Change Password Modal (First Login) -->
<div class="sc-modal" id="password-modal">
    <div class="sc-modal-overlay"></div>
    <div class="sc-modal-box">
        <div class="sc-modal-header">
            <h3>Update Security</h3>
            <p class="sc-modal-subtitle">Set a new password for your account</p>
        </div>
        <div class="sc-modal-body">
            <form id="change-password-form">

                <input type="text" name="username" value="logged_in_username_here" autocomplete="username"
                    style="display: none;">
                <div class="sc-input-group">
                    <label class="sc-input-label">New Password</label>
                    <input type="password" id="new-password" name="new_password" class="sc-input"
                        placeholder="Min. 8 characters" required autocomplete="new-password">
                </div>
                <div class="sc-input-group">
                    <label class="sc-input-label">Confirm Password</label>
                    <input type="password" id="confirm-password" class="sc-input"
                        placeholder="Confirm your new password" required autocomplete="Confirm your new password">
                </div>
                <div id="password-error" class="alert alert-danger d-none mb-4"></div>
                <button type="submit" class="btn-sc-submit" id="btn-pass-submit">
                    Set New Password
                </button>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const isLocal = window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1';
    const mediaBase = "<?= $media_base ?>";
    const apiBase = isLocal ? 'http://localhost:8001/api/v1' : `${mediaBase}/api/v1`;

    let allNotices = [];
    let currentCat = '';
    let currentTab = 'all';
    let currentPage = 1;
    const noticesPerPage =10;
    let firstLoginOldPassword = '';
    let firstLoginUsername = '';

    const listContainer = document.getElementById('notices-list');
    const searchInput = document.getElementById('notice-search');
    const timelineSelect = document.getElementById('notice-timeline');
    const sortSelect = document.getElementById('notice-sort');
    const resetBtn = document.getElementById('reset-filters');
    const authUnlogged = document.getElementById('auth-unlogged');
    const authLogged = document.getElementById('auth-logged');
    const loggedUsername = document.getElementById('logged-username');
    const tabPrivate = document.getElementById('tab-private');

    async function updateAuthUI() {
        const user = localStorage.getItem('portal_user');
        let authenticated = false;
        try {
            const session = await fetch(`${apiBase.replace('/api/v1', '')}/portal/api/session/`, {
                credentials: 'include'
            });
            authenticated = session.ok;
        } catch (e) {}
        if (authenticated) {
            authUnlogged.classList.add('d-none');
            authLogged.classList.remove('d-none');
            tabPrivate.classList.remove('d-none');
            loggedUsername.textContent = user;
            currentTab = 'private';
            tabPrivate.classList.remove('btn-success');
        } else {
            authUnlogged.classList.remove('d-none');
            authLogged.classList.add('d-none');
            tabPrivate.classList.add('d-none');
            currentTab = 'all';
            tabPrivate.classList.remove('btn-success');
        }
    }

    async function fetchNotices() {
        const headers = {};

        try {
            const res = await fetch(`${apiBase}/global-notices/?page_size=500`, {
                headers,
                credentials: 'include'
            });
            const data = await res.json();

            allNotices = (data.results || []).map(n => ({
                ...n,
                cat: n.categories?. [0] || 'General',
                date: new Date(n.date_posted)
            }));

            render();
        } catch (e) {
            listContainer.innerHTML = '<p>Connection Error.</p>';
        }
    }

    function render() {
        const search = searchInput.value.toLowerCase();
        const timelineVal = timelineSelect.value;
        const sortVal = sortSelect.value;

        let filtered = allNotices.filter(n => {
            const matchesSearch = n.title.toLowerCase().includes(search);
            const matchesCat = !currentCat || n.cat === currentCat;
            const matchesTab = currentTab === 'all' ? true : n.is_private;

            // Timeline Filter
            let matchesTimeline = true;
            if (timelineVal !== 'all') {
                const days = parseInt(timelineVal);
                const now = new Date();
                const diffTime = Math.abs(now - n.date);
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                matchesTimeline = diffDays <= days;
            }

            return matchesSearch && matchesCat && matchesTab && matchesTimeline;
        });

        // Sorting
        filtered.sort((a, b) => {
            return sortVal === 'asc' ? a.date - b.date : b.date - a.date;
        });

        document.getElementById('result-count').textContent = `Total: ${filtered.length}`;

        const totalPages = Math.ceil(filtered.length / noticesPerPage);
        if (totalPages > 0 && currentPage > totalPages) currentPage = totalPages;
        const pageStart = (currentPage - 1) * noticesPerPage;
        const pageNotices = filtered.slice(pageStart, pageStart + noticesPerPage);

        if (filtered.length === 0) {
            listContainer.innerHTML = '<p class="py-5 text-center">No announcements found.</p>';
            renderPagination(0);
            return;
        }

        listContainer.innerHTML = pageNotices.map(n => `
            <a href="${n.attachment || n.link || '#'}" target="_blank" class="sc-notice-card ${n.is_private ? 'is-private' : ''}">
                <div class="sc-notice-icon">
                    <i class="fa-solid ${n.is_private ? 'fa-lock-open' : 'fa-bullhorn'}"></i>
                </div>
                <div class="sc-notice-info">
                    <h3>${n.title}</h3>
                    <div class="sc-notice-meta">
                        ${n.cat} &bull; ${n.date.toLocaleDateString('en-GB')}
                    </div>
                </div>
            </a>
        `).join('');
        renderPagination(totalPages);
    }

    function renderPagination(totalPages) {
        const pagination = document.getElementById('notice-pagination');
        pagination.innerHTML = '';
        if (totalPages <= 1) return;

        const addButton = (label, page, disabled = false, current = false) => {
            const button = document.createElement('button');
            button.type = 'button';
            button.className = `notice-page-btn${current ? ' active' : ''}`;
            button.innerHTML = label === '<'
                ? '<i class="fa-solid fa-chevron-left" style="font-size:.7rem;" aria-hidden="true"></i>'
                : label === '>'
                    ? '<i class="fa-solid fa-chevron-right" style="font-size:.7rem;" aria-hidden="true"></i>'
                    : label;
            button.disabled = disabled;
            if (current) button.setAttribute('aria-current', 'page');
            button.setAttribute('aria-label', label === '<' ? 'Previous page' : label === '>' ? 'Next page' : `Page ${page}`);
            button.addEventListener('click', () => {
                currentPage = page;
                render();
                document.getElementById('notices-list').scrollIntoView({ behavior: 'smooth', block: 'start' });
            });
            pagination.appendChild(button);
        };

        addButton('<', currentPage - 1, currentPage === 1);
        for (let page = 1; page <= totalPages; page++) {
            if (totalPages > 7 && page > 2 && page < totalPages - 1 && Math.abs(page - currentPage) > 1) {
                if (page === 3 || page === totalPages - 2) {
                    const ellipsis = document.createElement('span');
                    ellipsis.className = 'notice-page-ellipsis';
                    ellipsis.textContent = '…';
                    pagination.appendChild(ellipsis);
                }
                continue;
            }
            addButton(String(page), page, false, page === currentPage);
        }
        addButton('>', currentPage + 1, currentPage === totalPages);
    }

    // Auth Actions
    document.getElementById('staff-login-form').addEventListener('submit', async (e) => {
        e.preventDefault();
        const data = Object.fromEntries(new FormData(e.target).entries());
        const loginError = document.getElementById('login-error');
        loginError.classList.add('d-none');

        try {
            // Using our custom security-aware login endpoint
            const res = await fetch(`${apiBase.replace('/api/v1', '')}/portal/api/login/`, {
                method: 'POST',
                credentials: 'include',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            });
            const resData = await res.json();

            if (res.ok) {
                // Check if user is forced to change password
                if (resData.force_password_change) {
                    firstLoginOldPassword = data.password;
                    firstLoginUsername = data.username;
                    toggleModal('login-modal', false);
                    toggleModal('password-modal', true);
                    return;
                }

                // The backend owns the HttpOnly auth cookie.
                localStorage.setItem('portal_user', data.username);
                toggleModal('login-modal', false);
                updateAuthUI();
                fetchNotices();
            } else {
                loginError.textContent = resData.detail || "Login failed.";
                loginError.classList.remove('d-none');
            }
        } catch (i) {
            loginError.textContent = "Network error. Please try again.";
            loginError.classList.remove('d-none');
        }
    });

    document.getElementById('change-password-form').addEventListener('submit', async (e) => {
        e.preventDefault();
        const newPass = document.getElementById('new-password').value;
        const confirmPass = document.getElementById('confirm-password').value;
        const passError = document.getElementById('password-error');

        passError.classList.add('d-none');

        if (newPass.length < 8) {
            passError.textContent = "Password must be at least 8 characters long.";
            passError.classList.remove('d-none');
            return;
        }

        if (newPass !== confirmPass) {
            passError.textContent = "Passwords do not match.";
            passError.classList.remove('d-none');
            return;
        }

        try {
            const res = await fetch(
                `${apiBase.replace('/api/v1', '')}/portal/api/change-password/`, {
                    method: 'POST',
                    credentials: 'include',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        old_password: firstLoginOldPassword,
                        new_password: newPass,
                        confirm_password: confirmPass
                    })
                });

            if (res.ok) {
                // Password changed! Now log them in properly
                firstLoginOldPassword = '';
                localStorage.setItem('portal_user', firstLoginUsername);

                toggleModal('password-modal', false);
                updateAuthUI();
                fetchNotices();
                alert("Security updated! Welcome to the Portal.");
            } else {
                const data = await res.json();
                passError.textContent = data.detail || "Update failed.";
                passError.classList.remove('d-none');
            }
        } catch (err) {
            passError.textContent = "Network error.";
            passError.classList.remove('d-none');
        }
    });

    document.getElementById('btn-logout').addEventListener('click', async () => {
        try {
            await fetch(`${apiBase.replace('/api/v1', '')}/portal/logout/`, {
                method: 'GET',
                credentials: 'include'
            });
        } finally {
            localStorage.removeItem('portal_user');
            currentTab = 'all';
            updateAuthUI();
            fetchNotices();
        }
    });

    // Event Listeners for Filters
    [searchInput, timelineSelect, sortSelect].forEach(el => {
        const updateResults = () => { currentPage = 1; render(); };
        el.addEventListener('change', updateResults);
        if (el === searchInput) el.addEventListener('input', updateResults);
    });

    document.querySelectorAll('.sc-cat-item').forEach(li => {
        li.addEventListener('click', (e) => {
            e.preventDefault();
            document.querySelectorAll('.sc-cat-item').forEach(l => l.classList.remove(
                'active'));
            li.classList.add('active');
            currentCat = li.dataset.cat;
            currentPage = 1;
            render();
        });
    });

    tabPrivate.addEventListener('click', () => {
        currentTab = currentTab === 'all' ? 'private' : 'all';
        currentPage = 1;
        tabPrivate.classList.toggle('btn-success', currentTab === 'private');
        render();
    });

    resetBtn.addEventListener('click', () => {
        searchInput.value = '';
        timelineSelect.value = 'all';
        sortSelect.value = 'desc';
        currentCat = '';
        currentPage = 1;
        document.querySelectorAll('.sc-cat-item').forEach(l => l.classList.remove('active'));
        document.querySelector('[data-cat=""]').classList.add('active');
        render();
    });

    updateAuthUI();
    fetchNotices();
});

function toggleModal(id, show) {
    document.getElementById(id).classList.toggle('active', show);
}
</script>

<?php get_footer(); ?>
