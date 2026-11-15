@props([
    'title' => 'Delete item',
    'confirmLabel' => 'Delete',
])

<dialog
    id="confirm-delete-modal"
    class="m-auto w-full max-w-md rounded-2xl border border-slate-200 bg-white p-0 text-slate-900 shadow-xl backdrop:bg-slate-950/60 dark:border-slate-800 dark:bg-slate-900 dark:text-slate-100"
    aria-labelledby="delete-modal-title"
    aria-describedby="delete-modal-description"
>
    <form method="POST" class="p-6 sm:p-8">
        @csrf
        @method('DELETE')

        <div class="flex items-start gap-4">
            <span class="flex size-11 shrink-0 items-center justify-center rounded-full bg-red-50 text-red-600 dark:bg-red-500/10 dark:text-red-400">
                <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m0 3.75h.008v.008H12v-.008ZM10.34 3.94l-7.5 12.99A1.5 1.5 0 0 0 4.14 19h15.72a1.5 1.5 0 0 0 1.3-2.07l-7.5-12.99a1.5 1.5 0 0 0-2.6 0Z" />
                </svg>
            </span>

            <div class="min-w-0">
                <h2 id="delete-modal-title" class="text-lg font-semibold text-slate-900 dark:text-slate-100">
                    {{ $title }}
                </h2>

                <p id="delete-modal-description" class="mt-1.5 text-sm leading-6 text-slate-500 dark:text-slate-400">
                    Are you sure you want to delete
                    <span data-delete-name class="font-medium text-slate-900 dark:text-slate-100"></span>?
                    This action cannot be undone.
                </p>
            </div>
        </div>

        <div class="mt-6 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
            <button
                type="button"
                data-modal-cancel
                class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 shadow-sm transition-colors hover:bg-slate-50 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200 dark:hover:bg-slate-800"
            >
                Cancel
            </button>

            <button
                type="submit"
                class="inline-flex items-center justify-center rounded-lg bg-red-600 px-4 py-2.5 text-sm font-medium text-white shadow-sm transition-colors hover:bg-red-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600"
            >
                {{ $confirmLabel }}
            </button>
        </div>
    </form>
</dialog>
