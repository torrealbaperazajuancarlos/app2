@php
    $submitLabel = $submitLabel ?? 'Save';
@endphp

<div class="grid gap-6">
    <x-form-field
        name="name"
        label="Name"
        :value="$category?->name"
        placeholder="Category title"
        maxlength="255"
        required
    />
</div>

<div class="mt-8 flex flex-col-reverse gap-3 border-t border-slate-200 pt-6 dark:border-slate-800 sm:flex-row sm:justify-end">
    <a
        href="{{ route('categories.index') }}"
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
