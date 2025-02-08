<?php

use Illuminate\Http\Request;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\API\Admin\CategoryControllerAdmin;
use App\Http\Controllers\API\Admin\HomeController;
use App\Http\Controllers\API\User\FrontendController;
use App\Http\Controllers\API\FrontendControllerS;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application.
| These routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::post('login', [AuthController::class, 'login']); 
Route::get('get-category',[FrontendControllerS::class,'Frontend']);
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::prefix('admin')->middleware('role:admin')->group(function () {
        //category Routes Start
        Route::post('create-category', [CategoryControllerAdmin::class, 'create']);
        Route::get('get-categories', [CategoryControllerAdmin::class, 'getCategories']);
        Route::get('categories-details',[CategoryControllerAdmin::class,'GetCategoriesDetails']);
        Route::put('categories-update',[CategoryControllerAdmin::class, 'UpdateCategories']);
        Route::delete('categories-delete',[CategoryControllerAdmin::class, 'DeleteCategories']);
        //category Routes End
        

        // Subcategory Routes Start
        Route::post('create-subcategory', [CategoryControllerAdmin::class, 'SubCategoryCreate']);
        Route::get('get-subcategories', [CategoryControllerAdmin::class, 'GetSubcategories']);
        Route::get('subcategories-details',[CategoryControllerAdmin::class,'GetSubCategoriesDetails']);
        Route::put('subcategories-update' ,[CategoryControllerAdmin::class,'UpdateSubcategories']);
        Route::delete('subcatgeoies-delete',[CategoryControllerAdmin::class,'DeleteSubcategories']);

        //SubCategory Routes End
        Route::get('/columns', [CategoryControllerAdmin::class, 'getColumns']);




        Route::post('/products', [ProductController::class, 'createProduct']);
        Route::put('/products/{id}', [ProductController::class, 'updateProduct']);
        Route::delete('/products/{id}', [ProductController::class, 'deleteProduct']);
        Route::get('/users', [HomeController::class, 'userDetails']);  
    });
    Route::prefix('user')->middleware('role:user')->group(function () {
        Route::get('/products', [ProductController::class, 'getAllProducts']);
        Route::get('/products/{id}', [ProductController::class, 'getProductById']);
        Route::get('/details', [FrontendController::class, 'FrontendUserDetails']); 
    });
});
