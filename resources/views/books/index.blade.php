<x-layouts.app title="Books">
    <div class="space-y-6">
        <x-page-header title="Books" description="Manage the books in your library.">
            <x-slot:actions>
                <a
                    href="{{ route('books.create') }}"
                    class="inline-flex items-center justify-center gap-2 rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-medium text-white shadow-sm transition-colors hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                >
                    <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>

                    New book
                </a>
            </x-slot:actions>
        </x-page-header>

        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <div class="flex flex-col gap-2 border-b border-slate-200 px-6 py-5 dark:border-slate-800 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-base font-semibold text-slate-900 dark:text-slate-100">All books</h2>
                    <p class="mt-0.5 text-sm text-slate-500 dark:text-slate-400">
                        {{ $books->total() }} {{ $books->total() === 1 ? 'book' : 'books' }}
                    </p>
                </div>
            </div>

            @if ($books->isEmpty())
                <div class="px-6 py-16 text-center">
                    <span class="mx-auto flex size-14 items-center justify-center rounded-full bg-slate-100 text-slate-500 dark:bg-slate-800 dark:text-slate-400">
                        <svg class="size-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                        </svg>
                    </span>

                    <h3 class="mt-4 text-base font-semibold text-slate-900 dark:text-slate-100">No books yet</h3>
                    <p class="mx-auto mt-1.5 max-w-sm text-sm text-slate-500 dark:text-slate-400">
                        Get started by adding your first book to the library.
                    </p>

                    <a
                        href="{{ route('books.create') }}"
                        class="mt-6 inline-flex items-center justify-center gap-2 rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-medium text-white shadow-sm transition-colors hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                    >
                        <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>

                        New book
                    </a>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-800">
                        <thead class="bg-slate-50 dark:bg-slate-900/60">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                                    Title
                                </th>
                                <th scope="col" class="hidden px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400 md:table-cell">
                                    Author
                                </th>
                                <th scope="col" class="hidden px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400 lg:table-cell">
                                    Category
                                </th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                                    Actions
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-200 bg-white dark:divide-slate-800 dark:bg-slate-900">
                            @foreach ($books as $book)
                                <tr class="transition-colors hover:bg-slate-50 dark:hover:bg-slate-800/60">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            @if ($book->image)
                                                <img
                                                    src="{{ Storage::url($book->image) }}"
                                                    alt="{{ $book->title }} cover"
                                                    class="h-12 w-9 shrink-0 rounded-md object-cover ring-1 ring-slate-200 dark:ring-slate-700"
                                                >
                                            @else
                                                <span class="flex h-12 w-9 shrink-0 items-center justify-center rounded-md bg-slate-100 text-slate-400 dark:bg-slate-800 dark:text-slate-500">
                                                    <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                                                    </svg>
                                                </span>
                                            @endif

                                            <div class="min-w-0">
                                                <p class="truncate text-sm font-medium text-slate-900 dark:text-slate-100">
                                                    {{ $book->title }}
                                                </p>

                                                @if ($book->summary)
                                                    <p class="max-w-xs truncate text-sm text-slate-500 dark:text-slate-400">
                                                        {{ $book->summary }}
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="hidden whitespace-nowrap px-6 py-4 text-sm text-slate-700 dark:text-slate-300 md:table-cell">
                                        {{ $book->author?->first_name }} {{ $book->author?->last_name }}
                                    </td>
                                    <td class="hidden whitespace-nowrap px-6 py-4 text-sm text-slate-700 dark:text-slate-300 lg:table-cell">
                                        {{ $book->category?->name }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <a
                                                href="{{ route('books.edit', $book) }}"
                                                class="inline-flex items-center gap-1.5 rounded-lg px-2.5 py-1.5 text-sm font-medium text-slate-600 transition-colors hover:bg-slate-100 hover:text-slate-900 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500 dark:text-slate-400 dark:hover:bg-slate-800 dark:hover:text-slate-100"
                                            >
                                                <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.93Z" />
                                                </svg>

                                                Edit
                                            </a>

                                            <button
                                                type="button"
                                                data-delete
                                                data-delete-url="{{ route('books.destroy', $book) }}"
                                                data-delete-name="{{ $book->title }}"
                                                class="inline-flex items-center gap-1.5 rounded-lg px-2.5 py-1.5 text-sm font-medium text-red-600 transition-colors hover:bg-red-50 hover:text-red-700 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600 dark:text-red-400 dark:hover:bg-red-500/10 dark:hover:text-red-300"
                                            >
                                                <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673A2.25 2.25 0 0 1 15.916 21H8.084a2.25 2.25 0 0 1-2.244-2.327L5.2 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                </svg>

                                                Delete
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if ($books->hasPages())
                    <div class="border-t border-slate-200 px-6 py-4 dark:border-slate-800">
                        {{ $books->links() }}
                    </div>
                @endif
            @endif
        </div>
    </div>

    <x-confirm-delete-modal title="Delete book" confirm-label="Delete book" />
</x-layouts.app>
