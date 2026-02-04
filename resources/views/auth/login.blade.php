<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex items-center justify-center bg-base-200">

    <div class="card w-full max-w-sm shadow-xl bg-base-100">
        <div class="card-body gap-4">
            <h1 class="text-2xl font-bold text-center">
                Login
            </h1>

            <p class="text-center text-sm text-base-content/70">
                Masuk menggunakan akun Google
            </p>

            <div class="divider">OR</div>

            <a
                href="{{ route('auth.google.redirect') }}"
                class="btn btn-outline w-full flex items-center gap-2"
            >
                {{-- Google icon (SVG, ringan & tidak perlu library tambahan) --}}
                <svg class="w-5 h-5" viewBox="0 0 48 48">
                    <path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.23 9.21 3.64l6.85-6.85C35.9 2.42 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"/>
                    <path fill="#4285F4" d="M46.5 24c0-1.64-.15-3.22-.43-4.74H24v9.02h12.7c-.55 2.96-2.21 5.47-4.7 7.18l7.2 5.59C43.98 36.58 46.5 30.79 46.5 24z"/>
                    <path fill="#FBBC05" d="M10.54 28.41c-.48-1.45-.76-2.99-.76-4.41s.27-2.96.76-4.41l-7.98-6.19C.92 16.24 0 20.01 0 24s.92 7.76 2.56 11.19l7.98-6.78z"/>
                    <path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.9-5.81l-7.2-5.59c-2 1.35-4.56 2.15-8.7 2.15-6.26 0-11.57-4.22-13.46-9.91l-7.98 6.78C6.51 42.62 14.62 48 24 48z"/>
                </svg>

                <span>Login dengan Google</span>
            </a>
        </div>
    </div>

</body>
</html>
