@props(['book'])

@php
    $authorName = trim(($book->author?->first_name ?? '').' '.($book->author?->last_name ?? ''));
@endphp

<article {{ $attributes->merge(['class' => 'group flex h-full flex-col overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition duration-200 hover:-translate-y-1 hover:shadow-lg dark:border-slate-800 dark:bg-slate-900']) }}>
    <a href="{{ route('front.books.show', $book) }}" class="relative block overflow-hidden bg-slate-100 dark:bg-slate-800">
        <div class="aspect-[3/4]">
            @if ($book->image)
                <img
                    src="{{ Storage::url($book->image) }}"
                    alt="Portada de {{ $book->title }}"
                    loading="lazy"
                    class="size-full object-cover transition duration-300 group-hover:scale-105"
                >
            @else
                <div class="flex size-full flex-col items-center justify-center gap-3 bg-gradient-to-br from-indigo-500 via-indigo-600 to-violet-700 p-6 text-white">
                    <svg class="size-10 text-white/80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                    </svg>

                    <span class="text-center text-sm font-medium">{{ $book->title }}</span>
                </div>
            @endif
        </div>

        <span class="absolute left-3 top-3 rounded-full bg-white/90 px-2.5 py-1 text-xs font-semibold text-slate-700 shadow-sm backdrop-blur dark:bg-slate-950/80 dark:text-slate-200">
            {{ ucfirst($book->category?->name ?? 'Sin categoría') }}
        </span>
    </a>

    <div class="flex flex-1 flex-col p-5">
        <h3 class="line-clamp-2 text-base font-semibold text-slate-900 dark:text-slate-100">
            <a href="{{ route('front.books.show', $book) }}" class="transition-colors hover:text-indigo-600 dark:hover:text-indigo-400">
                {{ $book->title }}
            </a>
        </h3>

        @if ($authorName)
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">{{ $authorName }}</p>
        @endif

        <a
            href="{{ route('front.books.show', $book) }}"
            class="mt-auto inline-flex items-center gap-1.5 pt-4 text-sm font-medium text-indigo-600 transition-colors hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300"
        >
            Ver detalles

            <svg class="size-4 transition-transform group-hover:translate-x-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
            </svg>
        </a>
    </div>
</article>
