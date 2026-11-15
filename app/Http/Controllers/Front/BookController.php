<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BookController extends Controller
{
    /**
     * Display the public book catalog.
     */
    public function index(Request $request): View
    {
        $categoryId = $request->integer('category');

        $books = Book::query()
            ->with(['author', 'category'])
            ->when(
                $categoryId > 0,
                fn (Builder $query): Builder => $query->where('category_id', $categoryId)
            )
            ->orderBy('title')
            ->orderBy('id')
            ->paginate(9)
            ->withQueryString();

        return view('front.books.index', [
            'books' => $books,
            'categories' => Category::query()->orderBy('name')->get(),
            'selectedCategoryId' => $categoryId > 0 ? $categoryId : null,
        ]);
    }

    /**
     * Display the public details of the given book.
     */
    public function show(Book $book): View
    {
        $book->load(['author', 'category']);

        return view('front.books.show', ['book' => $book]);
    }
}
