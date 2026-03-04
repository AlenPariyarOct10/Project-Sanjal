@extends('layouts.guest')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/tom-select.css') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Outfit:wght@400;600;700;800&display=swap');

        :root {
            --primary: #4f46e5;
            --bg-light: #f8fafc;
            --text-main: #0f172a;
            --text-soft: #475569;
            --border-soft: #f1f5f9;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-light);
            color: var(--text-main);
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        h1, h2, h3 {
            font-family: 'Outfit', sans-serif;
        }

        .dot-pattern {
            background-image: radial-gradient(#e2e8f0 1px, transparent 1px);
            background-size: 24px 24px;
        }

        .card-premium {
            background: white;
            border: 1px solid var(--border-soft);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.08);
            border-radius: 2.5rem;
        }

        .gradient-text {
            background: linear-gradient(135deg, #4f46e5 0%, #db2777 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .gradient-btn {
            background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            color: white;
            font-weight: 700;
            border: none;
        }

        .gradient-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(79, 70, 229, 0.4);
        }

        .input-premium {
            background: #f8fafc;
            border: 2px solid #f1f5f9;
            border-radius: 1rem;
            padding: 0.875rem 1.25rem;
            transition: all 0.3s ease;
            width: 100%;
            outline: none;
        }

        .input-premium:focus {
            border-color: #4f46e5;
            background: white;
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
        }

        /* TomSelect Overrides to match premium style */
        .ts-control {
            background: #f8fafc !important;
            border: 2px solid #f1f5f9 !important;
            border-radius: 1rem !important;
            padding: 0.875rem 1.25rem !important;
            box-shadow: none !important;
        }
        .ts-control.focus {
            border-color: #4f46e5 !important;
            background: white !important;
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1) !important;
        }
        .ts-dropdown {
            border-radius: 1rem !important;
            border: 1px solid var(--border-soft) !important;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1) !important;
            margin-top: 5px !important;
        }

        .alert-error-box {
            background: #fef2f2;
            color: #991b1b;
            padding: 1rem;
            border-radius: 1rem;
            margin-bottom: 1.5rem;
            border: 1px solid #fee2e2;
            font-size: 0.875rem;
        }
    </style>
@endsection

