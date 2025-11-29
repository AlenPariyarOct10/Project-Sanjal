<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Details - Nepal IT Project Hub</title>
    <!-- Removed inline Tailwind config -->
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
        <a href="projects.html" class="text-gray-900 mb-4 inline-block underline hover:no-underline">← Back to Projects</a>

        <div id="project-details"></div>

        <!-- Creator Profile Section -->
        <div class="mt-12 pt-12 border-t border-gray-200">
            <h2 class="text-2xl font-bold mb-6">Creator Profile</h2>
            <div id="creator-profile-section"></div>
        </div>

        <!-- Comments Section -->
        <div class="mt-12">
            <h2 class="text-2xl font-bold mb-6">Comments & Discussion</h2>
            <div class="bg-white border border-gray-200 p-6 mb-6">
                <h3 class="text-lg font-bold mb-4">Add a Comment</h3>
                <textarea id="comment-input" placeholder="Share your thoughts..." class="w-full px-4 py-3 border border-gray-300 focus:outline-none focus:border-black resize-vertical min-h-24 mb-4"></textarea>
                <button id="submit-comment-btn" class="bg-black text-white font-semibold px-4 py-2">Post Comment</button>
            </div>
            <div id="comments-list" class="flex flex-col gap-4"></div>
        </div>

        <!-- Related Projects Section -->
        <div class="mt-12">
            <h2 class="text-2xl font-bold mb-6">Related Projects</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="related-projects"></div>
        </div>
    </div>
</main>

<!-- Footer -->
<footer class="bg-gray-900 text-white py-8 mt-12">
    <div class="max-w-6xl mx-auto px-4">
        <div class="text-center text-gray-400 text-sm">
            <p>&copy; 2025 Nepal IT Project Hub. All rights reserved.</p>
        </div>
    </div>
</footer>

<script src="assets/js/main.js"></script>
<script src="assets/js/project.js"></script>
</body>
</html>
