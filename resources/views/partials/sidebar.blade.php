<aside class="sidebar">
    <div class="sidebar-header">
        <a class="brand" href="{{ route('dashboard') }}">
            <div class="brand-mark">S</div>
            <div>
                <div class="brand-title">Admin Scoala</div>
                <div class="brand-subtitle">Dashboard</div>
            </div>
        </a>
        <button class="btn btn-light btn-icon d-lg-none" data-sidebar-toggle type="button" aria-label="Deschide meniul">
            <i class="bi bi-list"></i>
        </button>
    </div>

    <nav class="sidebar-nav">
        <a class="nav-link @if(Route::currentRouteName() == 'dashboard') active @endif" href="{{ route('dashboard') }}">
            <i class="bi bi-speedometer2"></i>Dashboard
        </a>
        <a class="nav-link @if(Route::currentRouteName() == 'teachers.index' || str_contains(Route::currentRouteName(), 'teachers')) active @endif" href="{{ route('teachers.index') }}">
            <i class="bi bi-mortarboard"></i>Profesori
        </a>
        <a class="nav-link @if(Route::currentRouteName() == 'timetables.index' || str_contains(Route::currentRouteName(), 'timetables')) active @endif" href="{{ route('timetables.index') }}">
            <i class="bi bi-calendar3"></i>Orar
        </a>
    </nav>

    <div class="sidebar-card">
        <h6>Stare Campus</h6>
        <p class="mb-2">Aplicatia este functionala.</p>
        <div class="badge-soft success">
            <i class="bi bi-check-circle"></i>
            <span>Totul ok</span>
        </div>
    </div>
</aside>
