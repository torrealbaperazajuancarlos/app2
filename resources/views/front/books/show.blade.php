@php
    $authorName = trim(($book->author?->first_name ?? '').' '.($book->author?->last_name ?? ''));
@endphp

<x-layouts.front
    :title="$book->title"
    :description="$book->summary ?: 'Detalles del libro '.$book->title"
>
    <div class="space-y-8">
        <a
            href="{{ route('front.books.index') }}"
            class="inline-flex items-center gap-2 text-sm font-medium text-slate-600 transition-colors hover:text-indigo-600 dark:text-slate-400 dark:hover:text-indigo-400"
        >
            <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
            </svg>

            Volver a libros
        </a>

        <article class="grid gap-8 rounded-3xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900 lg:grid-cols-[minmax(0,320px)_minmax(0,1fr)] lg:p-10">
            <div class="overflow-hidden rounded-2xl bg-slate-100 shadow-sm dark:bg-slate-800">
                @if ($book->image)
                    <img
                        src="{{ Storage::url($book->image) }}"
                        alt="Portada de {{ $book->title }}"
                        class="aspect-[3/4] size-full object-cover"
                    >
                @else
                    <div class="flex aspect-[3/4] size-full flex-col items-center justify-center gap-4 bg-gradient-to-br from-indigo-500 via-indigo-600 to-violet-700 p-8 text-white">
                        <svg class="size-12 text-white/80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                        </svg>

                        <p class="text-center text-lg font-semibold">{{ $book->title }}</p>
                    </div>
                @endif
            </div>

            <div class="flex flex-col">
                <div class="flex flex-wrap items-center gap-2">
                    @if ($book->category)
                        <a
                            href="{{ route('front.books.index', ['category' => $book->category->id]) }}"
                            class="rounded-full bg-indigo-50 px-3 py-1 text-xs font-semibold text-indigo-700 transition-colors hover:bg-indigo-100 dark:bg-indigo-500/10 dark:text-indigo-300 dark:hover:bg-indigo-500/20"
                        >
                            {{ ucfirst($book->category->name) }}
                        </a>
                    @endif

                    @if ($authorName)
                        <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600 dark:bg-slate-800 dark:text-slate-300">
                            {{ $authorName }}
                        </span>
                    @endif
                </div>

                <h1 class="mt-4 text-3xl font-semibold tracking-tight text-slate-900 dark:text-slate-100 sm:text-4xl">
                    {{ $book->title }}
                </h1>

                @if ($book->summary)
                    <p class="mt-4 text-base leading-relaxed text-slate-600 dark:text-slate-400">
                        {{ $book->summary }}
                    </p>
                @endif

                <dl class="mt-8 grid gap-5 border-t border-slate-200 pt-6 dark:border-slate-800 sm:grid-cols-2">
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-slate-400 dark:text-slate-500">
                            Autor
                        </dt>
                        <dd class="mt-1 text-sm font-medium text-slate-900 dark:text-slate-100">
                            {{ $authorName ?: 'Sin autor' }}
                        </dd>
                    </div>

                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-slate-400 dark:text-slate-500">
                            Categoría
                        </dt>
                        <dd class="mt-1 text-sm font-medium text-slate-900 dark:text-slate-100">
                            {{ $book->category ? ucfirst($book->category->name) : 'Sin categoría' }}
                        </dd>
                    </div>
                </dl>

                <div class="mt-8 flex flex-wrap gap-3">
                    @if ($book->pdf)
                        <a
                            href="{{ Storage::url($book->pdf) }}"
                            target="_blank"
                            rel="noopener"
                            class="inline-flex items-center justify-center gap-2 rounded-xl bg-indigo-600 px-5 py-3 text-sm font-medium text-white shadow-sm transition-colors hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                        >
                            <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 9h6m-6 3h6m-9-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                            </svg>

                            Leer PDF
                        </a>
                    @endif

                    <a
                        href="{{ route('front.books.index') }}"
                        class="inline-flex items-center justify-center rounded-xl border border-slate-300 bg-white px-5 py-3 text-sm font-medium text-slate-700 shadow-sm transition-colors hover:bg-slate-50 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200 dark:hover:bg-slate-800"
                    >
                        Explorar más libros
                    </a>
                </div>
            </div>
        </article>
    </div>
</x-layouts.front>