@section('content')
    <div class="min-h-screen py-12 flex items-center justify-center p-6 dot-pattern relative overflow-hidden">
        <!-- Background Accents -->
        <div class="fixed inset-0 overflow-hidden pointer-events-none -z-10">
            <div class="absolute -top-40 -right-40 w-96 h-96 bg-indigo-50 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-pulse"></div>
            <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-pink-50 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-pulse" style="animation-delay: 2s;"></div>
        </div>

        <div class="max-w-6xl w-full grid lg:grid-cols-2 gap-12 items-center relative z-10">
            
            <!-- Left Info Section -->
            <div class="hidden lg:block space-y-8">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-indigo-50 border border-indigo-100 text-indigo-700 text-xs font-bold">
                    <span class="flex h-2 w-2 rounded-full bg-indigo-500 animate-ping"></span>
                    JOIN THE NEPAL IT ECOSYSTEM
                </div>
                
                <h1 class="text-6xl font-extrabold text-slate-900 leading-[1.1]">
                    Start Your <br>
                    <span class="gradient-text">Journey</span> With <br>
                    Project Sanjal
                </h1>
                
                <p class="text-slate-600 text-xl leading-relaxed max-w-lg">
                    Creating an account allows you to showcase your academic work, collaborate with peers, and get noticed by top colleges and industries.
                </p>

                <div class="flex flex-col gap-4">
                    <div class="flex items-center gap-4 p-4 card-premium border-none shadow-sm">
                        <div class="w-12 h-12 bg-indigo-100 text-indigo-600 rounded-2xl flex items-center justify-center text-xl">🚀</div>
                        <div>
                            <p class="font-bold text-slate-900">Showcase Effortlessly</p>
                            <p class="text-slate-500 text-sm">Upload and manage your projects with ease.</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4 p-4 card-premium border-none shadow-sm">
                        <div class="w-12 h-12 bg-pink-100 text-pink-600 rounded-2xl flex items-center justify-center text-xl">🤝</div>
                        <div>
                            <p class="font-bold text-slate-900">Expert Feedback</p>
                            <p class="text-slate-500 text-sm">Get reviews and likes from the community.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Register Form Card -->
            <div class="w-full max-w-xl mx-auto">
                <div class="card-premium p-8 md:p-12">
                    <!-- Logo & Back Link -->
                    <div class="flex justify-between items-start mb-8">
                        <a href="/" class="flex items-center gap-2 group">
                            <!-- <div class="w-10 h-10 bg-indigo-600 text-white flex items-center justify-center text-sm font-bold rounded-xl group-hover:rotate-12 transition-transform shadow-lg shadow-indigo-200">
                                {{ substr(config('app.name', 'P'), 0, 1) }}
                            </div> -->
                            <span class="text-slate-900 font-bold text-xl tracking-tight">
                                {{ config('app.name', 'ProjectSanjal') }}
                            </span>
                        </a>
                        <a href="{{ route('client.login') }}" class="text-indigo-600 hover:text-indigo-700 text-sm font-bold flex items-center gap-1 transition-colors">
                            Login instead
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                    </div>

                    <div class="mb-8">
                        <h2 class="text-3xl font-extrabold text-slate-900 mb-2">Create Account</h2>
                        <p class="text-slate-500 font-medium">Join Nepal's most active student community.</p>
                    </div>

                    @if ($errors->any())
                        <div class="alert-error-box mb-6">
                            <ul class="list-disc list-inside space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form class="space-y-5" id="registerForm" action="{{ route('client.register') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="space-y-2">
                            <label for="name" class="text-sm font-bold text-slate-700 ml-1">Full Name</label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" required
                                class="input-premium" placeholder="John Doe">
                        </div>

                        <div class="space-y-2">
                            <label for="email" class="text-sm font-bold text-slate-700 ml-1">Email Address</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                class="input-premium" placeholder="name@college.edu.np">
                        </div>

                        <div class="grid sm:grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <label for="password" class="text-sm font-bold text-slate-700 ml-1">Password</label>
                                <input type="password" id="password" name="password" required 
                                    class="input-premium" placeholder="••••••••">
                            </div>
                            <div class="space-y-2">
                                <label for="password_confirmation" class="text-sm font-bold text-slate-700 ml-1">Confirm Password</label>
                                <input type="password" id="password_confirmation" name="password_confirmation" required 
                                    class="input-premium" placeholder="••••••••">
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label for="college_id" class="text-sm font-bold text-slate-700 ml-1">Your College</label>
                            <select id="college_id" name="college_id" required>
                                <option value="">Select College</option>
                                @foreach (\App\Models\College::where('status', true)->get() as $college)
                                    <option value="{{ $college->id }}" {{ old('college_id') == $college->id ? 'selected' : '' }}>
                                        {{ $college->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="space-y-2">
                            <label for="role_id" class="text-sm font-bold text-slate-700 ml-1">Account Type</label>
                            <select name="role_id" id="role_id" required class="input-premium appearance-none">
                                <option value="">Select Role</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                        {{ $role->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex items-center gap-3 px-1">
                            <input type="checkbox" id="terms" name="terms" required class="w-4 h-4 text-indigo-600 border-slate-300 rounded focus:ring-indigo-500">
                            <label for="terms" class="text-sm font-bold text-slate-500 cursor-pointer">I agree to the <a href="#" class="text-indigo-600">Terms of Service</a></label>
                        </div>

                        <button type="submit" class="gradient-btn w-full py-4 rounded-2xl text-lg shadow-xl shadow-indigo-100 mt-2 group">
                            Create My Account
                            <span class="inline-block transform group-hover:translate-x-1 transition-transform ml-1">→</span>
                        </button>
                    </form>

                    <div class="mt-8 pt-6 border-t border-slate-50 text-center">
                        <p class="text-slate-400 font-medium text-sm italic">
                            By joining, you agree to our community guidelines for project sharing.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/tom-select.complete.min.js') }}"></script>
    <script>
        new TomSelect("#college_id", {
            allowEmptyOption: true,
            create: false,
            searchField: ['text'],
            render: {
                no_results: function(data, escape) {
                    return '<div class="no-results p-4 text-slate-400">No colleges found</div>';
                }
            }
        });
    </script>
@endsection
