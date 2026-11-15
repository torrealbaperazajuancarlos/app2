<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $books = Book::query()
            ->with(['author', 'category'])
            ->orderBy('title')
            ->orderBy('id')
            ->paginate(10)
            ->withQueryString();

        return view('books.index', ['books' => $books]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('books.create', [
            'categories' => Category::query()->orderBy('name')->get(),
            'authors' => Author::query()->orderBy('last_name')->orderBy('first_name')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $data['pdf'] = $this->storeFile($request->file('pdf'));
        $data['image'] = $this->storeFile($request->file('image'));

        Book::create($data);

        return redirect()
            ->route('books.index')
            ->with('success', 'Book created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book): View
    {
        return view('books.edit', [
            'book' => $book,
            'categories' => Category::query()->orderBy('name')->get(),
            'authors' => Author::query()->orderBy('last_name')->orderBy('first_name')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookRequest $request, Book $book): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('pdf')) {
            $this->deleteFile($book->pdf);
            $data['pdf'] = $this->storeFile($request->file('pdf'));
        } else {
            unset($data['pdf']);
        }

        if ($request->hasFile('image')) {
            $this->deleteFile($book->image);
            $data['image'] = $this->storeFile($request->file('image'));
        } else {
            unset($data['image']);
        }

        $book->update($data);

        return redirect()
            ->route('books.index')
            ->with('success', 'Book updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book): RedirectResponse
    {
        $book->delete();

        return redirect()
            ->route('books.index')
            ->with('success', 'Book deleted successfully.');
    }

    /**
     * Store an uploaded file on the public disk.
     */
    private function storeFile(?UploadedFile $file): ?string
    {
        return $file?->store('books', 'public');
    }

    /**
     * Delete a file from the public disk if it exists.
     */
    private function deleteFile(?string $path): void
    {
        if ($path) {
            Storage::disk('public')->delete($path);
        }
    }
}
