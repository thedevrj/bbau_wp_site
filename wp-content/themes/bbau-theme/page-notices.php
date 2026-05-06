<?php
/**
 * Template Name: Notice Portal
 *
 * @package BBAU_Theme
 */

get_header();

// Reuse background from satellite campus if available, otherwise a placeholder
$banner_url = "/wp-content/uploads/2026/04/language.png"; 
?>

<div class="satellite-campus-portal notice-portal-brand">

    <!-- HERO SECTION - Aligned with Satellite Campus -->
    <div class="sc-hero" style="background-image: url('<?php echo esc_url($banner_url); ?>');">
        <div class="sc-hero-overlay">
            <div class="sc-hero-card">
                <span class="sc-badge">University Archive</span>
                <h1>Notice Portal</h1>
                <div class="sc-hero-line"></div>
            </div>
        </div>
    </div>

    <div class="container py-5">
        <!-- SEARCH & FILTER BAR -->
        <div class="sc-content-card mb-4">
            <div class="row g-3">
                <div class="col-lg-6 col-md-6">
                    <div class="sc-search-wrap">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <input type="text" id="notice-search" class="form-control"
                            placeholder="Search announcements...">
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <select id="notice-source" class="form-select sc-select">
                        <option value="all">Sort by</option>
                        <option value="global">University Wide</option>
                        <option value="dept">Departmental</option>
                    </select>
                </div>

                <!-- Advanced Filters -->
                <div class="col-lg-3 col-md-6">
                    <select id="notice-timeline" class="form-select sc-select">
                        <option value="all">Any Time</option>
                        <option value="7">Last 7 Days</option>
                        <option value="30">Last 30 Days</option>
                    </select>
                </div>
                <div class="col-lg-5 col-md-6">
                    <select id="notice-dept" class="form-select sc-select">
                        <option value="all">All Departments</option>
                    </select>
                </div>
                <div class="col-lg-4 col-md-6">
                    <select id="notice-sort" class="form-select sc-select">
                        <option value="desc">Newest First</option>
                        <option value="asc">Oldest First</option>
                    </select>
                </div>
                <div class="col-lg-3 col-md-6">
                    <button id="reset-filters" class="btn sc-btn-gold w-75">Reset</button>
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
                            <a href="#" class="sc-cat-item" data-cat="Academic">
                                <span>Academic</span>
                                <i class="fa-solid fa-chevron-right"></i>
                            </a>
                            <a href="#" class="sc-cat-item" data-cat="Examination">
                                <span>Examination</span>
                                <i class="fa-solid fa-chevron-right"></i>
                            </a>
                            <a href="#" class="sc-cat-item" data-cat="Admission">
                                <span>Admission</span>
                                <i class="fa-solid fa-chevron-right"></i>
                            </a>
                            <a href="#" class="sc-cat-item" data-cat="Recruitment">
                                <span>Recruitment</span>
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
                                    <h4 id="logged-username" class="mb-0">Staff</h4>
                                    <span class="sc-status-dot">Verified Session</span>
                                </div>
                                <button class="btn sc-btn-gold w-100 mb-2 d-none" id="tab-private" data-tab="private">
                                    Internal Dashboard
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
            <h3>Login Portal</h3>
            <p class="sc-modal-subtitle">Secure Authentication</p>
        </div>
        <div class="sc-modal-body">
            <form id="staff-login-form">
                <div class="sc-input-group">
                    <label class="sc-input-label">Username</label>
                    <input type="text" name="username" class="sc-input" placeholder="Enter your ID" required>
                </div>
                <div class="sc-input-group">
                    <label class="sc-input-label">Password</label>
                    <input type="password" name="password" class="sc-input" placeholder="••••••••" required>
                </div>
                <div id="login-error" class="alert alert-danger d-none mb-4"></div>
                <button type="submit" class="btn-sc-submit" id="btn-login-submit">
                    Access Portal
                </button>
            </form>
        </div>
    </div>
</div>

<style>
/* ============================================================
   BRANDED NOTICE PORTAL - SATELLITE CAMPUS STYLE
============================================================ */

@import url('https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700;900&family=Nunito:wght@400;600;700;800&display=swap');

:root {
    --sc-midnight: #0f172a;
    --sc-slate: #1e293b;
    --sc-gold: #c9a84c;
    --sc-gold-light: #e2d9cc;
    --sc-bg: #fdfaf6;
    --sc-white: #ffffff;
}

.notice-portal-brand {
    background-color: var(--sc-bg);
    min-height: 100vh;
    font-family: 'Nunito', sans-serif;
    color: var(--sc-slate);
}

/* --- HERO --- */
.sc-hero {
    height: 350px;
    background-size: contain;
    background-position: center;
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
}

