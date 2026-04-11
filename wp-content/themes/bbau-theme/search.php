<?php
/**
 * The template for displaying search results pages
 * Enhanced to also search the Django API for Faculty, Programs, and Notices.
 *
 * @package BBAU_Theme
 */

get_header();

$search_query = get_search_query(); // This reads the ?s= parameter
$api_base   = getenv('DJANGO_API_URL');
$media_base = getenv('DJANGO_MEDIA_URL');
?>

<main id="primary" class="site-main search-results-page" style="background:#fdfaf6; min-height:80vh;">

    <div class="search-hero py-5" style="background: linear-gradient(135deg, #5c1010, #8B1A1A); color: #fff;">
        <div class="container text-center">
            
            <form role="search" method="get" action="<?php echo home_url('/'); ?>"
                class="mt-3 d-flex justify-content-center gap-2">
                <input type="text" name="s" value="<?php echo esc_attr($search_query); ?>"
                    placeholder="Search faculty, programmes, notices..."
                    style="padding:10px 20px; border-radius:30px; border:none; min-width:320px; outline:none; font-size:1rem;">
                <button type="submit"
                    style="padding:10px 25px; border-radius:30px; background:#c9a84c; color:#5c1010; border:none; font-weight:800; cursor:pointer;">Search</button>
            </form>
        </div>
    </div>

    <?php if ($search_query): ?>
    <div class="container py-5">

        <!-- Category Tabs -->
        <!-- Tab bar — filled dynamically by JS after results are ready -->
        <div class="search-tabs d-flex flex-wrap justify-content-center gap-2 mb-5" id="search-tab-bar" style="display:none !important;">
        </div>

        <!-- Loading Indicator -->
        <div id="search-loading" class="text-center py-5">
            <div
                style="width:50px; height:50px; border:4px solid #e2d9cc; border-top-color:#8B1A1A; border-radius:50%; animation:spin 0.8s linear infinite; margin:auto;">
            </div>
            <p class="mt-3" style="color:#888;">Searching across the university…</p>
        </div>

        <!-- Results Wrapper -->
        <div id="results-wrap" style="display:none;">

            <!-- WORDPRESS PAGES -->
            <?php
            $wp_search = new WP_Query(array(
                's'              => $search_query,
                'post_type'      => array('page', 'post'),
                'posts_per_page' => 10,
                'post_status'    => 'publish',
            ));
            ?>
            <section id="sec-pages" class="result-section mb-5"
                <?php if (!$wp_search->have_posts()) echo 'style="display:none;"'; ?>>
                <h3 class="sec-title"><i class="fa-solid fa-file-lines"></i> University Pages</h3>
                <div class="row g-4">
                    <?php while ($wp_search->have_posts()): $wp_search->the_post(); ?>
                    <div class="col-md-6">
                        <a href="<?php the_permalink(); ?>" class="search-card">
                            <span class="card-label"><?php echo esc_html(get_post_type() === 'page' ? 'Page' : 'Post'); ?></span>
                            <h4 class="card-title"><?php the_title(); ?></h4>
                            <p class="card-meta"><?php echo wp_trim_words(get_the_excerpt(), 15, '…'); ?></p>
                        </a>
                    </div>
                    <?php endwhile; wp_reset_postdata(); ?>
                </div>
            </section>

            <!-- PROGRAMMES -->
            <section id="sec-programs" class="result-section mb-5">
                <h3 class="sec-title"><i class="fa-solid fa-graduation-cap"></i> Academic Programmes</h3>
                <div class="row g-4" id="list-programs"></div>
            </section>

            <!-- FACULTY -->
            <section id="sec-people" class="result-section mb-5">
                <h3 class="sec-title"><i class="fa-solid fa-user-tie"></i> Faculty & Staff</h3>
                <div class="row g-4" id="list-people"></div>
            </section>

            <!-- NOTICES -->
            <section id="sec-notices" class="result-section mb-5">
                <h3 class="sec-title"><i class="fa-solid fa-bullhorn"></i> Notifications</h3>
                <div class="row g-4" id="list-notices"></div>
            </section>

            <!-- COURSES -->
            <section id="sec-courses" class="result-section mb-5">
                <h3 class="sec-title"><i class="fa-solid fa-book"></i> Courses</h3>
                <div class="row g-4" id="list-courses"></div>
            </section>

            <!-- CBCS COURSES -->
            <section id="sec-cbcs" class="result-section mb-5">
                <h3 class="sec-title"><i class="fa-solid fa-book-open"></i> CBCS / Open Electives</h3>
                <div class="row g-4" id="list-cbcs"></div>
            </section>

            <!-- RESEARCH PROJECTS -->
            <section id="sec-research" class="result-section mb-5">
                <h3 class="sec-title"><i class="fa-solid fa-flask"></i> Research Projects</h3>
                <div class="row g-4" id="list-research"></div>
            </section>

            <!-- RESEARCH SCHOLARS -->
            <section id="sec-scholars" class="result-section mb-5">
                <h3 class="sec-title"><i class="fa-solid fa-user-graduate"></i> Research Scholars</h3>
                <div class="row g-4" id="list-scholars"></div>
            </section>

            <!-- TIMETABLES -->
            <section id="sec-timetable" class="result-section mb-5">
                <h3 class="sec-title"><i class="fa-solid fa-calendar-days"></i> Timetables</h3>
                <div class="row g-4" id="list-timetable"></div>
            </section>

            <!-- STUDY MATERIALS -->
            <section id="sec-materials" class="result-section mb-5">
                <h3 class="sec-title"><i class="fa-solid fa-folder-open"></i> Study Materials</h3>
                <div class="row g-4" id="list-materials"></div>
            </section>

            <div id="no-results" class="text-center py-5" style="display:none;">
                <i class="fa-solid fa-magnifying-glass" style="font-size:4rem; color:#e2d9cc;"></i>
                <h3 class="mt-4" style="color:#888;">No matches found for "<?php echo esc_html($search_query); ?>"</h3>
                <p style="color:#aaa;">Try a more general term, or contact the university directly. <br>Thank you !</p>
            </div>
        </div>
    </div>
    <?php else: ?>
    <div class="container py-5 text-center">
        <i class="fa-solid fa-magnifying-glass" style="font-size:4rem; color:#e2d9cc;"></i>
        <h3 class="mt-4" style="color:#888;">Enter your query in the search box</h3>
    </div>
    <?php endif; ?>

