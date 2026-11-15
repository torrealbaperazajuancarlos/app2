<x-layouts.auth title="Sign in">
    <div class="mb-8">
        <h1 class="text-2xl font-semibold tracking-tight text-slate-900 dark:text-slate-100">Welcome back</h1>
        <p class="mt-1.5 text-sm text-slate-500 dark:text-slate-400">
            Sign in to manage your library.
        </p>
    </div>

    @if (session('status'))
        <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800 dark:border-emerald-500/30 dark:bg-emerald-500/10 dark:text-emerald-300">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <x-form-field
            name="email"
            label="Email"
            type="email"
            placeholder="you@example.com"
            autocomplete="username"
            autofocus
            required
        />

        <x-form-field
            name="password"
            label="Password"
            type="password"
            placeholder="Enter your password"
            autocomplete="current-password"
            required
        />

        <label class="flex items-center gap-2.5 text-sm text-slate-600 dark:text-slate-400">
            <input
                type="checkbox"
                name="remember"
                value="1"
                @checked(old('remember'))
                class="size-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500/30 dark:border-slate-700 dark:bg-slate-950"
            >

            <span>Remember me</span>
        </label>

        <div class="flex items-center justify-between gap-4 pt-1">
            @if (Route::has('password.request'))
                <a
                    href="{{ route('password.request') }}"
                    class="text-sm font-medium text-indigo-600 transition-colors hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300"
                >
                    Forgot password?
                </a>
            @endif

            <button
                type="submit"
                class="inline-flex items-center justify-center gap-2 rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-medium text-white shadow-sm transition-colors hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
            >
                Sign in
            </button>
        </div>
    </form>
</x-layouts.auth>
