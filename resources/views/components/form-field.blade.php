@props([
    'name',
    'label',
    'value' => null,
    'type' => 'text',
    'placeholder' => null,
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
        type="{{ $type }}"
        value="{{ old($name, $value) }}"
        @if ($placeholder) placeholder="{{ $placeholder }}" @endif
        @if ($required) required @endif
        {{ $attributes->merge([
            'class' => 'mt-1.5 block w-full rounded-lg border bg-white px-3.5 py-2.5 text-sm text-slate-900 shadow-sm transition placeholder:text-slate-400 focus:outline-none focus:ring-2 dark:bg-slate-950 dark:text-slate-100 dark:placeholder:text-slate-500 ' . ($hasError
                ? 'border-red-300 focus:border-red-500 focus:ring-red-500/20 dark:border-red-500/60'
                : 'border-slate-300 focus:border-indigo-500 focus:ring-indigo-500/20 dark:border-slate-700'),
        ]) }}
    >

    @error($name)
        <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
    @enderror
</div>
