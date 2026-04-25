<?php
/**
 * Template Name: Research Areas
 */

get_header();

$api_base = getenv('DJANGO_MEDIA_URL');
?>

<main id="primary" class="site-main research-portal">
    <!-- PREMIUM HERO BANNER -->
    <section class="premium-hero-rd1">
        <div class="hero-overlay"></div>
        <div class="container">
            <div class="hero-content-glass1 animate-up">
                <div class="badge-new-rd1">Academic Domains</div>
                <h1 style="font-size: 3rem;">Research Areas</h1>
                <p>Exploring the frontiers of knowledge through specialized research domains across science, humanities, and technology.</p>
            </div>
        </div>
    </section>

    <div class="research-container container">
        <?php get_template_part('template-parts/breadcrumb');?>
        
        <!-- ENHANCED FILTER BAR (Glassmorphism) -->
        <div class="ra-glass-filters mb-5">
            <div class="ra-search-box">
                <i class="fas fa-search ra-search-icon"></i>
                <input type="text" id="area-search" placeholder="Search by area, keyword or specialization..." autocomplete="off">
            </div>
            
            <div class="ra-filter-group">
                <div class="filter-item">
                    <select id="dept-filter" class="ra-select">
                        <option value="">All Departments</option>
                        <!-- Options populated via JS -->
                    </select>
                </div>
            </div>
        </div>

        <!-- RESEARCH AREAS GRID -->
        <div id="loading-spinner" class="text-center py-5">
            <div class="rd-loader"></div>
            <p class="mt-3 text-muted">Curating research excellence...</p>
        </div>

        <div id="no-results" class="text-center py-5" style="display: none;">
            <div class="empty-state">
                <i class="fas fa-search-minus fa-3x mb-3" style="opacity: 0.2;"></i>
                <p>No research areas found matching your criteria.</p>
                <button onclick="location.reload()" class="btn-rd-profile" style="width: auto; padding: 10px 25px;">Reset Filters</button>
            </div>
        </div>

        <div class="areas-grid" id="areas-container">
            <!-- Dynamic Cards Go Here -->
        </div>

        <!-- PAGINATION CONTROLS -->
        <div id="pagination-controls" class="pagination-wrapper p-3 border-top d-flex justify-content-center gap-3 mt-5">
        </div>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    
    // --- DYNAMICALLY LOAD FILTERS VIA JS ---
    async function loadDynamicFilters() {
        try {
            const apiBase = "<?php echo esc_js($api_base); ?>";
            const deptFilter = document.getElementById('dept-filter');

            if (deptFilter) {
                const dRes = await fetch(`${apiBase}/api/v1/departments/?page_size=500`);
                if (dRes.ok) {
                    const depts = await dRes.json();
                    const dData = depts.results || depts;
                    dData.forEach(d => {
                        deptFilter.innerHTML += `<option value="${d.slug}">${d.name}</option>`;
                    });
                }
            }
        } catch(e) { console.error("Filter Load Error:", e); }
    }
    loadDynamicFilters();
    
    const searchInput = document.getElementById('area-search');
    const deptFilter = document.getElementById('dept-filter');
    const container = document.getElementById('areas-container');
    const loading = document.getElementById('loading-spinner');
    const noResults = document.getElementById('no-results');
    const paginationControls = document.getElementById('pagination-controls');
    const apiBase = "<?php echo esc_js($api_base); ?>";
    
    let debounceTimer;
    let nextUrl = null;
    let prevUrl = null;

    function fetchAreas(url = `${apiBase}/api/v1/research-areas/?page_size=12`) {
        const query = searchInput.value.toLowerCase().trim();
        const dept = deptFilter.value;
        
        let fetchUrl = url;
        if (query && !url.includes('search=')) {
            fetchUrl += `&search=${encodeURIComponent(query)}`;
        }
        if (dept && !url.includes('department__slug=')) {
            fetchUrl += `&department__slug=${encodeURIComponent(dept)}`;
        }

        container.style.display = 'none';
        noResults.style.display = 'none';
        loading.style.display = 'block';
        paginationControls.style.display = 'none';

        fetch(fetchUrl)
            .then(res => res.json())
            .then(data => {
                const areas = data.results || data;
                nextUrl = data.next;
                prevUrl = data.previous;
                renderAreas(areas);
                renderPagination();
            })
            .catch(err => {
                loading.style.display = 'none';
                noResults.style.display = 'block';
            });
    }

    function renderAreas(areas) {
        loading.style.display = 'none';

        if (areas.length === 0) {
            noResults.style.display = 'block';
            return;
        }

        container.style.display = 'grid';

        const html = areas.map((area) => {
            const desc = area.description && area.description.trim() ? area.description : 'Explore specialized research opportunities in this domain.';
            const isLong = desc.length > 220;
            const shortDesc = isLong ? desc.substring(0, 200) + '...' : desc;
            
            const deptName = area.department_name || 'Generic';
            return `
                <div class="ra-modern-card animate-up">
                    <div class="ra-card-inner">
                        <div class="ra-header">
                            <span class="ra-badge">${deptName}</span>
                            <div class="ra-icon-ring"><i class="fas fa-atom"></i></div>
                        </div>
                        <h3 class="ra-title">${area.available_research_areas_or_Specialization}</h3>
                        <div class="ra-body">
                            <div class="ra-desc-wrap">
                                <div class="ra-desc-short">${shortDesc}</div>
                                ${isLong ? `<div class="ra-desc-full" style="display:none;">${desc}</div>` : ''}
                            </div>
                            ${isLong ? `<button class="ra-toggle-btn">Read More <i class="fas fa-chevron-down"></i></button>` : ''}
                        </div>
                    </div>  
                </div>
            `;
        }).join('');
        
        container.innerHTML = html;

        // Add Toggle Listeners
        document.querySelectorAll('.ra-toggle-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const wrap = this.previousElementSibling;
                const short = wrap.querySelector('.ra-desc-short');
                const full = wrap.querySelector('.ra-desc-full');
                const isExpanded = full.style.display === 'block';

                if (isExpanded) {
                    full.style.display = 'none';
                    short.style.display = 'block';
                    this.innerHTML = 'Read More <i class="fas fa-chevron-down"></i>';
                } else {
                    full.style.display = 'block';
                    short.style.display = 'none';
                    this.innerHTML = 'Show Less <i class="fas fa-chevron-up"></i>';
                }
            });
        });
    }

    function renderPagination() {
        paginationControls.innerHTML = '';
        if (!nextUrl && !prevUrl) return;

        paginationControls.style.display = 'flex';

        if (prevUrl) {
            const prevBtn = document.createElement('button');
            prevBtn.innerHTML = '<i class="fas fa-chevron-left"></i> Previous';
            prevBtn.className = 'btn-rd-profile';
            prevBtn.style.width = 'auto';
            prevBtn.onclick = () => fetchAreas(prevUrl);
            paginationControls.appendChild(prevBtn);
        }

        if (nextUrl) {
            const nextBtn = document.createElement('button');
            nextBtn.innerHTML = 'Next <i class="fas fa-chevron-right"></i>';
            nextBtn.className = 'btn-rd-profile';
            nextBtn.style.width = 'auto';
            nextBtn.onclick = () => fetchAreas(nextUrl);
            paginationControls.appendChild(nextBtn);
        }
    }

    searchInput.addEventListener('input', () => {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => fetchAreas(), 400);
    });
    
    deptFilter.addEventListener('change', () => fetchAreas());
    fetchAreas();
});
</script>

