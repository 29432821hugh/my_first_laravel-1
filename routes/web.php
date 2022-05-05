<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ShoppingCartController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\ProductController;
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

// 首頁
Route::get('/', [Controller::class, 'index']);

// 商品詳情
Route::get('/product_detail/{id}', [Controller::class, 'product']);

// 接受加入購物車請求
Route::post('/add_to_cart', [Controller::class, 'add_cart']);



// 留言相關路由
Route::get('/comment', [Controller::class, 'comment']);
Route::post('/comment/store', [Controller::class, 'save_comment']);
Route::get('/comment/edit/{id}', [Controller::class, 'edit_comment']);
Route::get('/comment/update/{id}', [Controller::class, 'update_comment']);
Route::get('/comment/delete/{id}', [Controller::class, 'delete_comment']);

// 購物車相關路由
Route::middleware(['auth'])->group(function () {
    Route::get('/shopping1', [ShoppingCartController::class, 'step01']);
    Route::post('/shopping2', [ShoppingCartController::class, 'step02']);
    Route::post('/shopping3', [ShoppingCartController::class, 'step03']);
    Route::post('/shopping4', [ShoppingCartController::class, 'step04']);
});
// 後台首頁
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth','power'])->name('dashboard');

// 登入相關路由
require __DIR__.'/auth.php';

 // BANNER管理相關路由
Route::prefix('/banner')->middleware(['auth','power'])->group(function () {
    Route::get('/', [BannerController::class, 'index']); //總表,列表頁 = Read
    Route::get('/create', [BannerController::class, 'create']); //新增頁 C
    Route::post('/store', [BannerController::class, 'store']); //儲存 C
    Route::get('/edit/{id}', [BannerController::class, 'edit']); //編輯頁 U
    Route::post('/update/{id}', [BannerController::class, 'update']); //更新  U
    Route::delete('/delete/{id}', [BannerController::class, 'destroy']); //刪除 D
});

 // 商品管理相關路由
Route::prefix('/product')->middleware(['auth','power'])->group(function () {
    Route::get('/', [ProductController::class, 'index']); //總表,列表頁 = Read
    Route::get('/create', [ProductController::class, 'create']); //新增頁 C
    Route::post('/store', [ProductController::class, 'store']); //儲存 C
    Route::get('/edit/{id}', [ProductController::class, 'edit']); //編輯頁 U
    Route::post('/update/{id}', [ProductController::class, 'update']); //更新  U
    Route::delete('/delete/{id}', [ProductController::class, 'destroy']); //刪除 D
    Route::delete('/delete_img/{img_id}', [ProductController::class, 'delete_img']); //刪除次要圖片 (接收次要商品圖片的id) D
});


 // 會員管理相關路由
 Route::prefix('/account')->middleware(['auth','power'])->group(function () {
    Route::get('/', [AccountController::class, 'index']); //總表,列表頁 = Read
    Route::get('/create', [AccountController::class, 'create']); //新增頁 C
    Route::post('/store', [AccountController::class, 'store']); //儲存 C
    Route::get('/edit/{id}', [AccountController::class, 'edit']); //編輯頁 U
    Route::post('/update/{id}', [AccountController::class, 'update']); //更新  U
    Route::delete('/delete/{id}', [AccountController::class, 'destroy']); //刪除 D
});

//BANNER管理相關頁面  手工建立版本 (諄照resful API 的規定)
// Route::get('/banner', [BannerController::class, 'index']); //總表,列表頁
// Route::post('/banner', [BannerController::class, 'store']); //儲存
// Route::get('/banner/create', [BannerController::class, 'create']); //新增頁
// Route::get('/banner/{id}', [BannerController::class, 'show']); //單筆檢視頁
// Route::post('/banner/{id}', [BannerController::class, 'edit']); //編輯頁
// Route::patch('/banner/{id}', [BannerController::class, 'update']); //更新
// Route::delete('/banner/{id}', [BannerController::class, 'destroy']); //刪除

//以下一行底上面七行
// Route::resource('banner', BannerController::class);
