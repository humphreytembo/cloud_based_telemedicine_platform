<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ $article['title'] }} – MediCare+</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<style>
*{margin:0;padding:0;box-sizing:border-box;}
body{font-family:'Segoe UI',sans-serif;background:#f1f5f9;color:#1e293b;}

.sidebar{width:260px;height:100vh;position:fixed;top:0;left:0;background:linear-gradient(to bottom,#0f172a,#1e293b);color:#fff;padding-top:20px;z-index:1000;transition:.3s;overflow-y:auto;}
.logo{text-align:center;padding:10px 20px 30px;border-bottom:1px solid rgba(255,255,255,.08);}
.logo h2{font-size:24px;color:#38bdf8;}
.logo p{font-size:13px;color:#94a3b8;margin-top:5px;}
.sidebar-links{margin-top:20px;}
.sidebar a{display:flex;align-items:center;gap:14px;color:#cbd5e1;text-decoration:none;padding:15px 25px;margin:5px 12px;border-radius:12px;transition:.3s;font-size:15px;}
.sidebar a:hover,.sidebar a.active{background:#0ea5e9;color:#fff;transform:translateX(5px);}
.sidebar a i{font-size:18px;}

.main{margin-left:260px;padding:25px;transition:.3s;}

.topbar{background:white;border-radius:18px;padding:18px 25px;display:flex;justify-content:space-between;align-items:center;box-shadow:0 5px 20px rgba(0,0,0,.05);margin-bottom:30px;}
.menu-toggle{display:none;font-size:24px;cursor:pointer;}

.article-wrap{max-width:780px;}

.article-header{background:white;border-radius:20px;padding:35px;box-shadow:0 5px 20px rgba(0,0,0,.05);margin-bottom:25px;}
.back-link{display:inline-flex;align-items:center;gap:8px;color:#0ea5e9;font-size:13px;font-weight:600;text-decoration:none;margin-bottom:20px;}
.back-link:hover{text-decoration:underline;}
.article-tag{display:inline-block;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.07em;padding:5px 14px;border-radius:20px;margin-bottom:16px;}
.tag-heart{background:#fce7f3;color:#9d174d;}
.tag-mind{background:#ede9fe;color:#7c3aed;}
.tag-nutrition{background:#dcfce7;color:#166534;}
.tag-fitness{background:#fef3c7;color:#92400e;}
.tag-prevention{background:#dbeafe;color:#1e40af;}
.tag-first-aid{background:#fee2e2;color:#991b1b;}

.article-header h1{font-size:28px;line-height:1.3;margin-bottom:15px;}
.article-meta{display:flex;align-items:center;gap:16px;font-size:13px;color:#64748b;flex-wrap:wrap;}
.avatar{width:32px;height:32px;border-radius:50%;background:#0ea5e9;color:white;font-size:12px;font-weight:700;display:flex;align-items:center;justify-content:center;}

.article-body{background:white;border-radius:20px;padding:35px;box-shadow:0 5px 20px rgba(0,0,0,.05);margin-bottom:25px;}
.article-body p{font-size:16px;line-height:1.85;color:#334155;margin-bottom:18px;}
.article-body h2{font-size:20px;margin:28px 0 12px;color:#0f172a;}
.article-body ul{padding-left:22px;margin-bottom:18px;}
.article-body ul li{font-size:15px;line-height:1.8;color:#334155;margin-bottom:4px;}
.article-body blockquote{border-left:4px solid #0ea5e9;padding:16px 20px;background:#f0f9ff;border-radius:0 12px 12px 0;margin:20px 0;font-style:italic;color:#0369a1;}

.cta-box{background:linear-gradient(135deg,#0f172a,#0369a1);border-radius:20px;padding:30px;color:white;text-align:center;margin-bottom:25px;}
.cta-box h3{font-size:20px;margin-bottom:8px;}
.cta-box p{font-size:14px;color:#bae6fd;margin-bottom:20px;}
.cta-box a{background:#0ea5e9;color:white;padding:13px 28px;border-radius:12px;text-decoration:none;font-weight:600;font-size:15px;transition:.2s;display:inline-block;}
.cta-box a:hover{background:#0284c7;}

.related-section h3{font-size:20px;margin-bottom:16px;}
.related-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(230px,1fr));gap:16px;}
.related-card{background:white;border-radius:16px;padding:20px;box-shadow:0 5px 20px rgba(0,0,0,.05);transition:.3s;text-decoration:none;color:inherit;display:block;}
.related-card:hover{transform:translateY(-4px);}
.related-card h5{font-size:14px;font-weight:600;margin:10px 0 6px;line-height:1.4;}
.related-card span{font-size:12px;color:#64748b;}

@media(max-width:768px){
    .sidebar{left:-260px;}
    .sidebar.active{left:0;}
    .main{margin-left:0;padding:15px;}
    .menu-toggle{display:block;}
    .article-header h1{font-size:22px;}
}
</style>
</head>
<body>

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

<div class="main">

    <div class="topbar">
        <div style="display:flex;align-items:center;gap:15px;">
            <span class="menu-toggle" onclick="document.getElementById('sidebar').classList.toggle('active')">
                <i class="fa-solid fa-bars"></i>
            </span>
            <div>
                <h2 style="font-size:20px;">{{ $article['title'] }}</h2>
                <p style="color:#64748b;font-size:13px;margin-top:3px;">Health Learning Centre</p>
            </div>
        </div>
        <a href="{{ route('health.learn') }}" style="background:#0ea5e9;color:white;padding:11px 18px;border-radius:10px;text-decoration:none;font-weight:600;font-size:13px;">
            <i class="fa-solid fa-arrow-left"></i> Back
        </a>
    </div>

    <div class="article-wrap">

        <!-- ARTICLE HEADER -->
        <div class="article-header">
            <a href="{{ route('health.learn') }}" class="back-link">
                <i class="fa-solid fa-arrow-left"></i> Back to Health Learning
            </a>

            <span class="article-tag tag-{{ $article['category'] }}">{{ $article['tag'] }}</span>

            <h1>{{ $article['title'] }}</h1>

            <div class="article-meta">
                <div class="avatar">{{ strtoupper(substr($article['author'], 3, 2)) }}</div>
                <span>{{ $article['author'] }}</span>
                <span>·</span>
                <span><i class="fa-regular fa-clock"></i> {{ $article['read_time'] }}</span>
                <span>·</span>
                <span>{{ $article['date'] }}</span>
            </div>
        </div>

        <!-- ARTICLE BODY -->
        <div class="article-body">
            {{-- When you move content to a database, use {!! $article['content'] !!} for HTML --}}
            <p>{{ $article['excerpt'] }}</p>

            <h2>Overview</h2>
            <p>{{ $article['content'] }}</p>

            <blockquote>
                "Prevention is better than cure. Small, consistent habits compound into extraordinary health outcomes over time."
            </blockquote>

            <h2>Key Takeaways</h2>
            <ul>
                <li>Regular check-ups catch problems before they become serious.</li>
                <li>Lifestyle changes are more powerful than most medications.</li>
                <li>Consult your doctor before making major changes to your diet or exercise routine.</li>
                <li>Mental and physical health are deeply interconnected — treat both.</li>
            </ul>

            <p>For personalised advice, consult one of our qualified doctors via the platform's consultation feature.</p>
        </div>

        <!-- CTA -->
        <div class="cta-box">
            <h3>Have questions about this topic?</h3>
            <p>Our doctors are available for a consultation right now.</p>
            <a href="/doctors/consult">
                <i class="fa-solid fa-user-doctor"></i> &nbsp;Consult a Doctor
            </a>
        </div>

        <!-- RELATED ARTICLES -->
        @if(count($related) > 0)
        <div class="related-section">
            <h3>Related Articles</h3>
            <div class="related-grid">
                @foreach($related as $rel)
                <a href="{{ route('health.learn.article', $rel['slug']) }}" class="related-card">
                    <span class="article-tag tag-{{ $rel['category'] }}" style="font-size:10px;padding:4px 10px;">{{ $rel['tag'] }}</span>
                    <h5>{{ $rel['title'] }}</h5>
                    <span><i class="fa-regular fa-clock"></i> {{ $rel['read_time'] }}</span>
                </a>
                @endforeach
            </div>
        </div>
        @endif

    </div>
</div>
</body>
</html>