<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- Theme --}}
    <script async>
        async function applyTheme(theme) {
            document.documentElement.setAttribute('data-bs-theme', theme);
            localStorage.setItem('theme', theme);
        }
        async function applyThemeIcon(theme) {
            const icon = document.getElementById('theme-icon');
            if (!icon) return;
            icon.classList.remove('ti-sun', 'ti-moon');
            icon.classList.add(theme === 'light' ? 'ti-sun' : 'ti-moon');
        }
        (async function() {
            const savedTheme = localStorage.getItem('theme');
            const theme = (savedTheme === 'dark' || savedTheme === 'light') ? savedTheme : 'light';
            await applyTheme(theme);
        })();
    </script>
    {{-- SEO --}}
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <title>@yield('title', config('app.name'))</title>
    <meta name="description" content="@yield('meta-description', 'Halaman website resmi ' . config('app.name') . '.')">
    <meta name="keywords" content="@yield('meta-keywords', 'website sekolah, sman 6 tangerang')">
    <meta name="robots" content="index, follow">
    <meta http-equiv="X-Content-Type-Options" content="nosniff">
    <meta http-equiv="Referrer-Policy" content="strict-origin-when-cross-origin">
    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    {{-- CSS --}}
    <link rel="stylesheet" href="{{ asset('static/css/bootstrap.min.css') }}">
    @stack('css')
</head>
<body>
    @yield('layout')
    {{-- JS --}}
    <script src="{{ asset('static/js/bootstrap.bundle.min.js') }}" defer></script>
    @stack('js')
    {{-- Custom CSS Handle --}}
    <style>
        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus,
        input:-webkit-autofill:active {
            -webkit-box-shadow: 0 0 0 0 transparent inset !important;
            box-shadow: 0 0 0 0 transparent inset !important;
            color: var(--bs-body-color) !important;
        }
        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus,
        input:-webkit-autofill:active {
            -webkit-text-fill-color: var(--bs-body-color) !important;
        }
    </style>
</body>
</html>
