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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/about', function () {
    return view('about');
})->name('about');


Route::get('/home', 'HomeController@index')->name('home');

Route::resource('/profile', 'ProfileController');

Route::get('/user/relatorio', 'UserController@relatorio')->name('relatorio');
Route::resource('/user', 'UserController');

Route::resource('/category', 'CategoryController');
Route::post('/category/categoryAjax', 'CategoryController@categoryAjax')->name('categoryAjax');

Route::resource('/feedback', 'FeedbackController');

Route::resource('/feedback', 'FeedbackController');

Route::resource('/measure', 'MeasureController');
Route::post('/measure/measureAjax', 'MeasureController@measureAjax')->name('measureAjax');

Route::resource('/product', 'ProductController');
Route::post('/product/productAjax', 'ProductController@productAjax')->name('productAjax');
Route::post('/product/productImageAjax', 'ProductController@productImageAjax')->name('productImageAjax');
Route::post('/product/productCategoryAjax', 'ProductController@productCategoryAjax')->name('productCategoryAjax');
Route::post('/product/productBrandAjax', 'ProductController@productBrandAjax')->name('productBrandAjax');
Route::post('/product/getProductOneAjax', 'ProductController@getProductOneAjax')->name('getProductOneAjax');

Route::post('/productMeasurements/getProductMeasuresAjax', 'ProductMeasurementsController@getProductMeasuresAjax')->name('getProductMeasuresAjax');

Route::resource('/product-request', 'ProductRequestController');
Route::post('/productRequest/productRequestAjax', 'ProductRequestController@store')->name('productRequestAjax');
Route::post('/productRequest/atualiza', 'ProductRequestController@atualiza')->name('productRequestAtualizaAjax');
Route::post('/productRequest/remover/','ProductRequestController@destroy')->name('removerReqProdutos');

Route::post('/product/fileupload/','ProductController@uploadFiles')->name('fileupload');
Route::post('/product/remover/','ProductController@removeProdutos')->name('prod_cancelados');


Route::get('/usuario/novo', function () {
    $user = null;
    return view('users/user', compact('user'));
})->name('novo_usuario');

Route::resource('/brand', 'BrandController');
Route::post('/brand/brandAjax', 'BrandController@brandAjax')->name('brandAjax');


Route::resource('/puchase-order', 'PurchaseOrderController');
Route::post('/puchase-order/productImageAjax', 'PurchaseOrderController@getProductImages');
