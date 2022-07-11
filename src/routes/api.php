<?php

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

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

Route::middleware("auth:sanctum")->get("/user", function (Request $request) {
    return $request->user();
});

Route::get("/test", function () {
    return new JsonResponse("Hello, API");
});

Route::get("/test/error", function () {
    throw new BadRequestHttpException("Test Error Trace");
});
