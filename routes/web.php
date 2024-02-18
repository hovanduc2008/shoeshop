<?php

use Illuminate\Support\Facades\Route;


// Admin Controller
use App\Http\Controllers\admin\AuthController;
use App\Http\Controllers\admin\CustomerController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\AuthorController;
use App\Http\Controllers\admin\OrderController;
use App\Http\Controllers\admin\ArticleController;

// User Controller
use App\Http\Controllers\user\HomeController as UserHomeController;
use App\Http\Controllers\user\SearchController as UserSearchController;
use App\Http\Controllers\user\AuthController as UserAuthController;
use App\Http\Controllers\user\ProductController as UserProductController;
use App\Http\Controllers\user\AuthorController as UserAuthorController;

use App\Http\Controllers\user\BorrowController as UserBorrowController;
use App\Http\Controllers\user\CartController as UserCartController;
use App\Http\Controllers\user\OrderController as UserOrderController;
use App\Http\Controllers\user\ArticleController as UserArticleController;
use App\Http\Controllers\ProxyController; 
use App\Http\Controllers\VNPayController;


use App\Http\Controllers\CKEditorController;


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

Route::get('/', function () {
    return view('welcome');
}) -> name('welcome');

Route::prefix('/admin') -> group(function() {

    

    Route::prefix('/') -> group(function() {
        Route::view('/' ,'admin.dashboard.index') -> name('admin.dashboard');
        Route::get('/register', [AuthController::class, 'register']) -> name('admin.register');
        Route::get('/login', [AuthController::class, 'login']) -> name('admin.login');

        Route::post('/register', [AuthController::class, 'handleRegister'] ) -> name('admin.handleRegister');
        Route::post('/login', [AuthController::class, 'handleLogin']) -> name('admin.handleLogin');
        Route::get('/logout', [AuthController::class, 'handelLogout']) -> name('admin.logout');
    });

    Route::middleware('admin.login') -> prefix('/dashboard') -> group(function() {
        Route::view('/' ,'admin.dashboard.index') -> name('admin.dashboard');
    });



    // Customer Route------------------------------------------------------------------------
    Route::middleware('admin.login') -> prefix('customer') -> group(function() {
        Route::get('/', [CustomerController:: class, 'index']) -> name('admin.customers');
    });

    // Product Route------------------------------------------------------------------------
    Route::middleware('admin.login') -> prefix('product') -> group(function() {

        Route::get('/', [ProductController::class, 'index']) -> name('admin.products');

        Route::get('create', [ProductController::class, 'createForm']) -> name('admin.product.create');
        Route::post('create', [ProductController::class, 'handleCreate']) -> name('admin.product.handleCreate');

        Route::get('edit/{id}', [ProductController::class, 'editForm']) -> name('admin.product.edit');
        Route::put('edit/{id}', [ProductController::class, 'handleEdit']) -> name('admin.product.handleEdit');

        Route::delete('delete/{id}', [ProductController::class, 'handleDelete']) -> name('admin.product.delete');

        Route::get('filter', [ProductController::class, 'filterProducts']) -> name('admin.product.filter');
        Route::get('borrowproducts', [ProductController::class, 'borrowProducts']) -> name('admin.product.borrowproducts');
    });


    // Category Route------------------------------------------------------------------------
    Route::middleware('admin.login') -> prefix('category') -> group(function() {

        Route::get('/', [CategoryController::class, 'index']) -> name('admin.categories');;

        Route::get('create', [CategoryController::class, 'createForm']) -> name('admin.category.create');
        Route::post('create', [CategoryController::class, 'handleCreate']) -> name('admin.category.handleCreate');

        Route::get('edit/{id}', [CategoryController::class, 'editForm']) -> name('admin.category.edit');
        Route::put('edit/{id}', [CategoryController::class, 'handleEdit']) -> name('admin.category.handleEdit');

        Route::delete('delete/{id}', [CategoryController::class, 'handleDelete']) -> name('admin.category.delete');
    });

     // Category Route------------------------------------------------------------------------
     Route::middleware('admin.login') -> prefix('article') -> group(function() {

        Route::get('/', [ArticleController::class, 'index']) -> name('admin.articles');;

        Route::get('create', [ArticleController::class, 'createForm']) -> name('admin.article.create');
        Route::post('create', [ArticleController::class, 'handleCreate']) -> name('admin.article.handleCreate');

        Route::get('edit/{id}', [ArticleController::class, 'editForm']) -> name('admin.article.edit');
        Route::put('edit/{id}', [ArticleController::class, 'handleEdit']) -> name('admin.article.handleEdit');

        Route::delete('delete/{id}', [ArticleController::class, 'handleDelete']) -> name('admin.article.delete');
    });


    // Author Route------------------------------------------------------------------------
    Route::middleware('admin.login') -> prefix('author') -> group(function() {

        Route::get('/', [AuthorController::class, 'index']) -> name('admin.authors');;

        Route::get('create', [AuthorController::class, 'createForm']) -> name('admin.author.create');
        Route::post('create', [AuthorController::class, 'handleCreate']) -> name('admin.author.handleCreate');

        Route::get('edit/{id}', [AuthorController::class, 'editForm']) -> name('admin.author.edit');
        Route::put('edit/{id}', [AuthorController::class, 'handleEdit']) -> name('admin.author.handleEdit');

        Route::delete('delete/{id}', [AuthorController::class, 'handleDelete']) -> name('admin.author.delete');
    });


    // Order Route------------------------------------------------------------------------
    Route::middleware('admin.login') -> prefix('order') -> group(function() {

        Route::get('/', [OrderController::class, 'index']) -> name('admin.orders');
        Route::get('statistics', [OrderController::class, 'statistics']) -> name('admin.statistics');

        Route::get('/{id}', [OrderController::class, 'detail']) -> name('admin.orders.detail');
        Route::put('/change-status/{id}', [OrderController::class, 'changeStatus']) -> name('admin.orders.change_status');
    });

});