</main>

<style>
@keyframes spin {
    to {
        transform: rotate(360deg);
    }
}

.search-tabs .s-tab {
    padding: 10px 22px;
    border: 1.5px solid #e2d9cc;
    background: #fff;
    border-radius: 30px;
    font-weight: 700;
    font-size: 0.85rem;
    color: #5c1010;
    cursor: pointer;
    transition: 0.25s;
    display: flex;
    align-items: center;
    gap: 8px;
}

.search-tabs .s-tab.active,
.search-tabs .s-tab:hover {
    background: #8B1A1A;
    color: #fff;
    border-color: #8B1A1A;
    box-shadow: 0 4px 15px rgba(139, 26, 26, 0.2);
}

.sec-title {
    font-family: 'Merriweather', serif;
    font-weight: 800;
    color: #5c1010;
    margin-bottom: 25px;
    padding-bottom: 12px;
    border-bottom: 2px solid #e2d9cc;
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 1.2rem;
}

.search-card {
    background: #fff;
    border: 1px solid #e2d9cc;
    border-radius: 14px;
    padding: 20px;
    height: 100%;
    transition: 0.3s;
    text-decoration: none;
    color: inherit;
    display: block;
}

.search-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 30px rgba(139, 26, 26, 0.08);
    border-color: #c9a84c;
    color: inherit;
}

.card-label {
    font-size: 0.68rem;
    font-weight: 800;
    color: #8B1A1A;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    display: block;
    margin-bottom: 8px;
}