.sc-hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(to bottom, rgba(15, 23, 42, 0.4), rgba(15, 23, 42, 0.7));
}

.sc-hero-overlay {
    position: relative;
    z-index: 2;
    width: 100%;
    max-width: 800px;
    padding: 20px;
}

.sc-hero-card {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    padding: 25px;
    border-radius: 30px;
    text-align: center;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
    color: #fff;
    animation: scFadeInScale 0.8s ease-out;
}

.sc-badge {
    background: var(--sc-gold);
    color: var(--sc-midnight);
    padding: 6px 20px;
    border-radius: 50px;
    font-weight: 800;
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 2px;
    display: inline-block;
    margin-bottom: 15px;
}

.sc-hero-card h1 {
    font-family: 'Merriweather', serif;
    font-size: 2rem;
    font-weight: 900;
    margin: 0;
}

.sc-hero-line {
    width: 60px;
    height: 4px;
    background: var(--sc-gold);
    margin: 20px auto;
    border-radius: 2px;
}

/* --- COMPONENTS --- */
.sc-section-title {
    font-family: 'Merriweather', serif;
    font-size: 1.6rem;
    font-weight: 800;
    color: var(--sc-midnight);
    margin-bottom: 25px;
    position: relative;
    display: inline-block;
}

.sc-section-title::after {
    content: '';
    position: absolute;
    left: 0;
    bottom: -8px;
    width: 40px;
    height: 3px;
    background: var(--sc-gold);
}

.sc-content-card {
    background: #fff;
    padding: 30px;
    border-radius: 20px;
    border: 1px solid var(--sc-gold);
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
}

#staff-auth-card {
    background: #fdfaf6;
    width: 300px;
    border: 1px solid var(--sc-gold);
    box-shadow: 0 10px 20px rgba(201, 168, 76, 0.2);
}

.sc-count-badge {
    background: var(--sc-midnight);
    color: #fff;
    padding: 5px 15px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 700;
}

/* --- SEARCH --- */
.sc-search-wrap {
    position: relative;
    display: flex;
    align-items: center;
}

.sc-search-wrap i {
    position: absolute;
    left: 15px;
    color: var(--sc-gold);
}

.sc-search-wrap input {
    padding-left: 45px;
    height: 50px;
    border-radius: 12px;
    border: 1px solid var(--sc-gold-light);
}

.sc-select {
    height: 50px;
    border-radius: 12px;
    border: 1px solid var(--sc-gold-light);
}

.sc-btn-gold {
    background: var(--sc-gold);
    color: var(--sc-midnight);
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 1px;
    border: none;
    height: 50px;
    border-radius: 12px;
    transition: 0.3s;
}

.sc-btn-gold:hover {
    background: var(--sc-midnight);
    color: var(--sc-gold);
}

.sc-btn-midnight {
    background: var(--sc-midnight);
    color: var(--sc-gold);
    font-weight: 800;
    border: none;
    height: 50px;
    border-radius: 12px;
}

.sc-btn-midnight:hover {
    background: var(--sc-gold);
    color: var(--sc-midnight);
}

