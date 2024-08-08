<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\PatronController;
use App\Http\Controllers\BorrowingRecordController;
use App\Http\Controllers\AuthController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    // Book routes
    Route::get('/books', [BookController::class, 'index']);
    Route::get('/books/{id}', [BookController::class, 'show']);
    Route::post('/books', [BookController::class, 'store']);
    Route::put('/books/{id}', [BookController::class, 'update']);
    Route::delete('/books/{id}', [BookController::class, 'destroy']);

    // Patron routes
    Route::get('/patrons', [PatronController::class, 'index']);
    Route::get('/patrons/{id}', [PatronController::class, 'show']);
    Route::post('/patrons', [PatronController::class, 'store']);
    Route::put('/patrons/{id}', [PatronController::class, 'update']);
    Route::delete('/patrons/{id}', [PatronController::class, 'destroy']);

    // Borrowing routes
    Route::post('/borrow/{bookId}/patron/{patronId}', [BorrowingRecordController::class, 'borrow']);
    Route::put('/return/{bookId}/patron/{patronId}', [BorrowingRecordController::class, 'returnBook']);

    // Logout route
    Route::post('/logout', [AuthController::class, 'logout']);
});

