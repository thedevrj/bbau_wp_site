<?php
/*
Template Name: Hostel Life
*/
defined('ABSPATH') || exit;
get_header();
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">


<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@500;600;700;800&family=Nunito:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">

<?php get_template_part('banners/about-banner'); ?>

<div class="container-fluid page-bg py-lg-5 overflow-hidden hostel-life-page">
    <?php get_template_part('template-parts/breadcrumb'); ?>

    <div class="container">
        <div class="menu-wrapper">
            <?php get_template_part('menu/menu'); ?>
        </div>

        <h2>Hostel Life</h2>

        <style>
            .hostel-life-page{
                --cream:#FFF8EC;
                --cream-card:#FFFDF8;
                --maroon:#8B1A1A;
                --maroon-soft:#C65B5B;
                --gold:#E8B84B;
                --rose:#F3D6D2;
                --rose-deep:#E8B3AC;
                --sand:#F1E3C3;
                --sage:#DCE3C8;
                --ink:#4A2E22;
                --ink-soft:#93765f;
                --line:#EFE2CC;
            }
            .hostel-life-page{font-family:'Nunito',sans-serif;color:var(--ink);}
            .hostel-life-page h1, .hostel-life-page h2, .hostel-life-page h3{font-family:'Baloo 2',sans-serif;color:var(--maroon);}
            .hostel-life-page > h2{font-size:32px;margin:10px 0 30px;text-align:center;}
            .hl-section{padding:30px 0;}
            .hl-section-head{text-align:center;max-width:560px;margin:0 auto 30px;}
            .hl-section-head .tag{display:inline-block;font-family:'JetBrains Mono',monospace;font-size:11.5px;letter-spacing:.1em;text-transform:uppercase;color:var(--maroon-soft);background:var(--rose);padding:5px 14px;border-radius:999px;margin-bottom:12px;}
            .hl-section-head h3{font-size:26px;}
            .hl-section-head p{color:var(--ink-soft);font-size:14.5px;margin:8px 0 0;font-weight:600;}

            .hl-two-col{display:grid;grid-template-columns:1fr 1fr;gap:26px;align-items:start;}
            .hl-fun-card{background:var(--cream-card);border:2px solid var(--line);border-radius:22px;padding:26px 24px;}
            .hl-fun-card h4{font-family:'Baloo 2',sans-serif;font-size:18px;margin-bottom:12px;display:flex;align-items:center;gap:10px;color:var(--maroon);}
            .hl-fun-card ul{margin:0;padding-left:20px;color:var(--ink-soft);font-size:14.5px;font-weight:600;}
            .hl-fun-card ul li{margin-bottom:9px;}
            .hl-icon-chip{width:34px;height:34px;border-radius:50%;background:var(--rose);display:inline-flex;align-items:center;justify-content:center;font-size:16px;flex-shrink:0;}
            .hl-icon-chip i{color:var(--maroon);font-size:15px;}
            .hl-rule-head .hl-icon-chip i{color:var(--maroon-soft);}
            .hl-curfew-row{display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-top:6px;}
            .hl-curfew-chip{background:var(--sand);border-radius:18px;padding:18px;text-align:center;}
            .hl-curfew-chip .k{font-family:'JetBrains Mono',monospace;font-size:11px;text-transform:uppercase;letter-spacing:.06em;color:var(--maroon-soft);margin-bottom:6px;}
            .hl-curfew-chip .v{font-family:'Baloo 2',sans-serif;font-size:20px;font-weight:700;color:var(--maroon);}
            .hl-curfew-chip .d{font-size:12.5px;color:var(--ink-soft);margin-top:4px;font-weight:600;}
            @media (max-width:760px){.hl-two-col{grid-template-columns:1fr;}}

            .hl-pic-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(210px,1fr));gap:18px;}
            .hl-pic-card{margin:0;background:var(--cream-card);border:2px solid var(--line);border-radius:20px;overflow:hidden;transition:transform .18s ease;}
            .hl-pic-card:hover{transform:translateY(-4px);}
            .hl-pic-card svg{display:block;width:100%;height:auto;}
            .hl-pic-card figcaption{padding:14px 16px 16px;}
            .hl-pic-card figcaption strong{display:block;font-family:'Baloo 2',sans-serif;font-size:15.5px;color:var(--maroon);}
            .hl-pic-card figcaption span{font-size:12.5px;color:var(--ink-soft);font-weight:600;}

            .hl-sticker-label{font-family:'JetBrains Mono',monospace;font-size:12px;letter-spacing:.08em;text-transform:uppercase;color:var(--maroon-soft);font-weight:600;margin:26px 0 14px;display:flex;align-items:center;gap:8px;}
            .hl-sticker-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(210px,1fr));gap:18px;}
            .hl-sticker{border-radius:18px;padding:20px 18px;position:relative;transition:transform .18s ease;font-weight:700;}
            .hl-sticker:nth-child(4n+1){background:var(--rose);transform:rotate(-1.4deg);}
            .hl-sticker:nth-child(4n+2){background:var(--sand);transform:rotate(1deg);}
            .hl-sticker:nth-child(4n+3){background:var(--sage);transform:rotate(-.8deg);}
            .hl-sticker:nth-child(4n+4){background:#f7e3e0;transform:rotate(1.3deg);}
            .hl-sticker:hover{transform:rotate(0deg) translateY(-4px) scale(1.02);}
            .hl-sticker .tape{position:absolute;top:-9px;left:50%;transform:translateX(-50%) rotate(-3deg);width:52px;height:16px;background:rgba(255,255,255,.6);border:1px solid rgba(0,0,0,.05);border-radius:3px;}
            .hl-sticker .name{font-family:'Baloo 2',sans-serif;font-size:16.5px;color:var(--maroon);margin-top:8px;}
            .hl-sticker .sub{font-family:'JetBrains Mono',monospace;font-size:10.5px;color:var(--ink-soft);text-transform:uppercase;letter-spacing:.05em;font-weight:500;}

            .hl-fee-card{background:var(--cream-card);border:2px solid var(--line);border-radius:22px;padding:8px;overflow:hidden;}
            .hl-fee-row{display:flex;justify-content:space-between;align-items:center;padding:14px 20px;border-radius:14px;}
            .hl-fee-row:nth-child(odd){background:#fbf5e8;}
            .hl-fee-row .label{font-weight:700;font-size:14.5px;}
            .hl-fee-row .label small{display:block;font-weight:600;color:var(--ink-soft);font-size:12px;}
            .hl-fee-row .amt{font-family:'JetBrains Mono',monospace;font-weight:700;color:var(--maroon-soft);}
            .hl-fee-row.total{background:var(--maroon);color:#fff8ea;margin-top:4px;}
            .hl-fee-row.total .amt{color:var(--gold);font-size:17px;}
            .hl-fee-note{text-align:center;font-size:12.5px;color:var(--ink-soft);margin-top:14px;font-weight:600;}

            .hl-rule-grid{display:grid;gap:16px;}
            .hl-rule-card{background:var(--cream-card);border:2px solid var(--line);border-radius:20px;overflow:hidden;}
            .hl-rule-head{width:100%;display:flex;align-items:center;gap:14px;padding:16px 20px;background:none;border:none;cursor:pointer;text-align:left;font-family:'Baloo 2',sans-serif;font-size:16.5px;color:var(--maroon);font-weight:700;}
            .hl-rule-head .hl-icon-chip{background:var(--rose);font-size:17px;}
            .hl-rule-head .hl-grow{flex:1;}
            .hl-rule-head .hl-grow small{display:block;font-family:'Nunito',sans-serif;font-size:12.5px;color:var(--ink-soft);font-weight:600;margin-top:2px;}
            .hl-rule-arrow{width:26px;height:26px;border-radius:50%;background:var(--sand);display:flex;align-items:center;justify-content:center;flex-shrink:0;transition:transform .25s ease;font-size:13px;color:var(--maroon);}
            .hl-rule-card.open .hl-rule-arrow{transform:rotate(180deg);}
            .hl-rule-body{max-height:0;overflow:hidden;transition:max-height .3s ease;}
            .hl-rule-body-inner{padding:0 22px 20px 68px;}
            .hl-rule-body-inner ul{margin:0;padding-left:18px;}
            .hl-rule-body-inner li{margin-bottom:9px;font-size:14px;color:var(--ink-soft);font-weight:600;}
            .hl-rule-body-inner li em{color:var(--maroon);font-style:normal;font-weight:800;}

            .hl-cta-band{background:linear-gradient(135deg, var(--maroon), var(--maroon-soft));border-radius:26px;padding:36px clamp(20px,4vw,44px);display:flex;justify-content:space-between;align-items:center;gap:24px;flex-wrap:wrap;color:#fff8ea;}
            .hl-section-head h3 i{color:var(--gold);font-size:.8em;margin-left:6px;}
            .hl-sticker-label i{color:var(--maroon-soft);}
            .hl-cta-band h4{color:#fff8ea;font-size:21px;font-family:'Baloo 2',sans-serif;margin:0;}
            .hl-cta-band h4 i{color:var(--gold);margin-left:6px;}
            .hl-cta-band p{margin:6px 0 0;color:#f6dfd7;font-size:13.5px;font-weight:600;max-width:420px;}
            .hl-btn{display:inline-flex;align-items:center;gap:8px;padding:13px 26px;border-radius:999px;font-weight:700;font-size:14.5px;text-decoration:none;background:var(--gold);color:var(--maroon);box-shadow:0 6px 0 #b98c30;}
        </style>
        <section class="hl-section">
            <div class="hl-two-col">
                <div class="hl-fun-card">
                    <h4><span class="hl-icon-chip"><i class="fa-solid fa-bullseye"></i></span> Why hostel life matters</h4>
                    <ul>
                        <li>Friends from every corner of the country, living together and building real bonds.</li>
                        <li>Plenty of quiet time carved out for study and research.</li>
                        <li>A cheerful push for co-curricular and extra-curricular fun.</li>
                        <li>One community — no matter your caste, religion, hometown, or gender.</li>
                    </ul>
                </div>
                <div class="hl-fun-card">
                    <h4><span class="hl-icon-chip"><i class="fa-solid fa-moon"></i></span> Curfew, at a glance</h4>
                    <div class="hl-curfew-row">
                        <div class="hl-curfew-chip">
                            <div class="k">General</div>
                            <div class="v">10:00 PM</div>
                            <div class="d">Back-in-hostel time</div>
                        </div>
                        <div class="hl-curfew-chip">
                            <div class="k">Girls Hostel</div>
                            <div class="v">8 PM–5 AM</div>
                            <div class="d">Return by 8, out from 5</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
>
        <section class="hl-section">
            <div class="hl-section-head">
                <span class="tag">Life in pictures</span>
                <h3>A peek into hostel life <i class="fa-solid fa-camera"></i></h3>
                <p>Illustrated for now — swap these for real photos from your hostels anytime.</p>
            </div>
            <div class="hl-pic-grid">
                <figure class="hl-pic-card">
                    <svg viewBox="0 0 300 220" xmlns="http://www.w3.org/2000/svg">
                        <rect width="300" height="220" fill="#F3D6D2"/>
                        <rect x="0" y="150" width="300" height="70" fill="#EAD9C4"/>
                        <rect x="50" y="112" width="200" height="30" rx="6" fill="#fff8ea"/>
                        <circle cx="80" cy="127" r="10" fill="#E8B84B"/>
                        <circle cx="150" cy="127" r="10" fill="#E8B84B"/>
                        <circle cx="220" cy="127" r="10" fill="#E8B84B"/>
                        <circle cx="72" cy="85" r="16" fill="#4A2E22"/>
                        <rect x="58" y="99" width="28" height="34" rx="10" fill="#C65B5B"/>
                        <circle cx="150" cy="82" r="16" fill="#7a4a34"/>
                        <rect x="136" y="96" width="28" height="34" rx="10" fill="#8B1A1A"/>
                        <circle cx="228" cy="85" r="16" fill="#5a3a28"/>
                        <rect x="214" y="99" width="28" height="34" rx="10" fill="#DCE3C8"/>
                    </svg>
                    <figcaption><strong>Mess Hall</strong><span>Shared meals, shared stories</span></figcaption>
                </figure>

                <figure class="hl-pic-card">
                    <svg viewBox="0 0 300 220" xmlns="http://www.w3.org/2000/svg">
                        <rect width="300" height="220" fill="#DCE3C8"/>
                        <rect x="90" y="70" width="120" height="90" rx="6" fill="#EAD9C4" stroke="#8B1A1A" stroke-width="3"/>
                        <circle cx="115" cy="95" r="6" fill="#8B1A1A"/>
                        <circle cx="150" cy="140" r="6" fill="#4A2E22"/>
                        <circle cx="185" cy="95" r="6" fill="#E8B84B"/>
                        <circle cx="115" cy="140" r="6" fill="#E8B84B"/>
                        <circle cx="185" cy="140" r="6" fill="#8B1A1A"/>
                        <circle cx="40" cy="80" r="15" fill="#4A2E22"/>
                        <rect x="26" y="94" width="28" height="34" rx="10" fill="#C65B5B"/>
                        <circle cx="260" cy="85" r="15" fill="#7a4a34"/>
                        <rect x="246" y="99" width="28" height="34" rx="10" fill="#8B1A1A"/>
                    </svg>
                    <figcaption><strong>Common Room</strong><span>Carrom, cards, and lazy evenings</span></figcaption>
                </figure>

                <figure class="hl-pic-card">
                    <svg viewBox="0 0 300 220" xmlns="http://www.w3.org/2000/svg">
                        <rect width="300" height="220" fill="#F1E3C3"/>
                        <rect x="0" y="170" width="300" height="50" fill="#c9d9a8"/>
                        <circle cx="150" cy="150" r="9" fill="#fff8ea" stroke="#8B1A1A" stroke-width="2"/>
                        <circle cx="60" cy="120" r="15" fill="#4A2E22"/>
                        <rect x="46" y="134" width="28" height="40" rx="10" fill="#8B1A1A"/>
                        <circle cx="240" cy="115" r="15" fill="#7a4a34"/>
                        <rect x="226" y="129" width="28" height="40" rx="10" fill="#C65B5B"/>
                        <circle cx="150" cy="100" r="15" fill="#5a3a28"/>
                        <rect x="136" y="114" width="28" height="40" rx="10" fill="#DCE3C8"/>
                    </svg>
                    <figcaption><strong>Sports Ground</strong><span>Evening matches after class</span></figcaption>
                </figure>

                <figure class="hl-pic-card">
                    <svg viewBox="0 0 300 220" xmlns="http://www.w3.org/2000/svg">
                        <rect width="300" height="220" fill="#f7e3e0"/>
                        <circle cx="50" cy="40" r="8" fill="#E8B84B"/>
                        <circle cx="250" cy="55" r="8" fill="#E8B84B"/>
                        <circle cx="150" cy="30" r="8" fill="#E8B84B"/>
                        <path d="M40 190 L40 150 Q40 140 50 140 L60 140 Q70 140 70 150 L70 190 Z" fill="#8B1A1A"/>
                        <path d="M240 190 L240 150 Q240 140 250 140 L260 140 Q270 140 270 150 L270 190 Z" fill="#C65B5B"/>
                        <circle cx="120" cy="110" r="15" fill="#4A2E22"/>
                        <rect x="106" y="124" width="28" height="46" rx="10" fill="#8B1A1A"/>
                        <circle cx="180" cy="105" r="15" fill="#7a4a34"/>
                        <rect x="166" y="119" width="28" height="46" rx="10" fill="#E8B84B"/>
                    </svg>
                    <figcaption><strong>Festival Nights</strong><span>Diwali &amp; Holi in the courtyard</span></figcaption>
                </figure>
            </div>
        </section>

        <section class="hl-section">
            <div class="hl-section-head">
                <span class="tag">Directory</span>
                <h3>Meet all 11 hostels <i class="fa-solid fa-building"></i></h3>
                <p>Allotted by the Dean, Students' Welfare — subject to seat availability.</p>
            </div>

            <div class="hl-sticker-label"><i class="fa-solid fa-venus"></i> Girls Hostels</div>
            <div class="hl-sticker-grid">
                <div class="hl-sticker"><div class="tape"></div><div class="sub">Girls Hostel</div><div class="name">Yashodhara</div></div>
                <div class="hl-sticker"><div class="tape"></div><div class="sub">Girls Hostel</div><div class="name">Sanghmitra</div></div>
                <div class="hl-sticker"><div class="tape"></div><div class="sub">Extension</div><div class="name">Sanghmitra Ext.</div></div>
                <div class="hl-sticker"><div class="tape"></div><div class="sub">Girls Hostel</div><div class="name">Chitralekha</div></div>
                <div class="hl-sticker"><div class="tape"></div><div class="sub">OBC</div><div class="name">OBC Girls Hostel</div></div>
                <div class="hl-sticker"><div class="tape"></div><div class="sub">Girls Hostel</div><div class="name">Savitri Bai Phule</div></div>
            </div>

            <div class="hl-sticker-label" style="margin-top:34px;"><i class="fa-solid fa-mars"></i> Boys Hostels</div>
            <div class="hl-sticker-grid">
                <div class="hl-sticker"><div class="tape"></div><div class="sub">Boys Hostel</div><div class="name">Ashoka</div></div>
                <div class="hl-sticker"><div class="tape"></div><div class="sub">Boys Hostel</div><div class="name">Kanishka</div></div>
                <div class="hl-sticker"><div class="tape"></div><div class="sub">Boys Hostel</div><div class="name">Siddhartha</div></div>
                <div class="hl-sticker"><div class="tape"></div><div class="sub">RCA</div><div class="name">RCA Boys Hostel</div></div>
                <div class="hl-sticker"><div class="tape"></div><div class="sub">OBC</div><div class="name">OBC Boys Hostel</div></div>
            </div>
        </section>

        <section class="hl-section">
            <div class="hl-section-head">
                <span class="tag">Money talk</span>
                <h3>Hostel fee, made simple <i class="fa-solid fa-coins"></i></h3>
                <p>Room rental, electrical &amp; services charges are per semester. Caution deposit is one-time &amp; refundable.</p>
            </div>
            <div class="hl-fee-card">
                <div class="hl-fee-row"><div class="label">Admission fee<small>per year</small></div><div class="amt">Rs. 1000/-</div></div>
                <div class="hl-fee-row"><div class="label">Hostel Caution Deposit<small>one-time, refundable</small></div><div class="amt">Rs. 2000/-</div></div>
                <div class="hl-fee-row"><div class="label">Electrical Charges<small>per semester</small></div><div class="amt">Rs. 500/-</div></div>
                <div class="hl-fee-row"><div class="label">Room Rental*<small>per semester</small></div><div class="amt">Rs. 500/-</div></div>
                <div class="hl-fee-row"><div class="label">Services &amp; Maintenance<small>per semester</small></div><div class="amt">Rs. 500/-</div></div>
                <div class="hl-fee-row"><div class="label">Miscellaneous Fee</div><div class="amt">Rs. 100/-</div></div>
                <div class="hl-fee-row total"><div class="label">Total</div><div class="amt">Rs. 4600/-</div></div>
            </div>
            <p class="hl-fee-note">*Fees may be revised — check with the Hostel Office for the latest notification.</p>
        </section>

        <section class="hl-section" id="hl-rules">
            <div class="hl-section-head">
                <span class="tag">The fine print</span>
                <h3>Rules, admission &amp; residence <i class="fa-solid fa-clipboard-list"></i></h3>
                <p>Tap a card to open it up.</p>
            </div>
            <div class="hl-rule-grid">

                <div class="hl-rule-card">
                    <button class="hl-rule-head"><span class="hl-icon-chip"><i class="fa-solid fa-file-signature"></i></span><span class="hl-grow">Getting admitted to a hostel<small>Forms, deadlines &amp; allotment</small></span><span class="hl-rule-arrow"><i class="fa-solid fa-chevron-down"></i></span></button>
                    <div class="hl-rule-body"><div class="hl-rule-body-inner"><ul>
                        <li>Download the form from the University website and submit it, filled in, with proof of registration and your Aadhar Card at the DSW office by the prescribed date.</li>
                        <li>Deposit your hostel fee receipt at the hostel office by the last date set by the DSW office — miss it, and your allotment is cancelled.</li>
                        <li>Allotment is made by the Dean, Students' Welfare (or an authorized officer); no one is entitled to a particular hostel or room as a matter of right.</li>
                        <li>Take possession of your allotted room within <em>seven days</em>, or it passes on to the next student on the waiting list.</li>
                        <li>Room-level allotment inside a hostel is handled by the concerned Warden(s).</li>
                    </ul></div></div>
                </div>

                <div class="hl-rule-card">
                    <button class="hl-rule-head"><span class="hl-icon-chip"><i class="fa-solid fa-moon"></i></span><span class="hl-grow">Everyday hostel rules<small>Curfew, visitors &amp; house rules</small></span><span class="hl-rule-arrow"><i class="fa-solid fa-chevron-down"></i></span></button>
                    <div class="hl-rule-body"><div class="hl-rule-body-inner"><ul>
                        <li>A hostel room doesn't come with any tenancy or subletting rights.</li>
                        <li>Be back by <em>10:00 PM</em>. In Girls Hostels, that's <em>8:00 PM</em>, with morning exit allowed from <em>5:00 AM</em>.</li>
                        <li>No visitors are allowed to stay in a room after 10:00 PM.</li>
                        <li>Keep your room and the hostel neat and tidy — no stickers or paint on the walls.</li>
                        <li>Rooms may be inspected by University authorities at any time.</li>
                        <li>No cooking in rooms or the pantry.</li>
                        <li>No narcotics, alcohol, or gambling on hostel premises.</li>
                        <li>No pets on hostel premises.</li>
                        <li>The University can close any or all hostels suo moto if needed.</li>
                    </ul></div></div>
                </div>

                <div class="hl-rule-card">
                    <button class="hl-rule-head"><span class="hl-icon-chip"><i class="fa-solid fa-utensils"></i></span><span class="hl-grow">How the mess works<small>Coupons, dining hall &amp; etiquette</small></span><span class="hl-rule-arrow"><i class="fa-solid fa-chevron-down"></i></span></button>
                    <div class="hl-rule-body"><div class="hl-rule-body-inner"><ul>
                        <li>Each hostel runs its own mess, managed by an authorized private contractor, with the Warden overseeing it.</li>
                        <li>Joining the mess is compulsory for every allotted student — meals run on coupons bought a day in advance.</li>
                        <li>Guests can eat too, on payment of the guest mess charge.</li>
                        <li>It's self-service, and one resident gets one plate or thali.</li>
                        <li>Dress properly, skip the smoking and alcohol, and stick to the meal timings.</li>
                        <li>Don't waste food, don't take utensils out of the hall, and steer clear of the kitchen unless you're on mess duty.</li>
                        <li>Eating against someone else's coupon (impersonation) is a serious offence — it can even lead to an FIR.</li>
                        <li>Breaking these rules can mean a fine or disciplinary action, including expulsion from the hostel.</li>
                    </ul></div></div>
                </div>

                <div class="hl-rule-card">
                    <button class="hl-rule-head"><span class="hl-icon-chip"><i class="fa-solid fa-calendar-days"></i></span><span class="hl-grow">How long you can stay<small>Duration &amp; vacating rooms</small></span><span class="hl-rule-arrow"><i class="fa-solid fa-chevron-down"></i></span></button>
                    <div class="hl-rule-body"><div class="hl-rule-body-inner"><ul>
                        <li>Accommodation starts semester-by-semester and continues as long as you stay registered and meet academic requirements.</li>
                        <li>M.Phil./Ph.D. residents can stay up to the total registration period allowed by the ordinance.</li>
                        <li>The maximum stay matches the normal duration of your program.</li>
                        <li>Rooms must be vacated at the end of the academic session, or when your program finishes — whichever comes first.</li>
                    </ul></div></div>
                </div>

                <div class="hl-rule-card">
                    <button class="hl-rule-head"><span class="hl-icon-chip"><i class="fa-solid fa-triangle-exclamation"></i></span><span class="hl-grow">If things go wrong<small>Eviction procedure</small></span><span class="hl-rule-arrow"><i class="fa-solid fa-chevron-down"></i></span></button>
                    <div class="hl-rule-body"><div class="hl-rule-body-inner"><ul>
                        <li>Breaking hostel or mess discipline rules can lead to eviction.</li>
                        <li>The Warden handles this in consultation with the Dean, Students' Welfare.</li>
                        <li>A five-day eviction notice is served first.</li>
                        <li>If the room still isn't vacated, it's opened in the presence of the Proctor, Warden, Security Officer, Caretaker/Matron, and a nominee of the Vice-Chancellor.</li>
                    </ul></div></div>
                </div>

            </div>
        </section>

        <section class="hl-section">
            <div class="hl-cta-band">
                <div>
                    <h4>Ready to move in? <i class="fa-solid fa-champagne-glasses"></i></h4>
                    <p>Download the hostel admission form from the University website and submit it to the DSW office with your registration proof and Aadhar Card.</p>
                </div>
                <a href="#" class="hl-btn">Go to Hostel Office →</a>
            </div>
        </section>

    </div>
</div>

<script>
document.querySelectorAll('.hl-rule-card').forEach(function(card){
    var head = card.querySelector('.hl-rule-head');
    var body = card.querySelector('.hl-rule-body');
    head.addEventListener('click', function(){
        var open = card.classList.contains('open');
        if (open) {
            body.style.maxHeight = null;
            card.classList.remove('open');
        } else {
            card.classList.add('open');
            body.style.maxHeight = body.scrollHeight + 'px';
        }
    });
});
</script>

<?php get_footer(); ?>