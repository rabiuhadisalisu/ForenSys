<?php

use App\Http\Controllers\Api\AuditController;
use App\Http\Controllers\Api\CaseController;
use App\Http\Controllers\Api\CaseEvidenceController;
use App\Http\Controllers\Api\CaseTimelineController;
use App\Http\Controllers\Api\CommandCenterController;
use App\Http\Controllers\Api\EvidenceController;
use App\Http\Controllers\Api\EvidenceHashController;
use App\Http\Controllers\Api\EvidenceNoteController;
use App\Http\Controllers\Api\LabController;
use App\Http\Controllers\Api\ReportController;
use App\Http\Controllers\Api\SettingController;
use App\Http\Controllers\Api\ToolController;
use Illuminate\Support\Facades\Route;

Route::get('/command-center', [CommandCenterController::class, 'show'])->name('command-center.show');

Route::get('/cases', [CaseController::class, 'index'])->name('cases.index');
Route::get('/cases/{case:ulid}', [CaseController::class, 'show'])->name('cases.show');
Route::get('/cases/{case:ulid}/timeline', [CaseTimelineController::class, 'index'])->name('cases.timeline.index');
Route::get('/cases/{case:ulid}/evidence', [CaseEvidenceController::class, 'index'])->name('cases.evidence.index');

Route::get('/evidence/{evidence:ulid}', [EvidenceController::class, 'show'])->name('evidence.show');
Route::get('/evidence/{evidence:ulid}/hashes', [EvidenceHashController::class, 'index'])->name('evidence.hashes.index');
Route::get('/evidence/{evidence:ulid}/notes', [EvidenceNoteController::class, 'index'])->name('evidence.notes.index');

Route::get('/tools', [ToolController::class, 'index'])->name('tools.index');
Route::get('/tools/{tool}', [ToolController::class, 'show'])->name('tools.show');

Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
Route::get('/reports/{report:ulid}', [ReportController::class, 'show'])->name('reports.show');

Route::get('/audit', [AuditController::class, 'index'])->name('audit.index');

Route::get('/labs', [LabController::class, 'index'])->name('labs.index');
Route::get('/labs/{scenario:ulid}', [LabController::class, 'show'])->name('labs.show');

Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
