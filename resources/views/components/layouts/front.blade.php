@props(['title' => null, 'description' => null])

<!DOCTYPE html>
<html lang="es" class="h-full scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ $title ?? 'Inicio' }} · {{ config('app.name', 'Library') }}</title>

        @if ($description)
            <meta name="description" content="{{ $description }}">
        @endif

        @include('partials.theme-init')

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-slate-50 font-sans text-slate-900 antialiased dark:bg-slate-950 dark:text-slate-100">
        <a
            href="#main-content"
            class="sr-only focus:not-sr-only focus:absolute focus:left-4 focus:top-4 focus:z-[60] focus:rounded-lg focus:bg-white focus:px-4 focus:py-2 focus:text-sm focus:font-medium focus:text-slate-900 focus:shadow-lg dark:focus:bg-slate-900 dark:focus:text-slate-100"
        >
            Ir al contenido
        </a>

        <header class="sticky top-0 z-40 border-b border-slate-200/80 bg-white/85 backdrop-blur dark:border-slate-800/80 dark:bg-slate-950/85">
            <div class="mx-auto flex h-16 max-w-7xl items-center justify-between gap-3 px-4 sm:px-6 lg:px-8">
                <a href="{{ route('front.home') }}" class="group flex min-w-0 items-center gap-2.5">
                    <span class="flex size-9 shrink-0 items-center justify-center rounded-xl bg-indigo-600 text-white shadow-sm transition-transform group-hover:-translate-y-0.5">
                        <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.5v13m0-13c-2.2-1.5-5.1-2-8-1.5v12c2.9-.5 5.8 0 8 1.5m0-13c2.2-1.5 5.1-2 8-1.5v12c-2.9-.5-5.8 0-8 1.5" />
                        </svg>
                    </span>

                    <span class="hidden min-w-0 sm:block">
                        <span class="block truncate text-sm font-semibold">{{ config('app.name', 'Library') }}</span>
                        <span class="block text-xs text-slate-500 dark:text-slate-400">Biblioteca digital</span>
                    </span>
                </a>

                <nav class="flex items-center gap-1" aria-label="Navegación principal">
                    <a
                        href="{{ route('front.home') }}"
                        @class([
                            'rounded-xl px-3 py-2 text-sm font-medium transition-colors',
                            'bg-indigo-50 text-indigo-700 dark:bg-indigo-500/10 dark:text-indigo-300' => request()->routeIs('front.home'),
                            'text-slate-600 hover:bg-slate-100 hover:text-slate-900 dark:text-slate-400 dark:hover:bg-slate-800/70 dark:hover:text-slate-100' => ! request()->routeIs('front.home'),
                        ])
                        @if (request()->routeIs('front.home')) aria-current="page" @endif
                    >
                        Inicio
                    </a>

                    <a
                        href="{{ route('front.books.index') }}"
                        @class([
                            'rounded-xl px-3 py-2 text-sm font-medium transition-colors',
                            'bg-indigo-50 text-indigo-700 dark:bg-indigo-500/10 dark:text-indigo-300' => request()->routeIs('front.books.*'),
                            'text-slate-600 hover:bg-slate-100 hover:text-slate-900 dark:text-slate-400 dark:hover:bg-slate-800/70 dark:hover:text-slate-100' => ! request()->routeIs('front.books.*'),
                        ])
                        @if (request()->routeIs('front.books.*')) aria-current="page" @endif
                    >
                        Libros
                    </a>
                </nav>

                <div class="flex items-center gap-1 sm:gap-2">
                    @auth
                        <a
                            href="{{ route('dashboard') }}"
                            class="inline-flex size-10 items-center justify-center rounded-xl text-slate-600 transition-colors hover:bg-slate-100 hover:text-slate-900 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500 dark:text-slate-400 dark:hover:bg-slate-800 dark:hover:text-slate-100 sm:hidden"
                            aria-label="Ir al panel"
                            title="Ir al panel"
                        >
                            <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6.75a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.5 20.25a7.5 7.5 0 0 1 15 0" />
                            </svg>
                        </a>
                    @else
                        <a
                            href="{{ route('login') }}"
                            class="inline-flex size-10 items-center justify-center rounded-xl text-slate-600 transition-colors hover:bg-slate-100 hover:text-slate-900 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500 dark:text-slate-400 dark:hover:bg-slate-800 dark:hover:text-slate-100 sm:hidden"
                            aria-label="Acceso"
                            title="Acceso"
                        >
                            <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6A2.25 2.25 0 0 0 5.25 5.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                            </svg>
                        </a>
                    @endauth

                    <button
                        type="button"
                        data-theme-toggle
                        class="inline-flex size-10 items-center justify-center rounded-xl text-slate-600 transition-colors hover:bg-slate-100 hover:text-slate-900 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500 dark:text-slate-400 dark:hover:bg-slate-800 dark:hover:text-slate-100"
                        aria-label="Cambiar tema"
                        title="Cambiar tema"
                    >
                        <svg class="size-5 dark:hidden" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79Z" />
                        </svg>

                        <svg class="hidden size-5 dark:block" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1.5m0 15V21m9-9h-1.5M4.5 12H3m15.36-6.36-1.06 1.06M6.7 17.3l-1.06 1.06m12.72 0-1.06-1.06M6.7 6.7 5.64 5.64M16.5 12a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0Z" />
                        </svg>
                    </button>

                    @auth
                        <a
                            href="{{ route('dashboard') }}"
                            class="hidden items-center justify-center rounded-xl border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 shadow-sm transition-colors hover:bg-slate-50 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200 dark:hover:bg-slate-800 sm:inline-flex"
                        >
                            Panel
                        </a>
                    @else
                        <a
                            href="{{ route('login') }}"
                            class="hidden items-center justify-center rounded-xl bg-slate-900 px-4 py-2 text-sm font-medium text-white shadow-sm transition-colors hover:bg-slate-800 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500 dark:bg-white dark:text-slate-900 dark:hover:bg-slate-100 sm:inline-flex"
                        >
                            Acceso
                        </a>
                    @endauth
                </div>
            </div>
        </header>

        <main id="main-content" class="mx-auto w-full max-w-7xl px-4 py-10 sm:px-6 lg:px-8 lg:py-14">
            @if (session('success'))
                <div class="mb-8 flex items-start gap-3 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800 dark:border-emerald-500/30 dark:bg-emerald-500/10 dark:text-emerald-300">
                    <svg class="mt-0.5 size-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m9 12.75 2.25 2.25L15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>

                    <p>{{ session('success') }}</p>
                </div>
            @endif

            {{ $slot }}
        </main>

        <footer class="border-t border-slate-200 bg-white dark:border-slate-800 dark:bg-slate-900">
            <div class="mx-auto flex max-w-7xl flex-col gap-4 px-4 py-8 sm:flex-row sm:items-center sm:justify-between sm:px-6 lg:px-8">
                <p class="text-sm text-slate-500 dark:text-slate-400">
                    © {{ date('Y') }} {{ config('app.name', 'Library') }}. Todos los derechos reservados.
                </p>

                <nav class="flex items-center gap-4 text-sm font-medium" aria-label="Navegación del pie de página">
                    <a href="{{ route('front.home') }}" class="text-slate-600 transition-colors hover:text-indigo-600 dark:text-slate-400 dark:hover:text-indigo-400">
                        Inicio
                    </a>

                    <a href="{{ route('front.books.index') }}" class="text-slate-600 transition-colors hover:text-indigo-600 dark:text-slate-400 dark:hover:text-indigo-400">
                        Libros
                    </a>
                </nav>
            </div>
        </footer>

        @stack('scripts')
    </body>
</html>
