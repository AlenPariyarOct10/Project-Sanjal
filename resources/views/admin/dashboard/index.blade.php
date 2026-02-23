@extends("layouts.admin")

@section("css")
    <style>
        .dashboard-welcome {
            background: linear-gradient(135deg, #000 0%, #333 100%);
            color: white;
            padding: 3rem;
            border-radius: 4px;
            margin-bottom: 2rem;
            position: relative;
            overflow: hidden;
        }
        .dashboard-welcome::after {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 300px;
            height: 300px;
            background: rgba(255,255,255,0.05);
            border-radius: 50%;
        }
        .stat-card {
            transition: all 0.3s ease;
            border-left: 4px solid #000;
        }
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        .activity-card {
            background: #fff;
            border: 1px solid var(--border);
            padding: 1.5rem;
            height: 100%;
        }
        .activity-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem 0;
            border-bottom: 1px solid #f0f0f0;
        }
        .activity-item:last-child {
            border-bottom: none;
        }
        .icon-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f8f9fa;
            color: #000;
        }
        .badge-pill {
            padding: 0.25rem 0.75rem;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
        }
    </style>
@endsection

@section("content")
    <main>
        <section class="admin-container">
            <div class="dashboard-welcome">
                <h1 class="text-3xl font-bold mb-2">Welcome Back, Admin!</h1>
                <p class="opacity-80">Here's what's happening on Nepal IT Project Hub today.</p>
            </div>

            <!-- Stats Grid -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-label">Total Users</div>
                    <div class="stat-value">{{ number_format($stats['total_users']) }}</div>
                    <div class="stat-change"><i class="fas fa-users mr-1"></i> Platform Members</div>
                </div>

                <div class="stat-card">
                    <div class="stat-label">Total Projects</div>
                    <div class="stat-value">{{ number_format($stats['total_projects']) }}</div>
                    <div class="stat-change"><i class="fas fa-project-diagram mr-1"></i> Submissions</div>
                </div>

                <div class="stat-card">
                    <div class="stat-label">Institutions</div>
                    <div class="stat-value">{{ number_format($stats['total_colleges'] + $stats['total_universities']) }}</div>
                    <div class="stat-change"><i class="fas fa-university mr-1"></i> Colleges & Unis</div>
                </div>

                <div class="stat-card">
                    <div class="stat-label">Knowledge Base</div>
                    <div class="stat-value">{{ number_format($stats['total_algorithms'] + $stats['total_subjects']) }}</div>
                    <div class="stat-change"><i class="fas fa-book mr-1"></i> Algos & Subjects</div>
                </div>
            </div>

            <div class="admin-grid">
                <!-- Recent Projects -->
                <div class="activity-card">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-lg font-bold">Recent Projects</h2>
                        <a href="{{ route('admin.projects.index') }}" class="text-sm border-b border-black">View All</a>
                    </div>
                    <div class="space-y-4">
                        @forelse($recent_projects as $project)
                            <div class="activity-item">
                                <div class="icon-circle">
                                    <i class="fas fa-code"></i>
                                </div>
                                <div class="flex-1">
                                    <h4 class="font-bold text-sm">{{ $project->name }}</h4>
                                    <p class="text-xs text-gray-500">by {{ $project->user->name ?? 'Unknown' }} • {{ $project->created_at->diffForHumans() }}</p>
                                </div>
                                <div class="text-right">
                                    <span class="badge-pill {{ $project->status ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                        {{ $project->status ? 'Active' : 'Draft' }}
                                    </span>
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500">No projects found.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Recent Users -->
                <div class="activity-card">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-lg font-bold">New Users</h2>
                        <a href="{{ route('admin.users.index') }}" class="text-sm border-b border-black">View All</a>
                    </div>
                    <div class="space-y-4">
                        @forelse($recent_users as $user)
                            <div class="activity-item">
                                <div class="icon-circle">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div class="flex-1">
                                    <h4 class="font-bold text-sm">{{ $user->name }}</h4>
                                    <p class="text-xs text-gray-500">{{ $user->email }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-xs text-gray-500">{{ $user->created_at->format('M d') }}</p>
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500">No users found.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Quick Links / Secondary Stats -->
            <div class="admin-section">
                <h2 class="text-lg font-bold mb-6">Discovery Overview</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    <div class="p-4 border border-gray-100 bg-gray-50">
                        <p class="text-xs uppercase tracking-widest text-gray-400 mb-1">Courses</p>
                        <p class="text-2xl font-bold">{{ $stats['total_courses'] }}</p>
                    </div>
                    <div class="p-4 border border-gray-100 bg-gray-50">
                        <p class="text-xs uppercase tracking-widest text-gray-400 mb-1">Subjects</p>
                        <p class="text-2xl font-bold">{{ $stats['total_subjects'] }}</p>
                    </div>
                    <div class="p-4 border border-gray-100 bg-gray-50">
                        <p class="text-xs uppercase tracking-widest text-gray-400 mb-1">Universities</p>
                        <p class="text-2xl font-bold">{{ $stats['total_universities'] }}</p>
                    </div>
                    <div class="p-4 border border-gray-100 bg-gray-50">
                        <p class="text-xs uppercase tracking-widest text-gray-400 mb-1">Algorithms</p>
                        <p class="text-2xl font-bold">{{ $stats['total_algorithms'] }}</p>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
