<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers: Authorization, Content-Type');

Route::group(['middleware' => ['api', 'cors'], 'prefix' => 'api'], function () {
    
    Route::group(['prefix' => 'account'], function() {
        Route::post('signin', 'UserController@postSignIn');
    });

    Route::group(['middleware' => 'jwt.auth'], function () {    
        Route::group(['prefix' => 'usuarios'], function() {
            Route::get('/', 'UserController@getUsers');
            Route::post('/', 'UserController@saveUser');
            Route::put('/', 'UserController@updateUser');
        });

        // Route::group(['prefix' => 'placas'], function() {
        //     Route::get('/', 'PlacasController@getPlacas');
        //     Route::post('/files', 'PlacasController@postPlacas');
        // });

        // Route::group(['prefix' => 'viajes'], function() {
        //     Route::get('/', 'ViajesController@getViajes');
        //     Route::get('/all', 'ViajesController@getAllViajesToUser');
        //     Route::post('/cercanos', 'ViajesController@searchViajesCercanos');
        //     Route::post('/', 'ViajesController@postSaveViaje');
        //     Route::post('/validar', 'ViajesController@validarSolicitudViajes');
        //     Route::post('/{id}', 'ViajesController@postAceptarViaje');
        //     Route::put('/calificar/{rating}', 'ViajesController@putCalificarViaje');
        //     Route::put('/', 'ViajesController@putEstadoViajes');
        //     Route::put('/ratings', 'ViajesController@putRatings');
            
        //     Route::get('/solicitudviajes/{tipo}', 'ViajesController@getSolicitudViajes');
        //     Route::put('/solicitudviajes', 'ViajesController@putSolicitudViajes');
        // });

        // Route::group(['prefix' => 'rutas'], function() {
        //     Route::get('/', 'RutasController@getRutas');
        //     Route::post('/', 'RutasController@postSaveRutas');
        //     Route::put('/estado/{id}', 'RutasController@putEstadoRutas');
        // });

        // Route::group(['prefix' => 'devices'], function () {
        //     Route::post('/', 'DevicesController@postSaveDevices');
        // });
    });
});