/* --- SIDEBAR --- */
.sc-category-list {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.sc-cat-item {
    background: #fff;
    padding: 15px 20px;
    border-radius: 14px;
    text-decoration: none !important;
    color: var(--sc-midnight) !important;
    font-weight: 700;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border: 1px solid var(--sc-gold-light);
    transition: 0.3s;
}

.sc-cat-item:hover,
.sc-cat-item.active {
    background: var(--sc-midnight);
    color: var(--sc-gold) !important;
    border-color: var(--sc-midnight);
}

/* --- NOTICE CARDS --- */
.sc-notice-grid {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.sc-notice-card {
    background: #fff;
    border: 1px solid var(--sc-gold-light);
    padding: 25px;
    border-radius: 18px;
    display: flex;
    align-items: center;
    gap: 20px;
    text-decoration: none !important;
    transition: all 0.3s ease;
}

.sc-notice-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    border-color: var(--sc-gold);
}

.sc-notice-icon {
    width: 60px;
    height: 60px;
    background: #f8fafc;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: var(--sc-midnight);
}

.sc-notice-card.is-private {
    border-left: 6px solid var(--sc-gold);
    background: #fffdf9;
}

.sc-notice-info h3 {
    font-family: 'Merriweather', serif;
    font-size: 1.15rem;
    font-weight: 700;
    color: var(--sc-midnight);
    margin-bottom: 5px;
}

.sc-notice-meta {
    font-size: 0.8rem;
    font-weight: 700;
    color: var(--sc-gold);
    display: flex;
    align-items: center;
    gap: 10px;
}

/* --- PREMIUM MODAL --- */
.sc-modal {
    position: fixed;
    inset: 0;
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 9999;
}

.sc-modal.active {
    display: flex;
}

.sc-modal-overlay {
    position: absolute;
    inset: 0;
    background: rgba(15, 23, 42, 0.4);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
}

.sc-modal-box {
    background: #fff;
    width: 100%;
    max-width: 480px;
    position: relative;
    border-radius: 28px;
    padding: 60px;
    box-shadow: 0 40px 100px rgba(0, 0, 0, 0.15);
    border: 1px solid rgba(201, 168, 76, 0.2);
    transform: translateY(30px);
    opacity: 0;
    transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
}

.sc-modal.active .sc-modal-box {
    transform: translateY(0);
    opacity: 1;
}

.sc-modal-header {
    text-align: center;
    margin-bottom: 40px;
}

.sc-modal-header h3 {
    font-family: 'Merriweather', serif;
    font-size: 1.8rem;
    font-weight: 900;
    color: var(--sc-midnight);
    margin-bottom: 8px;
}

.sc-modal-subtitle {
    color: #64748b;
    font-size: 0.95rem;
}

.sc-modal-close {
    position: absolute;
    top: 25px;
    right: 30px;
    background: none;
    border: none;
    font-size: 2rem;
    color: #94a3b8;
    cursor: pointer;
    transition: 0.3s;
    line-height: 1;
}

.sc-modal-close:hover {
    color: var(--sc-gold);
    transform: rotate(90deg);
}

.sc-input-group {
    margin-bottom: 30px;
}

.sc-input-label {
    display: block;
    font-weight: 800;
    font-size: 0.7rem;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    margin-bottom: 12px;
    color: var(--sc-gold);
}

.sc-input {
    width: 100%;
    border: none;
    border-bottom: 2px solid #f1f1f1;
    padding: 12px 0;
    font-size: 1.1rem;
    outline: none;
    background: transparent;
    font-family: 'Nunito', sans-serif;
    transition: all 0.3s;
}

.sc-input:focus {
    border-bottom-color: var(--sc-gold);
}

.btn-sc-submit {
    width: 100%;
    background: var(--sc-midnight);
    color: var(--sc-gold);
    border: none;
    padding: 18px;
    border-radius: 14px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 2px;
    font-size: 0.9rem;
    transition: 0.3s;
    cursor: pointer;
    box-shadow: 0 10px 20px rgba(15, 23, 42, 0.2);
}

.btn-sc-submit:hover {
    background: var(--sc-gold);
    color: var(--sc-midnight);
    transform: translateY(-2px);
    box-shadow: 0 15px 30px rgba(201, 168, 76, 0.3);
}

/* --- ANIMATIONS --- */
@keyframes scFadeInScale {
    from {
        opacity: 0;
        transform: scale(0.95);
    }

    to {
        opacity: 1;
        transform: scale(1);
    }
}

.sc-shimmer {
    height: 100px;
    background: #eee;
    border-radius: 18px;
    margin-bottom: 20px;
    animation: scPulse 1.5s infinite;
}

@keyframes scPulse {

    0%,
    100% {
        opacity: 0.5;
    }

    50% {
        opacity: 1;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const isLocal = window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1';
    const apiBase = isLocal ? 'http://localhost:8001/api/v1' : 'http://172.35.0.45:8001/api/v1';

    let allNotices = [];
    let currentCat = '';
    let currentTab = 'all';

    const listContainer = document.getElementById('notices-list');
    const searchInput = document.getElementById('notice-search');
    const sourceSelect = document.getElementById('notice-source');
    const timelineSelect = document.getElementById('notice-timeline');
    const deptSelect = document.getElementById('notice-dept');
    const sortSelect = document.getElementById('notice-sort');
    const resetBtn = document.getElementById('reset-filters');
    const authUnlogged = document.getElementById('auth-unlogged');
    const authLogged = document.getElementById('auth-logged');
    const loggedUsername = document.getElementById('logged-username');
    const tabPrivate = document.getElementById('tab-private');

    function updateAuthUI() {
        const token = localStorage.getItem('portal_access_token');
        const user = localStorage.getItem('portal_user');
        if (token) {
            authUnlogged.classList.add('d-none');
            authLogged.classList.remove('d-none');
            tabPrivate.classList.remove('d-none');
            loggedUsername.textContent = user;
        } else {
            authUnlogged.classList.remove('d-none');
            authLogged.classList.add('d-none');
            tabPrivate.classList.add('d-none');
        }
    }

    async function fetchNotices() {
        const token = localStorage.getItem('portal_access_token');
        const headers = token ? {
            'Authorization': `Bearer ${token}`
        } : {};

        try {
            const [gRes, dRes] = await Promise.all([
                fetch(`${apiBase}/global-notices/?page_size=500`, {
                    headers
                }),
                fetch(`${apiBase}/notices/?page_size=500`, {
                    headers
                })
            ]);

            const gData = await gRes.json();
            const dData = await dRes.json();

            const g = (gData.results || []).map(n => ({
                ...n,
                source: 'global',
                sourceLabel: 'University Wide',
                cat: n.categories?. [0] || 'General',
                date: new Date(n.date_posted)
            }));
            const d = (dData.results || []).map(n => ({
                ...n,
                source: 'dept',
                sourceLabel: n.department_name || 'Departmental',
                cat: n.category || 'General',
                date: new Date(n.date_posted)
            }));

            allNotices = [...g, ...d];
            populateDeptFilter();
            render();
        } catch (e) {
            listContainer.innerHTML = '<p>Connection Error.</p>';
        }
    }

    function populateDeptFilter() {
        const depts = [...new Set(allNotices.filter(n => n.source === 'dept').map(n => n.sourceLabel))].sort();
        deptSelect.innerHTML = '<option value="all">All Departments</option>' +
            depts.map(d => `<option value="${d}">${d}</option>`).join('');
    }

    function render() {
        const search = searchInput.value.toLowerCase();
        const sourceVal = sourceSelect.value;
        const timelineVal = timelineSelect.value;
        const deptVal = deptSelect.value;
        const sortVal = sortSelect.value;

        let filtered = allNotices.filter(n => {
            const matchesSearch = n.title.toLowerCase().includes(search);
            const matchesCat = !currentCat || n.cat === currentCat;
            const matchesSource = sourceVal === 'all' || n.source === sourceVal;
            const matchesDept = deptVal === 'all' || n.sourceLabel === deptVal;
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

            return matchesSearch && matchesCat && matchesSource && matchesDept && matchesTab &&
                matchesTimeline;
        });

        // Sorting
        filtered.sort((a, b) => {
            return sortVal === 'asc' ? a.date - b.date : b.date - a.date;
        });

        document.getElementById('result-count').textContent = filtered.length;

        if (filtered.length === 0) {
            listContainer.innerHTML = '<p class="py-5 text-center">No announcements found.</p>';
            return;
        }

        listContainer.innerHTML = filtered.map(n => `
            <a href="${n.attachment || n.link || '#'}" target="_blank" class="sc-notice-card ${n.is_private ? 'is-private' : ''}">
                <div class="sc-notice-icon">
                    <i class="fa-solid ${n.is_private ? 'fa-lock-open' : 'fa-bullhorn'}"></i>
                </div>
                <div class="sc-notice-info">
                    <h3>${n.title}</h3>
                    <div class="sc-notice-meta">
                        ${n.cat} &bull; ${n.sourceLabel} &bull; ${n.date.toLocaleDateString('en-GB')}
                    </div>
                </div>
            </a>
        `).join('');
    }

    // Auth Actions
    document.getElementById('staff-login-form').addEventListener('submit', async (e) => {
        e.preventDefault();
        const data = Object.fromEntries(new FormData(e.target).entries());
        try {
            const res = await fetch(`${apiBase}/token/`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            });
            const resData = await res.json();
            if (res.ok) {
                localStorage.setItem('portal_access_token', resData.access);
                localStorage.setItem('portal_user', data.username);
                toggleModal('login-modal', false);
                updateAuthUI();
                fetchNotices();
            } else {
                alert("Login failed.");
            }
        } catch (i) {
            alert("Network Error.");
        }
    });

    document.getElementById('btn-logout').addEventListener('click', () => {
        localStorage.clear();
        updateAuthUI();
        fetchNotices();
    });

    // Event Listeners for Filters
    [searchInput, sourceSelect, timelineSelect, deptSelect, sortSelect].forEach(el => {
        el.addEventListener('change', render);
        if (el === searchInput) el.addEventListener('input', render);
    });

    document.querySelectorAll('.sc-cat-item').forEach(li => {
        li.addEventListener('click', (e) => {
            e.preventDefault();
            document.querySelectorAll('.sc-cat-item').forEach(l => l.classList.remove(
            'active'));
            li.classList.add('active');
            currentCat = li.dataset.cat;
            render();
        });
    });

    tabPrivate.addEventListener('click', () => {
        currentTab = currentTab === 'all' ? 'private' : 'all';
        tabPrivate.classList.toggle('btn-success', currentTab === 'private');
        render();
    });

    resetBtn.addEventListener('click', () => {
        searchInput.value = '';
        sourceSelect.value = 'all';
        timelineSelect.value = 'all';
        deptSelect.value = 'all';
        sortSelect.value = 'desc';
        currentCat = '';
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