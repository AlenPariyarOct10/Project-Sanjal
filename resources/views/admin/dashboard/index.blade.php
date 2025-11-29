@extends("layouts.admin")

@section("content")
    <main>
        <section class="admin-container">
            <div class="admin-header">
                <h1>Dashboard</h1>
                <p>System Overview & Statistics</p>
            </div>

            <!-- Stats Grid -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-label">Total Users</div>
                    <div class="stat-value" id="totalUsers">0</div>
                    <div class="stat-change">+12% this month</div>
                </div>

                <div class="stat-card">
                    <div class="stat-label">Total Projects</div>
                    <div class="stat-value" id="totalProjects">0</div>
                    <div class="stat-change">+5 this week</div>
                </div>

                <div class="stat-card">
                    <div class="stat-label">Active Colleges</div>
                    <div class="stat-value" id="totalColleges">0</div>
                    <div class="stat-change">Across Nepal</div>
                </div>

                <div class="stat-card">
                    <div class="stat-label">Total Algorithms</div>
                    <div class="stat-value" id="totalAlgorithms">0</div>
                    <div class="stat-change">13 categories</div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="admin-section">
                <h2>Recent Projects</h2>
                <div id="recentProjects" class="projects-table">
                    <!-- Populated by JS -->
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="admin-grid">
                <div class="card">
                    <h3>Technology Usage</h3>
                    <div id="techStats" class="stats-list">
                        <!-- Populated by JS -->
                    </div>
                </div>

                <div class="card">
                    <h3>Top Algorithms</h3>
                    <div id="algorithmStats" class="stats-list">
                        <!-- Populated by JS -->
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
