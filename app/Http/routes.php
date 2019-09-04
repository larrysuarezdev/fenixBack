<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers: Authorization, Content-Type');

Route::group(['middleware' => ['api', 'cors'], 'prefix' => 'api'], function () {
    
    Route::group(['prefix' => 'account'], function() {
        Route::post('signin', 'UserController@postSignIn');
    });

    Route::group(['middleware' => 'jwt.auth'], function () {  
        
        Route::group(['prefix' => 'dashboard'], function() {
            Route::get('/newclientes', 'DashboardController@getNewClientes');            
        });

        Route::group(['prefix' => 'roles'], function() {
            Route::get('/{id}', 'RolesController@getPermisoByRol');            
            Route::put('/', 'RolesController@putPermisos');            
        });

        Route::group(['prefix' => 'usuarios'], function() {
            Route::get('/', 'UserController@getUsers');
            Route::post('/', 'UserController@saveUser');
            Route::post('/changePassword', 'UserController@changePassword');
            Route::put('/', 'UserController@updateUser');
            Route::put('/', 'UserController@updateUser');
        });

        Route::group(['prefix' => 'clientes'], function() {
            Route::get('/', 'ClientesController@getClientes');
            Route::post('/', 'ClientesController@saveCliente');
            Route::post('/{id}', 'ClientesController@changeState');
            Route::put('/', 'ClientesController@updateCliente');
        });

        Route::group(['prefix' => 'parametros'], function() {
            Route::get('/', 'ParametrosController@getParametros');
            Route::get('/rutas', 'ParametrosController@getRutas');
            Route::get('/periodos', 'ParametrosController@getPeriodos');
            Route::get('/roles', 'ParametrosController@getRoles');
            Route::post('/', 'ParametrosController@postParametros');
            Route::put('/', 'ParametrosController@putParametros');
        });

        Route::group(['prefix' => 'creditos'], function() {
            Route::get('/clientes', 'CreditosController@getClientes');
            Route::get('/{id}', 'CreditosController@getCredito');
            Route::post('/', 'CreditosController@postCredito');
            Route::post('/abonos', 'CreditosController@postAbonos');
            Route::post('/reorder', 'CreditosController@postSetEstadosCreditos');
            Route::post('/renovaciones', 'CreditosController@postRenovaciones');
        });

        Route::group(['prefix' => 'flujoCaja'], function() {
            Route::get('/', 'FlujoCajaController@getFlujoCaja');
            Route::get('/utilidades', 'FlujoCajaController@getFlujoUtilidades');
            Route::post('/', 'FlujoCajaController@postSaveFlujo');
            Route::post('/utilidades', 'FlujoCajaController@postSaveFlujoUtilidades');

        });

        // Route::group(['prefix' => 'flujoUtilidades'], function() {
        //     // Route::get('/', 'flujoUtilidadesController@getFlujoUtilidades');
        //     Route::post('/', 'flujoUtilidadesController@postSaveFlujo');
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

        

        // Route::group(['prefix' => 'devices'], function () {
        //     Route::post('/', 'DevicesController@postSaveDevices');
        // });
    });
});