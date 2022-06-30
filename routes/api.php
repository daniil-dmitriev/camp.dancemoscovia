<?php

use App\Http\Controllers\Api\v1\CoachesController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SpreadsheetController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

Route::middleware('auth:sanctum')->get('/user', function(Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->get('/authenticated', function() {
    if (Auth::user()->isAdmin) {
        return ["status" => true];
    } else {
        return [
            "status" => false, "message" => "Authentication failed! :-("
        ];
    }
});



// settings routes
Route::resource('settings', SettingsController::class);
Route::resource('coaches', CoachesController::class);  
Route::resource('users', UserController::class);

// spreadsheet routes
Route::get('/reportCoach', [SpreadsheetController::class, "createCoachReport"]);
Route::get('/reportVisitor', [SpreadsheetController::class, "createVisitorReport"]);
Route::post('/addCampInfoFromExcel', [SpreadsheetController::class, "addCampInfoFromExcel"]);
Route::post('/addCoachPrice', [SpreadsheetController::class, "addCoachPrice"]);
Route::post('/addMoscoviaFromExcel', [SpreadsheetController::class, "addMoscoviaFromExcel"]);

// registration form routes
Route::resource('register', RegisterController::class);
Route::post('/send-email', [MailController::class, "sendEmail"]);
Route::post('/getCorrectRecordPrice', [RegisterController::class, "getCorrectRecordPrice"]);


// auth routes
Route::post('/login', [LoginController::class, "login"]);
Route::post('/logout', [LoginController::class, "logout"]);