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
    return view('auth.login');
//    return view('welcome');
});

Auth::routes();

Route::get('/about', function () {
    return view('about');
})->name('about');


Route::get('/home', 'HomeController@index')->name('home');
Route::post('/home/getConsumeProductsAjax', 'HomeController@getConsumeProductsAjax')->name('getConsumeProductsAjax');
Route::post('/home/getCategoriasProductsAjax', 'HomeController@getCategoriasProductsAjax')->name('getCategoriasProductsAjax');
Route::post('/home/getMarcasProductsAjax', 'HomeController@getMarcasProductsAjax')->name('getMarcasProductsAjax');
Route::post('/home/getQuantidadesMesAjax', 'HomeController@getQuantidadesMesAjax')->name('getQuantidadesMesAjax');

Route::resource('/profile', 'ProfileController');

Route::get('/user/relatorio', 'UserController@relatorio')->name('relatorio');
Route::resource('/user', 'UserController');

Route::resource('/category', 'CategoryController');
Route::post('/category/categoryAjax', 'CategoryController@categoryAjax')->name('categoryAjax');

Route::resource('/feedback', 'FeedbackController');

Route::resource('/feedback', 'FeedbackController');

Route::resource('/measure', 'MeasureController');
Route::post('/measure/measureAjax', 'MeasureController@measureAjax')->name('measureAjax');
Route::post('/measure/measureProductAjax', 'MeasureController@measureProductAjax')->name('measureproductAjax');

Route::resource('/product', 'ProductController');
Route::post('/product/productAjax', 'ProductController@productAjax')->name('productAjax');
Route::post('/product/productImageAjax', 'ProductController@productImageAjax')->name('productImageAjax');
Route::post('/product/productCategoryAjax', 'ProductController@productCategoryAjax')->name('productCategoryAjax');
Route::post('/product/productBrandAjax', 'ProductController@productBrandAjax')->name('productBrandAjax');
Route::post('/product/getProductOneAjax', 'ProductController@getProductOneAjax')->name('getProductOneAjax');

Route::resource('/productMeasurements', 'ProductMeasurementsController');
Route::post('/productMeasurements/getProductMeasuresAjax', 'ProductMeasurementsController@getProductMeasuresAjax')->name('getProductMeasuresAjax');
Route::post('/productMeasurements/productImageAjax', 'ProductMeasurementsController@getProductImages');
Route::post('/productMeasurements/productMeasurementsAjax', 'ProductMeasurementsController@createProductMeasurements');
Route::post('/productMeasurements/getValidateProductMeasuresAjax', 'ProductMeasurementsController@getValidateProductMeasuresAjax');

Route::resource('/confProductMeasurementsQuantities', 'ConfProductMeasurementsQuantitiesController');
Route::post('/confProductMeasurementsQuantities/upConfProductMeasurementsQuantitiesAjax', 'ConfProductMeasurementsQuantitiesController@upConfProductMeasurementsQuantitiesAjax');

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


Route::resource('/purchase-order', 'PurchaseOrderController');
Route::post('/purchase-order/productImageAjax', 'PurchaseOrderController@getProductImages');
Route::post('/purchase-order/savePurchaseOrderAjax', 'PurchaseOrderController@savePurchaseOrder')->name('savePurchaseOrderAjax');
Route::post('/purchase-order/getQueryListAjax', 'PurchaseOrderController@getQueryListAjax')->name('getQueryListAjax');
Route::post('/purchase-order/aprovaListaPedidosAjax/{user}', 'PurchaseOrderController@aprovaListaPedidosAjax')->name('aprovaListaPedidosAjax');

Route::resource('/product-write-off', 'ProductWriteOffController');

Route::resource('/notification', 'NotificationController');
Route::post('/notification/getNotificationsAjax', 'NotificationController@getNotificationsAjax')->name('getNotificationsAjax');
Route::post('/notification/viewNotificationsAjax', 'NotificationController@viewNotificationsAjax')->name('viewNotificationsAjax');
