<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProjectSanjal - Share & Collaborate IT Projects</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @if($system_logo)
        <link rel="icon" type="image/x-icon" href="{{ $system_logo }}">
    @endif

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Outfit:wght@400;600;700;800&display=swap');

        :root {
            --primary: #4f46e5;
            --primary-light: #e0e7ff;
            --secondary: #db2777;
            --accent: #0d9488;
            --bg-light: #f8fafc;
            --bg-card: #ffffff;
            --border-soft: #f1f5f9;
            --text-main: #0f172a;
            --text-soft: #475569;
            --text-muted: #94a3b8;
        }

        * {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Outfit', sans-serif;
        }

        body {
            background-color: var(--bg-light);
            color: var(--text-main);
            background-image:
                radial-gradient(at 0% 0%, hsla(253,16%,7%,0) 0, hsla(253,16%,7%,0) 50%, hsla(253,16%,7%,0.05) 100%),
                radial-gradient(at 50% 0%, hsla(225,39%,30%,0) 0, hsla(225,39%,30%,0) 50%, hsla(225,39%,30%,0.05) 100%);
        }

        .gradient-text {
            background: linear-gradient(135deg, #4f46e5 0%, #db2777 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .gradient-btn {
            background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .gradient-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(79, 70, 229, 0.4);
        }

        .card-premium {
            background: white;
            border: 1px solid var(--border-soft);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .card-premium:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            border-color: rgba(79, 70, 229, 0.2);
        }

        .tech-badge {
            background: rgba(79, 70, 229, 0.05);
            border: 1px solid rgba(79, 70, 229, 0.1);
            color: var(--primary);
        }

        .float-animation {
            animation: float 4s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(2deg); }
        }

        .glass-nav {
            backdrop-filter: blur(12px);
            background: rgba(255, 255, 255, 0.8);
            border-bottom: 1px solid rgba(241, 245, 249, 1);
        }

        .hero-img-box {
            position: relative;
            width: 160px;
            height: 160px;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 20px 50px rgba(0,0,0,0.1);
            border: 4px solid white;
        }

        .hero-img-box img {
            width: 100%;
            height: 100%;
            object-cover: cover;
            transition: transform 0.5s ease;
        }

        .hero-img-box:hover img {
            transform: scale(1.1);
        }

        .dot-pattern {
            background-image: radial-gradient(#e2e8f0 1px, transparent 1px);
            background-size: 24px 24px;
        }
    </style>
    @vite(["resources/css/app.css", "resources/js/app.js"])
</head>
<body class="overflow-x-hidden dot-pattern">

<!-- Background Accents -->
<div class="fixed inset-0 overflow-hidden pointer-events-none -z-10">
    <div class="absolute -top-40 -right-40 w-96 h-96 bg-indigo-50 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-pulse"></div>
    <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-pink-50 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-pulse" style="animation-delay: 2s;"></div>
</div>

<!-- Header -->
<header class="glass-nav sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex justify-between items-center py-4">
            <div class="flex items-center gap-3">
                <a href="/" class="flex items-center gap-3 group">
                    @if($system_logo)
                        <img src="{{ $system_logo }}" alt="{{ $system_name }}" class="w-10 h-10 object-contain group-hover:rotate-12 transition-transform">
                    @else
                        <div class="w-10 h-10 bg-indigo-600 text-white flex items-center justify-center text-sm font-bold rounded-xl group-hover:rotate-12 transition-transform shadow-lg shadow-indigo-200">
                            {{ substr($system_name, 0, 1) }}
                        </div>
                    @endif
                    <span class="text-slate-900 font-bold text-xl tracking-tight">{{ $system_name }}</span>
                </a>
            </div>

            <ul class="hidden md:flex gap-8 items-center">
                <li><a href="#home" class="text-slate-600 font-semibold text-sm hover:text-indigo-600 transition-colors">Home</a></li>
                <li><a href="{{ route('projects.index') }}" class="text-slate-600 font-semibold text-sm hover:text-indigo-600 transition-colors">Browse</a></li>
                <li><a href="{{ route('colleges.index') }}" class="text-slate-600 font-semibold text-sm hover:text-indigo-600 transition-colors">Colleges</a></li>
                <li><a href="{{ route('users.contributors') }}" class="text-slate-600 font-semibold text-sm hover:text-indigo-600 transition-colors">Contributors</a></li>

                @if(auth()->guard('client')->check() || auth()->guard('web')->check())
                    <li><a href="{{ route('client.dashboard') }}" class="text-slate-600 font-semibold text-sm hover:text-indigo-600 transition-colors">Dashboard</a></li>
                    <li><a href="{{ route('client.projects.create') }}" class="gradient-btn text-white font-bold px-6 py-2.5 rounded-full text-sm shadow-md">Submit Project</a></li>
                @else
                    <li><a href="{{ route('client.login') }}" class="text-slate-600 font-semibold text-sm hover:text-indigo-600 transition-colors">Login</a></li>
                    <li><a href="{{ route('client.register') }}" class="gradient-btn text-white font-bold px-7 py-2.5 rounded-full text-sm shadow-lg shadow-indigo-100">Get Started</a></li>
                @endif
            </ul>

            <button class="md:hidden text-slate-900" id="navToggle" onclick="document.getElementById('mobileNav').classList.toggle('hidden')">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
            </button>
        </nav>
    </div>

    <!-- Mobile Navigation -->
    <div id="mobileNav" class="hidden md:hidden bg-white border-b p-6 space-y-4">
        <a href="#home" class="block text-slate-600 font-semibold">Home</a>
        <a href="{{ route('projects.index') }}" class="block text-slate-600 font-semibold">Browse</a>
        <a href="{{ route('colleges.index') }}" class="block text-slate-600 font-semibold">Colleges</a>
        <a href="{{ route('users.contributors') }}" class="block text-slate-600 font-semibold">Contributors</a>
        <hr class="border-slate-100">
        @if(auth()->check())
            <a href="{{ route('client.dashboard') }}" class="block text-slate-600 font-semibold">Dashboard</a>
            <a href="{{ route('client.projects.create') }}" class="block gradient-btn text-white text-center py-3 rounded-xl font-bold">Submit Project</a>
        @else
            <a href="{{ route('client.login') }}" class="block text-slate-600 font-semibold">Login</a>
            <a href="{{ route('client.register') }}" class="block gradient-btn text-white text-center py-3 rounded-xl font-bold">Get Started</a>
        @endif
    </div>
</header>

<!-- Hero Section -->
<section class="relative py-10 lg:py-22 px-4 overflow-hidden" id="home">
    <div class="max-w-7xl mx-auto">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
            <div class="relative z-10">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-green-50 border border-green-100 text-green-700 text-xs font-bold mb-8">
                    <span class="flex h-2 w-2 rounded-full bg-green-500 animate-ping"></span>
                    NEPAL'S LARGEST IT HUB
                </div>

                <h1 class="text-6xl md:text-7xl font-extrabold text-slate-900 mb-8 leading-[1.1]">
                    Showcase Your<br>
                    <span class="gradient-text">IT Projects</span>
                </h1>

                <p class="text-slate-600 text-xl mb-10 leading-relaxed max-w-xl">
                    Discover, showcase, and collaborate on the most innovative IT projects from students across Nepal. Join the community of future tech leaders.
                </p>

                <div class="flex gap-4 flex-wrap">
                    <a href="{{ route('projects.index') }}" class="gradient-btn text-white font-bold px-10 py-4 rounded-2xl text-lg shadow-xl shadow-indigo-100">
                        Explore Now
                    </a>
                    <a href="{{ route('client.projects.create') }}" class="bg-white text-slate-900 border border-slate-200 font-bold px-10 py-4 rounded-2xl text-lg hover:border-indigo-600 hover:text-indigo-600 transition-all">
                        Submit Work
                    </a>
                </div>

                <!-- Stats -->
                <div class="flex gap-10 mt-8 pt-6 border-t border-slate-100 text-left">
                    <div class="pe-6 border-r border-slate-100">
                        <p class="text-3xl font-black text-slate-900">{{ number_format($total_projects) }}+</p>
                        <p class="text-slate-500 text-sm font-semibold tracking-wide uppercase mt-1">Projects</p>
                    </div>
                    <div>
                        <p class="text-3xl font-black text-indigo-600">{{ number_format($total_innovators) }}+</p>
                        <p class="text-slate-500 text-sm font-semibold tracking-wide uppercase mt-1">Innovators</p>
                    </div>
                </div>
            </div>

            <div class="hidden lg:block relative">
                <!-- Floating Boxes with Real Images -->
                <div class="relative h-[600px]">
                    <!-- Top Left: Coding -->
                    <div class="absolute top-0 left-0 hero-img-box float-animation border-indigo-100" style="animation-duration: 5s; width: 270px; height: 270px;">
                        <img src="{{ asset('images/hero/cs2.png') }}" alt="Coding">
                    </div>

                    <!-- Top Right: Design -->
                    <div class="absolute top-20 right-10 hero-img-box float-animation" style="animation-delay: 1s; animation-duration: 6s; width: 270px; height: 270px;">
                        <img src="{{ asset('images/hero/cs4.jpg') }}" alt="Design">
                    </div>

                    <!-- Bottom Right: Rocket/Success -->
                    <div class="absolute bottom-10 right-0 hero-img-box float-animation" style="animation-delay: 2s; animation-duration: 4s; width: 270px; height: 270px;">
                        <img src="{{ asset('images/hero/cs3.png') }}" alt="Innovation">
                    </div>

                    <!-- Left Center: Speed -->
                    <div class="absolute top-1/2 -left-10 hero-img-box float-animation" style="animation-delay: 1.5s; animation-duration: 7s; width: 270px; height: 270px;">
                        <img src="{{ asset('images/hero/cs.jpg') }}" alt="Speed">
                    </div>

                    <!-- Central Accent -->
                    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-80 h-80 bg-gradient-to-br from-indigo-500/10 to-pink-500/10 rounded-full blur-3xl -z-10"></div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Popular Projects -->
<section class="py-24 bg-white relative">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-6">
            <div class="max-w-2xl">
                <h2 class="text-4xl md:text-5xl font-extrabold text-slate-900 mb-6">Trending Projects</h2>
                <p class="text-slate-600 text-lg">Handpicked popular innovations from our talented community.</p>
            </div>
            <a href="{{ route('projects.index') }}" class="group flex items-center gap-2 text-indigo-600 font-bold hover:gap-3 transition-all">
                See all projects
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($popular_projects as $project)
                <div class="card-premium rounded-2xl overflow-hidden group">
                    <a href="{{ route('projects.show', $project->slug) }}" class="block">
                        <div class="aspect-video overflow-hidden bg-slate-100">
                            @if($project->image)
                                <img src="{{ asset('storage/' . $project->image) }}" alt="{{ $project->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-indigo-50">
                                    <svg class="w-12 h-12 text-indigo-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                            @endif
                        </div>
                        <div class="p-5">
                            <h3 class="text-lg font-bold text-slate-900 mb-2 line-clamp-1 group-hover:text-indigo-600 transition-colors">{{ $project->name }}</h3>
                            <p class="text-slate-600 text-sm mb-4 line-clamp-2 leading-relaxed">{{ $project->description }}</p>

                            <div class="flex flex-wrap gap-2 mb-4">
                                @foreach($project->tags->take(2) as $tag)
                                    <span class="text-[10px] uppercase tracking-widest font-extrabold px-2 py-1 rounded-lg bg-slate-50 text-slate-500 border border-slate-100">{{ $tag->name }}</span>
                                @endforeach
                            </div>

                            <div class="flex items-center justify-between pt-4 border-t border-slate-50">
                                <div class="flex items-center gap-2">
                                    <div class="p-1.5 rounded-lg bg-pink-50 text-pink-600">
                                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"></path></svg>
                                    </div>
                                    <span class="font-bold text-sm text-slate-900">{{ $project->likes_count }}</span>
                                </div>
                                <span class="text-indigo-600 font-bold text-xs">View Project &rarr;</span>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Active Institutions -->
<section class="py-24 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-extrabold text-slate-900 mb-6">Partner Institutions</h2>
            <p class="text-slate-600 max-w-xl mx-auto">Colleges and universities driving technical excellence across Nepal.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($top_colleges as $college)
                <a href="{{ route('colleges.show', $college->id) }}"
                   class="card-premium p-10 flex flex-col items-center text-center rounded-[2.5rem]">

                    <div class="w-24 h-24 mb-8 rounded-3xl flex items-center justify-center
                    shadow-xl overflow-hidden
                    {{ $college->logo ? 'bg-white' : 'bg-indigo-600 text-white text-4xl font-black' }}">

                        @if($college->logo)
                            <img src="{{ asset('storage/'.$college->logo) }}"
                                 alt="{{ $college->name }}"
                                 class="w-full h-full object-contain p-2">
                        @else
                            {{ strtoupper(substr($college->name, 0, 1)) }}
                        @endif

                    </div>

                    <h3 class="text-2xl font-bold text-slate-900 mb-2">
                        {{ $college->name }}
                    </h3>

                    <p class="text-indigo-600 font-extrabold text-xs uppercase tracking-[0.2em]">
                        {{ $college->users_count }} Developers
                    </p>

                </a>
            @endforeach        </div>
    </div>
</section>

<!-- CTA -->
<section class="py-24 px-4">
    <div class="max-w-5xl mx-auto bg-slate-900 rounded-[3rem] p-12 lg:p-20 text-center relative overflow-hidden shadow-2xl">
        <div class="absolute top-0 right-0 w-64 h-64 bg-indigo-600/20 rounded-full blur-[100px]"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-pink-600/20 rounded-full blur-[100px]"></div>

        <div class="relative z-10">
            <h2 class="text-4xl md:text-5xl font-black text-white mb-8">Ready to showcase your talent?</h2>
            <p class="text-slate-400 text-lg mb-12 max-w-2xl mx-auto leading-relaxed">Join the most active IT student community and get noticed by industry experts and peers.</p>
            <div class="flex gap-4 flex-wrap justify-center">
                <a href="{{ route('client.projects.create') }}" class="gradient-btn text-white font-bold px-12 py-5 rounded-2xl text-lg">Submit Project</a>
                <a href="{{ route('projects.index') }}" class="bg-slate-800 text-white font-bold px-12 py-5 rounded-2xl text-lg hover:bg-slate-700 transition-all">Explore Platform</a>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="bg-white pt-24 pb-12 border-t border-slate-100">
    <div class="max-w-7xl mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-16 mb-20">
            <div class="col-span-1 lg:col-span-2">
                <a href="/" class="flex items-center gap-3 mb-8">
                    @if($system_logo)
                        <img src="{{ $system_logo }}" alt="{{ $system_name }}" class="w-10 h-10 object-contain">
                    @else
                        <div class="w-10 h-10 bg-indigo-600 text-white flex items-center justify-center text-sm font-bold rounded-xl">{{ substr($system_name, 0, 1) }}</div>
                    @endif
                    <span class="text-slate-900 font-extrabold text-2xl">{{ $system_name }}</span>
                </a>
                <p class="text-slate-500 text-lg max-w-sm leading-relaxed">Bridging the gap between students, colleges, and the professional tech ecosystem in Nepal.</p>
            </div>

            <div>
                <h4 class="text-slate-900 font-bold uppercase tracking-widest text-xs mb-8">Navigation</h4>
                <ul class="space-y-4">
                    <li><a href="{{ route('projects.index') }}" class="text-slate-500 hover:text-indigo-600 font-semibold transition-colors">Browse Projects</a></li>
                    <li><a href="{{ route('colleges.index') }}" class="text-slate-500 hover:text-indigo-600 font-semibold transition-colors">Colleges</a></li>
                    <li><a href="{{ route('client.projects.create') }}" class="text-slate-500 hover:text-indigo-600 font-semibold transition-colors">Submit Work</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-slate-900 font-bold uppercase tracking-widest text-xs mb-8">Reach Out</h4>
                <p class="text-slate-500 font-semibold mb-2">support@projectsanjal.com.np</p>
                <p class="text-slate-500 font-semibold">Kathmandu, Nepal</p>
            </div>
        </div>

        <div class="pt-10 border-t border-slate-50 flex flex-col md:flex-row justify-between items-center gap-6">
            <p class="text-slate-400 font-medium">&copy; {{ date('Y') }} {{ $system_name }}.</p>
            <div class="flex gap-8">
                <a href="#" class="text-slate-400 hover:text-indigo-600 text-sm font-bold">Privacy</a>
                <a href="#" class="text-slate-400 hover:text-indigo-600 text-sm font-bold">Terms</a>
            </div>
        </div>
    </div>
</footer>

<script>
    // Smooth scroll for internal links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({ behavior: 'smooth' });
            }
        });
    });
</script>
</body>
</html>
