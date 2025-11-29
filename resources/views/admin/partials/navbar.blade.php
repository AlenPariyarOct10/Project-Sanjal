<header>
    <nav class="container navbar">
        <div class="logo">Admin Hub</div>
        <ul class="nav-links">
            <li><a class="{{ Route::is('admin.dashboard') ? 'active' : '' }} " href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li><a class="{{ Route::is('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">Users</a></li>
            <li><a class="{{ Route::is('admin.algorithms.*') ? 'active' : '' }}" href="{{ route('admin.algorithms.index') }}">Algorithms</a></li>
            <li><a class="{{ Route::is('admin.colleges.*') ? 'active' : '' }}" href="{{ route('admin.colleges.index') }}">Colleges</a></li>
            <li><a class="{{ Route::is('admin.universities.*') ? 'active' : '' }}" href="{{ route('admin.universities.index') }}">Universities</a></li>
            <li>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-sm text-white">Logout</button>
                </form>
            </li>
        </ul>

        <button class="nav-toggle">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </nav>
</header>
