<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\BuildingController;
use App\Http\Controllers\DailyReportController;
use App\Http\Controllers\OutletController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\ScheduleBuildingController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserPermissionController;
use App\Http\Controllers\UserRoleController;
use App\Http\Controllers\VisitBuildingController;
use App\Http\Controllers\VisitController;
use Illuminate\Support\Facades\Route;

Route::get('/login', function () {
    return view('auth.login');
});
Route::get('/register', function () {
    return view('auth.register');
});
Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/ticket', [TicketController::class, 'userCreate'])->name('tickets.users.create');
Route::post('/store', [TicketController::class, 'storeUser'])->name('tickets.users.storeUser');

Route::middleware('guest')->group(function () {
    Route::get('/', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/', [AuthenticatedSessionController::class, 'store']);

});


Route::middleware('auth')->group(function () {
   

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::get('/dashboard', [TicketController::class, 'index'])->name('dashboard')->middleware('role:admin|superadmin|direksi');
    Route::get('/visits', [VisitController::class, 'index'])->name('visits.index')->middleware('role:admin|superadmin|direksi');
    Route::middleware(['role:admin|superadmin'])->group(function () {
        Route::get('/ticket/create', [TicketController::class, 'create'])->name('tickets.create');
        Route::get('/ticket/{id}/edit', [TicketController::class, 'edit'])->name('tickets.edit');
        Route::get('/ticket/{id}/detail', [TicketController::class, 'show'])->name('tickets.detail');
        Route::put('/ticket/{id}', [TicketController::class, 'update'])->name('tickets.update');
        Route::post('/ticket/store', [TicketController::class, 'store'])->name('tickets.store');
        Route::delete('/images/{id}', [TicketController::class, 'destroyImage'])->name('images.destroy');

        
        Route::get('/visits/create', [VisitController::class, 'create'])->name('visits.create');
        Route::post('/visits/store', [VisitController::class, 'store'])->name('visits.store');
    Route::get('/visits/{id}/edit', [VisitController::class, 'edit'])->name('visits.edit');
    Route::put('/visits/{id}', [VisitController::class, 'update'])->name('visits.update');
    Route::get('/visits/{id}/detail', [VisitController::class, 'show'])->name('visits.detail');
    // Route::get('/visits', [VisitController::class, 'index'])->name('visits.index');
    });

    Route::get('/admin/index', [AdminController::class, 'index'])->name('users.index')
        ->middleware('role:superadmin');

    Route::post('/admin/make-admin/{id}', [AdminController::class, 'makeAdmin'])->name('admin.makeAdmin')
    ->middleware('role:superadmin');

    // Route::get('/schedules/{employee}/edit', [ScheduleController::class, 'edit'])->name('schedules.edit');
    // Route::post('/schedules/{employee}/store', [ScheduleController::class, 'store'])->name('schedules.store');
    
    Route::get('/schedules/exports/pdf', [ScheduleController::class, 'exportPdf'])->name('schedules.exports.pdf');
    Route::get('/schedules/exports/excel', [ScheduleController::class, 'exportExcel'])->name('schedules.exports.excel');
    Route::middleware(['role:admin|superadmin'])->group(function () {
        Route::get('/schedules/{id}/edit/{start_date?}', [ScheduleController::class, 'edit'])->name('schedules.edit.weekly');
        Route::post('/schedules/{id}/store', [ScheduleController::class, 'store'])->name('schedules.store');
    });

    Route::get('/building/schedules/exports/pdf', [ScheduleBuildingController::class, 'exportPdf'])->name('building.schedules.exports.pdf');
    Route::get('/building/schedules/exports/excel', [ScheduleBuildingController::class, 'exportExcel'])->name('building.schedules.exports.excel');
    Route::middleware(['role:admin|superadmin|maintenance'])->group(function () {
        Route::get('/building/schedules/{id}/edit/{start_date?}', [ScheduleBuildingController::class, 'edit'])->name('building.schedules.edit.weekly');
        Route::post('/building/schedules/{id}/store', [ScheduleBuildingController::class, 'store'])->name('building.schedules.store');

    });
    Route::middleware(['role:admin|superadmin|maintenance|maintenance1'])->group(function () {
        Route::get('/building/visits/create', [VisitBuildingController::class, 'create'])->name('building.visits.create');
        Route::post('/building/visits/store', [VisitBuildingController::class, 'store'])->name('building.visits.store');
        Route::get('/building/visits/{id}/edit', [VisitBuildingController::class, 'edit'])->name('building.visits.edit');
        Route::put('/building/visits/{id}', [VisitBuildingController::class, 'update'])->name('building.visits.update');
        Route::get('/building/visits/{id}/detail', [VisitBuildingController::class, 'show'])->name('building.visits.detail');
        Route::get('/building/visits/index', [VisitBuildingController::class, 'index'])->name('building.visits.index');
    });
    Route::resource('schedulebuilds', ScheduleBuildingController::class);
    
    
    Route::resource('schedules', ScheduleController::class);
    Route::middleware(['role:superadmin'])->group(function () {
        Route::get('/roles/{role}/permissions', [RolePermissionController::class, 'edit'])->name('roles.permissions');
        Route::put('/roles/{role}/permissions', [RolePermissionController::class, 'update'])->name('roles.permissions.update');
        
        Route::get('/users/{user}/permissions', [UserPermissionController::class, 'edit'])->name('users.permissions');
        Route::put('/users/{user}/permissions', [UserPermissionController::class, 'update'])->name('users.permissions.update');
        
        Route::get('/users/{user}/roles', [UserRoleController::class, 'edit'])->name('users.roles');
        Route::put('/users/{user}/roles', [UserRoleController::class, 'update'])->name('users.roles.update');
        Route::get('/users/index', [UserController::class, 'index'])->name('admin.users.index');
    });
        // Route::put('/users/{user}/roles', [UserController::class, 'update'])->name('users.roles.update');
    

    Route::get('/ticket/export-excel', [TicketController::class, 'exportExcel'])->name('ticket.export.excel');
    Route::get('/ticket/export-pdf', [TicketController::class, 'exportPDF'])->name('ticket.export.pdf');

    Route::get('/outlets/index', [OutletController::class, 'index'])->name('outlets.index');
    Route::get('/outlets/{id}/edit', [OutletController::class, 'edit'])->name('outlets.edit');
    Route::get('/outlets/create', [OutletController::class, 'create'])->name('outlets.create');
    Route::post('/outlets/store', [OutletController::class, 'store'])->name('outlets.store');
    Route::put('/outlets/{id}/update', [OutletController::class, 'update'])->name('outlets.update');
    
    Route::middleware(['role:admin|superadmin|building|maintenance|maintenance1'])->group(function () {
        Route::get('/building/index', [BuildingController::class, 'index'])->name('building.tickets.index');
    });
    
    Route::middleware(['role:admin|superadmin|admin|building'])->group(function () {
    
        Route::get('/building/create', [BuildingController::class, 'create'])->name('building.tickets.create');
        Route::post('/building/store', [BuildingController::class, 'store'])->name('building.tickets.store');
        Route::get('/building/{id}/detail', [BuildingController::class, 'show'])->name('building.tickets.detail');
        Route::get('/building/{id}/edit', [BuildingController::class, 'edit'])->name('building.tickets.edit');
        Route::put('/building/{id}/update', [BuildingController::class, 'update'])->name('building.tickets.update');
        Route::delete('/images/{id}', [BuildingController::class, 'destroyImage'])->name('images.destroy');
        
        Route::get('/building/vendors/create', [BuildingController::class, 'createVendor'])->name('building.vendors.create');
        Route::get('/building/vendors/', [BuildingController::class, 'indexVendor'])->name('building.vendors.index');
        Route::get('/building/vendors/{id}/edit', [BuildingController::class, 'editVendor'])->name('building.vendors.edit');
        Route::put('/building/vendors/{id}/update', [BuildingController::class, 'updateVendor'])->name('building.vendors.update');
        Route::post('/building/vendors/store', [BuildingController::class, 'storeVendor'])->name('building.vendors.store');
        
        Route::get('/building/pics/create', [BuildingController::class, 'createPic'])->name('building.pics.create');
        Route::get('/building/pics/', [BuildingController::class, 'indexPic'])->name('building.pics.index');
        Route::get('/building/pics/{id}/edit', [BuildingController::class, 'editPic'])->name('building.pics.edit');
        Route::put('/building/pics/{id}/update', [BuildingController::class, 'updatePic'])->name('building.pics.update');
        Route::post('/building/pics/store', [BuildingController::class, 'storePic'])->name('building.pics.store');

        Route::get('/building/export-excel', [BuildingController::class, 'exportExcel'])->name('building.export.excel');
        Route::get('/building/export-pdf', [BuildingController::class, 'exportPDF'])->name('building.export.pdf');

    });
    
    Route::resource('reports', DailyReportController::class);
    Route::get('/reports/export/exportexcel', [DailyReportController::class, 'exportExcel'])->name('reports.export.export_excel');
});

Route::prefix('admin')->middleware('role:superadmin')->group(function () {
    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);
    
});

Route::prefix('building')->middleware('role:superadmin')->group(function () {
    // Route::resource('tickets', BuildingController::class);
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
