<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Colleges - {{ $system_name }}</title>
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
                <li><a href="{{ route('projects.index') }}" class="text-gray-600 font-medium text-sm hover:text-black hover:underline">Browse Projects</a></li>
                <li><a href="{{ route('colleges.index') }}" class="text-black font-semibold text-sm underline">Colleges</a></li>
                <li><a href="{{ route('users.contributors') }}" class="text-gray-600 font-medium text-sm hover:text-black hover:underline">Contributors</a></li>

                @if(auth()->guard('client')->check() || auth()->guard('web')->check())
                    <li><a href="{{ route('client.dashboard') }}" class="text-gray-600 font-medium text-sm hover:text-black hover:underline">Dashboard</a></li>
                    <li>
                        <form method="POST" action="{{ route('client.logout') }}">
                            @csrf
                            <button type="submit" class="text-gray-600 font-medium text-sm hover:text-black hover:underline bg-transparent border-none p-0 cursor-pointer">Logout</button>
                        </form>
                    </li>
                @else
                    <li><a href="{{ route('client.login') }}" class="text-gray-600 font-medium text-sm hover:text-black hover:underline">Login</a></li>
                    <li><a href="{{ route('client.register') }}" class="bg-black text-white font-semibold px-4 py-2">Get Started</a></li>
                @endif
            </ul>
        </nav>
    </div>
</header>

<main class="py-12 md:py-16">
    <div class="max-w-6xl mx-auto px-4">
        <div class="mb-10 text-center">
            <h1 class="text-4xl font-extrabold mb-4">Educational Institutions</h1>
            <p class="text-gray-600 max-w-2xl mx-auto text-lg">Browse colleges and universities across the network. Discover projects from different institutions.</p>
        </div>

        <!-- Filters -->
        <div class="mb-12">
            <form action="{{ route('colleges.index') }}" method="GET" class="bg-white p-6 border border-gray-200 shadow-sm rounded-xl">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="md:col-span-1">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Search</label>
                        <input type="text" name="search" placeholder="Name or address..." value="{{ request('search') }}" class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:border-black transition">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">University</label>
                        <select name="university" class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:border-black transition">
                            <option value="">All Universities</option>
                            @foreach($universities as $uni)
                                <option value="{{ $uni->id }}" {{ request('university') == $uni->id ? 'selected' : '' }}>{{ $uni->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex items-end gap-2">
                        <button type="submit" class="flex-1 bg-black text-white py-2 font-bold rounded-lg hover:bg-gray-800 transition">Apply Filters</button>
                        @if(request()->anyFilled(['search', 'university']))
                            <a href="{{ route('colleges.index') }}" class="px-4 py-2 border border-gray-200 rounded-lg hover:bg-gray-50 text-gray-500 transition">Reset</a>
                        @endif
                    </div>
                </div>
            </form>
        </div>

        @if($colleges->isEmpty())
            <div class="bg-white border border-gray-200 p-20 text-center rounded-xl shadow-sm">
                <p class="text-gray-500 italic text-lg">No institutions found matching your criteria.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($colleges as $college)
                <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col group">
                    <div class="p-8 flex-1 flex flex-col items-center text-center">
                        <div class="w-24 h-24 bg-gray-50 rounded-2xl border border-gray-100 flex items-center justify-center mb-6 group-hover:scale-105 transition-transform">
                            @if($college->logo)
                                <img src="{{ asset('storage/' . $college->logo) }}" alt="{{ $college->name }}" class="w-full h-full object-contain p-2">
                            @else
                                <span class="text-3xl font-black text-gray-300">{{ substr($college->name, 0, 1) }}</span>
                            @endif
                        </div>

                        <a href="{{ route('colleges.show', $college->id) }}" class="text-xl font-bold mb-2 group-hover:text-blue-600 transition-colors line-clamp-1">{{ $college->name }}</a>

                        @if($college->university)
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4 inline-block bg-gray-100 px-3 py-1 rounded-full">{{ $college->university->name }}</span>
                        @endif

                        <p class="text-gray-600 text-sm mb-6 line-clamp-2">{{ $college->description ?? 'No description provided.' }}</p>

                        <div class="mt-auto w-full pt-6 border-t border-gray-50 flex flex-col gap-3">
                            <div class="flex items-center justify-center gap-1 text-xs text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                <span>{{ $college->users->count() }} active users</span>
                            </div>
                            <a href="{{ route('colleges.show', $college->id) }}" class="inline-block bg-white text-black border-2 border-black py-2 px-6 font-bold text-sm hover:bg-black hover:text-white transition group-hover:gap-2">
                                View Profile &rarr;
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="mt-12">
                {{ $colleges->links() }}
            </div>
        @endif
    </div>
</main>

<footer class="bg-black text-white py-12 mt-20 border-t border-gray-800">
    <div class="max-w-6xl mx-auto px-4 text-center">
        <p class="text-gray-500 text-sm">&copy; {{ date('Y') }} {{ $system_name }}. All rights reserved.</p>
    </div>
</footer>

</body>
</html>
