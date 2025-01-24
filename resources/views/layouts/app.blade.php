<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ $attributes->get('title', config('app.name', 'Laravel')) }}</title>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <!-- Scripts -->
        <script src="https://cdn.tiny.cloud/1/k2kh8xz745b3fcj8lk7sx9g5pzgwrw7fzwmjha1kb0x1t3gq/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
        @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/tiny.css', 'resources/js/tiny.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900 flex-container">
            @include('layouts.navigation')
            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif
            <!-- Page Content -->
            <main class="main-content">
                {{ $slot }}
            </main>
            <!-- Footer -->
            @include('layouts.footer')
        </div>
    </body>
</html>
