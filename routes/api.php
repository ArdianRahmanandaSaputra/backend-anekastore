<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\UserDetail;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//API route for register new user
Route::post('/register', [App\Http\Controllers\Api\AuthController::class, 'register'])->name('api.register');
//API route for login user
Route::post('/login', [App\Http\Controllers\Api\AuthController::class, 'login']);

//Protecting Routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/profile', function(Request $request) {
        $user = [
            'user' => auth()->user(),
            'detail' => UserDetail::where('user_id', auth()->user()->id)->first()
        ];
        return response()->json(['user' => auth()->user(), 'detail' => UserDetail::where('user_id', auth()->user()->id)->first()]);
        // return auth()->user();
    });

    Route::post('/update-profile', [App\Http\Controllers\Api\ProfileController::class, 'update']);

    // API route for logout user
    Route::post('/logout', [App\Http\Controllers\Api\AuthController::class, 'logout']);

    // API Route for report
    Route::post('/report', [App\Http\Controllers\Api\ReportController::class, 'generate']);

    // Route::get('/category', [App\Http\Controllers\Api\CategoryController::class, 'index']);
    Route::post('/category-save', [App\Http\Controllers\Api\CategoryController::class, 'save']);
    Route::post('/category-delete', [App\Http\Controllers\Api\CategoryController::class, 'delete']);
    Route::get('/category-view/{id}', [App\Http\Controllers\Api\CategoryController::class, 'view']);
    Route::post('/category-update', [App\Http\Controllers\Api\CategoryController::class, 'update']);

    // Route::get('/product', [App\Http\Controllers\Api\ProductController::class, 'index']);
    Route::post('/product-save', [App\Http\Controllers\Api\ProductController::class, 'save']);
    Route::post('/product-delete', [App\Http\Controllers\Api\ProductController::class, 'delete']);
    Route::post('/product-update', [App\Http\Controllers\Api\ProductController::class, 'update']);

    Route::get('/customers', [App\Http\Controllers\Api\CustomersController::class, 'index']);

    Route::get('/payments', [App\Http\Controllers\Api\PaymentsController::class, 'index']);

    Route::get('/orders-by-customers', [App\Http\Controllers\Api\OrdersController::class, 'orderByCustomer']);

    Route::get('/orders', [App\Http\Controllers\Api\OrdersController::class, 'index']);
    Route::get('/order-view/{id}', [App\Http\Controllers\Api\OrdersController::class, 'view']);
    Route::post('/order-update', [App\Http\Controllers\Api\OrdersController::class, 'update']);

    Route::get('/get-province', [App\Http\Controllers\Api\ProfileController::class, 'province']);
    Route::get('/get-province-by-id/{id}', [App\Http\Controllers\Api\ProfileController::class, 'provinceById']);
    Route::get('/get-city-by-province/{id}', [App\Http\Controllers\Api\ProfileController::class, 'cityByProvince']);
    Route::get('/get-city-by-id/{id}', [App\Http\Controllers\Api\ProfileController::class, 'cityById']);

    Route::post('/get-cart', [App\Http\Controllers\Api\CartController::class, 'getCart']);
    Route::post('/sync-cart', [App\Http\Controllers\Api\CartController::class, 'syncCart']);
    Route::post('/add-cart', [App\Http\Controllers\Api\CartController::class, 'addCart']);
    Route::post('/add-item-cart', [App\Http\Controllers\Api\CartController::class, 'addItemCart']);
    Route::post('/delete-cart', [App\Http\Controllers\Api\CartController::class, 'deleteCart']);
    Route::post('/delete-item-cart', [App\Http\Controllers\Api\CartController::class, 'deleteItemCart']);
    Route::post('/update-cart', [App\Http\Controllers\Api\CartController::class, 'updateCart']);

    Route::post('/get-cost', [App\Http\Controllers\Api\CartController::class, 'getCost']);
    Route::post('/make-order', [App\Http\Controllers\Api\CartController::class, 'makeOrder']);
});

Route::get('/category', [App\Http\Controllers\Api\CategoryController::class, 'index']);
Route::get('/product', [App\Http\Controllers\Api\ProductController::class, 'index']);
Route::get('/getproductbycategory/{id}', [App\Http\Controllers\Api\ProductController::class, 'getproductbycategory']);
Route::get('/getproduct', [App\Http\Controllers\Api\ProductController::class, 'getProduct']);
Route::get('/product-view/{id}', [App\Http\Controllers\Api\ProductController::class, 'view']);
Route::get('/getrelatedproduct/{id}', [App\Http\Controllers\Api\ProductController::class, 'relatedproduct']);
Route::post('/payments/notif', [App\Http\Controllers\Api\CartController::class, 'receive']);
