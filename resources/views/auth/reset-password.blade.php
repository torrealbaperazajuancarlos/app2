<x-layouts.auth title="Reset password">
    <div class="mb-8">
        <h1 class="text-2xl font-semibold tracking-tight text-slate-900 dark:text-slate-100">Reset password</h1>
        <p class="mt-1.5 text-sm text-slate-500 dark:text-slate-400">
            Choose a new password for your account.
        </p>
    </div>

    <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
        @csrf

        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <x-form-field
            name="email"
            label="Email"
            type="email"
            :value="$request->email"
            autocomplete="username"
            required
        />

        <x-form-field
            name="password"
            label="New password"
            type="password"
            placeholder="Enter a new password"
            autocomplete="new-password"
            required
        />

        <x-form-field
            name="password_confirmation"
            label="Confirm password"
            type="password"
            placeholder="Confirm your new password"
            autocomplete="new-password"
            required
        />

        <div class="flex flex-col-reverse gap-3 pt-1 sm:flex-row sm:items-center sm:justify-between">
            <a
                href="{{ route('login') }}"
                class="text-sm font-medium text-slate-600 transition-colors hover:text-slate-900 dark:text-slate-400 dark:hover:text-slate-100"
            >
                Back to sign in
            </a>

            <button
                type="submit"
                class="inline-flex items-center justify-center gap-2 rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-medium text-white shadow-sm transition-colors hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
            >
                Reset password
            </button>
        </div>
    </form>
</x-layouts.auth>
