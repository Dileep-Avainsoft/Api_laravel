<?php

use App\Http\Controllers\Api\ApiController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// // });
// Route::post('/postss',function(){

//     return response()->json("This is past demo of api file ");
// });
// Route::get('/posts',function(){

//     return response()->json("This is past demo of api file ");
// });

Route::get('/test',function(){

    p("Working");

});
Route::post('user/store',[ApiController::class,'store']);
Route::get('user/get',[ApiController::class,'index']);
// Route::get('user/show',[ApiController::class,'show']);
Route::delete('user/delete/{id}',[ApiController::class,'destroy']);
Route::put('user/put/{id}',[ApiController::class,'update']);

