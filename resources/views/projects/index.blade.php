<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browse Projects - ProjectSanjal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(["resources/css/app.css", "resources/js/app.js"])
</head>
<body class="bg-gray-50 text-gray-900 font-sans">
<!-- Header & Navigation -->
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
            <ul class="hidden md:flex gap-6 list-none items-center" id="navLinks">
                <li><a href="/" class="text-gray-600 font-medium text-sm hover:text-black hover:underline">Home</a></li>
                <li><a href="{{ route('projects.index') }}" class="text-black font-semibold text-sm underline">Browse Projects</a></li>
                <li><a href="{{ route('colleges.index') }}" class="text-gray-600 font-medium text-sm hover:text-black hover:underline">Colleges</a></li>

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
            <li><a href="{{ route('colleges.index') }}" class="text-gray-600 font-medium text-sm">Colleges</a></li>
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

<!-- Main Content -->
<main class="py-12 md:py-16">
    <div class="max-w-6xl mx-auto px-4">
        <div class="mb-10">
            <div class="mb-6">
                <h1 class="text-4xl font-bold mb-2">Explore Projects</h1>
                <p class="text-gray-600">Discover innovative projects built by IT students across Nepal.</p>
            </div>

            <form action="{{ route('projects.index') }}" method="GET" class="bg-white p-6 border border-gray-200 shadow-sm rounded-lg">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                    <div class="col-span-1 md:col-span-2 lg:col-span-4 flex gap-2">
                        <input type="text" name="search" placeholder="Search projects by name or description..." value="{{ request('search') }}" class="w-full px-4 py-3 border border-gray-300 rounded focus:outline-none focus:border-black">
                        <button type="submit" class="bg-black text-white px-8 py-3 font-semibold rounded hover:bg-gray-800 transition">Search</button>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Course</label>
                        <select name="course" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-black text-sm">
                            <option value="">All Courses</option>
                            @foreach($courses as $course)
                                <option value="{{ $course->id }}" {{ request('course') == $course->id ? 'selected' : '' }}>{{ $course->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Subject</label>
                        <select name="subject" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-black text-sm">
                            <option value="">All Subjects</option>
                            @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}" {{ request('subject') == $subject->id ? 'selected' : '' }}>{{ $subject->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">College</label>
                        <select name="college" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-black text-sm">
                            <option value="">All Colleges</option>
                            @foreach($colleges as $college)
                                <option value="{{ $college->id }}" {{ request('college') == $college->id ? 'selected' : '' }}>{{ $college->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Tag</label>
                        <select name="tag" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-black text-sm">
                            <option value="">All Tags</option>
                            @foreach($tags as $tag)
                                <option value="{{ $tag->id }}" {{ request('tag') == $tag->id ? 'selected' : '' }}>{{ $tag->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Algorithm</label>
                        <select name="algorithm" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-black text-sm">
                            <option value="">All Algorithms</option>
                            @foreach($algorithms as $algorithm)
                                <option value="{{ $algorithm->id }}" {{ request('algorithm') == $algorithm->id ? 'selected' : '' }}>{{ $algorithm->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Sort By</label>
                        <select name="sort" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-black text-sm">
                            <option value="">Latest (Default)</option>
                            <option value="likes" {{ request('sort') == 'likes' ? 'selected' : '' }}>Most Liked</option>
                        </select>
                    </div>

                    <div class="col-span-1 md:col-span-2 lg:col-span-2 flex justify-end items-end gap-2">
                        @if(request()->anyFilled(['search', 'course', 'subject', 'college', 'tag', 'algorithm', 'sort']))
                            <a href="{{ route('projects.index') }}" class="text-sm text-gray-500 hover:text-black hover:underline py-2 px-3">Clear</a>
                        @endif
                        <button type="submit" class="bg-gray-100 text-gray-800 border border-gray-300 hover:bg-gray-200 px-6 py-2 font-semibold rounded transition text-sm">Apply Filters</button>
                    </div>
                </div>
            </form>
        </div>

        @if($projects->isEmpty())
            <div class="bg-white border border-gray-200 p-12 text-center">
                <p class="text-gray-600 text-lg">No projects found. Be the first to <a href="{{ route('client.projects.create') }}" class="text-black font-bold underline">submit one</a>!</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($projects as $project)
                    <div class="bg-white border border-gray-200 hover:shadow-xl transition-all duration-300 group">
                        <div class="aspect-video overflow-hidden bg-gray-100">
                            @if($project->image)
                                <img src="{{ asset('storage/' . $project->image) }}" alt="{{ $project->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                            @endif
                        </div>
                        <div class="p-6">
                            <a href="{{ route('projects.show', $project->slug) }}" class="text-xl font-bold mb-1 group-hover:text-blue-600 transition-colors">{{ $project->name }}</a>

                            <div class="mb-3 text-xs text-gray-400 font-medium">
                                @if($project->user)
                                    By <a href="{{ route('users.show', $project->user->id) }}" class="text-gray-600 hover:text-black hover:underline transition">{{ $project->user->name }}</a>
                                @else
                                    By <span class="text-gray-600">Anonymous</span>
                                @endif
                            </div>

                            <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $project->description }}</p>

                            <div class="flex flex-wrap gap-2 mb-6">
                                @foreach($project->tags->take(3) as $tag)
                                    <span class="px-2 py-1 bg-gray-100 text-gray-600 text-[10px] font-bold uppercase tracking-wider">{{ $tag->name }}</span>
                                @endforeach
                            </div>

                            <div class="border-t border-gray-100 pt-4 flex justify-between items-center">
                                <a href="{{ route('projects.show', $project->slug) }}" class="text-black font-bold text-sm flex items-center gap-1 hover:gap-2 transition-all">
                                    View Details <span>&rarr;</span>
                                </a>
                                <div class="flex items-center gap-3 text-gray-500 text-[10px] font-medium">
                                    <span class="flex items-center gap-1" title="Likes">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                                        {{ $project->likes->count() }}
                                    </span>
                                    <span class="flex items-center gap-1" title="Views">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        {{ $project->views }}
                                    </span>
                                    <span class="flex items-center gap-1" title="Downloads">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                        {{ $project->downloads }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-12">
                {{ $projects->links() }}
            </div>
        @endif
    </div>
</main>

<!-- Footer -->
<footer class="bg-black text-white py-16 mt-12">
    <div class="max-w-6xl mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
            <div class="col-span-1 md:col-span-2">
                <div class="flex items-center gap-2 font-bold text-2xl mb-6">
                    @if($system_logo)
                        <img src="{{ $system_logo }}" alt="{{ $system_name }}" class="w-10 h-10 object-contain">
                    @else
                        <div class="w-10 h-10 bg-white text-black flex items-center justify-center text-lg font-black">{{ substr($system_name, 0, 1) }}</div>
                    @endif
                    <span>{{ $system_name }}</span>
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
            <p>&copy; {{ date('Y') }} ProjectSanjal. All rights reserved.</p>
            <div class="flex gap-6">
                <a href="#" class="hover:text-white">Privacy Policy</a>
                <a href="#" class="hover:text-white">Terms of Service</a>
            </div>
        </div>
    </div>
</footer>

</body>
</html>
