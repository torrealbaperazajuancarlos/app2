@props([
    'name',
    'label',
    'accept' => null,
    'hint' => null,
    'required' => false,
])

@php
    $hasError = $errors->has($name);
@endphp

<div>
    <label for="{{ $name }}" class="block text-sm font-medium text-slate-700 dark:text-slate-300">
        {{ $label }}

        @if ($required)
            <span class="text-red-500" aria-hidden="true">*</span>
        @endif
    </label>

    <input
        id="{{ $name }}"
        name="{{ $name }}"
        type="file"
        @if ($accept) accept="{{ $accept }}" @endif
        @if ($required) required @endif
        {{ $attributes->merge([
            'class' => 'mt-1.5 block w-full cursor-pointer rounded-lg border bg-white text-sm text-slate-500 shadow-sm transition file:mr-4 file:border-0 file:bg-slate-100 file:px-4 file:py-2.5 file:text-sm file:font-medium file:text-slate-700 hover:file:bg-slate-200 focus:outline-none focus:ring-2 dark:bg-slate-950 dark:text-slate-400 dark:file:bg-slate-800 dark:file:text-slate-200 dark:hover:file:bg-slate-700 ' . ($hasError
                ? 'border-red-300 focus:border-red-500 focus:ring-red-500/20 dark:border-red-500/60'
                : 'border-slate-300 focus:border-indigo-500 focus:ring-indigo-500/20 dark:border-slate-700'),
        ]) }}
    >

    @if ($hint)
        <p class="mt-1.5 text-xs text-slate-500 dark:text-slate-400">{{ $hint }}</p>
    @endif

    @error($name)
        <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
    @enderror
</div>
