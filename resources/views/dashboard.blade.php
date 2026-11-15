<x-layouts.app title="Dashboard">
    <div class="space-y-6">
        <x-page-header title="Dashboard" description="An overview of your library.">
            <x-slot:actions>
                <a
                    href="{{ route('authors.create') }}"
                    class="inline-flex items-center justify-center gap-2 rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-medium text-white shadow-sm transition-colors hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                >
                    <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>

                    New author
                </a>
            </x-slot:actions>
        </x-page-header>

        <div class="grid gap-4 sm:grid-cols-3">
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Total authors</p>
                <p class="mt-2 text-3xl font-semibold tracking-tight text-slate-900 dark:text-slate-100">
                    {{ $totalAuthors }}
                </p>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <p class="text-sm font-medium text-slate-500 dark:text-slate-400">New this month</p>
                <p class="mt-2 text-3xl font-semibold tracking-tight text-slate-900 dark:text-slate-100">
                    {{ $authorsThisMonth }}
                </p>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Latest author</p>
                <p class="mt-2 truncate text-lg font-semibold tracking-tight text-slate-900 dark:text-slate-100">
                    @if ($latestAuthor)
                        {{ $latestAuthor->first_name }} {{ $latestAuthor->last_name }}
                    @else
                        —
                    @endif
                </p>
            </div>
        </div>

        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <div class="flex items-center justify-between gap-4 border-b border-slate-200 px-6 py-5 dark:border-slate-800">
                <div>
                    <h2 class="text-base font-semibold text-slate-900 dark:text-slate-100">Recent authors</h2>
                    <p class="mt-0.5 text-sm text-slate-500 dark:text-slate-400">
                        The latest additions to your library.
                    </p>
                </div>

                <a
                    href="{{ route('authors.index') }}"
                    class="text-sm font-medium text-indigo-600 transition-colors hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300"
                >
                    View all
                </a>
            </div>

            @if ($recentAuthors->isEmpty())
                <div class="px-6 py-16 text-center">
                    <span class="mx-auto flex size-14 items-center justify-center rounded-full bg-slate-100 text-slate-500 dark:bg-slate-800 dark:text-slate-400">
                        <svg class="size-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6.75a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.5 20.25a7.5 7.5 0 0 1 15 0" />
                        </svg>
                    </span>

                    <h3 class="mt-4 text-base font-semibold text-slate-900 dark:text-slate-100">No authors yet</h3>
                    <p class="mx-auto mt-1.5 max-w-sm text-sm text-slate-500 dark:text-slate-400">
                        Create your first author to start building the library.
                    </p>

                    <a
                        href="{{ route('authors.create') }}"
                        class="mt-6 inline-flex items-center justify-center gap-2 rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-medium text-white shadow-sm transition-colors hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                    >
                        New author
                    </a>
                </div>
            @else
                <ul role="list" class="divide-y divide-slate-200 dark:divide-slate-800">
                    @foreach ($recentAuthors as $author)
                        <li class="flex items-center justify-between gap-4 px-6 py-4">
                            <div class="flex min-w-0 items-center gap-3">
                                <span class="flex size-10 shrink-0 items-center justify-center rounded-full bg-indigo-50 text-sm font-semibold text-indigo-700 dark:bg-indigo-500/10 dark:text-indigo-300">
                                    {{ mb_strtoupper(mb_substr($author->first_name, 0, 1) . mb_substr($author->last_name, 0, 1)) }}
                                </span>

                                <div class="min-w-0">
                                    <p class="truncate text-sm font-medium text-slate-900 dark:text-slate-100">
                                        {{ $author->first_name }} {{ $author->last_name }}
                                    </p>
                                    <p class="truncate text-sm text-slate-500 dark:text-slate-400">
                                        {{ $author->phrase ?: 'No phrase yet' }}
                                    </p>
                                </div>
                            </div>

                            <a
                                href="{{ route('authors.edit', $author) }}"
                                class="shrink-0 text-sm font-medium text-indigo-600 transition-colors hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300"
                            >
                                Edit
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</x-layouts.app>
