<?php
Route::get('/', function () {
    return view('welcome');
});
Route::get('/home', function () {
    return view('welcome');
});

Route::group(['prefix' => 'admin', 'middleware' => 'auth.checkrole:admin', 'as' => 'admin.'], function(){
    Route::group(['prefix' => 'categories', 'as' => 'categories.'], function(){
        Route::get('/',['uses' => 'CategoriesController@index', 'as' => 'index']);
        Route::get('/create', ['uses' => 'CategoriesController@create', 'as' => 'create']);
        Route::post('/store', ['uses' => 'CategoriesController@store', 'as' => 'store']);
        Route::get('/edit/{id}', ['uses' => 'CategoriesController@edit', 'as' => 'edit']);
        Route::post('/update/{id}', ['uses' => 'CategoriesController@update', 'as' => 'update']);
    });

    Route::group(['prefix' => 'clients', 'as' => 'clients.'], function () {
        Route::get('', ['as' => 'index', 'uses' => 'ClientsController@index']);
        Route::get('create', ['as' => 'create', 'uses' => 'ClientsController@create']);
        Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'ClientsController@edit']);
        Route::post('store', ['as' => 'store', 'uses' => 'ClientsController@store']);
        Route::post('update/{id}', ['as' => 'update', 'uses' => 'ClientsController@update']);
    });
    Route::group(['prefix' => 'products', 'as' => 'products.'], function () {
        Route::get('', ['as' => 'index', 'uses' => 'ProductsController@index']);
        Route::get('create', ['as' => 'create', 'uses' => 'ProductsController@create']);
        Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'ProductsController@edit']);
        Route::get('delete/{id}', ['as' => 'delete', 'uses' => 'ProductsController@update']);
        Route::get('destroy/{id}', ['as' => 'destroy', 'uses' => 'ProductsController@destroy']);
        Route::post('store', ['as' => 'store', 'uses' => 'ProductsController@store']);
        Route::post('update/{id}', ['as' => 'update', 'uses' => 'ProductsController@update']);
    });
    Route::group(['prefix' => 'orders', 'as' => 'orders.'], function () {
        Route::get('', ['as' => 'index', 'uses' => 'OrdersController@index']);
        Route::get('create', ['as' => 'create', 'uses' => 'OrdersController@create']);
        Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'OrdersController@edit']);
        Route::get('delete/{id}', ['as' => 'delete', 'uses' => 'OrdersController@update']);
        Route::get('destroy/{id}', ['as' => 'destroy', 'uses' => 'OrdersController@destroy']);
        Route::post('store', ['as' => 'store', 'uses' => 'OrdersController@store']);
        Route::post('update/{id}', ['as' => 'update', 'uses' => 'OrdersController@update']);
    });
});

Route::group(['prefix' => 'customer', 'middleware' => 'auth.checkrole:client', 'as' => 'customer.'], function () {
    Route::group(['prefix' => 'order', 'as' => 'order.'], function () {
        Route::get('', ['as' => 'index', 'uses' => 'CheckoutController@index']);
        Route::get('create', ['as' => 'create', 'uses' => 'CheckoutController@create']);
        Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'CheckoutController@edit']);
        Route::get('delete/{id}', ['as' => 'delete', 'uses' => 'CheckoutController@update']);
        Route::get('destroy/{id}', ['as' => 'destroy', 'uses' => 'CheckoutController@destroy']);
        Route::post('store', ['as' => 'store', 'uses' => 'CheckoutController@store']);
        Route::post('update/{id}', ['as' => 'update', 'uses' => 'CheckoutController@update']);
    });
});

Route::group(['prefix' => 'customer', 'as' => 'customer.','middleware' => 'auth.checkrole:client'], function(){
    Route::get('order', ['as' => 'order.index', 'uses' => 'CheckoutController@index']);
    Route::get('order/create', ['as' => 'order.create', 'uses' => 'CheckoutController@create']);
    Route::post('order/store', ['as' => 'order.store', 'uses' => 'CheckoutController@store']);
});

Route::group(['middleware'=>'cors'],function(){
    Route::post('oauth/access_token', function() {
        return Response::json(Authorizer::issueAccessToken());
    });
    Route::group(['prefix' => 'api', 'middleware' => 'oauth' , 'as' => 'api.'], function()
    {
        Route::get('authenticated',function(\CodeDelivery\Repositories\UserRepository $userRepository){
            $id = Authorizer::getResourceOwnerId();
            return $userRepository->skipPresenter(false)->find($id);
        });
        Route::group(['prefix'=>'client',  'middleware'=>'oauth.CheckRole:client','as'=>'client.'],function() {
            Route::resource('order',
                'Api\Client\ClientCheckoutController',[
                    'except' => ['create', 'edit'],
                ]);
            Route::get('products','Api\Client\ClientProductController@index');
        });
        Route::group(['prefix'=>'deliveryman', 'middleware'=>'oauth.CheckRole:deliveryman', 'as'=>'deliveryman.'],function() {
            Route::resource('order',
                'Api\Deliveryman\DeliverymanCheckoutController',[
                    'except' => ['create', 'edit', 'destroy','store'],
                ]);
            Route::patch('order/{id}/update-status',[
                'uses'=> 'Api\Deliveryman\DeliverymanCheckoutController@updateStatus',
                'as' => 'order.update_status',
            ]);
        });
        Route::get('cupom/{code}', 'Api\CupomController@show');
    });
});
