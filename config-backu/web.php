<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FrontController;
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


Route::get('/',[FrontController::class,'home']);

//Route::get('/',[CategoryController::class,'home']);
Route::get('news-details',[FrontController::class,'news_details'])->name('news-details');

Route::get('news-categories',[FrontController::class,'news_categories'])->name('news-categories');





//Admin
Route::get('AddCategory',[CategoryController::class,'AddCategory']);


Route::post('update-category',[AdminController::class,'update_category'])->name('update-category');
Route::get('EditCategory',[CategoryController::class,'EditCategory']);

Route::get('admin',[AdminController::class,'login'])->name('login');
Route::post('login-auth',[AdminController::class,'loginAuth'])->name('login-auth');
Route::get('dashboard',[AdminController::class,'dashboard'])->name('dashboard');
Route::get('logout',[AdminController::class,'logout'])->name('logout');

Route::get('category-list',[AdminController::class,'category_list'])->name('category-list');

Route::post('add-category',[AdminController::class,'category_add'])->name('add-category');
Route::post('delete-category',[AdminController::class,'delete_category'])->name('delete-category');

Route::get('delete-subcategory',[AdminController::class,'delete_subcategory'])->name('delete-subcategory');

Route::get('subcategory-list',[AdminController::class,'subcategory_list'])->name('subcategory-list');
Route::post('add-subcategory',[AdminController::class,'subcategory_add'])->name('add-subcategory');
Route::post('update-subcategory',[AdminController::class,'update_subcategory'])->name('update-subcategory');
Route::get('subadmin-list',[AdminController::class,'subadmin_list'])->name('subadmin-list');

Route::post('add-subadmin',[AdminController::class,'add_subadmin'])->name('add-subadmin');
Route::post('update-subadmin',[AdminController::class,'update_subadmin'])->name('update-subadmin');
Route::post('delete-subadmin',[AdminController::class,'delete_subadmin'])->name('delete-subadmin');
Route::get('post-news',[AdminController::class,'post_news'])->name('post-news');
Route::get('news-list',[AdminController::class,'news_list'])->name('news-list');
Route::post('GetSubcategoryByCategory',[AdminController::class,'GetSubcategoryByCategory'])->name('GetSubcategoryByCategory');
Route::post('add-news',[AdminController::class,'add_news'])->name('add-news');
Route::get('edit-news',[AdminController::class,'edit_news'])->name('edit-news');
Route::post('update-news',[AdminController::class,'update_news'])->name('update-news');
Route::post('delete-news',[AdminController::class,'delete_news'])->name('delete-news');

Route::post('ChangeLatestStatus',[AdminController::class,'ChangeLatestStatus'])->name('ChangeLatestStatus');
Route::post('ChangePopular',[AdminController::class,'ChangePopular'])->name('ChangePopular');
Route::get('menu-list',[AdminController::class,'menu_list'])->name('menu-list');
Route::get('menu-category',[AdminController::class,'menu_category'])->name('menu-category');
Route::post('add-menucategory',[AdminController::class,'menu_category_add'])->name('add-menucategory');
Route::get('manage-pages',[AdminController::class,'manage_pages'])->name('manage-pages');
Route::get('social-links',[AdminController::class,'social_links'])->name('social-links');
Route::post('update-social',[AdminController::class,'update_social'])->name('update-social');
Route::get('manage-home',[AdminController::class,'manage_home'])->name('manage-home');
Route::get('home-template',[AdminController::class,'home_template'])->name('home-template');
Route::post('update-home-section',[AdminController::class,'update_home_section'])->name('update-home-section');
Route::get('manage-logo',[AdminController::class,'manage_logo'])->name('manage-logo');
Route::post('update-logo',[AdminController::class,'update_logo'])->name('update-logo');

Route::get('manage-ads',[AdminController::class,'manage_ads'])->name('manage-ads');
Route::post('add-ads',[AdminController::class,'add_ads'])->name('add-ads');
Route::post('update-ads',[AdminController::class,'update_ads'])->name('update-ads');
Route::get('manage-header-banner',[AdminController::class,'manage_header_banner'])->name('manage-header-banner');
Route::post('update-header-banner',[AdminController::class,'update_header_banner'])->name('update-header-banner');