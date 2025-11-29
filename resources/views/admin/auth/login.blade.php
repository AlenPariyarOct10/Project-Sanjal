@extends('layouts.guest')

@section('content')
    <div class="auth-container">
        <div class="auth-wrapper">

            <!-- Banner Section -->
            <div class="auth-banner">
                <div class="auth-banner-icon">👨‍💻</div>
                <h2>Welcome Back</h2>
                <p>Access your {{ config('app.name', 'Laravel') }} account to collaborate and share your projects</p>
            </div>

            <!-- Login Form Section -->
            <div class="auth-form-section">
                <form class="auth-form" id="loginForm" action="{{ route('admin.login') }}" method="POST">
                    @csrf

                    <!-- Logo -->
                    <div class="form-logo">
                        <div class="logo-icon">N</div>
                        <div>
                            <h3 style="margin: 0">{{ config('app.name', 'Laravel') }}</h3>
                            <p style="margin: 0; font-size: 12px; color: var(--subtext)">Project Sharing Platform</p>
                        </div>
                    </div>

                    <!-- Title -->
                    <h1 class="form-title">Admin Login</h1>
                    <p class="form-subtitle">Enter your credentials to access your account</p>

                    <!-- Error Messages -->
                    @if ($errors->any())
                        <div class="alert-error">
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif

                    <!-- Email Field -->
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            placeholder="you@example.com"
                            value="{{ old('email') }}"
                            required
                        />
                    </div>

                    <!-- Password Field -->
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Enter your password"
                            required
                        />
                    </div>


                    <!-- Login Button -->
                    <button type="submit" class="btn">Login to Your Account</button>





                </form>
            </div>
        </div>
    </div>
    <script>
        document.getElementById("loginForm").addEventListener("submit", handleLogin)
    </script>
@endsection
