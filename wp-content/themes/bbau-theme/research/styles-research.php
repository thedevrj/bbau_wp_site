<style>
:root {
    --research-primary: #1e3a8a;
    --research-accent: #b45309;
    --research-bg: #f8fafc;
    --glass-bg: rgba(255, 255, 255, 0.95);
    --glass-border: rgba(255, 255, 255, 0.3);
    --shadow-soft: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
}

.research-portal {
    background: var(--research-bg);
    font-family: 'Inter', sans-serif;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

/* HERO SECTION */
.research-hero {
    background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
    color: white;
    padding: 80px 0 50px;
    text-align: center;
    position: relative;
    overflow: hidden;
}

.research-hero h1 {
    font-size: 2.5rem;
    font-weight: 800 !important;
    margin-bottom: 20px;
    letter-spacing: -0.02em;
}

.research-hero p {
    font-size: 1.25rem;
    opacity: 0.9;
    max-width: 700px;
    margin: 0 auto 50px;
}

/* NAVIGATION CARDS */
.research-nav {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    margin-top: 40px;
}

.nav-card {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    padding: 30px 20px;
    border-radius: 16px;
    color: white !important;
    text-decoration: none;
    transition: all 0.3s ease;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 15px;
}

.nav-card i {
    font-size: 2rem;
    color: #fbbf24;
}

.nav-card span {
    font-weight: 600;
    font-size: 1.1rem;
}

.nav-card:hover {
    background: rgba(255, 255, 255, 0.2);
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
}

/* PORTAL SEARCH HUB */
.research-container {
    padding: 60px 0;
}

.portal-header {
    background: var(--glass-bg);
    backdrop-filter: blur(12px);
    border: 1px solid var(--glass-border);
    border-radius: 20px;
    padding: 23px;
    box-shadow: var(--shadow-soft);
    position: relative;
    z-index: 10;
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 40px;
    flex-wrap: wrap;
    gap: 20px;
}

.search-filter-wrapper {
    display: flex;
    gap: 20px;
    margin-top: 30px;
    flex-wrap: wrap;
}

.search-box1 {
    flex: 1;
    position: relative;
    min-width: 300px;
}

.search-icon1 {
    position: absolute;
    left: 20px;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
}

.search-box1 input {
    width: 100%;
    padding: 15px 15px 15px 50px;
    border-radius: 12px;
    border: 2px solid #e2e8f0;
    font-size: 1rem;
    transition: all 0.3s ease;
}

.search-box1 input:focus {
    border-color: var(--research-primary);
    box-shadow: 0 0 0 4px rgba(30, 58, 138, 0.1);
    outline: none;
}

.count-pill {
    background: var(--research-primary);
    color: white;
    padding: 4px 12px;
    border-radius: 30px;
    font-size: 0.8rem;
    font-weight: 700;
    margin-left: 10px;
}

.section-title {
    font-weight: 700 !important;
    color: #0f172a;
    border-left: 6px solid #fbbf24;
    padding-left: 20px;
}

.section-title::after {
    background: none !important;
}

.custom-select {
    padding: 12px 25px;
    border-radius: 30px;
    border: 1px solid #e2e8f0;
    font-weight: 600;
    color: #475569;
    background: white;
    cursor: pointer;
}

/* TABLES */
.data-section {
    margin-bottom: 50px;
    background: white;
    padding: 30px;
    border-radius: 20px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
}

.data-section h3 {
    margin-bottom: 25px;
    font-weight: 700;
    color: #0f172a;
    border-bottom: 2px solid #f1f5f9;
    padding-bottom: 15px;
}

.table-container {
    overflow-x: auto;
}

.data-table {
    width: 100%;
    border-collapse: collapse;
    min-width: 800px;
}

.data-table th {
    text-align: left;
    padding: 15px;
    background: #f8fafc;
    color: #64748b;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.75rem;
    letter-spacing: 0.05em;
    border-bottom: 2px solid #f1f5f9;
}

.data-table td {
    padding: 20px 15px;
    border-bottom: 1px solid #f1f5f9;
    vertical-align: top;
    color: #334155;
}

.data-table tr:hover {
    background-color: #f8fafc;
}

.project-row[data-dept] {
    /* Placeholder for PHP logic: <tr class="project-row" data-dept="<?php echo esc_attr($proj['department_slug'] ?? ''); ?>" data-search-text="<?php echo esc_attr(strtolower($proj['title'] . ' ' . $proj['pi_name'] . ' ' . $proj['funding_agency'])); ?>"> */
}

.bold-cell {
    font-weight: 700;
    color: #1e3a8a;
}

.italic-cell {
    font-style: italic;
    font-size: 0.95rem;
}

.sub-text {
    font-size: 0.8rem;
    color: #64748b;
    margin-top: 5px;
}

.amount {
    font-weight: 600;
    color: #b91c1c;
}

/* BADGES */
.status-badge {
    padding: 6px 14px;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
}

.status-badge.ongoing {
    background: #dbeafe;
    color: #1e40af;
}

.status-badge.completed {
    background: #dcfce7;
    color: #15803d;
}

.status-badge.awarded {
    background: #fef9c3;
    color: #854d0e;
}

.status-badge.pursuing {
    background: #f1f5f9;
    color: #475569;
}

/* CARDS & GRIDS (Dynamic) */
.patents-grid-mini {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 20px;
}

.patent-card-mini {
    background: white;
    padding: 25px;
    border-radius: 16px;
    border-left: 5px solid var(--research-accent);
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    animation: fadeInUp 0.5s ease forwards;
}

.pub-card-mini {
    background: white;
    padding: 20px;
    border-radius: 12px;
    margin-bottom: 15px;
    border: 1px solid #e2e8f0;
    position: relative;
    animation: fadeInUp 0.5s ease forwards;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@media (max-width: 768px) {
    .research-hero h1 {
        font-size: 2.5rem;
    }

    .portal-header {
        flex-direction: column;
        align-items: flex-start;
    }

    .nav-card {
        padding: 20px;
    }
}
</style>