<style>
/* PREMIUM RESEARCH DESIGN SYSTEM */
:root {
    --rd-indigo: #1e1b4b;
    --rd-royal: #1e3a8a;
    --rd-gold: #c9a84c;
    --rd-slate: #f8fafc;
    --rd-emerald: #059669;
    --rd-crimson: #be123c;
    --shadow-premium: 0 20px 50px rgba(30, 27, 75, 0.05);
}

.research-portal {
    background: #fafafa !important;
    font-family: 'Inter', system-ui, sans-serif;
}

/* PREMIUM HERO BANNER */
.premium-hero-rd1 {
    position: relative;
    display: flex;
    align-items: center;
    overflow: hidden;
    background: var(--rd-indigo) url('/wp-content/uploads/2026/04/rd-cell-image.png') center/cover no-repeat;
    min-height: 310px;
    padding: 40px 0;
    color: white;
}

.premium-hero-rd1 .hero-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    /* background: linear-gradient(135deg, rgba(30, 27, 75, 0.95) 0%, rgba(30, 58, 138, 0.8) 100%); */
    background: linear-gradient(135deg, rgba(30, 27, 75, 0.95), rgb(85 99 138 / 70%));
    z-index: 1;
}

.hero-content-glass1 {
    position: relative;
    z-index: 2;
    background: rgba(255, 255, 255, 0.05);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.1);
    padding: 40px;
    border-radius: 24px;
    max-width: 800px;
}

.badge-new-rd1 {
    display: inline-block;
    background: var(--rd-gold);
    color: var(--rd-indigo);
    padding: 6px 16px;
    border-radius: 30px;
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 20px;
}

.hero-content-glass1 h1 {
    font-weight: 800 !important;
    margin-bottom: 15px;
    color: white;
    letter-spacing: -0.03em;
}

.hero-content-glass1 p {
    font-size: 1.1rem;
    opacity: 0.9;
    line-height: 1.6;
    margin: 0;
}

/* GLASS FILTERS */
.ra-glass-filters {
    background: white;
    padding: 25px;
    border-radius: 20px;
    box-shadow: var(--shadow-premium);
    border: 1px solid #f1f5f9;
    display: flex;
    gap: 20px;
    align-items: center;
    flex-wrap: wrap;
    margin-top: -40px;
    position: relative;
    z-index: 10;
}

.ra-search-box {
    flex: 2;
    min-width: 300px;
    position: relative;
}

.ra-search-icon {
    position: absolute;
    left: 20px;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
}

.ra-search-box input {
    width: 100%;
    padding: 14px 20px 14px 50px;
    border-radius: 12px;
    border: 2px solid #f1f5f9;
    background: #f8fafc;
    font-size: 1rem;
    transition: all 0.3s;
}

.ra-search-box input:focus {
    border-color: var(--rd-royal);
    background: white;
    outline: none;
    box-shadow: 0 0 0 4px rgba(30, 58, 138, 0.05);
}

.ra-filter-group {
    display: flex;
    gap: 15px;
    flex: 3;
    flex-wrap: wrap;
}

.filter-item {
    display: flex;
    flex-direction: column;
    gap: 5px;
    flex: 1;
    min-width: 150px;
}

.filter-item label {
    font-size: 0.7rem;
    font-weight: 700;
    text-transform: uppercase;
    color: #64748b;
    letter-spacing: 0.5px;
}

.ra-select {
    padding: 10px 15px !important;
    border-radius: 10px !important;
    border: 2px solid #f1f5f9 !important;
    background: #f8fafc;
    font-weight: 600;
    color: #334155 !important;
    cursor: pointer;
    font-size: 0.9rem;
    height: 48px;
    transition: all 0.3s;
}

.ra-select:focus {
    border-color: var(--rd-royal);
    background: white;
    outline: none;
    box-shadow: 0 0 0 4px rgba(30, 58, 138, 0.05);
}

input[type="date"].ra-select {
    font-family: inherit;
}

