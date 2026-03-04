@extends('layouts.guest')

@section('css')
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
            padding: 1rem 1.25rem;
            transition: all 0.3s ease;
            width: 100%;
            outline: none;
        }

        .input-premium:focus {
            border-color: #4f46e5;
            background: white;
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
        }

        .alert-error {
            background: #fef2f2;
            color: #991b1b;
            padding: 1rem;
            border-radius: 1rem;
            margin-bottom: 1.5rem;
            border: 1px solid #fee2e2;
            font-size: 0.875rem;
        }

        .float-animation {
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-15px) rotate(1deg); }
        }
    </style>
@endsection

@section('content')
    <div class="min-h-screen flex items-center justify-center p-6 dot-pattern relative overflow-hidden">
        <!-- Background Accents -->
        <div class="fixed inset-0 overflow-hidden pointer-events-none -z-10">
            <div class="absolute -top-40 -right-40 w-96 h-96 bg-indigo-50 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-pulse"></div>
            <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-pink-50 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-pulse" style="animation-delay: 2s;"></div>
        </div>

        <div class="max-w-6xl w-full grid lg:grid-cols-2 gap-12 items-center relative z-10">
            
            <!-- Left Info Section (Hero-like) -->
            <div class="hidden lg:block space-y-8">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-indigo-50 border border-indigo-100 text-indigo-700 text-xs font-bold">
                    <span class="flex h-2 w-2 rounded-full bg-indigo-500 animate-ping"></span>
                    WELCOME BACK TO PROJECT SANJAL
                </div>
                
                <h1 class="text-6xl font-extrabold text-slate-900 leading-[1.1]">
                    Manage Your <br>
                    <span class="gradient-text">Projects</span> & <br>
                    Collaboration
                </h1>
                
                <p class="text-slate-600 text-xl leading-relaxed max-w-lg">
                    Login to your account to continue sharing your innovative IT projects with the community of Nepal.
                </p>

                <div class="grid grid-cols-2 gap-6 pt-8">
                    <div class="p-6 card-premium border-none shadow-indigo-100/50">
                        <p class="text-3xl font-black text-slate-900 mb-1">500+</p>
                        <p class="text-slate-500 font-medium">Active Projects</p>
                    </div>
                    <div class="p-6 card-premium border-none shadow-indigo-100/50">
                        <p class="text-3xl font-black text-indigo-600 mb-1">2K+</p>
                        <p class="text-slate-500 font-medium">Builders</p>
                    </div>
                </div>
            </div>

            <!-- Login Form Card -->
            <div class="w-full max-w-md mx-auto">
                <div class="card-premium p-8 md:p-12">
                    <!-- Logo & Back Link -->
                    <div class="flex justify-between items-start mb-10">
                        <a href="/" class="flex items-center gap-2 group">
                            <!-- <div class="w-10 h-10 bg-indigo-600 text-white flex items-center justify-center text-sm font-bold rounded-xl group-hover:rotate-12 transition-transform shadow-lg shadow-indigo-200">

                            </div> -->
                            <span class="text-slate-900 font-bold text-xl tracking-tight hidden sm:block">
                                {{ getSystemInfo('system_title', 'ProjectSanjal') }}
                            </span>
                        </a>
                        <a href="/" class="text-slate-400 hover:text-indigo-600 text-sm font-bold flex items-center gap-1 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                            Back Home
                        </a>
                    </div>

                    <div class="mb-10">
                        <h2 class="text-3xl font-extrabold text-slate-900 mb-2">Client Login</h2>
                        <p class="text-slate-500 font-medium">Enter your credentials to continue your journey.</p>
                    </div>

                    @if ($errors->any())
                        <div class="alert-error">
                            @foreach ($errors->all() as $error)
                                <p class="flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                    {{ $error }}
                                </p>
                            @endforeach
                        </div>
                    @endif

                    <form class="space-y-6" id="loginForm" action="{{ route('client.login') }}" method="POST">
                        @csrf

                        <div class="space-y-2">
                            <label for="email" class="text-sm font-bold text-slate-700 ml-1">Email Address</label>
                            <input type="email" id="email" name="email" required value="{{ old('email') }}"
                                class="input-premium" placeholder="name@college.edu.np">
                        </div>

                        <div class="space-y-2">
                            <div class="flex justify-between items-center px-1">
                                <label for="password" class="text-sm font-bold text-slate-700">Password</label>
                                <a href="#" class="text-xs font-bold text-indigo-600 hover:text-indigo-700">Forgot Password?</a>
                            </div>
                            <input type="password" id="password" name="password" required 
                                class="input-premium" placeholder="••••••••">
                        </div>

                        <div class="flex items-center gap-3 px-1">
                            <input type="checkbox" id="remember" name="remember" class="w-4 h-4 text-indigo-600 border-slate-300 rounded focus:ring-indigo-500">
                            <label for="remember" class="text-sm font-bold text-slate-500 cursor-pointer">Remember me</label>
                        </div>

                        <button type="submit" class="gradient-btn w-full py-4 rounded-2xl text-lg shadow-xl shadow-indigo-100 mt-4 group">
                            Login Now
                            <span class="inline-block transform group-hover:translate-x-1 transition-transform ml-1">→</span>
                        </button>
                    </form>

                    <div class="mt-10 pt-8 border-t border-slate-50 text-center">
                        <p class="text-slate-500 font-medium text-sm">
                            Don't have an account yet? 
                            <a href="{{ route('client.register') }}" class="text-indigo-600 font-bold hover:underline">Register here</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Keep existing script but update it if needed for the new UI elements -->
    <script>
        document.getElementById("loginForm").addEventListener("submit", handleLogin)
    </script>
@endsection
