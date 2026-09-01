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
        <link rel="icon" href="/favicon-32x32.png" sizes="32x32" type="image/png">
        <link rel="icon" href="/favicon-16x16.png" sizes="16x16" type="image/png">

        <!-- PWA -->
        <link rel="manifest" href="/manifest.webmanifest">
        <meta name="theme-color" content="#2c3821">
        <meta name="mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
        <meta name="apple-mobile-web-app-title" content="Bumi Lestari">
        <link rel="apple-touch-icon" href="/favicon-180x180.png">

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

        {{-- Floating PWA Install Button --}}
        <button
            id="pwa-install-btn"
            type="button"
            aria-label="Instal Aplikasi"
            style="position:fixed;right:20px;bottom:20px;z-index:9999;display:none;align-items:center;gap:10px;padding:13px 20px;border:none;border-radius:50px;background:#2c3821;color:#fbf8ef;font-family:'Instrument Sans','Work Sans',sans-serif;font-weight:600;font-size:0.92rem;cursor:pointer;box-shadow:0 8px 24px rgba(44,56,33,0.45);transition:transform .2s ease,opacity .2s ease,box-shadow .2s ease;"
            onmouseover="this.style.transform='translateY(-3px)';this.style.boxShadow='0 12px 28px rgba(44,56,33,0.55)';"
            onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 8px 24px rgba(44,56,33,0.45)';"
        >
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 3v12"/><path d="m8 11 4 4 4-4"/><path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-2"/></svg>
            <span>Instal Aplikasi</span>
        </button>

        <script>
            if ('serviceWorker' in navigator) {
                window.addEventListener('load', function () {
                    navigator.serviceWorker.register('/sw.js').catch(function (err) {
                        console.error('PWA service worker registration failed:', err);
                    });
                });
            }

            (function () {
                var btn = document.getElementById('pwa-install-btn');
                var deferredPrompt = null;

                function hideBtn() { if (btn) btn.style.display = 'none'; }
                function showBtn() { if (btn) btn.style.display = 'flex'; }

                window.addEventListener('beforeinstallprompt', function (e) {
                    e.preventDefault();
                    deferredPrompt = e;
                    showBtn();
                });

                if (btn) {
                    btn.addEventListener('click', function () {
                        if (!deferredPrompt) return;
                        deferredPrompt.prompt();
                        deferredPrompt.userChoice.then(function (choice) {
                            deferredPrompt = null;
                            hideBtn();
                        });
                    });
                }

                window.addEventListener('appinstalled', function () {
                    deferredPrompt = null;
                    hideBtn();
                });
            })();
        </script>
    </body>
</html>
