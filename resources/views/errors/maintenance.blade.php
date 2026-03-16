<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Maintenance Mode - {{ config('app.name', 'System') }}</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: '#3b82f6',
                        secondary: '#1e293b',
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-200 antialiased min-h-screen flex items-center justify-center">

    <div class="max-w-2xl w-full px-6">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden border border-gray-100 dark:border-gray-700">
            <div class="p-8 md:p-12 text-center">
                
                <!-- Maintenance Icon / Animation -->
                <div class="mx-auto w-24 h-24 mb-8 bg-blue-50 dark:bg-blue-900/30 rounded-full flex items-center justify-center animation-pulse">
                    <svg class="w-12 h-12 text-blue-500 animate-[spin_4s_linear_infinite]" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>

                <h1 class="text-3xl md:text-4xl font-bold mb-4 tracking-tight">Under Maintenance</h1>
                
                <p class="text-lg text-gray-500 dark:text-gray-400 mb-8 max-w-lg mx-auto">
                    We are currently performing scheduled maintenance on our system to improve your experience. 
                    We'll be back online shortly!
                </p>

                <div class="inline-block px-6 py-4 bg-gray-50 dark:bg-gray-800/50 rounded-xl border border-gray-100 dark:border-gray-700 w-full sm:w-auto mt-4">
                    <p class="text-sm font-medium text-gray-400">Thank you for your patience.</p>
                </div>

                <!-- Admin Login Shortcut (Subtle) -->
                <div class="mt-12">
                    <a href="{{ route('admin.login') }}" class="text-xs text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                        Admin Access
                    </a>
                </div>
                
            </div>
            
            <div class="h-2 bg-gradient-to-r from-blue-500 via-indigo-500 to-purple-500 w-full"></div>
        </div>
        
        <div class="mt-8 text-center text-sm text-gray-400">
            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        </div>
    </div>

</body>
</html>
