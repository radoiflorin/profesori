<header class="topbar">
    <div class="topbar-row">
        <div class="topbar-title">
            <h1>@yield('topbar-title', 'Dashboard')</h1>
            <span>@yield('topbar-subtitle', 'Administrare scoala')</span>
        </div>
        <div class="topbar-user">
            <select class="form-select form-select-sm" id="theme-select" aria-label="Schimba tema">
                <option value="school">School</option>
                <option value="corporate">Corporate</option>
                <option value="dark">Dark</option>
            </select>
        </div>
    </div>
</header>
