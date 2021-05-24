<?php

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\CuentasbancariasclienteController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\ProveedorcuentaController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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
//  Route::group(['middleware' => 'auth'], function () {
//      Route::post('store', "InicioController@store")->name('dashboard.store');
//      Route::get('/dashboard', [InicioController::class, 'index'])->name('dashboard');
//  }
Route::group(['middleware' => 'prevent-back-history'],function(){
	Auth::routes();
	Route::group(['middleware' => 'auth'], function () {
        // Route::group(['middleware' => 'checkstatus'], function () {

        // });
        Route::resource('roles', RoleController::class);
        Route::delete('role_delete_modal', 'RoleController@destroy')->name('roles.destroy');
        Route::resource('permissions', 'PermissionController');
        Route::delete('permiso_delete_modal', 'PermissionController@destroy')->name('permissions.destroy');
        Route::resource('users', UserController::class);
        Route::delete('user_delete_modal', 'UserController@destroy')->name('users.destroy');
        Route::get('/', 'HomeController@index')->name('home');

        Route::get('change-password', 'ChangePasswordController@index')->name('changemy.password');
        Route::post('change-password', 'ChangePasswordController@store')->name('change.password');

        Route::resource('almacens','AlmacenController');
        Route::delete('almacen_delete_modal', 'AlmacenController@destroy')->name('almacens.destroy');

        Route::resource('clasificacions','ClasificacionController');
        Route::delete('clasificacion_delete_modal', 'ClasificacionController@destroy')->name('clasificacions.destroy');

        Route::resource('mercancias','MercanciaController');
        Route::delete('mercancia_delete_modal', 'MercanciaController@destroy')->name('mercancias.destroy');


        Route::resource('recepcions','RecepcionController');
        Route::put('recepcion_cancelar_modal', 'RecepcionController@cancelar')->name('recepcions.cancelar');
        Route::put('recepcion_firmar_modal', 'RecepcionController@firmar')->name('recepcions.firmar');

        Route::resource('recepcionmercancias','RecepcionmercanciaController');
        Route::delete('recep_mercancia_delete_modal', 'RecepcionmercanciaController@destroy')->name('recepcionmercancias.destroy');
        Route::put('recep_mercancia_update_modal', 'RecepcionmercanciaController@update')->name('recepcionmercancias.update');

        Route::resource('vales','ValeController');
        Route::put('vale_firmar_modal', 'ValeController@firmar')->name('vales.firmar');
        Route::get('vale_pdf/{vale}', 'ValeController@imprimir')->name('vales.imprimir');
        Route::put('vale_delete_modal', 'ValeController@cancelar')->name('vales.cancelar');


        Route::resource('valeitems','ValeitemController');
        Route::put('valeitem_edit_modal', 'ValeitemController@editar')->name('valeitems.editar');
        Route::delete('valeitem_delete_modal', 'ValeitemController@destroy')->name('valeitems.destroy');

        Route::resource('ficuentas','FicuentaController');
        Route::delete('ficuenta_delete_modal', 'FicuentaController@destroy')->name('ficuentas.destroy');

        Route::resource('fisubcuentas','FisubcuentaController');
        Route::get('fisubcuentas/get_by_cuenta/{ficuenta_id}', 'FisubcuentaController@get_by_cuenta')->name('fisubcuentas.get_by_cuenta');
        Route::delete('fisubcuenta_delete_modal', 'FisubcuentaController@destroy')->name('fisubcuentas.destroy');


        Route::resource('fiinfracuentas','FiinfracuentaController');
        Route::get('fiinfracuentas/get_by_subcuenta/{fisubcuenta_id}', 'FiinfracuentaController@get_by_subcuenta')->name('fiinfracuentas.get_by_subcuenta');
        Route::delete('analisis_delete_modal', 'FiinfracuentaController@destroy')->name('fiinfracuentas.destroy');

        Route::resource('clasificadorcuentas','ClasificadorcuentaController');
        Route::delete('clasificadorcuenta_delete_modal', 'ClasificadorcuentaController@destroy')->name('clasificadorcuentas.destroy');

        Route::resource('tipotproductos','TipotproductoController');
        Route::delete('tipotproducto_delete_modal', 'TipotproductoController@destroy')->name('tipotproductos.destroy');

        Route::resource('tipotproductos','TipotproductoController');
        Route::delete('tipotproducto_delete_modal', 'TipotproductoController@destroy')->name('tipotproductos.destroy');

        Route::resource('tproductos','TproductoController');
        Route::delete('tproducto_delete_modal', 'TproductoController@destroy')->name('tproductos.destroy');

        Route::resource('materiaprimas','MateriaprimaController');
        Route::put('materiaprima_edit_modal', 'MateriaprimaController@editar')->name('materiaprimas.editar');
        Route::delete('mprima_delete_modal', 'MateriaprimaController@destroy')->name('materiaprimas.destroy');

        Route::put('solicitudes_cancelar_modal', 'SolicitudeController@cancelar')->name('solicitudes.cancelar');
        Route::put('solicitudes_confirmar_modal', 'SolicitudeController@confirmar')->name('solicitudes.confirmar');
        Route::put('solicitudes_entregar_modal', 'SolicitudeController@entregar')->name('solicitudes.entregar');
        Route::resource('solicitudes','SolicitudeController');

        // Route::delete('solicitude_delete_modal', 'SolicitudeController@destroy')->name('solicitudes.destroy');

        Route::resource('solicitudproductos','SolicitudproductoController');
        Route::put('solicitudproducto_edit_modal', 'SolicitudproductoController@editar')->name('solicitudproductos.editar');
        Route::delete('solicitudproducto_delete_modal', 'SolicitudproductoController@destroy')->name('solicitudproductos.destroy');

        Route::put('ordentrabajos_cancelar_modal', 'OrdentrabajoController@cancelar')->name('ordentrabajos.cancelar');
        Route::put('ordentrabajos_terminar_modal', 'OrdentrabajoController@terminar')->name('ordentrabajos.terminar');
        Route::resource('ordentrabajos','OrdentrabajoController');

        Route::resource('otsolicitudes','OtsolicitudeController');
        Route::put('otsolicitude_terminar_modal', 'OtsolicitudeController@terminar')->name('otsolicitudes.terminar');
        Route::delete('otsolicitude_delete_modal', 'OtsolicitudeController@destroy')->name('otsolicitudes.destroy');

        Route::get('ofertas/{oferta?}/recalcular', 'OfertaController@recalcular')->name('ofertas.recalcular');
        Route::resource('ofertas','OfertaController');


        Route::resource('ofertamercancias','OfertamercanciaController');

        Route::resource('ofertaproductos','OfertaproductoController');
        Route::put('ofertaproducto_edit_modal', 'OfertaproductoController@editar')->name('ofertaproductos.editar');
        Route::delete('ofertaproducto_delete_modal', 'OfertaproductoController@destroy')->name('ofertaproductos.destroy');

        Route::resource('clientes','ClienteController');
        Route::delete('cliente_delete_modal', 'ClienteController@destroy')->name('clientes.destroy');

        Route::resource('cuentasbancariasclientes','CuentasbancariasclienteController');
        Route::put('cuentasbancariascliente_edit_modal', 'CuentasbancariasclienteController@editar')->name('cuentasbancariasclientes.editar');
        Route::delete('cuentasbancariascliente_delete_modal', 'CuentasbancariasclienteController@destroy')->name('cuentasbancariasclientes.destroy');

        Route::resource('proveedors','ProveedorController');

        Route::resource('proveedorcuentas','ProveedorcuentaController');
        Route::put('proveedorcuenta_edit_modal', 'ProveedorcuentaController@editar')->name('proveedorcuentas.editar');
        Route::delete('proveedorcuenta_delete_modal', 'ProveedorcuentaController@destroy')->name('proveedorcuentas.destroy');

        Route::put('facturas_cancelar_modal', 'FacturaController@cancelar')->name('facturas.cancelar');
        Route::put('facturas_firmar_modal', 'FacturaController@firmar')->name('facturas.firmar');
        Route::put('facturas_pagar_modal', 'FacturaController@pagar')->name('facturas.pagar');
        Route::get('factura_pdf/{factura}', 'FacturaController@imprimir')->name('facturas.imprimir');
        Route::resource('facturas','FacturaController');


        Route::delete('facturaelemento_delete_modal', 'FacturaelementoController@eliminar')->name('facturaelementos.eliminar');
        Route::put('facturaelemento_edit_modal', 'FacturaelementoController@editar')->name('facturaelementos.editar');
        Route::resource('facturaelementos','FacturaelementoController');
    });
});



//hasta aqui
// Auth::routes();

// Route::post('users/{id}', function ($id) {

// });

// Route::put('users/{id}', function ($id) {

// });

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
