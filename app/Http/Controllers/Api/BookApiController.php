<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\books;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;

class BookApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = books::with('category')->latest()->paginate(5);
        return response()->json($books);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookRequest $request)
    {
        $book = books::create($request->validated());

        return response()->json([
            'message' => 'Book created successfully.',
            'data' => $book
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $book = books::with('category')->find($id);

        if (!$book) {
            return response()->json(['message' => 'Book not found.'], 404);
        }

        return response()->json($book);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookRequest $request, string $id)
    {
        $book = books::find($id);

        if (!$book) {
            return response()->json(['message' => 'Book not found.'], 404);
        }

        $book->update($request->validated());

        return response()->json([
            'message' => 'Book updated successfully.',
            'data' => $book
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $book = books::find($id);

        if (!$book) {
            return response()->json(['message' => 'Book not found.'], 404);
        }

        $book->delete();

        return response()->json(['message' => 'Book deleted successfully.']);
    }
}
