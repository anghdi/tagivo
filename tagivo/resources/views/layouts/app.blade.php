<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50/50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Tagivo by Khuncode - Simple Invoice Generator')</title>

    <!-- Meta SEO -->
    <meta name="description" content="Buat, kelola, dan bagikan invoice profesional secara instan dengan Tagivo. Tanpa registrasi, ramah mobile, dan cepat.">
    <meta name="keywords" content="invoice generator, invoice online, buat invoice gratis, tagihan online, invoice mobile-first">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.png') }}">

    <!-- Fonts & CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Custom Page Styles -->
    @yield('styles')
</head>
<body class="h-full font-sans antialiased text-slate-800">
    <!-- Main Wrapper -->
    <div class="min-h-full flex flex-col justify-between">

        <!-- Header / Navigation -->
        <header class="bg-white/80 backdrop-blur-md border-b border-slate-100 sticky top-0 z-40">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <div class="flex items-center">
                        <a href="{{ route('invoices.index') }}" class="flex items-center gap-2 group">
                            <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-indigo-600 to-violet-500 flex items-center justify-center shadow-md shadow-indigo-200 group-hover:scale-105 transition-transform duration-200">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <span class="text-xl font-bold tracking-tight bg-gradient-to-r from-slate-900 to-indigo-950 bg-clip-text text-transparent flex items-baseline gap-1">
                                Tagivo <span class="text-xs font-semibold text-indigo-500/80 tracking-normal">by Khuncode</span>
                            </span>
                        </a>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="hidden md:inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-100">
                            Fase MVP v1.0
                        </span>
                        <a href="{{ route('invoices.index') }}" class="text-sm font-medium text-slate-600 hover:text-indigo-600 transition-colors">
                            Buat Baru
                        </a>
                        <a href="https://tako.id/khuncode" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 bg-rose-50 hover:bg-rose-100 border border-rose-150 text-rose-700 font-bold rounded-xl text-xs transition duration-200 shadow-xs print:hidden">
                            <svg class="w-3.5 h-3.5 fill-rose-600" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
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
        <footer class="bg-white border-t border-slate-100 py-8 mt-12 print:hidden">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 text-center sm:flex sm:items-center sm:justify-between">
                <p class="text-sm text-slate-500">
                    &copy; {{ date('Y') }} <strong>Tagivo by Khuncode</strong>. Semua Hak Cipta Dilindungi.
                </p>
                <p class="text-xs text-slate-400 mt-2 sm:mt-0">
                    Dibuat oleh <a href="https://tako.id/khuncode" target="_blank" rel="noopener noreferrer" class="text-indigo-600 font-semibold hover:underline">Khuncode</a> untuk Kecepatan &amp; Kemudahan.
                </p>
            </div>
        </footer>

    </div>

    <!-- Scripts -->
    @yield('scripts')
</body>
</html>