.card-title {
    font-size: 1rem;
    font-weight: 700;
    color: #111;
    margin: 0 0 6px;
}

.card-meta {
    font-size: 0.82rem;
    color: #777;
    margin: 0;
}

.faculty-photo-mini {
    width: 55px;
    height: 55px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #e2d9cc;
    margin-bottom: 12px;
}
</style>

<script>
const apiBase = "<?php echo esc_js($api_base); ?>";
const mediaBase = "<?php echo esc_js($media_base); ?>";
const query = "<?php echo esc_js($search_query); ?>";

// Map of category id => { label, icon }
const TAB_META = {
    pages:     { label: 'Pages',          icon: 'fa-file-lines' },
    programs:  { label: 'Programmes',     icon: 'fa-graduation-cap' },
    courses:   { label: 'Courses',        icon: 'fa-book' },
    cbcs:      { label: 'CBCS',           icon: 'fa-book-open' },
    people:    { label: 'Faculty',        icon: 'fa-user-tie' },
    notices:   { label: 'Notices',        icon: 'fa-bullhorn' },
    research:  { label: 'Research',       icon: 'fa-flask' },
    scholars:  { label: 'Scholars',       icon: 'fa-user-graduate' },
    timetable: { label: 'Timetable',      icon: 'fa-calendar-days' },
    materials: { label: 'Study Materials',icon: 'fa-folder-open' },
};

let activeCats = []; // categories that have results

async function fetchSearchResults() {
    if (!query) return;
    const q = encodeURIComponent(query);
    try {
        const [progRes, facultyRes, noticeRes, courseRes, cbcsRes, researchRes, scholarRes, ttRes, matRes] = await Promise.all([
            fetch(`${apiBase}/api/v1/programs/?search=${q}`).then(r => r.json()),
            fetch(`${apiBase}/api/v1/faculty/?search=${q}`).then(r => r.json()),
            fetch(`${apiBase}/api/v1/notices/?search=${q}`).then(r => r.json()),
            fetch(`${apiBase}/api/v1/courses/?search=${q}`).then(r => r.json()),
            fetch(`${apiBase}/api/v1/cbcs/?search=${q}`).then(r => r.json()),
            fetch(`${apiBase}/api/v1/research-projects/?search=${q}`).then(r => r.json()),
            fetch(`${apiBase}/api/v1/research-scholars/?search=${q}`).then(r => r.json()),
            fetch(`${apiBase}/api/v1/timetables/?search=${q}`).then(r => r.json()),
            fetch(`${apiBase}/api/v1/study-materials/?search=${q}`).then(r => r.json()),
        ]);

        const progs    = progRes.results    ?? progRes;
        const faculty  = facultyRes.results ?? facultyRes;
        const notices  = noticeRes.results  ?? noticeRes;
        const courses  = courseRes.results  ?? courseRes;
        const cbcs     = cbcsRes.results    ?? cbcsRes;
        const research = researchRes.results ?? researchRes;
        const scholars = scholarRes.results  ?? scholarRes;
        const tt       = ttRes.results       ?? ttRes;
        const mats     = matRes.results      ?? matRes;

        renderPrograms(progs);
        renderFaculty(faculty);
        renderNotices(notices);
        renderCourses(courses);
        renderCBCS(cbcs);
        renderResearch(research);
        renderScholars(scholars);
        renderTimetable(tt);
        renderMaterials(mats);

        // Check if WP pages section has results (server-rendered)
        const wpPages = document.getElementById('sec-pages');
        const hasWp   = wpPages && wpPages.style.display !== 'none';
        if (hasWp) activeCats.push('pages');

        document.getElementById('search-loading').style.display = 'none';

        const totalApi = progs.length + faculty.length + notices.length + courses.length +
                         cbcs.length + research.length + scholars.length + tt.length + mats.length;

        if (totalApi === 0 && !hasWp) {
            document.getElementById('no-results').style.display = 'block';
            document.getElementById('results-wrap').style.display = 'block';
        } else {
            document.getElementById('results-wrap').style.display = 'block';
            buildTabBar();
        }
    } catch (e) {
        console.error("Search failed:", e);
        document.getElementById('search-loading').style.display = 'none';
    }
}

