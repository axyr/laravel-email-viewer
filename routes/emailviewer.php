<?php

use Axyr\EmailViewer\Http\Controllers\JsonEmailController;
use Illuminate\Support\Facades\Route;

$routeNamespace = config('emailviewer.route-namespace');

Route::get($routeNamespace, [JsonEmailController::class, 'index'])->name($routeNamespace . '.index');
Route::get($routeNamespace . '/{id}', [JsonEmailController::class, 'show'])->name($routeNamespace . '.show');
Route::delete($routeNamespace . '/{id}', [JsonEmailController::class, 'destroy'])->name($routeNamespace . '.destroy');
