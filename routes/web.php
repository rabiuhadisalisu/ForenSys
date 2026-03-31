<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Web\Admin\QueueController as AdminQueueController;
use App\Http\Controllers\Web\Admin\RoleController as AdminRoleController;
use App\Http\Controllers\Web\Admin\SettingsController as AdminSettingsController;
use App\Http\Controllers\Web\Admin\StorageController as AdminStorageController;
use App\Http\Controllers\Web\Admin\UserController as AdminUserController;
use App\Http\Controllers\Web\AuditController;
use App\Http\Controllers\Web\CaseController;
use App\Http\Controllers\Web\CommandCenterController;
use App\Http\Controllers\Web\CryptoLabController;
use App\Http\Controllers\Web\EvidenceController;
use App\Http\Controllers\Web\LabController;
use App\Http\Controllers\Web\LandingController;
use App\Http\Controllers\Web\OrganizationContextController;
use App\Http\Controllers\Web\ReportController;
use App\Http\Controllers\Web\ToolController;
use Illuminate\Support\Facades\Route;

Route::get('/', LandingController::class)->name('home');

Route::post('/organizations/switch', [OrganizationContextController::class, 'update'])
    ->middleware('auth')
    ->name('organizations.switch');

Route::redirect('/dashboard', '/command-center')
    ->middleware(['auth', 'verified', 'active.organization'])
    ->name('dashboard');

Route::middleware(['auth', 'verified', 'active.organization'])->group(function () {
    Route::get('/command-center', [CommandCenterController::class, 'index'])->name('command-center');

    Route::get('/cases', [CaseController::class, 'index'])->name('cases.index');
    Route::get('/cases/{case:ulid}', [CaseController::class, 'show'])->name('cases.show');

    Route::get('/evidence/{evidence:ulid}', [EvidenceController::class, 'show'])->name('evidence.show');

    Route::get('/tools', [ToolController::class, 'index'])->name('tools.index');
    Route::get('/tools/{tool}', [ToolController::class, 'show'])->name('tools.show');
    Route::get('/crypto-lab', [CryptoLabController::class, 'index'])->name('crypto-lab.index');

    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/{report:ulid}', [ReportController::class, 'show'])->name('reports.show');

    Route::get('/audit', [AuditController::class, 'index'])->name('audit.index');

    Route::get('/labs', [LabController::class, 'index'])->name('labs.index');
    Route::get('/labs/{scenario:ulid}', [LabController::class, 'show'])->name('labs.show');

    Route::prefix('admin')->as('admin.')->group(function () {
        Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
        Route::get('/roles', [AdminRoleController::class, 'index'])->name('roles.index');
        Route::get('/settings', [AdminSettingsController::class, 'index'])->name('settings.index');
        Route::get('/storage', [AdminStorageController::class, 'index'])->name('storage.index');
        Route::get('/queues', [AdminQueueController::class, 'index'])->name('queues.index');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
