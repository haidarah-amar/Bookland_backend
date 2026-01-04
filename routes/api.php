<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\AuthorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// /** api/test */
// Route::get('test' , function(){
//     return "I am for test only";
// });
// Route::get('test/{x}' , function($x1){
//     return "I am for test only: $x1";
// });

// Route::get('categories' , ['App\Http\Controllers\Api\CategoryController' , 'index']);


Route:: prefix('categories')->group(function () {
    Route::get('' , [CategoryController::class,  'index']);
    Route::post('' , [CategoryController::class,  'store']);
    Route::put('/{identifier}' , [CategoryController::class,  'update']);
    Route::delete('/{id}' , [CategoryController::class,  'destroy']);  
});


Route::apiResource('author', AuthorController::class);
