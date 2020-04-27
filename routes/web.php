<?php

Route::redirect('/admin', '/'.app()->getLocale().'/admin');

// Joystick Administration
Route::group(['prefix' => '{lang}/admin', 'middleware' => ['auth', 'role:admin']], function () {

    Route::get('/', 'Joystick\AdminController@index');
    Route::get('filemanager', 'Joystick\AdminController@filemanager');
    Route::get('frame-filemanager', 'Joystick\AdminController@frameFilemanager');

    Route::resources([
        'categories' => 'Joystick\CategoryController',
        'companies' => 'Joystick\CompanyController',
        'products' => 'Joystick\ProductController',
        'regions' => 'Joystick\RegionController',
        'articles' => 'Joystick\ArticleController',
        'languages' => 'Joystick\LanguageController',
        'modes' => 'Joystick\ModeController',
        'options' => 'Joystick\OptionController',
        'orders' => 'Joystick\OrderController',
        'pages' => 'Joystick\PageController',
        'section' => 'Joystick\SectionController',
        'slide' => 'Joystick\SlideController',
        'roles' => 'Joystick\RoleController',
        'users' => 'Joystick\UserController',
        'permissions' => 'Joystick\PermissionController'
    ]);

    Route::get('categories-actions', 'Joystick\CategoryController@actionCategories');
    Route::get('companies-actions', 'Joystick\CompanyController@actionCompanies');

    Route::get('products-actions', 'Joystick\ProductController@actionProducts');
    Route::get('products-search', 'Joystick\ProductController@search');
    Route::get('products-category/{id}', 'Joystick\ProductController@categoryProducts');
    Route::get('products/{id}/comments', 'Joystick\ProductController@comments');
    Route::get('products/{id}/destroy-comment', 'Joystick\ProductController@destroyComment');

    Route::get('apps', 'Joystick\AppController@index');
    Route::get('apps/{id}', 'Joystick\AppController@show');
    Route::delete('apps/{id}', 'Joystick\AppController@destroy');
});

Route::redirect('/', '/'.app()->getLocale());

Route::group(['prefix' => '{lang}'], function () {

    Auth::routes();

    // Pages
    Route::get('/', 'PageController@index');
    Route::get('i/catalog', 'PageController@catalog');

        // News
        Route::get('i/news', 'NewsController@news');
        Route::get('news/{page}', 'NewsController@newsSingle');
        Route::post('comment-news', 'NewsController@saveComment');

    Route::get('i/contacts', 'PageController@contacts');
    Route::get('i/{page}', 'PageController@page');

    // Shop
    // Route::get('/', 'ShopController@index');
    // Route::get('brand/{company}', 'ShopController@brandProducts');
    // Route::get('brand/{company}/{category}/{id}', 'ShopController@brandCategoryProducts');
    Route::get('c/{category}/{id}', 'ShopController@categoryProducts');
    // Route::get('c/{category}/{subcategory}/{id}', 'ShopController@subCategoryProducts');
    Route::get('p/{product}', 'ShopController@product');
    Route::post('comment-product', 'ShopController@saveComment');

    // Input
    Route::get('search', 'InputController@search');
    Route::get('search-ajax', 'InputController@searchAjax');
    Route::post('filter-products', 'InputController@filterProducts');
    Route::post('send-app', 'InputController@sendApp');
});


// Cart Actions
// Route::get('cart', 'CartController@cart');
// Route::get('add-to-cart/{id}', 'CartController@addToCart');
// Route::get('remove-from-cart/{id}', 'CartController@removeFromCart');
// Route::get('clear-cart', 'CartController@clearCart');
// Route::post('store-order', 'CartController@storeOrder');
// Route::get('destroy-from-cart/{id}', 'CartController@destroy');


// Favourite Actions
Route::get('favorite', 'FavouriteController@getFavorite');
Route::get('toggle-favourite/{id}', 'FavouriteController@toggleFavourite');
