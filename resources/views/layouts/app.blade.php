<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Football League Manager</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 5 CDN with dark theme override -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #1e1e2f;
            color: #f5f5f5;
        }
        .navbar, .card {
            background-color: #2a2a3c;
        }
        .btn-primary {
            background-color: #d97706;
            border-color: #d97706;
        }
        .btn-primary:hover {
            background-color: #b45309;
            border-color: #b45309;
        }
        a {
            color: #facc15;
        }
        a:hover {
            color: #fde68a;
        }
        .form-control, .form-select {
            background-color: #2a2a3c;
            color: #f5f5f5;
            border: 1px solid #4b5563;
        }

        .page-link {
            background-color: #2a2a3c;
            color: #facc15;
            border: 1px solid #4b5563;
        }

        .page-link:hover {
            background-color: #facc15;
            color: #2a2a3c;
        }

        .page-item.active .page-link {
            background-color: #d97706;
            border-color: #d97706;
            color: white;
        }

        .nav-tabs {
            border-bottom: 1px solid #444;
        }

        .nav-tabs .nav-link {
            background-color: #1e1e2f;
            color: #ccc;
            border: none;
            border-radius: 0;
            padding: 10px 16px;
            margin-right: 4px;
            font-weight: 500;
        }

        .nav-tabs .nav-link:hover {
            color: #facc15;
            background-color: #2a2a3d;
        }

        .nav-tabs .nav-link.active {
            background-color: #111;
            color: #f8f9fa;
            border-bottom: 3px solid #facc15;
            font-weight: 600;
        }

        .tab-content {
            margin-top: 20px;
        }

    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark mb-4">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('home') }}">Football League Manager</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ route('leagues.index') }}">Leagues</a></li>
                    @auth
                        <li class="nav-item">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="btn btn-link nav-link">Logout</button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Register</a></li>
                    @endauth
                    <form method="POST" action="{{ route('locale.switch') }}" class="ms-3 d-inline">
                        @csrf
                        <select name="locale" onchange="this.form.submit()" class="form-select form-select-sm bg-dark text-light" style="width: auto;">
                            <option value="en" {{ app()->getLocale() == 'en' ? 'selected' : '' }}>🇬🇧 EN</option>
                            <option value="lv" {{ app()->getLocale() == 'lv' ? 'selected' : '' }}>🇱🇻 LV</option>
                        </select>
                    </form>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container">
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
