<style>
.research-portal {
    background: #f8fafc;
    font-family: 'Inter', sans-serif;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

/* HERO SECTION */
.research-hero {
    background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
    color: white;
    padding: 80px 0;
    text-align: center;
    position: relative;
    overflow: hidden;
}

.research-hero h1 {
    font-size: 3.5rem;
    font-weight: 800;
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

/* DATA CONTAINERS */
.research-container {
    padding: 60px 0;
}

.portal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 40px;
    flex-wrap: wrap;
    gap: 20px;
}

.section-title {
    font-size: 2.25rem;
    font-weight: 700;
    color: #0f172a;
    border-left: 6px solid #fbbf24;
    padding-left: 20px;
}

.filter-controls {
    display: flex;
    align-items: center;
    gap: 15px;
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
    margin-bottom: 60px;
    background: white;
    padding: 30px;
    border-radius: 20px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
}

.data-section h3 {
    font-size: 1.5rem;
    margin-bottom: 25px;
    color: #1e293b;
    font-weight: 700;
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

.status-badge.ongoing { background: #dbeafe; color: #1e40af; }
.status-badge.completed { background: #dcfce7; color: #15803d; }
.status-badge.awarded { background: #fef9c3; color: #854d0e; }
.status-badge.pursuing { background: #f1f5f9; color: #475569; }

@media (max-width: 768px) {
    .research-hero h1 { font-size: 2.5rem; }
    .portal-header { flex-direction: column; align-items: flex-start; }
    .nav-card { padding: 20px; }
}
</style>
