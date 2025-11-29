@extends('layouts.guest')
@section('css')
    <link rel="stylesheet" href="{{asset('css/tom-select.css')}}">

@endsection

@section('content')
<div class="auth-container">
    <div class="auth-wrapper">
        <!-- Banner Section -->
        <div class="auth-banner">
            <div class="auth-banner-icon">🚀</div>
            <h2>Join the Community</h2>
            <p>Create your account and start sharing your amazing IT projects with the Nepali tech community</p>
        </div>

        <!-- Register Form Section -->
        <div class="auth-form-section">
            <form class="auth-form" id="registerForm">
                <!-- Logo -->
                <div class="form-logo">
                    <div class="logo-icon">N</div>
                    <div>
                        <h3 style="margin: 0">{{ config('app.name', 'Laravel') }}</h3>
                        <p style="margin: 0; font-size: 12px; color: var(--subtext)">Project Sharing Platform</p>
                    </div>
                </div>

                <!-- Title -->
                <h1 class="form-title">Create Account</h1>
                <p class="form-subtitle">Join thousands of developers sharing their projects</p>

                <!-- Alert Container -->
                <div id="alertContainer"></div>

                <!-- Name Fields -->
                <div class="form-group-row">
                    <div class="form-group">
                        <label for="firstName">First Name</label>
                        <input
                            type="text"
                            id="firstName"
                            name="firstName"
                            placeholder="John"
                            required
                        />
                    </div>
                    <div class="form-group">
                        <label for="lastName">Last Name</label>
                        <input
                            type="text"
                            id="lastName"
                            name="lastName"
                            placeholder="Doe"
                            required
                        />
                    </div>
                </div>

                <!-- Email Field -->
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        placeholder="you@example.com"
                        required
                    />
                </div>

                <!-- University/College -->
                <div class="form-group-row">
                    <div class="form-group">
                        <label for="university">University</label>
                        <select id="university" name="university" required>
                            <option value="">Select University</option>
                            <option value="tribhuvan">Tribhuvan University</option>
                            <option value="kathmandu">Kathmandu University</option>
                            <option value="pokhara">Pokhara University</option>
                            <option value="purbanchal">Purbanchal University</option>
                            <option value="other">Other</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="college">College</label>
                        <select id="college" name="college" required>
                            <option value="">Select College</option>
                        </select>
                    </div>
                </div>


                <!-- Password Field -->
                <div class="form-group">
                    <label for="password">Password</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Min 8 characters with uppercase, number & symbol"
                        required
                    />
                    <div class="password-strength">
                        <div class="password-strength-bar" id="strengthBar"></div>
                    </div>
                    <p class="password-strength-text" id="strengthText"></p>
                </div>

                <!-- Confirm Password Field -->
                <div class="form-group">
                    <label for="confirmPassword">Confirm Password</label>
                    <input
                        type="password"
                        id="confirmPassword"
                        name="confirmPassword"
                        placeholder="Re-enter your password"
                        required
                    />
                </div>

                <!-- Terms Checkbox -->
                <label class="form-check">
                    <input type="checkbox" name="terms" required />
                    <span>I agree to the Terms of Service and Privacy Policy</span>
                </label>

                <!-- Register Button -->
                <button type="submit" class="btn" style="margin-top: var(--sp-24)">
                    Create My Account
                </button>

                <!-- Divider -->
                <div class="form-divider">
                    <span>or sign up with</span>
                </div>

                <!-- Social Sign Up -->
                <div class="social-auth">
                    <button type="button" class="social-btn" onclick="socialSignUp('google')">
                        🔍 Google
                    </button>
                    <button type="button" class="social-btn" onclick="socialSignUp('github')">
                        💻 GitHub
                    </button>
                </div>

                <!-- Login Link -->
                <p style="text-align: center; color: var(--subtext)">
                    Already have an account?
                    <a href="{{ route('login') }}" class="form-link">Login here</a>
                </p>
            </form>
        </div>
    </div>
</div>
<script src="{{asset('js/tom-select.complete.min.js')}}"></script>
<script>
    new TomSelect("#university",{
        allowEmptyOption: true,
        create: false,
        searchField: ['text']
    });
    new TomSelect("#college",{
        allowEmptyOption: true,
        create: false,
        searchField: ['text']
    });
    document.getElementById("registerForm").addEventListener("submit", handleRegister)
    document.getElementById("password").addEventListener("input", checkPasswordStrength)
</script>
@endsection
