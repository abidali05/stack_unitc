<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('images/favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/6.1.9/index.global.min.css" rel="stylesheet"> --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <title>UnitC</title>
    <style>
        .page-loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.9);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1050;
            display: none;
        }

        .page-loader .spinner {
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
            width: 50px;
            height: 50px;
        }

        .page-loader .spinner-border {
            position: absolute;
            width: 50px;
            height: 50px;
            border: 4px solid #f3f3f3;
            border-top: 4px solid #3498db;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        .page-loader .logo-image {
            position: absolute;
            width: 30px;
            height: auto;
            z-index: 2;
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }
    </style>
</head>

<body>
    <div class="page-loader" id="pageLoader">
        <div class="spinner">
            <div class="spinner-border"></div>
            <img src="{{ asset('svg/logo.svg') }}" alt="Logo" class="logo-image">
        </div>
    </div>

    <div>
        <main>
            <header>
                @include('layouts.topbar')
            </header>
            <article>
                @if (!empty($showModal) && $showModal)
                    @include('layouts.welcome-modal')
                @endif
                @yield('content')
            </article>
            <aside>
                @include('layouts.aside')
            </aside>
        </main>
        <div class="backdrop" id="backdrop"></div>
    </div>
    @stack('scripts')
    <script>
        const csrfToken = '{{ csrf_token() }}';

        window.addEventListener('beforeunload', () => {
            document.getElementById('pageLoader').style.display = 'flex';
        });

        window.addEventListener('pageshow', () => {
            document.getElementById('pageLoader').style.display = 'none';
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
    <script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('js/common.js') }}"></script>
    <script src="{{ asset('js/snap.js') }}"></script>
</body>

</html>