<?php include_once(get_template_directory() . '/research/styles-research.php'); ?>
<style>
/* MODERN RESEARCH AREA STYLES */
:root {
    --rd-indigo: #1e1b4b;
    --rd-royal: #1e3a8a;
    --rd-gold: #c9a84c;
    --rd-slate: #f8fafc;
}

/* FILTERS */
.ra-glass-filters {
    background: white;
    padding: 25px;
    border-radius: 20px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.03);
    border: 1px solid #f1f5f9;
    display: flex;
    gap: 20px;
    align-items: center;
    flex-wrap: wrap;
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
    flex: 1;
    min-width: 250px;
}

.filter-item {
    display: flex;
    flex-direction: column;
    gap: 5px;
}

.filter-item label {
    font-size: 0.75rem;
    font-weight: 800;
    text-transform: uppercase;
    color: #64748b;
    letter-spacing: 0.5px;
}

.ra-select {
    padding: 12px;
    border-radius: 10px;
    border: 2px solid #f1f5f9;
    background: #f8fafc;
    font-weight: 600;
    color: #334155;
    cursor: pointer;
}

/* CARDS GRID */
.areas-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 30px;
    margin-bottom: 80px;
}

.ra-modern-card {
    background: white;
    border-radius: 24px;
    display: flex;
    flex-direction: column;
    border: 1px solid #f1f5f9;
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    overflow: hidden;
    height: 100%;
}

.ra-modern-card:hover {
    transform: translateY(-12px);
    box-shadow: 0 30px 60px rgba(30, 27, 75, 0.08);
    border-color: var(--rd-gold);
}

.ra-card-inner {
    padding: 30px;
    flex-grow: 1;
}

.ra-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 20px;
}

.ra-badge {
    background: #f1f5f9;
    color: #475569;
    font-size: 0.7rem;
    font-weight: 800;
    padding: 5px 12px;
    border-radius: 30px;
    text-transform: uppercase;
}

.ra-icon-ring {
    width: 45px;
    height: 45px;
    background: #f8fafc;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--rd-royal);
    font-size: 1.2rem;
    transition: all 0.3s;
}

.ra-modern-card:hover .ra-icon-ring {
    background: var(--rd-royal);
    color: white;
    transform: rotate(10deg);
}

.ra-title {
    font-size: 1.4rem;
    font-weight: 800;
    color: var(--rd-indigo);
    line-height: 1.3;
    margin-bottom: 15px;
}

.ra-body {
    position: relative;
}

.ra-desc-wrap {
    color: #64748b;
    line-height: 1.7;
    font-size: 0.95rem;
}

.ra-toggle-btn {
    background: none;
    border: none;
    padding: 0;
    margin-top: 15px;
    color: var(--rd-royal);
    font-weight: 700;
    font-size: 0.85rem;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 5px;
    transition: color 0.2s;
}

.ra-toggle-btn:hover {
    color: var(--rd-gold);
}

.ra-explore-link {
    text-decoration: none !important;
    font-size: 0.85rem;
    font-weight: 700;
    color: #64748b;
    display: flex;
    align-items: center;
    gap: 8px;
    transition: all 0.2s;
}

.ra-explore-link:hover {
    color: var(--rd-royal);
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
    to { transform: rotate(360deg); }
}

@media (max-width: 768px) {
    .ra-glass-filters { flex-direction: column; align-items: stretch; }
    .ra-search-box { min-width: 100%; }
    .areas-grid { grid-template-columns: 1fr; }
}
</style>

<?php get_footer(); ?>
