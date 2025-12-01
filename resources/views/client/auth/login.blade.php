@extends('layouts.guest')

@section('content')
    <div class="auth-container">
        <div class="auth-wrapper">

            <!-- Banner Section -->
            <div class="auth-banner">
                <div class="auth-banner-icon">👤</div>
                <h2>Hello Client</h2>
                <p>Login to access your {{ getSystemInfo('system_title', 'ProjectSanjal') }} dashboard</p>
            </div>

            <!-- Login Form Section -->
            <div class="auth-form-section">
                <form class="auth-form" id="loginForm" action="{{ route('client.login') }}" method="POST">
                    @csrf

                    <!-- Logo -->
                    <div class="form-logo">
                        <div class="logo-icon">C</div>
                        <div>
                            <h3 style="margin: 0;">{{ getSystemInfo('system_title', 'ProjectSanjal') }}</h3>
                            <p style="margin: 0; font-size: 12px; color: var(--subtext)">
                                {{ getSystemInfo('system_short_description', 'Share & Collaborate IT Projects') }}
                            </p>
                        </div>
                    </div>

                    <h1 class="form-title">Client Login</h1>
                    <p class="form-subtitle">Enter your credentials to continue</p>

                    @if ($errors->any())
                        <div class="alert-error">
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif

                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" required value="{{ old('email') }}"
                            placeholder="you@example.com">
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" required placeholder="Enter your password">
                    </div>

                    <button type="submit" class="btn">Login</button>
                </form>
            </div>

        </div>
    </div>

    <script>
        document.getElementById("loginForm").addEventListener("submit", handleLogin)
    </script>
@endsection
