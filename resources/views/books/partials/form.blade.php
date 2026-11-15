@php
    $submitLabel = $submitLabel ?? 'Save';
@endphp

<div class="grid gap-6 md:grid-cols-2">
    <div class="md:col-span-2">
        <x-form-field
            name="title"
            label="Title"
            :value="$book?->title"
            placeholder="Book title"
            maxlength="255"
            required
        />
    </div>

    <div class="md:col-span-2">
        <x-form-field
            name="summary"
            label="Summary"
            :value="$book?->summary"
            placeholder="Book summary"
            maxlength="255"
        />
    </div>

    <x-select-field
        name="category_id"
        label="Category"
        :value="$book?->category_id"
        placeholder="Select a category"
        :options="$categories->map(fn ($category) => ['value' => $category->id, 'label' => $category->name])->all()"
        required
    />

    <x-select-field
        name="author_id"
        label="Author"
        :value="$book?->author_id"
        placeholder="Select an author"
        :options="$authors->map(fn ($author) => ['value' => $author->id, 'label' => $author->first_name.' '.$author->last_name])->all()"
        required
    />

    <div class="md:col-span-2">
        <x-file-field
            name="pdf"
            label="PDF file"
            accept="application/pdf"
            hint="PDF up to 10 MB."
            :required="$book === null"
        />

        @if ($book?->pdf)
            <a
                href="{{ Storage::url($book->pdf) }}"
                target="_blank"
                rel="noopener"
                class="mt-2 inline-flex items-center gap-1.5 text-sm font-medium text-indigo-600 transition-colors hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300"
            >
                <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 9h6m-6 3h6m-9-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                </svg>

                View current PDF
            </a>
        @endif
    </div>

    <div class="md:col-span-2">
        <x-file-field
            name="image"
            label="Cover image"
            accept="image/png,image/jpeg,image/gif"
            hint="PNG, JPG or GIF up to 2 MB."
        />

        @if ($book?->image)
            <img
                src="{{ Storage::url($book->image) }}"
                alt="{{ $book->title }} cover"
                class="mt-3 h-28 w-20 rounded-lg border border-slate-200 object-cover dark:border-slate-700"
            >
        @endif
    </div>
</div>

<div class="mt-8 flex flex-col-reverse gap-3 border-t border-slate-200 pt-6 dark:border-slate-800 sm:flex-row sm:justify-end">
    <a
        href="{{ route('books.index') }}"
        class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 shadow-sm transition-colors hover:bg-slate-50 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200 dark:hover:bg-slate-800"
    >
        Cancel
    </a>

    <button
        type="submit"
        class="inline-flex items-center justify-center rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-medium text-white shadow-sm transition-colors hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
    >
        {{ $submitLabel }}
    </button>
</div>
