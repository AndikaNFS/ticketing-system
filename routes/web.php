<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\OutletController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserPermissionController;
use App\Http\Controllers\UserRoleController;
use App\Http\Controllers\VisitController;
use Illuminate\Support\Facades\Route;

Route::get('/login', function () {
    return view('auth.login');
});
Route::get('/register', function () {
    return view('auth.register');
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
    Route::delete('/images/{id}', [TicketController::class, 'destroyImage'])->name('images.destroy');

    Route::get('/visits', [VisitController::class, 'index'])->name('visits.index');
    Route::get('/visits/create', [VisitController::class, 'create'])->name('visits.create');
    Route::post('/visits/store', [VisitController::class, 'store'])->name('visits.store');
    Route::get('/visits/{id}/edit', [VisitController::class, 'edit'])->name('visits.edit');
    Route::put('/visits/{id}', [VisitController::class, 'update'])->name('visits.update');
    Route::get('/visits/{id}/detail', [VisitController::class, 'show'])->name('visits.detail');
    // Route::get('/visits', [VisitController::class, 'index'])->name('visits.index');

    Route::get('/admin/index', [AdminController::class, 'index'])->name('users.index')
        ->middleware('role:superadmin');

    Route::post('/admin/make-admin/{id}', [AdminController::class, 'makeAdmin'])->name('admin.makeAdmin')
    ->middleware('role:superadmin');

    // Route::get('/schedules/{employee}/edit', [ScheduleController::class, 'edit'])->name('schedules.edit');
    // Route::post('/schedules/{employee}/store', [ScheduleController::class, 'store'])->name('schedules.store');
    Route::get('/schedules/{id}/edit/{start_date?}', [ScheduleController::class, 'edit'])->name('schedules.edit.weekly');
    Route::post('/schedules/{id}/store', [ScheduleController::class, 'store'])->name('schedules.store');
    Route::get('/schedules/export/pdf', [ScheduleController::class, 'exportPDF'])->name('schedules.export.pdf');
    Route::get('/schedules/export-excel', [ScheduleController::class, 'exportExcel'])->name('schedules.export.excel');

    Route::get('/roles/{role}/permissions', [RolePermissionController::class, 'edit'])->name('roles.permissions');
    Route::put('/roles/{role}/permissions', [RolePermissionController::class, 'update'])->name('roles.permissions.update');
    
    Route::get('/users/{user}/permissions', [UserPermissionController::class, 'edit'])->name('users.permissions');
    Route::put('/users/{user}/permissions', [UserPermissionController::class, 'update'])->name('users.permissions.update');
    
    Route::get('/users/{user}/roles', [UserRoleController::class, 'edit'])->name('users.roles');
    Route::put('/users/{user}/roles', [UserRoleController::class, 'update'])->name('users.roles.update');
    // Route::put('/users/{user}/roles', [UserController::class, 'update'])->name('users.roles.update');
    
    Route::get('/users/index', [UserController::class, 'index'])->name('admin.users.index');

    Route::get('/ticket/export-excel', [TicketController::class, 'exportExcel'])->name('ticket.export.excel');
    Route::get('/ticket/export-pdf', [TicketController::class, 'exportPDF'])->name('ticket.export.pdf');

    Route::get('/outlets/index', [OutletController::class, 'index'])->name('outlets.index');
    Route::get('/outlets/{id}/edit', [OutletController::class, 'edit'])->name('outlets.edit');
    Route::get('/outlets/create', [OutletController::class, 'create'])->name('outlets.create');
    Route::post('/outlets/store', [OutletController::class, 'store'])->name('outlets.store');
    Route::put('/outlets/{id}/update', [OutletController::class, 'update'])->name('outlets.update');
    
});

Route::prefix('admin')->middleware('role:superadmin|admin')->group(function () {
    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);
    Route::resource('schedules', ScheduleController::class);
    
});

// // Hanya user dengan role 'admin'
// Route::middleware(['role:admin'])->group(function () {
//     Route::resource('roles', RoleController::class);
//     Route::resource('permissions', PermissionController::class);
// });

// // Hanya user dengan permission tertentu
// Route::get('/ticket/delete/{id}', [TicketController::class, 'destroy'])
//     ->middleware('permission:delete ticket');

require __DIR__.'/auth.php';