input[type="date"].ra-select::-webkit-calendar-picker-indicator {
    cursor: pointer;
    filter: invert(0.4);
}

/* PREMIUM TABLE & CARDS */
.rd-card-premium {
    background: white;
    border-radius: 24px;
    padding: 35px;
    box-shadow: var(--shadow-premium);
    border: 1px solid #f1f5f9;
}

.rd-section-title {
    font-size: 1.4rem;
    font-weight: 700;
    color: var(--rd-indigo);
    margin-bottom: 30px;
    position: relative;
    padding-left: 20px;
}

.rd-section-title::after {
    background: none !important;
}

.rd-section-title::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 6px;
    background: var(--rd-gold);
    border-radius: 10px;
}

.premium-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0 8px;
}

.premium-table th {
    padding: 15px 20px;
    background: #f8fafc;
    color: #64748b;
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    border: none;
}

.premium-table td {
    padding: 20px;
    background: white;
    border-top: 1px solid #f1f5f9;
    border-bottom: 1px solid #f1f5f9;
    color: #334155;
    font-size: 0.95rem;
}

.premium-table td:first-child {
    border-left: 1px solid #f1f5f9;
    border-radius: 12px 0 0 12px;
}

.premium-table td:last-child {
    border-right: 1px solid #f1f5f9;
    border-radius: 0 12px 12px 0;
}

.premium-table tr:hover td {
    background: #fdfdfd;
    border-color: var(--rd-gold);
}

/* BUTTONS */
.btn-rd-profile {
    background: var(--rd-indigo);
    color: white !important;
    padding: 10px 20px;
    border-radius: 10px;
    text-decoration: none !important;
    font-weight: 700;
    font-size: 0.85rem;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all 0.3s;
    border: none;
    cursor: pointer;
}

.btn-rd-profile:hover {
    background: var(--rd-royal);
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(30, 58, 138, 0.2);
}

/* ANIMATIONS */
.animate-up {
    animation: rdUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    opacity: 0;
}

@keyframes rdUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* LOADER */
.rd-loader {
    width: 50px;
    height: 50px;
    border: 4px solid #f1f5f9;
    border-top-color: var(--rd-royal);
    border-radius: 50%;
    display: inline-block;
    animation: rdSpin 1s linear infinite;
}

@keyframes rdSpin {
    to {
        transform: rotate(360deg);
    }
}

/* PAGINATION */
.pagination-wrapper {
    display: flex;
    justify-content: center;
    gap: 15px;
    margin-top: 40px;
}

@media (max-width: 768px) {
    .premium-hero-rd {
        padding: 40px 0;
        min-height: 250px;
    }

    .hero-content-glass {
        padding: 25px;
        border-radius: 0;
    }

    .hero-content-glass h1 {
        font-size: 2rem !important;
    }

    .ra-glass-filters {
        margin-top: 0;
        border-radius: 0;
        padding: 15px;
        flex-direction: column;
        align-items: stretch;
    }

    .ra-search-box {
        min-width: 100%;
    }

    .ra-filter-group {
        flex-direction: column;
    }

    .rd-card-premium {
        padding: 20px;
        border-radius: 0;
    }

    /* PREMIUM TABLE MOBILE */
    .premium-table thead {
        display: none;
    }

    .premium-table tr {
        display: block;
        margin-bottom: 20px;
        background: #fff;
        border: 1px solid #f1f5f9;
        border-radius: 16px;
        overflow: hidden;
    }

    .premium-table td {
        display: block;
        text-align: left;
        padding: 12px 20px;
        border: none;
        border-bottom: 1px solid #f8fafc;
        width: 100% !important;
    }

    .premium-table td:last-child {
        border-bottom: none;
        background: #f8fafc;
        text-align: center;
    }

    .premium-table td::before {
        content: attr(data-label);
        display: block;
        font-size: 0.7rem;
        font-weight: 700;
        color: #94a3b8;
        text-transform: uppercase;
        margin-bottom: 4px;
    }
}
</style>