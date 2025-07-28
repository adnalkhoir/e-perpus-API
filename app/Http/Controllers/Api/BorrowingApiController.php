<?php

namespace App\Http\Controllers\Api;

use App\Models\books;
use App\Models\borrowings;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateBookRequest;
use App\Http\Requests\StoreBorrowingRequest;
use App\Http\Requests\UpdateBorrowingRequest;

class BorrowingApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $borrowings = borrowings::with(['user', 'book'])->latest()->paginate(5);
        return response()->json($borrowings);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBorrowingRequest $request)
    {
        $book = books::find($request->book_id);

        if ($book->stock < 1) {
            return response()->json([
                'message' => 'Stock buku habis.'
            ], 400);
        }

        $book->decrement('stock');

        $borrowing = borrowings::create([
            'user_id' => $request->user_id,
            'book_id' => $request->book_id,
            'borrow_date' => $request->borrow_date,
            'due_date' => $request->due_date,
            'status' => 'Dipinjam',
        ]);

        return response()->json([
            'message' => 'Penyewaan buku berhasil.',
            'data' => $borrowing
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $borrowing = borrowings::with(['user', 'book'])->find($id);

        if (!$borrowing) {
            return response()->json(['message' => 'Peminjaman buku tidak ditemukan.'], 404);
        }

        return response()->json($borrowing);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBorrowingRequest $request, string $id)
{
    $borrowing = borrowings::with('book')->find($id);

    if (!$borrowing) {
        return response()->json(['message' => 'Peminjaman buku tidak ditemukan.'], 404);
    }

    $oldStatus = $borrowing->status;
    $validated = $request->validated();

    DB::beginTransaction();

    try {
        $borrowing->update($validated);

        if ($oldStatus === 'Dipinjam' && $validated['status'] === 'Dikembalikan') {
        $book = $borrowing->book;
        if ($book) {
            $book->increment('stock');
        }
    }

        if ($request->has('return_date') && $borrowing->due_date && $borrowing->return_date) {
        $dueDate = Carbon::parse($borrowing->due_date);
        $returnDate = Carbon::parse($borrowing->return_date);

        if ($returnDate->gt($dueDate)) {
            $daysLate = $returnDate->diffInDays($dueDate);
            $fineAmount = $daysLate * 1000;

            // Buat atau update denda (satu borrowing satu denda)
            $fine = $borrowing->fine()->updateOrCreate(
            ['borrowing_id' => $borrowing->id],
            [
                'user_id' => $borrowing->user_id,
                'amount' => $fineAmount,
                'paid_at' => null,
                ]
            );
        } else {
            $borrowing->fine()?->delete();
        }
    }

        DB::commit();

        return response()->json([
        'message' => 'Peminjaman buku berhasil diperbarui.',
        'data' => $borrowing->load('book', 'fine'),
    ]);
    } catch (\Exception $e) {
        DB::rollBack();

        return response()->json([
            'message' => 'Peminjaman buku gagal diperbarui.',
            'error' => $e->getMessage(),
        ], 500);
    }
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $borrowing = borrowings::find($id);

        if (!$borrowing) {
            return response()->json(['message' => 'Peminjaman buku tidak ditemukan.'], 404);
        }

        $borrowing->delete();

        return response()->json(['message' => 'Peminjaman buku berhasil dihapus.']);
    }
    
}
