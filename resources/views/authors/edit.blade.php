<x-layouts.app title="Edit author">
    <div class="mx-auto w-full max-w-3xl space-y-6">
        <x-page-header title="Edit author" description="Update the author's details." />

        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <div class="border-b border-slate-200 px-6 py-5 dark:border-slate-800 sm:px-8">
                <h2 class="text-base font-semibold text-slate-900 dark:text-slate-100">Author details</h2>
                <p class="mt-0.5 text-sm text-slate-500 dark:text-slate-400">
                    Update the author's name or short phrase.
                </p>
            </div>

            <form method="POST" action="{{ route('authors.update', $author) }}" class="p-6 sm:p-8">
                @csrf
                @method('PUT')

                @include('authors.partials.form', ['author' => $author, 'submitLabel' => 'Save'])
            </form>
        </div>
    </div>
</x-layouts.app>
