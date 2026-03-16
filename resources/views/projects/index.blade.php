<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browse Projects - ProjectSanjal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/tom-select.css') }}">
    <style>
        /* TomSelect Overrides */
        .ts-wrapper {
            padding: 0 !important;
            border: none !important;
        }
        .ts-control {
            border: 1px solid #d1d5db !important;
            border-radius: 0.25rem !important;
            padding: 0.5rem 0.75rem !important;
            font-size: 0.875rem !important;
            box-shadow: none !important;
            background-color: white !important;
            min-height: 2.375rem !important;
            display: flex;
            align-items: center;
        }
        .ts-control.focus {
            border-color: black !important;
            box-shadow: none !important;
        }
        .ts-dropdown {
            border-radius: 0.25rem !important;
            border: 1px solid #d1d5db !important;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1) !important;
            font-size: 0.875rem !important;
        }
    </style>
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
                <li><a href="{{ route('users.contributors') }}" class="text-gray-600 font-medium text-sm hover:text-black hover:underline">Contributors</a></li>

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
            <li><a href="{{ route('users.contributors') }}" class="text-gray-600 font-medium text-sm">Contributors</a></li>
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
        <form action="{{ route('projects.index') }}" method="GET" class="mb-10">
            <div class="mb-4 flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                <div>
                    <h1 class="text-4xl font-bold mb-2">Explore Projects</h1>
                    <p class="text-gray-600">Discover innovative projects built by IT students across Nepal.</p>
                </div>
                <!-- Inline text search beside title -->
                <div class="flex-shrink-0 w-full lg:w-[450px] flex gap-2">
                    <input type="text" name="search" placeholder="Search projects by name or description..." value="{{ request('search') }}" class="w-full px-4 py-3 border border-gray-300 rounded focus:outline-none focus:border-black shadow-sm">
                    <button type="submit" class="bg-black text-white px-6 py-3 font-semibold rounded hover:bg-gray-800 transition shadow-sm">Search</button>
                </div>
            </div>

            <div class="flex justify-end mb-4">
                <button type="button" onclick="document.getElementById('advancedSearch').classList.toggle('hidden')" class="text-sm font-semibold text-gray-700 flex items-center gap-1 hover:text-black transition uppercase tracking-wide">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
                    Advanced Search
                </button>
            </div>

            <!-- Advanced Filters -->
            <div id="advancedSearch" class="{{ request()->anyFilled(['university', 'course', 'subject', 'college', 'tag', 'algorithm', 'technology', 'sort']) ? '' : 'hidden' }} bg-white p-6 border border-gray-200 shadow-sm rounded-lg">

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                    <!-- University -->
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">University</label>
                        <select name="university" id="university" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-black text-sm">
                            <option value="">All Universities</option>
                            @foreach($universities as $uni)
                                <option value="{{ $uni->id }}" {{ request('university') == $uni->id ? 'selected' : '' }}>{{ $uni->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Course -->
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Course</label>
                        <select name="course" id="course" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-black text-sm">
                            <option value="">All Courses</option>
                            @foreach($courses as $course)
                                <option value="{{ $course->id }}" data-university="{{ $course->university_id }}" {{ request('course') == $course->id ? 'selected' : '' }}>{{ $course->name . '-' . $course->code }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Subject -->
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Subject</label>
                        <select name="subject" id="subject" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-black text-sm">
                            <option value="">All Subjects</option>
                            @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}" data-course="{{ $subject->course_id }}" {{ request('subject') == $subject->id ? 'selected' : '' }}>{{ $subject->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- College -->
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">College</label>
                        <select name="college" id="college" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-black text-sm">
                            <option value="">All Colleges</option>
                            @foreach($colleges as $college)
                                <option value="{{ $college->id }}" {{ request('college') == $college->id ? 'selected' : '' }}>{{ $college->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Multi-Selects -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-4">
                    <!-- Tech Stack -->
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Tech Stack</label>
                        <div class="border border-gray-300 rounded overflow-hidden">
                            <input type="text" placeholder="Search tech..." class="w-full px-3 py-2 text-sm border-b border-gray-200 focus:outline-none" oninput="filterCheckboxList(this, 'tech-list')">
                            <div id="tech-list" class="max-h-36 overflow-y-auto p-2 bg-gray-50 flex flex-col gap-1">
                                @foreach($technologies as $tech)
                                    <label class="flex items-center gap-2 text-sm text-gray-700 hover:bg-gray-200 p-1 rounded cursor-pointer transition">
                                        <input type="checkbox" name="technology[]" value="{{ $tech->id }}" {{ in_array($tech->id, (array)request('technology', [])) ? 'checked' : '' }} class="rounded border-gray-300 text-black focus:ring-black">
                                        <span class="truncate">{{ $tech->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Tags -->
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Tags</label>
                        <div class="border border-gray-300 rounded overflow-hidden">
                            <input type="text" placeholder="Search tags..." class="w-full px-3 py-2 text-sm border-b border-gray-200 focus:outline-none" oninput="filterCheckboxList(this, 'tag-list')">
                            <div id="tag-list" class="max-h-36 overflow-y-auto p-2 bg-gray-50 flex flex-col gap-1">
                                @foreach($tags as $tag)
                                    <label class="flex items-center gap-2 text-sm text-gray-700 hover:bg-gray-200 p-1 rounded cursor-pointer transition">
                                        <input type="checkbox" name="tag[]" value="{{ $tag->id }}" {{ in_array($tag->id, (array)request('tag', [])) ? 'checked' : '' }} class="rounded border-gray-300 text-black focus:ring-black">
                                        <span class="truncate">{{ $tag->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Algorithms -->
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Algorithms</label>
                        <div class="border border-gray-300 rounded overflow-hidden">
                            <input type="text" placeholder="Search algorithms..." class="w-full px-3 py-2 text-sm border-b border-gray-200 focus:outline-none" oninput="filterCheckboxList(this, 'algo-list')">
                            <div id="algo-list" class="max-h-36 overflow-y-auto p-2 bg-gray-50 flex flex-col gap-1">
                                @foreach($algorithms as $algo)
                                    <label class="flex items-center gap-2 text-sm text-gray-700 hover:bg-gray-200 p-1 rounded cursor-pointer transition">
                                        <input type="checkbox" name="algorithm[]" value="{{ $algo->id }}" {{ in_array($algo->id, (array)request('algorithm', [])) ? 'checked' : '' }} class="rounded border-gray-300 text-black focus:ring-black">
                                        <span class="truncate">{{ $algo->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row justify-between items-center border-t border-gray-200 pt-5 mt-2 text-sm gap-4">
                    <div class="flex items-center gap-2 w-full sm:w-auto">
                        <label class="font-bold text-gray-700 uppercase text-[10px] tracking-widest whitespace-nowrap">Sort By:</label>
                        <select name="sort" id="sortOptions" class="px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-black text-sm w-full sm:w-40">
                            <option value="">Latest (Default)</option>
                            <option value="likes" {{ request('sort') == 'likes' ? 'selected' : '' }}>Most Liked</option>
                        </select>
                    </div>

                    <div class="flex items-center gap-4 w-full sm:w-auto justify-end">
                        @if(request()->anyFilled(['search', 'course', 'subject', 'college', 'tag', 'algorithm', 'technology', 'sort', 'university']))
                            <a href="{{ route('projects.index') }}" class="text-sm font-semibold text-gray-500 hover:text-black hover:underline transition">Clear Filters</a>
                        @endif
                        <button type="submit" class="bg-gray-900 text-white hover:bg-black px-6 py-2.5 font-semibold rounded shadow transition">Apply Filters</button>
                    </div>
                </div>
            </div>
        </form>

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

<script src="{{ asset('js/tom-select.complete.min.js') }}"></script>
<script>
    function filterCheckboxList(input, listId) {
        const searchTerm = input.value.toLowerCase();
        const list = document.getElementById(listId);
        const labels = list.querySelectorAll('label');
        labels.forEach(label => {
            const text = label.textContent.toLowerCase();
            label.style.display = text.includes(searchTerm) ? 'flex' : 'none';
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        const tsConfig = {
            allowEmptyOption: true,
            create: false,
            searchField: ['text'],
            render: {
                no_results: function(data, escape) {
                    return '<div class="no-results p-2 text-gray-500 text-sm">No results found</div>';
                }
            }
        };

        const uniSelect = document.getElementById('university');
        const courseSelect = document.getElementById('course');
        const subjectSelect = document.getElementById('subject');
        const collegeSelect = document.getElementById('college');

        const allCourses = courseSelect ? Array.from(courseSelect.options).map(opt => ({value: opt.value, text: opt.text, uni: opt.getAttribute('data-university')})) : [];
        const allSubjects = subjectSelect ? Array.from(subjectSelect.options).map(opt => ({value: opt.value, text: opt.text, course: opt.getAttribute('data-course')})) : [];

        let tsUniversity = uniSelect ? new TomSelect(uniSelect, tsConfig) : null;
        let tsCollege = collegeSelect ? new TomSelect(collegeSelect, tsConfig) : null;
        let tsCourse = courseSelect ? new TomSelect(courseSelect, tsConfig) : null;
        let tsSubject = subjectSelect ? new TomSelect(subjectSelect, tsConfig) : null;
        let tsSort = document.getElementById('sortOptions') ? new TomSelect('#sortOptions', tsConfig) : null;

        function updateCourses(skipSubjectUpdate = false) {
            if (!tsUniversity || !tsCourse) return;
            const uniId = tsUniversity.getValue();
            const currentSelected = tsCourse.getValue();

            tsCourse.clearOptions();
            
            allCourses.forEach(opt => {
                if (!opt.value || !uniId || opt.uni === uniId) {
                    tsCourse.addOption({value: opt.value, text: opt.text});
                }
            });

            if (tsCourse.options[currentSelected]) {
                tsCourse.setValue(currentSelected, true);
            } else {
                tsCourse.setValue('', true);
            }

            if (!skipSubjectUpdate) {
                updateSubjects();
            }
        }

        function updateSubjects() {
            if (!tsCourse || !tsSubject) return;
            const courseId = tsCourse.getValue();
            const currentSelected = tsSubject.getValue();

            tsSubject.clearOptions();

            allSubjects.forEach(opt => {
                if (!opt.value || !courseId || opt.course === courseId) {
                    tsSubject.addOption({value: opt.value, text: opt.text});
                }
            });

            if (tsSubject.options[currentSelected]) {
                tsSubject.setValue(currentSelected, true);
            } else {
                tsSubject.setValue('', true);
            }
        }

        if(tsUniversity) tsUniversity.on('change', () => updateCourses(false));
        if(tsCourse) tsCourse.on('change', updateSubjects);

        // Run on load to apply initial selects from query strings
        if(tsUniversity) updateCourses(true);
        if(tsCourse) updateSubjects();
    });
</script>
</body>
</html>
