<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BorrowingRecord;
use App\Models\Book;
use App\Models\Patron;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class BorrowingRecordController extends Controller
{
    public function borrow($bookId, $patronId)
    {
        try {
            $book = Book::findOrFail($bookId);
            $patron = Patron::findOrFail($patronId);

            $record = BorrowingRecord::create([
                'book_id' => $bookId,
                'patron_id' => $patronId,
                'borrowed_at' => now(),
            ]);

            return response()->json($record, 201);
        } catch (ModelNotFoundException $e) {
            return response()->json(["message" => "Book or Patron not found"], 404);
        } catch (\Exception $e) {
            return response()->json(["message" => "Failed to create borrowing record"], 400);
        }
    }

    public function returnBook($bookId, $patronId)
    {
        try {
            $record = BorrowingRecord::where('book_id', $bookId)
                ->where('patron_id', $patronId)
                ->whereNull('returned_at')
                ->firstOrFail();

            $record->update(['returned_at' => now()]);
            return response()->json($record, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(["message" => "Borrowing record not found or already returned"], 404);
        } catch (\Exception $e) {
            return response()->json(["message" => "Failed to update borrowing record"], 400);
        }
    }
}
