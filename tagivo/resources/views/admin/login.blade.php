@extends('layouts.app')

@section('title', 'Admin Login - Tagivo by Khuncode')

@section('content')
<div class="min-h-[70vh] flex flex-col items-center justify-center px-4 sm:px-6 lg:px-8 py-12">
    
    <!-- Login Card -->
    <div class="max-w-md w-full bg-white border border-slate-100 rounded-3xl shadow-xl shadow-slate-100/50 overflow-hidden">
        <!-- Accent bar -->
        <div class="h-2 bg-gradient-to-r from-indigo-500 via-violet-500 to-indigo-600"></div>

        <div class="p-6 sm:p-10 space-y-8">
            <!-- Branding -->
            <div class="text-center space-y-2">
                <div class="inline-flex w-12 h-12 rounded-2xl bg-indigo-50 items-center justify-center text-indigo-600 shadow-inner">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                </div>
                <h2 class="text-2xl font-bold tracking-tight text-slate-900">Admin Area</h2>
                <p class="text-xs text-slate-400 font-medium">Masukkan kode sandi admin untuk masuk ke dashboard statistik.</p>
            </div>

            <!-- Session Feedback -->
            @if(session('success'))
            <div class="p-3 bg-emerald-50 border-l-4 border-emerald-500 rounded-r-lg text-xs font-semibold text-emerald-800">
                {{ session('success') }}
            </div>
            @endif

            <!-- Errors Alert -->
            @if($errors->has('passcode'))
            <div class="p-3 bg-rose-50 border-l-4 border-rose-500 rounded-r-lg text-xs font-semibold text-rose-800">
                {{ $errors->first('passcode') }}
            </div>
            @endif

            <!-- Form -->
            <form action="{{ route('admin.login') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label for="passcode" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Kode Sandi Admin</label>
                    <div class="relative rounded-xl shadow-xs">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
                        </div>
                        <input type="password" name="passcode" id="passcode" required placeholder="••••••••" class="block w-full pl-10 pr-3 py-3 border border-slate-200 rounded-xl text-slate-800 placeholder-slate-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                </div>

                <button type="submit" class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-xl text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 shadow-md shadow-indigo-100 transition-colors">
                    Masuk ke Dashboard
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
