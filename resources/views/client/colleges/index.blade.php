<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Colleges - Nepal IT Project Hub</title>
    <!-- Added Tailwind CDN and removed custom CSS link -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white text-gray-900 font-sans">
<!-- Header -->
<header class="border-b border-gray-200 sticky top-0 z-50 bg-white">
    <div class="max-w-6xl mx-auto px-4">
        <nav class="flex justify-between items-center py-4">
            <div class="text-xl font-bold text-black">Nepal IT Hub</div>
            <button class="md:hidden flex flex-col gap-1" id="navToggle">
                <span class="w-6 h-0.5 bg-gray-900"></span>
                <span class="w-6 h-0.5 bg-gray-900"></span>
                <span class="w-6 h-0.5 bg-gray-900"></span>
            </button>
            <ul class="hidden md:flex gap-6 list-none items-center" id="navLinks">
                <li><a href="index.html" class="text-gray-600 hover:text-black">Home</a></li>
                <li><a href="projects.html" class="text-gray-600 hover:text-black">Projects</a></li>
                <li><a href="colleges.html" class="font-bold text-black">Colleges</a></li>
                <li><a href="universities.html" class="text-gray-600 hover:text-black">Universities</a></li>
                <li><a href="profile.html" class="text-gray-600 hover:text-black">Profile</a></li>
                <li><a href="login.html" class="text-gray-600 hover:text-black">Logout</a></li>
            </ul>
        </nav>
    </div>
</header>

<!-- Hero Section -->
<section class="py-12 md:py-16 border-b border-gray-200">
    <div class="max-w-6xl mx-auto px-4 text-center">
        <h1 class="text-4xl font-bold mb-2">Colleges</h1>
        <p class="text-gray-600">Explore colleges in Nepal and their projects</p>
    </div>
</section>

<!-- Search & Content Section -->
<section class="py-12 md:py-16">
    <div class="max-w-6xl mx-auto px-4">
        <div class="mb-8">
            <input type="text" id="collegeSearch" placeholder="Search colleges..." class="w-full px-4 py-2 border border-gray-300 focus:outline-none focus:border-black">
        </div>

        <div id="collegesList" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6"></div>
    </div>
</section>

<!-- Footer -->
<footer class="bg-gray-900 text-white py-8 mt-12">
    <div class="max-w-6xl mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div class="footer-section">
                <h4 class="font-bold mb-2">Nepal IT Hub</h4>
                <p class="text-gray-300 text-sm">Showcasing IT projects from Nepalese institutions</p>
            </div>
            <div class="footer-section">
                <h4 class="font-bold mb-2">Quick Links</h4>
                <ul class="text-sm space-y-1">
                    <li><a href="projects.html" class="text-gray-300 hover:text-white">Projects</a></li>
                    <li><a href="colleges.html" class="text-gray-300 hover:text-white">Colleges</a></li>
                    <li><a href="universities.html" class="text-gray-300 hover:text-white">Universities</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h4 class="font-bold mb-2">Contact</h4>
                <p class="text-gray-300 text-sm">Email: info@nepalithub.com</p>
            </div>
        </div>
        <div class="border-t border-gray-700 pt-6 text-center text-gray-400 text-sm">
            <p>&copy; 2025 Nepal IT Project Hub. All rights reserved.</p>
        </div>
    </div>
</footer>


</body>
</html>
