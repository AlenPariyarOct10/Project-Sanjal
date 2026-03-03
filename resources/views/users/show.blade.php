<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $user->name }} - Profile | ProjectSanjal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(["resources/css/app.css", "resources/js/app.js"])
</head>
<body class="bg-gray-50 text-gray-900 font-sans">
<!-- Header & Navigation -->
<header class="border-b border-gray-200 sticky top-0 z-50 bg-white shadow-sm">
    <div class="max-w-6xl mx-auto px-4">
        <nav class="flex justify-between items-center py-4">
            <div class="flex items-center gap-2 font-bold text-lg">
                <a href="/" class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-black text-white flex items-center justify-center text-sm font-bold rounded">N</div>
                    
                    @if($system_logo)
                        <img src="{{ $system_logo }}" alt="{{ $system_name }}" class="w-10 h-10 object-contain">
                    @else
                        <div class="w-10 h-10 bg-white text-black flex items-center justify-center text-lg font-black">{{ substr($system_name, 0, 1) }}</div>
                    @endif
                    <span>{{ $system_name }}</span>
                </a>
            </div>
            <ul class="hidden md:flex gap-6 list-none items-center" id="navLinks">
                <li><a href="/" class="text-gray-600 font-medium text-sm hover:text-black hover:underline">Home</a></li>
                <li><a href="{{ route('projects.index') }}" class="text-gray-600 font-medium text-sm hover:text-black hover:underline">Browse Projects</a></li>
                @if(auth()->guard('client')->check() || auth()->guard('web')->check())
                    <li><a href="{{ route('client.dashboard') }}" class="text-gray-600 font-medium text-sm hover:text-black hover:underline">Dashboard</a></li>
                    <li><a href="{{ route('client.projects.create') }}" class="bg-black text-white font-semibold px-4 py-2 rounded">Submit Project</a></li>
                @else
                    <li><a href="{{ route('client.login') }}" class="text-gray-600 font-medium text-sm hover:text-black hover:underline">Login</a></li>
                    <li><a href="{{ route('client.register') }}" class="bg-black text-white font-semibold px-4 py-2 rounded">Get Started</a></li>
                @endif
            </ul>
        </nav>
    </div>
</header>

