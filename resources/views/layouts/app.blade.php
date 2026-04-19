<!DOCTYPE html>
<html>
<head>
    <title>Medicure Hospital System</title>

    <link rel="stylesheet" href="{{ asset('style.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>

<body>

    {{-- SIDEBAR --}}
    @include('partials.sidebar')

    {{-- TOP NAVBAR --}}
    @include('partials.navbar')

    {{-- FLASH MESSAGES --}}
    <div class="main">
        @include('partials.flash')

        {{-- PAGE CONTENT --}}
        @yield('content')
    </div>

    {{-- FOOTER --}}
    <div class="footer">
        © {{ date('Y') }} | NABUKEERA ROSEMARY KEEYA | VU-BCS-2307-0996 | Advanced Software Development
    </div>

    @stack('scripts')

</body>
</html>