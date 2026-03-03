<header>
    <nav class="container navbar">
        <div class="logo">
            @if($system_logo)
                <img src="{{ $system_logo }}" alt="{{ $system_name }}" style="height:32px;object-fit:contain;vertical-align:middle;margin-right:6px;display:inline;">
            @endif
            {{ $system_name }}</div>
        <ul class="nav-links">
            <li><a class="{{ Route::is('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li><a class="{{ Route::is('admin.roles.*') ? 'active' : '' }}" href="{{ route('admin.roles.index') }}">Roles</a></li>
            <li><a class="{{ Route::is('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">Users</a></li>
            <li><a class="{{ Route::is('admin.projects.*') ? 'active' : '' }}" href="{{ route('admin.projects.index') }}">Projects</a></li>
            <li><a class="{{ Route::is('admin.algorithms.*') ? 'active' : '' }}" href="{{ route('admin.algorithms.index') }}">Algorithms</a></li>
            <li><a class="{{ Route::is('admin.colleges.*') ? 'active' : '' }}" href="{{ route('admin.colleges.index') }}">Colleges</a></li>
            <li><a class="{{ Route::is('admin.courses.*') ? 'active' : '' }}" href="{{ route('admin.courses.index') }}">Courses</a></li>
            <li><a class="{{ Route::is('admin.subjects.*') ? 'active' : '' }}" href="{{ route('admin.subjects.index') }}">Subjects</a></li>
            <li><a class="{{ Route::is('admin.universities.*') ? 'active' : '' }}" href="{{ route('admin.universities.index') }}">Universities</a></li>
            <li><a class="{{ Route::is('admin.tags.*') ? 'active' : '' }}" href="{{ route('admin.tags.index') }}">Tags</a></li>
            <li><a class="{{ Route::is('admin.system_settings.*') ? 'active' : '' }}" href="{{ route('admin.system_settings.index') }}">⚙ Settings</a></li>
            <li><a class="{{ Route::is('admin.system_infos.*') ? 'active' : '' }}" href="{{ route('admin.system_infos.index') }}">System Info</a></li>
            <li>
                <button class="dark-mode-toggle" onclick="toggleDarkMode()" title="Toggle Dark Mode">
                    <span id="darkModeIcon">{{ session('dark_mode', false) ? '☀️' : '🌙' }}</span>
                </button>
            </li>
            <li>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-sm">Logout</button>
                </form>
            </li>
        </ul>

        <button class="nav-toggle" onclick="document.querySelector('.nav-links').classList.toggle('active')">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </nav>
</header>

<script>
    // Fix dark mode icon on page load
    document.addEventListener('DOMContentLoaded', function() {
        const isDark = document.documentElement.classList.contains('dark');
        const icon = document.getElementById('darkModeIcon');
        if (icon) icon.textContent = isDark ? '☀️' : '🌙';
    });
</script>