<main class="py-12 md:py-16">
    <div class="max-w-6xl mx-auto px-4">
        <!-- Profile Header -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8 mb-8">
            <div class="flex flex-col md:flex-row gap-8 items-start md:items-center">
                <div class="w-32 h-32 flex-shrink-0 bg-gray-100 rounded-full overflow-hidden border-4 border-white shadow-lg mx-auto md:mx-0">
                    @if($user->profile_image)
                        <img src="{{ asset('storage/' . $user->profile_image) }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-400 bg-gray-50">
                            <svg class="h-16 w-16" fill="currentColor" viewBox="0 0 24 24"><path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                        </div>
                    @endif
                </div>

                <div class="flex-1 text-center md:text-left">
                    <h1 class="text-3xl font-extrabold mb-2">{{ $user->name }}</h1>
                    
                    @if($user->college)
                    <div class="flex items-center justify-center md:justify-start gap-2 text-gray-600 mb-4">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        <a href="{{ route('colleges.show', $user->college->id) }}" class="font-medium hover:text-blue-600 hover:underline transition">{{ $user->college->name }}</a>
                    </div>
                    @endif

                    @if($user->description)
                        <p class="text-gray-600 max-w-2xl text-sm leading-relaxed mb-6">{{ $user->description }}</p>
                    @endif

                    <!-- Social Links -->
                    <div class="flex flex-wrap justify-center md:justify-start gap-3">
                        @if($user->github)<a href="{{ $user->github }}" target="_blank" class="px-3 md:px-4 py-2 bg-gray-900 text-white rounded text-xs font-bold hover:bg-black transition">GitHub</a>@endif
                        @if($user->linkedin)<a href="{{ $user->linkedin }}" target="_blank" class="px-3 md:px-4 py-2 bg-blue-600 text-white rounded text-xs font-bold hover:bg-blue-700 transition">LinkedIn</a>@endif
                        @if($user->website)<a href="{{ $user->website }}" target="_blank" class="px-3 md:px-4 py-2 bg-gray-100 text-gray-800 border border-gray-200 rounded text-xs font-bold hover:bg-gray-200 transition">Website</a>@endif
                        @if($user->twitter)<a href="{{ $user->twitter }}" target="_blank" class="px-3 md:px-4 py-2 bg-sky-500 text-white rounded text-xs font-bold hover:bg-sky-600 transition">Twitter</a>@endif
                    </div>
                </div>
                
                <div class="hidden lg:flex flex-col gap-6 ml-auto pr-8">
                    <!-- Stats Block -->
                    <div class="grid grid-cols-2 gap-8 text-center bg-gray-50 rounded-lg p-6 border border-gray-100">
                        <div>
                            <div class="text-4xl font-extrabold text-black">{{ $user->projects->count() }}</div>
                            <div class="text-xs uppercase tracking-widest text-gray-500 font-bold mt-1">Projects</div>
                        </div>
                        <div>
                            <div class="text-4xl font-extrabold text-black">{{ $totalLikes }}</div>
                            <div class="text-xs uppercase tracking-widest text-gray-500 font-bold mt-1">Total Likes</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Mobile/Tablet only Stats -->
        <div class="grid grid-cols-2 gap-4 text-center bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8 lg:hidden">
            <div>
                <div class="text-3xl font-extrabold text-black">{{ $user->projects->count() }}</div>
                <div class="text-xs uppercase tracking-widest text-gray-500 font-bold mt-1">Projects</div>
            </div>
            <div>
                <div class="text-3xl font-extrabold text-black">{{ $totalLikes }}</div>
                <div class="text-xs uppercase tracking-widest text-gray-500 font-bold mt-1">Total Likes</div>
            </div>
        </div>

        <!-- User's Projects Grid -->
        <h2 class="text-2xl font-bold mb-6">Projects by {{ explode(' ', trim($user->name))[0] }}</h2>
        
        @if($user->projects->isEmpty())
            <div class="bg-white border border-gray-200 rounded p-12 text-center shadow-sm">
                <p class="text-gray-500 italic">This user hasn't published any public projects yet.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($user->projects as $project)
                    <div class="bg-white border border-gray-200 rounded overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 flex flex-col group">
                        <div class="aspect-video bg-gray-100 overflow-hidden shrink-0">
                            @if($project->image)
                                <img src="{{ asset('storage/' . $project->image) }}" alt="{{ $project->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                            @endif
                        </div>
                        <div class="p-6 flex-1 flex flex-col">
                            <h3 class="text-xl font-bold mb-2 group-hover:text-blue-600 transition-colors line-clamp-1">{{ $project->name }}</h3>
                            <p class="text-gray-600 text-sm mb-4 line-clamp-2 flex-1">{{ $project->description }}</p>

                            <div class="flex items-center justify-between border-t border-gray-100 pt-4 mt-auto">
                                <a href="{{ route('projects.show', $project->slug) }}" class="text-black font-bold text-sm hover:underline flex items-center gap-1">
                                    View Project <span class="group-hover:translate-x-1 transition-transform">&rarr;</span>
                                </a>
                                <div class="flex items-center text-gray-500 text-xs gap-1 font-medium bg-gray-50 px-2 py-1 rounded">
                                    <svg class="w-4 h-4 text-red-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                                    {{ $project->likes()->count() }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</main>

<footer class="bg-black text-white py-12 border-t border-gray-800">
    <div class="max-w-6xl mx-auto px-4 text-center">
        <p class="text-gray-400 text-sm">&copy; {{ date('Y') }} ProjectSanjal. All rights reserved.</p>
    </div>
</footer>

</body>
</html>
