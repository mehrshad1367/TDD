<?php

use App\Http\Controllers\AuthContrller;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BooksController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('register', [AuthContrller::class, "register"]);
Route::post("login", [AuthContrller::class, "login"]);

Route::group(["middleware"=>["auth:sanctum"]],function (){
    Route::get("me", function (Request $request) {
        return auth()->user()->createToken('token-name', ['server:update'])->plainTextToken;
});

    Route::get("logout", [AuthContrller::class,"logout"]);

});

Route::post("books",[BooksController::class,"store"])->name("store");
Route::patch("books/{book}-{slug}",[BooksController::class,"update"]);
Route::delete("books/{book}",[BooksController::class,"destroy"]);

Route::post("author",[AuthorController::class,"store"]);

