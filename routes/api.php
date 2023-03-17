<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('/individuals', [\App\Http\Controllers\IndividualsController::class, 'index'])->name('individuals.index');
Route::post('/individuals', [\App\Http\Controllers\IndividualsController::class, 'store'])->name('individuals.store');
Route::put('/individuals/{id}', [\App\Http\Controllers\IndividualsController::class, 'update'])->name('individuals.update');
Route::delete('/individuals/{id}', [\App\Http\Controllers\IndividualsController::class, 'destroy'])->name('individuals.destroy');

Route::get('/addresses', [\App\Http\Controllers\AddressController::class, 'index'])->name('addresses.index');
Route::post('/addresses', [\App\Http\Controllers\AddressController::class, 'store'])->name('addresses.store');
Route::put('/addresses/{id}', [\App\Http\Controllers\AddressController::class, 'update'])->name('addresses.update');
Route::delete('/addresses/{id}', [\App\Http\Controllers\AddressController::class, 'destroy'])->name('addresses.destroy');

Route::get('/legal-persons', [\App\Http\Controllers\LegalPersonController::class, 'index'])->name('legal-persons.index');
Route::get('/legal-persons/checklist', [\App\Http\Controllers\LegalPersonController::class, 'existingLegalPersons'])->name('legal-persons.checklist');
Route::post('/legal-persons', [\App\Http\Controllers\LegalPersonController::class, 'store'])->name('legal-persons.store');
Route::put('/legal-persons/{id}', [\App\Http\Controllers\LegalPersonController::class, 'update'])->name('legal-persons.update');
Route::delete('/legal-persons/{id}', [\App\Http\Controllers\LegalPersonController::class, 'destroy'])->name('legal-persons.destroy');

Route::get('/offices', [\App\Http\Controllers\OfficeController::class, 'index'])->name('offices.index');


