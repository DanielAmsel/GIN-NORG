<?php

use App\Http\Controllers\CombinedTankController;
use App\Http\Controllers\ManageUserController;
use App\Http\Controllers\RemovedSampleController;
use App\Http\Controllers\RestoreSampleController;
use App\Http\Controllers\SampleController;
use App\Http\Controllers\ShippedSampleController;
use App\Http\Controllers\StorageTankController;
use App\Http\Controllers\TankModelController;
use App\Http\Controllers\MaterialTypeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FhirController;

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


Route::get('/imprint',function() {
    return view('imprint');
});

Route::get('/privacy',function() {
    return view('privacy');
});

Route::get('/download', function() {
    try {
        $date = date("Ymd", strtotime("-1 days"));
        $dumpDirectory = public_path()."/sqldumps/NorgDBdump{$date}";
        $pathToFile = public_path()."/sqldumps/NorgDBdump{$date}/NorgSQLdump{$date}.sql";
        $name = "NorgDBdump" . date("Y-m-d", strtotime("-1 days"));
        $headers = ['Content-Type: application/sql'];

        // Check if the directory exists
        if (!file_exists($dumpDirectory) || !is_dir($dumpDirectory)) {
            throw new Exception("The directory for the SQL dumps does not exist: {$dumpDirectory}, cause it's empty");
        }

        // Check if the file exists
        if (!file_exists($pathToFile)) {
            throw new Exception("The file {$pathToFile} was not found.");
        }


        return response()->download($pathToFile, $name, $headers);
    } catch (Exception $e) {
        // Log the error
        Log::error("An error occurred: " . $e->getMessage());
        
        return response()->json(['error' => $e->getMessage()], 500);
    }
});

Route::get('/insideTank/{idTank}/',[CombinedTankController::class, 'indexContainer']);

Route::get('/insideTank/{idTank}/{idContainer}/',[CombinedTankController::class, 'indexTube']);

Route::get('/insideTank/{idTank}/{idContainer}/{idTube}/',[CombinedTankController::class, 'indexSample']);
Auth::routes();

Route::get('/', [CombinedTankController::class, 'index']);

Route::get('/sampleList', [SampleController::class, 'index']);

Route::get('/removedSamples', [RemovedSampleController::class, 'index']);

Route::post('/newSamples/pos/confirm', [SampleController::class, 'store']);

Route::post('/newSamples/pos', [SampleController::class, 'create']);

Route::get('/manageMaterialTypes', [MaterialTypeController::class, 'index']);

Route::post('/manageMaterialTypes', [MaterialTypeController::class, 'store'])->name('material-type.store');

Route::post('/materialDestroy', [MaterialTypeController::class, 'destroy']);

Route::post('/transfer', [RemovedSampleController::class, 'store']);

Route::post('/transferSentSample', [RemovedSampleController::class, 'deleteSentSample']);

Route::post('/transferSampleDelete', [RemovedSampleController::class, 'deleteSampleFromList']);

Route::get('/manageTanks', [TankModelController::class, 'index']);

Route::post('/addTank', [StorageTankController::class, 'store']);

Route::post('/addTankmodel', [TankModelController::class, 'store']);

Route::post('/tankDestroy', [StorageTankController::class, 'destroy']);

Route::post('/shipped', [ShippedSampleController::class, 'store']);

Route::post('/restore', [RestoreSampleController::class, 'create']);

Route::get('/manageUser', [ManageUserController::class, 'create']);

Route::post('/manageUser/updateRights', [ManageUserController::class, 'updateRights']);

Route::post('/manageUser/confirm-delete', [ManageUserController::class, 'confirmDelete'])->name('manageUser.confirmDelete');

Route::post('/manageUser/delete', [ManageUserController::class, 'delete'])->name('manageUser.delete');

Route::post('/manageUser/reset', [ManageUserController::class, 'resetPassword']);

Route::post('/restore/confirm', [RestoreSampleController::class, 'store']);

//Test Section
Route::get('/dataTest', [CombinedTankController::class, 'indextest']);

Route::get('/sentSamples', [ShippedSampleController::class, 'index']);