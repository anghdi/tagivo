<!DOCTYPE html>
<html lang="id" class="h-full dark bg-canvas text-ink">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Tagivo by Khuncode - Simple Invoice Generator')</title>

    <script>
        // Check local storage theme preference as early as possible
        if (localStorage.getItem('theme') === 'light') {
            document.documentElement.classList.remove('dark');
        }
    </script>

    <!-- Meta SEO -->
    <meta name="description" content="Buat, kelola, dan bagikan invoice profesional secara instan dengan Tagivo. Tanpa registrasi, ramah mobile, dan cepat.">
    <meta name="keywords" content="invoice generator, invoice online, buat invoice gratis, tagihan online, invoice mobile-first">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.png') }}">

    <!-- Google Fonts Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Fonts & CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Custom Page Styles -->
    @yield('styles')
</head>
<body class="h-full font-text antialiased bg-canvas text-ink">
    <!-- Main Wrapper -->
    <div class="min-h-full flex flex-col justify-between">

        <!-- Header / Navigation -->
        <header class="bg-canvas/70 backdrop-blur-md border-b border-hairline sticky top-0 z-40">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <div class="flex items-center">
                        <a href="{{ route('invoices.index') }}" class="flex items-center gap-2 group">
                            <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-primary to-primary-hover flex items-center justify-center shadow-md shadow-primary/20 group-hover:scale-105 transition-transform duration-200">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <span class="text-xl font-bold tracking-tight text-ink flex items-baseline gap-1">
                                Tagivo <span class="text-xs font-semibold text-primary tracking-normal">by Khuncode</span>
                            </span>
                        </a>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="hidden md:inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-primary/10 text-primary-hover border border-primary/20">
                            Fase MVP v1.0
                        </span>
                        <a href="{{ route('invoices.index') }}" class="text-sm font-medium text-ink-muted hover:text-ink transition-colors">
                            Buat Baru
                        </a>
                        
                        <!-- Theme Toggle Button -->
                        <button type="button" id="themeToggleBtn" class="p-2 text-ink-muted hover:text-ink hover:bg-surface-2 rounded-xl transition duration-150 focus:outline-none print:hidden" aria-label="Toggle theme">
                            <!-- Sun Icon (shown in dark mode) -->
                            <svg id="themeSunIcon" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m2.828-9.9a5 5 0 117.072 7.072l-7.072-7.072z"></path>
                            </svg>
                            <!-- Moon Icon (shown in light mode) -->
                            <svg id="themeMoonIcon" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                            </svg>
                        </button>
                        
                        <a href="https://tako.id/khuncode" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 bg-rose-500/10 hover:bg-rose-500/20 border border-rose-500/20 text-rose-400 font-bold rounded-xl text-xs transition duration-200 shadow-xs print:hidden">
                            <svg class="w-3.5 h-3.5 fill-rose-400" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                            </svg>
                            Donasi Server
                        </a>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-grow">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-canvas border-t border-hairline py-8 mt-12 print:hidden">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 text-center sm:flex sm:items-center sm:justify-between">
                <p class="text-sm text-ink-subtle">
                    &copy; {{ date('Y') }} <strong>Tagivo by Khuncode</strong>. Semua Hak Cipta Dilindungi.
                </p>
                <p class="text-xs text-ink-tertiary mt-2 sm:mt-0">
                    Dibuat oleh <a href="https://tako.id/khuncode" target="_blank" rel="noopener noreferrer" class="text-primary hover:text-primary-hover font-semibold hover:underline">Khuncode</a> untuk Kecepatan &amp; Kemudahan.
                </p>
            </div>
        </footer>

    </div>

    <!-- Script: Theme Toggle Implementation -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const toggleBtn = document.getElementById('themeToggleBtn');
            if (toggleBtn) {
                toggleBtn.addEventListener('click', () => {
                    const isDark = document.documentElement.classList.toggle('dark');
                    localStorage.setItem('theme', isDark ? 'dark' : 'light');
                    updateToggleIcon(isDark);
                });
                
                // Initial icon setup
                const isDark = document.documentElement.classList.contains('dark');
                updateToggleIcon(isDark);
            }
        });

        function updateToggleIcon(isDark) {
            const sunIcon = document.getElementById('themeSunIcon');
            const moonIcon = document.getElementById('themeMoonIcon');
            if (sunIcon && moonIcon) {
                if (isDark) {
                    sunIcon.classList.remove('hidden');
                    moonIcon.classList.add('hidden');
                } else {
                    sunIcon.classList.add('hidden');
                    moonIcon.classList.remove('hidden');
                }
            }
        }
    </script>

    <!-- Scripts -->
    @yield('scripts')
</body>
</html>
