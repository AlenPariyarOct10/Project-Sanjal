@extends('layouts.guest')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/tom-select.css') }}">
@endsection

@section('content')
    <div class="auth-container">
        <div class="auth-wrapper">
            <!-- Banner Section -->
            <div class="auth-banner">
                <div class="auth-banner-icon">🚀</div>
                <h2>Join the Community</h2>
                <p>Create your account and start sharing your amazing IT projects</p>
            </div>

            <!-- Register Form Section -->
            <div class="auth-form-section">
                <form class="auth-form" id="registerForm" method="POST" action="{{ route('client.register') }}"
                    enctype="multipart/form-data">
                    @csrf

                    <!-- Logo -->
                    <div class="form-logo">
                        <div class="logo-icon">N</div>
                        <div>
                            <h3 style="margin: 0">{{ config('app.name', 'Laravel') }}</h3>
                            <p style="margin: 0; font-size: 12px; color: var(--subtext)">Project Sharing Platform</p>
                        </div>
                    </div>

                    <h1 class="form-title">Create Account</h1>
                    <p class="form-subtitle">Join thousands of developers sharing their projects</p>

                    <!-- Alert Container -->
                    <div id="alertContainer"></div>

                    <!-- Name Fields -->
                    <div class="form-group-row">
                        <div class="form-group">
                            <label for="name">Full Name</label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}"
                                placeholder="John Doe" required />
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}"
                            placeholder="you@example.com" required />
                    </div>

                    <!-- Password Fields -->
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" placeholder="Min 8 characters" required />
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Confirm Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                            placeholder="Re-enter password" required />
                    </div>

                    <!-- Contact Info -->
                    <div class="form-group-row">
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="text" id="phone" name="phone" value="{{ old('phone') }}"
                                placeholder="9876543210">
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label>
                            <input type="text" id="address" name="address" value="{{ old('address') }}"
                                placeholder="Street Address">
                        </div>
                    </div>

                    <div class="form-group-row">
                        <div class="form-group">
                            <label for="city">City</label>
                            <input type="text" id="city" name="city" value="{{ old('city') }}">
                        </div>
                        <div class="form-group">
                            <label for="state">State</label>
                            <input type="text" id="state" name="state" value="{{ old('state') }}">
                        </div>
                        <div class="form-group">
                            <label for="country">Country</label>
                            <input type="text" id="country" name="country" value="{{ old('country') }}">
                        </div>
                    </div>

                    <!-- Social Links -->
                    <div class="form-group-row">
                        <div class="form-group"><label for="facebook">Facebook</label><input type="url" id="facebook"
                                name="facebook" value="{{ old('facebook') }}"></div>
                        <div class="form-group"><label for="twitter">Twitter</label><input type="url" id="twitter"
                                name="twitter" value="{{ old('twitter') }}"></div>
                        <div class="form-group"><label for="instagram">Instagram</label><input type="url" id="instagram"
                                name="instagram" value="{{ old('instagram') }}"></div>
                    </div>

                    <div class="form-group-row">
                        <div class="form-group"><label for="linkedin">LinkedIn</label><input type="url"
                                id="linkedin" name="linkedin" value="{{ old('linkedin') }}"></div>
                        <div class="form-group"><label for="github">GitHub</label><input type="url" id="github"
                                name="github" value="{{ old('github') }}"></div>
                        <div class="form-group"><label for="youtube">YouTube</label><input type="url"
                                id="youtube" name="youtube" value="{{ old('youtube') }}"></div>
                    </div>

                    <!-- College -->
                    <div class="form-group-row">
                        <div class="form-group">
                            <label for="college_id">College</label>
                            <select id="college_id" name="college_id">
                                <option value="">Select College</option>
                                @foreach (\App\Models\College::all() as $college)
                                    <option value="{{ $college->id }}"
                                        {{ old('college_id') == $college->id ? 'selected' : '' }}>{{ $college->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Roles -->
                    <div class="form-group">
                        <label for="role_id">Role</label>
                        <select name="role_id" id="role_id" required>
                            <option value="">Select Role</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                    {{ $role->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Description & Profile -->
                    <div class="form-group">
                        <label for="description">About Yourself</label>
                        <textarea id="description" name="description">{{ old('description') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="profile_image">Profile Image</label>
                        <input type="file" id="profile_image" name="profile_image" accept="image/*">
                    </div>

                    <!-- Terms Checkbox -->
                    <label class="form-check">
                        <input type="checkbox" name="terms" required />
                        <span>I agree to the Terms of Service and Privacy Policy</span>
                    </label>

                    <button type="submit" class="btn">Create My Account</button>

                    <p style="text-align: center; color: var(--subtext)">
                        Already have an account?
                        <a href="{{ route('client.login') }}" class="form-link">Login here</a>
                    </p>
                </form>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/tom-select.complete.min.js') }}"></script>
    <script>
        new TomSelect("#college_id", {
            allowEmptyOption: true,
            create: false,
            searchField: ['text']
        });

        // Optional: Add password strength check or other JS here
    </script>
@endsection
