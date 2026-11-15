<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(): View
    {
        return view('dashboard', [
            'totalAuthors' => Author::count(),
            'authorsThisMonth' => Author::where('created_at', '>=', now()->startOfMonth())->count(),
            'latestAuthor' => Author::query()->latest('id')->first(),
            'recentAuthors' => Author::query()->latest('id')->take(5)->get(),
        ]);
    }
}
