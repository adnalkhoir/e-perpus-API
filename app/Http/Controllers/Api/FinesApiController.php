<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreFinesRequest;
use App\Http\Requests\UpdateFinesRequest;
use App\Models\fines;

class FinesApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fines = fines::with(['borrowing', 'borrowing.book', 'borrowing.user'])->latest()->paginate(5);
        return response()->json($fines);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFinesRequest $request)
    {
        $fine = fines::create($request->validated());

        return response()->json([
            'message' => 'Denda berhasil ditambahkan.',
            'data' => $fine
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $fine = fines::with(['borrowing', 'borrowing.book', 'borrowing.user'])->find($id);

        if (!$fine) {
            return response()->json(['message' => 'Denda tidak ditemukan.'], 404);
        }

        return response()->json($fine);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFinesRequest $request, string $id)
    {
        $fine = fines::find($id);

        if (!$fine) {
            return response()->json(['message' => 'Denda tidak ditemukan.'], 404);
        }

        $fine->update($request->validated());

        return response()->json([
            'message' => 'Denda berhasil diperbarui.',
            'data' => $fine
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $fine = fines::find($id);

        if (!$fine) {
            return response()->json(['message' => 'Denda tidak ditemukan.'], 404);
        }

        $fine->delete();

        return response()->json(['message' => 'Denda berhasil dihapus.']);
    }
}
