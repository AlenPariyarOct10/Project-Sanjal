<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $team->name }} - Team Profile - ProjectSanjal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(["resources/css/app.css", "resources/js/app.js"])
</head>
<body class="bg-gray-50 text-gray-900 font-sans min-h-screen flex flex-col">

<!-- Header -->
<header class="border-b border-gray-200 sticky top-0 z-50 bg-white">
    <div class="max-w-6xl mx-auto px-4">
        <nav class="flex justify-between items-center py-4">
            <div class="flex items-center gap-2 font-bold text-lg">
                <a href="/" class="flex items-center gap-2">
                    
                    
                    @if($system_logo)
                        <img src="{{ $system_logo }}" alt="{{ $system_name }}" class="w-10 h-10 object-contain">
                    @else
                        <div class="w-10 h-10 bg-white text-black flex items-center justify-center text-lg font-black">{{ substr($system_name, 0, 1) }}</div>
                    @endif
                    <span>{{ $system_name }}</span>
                </a>
            </div>
            <!-- Standard Desktop Navigation ... -->
            <ul class="hidden md:flex gap-6 list-none items-center" id="navLinks">
                <li><a href="/" class="text-gray-600 font-medium text-sm hover:text-black hover:underline">Home</a></li>
                <li><a href="{{ route('projects.index') }}" class="text-gray-600 font-medium text-sm hover:text-black hover:underline">Browse Projects</a></li>
                @if(auth()->check())
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
        </nav>
    </div>
</header>

<main class="flex-grow py-12">
    <div class="max-w-6xl mx-auto px-4">
        <!-- Team Profile Header -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 mb-8 text-center sm:text-left">
            <div class="flex flex-col sm:flex-row items-center gap-8">
                <!-- Team Logo -->
                <div class="w-32 h-32 flex-shrink-0 bg-gray-100 rounded-full border border-gray-200 overflow-hidden flex items-center justify-center">
                    @if($team->logo)
                        <img src="{{ asset('storage/' . $team->logo) }}" alt="{{ $team->name }}" class="w-full h-full object-cover">
                    @else
                        <span class="text-4xl text-gray-400 font-bold">{{ substr($team->name, 0, 1) }}</span>
                    @endif
                </div>
                <!-- Team Info -->
                <div class="flex-grow">
                    <h1 class="text-3xl font-extrabold text-gray-900 mb-2">{{ $team->name }}</h1>
                    <p class="text-gray-600 mb-4 max-w-2xl leading-relaxed">{{ $team->description ?: 'No description provided.' }}</p>
                    
                    <div class="flex flex-wrap gap-4 justify-center sm:justify-start">
                        @if($team->website)
                            <a href="{{ $team->website }}" target="_blank" class="text-sm font-medium text-blue-600 hover:text-blue-800 transition-colors bg-blue-50 px-3 py-1 rounded">Website</a>
                        @endif
                        @if($team->github)
                            <a href="{{ $team->github }}" target="_blank" class="text-sm font-medium text-gray-700 hover:text-black transition-colors bg-gray-100 px-3 py-1 rounded">GitHub</a>
                        @endif
                        @if($team->linkedin)
                            <a href="{{ $team->linkedin }}" target="_blank" class="text-sm font-medium text-blue-600 hover:text-blue-800 transition-colors bg-blue-50 px-3 py-1 rounded">LinkedIn</a>
                        @endif
                        <span class="text-sm font-medium text-gray-500 bg-gray-100 px-3 py-1 rounded border border-gray-200">Joined {{ $team->created_at->format('M Y') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Members List -->
            <div class="md:col-span-1">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-5 border-b border-gray-100 bg-gray-50 flex items-center justify-between">
                        <h2 class="text-lg font-bold text-gray-900">Members ({{ $team->members->count() + 1 }})</h2>
                    </div>
                    <ul class="divide-y divide-gray-100">
                        <!-- Creator always first -->
                        <li class="p-4 flex items-center gap-3 hover:bg-gray-50 transition-colors">
                            <div class="w-10 h-10 rounded-full bg-black text-white flex items-center justify-center font-bold text-sm shrink-0">
                                {{ substr(optional($team->creator)->name ?: 'User', 0, 1) }}
                            </div>
                            <div class="overflow-hidden">
                                @if($team->creator)
                                    <a href="{{ route('users.show', $team->creator->id) }}" class="font-bold text-gray-900 hover:text-blue-600 text-sm truncate block">{{ $team->creator->name }}</a>
                                @else
                                    <span class="font-bold text-gray-900 text-sm truncate block">Unknown</span>
                                @endif
                                <span class="text-xs text-gray-500 block">Team Creator</span>
                            </div>
                        </li>

                        <!-- Approved Members -->
                        @foreach($team->members as $member)
                            <li class="p-4 flex items-center gap-3 hover:bg-gray-50 transition-colors">
                                <div class="w-10 h-10 rounded-full bg-gray-200 text-gray-700 flex items-center justify-center font-bold text-sm shrink-0">
                                    {{ substr($member->name, 0, 1) }}
                                </div>
                                <div class="overflow-hidden">
                                    <a href="{{ route('users.show', $member->id) }}" class="font-bold text-gray-900 hover:text-blue-600 text-sm truncate block">{{ $member->name }}</a>
                                    <span class="text-xs text-gray-500 block">Member</span>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <!-- Team Projects -->
            <div class="md:col-span-2">
                <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center border-b border-gray-200 pb-2">
                    Team Projects
                    <span class="ml-3 bg-black text-white text-xs py-0.5 px-2 rounded-full">{{ $team->projects->count() }}</span>
                </h2>
                
                @if($team->projects->isEmpty())
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 mb-1">No Projects Found</h3>
                        <p class="text-gray-500">This team has not contributed to any projects yet.</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        @foreach($team->projects as $project)
                            @if($project->status == 1) {{-- Only show published projects --}}
                            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden flex flex-col hover:shadow-md transition-shadow group">
                                <a href="{{ route('projects.show', $project->slug) }}" class="block aspect-video bg-gray-100 relative overflow-hidden">
                                    @if($project->image)
                                        <img src="{{ asset('storage/'.$project->image) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-300">
                                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        </div>
                                    @endif
                                </a>
                                <div class="p-5 flex-grow flex flex-col">
                                    <h3 class="font-bold text-lg mb-2 line-clamp-1">
                                        <a href="{{ route('projects.show', $project->slug) }}" class="hover:text-blue-600 transition-colors">{{ $project->name }}</a>
                                    </h3>
                                    <p class="text-gray-600 text-sm line-clamp-2 mb-4 flex-grow">{{ $project->description }}</p>
                                    
                                    <div class="flex items-center justify-between text-xs text-gray-500 border-t border-gray-100 pt-3 mt-auto">
                                        <span class="flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                                            {{ $project->likes_count ?? 0 }}
                                        </span>
                                        <span>{{ $project->created_at->format('M d, Y') }}</span>
                                    </div>
                                </div>
                            </div>
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</main>
</body>
</html>
