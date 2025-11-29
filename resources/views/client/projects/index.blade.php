<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browse Projects - Nepal IT Project Hub</title>
    <!-- Removed custom CSS link and inline Tailwind config -->
    <script src="https://cdn.tailwindcss.com"></script>
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
                <li><a href="index.html" class="text-gray-600 font-medium text-sm hover:text-black hover:underline">Home</a></li>
                <li><a href="projects.html" class="text-gray-600 font-medium text-sm hover:text-black hover:underline">Browse Projects</a></li>
                <li><a href="submit.html" class="bg-black text-white font-semibold px-4 py-2">Submit Project</a></li>
            </ul>
            <button class="md:hidden flex flex-col gap-1" id="navToggle">
                <span class="w-6 h-0.5 bg-gray-900"></span>
                <span class="w-6 h-0.5 bg-gray-900"></span>
                <span class="w-6 h-0.5 bg-gray-900"></span>
            </button>
        </nav>
    </div>
</header>

<!-- Main Content -->
<main class="py-8 md:py-12 bg-white min-h-screen">
    <div class="max-w-6xl mx-auto px-4">
        <div class="mb-8">
            <h1 class="text-4xl font-bold mb-2">Browse Projects</h1>
            <p class="text-gray-600">Discover projects from IT students across Nepal</p>
        </div>

        <!-- Filters -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-8 bg-white p-4 border border-gray-200">
            <div>
                <label class="block text-sm font-semibold text-gray-900 mb-2">Search</label>
                <input type="text" id="search-projects" placeholder="Search by title..." class="w-full px-4 py-2 border border-gray-300 focus:outline-none focus:border-black">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-900 mb-2">College</label>
                <select id="college-filter" class="w-full px-4 py-2 border border-gray-300 focus:outline-none focus:border-black">
                    <option value="">All Colleges</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-900 mb-2">University</label>
                <select id="university-filter" class="w-full px-4 py-2 border border-gray-300 focus:outline-none focus:border-black">
                    <option value="">All Universities</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-900 mb-2">Semester</label>
                <select id="semester-filter" class="w-full px-4 py-2 border border-gray-300 focus:outline-none focus:border-black">
                    <option value="">All Semesters</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-900 mb-2">Technology</label>
                <select id="tech-filter" class="w-full px-4 py-2 border border-gray-300 focus:outline-none focus:border-black">
                    <option value="">All Technologies</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-900 mb-2">Algorithm</label>
                <select id="algo-filter" class="w-full px-4 py-2 border border-gray-300 focus:outline-none focus:border-black">
                    <option value="">All Algorithms</option>
                </select>
            </div>
        </div>

        <!-- Projects Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="projects-container"></div>
    </div>
</main>

<!-- Footer -->
<footer class="bg-gray-900 text-white py-8 mt-12">
    <div class="max-w-6xl mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div>
                <h4 class="font-bold mb-2">About Nepal IT Project Hub</h4>
                <p class="text-gray-300 text-sm">A platform for IT students to share projects and collaborate.</p>
            </div>
            <div>
                <h4 class="font-bold mb-2">Quick Links</h4>
                <ul class="text-sm space-y-1">
                    <li><a href="index.html" class="text-gray-300 hover:text-white">Home</a></li>
                    <li><a href="projects.html" class="text-gray-300 hover:text-white">Projects</a></li>
                    <li><a href="submit.html" class="text-gray-300 hover:text-white">Submit</a></li>
                </ul>
            </div>
        </div>
        <div class="border-t border-gray-700 pt-6 text-center text-gray-400 text-sm">
            <p>&copy; 2025 Nepal IT Project Hub. All rights reserved.</p>
        </div>
    </div>
</footer>

<script src="assets/js/main.js"></script>
<script src="assets/js/project.js"></script>
</body>
</html>
