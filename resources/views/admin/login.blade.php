@extends('layouts.app')

@section('title', 'Admin Login - Tagivo by Khuncode')

@section('content')
<div class="min-h-[70vh] flex flex-col items-center justify-center px-4 sm:px-6 lg:px-8 py-12">
    
    <!-- Login Card -->
    <div class="max-w-md w-full bg-surface-1 border border-hairline rounded-2xl shadow-2xl overflow-hidden">
        <!-- Accent bar -->
        <div class="h-[3px] bg-gradient-to-r from-primary to-primary-hover shadow-[0_1px_15px_rgba(94,106,210,0.4)]"></div>

        <div class="p-6 sm:p-10 space-y-8">
            <!-- Branding -->
            <div class="text-center space-y-2">
                <div class="inline-flex w-12 h-12 rounded-2xl bg-primary/10 items-center justify-center text-primary-hover shadow-inner">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                </div>
                <h2 class="text-2xl font-bold tracking-tight text-ink">Admin Area</h2>
                <p class="text-xs text-ink-subtle font-medium">Masukkan kode sandi admin untuk masuk ke dashboard statistik.</p>
            </div>

            <!-- Session Feedback -->
            @if(session('success'))
            <div class="p-3 bg-emerald-500/10 border-l-4 border-emerald-500 rounded-r-xl text-xs font-semibold text-emerald-300">
                {{ session('success') }}
            </div>
            @endif

            <!-- Errors Alert -->
            @if($errors->has('passcode'))
            <div class="p-3 bg-rose-500/10 border-l-4 border-rose-500 rounded-r-xl text-xs font-semibold text-rose-300">
                {{ $errors->first('passcode') }}
            </div>
            @endif

            <!-- Form -->
            <form action="{{ route('admin.login') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label for="passcode" class="block text-xs font-bold text-ink-subtle uppercase tracking-eyebrow mb-2">Kode Sandi Admin</label>
                    <div class="relative rounded-xl shadow-xs">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-ink-tertiary">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
                        </div>
                        <input type="password" name="passcode" id="passcode" required placeholder="••••••••" class="block w-full pl-10 pr-3 py-3 bg-surface-2 border border-hairline rounded-xl text-ink placeholder-ink-tertiary focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary/45 focus:bg-surface-3 transition duration-150 sm:text-sm">
                    </div>
                </div>

                <button type="submit" class="w-full flex justify-center py-3.5 px-4 rounded-xl text-sm font-bold text-white bg-primary hover:bg-primary-hover active:bg-primary-focus shadow-lg shadow-primary/20 hover:shadow-primary/30 transition-all duration-200">
                    Masuk ke Dashboard
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
