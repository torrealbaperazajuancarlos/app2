@props(['title' => null])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ $title ?? 'Sign in' }} · {{ config('app.name', 'Library') }}</title>

        @include('partials.theme-init')

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-slate-50 font-sans text-slate-900 antialiased dark:bg-slate-950 dark:text-slate-100">
        <a
            href="#auth-content"
            class="sr-only focus:not-sr-only focus:absolute focus:left-4 focus:top-4 focus:z-[60] focus:rounded-lg focus:bg-white focus:px-4 focus:py-2 focus:text-sm focus:font-medium focus:text-slate-900 focus:shadow-lg dark:focus:bg-slate-900 dark:focus:text-slate-100"
        >
            Skip to content
        </a>

        <div class="relative flex min-h-screen items-center justify-center overflow-hidden px-4 py-10 sm:px-6">
            <div class="pointer-events-none absolute inset-0 -z-10 bg-[radial-gradient(circle_at_top,_rgba(99,102,241,0.14),_transparent_38%)] dark:bg-[radial-gradient(circle_at_top,_rgba(99,102,241,0.18),_transparent_34%)]"></div>

            <div class="w-full max-w-md">
                <div class="mb-8 flex items-center justify-between gap-4">
                    <a href="{{ url('/') }}" class="group flex items-center gap-3">
                        <span class="flex size-10 items-center justify-center rounded-xl bg-indigo-600 text-white shadow-sm transition-transform group-hover:-translate-y-0.5">
                            <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.5v13m0-13c-2.2-1.5-5.1-2-8-1.5v12c2.9-.5 5.8 0 8 1.5m0-13c2.2-1.5 5.1-2 8-1.5v12c-2.9-.5-5.8 0-8 1.5" />
                            </svg>
                        </span>

                        <span class="min-w-0">
                            <span class="block truncate text-sm font-semibold">{{ config('app.name', 'Library') }}</span>
                            <span class="block text-xs text-slate-500 dark:text-slate-400">Library manager</span>
                        </span>
                    </a>

                    <button
                        type="button"
                        data-theme-toggle
                        class="inline-flex size-10 items-center justify-center rounded-xl text-slate-600 transition-colors hover:bg-white hover:text-slate-900 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500 dark:text-slate-400 dark:hover:bg-slate-900 dark:hover:text-slate-100"
                        aria-label="Toggle theme"
                        title="Toggle theme"
                    >
                        <svg class="size-5 dark:hidden" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79Z" />
                        </svg>

                        <svg class="hidden size-5 dark:block" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1.5m0 15V21m9-9h-1.5M4.5 12H3m15.36-6.36-1.06 1.06M6.7 17.3l-1.06 1.06m12.72 0-1.06-1.06M6.7 6.7 5.64 5.64M16.5 12a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0Z" />
                        </svg>
                    </button>
                </div>

                <main
                    id="auth-content"
                    class="rounded-3xl border border-slate-200 bg-white p-6 shadow-xl shadow-slate-900/5 sm:p-8 dark:border-slate-800 dark:bg-slate-900 dark:shadow-black/20"
                >
                    {{ $slot }}
                </main>

                <p class="mt-6 text-center text-xs text-slate-500 dark:text-slate-400">
                    Secure access to your library management workspace.
                </p>
            </div>
        </div>

        @stack('scripts')
    </body>
</html>
