<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Health Learning Centre – MediCare+</title>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=Lora:ital,wght@0,600;1,400&display=swap" rel="stylesheet">

<style>
*{margin:0;padding:0;box-sizing:border-box;}

:root{
    --sky:#0ea5e9;
    --sky-dark:#0284c7;
    --navy:#0f172a;
    --slate:#1e293b;
    --muted:#64748b;
    --light:#f1f5f9;
    --white:#ffffff;
    --green:#16a34a;
    --green-bg:#dcfce7;
    --amber:#d97706;
    --amber-bg:#fef3c7;
    --red:#dc2626;
    --red-bg:#fee2e2;
    --purple:#7c3aed;
    --purple-bg:#ede9fe;
}

body{
    font-family:'Plus Jakarta Sans',sans-serif;
    background:var(--light);
    color:var(--navy);
}

/* SIDEBAR */
.sidebar{
    width:260px;height:100vh;position:fixed;top:0;left:0;
    background:linear-gradient(to bottom,#0f172a,#1e293b);
    color:#fff;padding-top:20px;z-index:1000;
    transition:.3s;overflow-y:auto;
}
.logo{text-align:center;padding:10px 20px 30px;border-bottom:1px solid rgba(255,255,255,.08);}
.logo h2{font-size:24px;color:#38bdf8;}
.logo p{font-size:13px;color:#94a3b8;margin-top:5px;}
.sidebar-links{margin-top:20px;}
.sidebar a{
    display:flex;align-items:center;gap:14px;color:#cbd5e1;
    text-decoration:none;padding:15px 25px;margin:5px 12px;
    border-radius:12px;transition:.3s;font-size:15px;
}
.sidebar a:hover,.sidebar a.active{background:#0ea5e9;color:#fff;transform:translateX(5px);}
.sidebar a i{font-size:18px;}

/* MAIN */
.main{margin-left:260px;padding:25px;transition:.3s;}

/* TOPBAR */
.topbar{
    background:white;border-radius:18px;padding:18px 25px;
    display:flex;justify-content:space-between;align-items:center;
    box-shadow:0 5px 20px rgba(0,0,0,.05);margin-bottom:30px;
}
.top-left{display:flex;align-items:center;gap:15px;}
.menu-toggle{display:none;font-size:24px;cursor:pointer;}
.topbar h1{font-size:26px;color:var(--navy);}
.topbar p{color:var(--muted);margin-top:4px;font-size:14px;}

/* HERO */
.hero{
    background:linear-gradient(135deg,#0f172a 0%,#0369a1 60%,#0ea5e9 100%);
    border-radius:22px;padding:50px 40px;
    color:white;margin-bottom:35px;position:relative;overflow:hidden;
}
.hero::before{
    content:'';position:absolute;right:-60px;top:-60px;
    width:340px;height:340px;border-radius:50%;
    background:rgba(255,255,255,.04);
}
.hero::after{
    content:'';position:absolute;right:80px;bottom:-80px;
    width:200px;height:200px;border-radius:50%;
    background:rgba(255,255,255,.06);
}
.hero-label{
    display:inline-block;background:rgba(255,255,255,.15);
    color:#bae6fd;font-size:12px;font-weight:600;letter-spacing:.08em;
    text-transform:uppercase;padding:6px 14px;border-radius:30px;margin-bottom:16px;
}
.hero h2{font-family:'Lora',serif;font-size:36px;line-height:1.2;margin-bottom:10px;}
.hero p{color:#bae6fd;font-size:15px;margin-bottom:28px;max-width:500px;}
.search-bar{
    display:flex;max-width:540px;
    background:white;border-radius:14px;overflow:hidden;
    box-shadow:0 8px 30px rgba(0,0,0,.2);
}
.search-bar input{
    flex:1;border:none;padding:16px 20px;font-size:15px;
    font-family:'Plus Jakarta Sans',sans-serif;color:var(--navy);outline:none;
}
.search-bar button{
    background:var(--sky);border:none;color:white;
    padding:16px 24px;cursor:pointer;font-size:15px;
    font-weight:600;font-family:'Plus Jakarta Sans',sans-serif;transition:.2s;
}
.search-bar button:hover{background:var(--sky-dark);}

/* CATEGORY PILLS */
.categories{display:flex;gap:10px;flex-wrap:wrap;margin-bottom:30px;}
.pill{
    background:white;border:1.5px solid #e2e8f0;
    color:var(--slate);padding:9px 18px;border-radius:30px;
    font-size:13px;font-weight:600;cursor:pointer;transition:.25s;
    display:flex;align-items:center;gap:7px;
}
.pill:hover,.pill.active{background:var(--sky);color:white;border-color:var(--sky);}
.pill i{font-size:14px;}

/* SECTION HEADER */
.sec-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:18px;}
.sec-header h3{font-size:20px;color:var(--navy);}
.see-all{color:var(--sky);font-size:13px;font-weight:600;text-decoration:none;}
.see-all:hover{text-decoration:underline;}

/* FEATURED ARTICLES */
.featured-grid{
    display:grid;grid-template-columns:2fr 1fr;
    gap:20px;margin-bottom:35px;
}
.article-main{
    background:white;border-radius:20px;overflow:hidden;
    box-shadow:0 5px 20px rgba(0,0,0,.05);transition:.3s;cursor:pointer;
}
.article-main:hover{transform:translateY(-5px);box-shadow:0 12px 35px rgba(0,0,0,.1);}
.art-img-placeholder{width:100%;height:220px;display:flex;align-items:center;justify-content:center;font-size:60px;}
.article-body{padding:22px;}
.article-tag{
    display:inline-block;font-size:11px;font-weight:700;
    text-transform:uppercase;letter-spacing:.07em;
    padding:5px 12px;border-radius:20px;margin-bottom:12px;
}
.tag-heart{background:#fce7f3;color:#9d174d;}
.tag-mind{background:var(--purple-bg);color:var(--purple);}
.tag-nutrition{background:var(--green-bg);color:#166534;}
.tag-fitness{background:var(--amber-bg);color:#92400e;}
.tag-prevention{background:#dbeafe;color:#1e40af;}
.tag-first-aid{background:var(--red-bg);color:#991b1b;}
.article-body h4{font-size:18px;line-height:1.35;margin-bottom:10px;}
.article-body p{color:var(--muted);font-size:14px;line-height:1.7;}
.article-meta{display:flex;align-items:center;gap:12px;margin-top:14px;font-size:12px;color:var(--muted);}
.avatar-placeholder{
    width:28px;height:28px;border-radius:50%;
    background:var(--sky);color:white;font-size:11px;font-weight:700;
    display:flex;align-items:center;justify-content:center;
}

/* SIDE ARTICLES */
.article-side-stack{display:flex;flex-direction:column;gap:15px;}
.article-side{
    background:white;border-radius:16px;overflow:hidden;
    box-shadow:0 5px 20px rgba(0,0,0,.05);
    display:flex;transition:.3s;cursor:pointer;
}
.article-side:hover{transform:translateY(-3px);}
.side-img{width:100px;flex-shrink:0;}
.side-img-placeholder{
    width:100px;height:100%;min-height:100px;
    display:flex;align-items:center;justify-content:center;font-size:32px;
}
.side-body{padding:14px 14px 14px 0;flex:1;}
.side-body .article-tag{font-size:10px;padding:3px 9px;margin-bottom:7px;}
.side-body h5{font-size:13px;font-weight:600;line-height:1.4;margin-bottom:4px;}
.side-body span{font-size:11px;color:var(--muted);}

/* HEALTH TIPS */
.tips-grid{
    display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));
    gap:16px;margin-bottom:35px;
}
.tip-card{
    background:white;border-radius:18px;padding:22px 18px;
    box-shadow:0 5px 20px rgba(0,0,0,.05);transition:.3s;cursor:pointer;
    border-top:4px solid transparent;
}
.tip-card:hover{transform:translateY(-6px);}
.tip-card.t1{border-color:#0ea5e9;}
.tip-card.t2{border-color:#16a34a;}
.tip-card.t3{border-color:#7c3aed;}
.tip-card.t4{border-color:#d97706;}
.tip-card.t5{border-color:#dc2626;}
.tip-icon{font-size:36px;margin-bottom:14px;}
.tip-card h4{font-size:15px;font-weight:700;margin-bottom:8px;}
.tip-card p{font-size:13px;color:var(--muted);line-height:1.6;}

/* ACCORDION */
.accordion-section{margin-bottom:35px;}
.accordion{background:white;border-radius:16px;overflow:hidden;box-shadow:0 5px 20px rgba(0,0,0,.05);}
.accordion-item{border-bottom:1px solid #f1f5f9;}
.accordion-item:last-child{border-bottom:none;}
.accordion-btn{
    width:100%;background:none;border:none;padding:20px 24px;
    display:flex;justify-content:space-between;align-items:center;
    cursor:pointer;text-align:left;font-family:'Plus Jakarta Sans',sans-serif;transition:.2s;
}
.accordion-btn:hover{background:#f8fafc;}
.accordion-btn-left{display:flex;align-items:center;gap:14px;}
.accordion-btn-icon{
    width:38px;height:38px;border-radius:12px;
    display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0;
}
.accordion-btn h5{font-size:15px;font-weight:600;color:var(--navy);}
.accordion-btn p{font-size:12px;color:var(--muted);margin-top:2px;}
.accordion-chevron{font-size:16px;color:var(--muted);transition:.3s;flex-shrink:0;}
.accordion-item.open .accordion-chevron{transform:rotate(180deg);}
.accordion-body{max-height:0;overflow:hidden;transition:max-height .35s ease,padding .3s;padding:0 24px;}
.accordion-item.open .accordion-body{max-height:600px;padding:0 24px 22px;}
.accordion-body p{font-size:14px;color:var(--muted);line-height:1.8;margin-bottom:10px;}
.accordion-body ul{padding-left:18px;}
.accordion-body ul li{font-size:14px;color:var(--muted);line-height:1.9;margin-bottom:2px;}
.accordion-body .read-link{
    display:inline-flex;align-items:center;gap:6px;
    color:var(--sky);font-size:13px;font-weight:600;
    text-decoration:none;margin-top:10px;
}
.accordion-body .read-link:hover{text-decoration:underline;}

/* VIDEO SECTION */
.video-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(280px,1fr));
    gap:22px;
    margin-bottom:35px;
}
.video-card{
    background:white;
    border-radius:18px;
    overflow:hidden;
    box-shadow:0 5px 20px rgba(0,0,0,.06);
    transition:.3s;
}
.video-card:hover{
    transform:translateY(-6px);
    box-shadow:0 14px 35px rgba(0,0,0,.1);
}
.video-wrapper{
    width:100%;
    background:#0f172a;
    border-radius:18px 18px 0 0;
    overflow:hidden;
    line-height:0;
}
.video-wrapper video{
    width:100%;
    height:190px;
    object-fit:cover;
    display:block;
}
.video-body{padding:16px 18px 18px;}
.video-body h5{
    font-size:15px;font-weight:600;
    margin:8px 0 6px;line-height:1.4;color:#0f172a;
}
.video-meta{display:flex;gap:16px;margin-top:10px;font-size:12px;color:#64748b;}
.video-meta span{display:flex;align-items:center;gap:5px;}

/* TRACKER */
.tracker-card{
    background:white;border-radius:20px;padding:28px;
    box-shadow:0 5px 20px rgba(0,0,0,.05);margin-bottom:35px;
}
.tracker-grid{
    display:grid;grid-template-columns:repeat(auto-fit,minmax(150px,1fr));
    gap:14px;margin-top:20px;
}
.tracker-item{
    background:var(--light);border-radius:14px;padding:16px;text-align:center;
    transition:.2s;cursor:pointer;
}
.tracker-item:hover{background:#e0f2fe;}
.tracker-item.done{background:var(--green-bg);}
.tracker-item i{font-size:28px;margin-bottom:8px;display:block;}
.tracker-item span{font-size:13px;font-weight:600;color:var(--slate);}
.tracker-item small{display:block;font-size:11px;color:var(--muted);margin-top:3px;}
.tracker-progress{margin-top:20px;}
.progress-bar{background:#e2e8f0;border-radius:30px;height:8px;overflow:hidden;margin-top:8px;}
.progress-fill{
    height:100%;border-radius:30px;
    background:linear-gradient(to right,#0ea5e9,#6366f1);
    transition:width .5s ease;
}
.progress-label{display:flex;justify-content:space-between;font-size:12px;color:var(--muted);}

/* MOBILE */
@media(max-width:768px){
    .sidebar{left:-260px;}
    .sidebar.active{left:0;}
    .main{margin-left:0;padding:15px;}
    .menu-toggle{display:block;}
    .hero{padding:30px 22px;}
    .hero h2{font-size:24px;}
    .featured-grid{grid-template-columns:1fr;}
    .article-side-stack{display:none;}
    .video-grid{grid-template-columns:1fr;}
}
</style>
</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar" id="sidebar">
    <div class="logo">
        <h2>MediCare+</h2>
        <p>Cloud Telemedicine Platform</p>
    </div>
    <div class="sidebar-links">
        <a href="/dashboard"><i class="fa-solid fa-house"></i> Dashboard</a>
        <a href="/appointments"><i class="fa-solid fa-calendar-check"></i> Appointments</a>
        <a href="/doctors/consult"><i class="fa-solid fa-user-doctor"></i> Doctors</a>
        <a href="/dr-ai-chat"><i class="fa-solid fa-robot"></i> Dr AI Assistant</a>
        <a href="/health-learn" class="active"><i class="fa-solid fa-book-open-reader"></i> Health Learning</a>
        <a href="#"><i class="fa-solid fa-user"></i> Profile</a>
    </div>
</div>

<!-- MAIN -->
<div class="main">

    <!-- TOPBAR -->
    <div class="topbar">
        <div class="top-left">
            <span class="menu-toggle" onclick="toggleMenu()"><i class="fa-solid fa-bars"></i></span>
            <div>
                <h1><i class="fa-solid fa-book-open-reader" style="color:#0ea5e9;margin-right:10px;"></i>Health Learning Centre</h1>
                <p>Evidence-based articles, tips, and guides to keep you well.</p>
            </div>
        </div>
        <a href="/home" style="background:#0ea5e9;color:white;padding:12px 20px;border-radius:10px;text-decoration:none;font-weight:600;font-size:14px;">
            <i class="fa-solid fa-arrow-left" style="margin-right:6px;"></i>Back to Dashboard
        </a>
    </div>

    <!-- HERO SEARCH -->
    <div class="hero">
        <div class="hero-label"><i class="fa-solid fa-shield-heart"></i> &nbsp;Your Wellness Hub</div>
        <h2>Learn. Understand.<br>Live Healthier.</h2>
        <p>Explore trusted health articles, expert tips, and interactive guides curated by our medical team.</p>
        <div class="search-bar">
            <input type="text" id="searchInput" placeholder="Search articles, tips, conditions…" oninput="filterArticles()"/>
            <button onclick="filterArticles()"><i class="fa-solid fa-magnifying-glass"></i> &nbsp;Search</button>
        </div>
    </div>

    <!-- CATEGORY PILLS -->
    <div class="categories">
        <span class="pill active" onclick="setCategory('all',this)"><i class="fa-solid fa-border-all"></i> All Topics</span>
        <span class="pill" onclick="setCategory('heart',this)"><i class="fa-solid fa-heart-pulse"></i> Heart Health</span>
        <span class="pill" onclick="setCategory('mind',this)"><i class="fa-solid fa-brain"></i> Mental Health</span>
        <span class="pill" onclick="setCategory('nutrition',this)"><i class="fa-solid fa-apple-whole"></i> Nutrition</span>
        <span class="pill" onclick="setCategory('fitness',this)"><i class="fa-solid fa-dumbbell"></i> Fitness</span>
        <span class="pill" onclick="setCategory('prevention',this)"><i class="fa-solid fa-shield-virus"></i> Prevention</span>
        <span class="pill" onclick="setCategory('first-aid',this)"><i class="fa-solid fa-kit-medical"></i> First Aid</span>
    </div>

    <!-- FEATURED ARTICLES -->
    <div class="sec-header">
        <h3><i class="fa-solid fa-fire" style="color:#f97316;margin-right:8px;"></i>Featured Articles</h3>
        <a href="#" class="see-all">See all articles →</a>
    </div>

    <div class="featured-grid" id="articleGrid">

        <div class="article-main" data-category="heart" onclick="openArticle('understanding-heart-health')">
            <div class="art-img-placeholder" style="background:linear-gradient(135deg,#fee2e2,#fecaca);">❤️</div>
            <div class="article-body">
                <span class="article-tag tag-heart">Heart Health</span>
                <h4>Understanding Your Heart: A Complete Guide to Cardiovascular Wellness</h4>
                <p>Learn how your heart works, key risk factors for heart disease, and practical lifestyle changes that can significantly improve your cardiovascular health over time.</p>
                <div class="article-meta">
                    <div class="avatar-placeholder">DM</div>
                    <span>Dr. Mwansa</span>
                    <span>·</span>
                    <span><i class="fa-regular fa-clock"></i> 8 min read</span>
                    <span>·</span>
                    <span>May 2025</span>
                </div>
            </div>
        </div>

        <div class="article-side-stack">

            <div class="article-side" data-category="mind" onclick="openArticle('stress-management')">
                <div class="side-img">
                    <div class="side-img-placeholder" style="background:linear-gradient(135deg,#ede9fe,#ddd6fe);">🧘</div>
                </div>
                <div class="side-body">
                    <span class="article-tag tag-mind">Mental Health</span>
                    <h5>5 Proven Techniques to Manage Daily Stress</h5>
                    <span><i class="fa-regular fa-clock"></i> 5 min read</span>
                </div>
            </div>

            <div class="article-side" data-category="nutrition" onclick="openArticle('balanced-diet')">
                <div class="side-img">
                    <div class="side-img-placeholder" style="background:linear-gradient(135deg,#dcfce7,#bbf7d0);">🥗</div>
                </div>
                <div class="side-body">
                    <span class="article-tag tag-nutrition">Nutrition</span>
                    <h5>Building a Balanced Plate: Macro & Micronutrients Explained</h5>
                    <span><i class="fa-regular fa-clock"></i> 6 min read</span>
                </div>
            </div>

            <div class="article-side" data-category="prevention" onclick="openArticle('vaccines-101')">
                <div class="side-img">
                    <div class="side-img-placeholder" style="background:linear-gradient(135deg,#dbeafe,#bfdbfe);">💉</div>
                </div>
                <div class="side-body">
                    <span class="article-tag tag-prevention">Prevention</span>
                    <h5>Vaccines 101: Why Immunisation Matters for Everyone</h5>
                    <span><i class="fa-regular fa-clock"></i> 4 min read</span>
                </div>
            </div>

        </div>
    </div>

    <!-- DAILY HEALTH TIPS -->
    <div class="sec-header">
        <h3><i class="fa-solid fa-lightbulb" style="color:#f59e0b;margin-right:8px;"></i>Daily Health Tips</h3>
    </div>

    <div class="tips-grid">
        <div class="tip-card t1">
            <div class="tip-icon">💧</div>
            <h4>Stay Hydrated</h4>
            <p>Drink at least 8 glasses of water daily. Proper hydration supports kidney function, skin health, and energy levels.</p>
        </div>
        <div class="tip-card t2">
            <div class="tip-icon">🚶</div>
            <h4>Move Every Hour</h4>
            <p>Sitting for long periods increases health risks. Stand, stretch, or walk for 5 minutes every hour to keep circulation healthy.</p>
        </div>
        <div class="tip-card t3">
            <div class="tip-icon">😴</div>
            <h4>Prioritise Sleep</h4>
            <p>7–9 hours of quality sleep per night boosts immunity, improves mood, and helps your body repair itself naturally.</p>
        </div>
        <div class="tip-card t4">
            <div class="tip-icon">🥦</div>
            <h4>Eat More Greens</h4>
            <p>Dark leafy vegetables are rich in iron, folate, and vitamins K and C. Aim for at least 2 servings every day.</p>
        </div>
        <div class="tip-card t5">
            <div class="tip-icon">🧴</div>
            <h4>Protect Your Skin</h4>
            <p>Apply sunscreen with SPF 30+ even on cloudy days. UV rays cause premature ageing and increase skin cancer risk.</p>
        </div>
    </div>

    <!-- FAQ ACCORDION -->
    <div class="accordion-section">
        <div class="sec-header">
            <h3><i class="fa-solid fa-circle-question" style="color:#0ea5e9;margin-right:8px;"></i>Health FAQs</h3>
            <a href="#" class="see-all">Browse all FAQs →</a>
        </div>

        <div class="accordion">

            <div class="accordion-item">
                <button class="accordion-btn" onclick="toggleAccordion(this)">
                    <div class="accordion-btn-left">
                        <div class="accordion-btn-icon" style="background:#fee2e2;">❤️</div>
                        <div>
                            <h5>What are the warning signs of a heart attack?</h5>
                            <p>Cardiovascular · 3 min read</p>
                        </div>
                    </div>
                    <i class="fa-solid fa-chevron-down accordion-chevron"></i>
                </button>
                <div class="accordion-body">
                    <p>A heart attack occurs when blood flow to part of the heart muscle is blocked. Recognising the signs early can save your life.</p>
                    <ul>
                        <li>Chest pain, pressure, squeezing, or tightness</li>
                        <li>Pain radiating to the left arm, jaw, neck, or back</li>
                        <li>Shortness of breath, even at rest</li>
                        <li>Nausea, cold sweats, or lightheadedness</li>
                        <li>Unusual fatigue lasting days (more common in women)</li>
                    </ul>
                    <p style="margin-top:10px;"><strong>If you experience these symptoms, call emergency services immediately. Every minute counts.</strong></p>
                    <a href="#" class="read-link">Read full article <i class="fa-solid fa-arrow-right"></i></a>
                </div>
            </div>

            <div class="accordion-item">
                <button class="accordion-btn" onclick="toggleAccordion(this)">
                    <div class="accordion-btn-left">
                        <div class="accordion-btn-icon" style="background:#ede9fe;">🧠</div>
                        <div>
                            <h5>How can I improve my mental health daily?</h5>
                            <p>Mental Health · 5 min read</p>
                        </div>
                    </div>
                    <i class="fa-solid fa-chevron-down accordion-chevron"></i>
                </button>
                <div class="accordion-body">
                    <p>Mental health is just as important as physical health. Small, consistent habits make a meaningful difference over time.</p>
                    <ul>
                        <li>Practice mindfulness or meditation for 10 minutes each morning</li>
                        <li>Maintain social connections — loneliness worsens anxiety and depression</li>
                        <li>Limit social media to under 60 minutes a day</li>
                        <li>Exercise at least 30 minutes, 5 days a week — it releases natural mood-boosting endorphins</li>
                        <li>Seek professional help when persistent sadness, anxiety, or hopelessness lasts more than 2 weeks</li>
                    </ul>
                    <a href="#" class="read-link">Read full article <i class="fa-solid fa-arrow-right"></i></a>
                </div>
            </div>

            <div class="accordion-item">
                <button class="accordion-btn" onclick="toggleAccordion(this)">
                    <div class="accordion-btn-left">
                        <div class="accordion-btn-icon" style="background:#dcfce7;">🥗</div>
                        <div>
                            <h5>What does a healthy diet actually look like?</h5>
                            <p>Nutrition · 6 min read</p>
                        </div>
                    </div>
                    <i class="fa-solid fa-chevron-down accordion-chevron"></i>
                </button>
                <div class="accordion-body">
                    <p>No single food is a magic bullet. A healthy diet is about consistent patterns and variety across food groups.</p>
                    <ul>
                        <li>Half your plate should be vegetables and fruits</li>
                        <li>Choose whole grains (brown rice, oats, whole wheat) over refined ones</li>
                        <li>Include lean protein: fish, legumes, poultry, or eggs</li>
                        <li>Limit ultra-processed foods, sugary drinks, and excess salt</li>
                        <li>Healthy fats (avocado, nuts, olive oil) are essential — avoid trans fats</li>
                    </ul>
                    <a href="#" class="read-link">Read full article <i class="fa-solid fa-arrow-right"></i></a>
                </div>
            </div>

            <div class="accordion-item">
                <button class="accordion-btn" onclick="toggleAccordion(this)">
                    <div class="accordion-btn-left">
                        <div class="accordion-btn-icon" style="background:#fef3c7;">🏃</div>
                        <div>
                            <h5>How much exercise do I really need each week?</h5>
                            <p>Fitness · 4 min read</p>
                        </div>
                    </div>
                    <i class="fa-solid fa-chevron-down accordion-chevron"></i>
                </button>
                <div class="accordion-body">
                    <p>The WHO recommends the following for adults aged 18–64:</p>
                    <ul>
                        <li>At least 150–300 minutes of moderate aerobic activity per week (brisk walking, cycling)</li>
                        <li>OR 75–150 minutes of vigorous aerobic activity (running, swimming)</li>
                        <li>Muscle-strengthening activities (weights, push-ups) on 2 or more days per week</li>
                        <li>Reduce sedentary time — some physical activity is better than none</li>
                    </ul>
                    <a href="#" class="read-link">Read full article <i class="fa-solid fa-arrow-right"></i></a>
                </div>
            </div>

            <div class="accordion-item">
                <button class="accordion-btn" onclick="toggleAccordion(this)">
                    <div class="accordion-btn-left">
                        <div class="accordion-btn-icon" style="background:#fee2e2;">🩹</div>
                        <div>
                            <h5>Basic first aid: what should every person know?</h5>
                            <p>First Aid · 7 min read</p>
                        </div>
                    </div>
                    <i class="fa-solid fa-chevron-down accordion-chevron"></i>
                </button>
                <div class="accordion-body">
                    <p>Knowing basic first aid can save a life before professional help arrives. Key skills every person should learn:</p>
                    <ul>
                        <li><strong>CPR</strong> — chest compressions at 100–120 per minute for cardiac arrest</li>
                        <li><strong>Choking</strong> — 5 back blows then 5 abdominal thrusts (Heimlich manoeuvre)</li>
                        <li><strong>Bleeding</strong> — apply firm, direct pressure with a clean cloth for at least 10 minutes</li>
                        <li><strong>Burns</strong> — cool with running water for 20 minutes; do NOT use ice or butter</li>
                        <li><strong>Fainting</strong> — lay the person flat, raise their legs 30 cm, loosen tight clothing</li>
                    </ul>
                    <a href="#" class="read-link">Read full article <i class="fa-solid fa-arrow-right"></i></a>
                </div>
            </div>

        </div>
    </div>

    <!-- VIDEO GUIDES -->
    <div class="sec-header">
        <h3><i class="fa-solid fa-circle-play" style="color:#0ea5e9;margin-right:8px;"></i>Video Health Guides</h3>
        <a href="#" class="see-all">See all videos →</a>
    </div>

    <div class="video-grid">

        <div class="video-card">
            <div class="video-wrapper">
                <video controls>
                    <source src="{{ asset('videos/blood-pressure.mp4') }}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
            <div class="video-body">
                <span class="article-tag tag-heart">Heart Health</span>
                <h5>How to Check Your Blood Pressure at Home</h5>
                <div class="video-meta">
                    <span><i class="fa-regular fa-clock"></i> 4:32</span>
                    <span><i class="fa-solid fa-user-doctor"></i> Dr. Mwansa</span>
                </div>
            </div>
        </div>

        <div class="video-card">
            <div class="video-wrapper">
                <video controls>
                    <source src="{{ asset('videos/breathing-exercise.mp4') }}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
            <div class="video-body">
                <span class="article-tag tag-mind">Mental Health</span>
                <h5>5-Minute Breathing Exercise for Anxiety Relief</h5>
                <div class="video-meta">
                    <span><i class="fa-regular fa-clock"></i> 5:10</span>
                    <span><i class="fa-solid fa-user-doctor"></i> Dr. Banda</span>
                </div>
            </div>
        </div>

        <div class="video-card">
            <div class="video-wrapper">
                <video controls>
                    <source src="{{ asset('videos/body-workout.mp4') }}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
            <div class="video-body">
                <span class="article-tag tag-fitness">Fitness</span>
                <h5>Full-Body Workout You Can Do at Home (No Equipment)</h5>
                <div class="video-meta">
                    <span><i class="fa-regular fa-clock"></i> 18:44</span>
                    <span><i class="fa-solid fa-user-doctor"></i> Dr. Phiri</span>
                </div>
            </div>
        </div>

    </div>

    <!-- DAILY TRACKER -->
    <div class="tracker-card">
        <div class="sec-header" style="margin-bottom:0;">
            <h3><i class="fa-solid fa-chart-line" style="color:#0ea5e9;margin-right:8px;"></i>Today's Wellness Checklist</h3>
            <span style="font-size:13px;color:var(--muted);" id="trackerDate"></span>
        </div>

        <div class="tracker-grid">
            <div class="tracker-item" onclick="toggleTracker(this)">
                <i>💧</i>
                <span>8 Glasses of Water</span>
                <small>Tap to mark done</small>
            </div>
            <div class="tracker-item" onclick="toggleTracker(this)">
                <i>🏃</i>
                <span>30 min Exercise</span>
                <small>Tap to mark done</small>
            </div>
            <div class="tracker-item" onclick="toggleTracker(this)">
                <i>🥗</i>
                <span>Eat 5 Fruits & Veg</span>
                <small>Tap to mark done</small>
            </div>
            <div class="tracker-item" onclick="toggleTracker(this)">
                <i>😴</i>
                <span>7+ Hours Sleep</span>
                <small>Tap to mark done</small>
            </div>
            <div class="tracker-item" onclick="toggleTracker(this)">
                <i>🧘</i>
                <span>10 min Mindfulness</span>
                <small>Tap to mark done</small>
            </div>
            <div class="tracker-item" onclick="toggleTracker(this)">
                <i>💊</i>
                <span>Take Medication</span>
                <small>Tap to mark done</small>
            </div>
        </div>

        <div class="tracker-progress">
            <div class="progress-label">
                <span>Daily progress</span>
                <span id="progressText">0 / 6 completed</span>
            </div>
            <div class="progress-bar">
                <div class="progress-fill" id="progressFill" style="width:0%"></div>
            </div>
        </div>
    </div>

</div><!-- /main -->

<script>
function toggleMenu(){
    document.getElementById('sidebar').classList.toggle('active');
}

document.getElementById('trackerDate').textContent =
    new Date().toLocaleDateString('en-GB',{weekday:'long',day:'numeric',month:'long',year:'numeric'});

function toggleAccordion(btn){
    const item = btn.closest('.accordion-item');
    const isOpen = item.classList.contains('open');
    document.querySelectorAll('.accordion-item').forEach(i => i.classList.remove('open'));
    if(!isOpen) item.classList.add('open');
}

function setCategory(cat, el){
    document.querySelectorAll('.pill').forEach(p => p.classList.remove('active'));
    el.classList.add('active');
    document.querySelectorAll('[data-category]').forEach(card => {
        card.style.display = (cat === 'all' || card.dataset.category === cat) ? '' : 'none';
    });
}

function filterArticles(){
    const q = document.getElementById('searchInput').value.toLowerCase();
    document.querySelectorAll('[data-category]').forEach(card => {
        const text = card.innerText.toLowerCase();
        card.style.display = text.includes(q) ? '' : 'none';
    });
}

function toggleTracker(el){
    el.classList.toggle('done');
    const items = document.querySelectorAll('.tracker-item');
    const done = document.querySelectorAll('.tracker-item.done').length;
    document.getElementById('progressText').textContent = done + ' / ' + items.length + ' completed';
    document.getElementById('progressFill').style.width = (done / items.length * 100) + '%';
    el.querySelector('small').textContent = el.classList.contains('done') ? '✅ Done!' : 'Tap to mark done';
}

function openArticle(slug){
    window.location.href = '/health-learn/' + slug;
}
</script>
</body>
</html>