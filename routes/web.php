<?php

use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

//login logout & register routes
// Auth::routes();



Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);
Route::get('/products/show/{product_id}', [App\Http\Controllers\HomeController::class, 'show']);
Route::get('/shop', [App\Http\Controllers\HomeController::class, 'shop']);
Route::get('category/products/{category}', [App\Http\Controllers\HomeController::class, 'getProductByCategory']);

Route::get('/activate/{code}', [App\Http\Controllers\ActivationController::class, 'activateUserAccount']);
Route::get('/resend/{email}', [App\Http\Controllers\ActivationController::class, 'resendActivationCode']);



Route::post('/products/search', [App\Http\Controllers\AdminController::class, 'productsearch']);


Route::group(['prefix' => '/admin','middleware' => 'adminauth'], function () {

    Route::get('/', [App\Http\Controllers\AdminController::class, 'index']);

    Route::get('/category', [App\Http\Controllers\AdminController::class, 'categoryindex']);
    Route::get('/category/create', [App\Http\Controllers\AdminController::class, 'categorycreate']);
    Route::post('/category/store', [App\Http\Controllers\AdminController::class, 'categorystore']);
    Route::get('/category/edit/{category_id}', [App\Http\Controllers\AdminController::class, 'categoryedit']);
    Route::put('/category/update/{category_id}', [App\Http\Controllers\AdminController::class, 'categoryupdate']);
    Route::delete('/category/destroy/{category_id}', [App\Http\Controllers\AdminController::class, 'categorydestroy']);
    Route::post('/category/search', [App\Http\Controllers\AdminController::class, 'categorsearch']);

    Route::get('/products', [App\Http\Controllers\AdminController::class, 'productindex']);
    Route::get('/products/create', [App\Http\Controllers\AdminController::class, 'productcreate']);
    Route::post('/products/store', [App\Http\Controllers\AdminController::class, 'productstore']);
    Route::get('/products/edit/{product_id}', [App\Http\Controllers\AdminController::class, 'productedit']);
    Route::put('/products/update/{product_id}', [App\Http\Controllers\AdminController::class, 'productupdate']);
    Route::delete('/products/destroy/{product_id}', [App\Http\Controllers\AdminController::class, 'productdestroy']);
    

    Route::get('/posts', [App\Http\Controllers\AdminController::class, 'postindex']);
    Route::get('/posts/create', [App\Http\Controllers\AdminController::class, 'postcreate']);
    Route::post('/posts/store', [App\Http\Controllers\AdminController::class, 'poststore']);
    Route::get('/posts/edit/{post_id}', [App\Http\Controllers\AdminController::class, 'postedit']);
    Route::put('/posts/update/{post_id}', [App\Http\Controllers\AdminController::class, 'postupdate']);
    Route::delete('/posts/destroy/{post_id}', [App\Http\Controllers\AdminController::class, 'postdestroy']);
    Route::post('/posts/search', [App\Http\Controllers\AdminController::class, 'postsearch']);



    Route::get('/login', [App\Http\Controllers\AdminController::class, 'showAdminLoginForm']);
    Route::post('/login', [App\Http\Controllers\AdminController::class, 'adminLogin']);
    Route::get('/logout', [App\Http\Controllers\AdminController::class, 'adminLogout']);
    Route::get('/products', [App\Http\Controllers\AdminController::class, 'getProducts']);
    Route::get('/orders', [App\Http\Controllers\AdminController::class, 'getOrders']);
    Route::get('/category', [App\Http\Controllers\AdminController::class, 'getCategory']);
});







Route::get('/cart', [App\Http\Controllers\CartController::class,'index']);
Route::post('/add/cart/{product}', [App\Http\Controllers\CartController::class,'addProductToCart']);
Route::delete('/remove/{product}/cart', [App\Http\Controllers\CartController::class,'removeProductFromCart']);
Route::put('/remove/{product}/cart', [App\Http\Controllers\CartController::class,'updateProductOnCart']);

