<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\VisitController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/ticket', [TicketController::class, 'userCreate'])->name('tickets.users.create');
Route::post('/store', [TicketController::class, 'storeUser'])->name('tickets.users.storeUser');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::get('/ticket/create', [TicketController::class, 'create'])->name('tickets.create');
    Route::get('/dashboard', [TicketController::class, 'index'])->name('dashboard');
    Route::get('/ticket/{id}/edit', [TicketController::class, 'edit'])->name('tickets.edit');
    Route::get('/ticket/{id}/detail', [TicketController::class, 'show'])->name('tickets.detail');
    Route::put('/ticket/{id}', [TicketController::class, 'update'])->name('tickets.update');
    Route::post('/ticket/store', [TicketController::class, 'store'])->name('tickets.store');

    Route::get('/visits', [VisitController::class, 'index'])->name('visits.index');
    Route::get('/visits/create', [VisitController::class, 'create'])->name('visits.create');
    // Route::get('/visits', [VisitController::class, 'index'])->name('visits.index');
});

require __DIR__.'/auth.php';
