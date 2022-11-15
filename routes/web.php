<?php

use App\Http\Controllers\CombinedTankController;
use App\Http\Controllers\ManageUserController;
use App\Http\Controllers\RemovedSampleController;
use App\Http\Controllers\RestoreSampleController;
use App\Http\Controllers\SampleController;
use App\Http\Controllers\ShippedSampleController;
use App\Http\Controllers\StorageTankController;
use App\Http\Controllers\TankModelController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
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


//Route::get('/sentSamples',function() {
//  return view('sentSamples');
//});

Route::get('/imprint',function() {
    return view('imprint');
});

Route::get('/privacy',function() {
    return view('privacy');
});

Auth::routes();

Route::get('/', [CombinedTankController::class, 'index']);

Route::get('/sampleList', [SampleController::class, 'index']);

Route::get('/removedSamples', [RemovedSampleController::class, 'index']);

Route::post('/newSamples/pos/confirm', [SampleController::class, 'store']);

Route::post('/newSamples/pos', [SampleController::class, 'create']);

Route::post('/transfer', [RemovedSampleController::class, 'store']);

Route::post('/transferSentSample', [RemovedSampleController::class, 'deleteSentSample']);

Route::post('/transferSampleDelete', [RemovedSampleController::class, 'deleteSampleFromList']);

Route::get('/manageTanks', [TankModelController::class, 'index']);

Route::post('/addTank', [StorageTankController::class, 'store']);

Route::post('/addTankmodel', [TankModelController::class, 'store']);

Route::post('/tankDestroy', [StorageTankController::class, 'destroy']);

//Route::get('/destroy', [SampleController::class, 'destroy']);

Route::post('/shipped', [ShippedSampleController::class, 'store']);

Route::post('/restore', [RestoreSampleController::class, 'create']);

Route::get('/manageUser', [ManageUserController::class, 'create']);

Route::post('/manageUser/updateRights', [ManageUserController::class, 'updateRights']);

Route::post('/manageUser/delete', [ManageUserController::class, 'destroy']);

Route::post('/restore/confirm', [RestoreSampleController::class, 'store']);

//Test Section
Route::get('/dataTest', [CombinedTankController::class, 'indextest']);

Route::get('/sentSamples', [ShippedSampleController::class, 'index']);


//Route::controller(SampleController::class)->group(function () {
//    Route::post('/newSamples/pos', 'create');
//    Route::post('/newSamples', 'store');
//   });

//Route::resource('sample','SampleController');

//Route::get('/newSamples', [SampleController::class, 'index']);

