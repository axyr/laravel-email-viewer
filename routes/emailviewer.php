<?php

use Axyr\EmailViewer\Http\Controllers\BladeEmailController;
use Axyr\EmailViewer\Http\Controllers\JsonEmailController;
use Illuminate\Support\Facades\Route;

$routePrefix = config('emailviewer.route-prefix');

Route::get($routePrefix . '/vue', fn() => view('email-viewer::vue'));

Route::get($routePrefix . '/json', [JsonEmailController::class, 'index'])->name($routePrefix . '.json.index');
Route::get($routePrefix . '/{id}/json', [JsonEmailController::class, 'show'])->name($routePrefix . '.json.show');
Route::delete($routePrefix . '/{id}/json', [JsonEmailController::class, 'destroy'])->name($routePrefix . '.json.destroy');

Route::get($routePrefix, [BladeEmailController::class, 'index'])->name($routePrefix . '.index');
Route::get($routePrefix . '/{id}', [BladeEmailController::class, 'show'])->name($routePrefix . '.show');
Route::delete($routePrefix . '/{id}', [BladeEmailController::class, 'destroy'])->name($routePrefix . '.destroy');
