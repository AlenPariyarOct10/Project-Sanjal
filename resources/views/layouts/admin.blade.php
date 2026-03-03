<!DOCTYPE html>
<html lang="en" class="{{ session('dark_mode', false) ? 'dark' : '' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') - {{ $system_name }}</title>
    @vite(['resources/css/styles.css', 'resources/css/admin.css', 'resources/css/app.css'])
    @yield('css')
    @stack('styles')
    <link rel="stylesheet" href="{{asset('css/sweetalert2.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/toastify.min.css')}}">
</head>
<body>
@include("admin.partials.navbar")

@yield('content')

<footer>
    <div class="container footer-content">
        <div class="footer-section">
            <h4>{{ $system_name }}</h4>
            <p>Connecting developers and projects across Nepal</p>
        </div>
        <div class="footer-section">
            <h4>Quick Links</h4>
            <ul>
                <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li><a href="{{ route('admin.projects.index') }}">Projects</a></li>
                <li><a href="{{ route('admin.users.index') }}">Users</a></li>
            </ul>
        </div>
    </div>
    <div class="footer-bottom">
        <p>&copy; {{ date('Y') }} {{ $system_name }}. All rights reserved.</p>
    </div>
</footer>

<div class="toast-container"></div>
<script src="{{asset('js/toastify.min.js')}}"></script>
<script src="{{asset('js/sweetalert2.all.min.js')}}"></script>

{{-- Dark mode toggle script --}}
<script>
    (function() {
        const html = document.documentElement;
        const saved = localStorage.getItem('darkMode');
        if (saved === 'true') {
            html.classList.add('dark');
        } else if (saved === 'false') {
            html.classList.remove('dark');
        }
    })();

    function toggleDarkMode() {
        const html = document.documentElement;
        html.classList.toggle('dark');
        const isDark = html.classList.contains('dark');
        localStorage.setItem('darkMode', isDark);
        // Update icon
        const icon = document.getElementById('darkModeIcon');
        if (icon) {
            icon.textContent = isDark ? '☀️' : '🌙';
        }
    }
</script>

@yield('js')
@stack('scripts')
</body>
</html>
