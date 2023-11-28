<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ExpirationdateController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\OrderController;
use App\Models\Expirationdate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

     //                   The Unprotected Route

 // Medicine
Route::controller(MedicineController::class)->prefix('medicine')->group(function (){
    Route::get('/','index');
    Route::get('/{id_medicine}','show_medicine');
    Route::get('/category/{id_category}','show');
    Route::get('/search/{name}','search');
});


 // Category
Route::controller(CategoryController::class)->prefix('category')->group(function (){
    Route::get('/search/{name}','search');
});


 // Login & Register
Route::controller(AuthController::class)->group(function (){
    Route::post('/register','register');
    Route::post('/login','login');
});


 // Quantity
Route::controller(ExpirationdateController::class)->group(function (){
    Route::get('/{id}','quantity');
});




       //                           The Protected Route


  //Medicine
Route::controller(MedicineController::class)->middleware('auth:sanctum')->prefix('medicine')->group(function (){
    Route::post('/','create');
    Route::post('/{id_medicine}','update');
    Route::delete('/{id_medicine}','destroy');
});

 //category
Route::controller(CategoryController::class)->middleware('auth:sanctum')->prefix('category')->group(function (){
    Route::post('/','create');
    Route::post('/{id_category}','update');
    Route::delete('/id_category}','destroy');
});

  //Expiration_Date
Route::controller(ExpirationdateController::class)->middleware('auth:sanctum')->prefix('expirationdate')->group(function (){
    Route::post('/','create');
});

  // Order
Route::controller(OrderController::class)->middleware('auth:sanctum')->prefix('order')->group(function (){
    Route::post('/','create');
});

//  Logout
Route::group(['middleware'=>['auth:sanctum']], function () {
    Route::post('/logout',[AuthController::class,'logout']);
});
//test sodkfskdfjdfpew[fd
