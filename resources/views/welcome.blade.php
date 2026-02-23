<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nepal IT Project Hub - Share & Collaborate IT Projects</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(["resources/css/app.css", "resources/js/app.js"])
</head>
<body class="bg-white text-gray-900 font-sans">
<!-- Header & Navigation -->
<header class="border-b border-gray-200 sticky top-0 z-50 bg-white">
    <div class="max-w-6xl mx-auto px-4">
        <nav class="flex justify-between items-center py-4">
            <div class="flex items-center gap-2 font-bold text-lg">
                <div class="w-8 h-8 bg-black text-white flex items-center justify-center text-sm font-bold">N</div>
                <span>Nepal IT Project Hub</span>
            </div>
            <ul class="hidden md:flex gap-6 list-none items-center" id="navLinks">
                <li><a href="/" class="text-gray-600 font-medium text-sm hover:text-black hover:underline">Home</a></li>
                <li><a href="{{ route('projects.index') }}" class="text-gray-600 font-medium text-sm hover:text-black hover:underline">Browse Projects</a></li>
                
                @if(auth()->guard('client')->check() || auth()->guard('web')->check())
                    <li><a href="{{ route('client.dashboard') }}" class="text-gray-600 font-medium text-sm hover:text-black hover:underline">Dashboard</a></li>
                    <li><a href="{{ route('client.projects.index') }}" class="text-gray-600 font-medium text-sm hover:text-black hover:underline">My Projects</a></li>
                    <li>
                        <form method="POST" action="{{ route('client.logout') }}">
                            @csrf
                            <button type="submit" class="text-gray-600 font-medium text-sm hover:text-black hover:underline bg-transparent border-none p-0 cursor-pointer">Logout</button>
                        </form>
                    </li>
                    <li><a href="{{ route('client.projects.create') }}" class="bg-black text-white font-semibold px-4 py-2">Submit Project</a></li>
                @else
                    <li><a href="{{ route('client.login') }}" class="text-gray-600 font-medium text-sm hover:text-black hover:underline">Login</a></li>
                    <li><a href="{{ route('client.register') }}" class="bg-black text-white font-semibold px-4 py-2">Get Started</a></li>
                @endif
            </ul>
            <button class="md:hidden flex flex-col gap-1 cursor-pointer bg-none border-none" id="navToggle" onclick="document.getElementById('mobileNav').classList.toggle('hidden')">
                <span class="w-6 h-0.5 bg-gray-900"></span>
                <span class="w-6 h-0.5 bg-gray-900"></span>
                <span class="w-6 h-0.5 bg-gray-900"></span>
            </button>
        </nav>
    </div>
    <!-- Mobile Nav -->
    <div id="mobileNav" class="hidden md:hidden bg-white border-t border-gray-100 p-4">
        <ul class="flex flex-col gap-4 list-none">
            <li><a href="/" class="text-gray-600 font-medium text-sm">Home</a></li>
            <li><a href="{{ route('projects.index') }}" class="text-gray-600 font-medium text-sm">Browse Projects</a></li>
            @if(auth()->check())
                <li><a href="{{ route('client.dashboard') }}" class="text-gray-600 font-medium text-sm">Dashboard</a></li>
                <li><a href="{{ route('client.projects.create') }}" class="bg-black text-white font-semibold px-4 py-2 inline-block">Submit Project</a></li>
            @else
                <li><a href="{{ route('client.login') }}" class="text-gray-600 font-medium text-sm">Login</a></li>
                <li><a href="{{ route('client.register') }}" class="bg-black text-white font-semibold px-4 py-2 inline-block text-center">Get Started</a></li>
            @endif
        </ul>
    </div>
</header>

<!-- Hero Section -->
<section class="border-b border-gray-200 py-12 md:py-24" id="home">
    <div class="max-w-6xl mx-auto px-4 text-center">
        <h1 class="text-4xl md:text-6xl font-extrabold mb-6 tracking-tight">Platform for IT Students of Nepal to Share Projects</h1>
        <p class="text-gray-600 text-xl mb-8 max-w-2xl mx-auto leading-relaxed">Showcase your academic and personal projects. Collaborate with peers from across the country. Learn from the best.</p>
        <div class="flex gap-4 justify-center flex-wrap">
            <a href="{{ route('projects.index') }}" class="bg-black text-white font-bold px-8 py-4 text-lg hover:bg-gray-800 transition-colors">Explore Projects</a>
            <a href="{{ route('client.projects.create') }}" class="border-2 border-black text-black font-bold px-8 py-4 text-lg hover:bg-gray-100 transition-colors">Submit Project</a>
        </div>
    </div>
</section>

