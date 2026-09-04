---
paths:
  - vite.config.ts
---

# General

## NAS build must not invoke PHP (no Inertia/wayfinder)
The Synology NAS has PHP 8.1.9 which fails composer (needs >=8.4.1), so `vite build` must never call `php artisan` (the @laravel/vite-plugin-wayfinder plugin did this and broke the build). The app is now fully Blade-rendered — do NOT re-add Inertia, the vue plugin, or the wayfinder plugin to vite.config.ts. Build is just laravel-vite-plugin + @tailwindcss/vite with a minimal resources/js/app.ts. On the server use `php84` for any artisan/composer command.
