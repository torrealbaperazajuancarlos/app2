@props([
    'eyebrow' => null,
    'title',
    'description' => null,
    'id' => null,
])

<div {{ $attributes->merge(['class' => 'flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between']) }}>
    <div class="max-w-2xl">
        @if ($eyebrow)
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-indigo-600 dark:text-indigo-400">
                {{ $eyebrow }}
            </p>
        @endif

        <h2 @if ($id) id="{{ $id }}" @endif class="mt-2 text-2xl font-semibold tracking-tight text-slate-900 dark:text-slate-100 sm:text-3xl">
            {{ $title }}
        </h2>

        @if ($description)
            <p class="mt-3 text-base text-slate-600 dark:text-slate-400">{{ $description }}</p>
        @endif
    </div>

    @if (isset($actions))
        <div class="flex shrink-0 flex-wrap items-center gap-3">
            {{ $actions }}
        </div>
    @endif
</div>
