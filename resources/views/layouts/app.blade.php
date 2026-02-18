<!doctype html>
<html lang="ro" data-theme="school">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin Scoala')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Literata:wght@400;600;700&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/themes/theme-school.css') }}" rel="stylesheet">
    <link href="{{ asset('css/themes/theme-corporate.css') }}" rel="stylesheet">
    <link href="{{ asset('css/themes/theme-dark.css') }}" rel="stylesheet">

    @yield('styles')
</head>
<body data-page="@yield('page-name')" data-base="./">
    <div class="app-shell">
        @include('partials.sidebar')

        <div class="app-main">
            @include('partials.topbar')

            <main class="content container-fluid">
                @if($errors->any())
                    <div class="alert alert-danger mb-4">
                        <h6 class="alert-heading"><i class="bi bi-exclamation-triangle"></i> Eroare</h6>
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if(session('success'))
                    <div class="alert alert-success mb-4 alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </main>

            @include('partials.footer')
        </div>
    </div>

    <div class="sidebar-overlay"></div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/theme.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>

    @yield('scripts')
</body>
</html>
