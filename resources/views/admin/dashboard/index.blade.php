@extends("layouts.admin")

@section("title", "Dashboard")

@section("content")
    <main>
        <section class="admin-container">
            <div class="dashboard-welcome">
                <h1 class="text-3xl font-bold mb-2">Welcome Back, Admin!</h1>
                <p class="opacity-80">Here's what's happening on {{ $system_name }} today.</p>
            </div>

            <!-- Stats Grid -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-label">Total Users</div>
                    <div class="stat-value">{{ number_format($stats['total_users']) }}</div>
                    <div class="stat-change">Platform Members</div>
                </div>

                <div class="stat-card">
                    <div class="stat-label">Total Projects</div>
                    <div class="stat-value">{{ number_format($stats['total_projects']) }}</div>
                    <div class="stat-change">Submissions</div>
                </div>

                <div class="stat-card">
                    <div class="stat-label">Institutions</div>
                    <div class="stat-value">{{ number_format($stats['total_colleges'] + $stats['total_universities']) }}</div>
                    <div class="stat-change">Colleges & Unis</div>
                </div>

                <div class="stat-card">
                    <div class="stat-label">Knowledge Base</div>
                    <div class="stat-value">{{ number_format($stats['total_algorithms'] + $stats['total_subjects']) }}</div>
                    <div class="stat-change">Algos & Subjects</div>
                </div>
            </div>

            <div class="admin-grid">
                <!-- Recent Projects -->
                <div class="activity-card">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-lg font-bold">Recent Projects</h2>
                        <a href="{{ route('admin.projects.index') }}" class="text-sm" style="border-bottom: 1px solid var(--primary); color: var(--text);">View All</a>
                    </div>
                    <div class="space-y-4">
                        @forelse($recent_projects as $project)
                            <div class="activity-item">
                                <div class="icon-circle">📁</div>
                                <div class="flex-1">
                                    <h4 class="font-bold text-sm">{{ $project->name }}</h4>
                                    <p class="text-xs" style="color: var(--subtext);">by {{ $project->user->name ?? 'Unknown' }} • {{ $project->created_at->diffForHumans() }}</p>
                                </div>
                                <div class="text-right">
                                    <span class="badge-pill {{ $project->status ? 'badge-pill-active' : 'badge-pill-inactive' }}">
                                        {{ $project->status ? 'Active' : 'Draft' }}
                                    </span>
                                </div>
                            </div>
                        @empty
                            <p class="text-sm" style="color: var(--subtext);">No projects found.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Recent Users -->
                <div class="activity-card">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-lg font-bold">New Users</h2>
                        <a href="{{ route('admin.users.index') }}" class="text-sm" style="border-bottom: 1px solid var(--primary); color: var(--text);">View All</a>
                    </div>
                    <div class="space-y-4">
                        @forelse($recent_users as $user)
                            <div class="activity-item">
                                <div class="icon-circle">👤</div>
                                <div class="flex-1">
                                    <h4 class="font-bold text-sm">{{ $user->name }}</h4>
                                    <p class="text-xs" style="color: var(--subtext);">{{ $user->email }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-xs" style="color: var(--subtext);">{{ $user->created_at->format('M d') }}</p>
                                </div>
                            </div>
                        @empty
                            <p class="text-sm" style="color: var(--subtext);">No users found.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Quick Links / Secondary Stats -->
            <div class="admin-section">
                <h2 class="text-lg font-bold mb-6">Discovery Overview</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    <div class="overview-tile">
                        <p class="text-xs uppercase tracking-widest mb-1">Courses</p>
                        <p class="text-2xl font-bold">{{ $stats['total_courses'] }}</p>
                    </div>
                    <div class="overview-tile">
                        <p class="text-xs uppercase tracking-widest mb-1">Subjects</p>
                        <p class="text-2xl font-bold">{{ $stats['total_subjects'] }}</p>
                    </div>
                    <div class="overview-tile">
                        <p class="text-xs uppercase tracking-widest mb-1">Universities</p>
                        <p class="text-2xl font-bold">{{ $stats['total_universities'] }}</p>
                    </div>
                    <div class="overview-tile">
                        <p class="text-xs uppercase tracking-widest mb-1">Algorithms</p>
                        <p class="text-2xl font-bold">{{ $stats['total_algorithms'] }}</p>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
