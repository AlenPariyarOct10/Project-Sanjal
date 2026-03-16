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

        .ghost-btn {
            background: transparent;
            border: 2px solid #e2e8f0;
            color: #64748b;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .ghost-btn:hover {
            border-color: #4f46e5;
            color: #4f46e5;
        }

        .alert-success {
            background: #f0fdf4;
            color: #166534;
            padding: 1rem;
            border-radius: 1rem;
            margin-bottom: 1.5rem;
            border: 1px solid #bbf7d0;
            font-size: 0.875rem;
        }

        .mail-icon-pulse {
            animation: pulse-ring 2.5s cubic-bezier(0.455, 0.03, 0.515, 0.955) infinite;
        }

        @keyframes pulse-ring {
            0% { box-shadow: 0 0 0 0 rgba(79, 70, 229, 0.3); }
            70% { box-shadow: 0 0 0 20px rgba(79, 70, 229, 0); }
            100% { box-shadow: 0 0 0 0 rgba(79, 70, 229, 0); }
        }

        .float-animation {
            animation: float 5s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-12px); }
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

            <!-- Left Info Section -->
            <div class="hidden lg:flex flex-col items-center justify-center space-y-8">
                <div class="float-animation">
                    <svg class="w-72 h-72 text-indigo-100" viewBox="0 0 400 400" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="40" y="100" width="320" height="220" rx="20" fill="#eef2ff" stroke="#c7d2fe" stroke-width="3"/>
                        <path d="M40 130 L200 230 L360 130" stroke="#a5b4fc" stroke-width="3" fill="none"/>
                        <rect x="120" y="160" width="80" height="10" rx="5" fill="#c7d2fe"/>
                        <rect x="120" y="180" width="120" height="8" rx="4" fill="#ddd6fe"/>
                        <rect x="120" y="196" width="100" height="8" rx="4" fill="#ddd6fe"/>
                        <!-- envelope flap -->
                        <path d="M40 100 L200 210 L360 100 Z" fill="#c7d2fe" opacity="0.6"/>
                        <!-- sparkles -->
                        <circle cx="340" cy="80" r="8" fill="#6366f1"/>
                        <circle cx="60" cy="90" r="5" fill="#ec4899"/>
                        <circle cx="360" cy="300" r="6" fill="#8b5cf6"/>
                    </svg>
                </div>

                <div class="text-center space-y-3">
                    <h1 class="text-5xl font-extrabold text-slate-900 leading-tight">
                        Check Your <span class="gradient-text">Inbox</span>
                    </h1>
                    <p class="text-slate-500 text-lg max-w-sm">
                        We've sent a confirmation link to your email. Click it to activate your account instantly.
                    </p>
                </div>

                <div class="flex items-center gap-6 pt-4">
                    <div class="flex flex-col items-center gap-1">
                        <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <p class="text-xs font-bold text-slate-500">Email Sent</p>
                    </div>
                    <div class="h-px w-12 bg-slate-200"></div>
                    <div class="flex flex-col items-center gap-1">
                        <div class="w-10 h-10 bg-slate-100 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                            </svg>
                        </div>
                        <p class="text-xs font-bold text-slate-400">Click Link</p>
                    </div>
                    <div class="h-px w-12 bg-slate-200"></div>
                    <div class="flex flex-col items-center gap-1">
                        <div class="w-10 h-10 bg-slate-100 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <p class="text-xs font-bold text-slate-400">Account Active</p>
                    </div>
                </div>
            </div>

            <!-- Verification Card -->
            <div class="w-full max-w-md mx-auto">
                <div class="card-premium p-8 md:p-12">
                    <!-- Logo & Back -->
                    <div class="flex justify-between items-start mb-10">
                        <a href="/" class="flex items-center gap-2 group">
                            <span class="text-slate-900 font-bold text-xl tracking-tight hidden sm:block">
                                {{ getSystemInfo('system_title', 'ProjectSanjal') }}
                            </span>
                        </a>
                        <a href="{{ route('client.login') }}" class="text-slate-400 hover:text-indigo-600 text-sm font-bold flex items-center gap-1 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                            Back to Login
                        </a>
                    </div>

                    <!-- Mail Icon -->
                    <div class="flex justify-center mb-8">
                        <div class="mail-icon-pulse w-20 h-20 bg-indigo-600 rounded-2xl flex items-center justify-center shadow-lg shadow-indigo-200">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    </div>

                    <div class="mb-6 text-center">
                        <h2 class="text-3xl font-extrabold text-slate-900 mb-2">Verify Your Email</h2>
                        <p class="text-slate-500 font-medium">
                            A verification link has been sent to your email address. Please click the link to activate your account.
                        </p>
                    </div>

                    @if (session('status') == 'verification-link-sent')
                        <div class="alert-success flex items-start gap-2">
                            <svg class="w-4 h-4 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            A new verification link has been sent to your registered email address.
                        </div>
                    @endif

                    <div class="space-y-4">
                        <!-- Resend verification -->
                        <form method="POST" action="{{ route('verification.send') }}">
                            @csrf
                            <button type="submit" class="gradient-btn w-full py-4 rounded-2xl text-base shadow-xl shadow-indigo-100 group">
                                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                                Resend Verification Email
                            </button>
                        </form>

                        <!-- Logout -->
                        <form method="POST" action="{{ route('client.logout') }}">
                            @csrf
                            <button type="submit" class="ghost-btn w-full py-4 rounded-2xl text-base">
                                Log Out
                            </button>
                        </form>
                    </div>

                    <div class="mt-8 pt-6 border-t border-slate-50">
                        <p class="text-xs text-slate-400 text-center leading-relaxed">
                            Didn't receive the email? Check your <strong>spam/junk folder</strong>. The link expires in 60 minutes.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
