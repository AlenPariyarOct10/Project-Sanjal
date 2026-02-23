<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $project->name }} - Nepal IT Project Hub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(["resources/css/app.css", "resources/js/app.js"])
</head>
<body class="bg-white text-gray-900 font-sans">
<!-- Header & Navigation -->
<header class="border-b border-gray-200 sticky top-0 z-50 bg-white">
    <div class="max-w-6xl mx-auto px-4">
        <nav class="flex justify-between items-center py-4">
            <div class="flex items-center gap-2 font-bold text-lg">
                <a href="/" class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-black text-white flex items-center justify-center text-sm font-bold">N</div>
                    <span>Nepal IT Project Hub</span>
                </a>
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

<main class="py-12 md:py-20">
    <div class="max-w-6xl mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            <!-- Left Column: Content -->
            <div class="lg:col-span-2">
                <div class="mb-8">
                    <h1 class="text-4xl md:text-5xl font-extrabold mb-4">{{ $project->name }}</h1>
                    <div class="flex flex-wrap gap-2 mb-6">
                        @foreach($project->tags as $tag)
                            <span class="px-3 py-1 bg-gray-100 text-gray-700 text-xs font-bold uppercase tracking-widest border border-gray-200">{{ $tag->name }}</span>
                        @endforeach
                    </div>
                </div>

                <div class="aspect-video bg-gray-100 mb-10 overflow-hidden border border-gray-200">
                    @if($project->image)
                        <img src="{{ asset('storage/' . $project->image) }}" alt="{{ $project->name }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-300">
                            <svg class="w-24 h-24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                    @endif
                </div>

                <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed mb-12">
                    <h2 class="text-2xl font-bold text-black mb-4">Project Description</h2>
                    <p>{{ $project->description }}</p>
                </div>
                
                @if($project->algorithms->count() > 0)
                <div class="mb-12">
                    <h2 class="text-2xl font-bold text-black mb-4">Algorithms & Subjects</h2>
                    <div class="flex flex-wrap gap-4">
                        @foreach($project->algorithms as $algo)
                            <div class="bg-gray-50 p-4 border border-gray-200 flex-1 min-w-[200px]">
                                <h4 class="font-bold text-sm">{{ $algo->name }}</h4>
                                <p class="text-xs text-gray-500">{{ $algo->code }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <!-- Right Column: Sidebar -->
            <div class="lg:col-span-1">
                <div class="sticky top-28">
                    <div class="bg-white border border-gray-200 p-8 mb-6">
                        <h3 class="font-bold text-xl mb-6">Links & Resources</h3>
                        <div class="flex flex-col gap-4">
                            @if($project->github_url)
                                <a href="{{ $project->github_url }}" target="_blank" class="flex items-center justify-center gap-2 bg-gray-900 text-white font-bold py-3 px-6 hover:bg-black transition-colors">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/></svg>
                                    GitHub Repo
                                </a>
                            @endif
                            @if($project->live_demo_url)
                                <a href="{{ $project->live_demo_url }}" target="_blank" class="flex items-center justify-center gap-2 border-2 border-black text-black font-bold py-3 px-6 hover:bg-gray-50 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                    Live Demo
                                </a>
                            @endif
                        </div>
                    </div>

                    <div class="bg-gray-50 border border-gray-200 p-8">
                        <h3 class="font-bold text-lg mb-4">Project Details</h3>
                        <div class="space-y-4 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-500">Submitted By</span>
                                <span class="font-bold">{{ $project->user ? $project->user->name : 'Anonymous' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Date</span>
                                <span class="font-bold">{{ $project->created_at->format('M d, Y') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Visibility</span>
                                <span class="font-bold">{{ $project->is_private ? 'Private' : 'Public' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

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

</body>
</html>
