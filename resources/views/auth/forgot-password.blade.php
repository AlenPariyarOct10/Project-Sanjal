@extends('layouts.guest')

@section('content')
    <div class="auth-container">

        <!-- Forgot Password Section -->
        <div class="auth-form-section">
            <form class="auth-form" id="forgotPasswordForm" method="POST" action="{{ route('password.email') }}">
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
                <h1 class="form-title">Forgot Password?</h1>
                <p class="form-subtitle">
                    Enter your email and we will send you a password reset link.
                </p>

                <!-- Status Message -->
                @if (session('status'))
                    <div class="alert-success">
                        {{ session('status') }}
                    </div>
                @endif

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

                <!-- Submit Button -->
                <button type="submit" class="btn">Send Password Reset Link</button>

                <!-- Back to Login -->
                <p style="text-align: center; color: var(--subtext); margin-top: 20px;">
                    Remember your password?
                    <a href="{{ route('login') }}" class="form-link">Go back to login</a>
                </p>

            </form>
        </div>
    </div>

    <script>
        document.getElementById("forgotPasswordForm").addEventListener("submit", function (e) {
            // You can add custom JS here if needed
        });
    </script>
@endsection
