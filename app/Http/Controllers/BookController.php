<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Cache;

class BookController extends Controller
{
    public function index()
    {
        $books = Cache::remember('books', 60, function () {
            return Book::all();
        });

        return response()->json(["Books" => $books], 200);
    }

    public function show($id)
    {
        try {
            $book = Book::findOrFail($id);
            return response()->json(["Book" => $book], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(["message" => "Book not found"], 404);
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string',
            'author' => 'required|string',
            'publication_year' => 'required|integer',
            'isbn' => 'required|string|unique:books',
        ]);

        $book = Book::create($request->all());

        return response()->json($book, 201);
    }

    public function update(Request $request, $id)
    {
        try {
            $book = Book::findOrFail($id);
            $book->update($request->all());
            return response()->json($book, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(["message" => "Book not found"], 404);
        }
    }

    public function destroy($id)
    {
        try {
            $book = Book::findOrFail($id);
            $book->delete();
            return response()->json(["message" => "Book deleted successfully"], 204);
        } catch (ModelNotFoundException $e) {
            return response()->json(["message" => "Book not found"], 404);
        }
    }
}