<!-- Popular Projects Section -->
<section class="py-16 md:py-24" id="popular">
    <div class="max-w-6xl mx-auto px-4">
        <div class="flex justify-between items-end mb-12">
            <div>
                <h2 class="text-3xl font-bold mb-2">Popular Projects</h2>
                <p class="text-gray-500">Most liked and discussed projects this month.</p>
            </div>
            <a href="{{ route('projects.index') }}" class="text-black font-bold border-b-2 border-black pb-1 hover:text-gray-600 hover:border-gray-600 transition-all">View All</a>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($popular_projects as $project)
                <div class="group bg-white border border-gray-200 hover:border-black transition-all duration-300">
                    <div class="aspect-video overflow-hidden bg-gray-100">
                        @if($project->image)
                            <img src="{{ asset('storage/' . $project->image) }}" alt="{{ $project->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-300 bg-gray-50">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                        @endif
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-3 group-hover:text-blue-600 transition-colors">{{ $project->name }}</h3>
                        <p class="text-gray-600 text-sm line-clamp-2 mb-4">{{ $project->description }}</p>
                        
                        <div class="flex flex-wrap gap-2 mb-6">
                            @foreach($project->tags->take(3) as $tag)
                                <span class="px-2 py-1 bg-gray-50 text-gray-500 border border-gray-100 text-[10px] font-bold uppercase tracking-wider">{{ $tag->name }}</span>
                            @endforeach
                        </div>
                        
                        <div class="border-t border-gray-100 pt-4 flex justify-between items-center">
                            <a href="{{ route('projects.show', $project->slug) }}" class="bg-black text-white font-bold px-4 py-2 text-xs hover:bg-gray-800 transition-colors">Details</a>
                            <div class="flex items-center gap-1 text-gray-400 text-sm">
                                <svg class="w-4 h-4 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"></path></svg>
                                <span class="font-bold text-gray-900">{{ $project->likes_count }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Top Technologies Section -->
<section class="bg-gray-50 py-16 md:py-24">
    <div class="max-w-6xl mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold mb-4">Top Technologies</h2>
            <p class="text-gray-500">Filter projects by popular stacks being used in Nepal.</p>
        </div>
        <div class="flex flex-wrap gap-4 justify-center">
            @foreach($top_technologies as $tag)
                <a href="{{ route('projects.index', ['search' => $tag->name]) }}" class="px-6 py-3 bg-white border border-gray-200 hover:border-black hover:shadow-md transition-all font-bold text-gray-800 flex items-center gap-2">
                    {{ $tag->name }}
                    <span class="text-[10px] bg-gray-100 px-1.5 py-0.5 rounded text-gray-500">{{ $tag->projects_count }}</span>
                </a>
            @endforeach
        </div>
    </div>
</section>

<!-- Top Colleges Section -->
<section class="py-16 md:py-24" id="colleges">
    <div class="max-w-6xl mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold mb-4">Active Institutions</h2>
            <p class="text-gray-500">Colleges contributing most to the Nepal IT ecosystem.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($top_colleges as $college)
                <div class="bg-white border border-gray-100 p-8 text-center hover:border-black hover:shadow-xl transition-all duration-300">
                    <div class="w-24 h-24 bg-gray-50 mx-auto mb-6 flex items-center justify-center text-4xl font-black text-black border-2 border-gray-100 rounded-full">
                        {{ strtoupper(substr($college->name, 0, 1)) }}
                    </div>
                    <h3 class="text-xl font-bold mb-2">{{ $college->name }}</h3>
                    <p class="text-gray-400 text-sm uppercase font-bold tracking-widest">{{ $college->users_count }} INNOVATORS</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="bg-black text-white py-16 mt-12">
    <div class="max-w-6xl mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
            <div class="col-span-1 md:col-span-2">
                <div class="flex items-center gap-2 font-bold text-2xl mb-6">
                    <div class="w-10 h-10 bg-white text-black flex items-center justify-center text-lg font-black">N</div>
                    <span>Nepal IT Project Hub</span>
                </div>
                <p class="text-gray-400 text-lg leading-relaxed max-w-md">Bridging the gap between academic learning and industry visibility for the next generation of Nepalese developers.</p>
            </div>
            <div>
                <h4 class="font-bold text-sm uppercase tracking-widest mb-6 text-gray-500">Quick Links</h4>
                <ul class="text-gray-300 space-y-4 font-medium">
                    <li><a href="{{ route('projects.index') }}" class="hover:text-white transition-colors">Browse Projects</a></li>
                    <li><a href="{{ route('client.projects.create') }}" class="hover:text-white transition-colors">Submit Project</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Community Guidelines</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold text-sm uppercase tracking-widest mb-6 text-gray-500">Contact</h4>
                <ul class="text-gray-300 space-y-4 font-medium">
                    <li>support@projecthub.com.np</li>
                    <li>Kathmandu, Nepal</li>
                </ul>
            </div>
        </div>
        <div class="border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center text-gray-500 text-sm gap-4">
            <p>&copy; {{ date('Y') }} Nepal IT Project Hub. All rights reserved.</p>
            <div class="flex gap-6">
                <a href="#" class="hover:text-white">Privacy Policy</a>
                <a href="#" class="hover:text-white">Terms of Service</a>
            </div>
        </div>
    </div>
</footer>

<script>
    // Navigation improvements can be added here if needed
</script>
</body>
</html>
