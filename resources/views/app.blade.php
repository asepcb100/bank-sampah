<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"  @class(['dark' => ($appearance ?? 'system') == 'dark'])>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Primary Meta Tags -->
        <meta name="title" content="Bank Sampah Bumi Indramayu Lestari — Solusi Pengelolaan Sampah Berkelanjutan" />
        <meta name="description" content="Bank Sampah Bumi Indramayu Lestari hadir sebagai solusi pengelolaan sampah yang berkelanjutan untuk lingkungan yang lebih bersih dan sehat di Kabupaten Indramayu." />
        <meta name="keywords" content="Bank Sampah, Indramayu, Bumi Indramayu Lestari, Pengelolaan Sampah, Daur Ulang, Kompos, Eco-Enzyme, Lingkungan Hidup" />
        <meta name="author" content="Bank Sampah Bumi Indramayu Lestari" />

        <!-- Open Graph / Facebook / WhatsApp Share Meta Tags -->
        <meta property="og:type" content="website" />
        <meta property="og:url" content="{{ url()->current() }}" />
        <meta property="og:title" content="Bank Sampah Bumi Indramayu Lestari — Solusi Pengelolaan Sampah Berkelanjutan" />
        <meta property="og:description" content="Bank Sampah Bumi Indramayu Lestari hadir sebagai solusi pengelolaan sampah yang berkelanjutan untuk lingkungan yang lebih bersih dan sehat di Kabupaten Indramayu." />
        <meta property="og:image" content="{{ asset('img/bg.png') }}" />
        <meta property="og:image:secure_url" content="{{ asset('img/bg.png') }}" />
        <meta property="og:image:type" content="image/png" />
        <meta property="og:image:width" content="1200" />
        <meta property="og:image:height" content="630" />
        <meta property="og:site_name" content="Bank Sampah Bumi Indramayu Lestari" />

        <!-- Twitter Card Meta Tags for Social & WhatsApp Sharing -->
        <meta name="twitter:card" content="summary_large_image" />
        <meta name="twitter:url" content="{{ url()->current() }}" />
        <meta name="twitter:title" content="Bank Sampah Bumi Indramayu Lestari — Solusi Pengelolaan Sampah Berkelanjutan" />
        <meta name="twitter:description" content="Bank Sampah Bumi Indramayu Lestari hadir sebagai solusi pengelolaan sampah yang berkelanjutan untuk lingkungan yang lebih bersih dan sehat di Kabupaten Indramayu." />
        <meta name="twitter:image" content="{{ asset('img/bg.png') }}" />

        {{-- Inline script to detect system dark mode preference and apply it immediately --}}
        <script>
            (function() {
                const appearance = '{{ $appearance ?? "system" }}';

                if (appearance === 'system') {
                    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

                    if (prefersDark) {
                        document.documentElement.classList.add('dark');
                    }
                }
            })();
        </script>

        {{-- Inline style to set the HTML background color based on our theme in app.css --}}
        <style>
            html {
                background-color: oklch(1 0 0);
            }

            html.dark {
                background-color: oklch(0.145 0 0);
            }
        </style>

        <link rel="icon" href="/favicon.ico" sizes="any">
        <link rel="icon" href="/favicon.svg" type="image/svg+xml">

        <!-- PWA -->
        <link rel="manifest" href="/manifest.webmanifest">
        <meta name="theme-color" content="#2c3821">
        <meta name="mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
        <meta name="apple-mobile-web-app-title" content="Bumi Lestari">
        <link rel="apple-touch-icon" href="/icon-192x192.png">

        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,300..900;1,300..900&family=Fraunces:ital,opsz,wght@0,9..144,400;0,9..144,600;1,9..144,500&display=swap" rel="stylesheet" />

        @fonts

        @vite(['resources/css/app.css', 'resources/js/app.ts', "resources/js/pages/{$page['component']}.vue"])
        <x-inertia::head>
            <title>{{ config('app.name', 'Laravel') }}</title>
        </x-inertia::head>
    </head>
    <body class="font-sans antialiased">
        <x-inertia::app />

        <script>
            if ('serviceWorker' in navigator) {
                window.addEventListener('load', function () {
                    navigator.serviceWorker.register('/sw.js').catch(function (err) {
                        console.error('PWA service worker registration failed:', err);
                    });
                });
            }
        </script>
    </body>
</html>
