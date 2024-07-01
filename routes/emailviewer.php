<?php

use Axyr\EmailViewer\Http\Controllers\BladeEmailController;
use Axyr\EmailViewer\Http\Controllers\JsonEmailController;
use Illuminate\Support\Facades\Route;

$routeNamespace = config('emailviewer.route-namespace');

Route::get($routeNamespace . '/json', [JsonEmailController::class, 'index'])->name($routeNamespace . '.json.index');
Route::get($routeNamespace . '/{id}/json', [JsonEmailController::class, 'show'])->name($routeNamespace . '.json.show');
Route::delete($routeNamespace . '/{id}/json', [JsonEmailController::class, 'destroy'])->name($routeNamespace . '.json.destroy');

Route::get($routeNamespace, [BladeEmailController::class, 'index'])->name($routeNamespace . '.index');
Route::get($routeNamespace . '/{id}', [BladeEmailController::class, 'show'])->name($routeNamespace . '.show');
Route::delete($routeNamespace . '/{id}', [BladeEmailController::class, 'destroy'])->name($routeNamespace . '.destroy');