function hide(id) { const el = document.getElementById(id); if (el) el.style.display = 'none'; }

function renderPrograms(list) {
    const wrap = document.getElementById('list-programs');
    if (!list.length) { hide('sec-programs'); return; }
    activeCats.push('programs');
    list.forEach(p => {
        wrap.innerHTML += `
            <div class="col-md-4 col-sm-6">
                <a href="/admissions/" class="search-card">
                    <span class="card-label">${p.level}</span>
                    <h4 class="card-title">${p.name}</h4>
                    <p class="card-meta"><i class="fa-solid fa-building-columns me-1"></i>${p.department_name ?? ''}</p>
                </a>
            </div>`;
    });
}

function renderFaculty(list) {
    const wrap = document.getElementById('list-people');
    if (!list.length) { hide('sec-people'); return; }
    activeCats.push('people');
    list.forEach(f => {
        const photo = f.photo ? mediaBase + f.photo : '';
        const imgTag = photo
            ? `<img src="${photo}" class="faculty-photo-mini" alt="${f.name}">`
            : `<div class="faculty-photo-mini d-flex align-items-center justify-content-center" style="background:#f1f5f9;"><i class="fa-solid fa-user" style="color:#cbd5e1;"></i></div>`;
        wrap.innerHTML += `
            <div class="col-md-3 col-sm-6">
                <a href="/faculty/${f.slug ?? '#'}" class="search-card text-center">
                    ${imgTag}
                    <h4 class="card-title">${f.name}</h4>
                    <p class="card-meta">${f.designation}</p>
                </a>
            </div>`;
    });
}

function renderNotices(list) {
    const wrap = document.getElementById('list-notices');
    if (!list.length) { hide('sec-notices'); return; }
    activeCats.push('notices');
    list.forEach(n => {
        const date = new Date(n.date_posted).toLocaleDateString('en-IN', { day: 'numeric', month: 'short', year: 'numeric' });
        const link = n.attachment ?? '#';
        wrap.innerHTML += `
            <div class="col-md-6">
                <a href="${link}" class="search-card d-flex gap-3 align-items-center" ${link !== '#' ? 'target="_blank"' : ''}>
                    <div style="font-size:2rem; color:#c9a84c; flex-shrink:0;"><i class="fa-solid fa-file-lines"></i></div>
                    <div>
                        <h4 class="card-title">${n.title}</h4>
                        <p class="card-meta">${date}</p>
                    </div>
                </a>
            </div>`;
    });
}

function renderCourses(list) {
    const wrap = document.getElementById('list-courses');
    if (!list.length) { hide('sec-courses'); return; }
    activeCats.push('courses');
    list.forEach(c => {
        wrap.innerHTML += `
            <div class="col-md-4 col-sm-6">
                <div class="search-card">
                    <span class="card-label">${c.course_type} &bull; Sem ${c.semester}</span>
                    <h4 class="card-title">${c.course_title}</h4>
                    <p class="card-meta"><code>${c.course_code}</code> &bull; ${c.credits} Credits</p>
                </div>
            </div>`;
    });
}

function renderCBCS(list) {
    const wrap = document.getElementById('list-cbcs');
    if (!list.length) { hide('sec-cbcs'); return; }
    activeCats.push('cbcs');
    list.forEach(c => {
        wrap.innerHTML += `
            <div class="col-md-4 col-sm-6">
                <div class="search-card">
                    <span class="card-label">Open Elective &bull; Sem ${c.semester}</span>
                    <h4 class="card-title">${c.course_title}</h4>
                    <p class="card-meta"><code>${c.course_code}</code> &bull; ${c.credits} Credits</p>
                </div>
            </div>`;
    });
}

