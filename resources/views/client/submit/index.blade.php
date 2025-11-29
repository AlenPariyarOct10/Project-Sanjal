<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Project - Nepal IT Project Hub</title>
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
    <div class="max-w-2xl mx-auto px-4">
        <h1 class="text-4xl font-bold mb-2">Submit Your Project</h1>
        <p class="text-gray-600 mb-8">Share your academic or personal project with the Nepal IT community.</p>

        <form id="submit-form" class="bg-white border border-gray-200 p-8">
            <!-- Project Title -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-900 mb-2">Project Title *</label>
                <input type="text" id="title" placeholder="Your project title" required class="w-full px-4 py-2 border border-gray-300 focus:outline-none focus:border-black">
            </div>

            <!-- Description -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-900 mb-2">Description *</label>
                <textarea id="description" placeholder="Describe your project in detail..." rows="4" required class="w-full px-4 py-2 border border-gray-300 focus:outline-none focus:border-black resize-vertical"></textarea>
            </div>

            <!-- College & University -->
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">College *</label>
                    <select id="college" required class="w-full px-4 py-2 border border-gray-300 focus:outline-none focus:border-black">
                        <option value="">Select College</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">University *</label>
                    <select id="university" required class="w-full px-4 py-2 border border-gray-300 focus:outline-none focus:border-black">
                        <option value="">Select University</option>
                    </select>
                </div>
            </div>

            <!-- Semester -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-900 mb-2">Semester / Year *</label>
                <select id="semester" required class="w-full px-4 py-2 border border-gray-300 focus:outline-none focus:border-black">
                    <option value="">Select Semester</option>
                </select>
            </div>

            <!-- Technologies -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-900 mb-2">Technologies Used (Hold Ctrl/Cmd to select multiple)</label>
                <select id="technologies" multiple class="w-full px-4 py-2 border border-gray-300 focus:outline-none focus:border-black min-h-24"></select>
            </div>

            <!-- Algorithms -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-900 mb-2">Algorithms Used (Hold Ctrl/Cmd to select multiple)</label>
                <select id="algorithms" multiple class="w-full px-4 py-2 border border-gray-300 focus:outline-none focus:border-black min-h-24"></select>
            </div>

            <!-- File Upload -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-900 mb-2">Upload Images / Files</label>
                <input type="file" id="file-upload" multiple accept="image/*,.zip,.rar,.tar,.7z" class="w-full px-4 py-2 border border-gray-300">
                <p class="text-xs text-gray-600 mt-2">Supported formats: Images (JPG, PNG, GIF), ZIP, RAR, TAR, 7Z</p>
                <div id="file-preview" class="mt-4"></div>
            </div>

            <!-- Team Members -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-900 mb-2">Team Members</label>
                <div class="flex gap-4 mb-4">
                    <input type="text" id="member-input" placeholder="Enter team member name" class="flex-1 px-4 py-2 border border-gray-300 focus:outline-none focus:border-black">
                    <button type="button" id="add-member-btn" class="bg-black text-white font-semibold px-4 py-2 text-sm">Add Member</button>
                </div>
                <div id="team-members-list" class="flex flex-wrap gap-2"></div>
            </div>

            <!-- Links -->
            <div class="grid grid-cols-2 gap-4 mb-8">
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">GitHub Link</label>
                    <input type="url" id="github-link" placeholder="https://github.com/username/project" class="w-full px-4 py-2 border border-gray-300 focus:outline-none focus:border-black">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">Live Demo Link</label>
                    <input type="url" id="live-demo-link" placeholder="https://example.com" class="w-full px-4 py-2 border border-gray-300 focus:outline-none focus:border-black">
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex gap-4 justify-end">
                <a href="projects.html" class="border border-gray-200 text-gray-900 font-semibold px-6 py-2 hover:bg-gray-100">Cancel</a>
                <button type="submit" class="bg-black text-white font-semibold px-6 py-2 hover:bg-gray-800">Submit Project</button>
            </div>
        </form>
    </div>
</main>

<!-- Footer -->
<footer class="bg-gray-900 text-white py-8 mt-12">
    <div class="max-w-6xl mx-auto px-4 text-center text-gray-400 text-sm">
        <p>&copy; 2025 Nepal IT Project Hub. All rights reserved.</p>
    </div>
</footer>

<script src="assets/js/main.js"></script>
<script src="assets/js/submit.js"></script>
</body>
</html>
