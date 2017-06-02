<?php

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

Route::get('/home', 'HomeController@index')->name('home');

/*Usuário Routes*/
Route::get('/usuarios', 'UsuariosController@index')->name('usuarios');
Route::match(array('GET', 'POST'),'/cadastrar-usuario', 'UsuariosController@insert')->name('cadastrar-usuario');
Route::match(array('GET', 'POST'),'/alterar-usuario/{id}', 'UsuariosController@update');
Route::match(array('GET', 'POST'),'/ativar-usuario/{id}', 'UsuariosController@enable');
Route::match(array('GET', 'POST'),'/desativar-usuario/{id}', 'UsuariosController@disable');
Route::get('/consultar-usuarios', 'UsuariosController@search')->name('consultar-usuarios');
Auth::routes();

/*Produtos Rotas*/
Route::get('/produtos', 'ProdutosController@index')->name('produtos');
Route::match(array('GET', 'POST'),'/cadastrar-produto', 'ProdutosController@insert')->name('cadastrar-produto');
Route::match(array('GET', 'POST'),'/alterar-produto/{id}', 'ProdutosController@update');
Route::get('/consultar-produtos', 'ProdutosController@search')->name('consultar-produtos');


/*Fornecedores Rotas*/
Route::get('/fornecedores', 'FornecedoresController@index')->name('fornecedores');
Route::match(array('GET', 'POST'),'/cadastrar-fornecedor', 'FornecedoresController@insert')->name('cadastrar-fornecedor');
Route::match(array('GET', 'POST'),'/excluir-fornecedor/{id}', 'FornecedoresController@delete')->name('excluir-fornecedor');
Route::match(array('GET', 'POST'),'/alterar-fornecedor/{id}', 'FornecedoresController@update');
Route::get('/consultar-fornecedores', 'FornecedoresController@search')->name('consultar-fornecedores');






Auth::routes();

Route::get('/home', 'HomeController@index');