// User Route

Route::prefix('/') -> group(function() {
    Route::get('/', [UserHomeController::class, 'index']) -> name('home-page');
    Route::get('article', [UserArticleController::class, 'index']) -> name('article');
    Route::get('article/{slug}', [UserArticleController::class, 'detail']) -> name('article-detail');
    Route::get('login', [UserAuthController::class, 'login']) -> name('login-form');
    Route::get('register', [UserAuthController::class, 'register']) -> name('register-form');
    Route::get('product/{slug}', [UserProductController::class, 'detail']) -> name('product_detail');
    Route::get('product/set-favourite/{slug}', [UserProductController::class, 'setFavourite']) -> name('product_favourite');
    Route::post('handle-register', [UserAuthController::class, 'handleRegister']) -> name('handle-register');
    Route::post('handle-login', [UserAuthController::class, 'handleLogin']) -> name('handle-login');
    Route::get('handle-logout', [UserAuthController::class, 'handleLogout']) -> name('handle-logout');
    Route::post('handle-review', [UserProductController::class, 'handleReview']) -> name('handle-review');

    // Route::get('search', [UserSearchController::class, 'index']) -> name('search');
    // Route::get('auth', [UserAuthController::class, 'index']) -> name('auth');
    // Route::post('handle-forget', [UserAuthController::class, 'handleForgetPassword']) -> name('handle-forget');

    // Route::get('products', [UserProductController::class, 'index']) -> name('products');
    // Route::get('products/{slug}', [UserProductController::class, 'detail']) -> name('product_detail');
    // Route::get('products/{slug}/read', [UserProductController::class, 'readbook']) -> name('read_book');
    // Route::get('authors', [UserAuthorController::class, 'index']) -> name('authors');
    // Route::get('authors/{slug}', [UserAuthorController::class, 'detail']) -> name('author_detail');
    Route::get('cart', [UserCartController::class, 'index']) -> name('cart');

    Route::post('cart/add/{productId}', [UserCartController::class, 'addToCart']) -> name('addToCart');
    Route::post('cart/update/{productId}',[UserCartController::class, 'updateCartItem']) -> name('updateCartItem');
    Route::post('cart/updateorder',[UserCartController::class, 'updateOrder']) -> name('updateOrder');
    Route::post('cart/remove/{productId}',[UserCartController::class, 'removeCartItem']) -> name('removeCart');


    // Route::get('proxy-pdf', [ProxyController::class, 'getPdf'])->middleware('cors')->name('proxy-pdf');
    // Route::get('borrow/{slug}', [UserBorrowController::class, 'borrow']) -> name('borrow');
    // Route::post('borrow/{id}', [UserBorrowController::class, 'borrow']) -> name('handle_borrow');

    // Route::get('profile', [UserAuthController::class, 'profile']) -> name('profile');
    // Route::put('profile', [UserAuthController::class, 'update_profile']) -> name('update_profile');

    Route::get('order', [UserOrderController::class, 'index']) -> name('order');
    Route::get('order-invoice-view/{id}', [UserOrderController::class, 'orderInvoiceView']) -> name('order-invoice-view');
    Route::get('order-invoice-generate/{id}', [UserOrderController::class, 'orderInvoiceGenerate']) -> name('order-invoice-generate');
    Route::post('ordernow/{productId}', [UserOrderController::class, 'orderNow']) -> name('orderNow');
    Route::get('paymentorder', [UserOrderController::class, 'createOrder']) -> name('createOrder');
    Route::post('submit-order', [UserOrderController::class, 'submitOrder']) -> name('submitOrder');
    Route::get('order-detail/{id}', [UserOrderController::class, 'orderDetail']) -> name('orderDetail');

    // Route::get('createpayment', [VNPayController::class, 'createPayment']) -> name('createpayment');
    // Route::get('vnp_return', [VNPayController::class, 'Returnurl']) -> name('vnp_return');
});

Route::get('password/reset/{token}', [UserAuthController::class, 'handleResetPassword']) -> name('reset-password');