function renderResearch(list) {
    const wrap = document.getElementById('list-research');
    if (!list.length) { hide('sec-research'); return; }
    activeCats.push('research');
    list.forEach(r => {
        wrap.innerHTML += `
            <div class="col-md-6">
                <div class="search-card">
                    <span class="card-label">${r.status} &bull; ${r.funding_agency ?? ''}</span>
                    <h4 class="card-title">${r.title}</h4>
                    <p class="card-meta">PI: ${r.pi_name ?? ''}</p>
                </div>
            </div>`;
    });
}

function renderScholars(list) {
    const wrap = document.getElementById('list-scholars');
    if (!list.length) { hide('sec-scholars'); return; }
    activeCats.push('scholars');
    list.forEach(s => {
        wrap.innerHTML += `
            <div class="col-md-6">
                <div class="search-card">
                    <span class="card-label">Research Scholar &bull; ${s.registration_year}</span>
                    <h4 class="card-title">${s.scholar_name}</h4>
                    <p class="card-meta">${s.research_topic}</p>
                </div>
            </div>`;
    });
}

function renderTimetable(list) {
    const wrap = document.getElementById('list-timetable');
    if (!list.length) { hide('sec-timetable'); return; }
    activeCats.push('timetable');
    list.forEach(t => {
        const link = t.attachment ?? '#';
        wrap.innerHTML += `
            <div class="col-md-6">
                <a href="${link}" class="search-card d-flex gap-3 align-items-center" target="_blank">
                    <div style="font-size:2rem; color:#5c1010; flex-shrink:0;"><i class="fa-solid fa-calendar-days"></i></div>
                    <div>
                        <h4 class="card-title">${t.title}</h4>
                        <p class="card-meta">Timetable</p>
                    </div>
                </a>
            </div>`;
    });
}

function renderMaterials(list) {
    const wrap = document.getElementById('list-materials');
    if (!list.length) { hide('sec-materials'); return; }
    activeCats.push('materials');
    list.forEach(m => {
        const link = m.attachment ?? '#';
        wrap.innerHTML += `
            <div class="col-md-6">
                <a href="${link}" class="search-card d-flex gap-3 align-items-center" target="_blank">
                    <div style="font-size:2rem; color:#1e293b; flex-shrink:0;"><i class="fa-solid fa-folder-open"></i></div>
                    <div>
                        <h4 class="card-title">${m.title}</h4>
                        <p class="card-meta">Study Material</p>
                    </div>
                </a>
            </div>`;
    });
}

function buildTabBar() {
    if (activeCats.length === 0) return;
    const bar = document.getElementById('search-tab-bar');
    // 'All' tab only if there are multiple categories
    if (activeCats.length > 1) {
        const allBtn = document.createElement('button');
        allBtn.className = 's-tab active';
        allBtn.innerHTML = '<i class="fa-solid fa-layer-group"></i> All';
        allBtn.onclick = () => switchSearchTab(allBtn, 'all');
        bar.appendChild(allBtn);
    }
    activeCats.forEach(cat => {
        const m = TAB_META[cat];
        if (!m) return;
        const btn = document.createElement('button');
        btn.className = 's-tab' + (activeCats.length === 1 ? ' active' : '');
        btn.innerHTML = `<i class="fa-solid ${m.icon}"></i> ${m.label}`;
        btn.onclick = () => switchSearchTab(btn, cat);
        bar.appendChild(btn);
    });
    bar.style.removeProperty('display'); // make visible
    bar.style.display = 'flex';
}

function switchSearchTab(btn, cat) {
    document.querySelectorAll('.s-tab').forEach(t => t.classList.remove('active'));
    btn.classList.add('active');
    activeCats.forEach(s => {
        const el = document.getElementById('sec-' + s);
        if (!el) return;
        el.style.display = (cat === 'all' || s === cat) ? 'block' : 'none';
    });
}

document.addEventListener('DOMContentLoaded', fetchSearchResults);
</script>


<?php get_footer(); ?>