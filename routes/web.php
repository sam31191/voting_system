<?php

use App\Http\Controllers\VotingController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [VotingController::class, 'index']);

Route::get('/getcandidates', [VotingController::class, 'getCandidates'])->name('candidates');

Route::get('/getDetails', [VotingController::class, 'getDetails'])->name('details');

Route::post('/save-vote', [VotingController::class, 'saveVote'])->name('save.vote');