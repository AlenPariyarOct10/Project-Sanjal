<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nepal IT Project Hub - Share & Collaborate IT Projects</title>
    <!-- Added single unified Tailwind CDN and removed custom CSS files -->
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
                <li><a href="#home" class="text-gray-600 font-medium text-sm hover:text-black hover:underline">Home</a></li>
                <li><a href="#popular" class="text-gray-600 font-medium text-sm hover:text-black hover:underline">Popular Projects</a></li>
                <li><a href="#colleges" class="text-gray-600 font-medium text-sm hover:text-black hover:underline">Colleges</a></li>
                <li><a href="projects.html" class="text-gray-600 font-medium text-sm hover:text-black hover:underline">Browse Projects</a></li>
                <li><a href="submit.html" class="bg-black text-white font-semibold px-4 py-2">Submit Project</a></li>
            </ul>
            <button class="md:hidden flex flex-col gap-1 cursor-pointer bg-none border-none" id="navToggle">
                <span class="w-6 h-0.5 bg-gray-900"></span>
                <span class="w-6 h-0.5 bg-gray-900"></span>
                <span class="w-6 h-0.5 bg-gray-900"></span>
            </button>
        </nav>
    </div>
</header>

<!-- Hero Section -->
<section class="border-b border-gray-200 py-12 md:py-16" id="home">
    <div class="max-w-6xl mx-auto px-4 text-center">
        <h1 class="text-4xl md:text-5xl font-bold mb-4">Platform for IT Students of Nepal to Share Projects</h1>
        <p class="text-gray-600 text-lg mb-6">Showcase your academic and personal projects. Collaborate. Learn. Innovate.</p>
        <div class="flex gap-4 justify-center flex-wrap">
            <a href="projects.html" class="bg-black text-white font-semibold px-6 py-3">Explore Projects</a>
            <a href="submit.html" class="border border-black text-black font-semibold px-6 py-3 hover:bg-gray-100">Submit Project</a>
        </div>
    </div>
</section>

<!-- Popular Projects Section -->
<section class="py-12 md:py-16" id="popular">
    <div class="max-w-6xl mx-auto px-4">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold mb-2">Popular Projects</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="popularProjects"></div>
    </div>
</section>

<!-- Top Technologies Section -->
<section class="bg-gray-100 py-12 md:py-16">
    <div class="max-w-6xl mx-auto px-4">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold mb-2">Top Technologies</h2>
        </div>
        <div class="flex flex-wrap gap-6 justify-center" id="topTechnologies"></div>
    </div>
</section>

<!-- Top Colleges Section -->
<section class="py-12 md:py-16" id="colleges">
    <div class="max-w-6xl mx-auto px-4">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold mb-2">Top Colleges & Universities</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="collegesList"></div>
    </div>
</section>

<!-- Footer -->
<footer class="bg-gray-900 text-white py-8 mt-12">
    <div class="max-w-6xl mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div>
                <h4 class="font-bold mb-4">About Nepal IT Project Hub</h4>
                <p class="text-gray-300 text-sm">A platform where IT students of Nepal can share their academic and personal projects, collaborate, and showcase their skills.</p>
            </div>
            <div>
                <h4 class="font-bold mb-4">Quick Links</h4>
                <ul class="text-sm space-y-2">
                    <li><a href="projects.html" class="text-gray-300 hover:text-white">Browse Projects</a></li>
                    <li><a href="submit.html" class="text-gray-300 hover:text-white">Submit Project</a></li>
                    <li><a href="#" class="text-gray-300 hover:text-white">Guidelines</a></li>
                    <li><a href="#" class="text-gray-300 hover:text-white">Contact</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold mb-4">Resources</h4>
                <ul class="text-sm space-y-2">
                    <li><a href="#" class="text-gray-300 hover:text-white">Documentation</a></li>
                    <li><a href="#" class="text-gray-300 hover:text-white">Blog</a></li>
                    <li><a href="#" class="text-gray-300 hover:text-white">Community</a></li>
                    <li><a href="#" class="text-gray-300 hover:text-white">FAQ</a></li>
                </ul>
            </div>
        </div>
        <div class="border-t border-gray-700 pt-6 text-center text-gray-400 text-sm">
            <p>&copy; 2025 Nepal IT Project Hub. All rights reserved.</p>
        </div>
    </div>
</footer>

<script>
    async function loadPopularProjects() {
        const container = document.getElementById('popularProjects');

        const res = await fetch("{{ route('admin.projects.data') }}");
        const data = await res.json();

        const projects = data.projects.slice(0, 3);

        container.innerHTML = projects.map(project => `
            <div class="bg-white border border-gray-200 hover:border-black transition-colors">
                <img src="${project.image}" alt="${project.title}" class="w-full h-48 object-cover mb-4 block">
                <div class="p-6">
                    <h3 class="text-xl font-bold mb-2">${project.title}</h3>
                    <div class="mb-4">
                        <p class="text-gray-600 text-sm">${project.description.substring(0, 80)}...</p>
                        <div class="mt-4 flex flex-wrap gap-2">
                            ${project.technologies.slice(0, 2).map(tech =>
            `<span class="inline-block px-3 py-1 bg-gray-100 text-gray-600 border border-gray-200 text-xs font-medium">${tech}</span>`
        ).join('')}
                        </div>
                    </div>
                    <div class="border-t border-gray-200 pt-4 flex justify-between items-center">
                        <a href="project.html?id=${project.id}"
                           class="bg-black text-white font-semibold px-3 py-1 text-sm">View Details</a>
                        <span class="text-gray-600 text-sm">${project.likes} likes</span>
                    </div>
                </div>
            </div>
        `).join('');
    }

    {{--async function loadTopTechnologies() {--}}
    {{--    const container = document.getElementById('topTechnologies');--}}

    {{--    const res = await fetch("{{ route('api.top-technologies') }}");--}}
    {{--    const data = await res.json();--}}

    {{--    container.innerHTML = data.technologies.slice(0, 10)--}}
    {{--        .map(tech => `--}}
    {{--            <div class="px-4 py-2 bg-white border border-gray-200 hover:border-black cursor-pointer text-center font-medium text-gray-900">--}}
    {{--                ${tech}--}}
    {{--            </div>--}}
    {{--        `).join('');--}}
    {{--}--}}

    {{--async function loadColleges() {--}}
    {{--    const container = document.getElementById('collegesList');--}}

    {{--    const res = await fetch("{{ route('api.colleges') }}");--}}
    {{--    const data = await res.json();--}}

    {{--    const colleges = data.colleges.slice(0, 6);--}}

    {{--    container.innerHTML = colleges.map(college => `--}}
    {{--        <div class="bg-white border border-gray-200 p-6 text-center hover:border-black transition-colors">--}}
    {{--            <div class="w-20 h-20 bg-gray-100 mx-auto mb-4 flex items-center justify-center text-4xl font-bold text-gray-900">--}}
    {{--                ${college.name.charAt(0)}--}}
    {{--            </div>--}}
    {{--            <h3 class="text-xl font-bold mb-2">${college.name}</h3>--}}
    {{--            <p class="text-gray-600 text-sm">Top Institution</p>--}}
    {{--        </div>--}}
    {{--    `).join('');--}}
    {{--}--}}

    document.addEventListener('DOMContentLoaded', () => {
        loadPopularProjects();
        // loadTopTechnologies();
        // loadColleges();
    });
</script>

</body>
</html>
