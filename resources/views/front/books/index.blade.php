<x-layouts.front
    title="Libros"
    description="Explora la colección completa de libros disponibles en formato PDF."
>
    <div class="space-y-8">
        <x-page-header title="Libros" description="Explora nuestra colección completa y encuentra tu próxima lectura.">
            <x-slot:actions>
                <a
                    href="{{ route('front.home') }}"
                    class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 shadow-sm transition-colors hover:bg-slate-50 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200 dark:hover:bg-slate-800"
                >
                    <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                    </svg>

                    Volver al inicio
                </a>
            </x-slot:actions>
        </x-page-header>

        <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div class="flex flex-wrap items-center gap-2">
                    <span class="mr-1 text-xs font-semibold uppercase tracking-wider text-slate-400 dark:text-slate-500">
                        Filtrar
                    </span>

                    <a
                        href="{{ route('front.books.index') }}"
                        @class([
                            'rounded-full px-3 py-1.5 text-sm font-medium transition-colors',
                            'bg-indigo-600 text-white shadow-sm' => $selectedCategoryId === null,
                            'text-slate-600 hover:bg-slate-100 hover:text-slate-900 dark:text-slate-400 dark:hover:bg-slate-800 dark:hover:text-slate-100' => $selectedCategoryId !== null,
                        ])
                    >
                        Todas
                    </a>

                    @foreach ($categories as $category)
                        <a
                            href="{{ route('front.books.index', ['category' => $category->id]) }}"
                            @class([
                                'rounded-full px-3 py-1.5 text-sm font-medium transition-colors',
                                'bg-indigo-600 text-white shadow-sm' => $selectedCategoryId === $category->id,
                                'text-slate-600 hover:bg-slate-100 hover:text-slate-900 dark:text-slate-400 dark:hover:bg-slate-800 dark:hover:text-slate-100' => $selectedCategoryId !== $category->id,
                            ])
                        >
                            {{ ucfirst($category->name) }}
                        </a>
                    @endforeach
                </div>

                <p class="text-sm text-slate-500 dark:text-slate-400">
                    {{ $books->total() }} {{ $books->total() === 1 ? 'libro' : 'libros' }}
                </p>
            </div>
        </div>

        @if ($books->isEmpty())
            <div class="rounded-2xl border border-dashed border-slate-300 bg-white p-12 text-center dark:border-slate-700 dark:bg-slate-900">
                <span class="mx-auto flex size-14 items-center justify-center rounded-full bg-slate-100 text-slate-500 dark:bg-slate-800 dark:text-slate-400">
                    <svg class="size-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                    </svg>
                </span>

                <h3 class="mt-4 text-base font-semibold text-slate-900 dark:text-slate-100">
                    {{ $selectedCategoryId === null ? 'Todavía no hay libros publicados' : 'No encontramos libros en esta categoría' }}
                </h3>

                <p class="mx-auto mt-1.5 max-w-sm text-sm text-slate-500 dark:text-slate-400">
                    {{ $selectedCategoryId === null
                        ? 'La colección está creciendo. Vuelve pronto para descubrir nuevas lecturas.'
                        : 'Prueba con otra categoría o explora la colección completa.' }}
                </p>

                <a
                    href="{{ $selectedCategoryId === null ? route('front.home') : route('front.books.index') }}"
                    class="mt-6 inline-flex items-center justify-center rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-medium text-white shadow-sm transition-colors hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                >
                    {{ $selectedCategoryId === null ? 'Volver al inicio' : 'Ver todos los libros' }}
                </a>
            </div>
        @else
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($books as $book)
                    <x-front.book-card :book="$book" />
                @endforeach
            </div>

            @if ($books->hasPages())
                <div class="rounded-2xl border border-slate-200 bg-white px-6 py-4 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                    {{ $books->links() }}
                </div>
            @endif
        @endif
    </div>
</x-layouts.front>
