<x-layouts.front
    title="Inicio"
    description="Descubre nuestra biblioteca digital: libros en PDF, autores destacados y categorías para todos los gustos."
>
    <div class="space-y-20 sm:space-y-24">
        <section class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-indigo-600 via-indigo-700 to-violet-800 px-6 py-10 text-white shadow-xl shadow-indigo-950/20 sm:px-10 sm:py-14 lg:px-14">
            <div class="pointer-events-none absolute -right-24 -top-24 size-72 rounded-full bg-white/10 blur-3xl" aria-hidden="true"></div>
            <div class="pointer-events-none absolute -bottom-32 -left-16 size-80 rounded-full bg-violet-400/20 blur-3xl" aria-hidden="true"></div>

            <div class="relative grid items-center gap-10 lg:grid-cols-[minmax(0,1fr)_minmax(0,1.15fr)] lg:gap-12">
                <div>
                    <span class="inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-indigo-50 backdrop-blur">
                        <span class="size-1.5 rounded-full bg-emerald-300"></span>
                        Biblioteca digital
                    </span>

                    <h1 class="mt-5 text-3xl font-semibold tracking-tight sm:text-4xl lg:text-5xl">
                        Descubre tu próxima gran lectura
                    </h1>

                    <p class="mt-4 max-w-xl text-base leading-relaxed text-indigo-100 sm:text-lg">
                        Explora nuestra colección de libros en PDF, conoce a sus autores y empieza a leer desde cualquier dispositivo.
                    </p>

                    <div class="mt-8 flex flex-wrap gap-3">
                        <a
                            href="{{ route('front.books.index') }}"
                            class="inline-flex items-center justify-center gap-2 rounded-xl bg-white px-5 py-3 text-sm font-semibold text-indigo-700 shadow-sm transition-colors hover:bg-indigo-50 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white"
                        >
                            Explorar libros

                            <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                            </svg>
                        </a>

                        @auth
                            <a
                                href="{{ route('dashboard') }}"
                                class="inline-flex items-center justify-center rounded-xl border border-white/30 bg-white/5 px-5 py-3 text-sm font-semibold text-white backdrop-blur transition-colors hover:bg-white/10 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white"
                            >
                                Ir al panel
                            </a>
                        @else
                            <a
                                href="{{ route('login') }}"
                                class="inline-flex items-center justify-center rounded-xl border border-white/30 bg-white/5 px-5 py-3 text-sm font-semibold text-white backdrop-blur transition-colors hover:bg-white/10 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white"
                            >
                                Iniciar sesión
                            </a>
                        @endauth
                    </div>
                </div>

                <div class="grid gap-4 sm:grid-cols-3">
                    @forelse ($featuredBooks as $featuredBook)
                        <x-front.book-card :book="$featuredBook" class="shadow-xl shadow-indigo-950/25" />
                    @empty
                        <div class="rounded-2xl border border-white/20 bg-white/10 p-8 text-center backdrop-blur sm:col-span-3">
                            <p class="text-base font-semibold">Aún no hay libros publicados</p>
                            <p class="mt-1 text-sm text-indigo-100">Vuelve pronto para descubrir nuevas lecturas.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </section>

        <section aria-labelledby="testimonials-heading" data-carousel>
            <x-front.section-heading
                id="testimonials-heading"
                eyebrow="Comunidad"
                title="Lo que dicen nuestros lectores"
                description="Experiencias reales de personas que disfrutan leer en PDF."
            >
                <x-slot:actions>
                    <button
                        type="button"
                        data-carousel-prev
                        aria-controls="testimonials-track"
                        aria-label="Comentario anterior"
                        disabled
                        class="inline-flex size-11 items-center justify-center rounded-xl border border-slate-300 bg-white text-slate-700 shadow-sm transition-colors hover:bg-slate-50 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500 disabled:cursor-not-allowed disabled:opacity-40 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200 dark:hover:bg-slate-800"
                    >
                        <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                        </svg>
                    </button>

                    <button
                        type="button"
                        data-carousel-next
                        aria-controls="testimonials-track"
                        aria-label="Comentario siguiente"
                        class="inline-flex size-11 items-center justify-center rounded-xl border border-slate-300 bg-white text-slate-700 shadow-sm transition-colors hover:bg-slate-50 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500 disabled:cursor-not-allowed disabled:opacity-40 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200 dark:hover:bg-slate-800"
                    >
                        <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                        </svg>
                    </button>
                </x-slot:actions>
            </x-front.section-heading>

            <div class="mt-8">
                <div
                    id="testimonials-track"
                    data-carousel-track
                    role="region"
                    aria-roledescription="carrusel"
                    aria-label="Comentarios de lectores"
                    tabindex="0"
                    class="flex snap-x snap-mandatory gap-6 overflow-x-auto pb-2 [-ms-overflow-style:none] [scrollbar-width:none] focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-indigo-500 [&::-webkit-scrollbar]:hidden"
                >
                    @foreach ($testimonials as $testimonial)
                        <figure
                            data-carousel-item
                            role="group"
                            aria-roledescription="comentario"
                            aria-label="{{ $loop->iteration }} de {{ $loop->count }}"
                            class="flex w-full shrink-0 snap-start flex-col rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900 md:w-[calc((100%-3rem)/3)]"
                        >
                            <div class="flex items-center gap-1 text-amber-400" aria-label="5 de 5 estrellas">
                                @for ($star = 0; $star < 5; $star++)
                                    <svg class="size-4" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                        <path d="M12 2.25 15.09 8.26 21.75 9.23l-4.87 4.75 1.15 6.62L12 17.48 5.97 20.6l1.15-6.63L2.25 9.23l6.66-.97L12 2.25Z" />
                                    </svg>
                                @endfor
                            </div>

                            <h3 class="mt-4 text-base font-semibold text-slate-900 dark:text-slate-100">
                                {{ $testimonial['title'] }}
                            </h3>

                            <blockquote class="mt-2 flex-1 text-sm leading-relaxed text-slate-600 dark:text-slate-400">
                                “{{ $testimonial['quote'] }}”
                            </blockquote>

                            <figcaption class="mt-6 flex items-center gap-3 border-t border-slate-200 pt-4 dark:border-slate-800">
                                <span class="flex size-10 shrink-0 items-center justify-center rounded-full bg-indigo-50 text-sm font-semibold text-indigo-700 dark:bg-indigo-500/10 dark:text-indigo-300">
                                    {{ mb_strtoupper(mb_substr($testimonial['reader'], 0, 1)) }}
                                </span>

                                <span class="text-sm font-medium text-slate-900 dark:text-slate-100">
                                    {{ $testimonial['reader'] }}
                                </span>
                            </figcaption>
                        </figure>
                    @endforeach
                </div>

                <div class="mt-5 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <p data-carousel-status class="text-sm text-slate-500 dark:text-slate-400" aria-live="polite">
                        Desliza para ver más comentarios
                    </p>

                    <div data-carousel-dots role="group" aria-label="Seleccionar comentario" class="flex flex-wrap items-center gap-1.5">
                        @foreach ($testimonials as $testimonial)
                            <button
                                type="button"
                                data-carousel-dot
                                data-index="{{ $loop->index }}"
                                aria-controls="testimonials-track"
                                aria-label="Ir al comentario {{ $loop->iteration }}"
                                @if ($loop->first) aria-current="true" @endif
                                class="size-2.5 rounded-full bg-slate-300 transition-colors hover:bg-slate-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500 aria-[current=true]:bg-indigo-600 dark:bg-slate-700 dark:hover:bg-slate-600 dark:aria-[current=true]:bg-indigo-400"
                            ></button>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        <section aria-labelledby="categories-heading">
            <x-front.section-heading
                id="categories-heading"
                eyebrow="Catálogo"
                title="Explora por categorías"
                description="Encuentra lecturas que se ajusten a tus gustos e intereses."
            >
                <x-slot:actions>
                    <a
                        href="{{ route('front.books.index') }}"
                        class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 shadow-sm transition-colors hover:bg-slate-50 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200 dark:hover:bg-slate-800"
                    >
                        Ver todos los libros
                    </a>
                </x-slot:actions>
            </x-front.section-heading>

            <div class="mt-8 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                @forelse ($categories as $category)
                    @php
                        $categoryImage = 'images/categories/'.$category->name.'.png';
                        $hasCategoryImage = file_exists(public_path($categoryImage));
                    @endphp

                    <a
                        href="{{ route('front.books.index', ['category' => $category->id]) }}"
                        class="group relative flex min-h-48 flex-col justify-end overflow-hidden rounded-2xl border border-slate-200 bg-slate-900 shadow-sm transition duration-200 hover:-translate-y-1 hover:shadow-lg dark:border-slate-800"
                    >
                        @if ($hasCategoryImage)
                            <img
                                src="{{ asset('images/categories/'.rawurlencode($category->name).'.png') }}"
                                alt="Categoría {{ $category->name }}"
                                loading="lazy"
                                class="absolute inset-0 size-full object-cover transition duration-300 group-hover:scale-105"
                            >

                            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/85 via-slate-950/35 to-transparent"></div>
                        @else
                            <div class="absolute inset-0 bg-gradient-to-br from-indigo-500 via-indigo-600 to-violet-700"></div>
                            <span class="absolute right-4 top-4 text-6xl font-bold text-white/15" aria-hidden="true">
                                {{ mb_strtoupper(mb_substr($category->name, 0, 1)) }}
                            </span>
                        @endif

                        <div class="relative p-6 text-white">
                            <p class="text-xs font-medium uppercase tracking-wider text-white/70">Categoría</p>
                            <h3 class="mt-1 text-xl font-semibold">{{ ucfirst($category->name) }}</h3>
                            <p class="mt-1 text-sm text-white/80">
                                {{ $category->books_count }} {{ $category->books_count === 1 ? 'libro' : 'libros' }}
                            </p>
                        </div>
                    </a>
                @empty
                    <div class="rounded-2xl border border-dashed border-slate-300 bg-white p-12 text-center dark:border-slate-700 dark:bg-slate-900 sm:col-span-2 lg:col-span-3">
                        <span class="mx-auto flex size-14 items-center justify-center rounded-full bg-slate-100 text-slate-500 dark:bg-slate-800 dark:text-slate-400">
                            <svg class="size-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z" />
                            </svg>
                        </span>

                        <h3 class="mt-4 text-base font-semibold text-slate-900 dark:text-slate-100">Todavía no hay categorías</h3>
                        <p class="mx-auto mt-1.5 max-w-sm text-sm text-slate-500 dark:text-slate-400">
                            Las categorías aparecerán aquí en cuanto estén disponibles.
                        </p>
                    </div>
                @endforelse
            </div>
        </section>

        <section aria-labelledby="authors-heading">
            <x-front.section-heading
                id="authors-heading"
                eyebrow="Talento"
                title="Nuestros autores"
                description="Conoce a las voces que dan vida a nuestra colección."
            />

            @if ($authors->isEmpty())
                <div class="mt-8 rounded-2xl border border-dashed border-slate-300 bg-white p-12 text-center dark:border-slate-700 dark:bg-slate-900">
                    <span class="mx-auto flex size-14 items-center justify-center rounded-full bg-slate-100 text-slate-500 dark:bg-slate-800 dark:text-slate-400">
                        <svg class="size-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6.75a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.5 20.25a7.5 7.5 0 0 1 15 0" />
                        </svg>
                    </span>

                    <h3 class="mt-4 text-base font-semibold text-slate-900 dark:text-slate-100">Todavía no hay autores</h3>
                    <p class="mx-auto mt-1.5 max-w-sm text-sm text-slate-500 dark:text-slate-400">
                        Los autores de la colección aparecerán aquí en cuanto estén disponibles.
                    </p>
                </div>
            @else
                <div class="mt-8 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
                    <div class="flex flex-wrap items-center justify-between gap-2 border-b border-slate-200 px-6 py-4 dark:border-slate-800">
                        <p class="text-sm text-slate-500 dark:text-slate-400">
                            {{ $authors->count() }} {{ $authors->count() === 1 ? 'autor' : 'autores' }} en la colección
                        </p>

                        <a
                            href="{{ route('front.books.index') }}"
                            class="text-sm font-medium text-indigo-600 transition-colors hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300"
                        >
                            Ver libros
                        </a>
                    </div>

                    <ul role="list" class="grid gap-px bg-slate-200 dark:bg-slate-800 sm:grid-cols-2 lg:grid-cols-4">
                        @foreach ($authors as $author)
                            <li class="flex items-center gap-3 bg-white px-5 py-4 dark:bg-slate-900">
                                <span class="flex size-10 shrink-0 items-center justify-center rounded-full bg-indigo-50 text-sm font-semibold text-indigo-700 dark:bg-indigo-500/10 dark:text-indigo-300">
                                    {{ mb_strtoupper(mb_substr($author->first_name, 0, 1).mb_substr($author->last_name, 0, 1)) }}
                                </span>

                                <div class="min-w-0">
                                    <p class="truncate text-sm font-medium text-slate-900 dark:text-slate-100">
                                        {{ $author->first_name }} {{ $author->last_name }}
                                    </p>

                                    @if ($author->phrase)
                                        <p class="truncate text-xs text-slate-500 dark:text-slate-400">{{ $author->phrase }}</p>
                                    @endif
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </section>
    </div>
</x-layouts.front>