Route::get('/handle-payment', [App\Http\Controllers\PaypalPaymentController::class,'handlePayment']);
Route::get('/cancel-payment', [App\Http\Controllers\PaypalPaymentController::class,'paymentCancel']);
Route::get('/payment-success', [App\Http\Controllers\PaypalPaymentController::class,'paymentSuccess']);

Route::get('/about', [App\Http\Controllers\AboutpageController::class, 'index']);

Route::get('/contact-us', [App\Http\Controllers\ContactController::class, 'index']);
Route::post('/contact/post', [App\Http\Controllers\ContactController::class, 'contact']);


Route::get('/posts', [App\Http\Controllers\PostController::class, 'posts']);
Route::get('/post/{slug}',[App\Http\Controllers\PostController::class, 'singlepost']);

//home route
// Route::get('/', 'HomeController@index')->name('home');
//activate user account routes
// Route::get('/activate/{code}', 'ActivationController@activateUserAccount')->name('user.activate');
// Route::get('/resend/{email}', 'ActivationController@resendActivationCode')->name('code.resend');
//products routes
// Route::resource('products', 'ProductController');
// Route::get('products/category/{category}', 'HomeController@getProductByCategory')->name("category.products");
//cart routes
// Route::get('/cart', 'CartController@index')->name('cart.index');
// Route::post('/add/cart/{product}', 'CartController@addProductToCart')->name('add.cart');
// Route::delete('/remove/{product}/cart', 'CartController@removeProductFromCart')->name('remove.cart');
// Route::put('/update/{product}/cart', 'CartController@updateProductOnCart')->name('update.cart');


//payment routes
// Route::get('/handle-payment', 'PaypalPaymentController@handlePayment')->name('make.payment');
// Route::get('/cancel-payment', 'PaypalPaymentController@paymentCancel')->name('cancel.payment');
// Route::get('/payment-success', 'PaypalPaymentController@paymentSuccess')->name('success.payment');
//admin routes
// Route::get('/admin', 'AdminController@index')->name('admin.index');
// Route::get('/admin/login', 'AdminController@showAdminLoginForm')->name('admin.login');
// Route::post('/admin/login', 'AdminController@adminLogin')->name('admin.login');
// Route::get('/admin/logout', 'AdminController@adminLogout')->name('admin.logout');
// Route::get('/admin/products', 'AdminController@getProducts')->name('admin.products');
// Route::get('/admin/orders', 'AdminController@getOrders')->name('admin.orders');
//orders routes
Route::resource('orders', 'OrderController');


Auth::routes();


Route::get('/dashboard',[App\Http\Controllers\UserProfilePageController::class, 'index']);
Route::get('/dashboard/edit-info',[App\Http\Controllers\UserProfilePageController::class, 'editinfo']);
Route::post('/dashboard/edit-info/post',[App\Http\Controllers\UserProfilePageController::class, 'infochange']);
Route::post('/dashboard/edit-info/avatar',[App\Http\Controllers\UserProfilePageController::class, 'avatar']);
Route::post('/dashboard/edit-info/avatar-remove',[App\Http\Controllers\UserProfilePageController::class, 'avatar_remove']);


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



    //dashboard

    //edit info


    //view orders
    Route::get('/dashboard/orders',[App\Http\Controllers\UserOrderPageController::class, 'index']);
    Route::get('/dashboard/user-orders',[App\Http\Controllers\UserOrderPageController::class, 'userOrders']);
    Route::get('/dashboard/orders/view/{id}',[App\Http\Controllers\UserOrderPageController::class, 'viewOrderDetails']);
    //edit address


    Route::get('/dashboard/edit-address', [App\Http\Controllers\UserAddressPageController::class, 'index']);
    Route::post('/dashboard/edit-address/billing',[App\Http\Controllers\UserAddressPageController::class, 'billing']);
    Route::post('/dashboard/edit-address/shipping',[App\Http\Controllers\UserAddressPageController::class, 'shipping']);

