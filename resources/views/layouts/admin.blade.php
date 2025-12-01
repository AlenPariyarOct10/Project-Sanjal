<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Nepal IT Project Hub</title>
    @vite(['resources/css/styles.css', 'resources/css/admin.css', 'resources/css/app.css'])
    @yield('css')
    @stack('styles')
    <link rel="stylesheet" href="{{asset('css/sweetalert2.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/toastify.min.css')}}">
    <style>
        .modal {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.55);
            justify-content: center;
            align-items: center;
            z-index: 9999;
            transition: opacity 0.2s ease-out;
        }

        .modal-show {
            opacity: 1;
        }

        .modal-hide {
            opacity: 0;
        }

        .modal-content {
            background: white;
            width: 100%;
            max-width: 600px;
            padding: 20px;
            animation: fadeInUp .2s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
@include("admin.partials.navbar")

@yield('content')
<footer>
    <div class="container footer-content">
        <div class="footer-section">
            <h4>{{getSystemInfo("system_title", "ProjectSanjal")}}</h4>
            <p>Connecting developers and projects across Nepal</p>
        </div>
        <div class="footer-section">
            <h4>Quick Links</h4>
            <ul>
                <li><a href="index.html">Home</a></li>
                <li><a href="projects.html">Projects</a></li>
                <li><a href="admin-dashboard.html">Admin</a></li>
            </ul>
        </div>
    </div>
    <div class="footer-bottom">
        <p>&copy; 2025 Nepal IT Project Hub. All rights reserved.</p>
    </div>
</footer>

<div class="toast-container"></div>
<script src="{{asset('js/toastify.min.js')}}"></script>
<script src="{{asset('js/sweetalert2.all.min.js')}}"></script>
@yield('js')
@stack('scripts')
</body>
</html>
