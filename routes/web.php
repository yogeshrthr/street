<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
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

Route::group(['middleware' => 'prevent-back-button'],function(){
	Route::get('/',[FrontController::class,'home'])->name('home');
    Route::get('/products',[FrontController::class,'products'])->name('products');
    Route::get('/products-by-category',[FrontController::class,'search_product_by_category'])->name('products-by-category');
    Route::get('/product-details',[FrontController::class,'product_details'])->name('product-details');
    Route::post('/get-variation-price',[FrontController::class,'get_variation_price']);

    //Order and Payment Routes
    Route::post('/place-order',[OrderController::class,'placeOrder'])->name('place-order');
    Route::get('/pay',[OrderController::class,'pay'])->name('pay');
    Route::get('/order-success',[OrderController::class,'orderSuccess'])->name('orderSuccess');

    Route::get('admin',[AdminController::class,'login'])->name('Admin');
    Route::post('login-auth',[AdminController::class,'loginAuth'])->name('login-auth');
    Route::get('/Admin/dashboard',[AdminController::class,'dashboard'])->name('Admin/dashboard');
    Route::get('/Admin/logout',[AdminController::class,'logout'])->name('Admin/logout');
    Route::get('/Admin/category-list',[AdminController::class,'category_list'])->name('Admin/category-list');
    Route::post('Admin/insert-category',[AdminController::class,'insert_category'])->name('Admin/insert-category');
    Route::post('Admin/update-category',[AdminController::class,'update_category'])->name('Admin/update-category');
    Route::post('Admin/delete-category',[AdminController::class,'delete_category'])->name('Admin/delete-category');
    Route::post('Admin/changeCategoryStatus',[AdminController::class,'changeCategoryStatus'])->name('Admin/changeCategoryStatus');

    Route::get('/Admin/user-list',[AdminController::class,'user_list'])->name('Admin/user-list');
    Route::post('Admin/insert-user',[AdminController::class,'insert_user'])->name('Admin/insert-user');
    Route::post('Admin/update-user',[AdminController::class,'update_user'])->name('Admin/update-user');
    Route::post('Admin/delete-user',[AdminController::class,'delete_user'])->name('Admin/delete-user');
    Route::post('Admin/changeUserStatus',[AdminController::class,'changeUserStatus'])->name('Admin/changeUserStatus');

    Route::get('/Admin/testimonial-list',[AdminController::class,'testimonial_list'])->name('Admin/testimonial-list');
    Route::post('Admin/insert-testimonial',[AdminController::class,'insert_testimonial'])->name('Admin/insert-testimonial');
    Route::post('Admin/update-testimonial',[AdminController::class,'update_testimonial'])->name('Admin/update-testimonial');
    Route::post('Admin/delete-testimonial',[AdminController::class,'delete_testimonial'])->name('Admin/delete-testimonial');
    Route::post('Admin/changetestimonialStatus',[AdminController::class,'changetestimonialStatus'])->name('Admin/changetestimonialStatus');
    // pincode
    Route::get('/Admin/pincode-list',[AdminController::class,'pincode_list'])->name('Admin/pincode-list');
    Route::post('Admin/insert-pincode',[AdminController::class,'insert_pincode'])->name('Admin/insert-pincode');
    Route::post('Admin/update-pincode',[AdminController::class,'update_pincode'])->name('Admin/update-pincode');
    Route::post('Admin/delete-pincode',[AdminController::class,'delete_pincode'])->name('Admin/delete-pincode');
    Route::post('Admin/change-pincode-status',[AdminController::class,'changePincodeStatus'])->name('Admin/changePincodeStatus');

    Route::get('/Admin/banner-list',[AdminController::class,'banner_list'])->name('Admin/banner-list');
    Route::post('Admin/insert-banner',[AdminController::class,'insert_banner'])->name('Admin/insert-banner');
    Route::post('Admin/update-banner',[AdminController::class,'update_banner'])->name('Admin/update-banner');
    Route::post('Admin/delete-banner',[AdminController::class,'delete_banner'])->name('Admin/delete-banner');
    Route::post('Admin/changeBannerStatus',[AdminController::class,'changeBannerStatus'])->name('Admin/changeBannerStatus');


    Route::get('/Admin/subcategory-list',[AdminController::class,'subcategory_list'])->name('Admin/subcategory-list');
    Route::post('Admin/insert-subcategory',[AdminController::class,'insert_subcategory'])->name('Admin/insert-subcategory');
    Route::post('Admin/update-subcategory',[AdminController::class,'update_subcategory'])->name('Admin/update-subcategory');
    Route::post('Admin/delete-subcategory',[AdminController::class,'delete_subcategory'])->name('Admin/delete-subcategory');
    Route::post('Admin/changeSubCategoryStatus',[AdminController::class,'changeSubCategoryStatus'])->name('Admin/changeSubCategoryStatus');

    //Product Routes
    Route::get('/admin-products',[ProductController::class,'adminProducts'])->name('admin-products');
    Route::post('/append-product-sub-category',[ProductController::class,'appendProductSubCategory'])->name('append-product-sub-category');
    Route::post('/append-attribute-data',[ProductController::class,'appendAttributeData'])->name('append-attribute-data');
    Route::post('/append-attribute-data1',[ProductController::class,'appendAttributeData1']);
    Route::post('/fetch-product-price',[ProductController::class,'fetchProductPrice'])->name('fetch-product-price');
    //Route::post('/fetch-product-price1',[ProductController::class,'fetchProductPrice1'])->name('fetch-product-price1');
    Route::post('/store-product',[ProductController::class,'storeProduct'])->name('store-product');
    Route::post('Admin/changeProductStatus',[ProductController::class,'changeProductStatus'])->name('Admin/changeProductStatus');
    route::post('/get-produt-details', [ProductController::class,'get_product_details'])->name('Admin/get_product_details');
    route::post('admin/remove-variations', [ProductController::class,'remove_product_variation'])->name('Admin/remove_product_variation');
    route::post('admin/edit-products', [ProductController::class,'edit_products'])->name('Admin/edit_products');

    // Orders
    Route::get('/Admin/order-list',[AdminController::class,'order_list'])->name('Admin/order-list');
    Route::get('admin/order-details',[AdminController::class,'order_details'])->name('Admin/order-details');

    Route::get('/cart',[UserController::class,'cart_list'])->name('cart');
    Route::post('/AddtoCart',[UserController::class,'add_to_cart'])->name('AddtoCart');
    Route::get('/CountCart',[UserController::class,'count_cart'])->name('CountCart');
    Route::post('/update-cart',[UserController::class,'update_cart'])->name('update-cart');
    Route::post('/remove-cart',[UserController::class,'remove_cart'])->name('remove-cart');

    Route::get('/checkout',[UserController::class,'checkout'])->name('checkout');
    // chek pincode vlaid or not for deliverable
    Route::post('/check-pincode',[OrderController::class,'check_pincode'])->name('check_pincode');


    //Authentication
    // Route::get('/login',[UserController::class,'login'])->name('login');
    // Route::get('/register',[UserController::class,'register'])->name('register');
    Route::post('/user-login',[UserController::class,'userLogin'])->name('user-login');
    Route::post('/user-signup',[UserController::class,'userSignup'])->name('user-signup');
    Route::match(['get', 'post'], '/logout', [UserController::class, 'userLogout'])->name('user-logout');

});
