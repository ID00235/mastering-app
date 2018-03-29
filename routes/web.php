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

Route::get('/login', function () {
	if(Auth::user()){
		return redirect('beranda');
	}
	return view('login');
})->name('login');

Route::post('/login/submit', 'LoginController@submitLogin');
Route::get('/logout', 'LoginController@logout');
Route::get('/uuid', 'LoginController@test_uuid');
Route::get('/import_proker', 'LoginController@import_proker');


Route::middleware(['auth.login','auth.menu'])->group(function(){
	Route::get('/', function () {return redirect('beranda');});
	Route::get('/beranda','HomeController@index');


	//SETTING > Code GENERATOR
	Route::group(['prefix'=>'code-gen'], function(){
		Route::get('/', 'CodeGenController@index');
		Route::post('/gen-route', 'CodeGenController@gen_route');
		Route::get('/form-columns/{table}', 'CodeGenController@form_column');
		Route::post('/gen-form-create', 'CodeGenController@gen_form_create');
		Route::post('/gen-form-update', 'CodeGenController@gen_form_update');
		Route::post('/gen-form-delete', 'CodeGenController@gen_form_delete');
	});

	//SETTING > MENU
	Route::group(['prefix'=>'setting-menu'], function(){
		Route::get('/', 'SettingController@index_menu');
		Route::get('/data', 'DTSettingController@data_menu');
		Route::get('/get/{uuid}', 'SettingController@getRecordMenu');
		Route::post('/insert', 'SettingController@insert_menu');
		Route::post('/update', 'SettingController@update_menu');
		Route::post('/delete', 'SettingController@delete_menu');
	});

	//SETTING > ROLE
	Route::group(['prefix'=>'setting-role'], function(){
		Route::get('/', 'SettingController@index_role');
		Route::get('/data', 'DTSettingController@data_role');
		Route::get('/get/{uuid}', 'SettingController@getRecordRole');
		Route::post('/insert', 'SettingController@insert_role');
		Route::post('/update', 'SettingController@update_role');
		Route::post('/delete', 'SettingController@delete_role');

		//ROLE > MENU
		Route::get('/menu/{uuid_role}', 'SettingController@index_role_menu');
		Route::get('/menu/{uuid_role}/data', 'DTSettingController@data_role_menu');
		Route::get('/menu/{uuid_role}/get/{uuid}', 'SettingController@getRecordRoleMenu');
		Route::post('/menu/{uuid_role}/insert', 'SettingController@insert_role_menu');
		Route::post('/menu/{uuid_role}/update', 'SettingController@update_role_menu');
		Route::post('/menu/{uuid_role}/delete', 'SettingController@delete_role_menu');
		
	});

	//SETTING > USER
	Route::group(['prefix'=>'setting-user'], function(){
		Route::get('/', 'SettingController@index_user');
		Route::get('/data', 'DTSettingController@data_user');
		Route::get('/get/{uuid}', 'SettingController@getRecordUser');
		Route::post('/insert', 'SettingController@insert_user');
		Route::post('/update', 'SettingController@update_user');
		Route::post('/delete', 'SettingController@delete_user');

		//USER > ROLE
		Route::get('/role/uuid/{uuid}', 'SettingController@index_user_role');
		Route::get('/role/data/{uuid}', 'DTSettingController@data_user_role');
		Route::get('/role/get/{uuid}', 'SettingController@getRecordUserRole');
		Route::post('/role/insert', 'SettingController@insert_user_role');
		Route::post('/role/update', 'SettingController@update_user_role');
		Route::post('/role/delete', 'SettingController@delete_user_role');
		

		//USER > ROLE
		Route::get('/role-instansi/{uuid}', 'SettingController@index_user_role_instansi');
		
	});


	//MASTER DATA -> DAERAH
	Route::group(['prefix'=>'ref-daerah'], function(){
		Route::get('/', 'MasterDataController@index_daerah');
		Route::get('/data', 'DTMasterController@data_daerah');
		Route::get('/get/{uuid}', 'MasterDataController@getRecordDaerah');
		Route::post('/insert', 'MasterDataController@insert_daerah');
		Route::post('/update', 'MasterDataController@update_daerah');
		Route::post('/delete', 'MasterDataController@delete_daerah');
	});

	//MASTER DATA -> FUNGSI
	Route::group(['prefix'=>'ref-fungsi'], function(){
		Route::get('/', 'MasterDataController@index_fungsi');
		Route::get('/data', 'DTMasterController@data_fungsi');
		Route::get('/get/{uuid}', 'MasterDataController@getRecordFungsi');
		Route::post('/insert', 'MasterDataController@insert_fungsi');
		Route::post('/update', 'MasterDataController@update_fungsi');
		Route::post('/delete', 'MasterDataController@delete_fungsi');
	});

	//MASTER DATA -> URUSAN
	Route::group(['prefix'=>'ref-urusan'], function(){
		Route::get('/', 'MasterDataController@index_urusan');
		Route::get('/data', 'DTMasterController@data_urusan');
		Route::get('/get/{uuid}', 'MasterDataController@get_record_urusan');
		Route::get('/get-list', 'MasterDataController@getListUrusan');
		Route::post('/insert', 'MasterDataController@insert_urusan');
		Route::post('/update', 'MasterDataController@update_urusan');
		Route::post('/delete', 'MasterDataController@delete_urusan');
	});


	/*MASTER DATA > URUSAN - ORGANISASI */
	Route::group(['prefix'=>'ref-urusan-organisasi'],function(){
	    Route::get('/','MasterDataController@index_urusan_organisasi');
	    Route::get('/datatable','DTMasterController@datatable_urusan_organisasi');
	    Route::get('/get/{uuid}','MasterDataController@get_record_urusan_organisasi');
	    Route::post('/insert','MasterDataController@insert_urusan_organisasi');
	    Route::post('/update','MasterDataController@update_urusan_organisasi');
	    Route::post('/delete','MasterDataController@delete_urusan_organisasi');
	});

	/*MASTER DATA > Program */
	Route::group(['prefix'=>'ref-program'],function(){
	    Route::get('/','MasterDataController@index_program');
	    Route::get('/datatable','DTMasterController@datatable_program');
	    Route::get('/get/{uuid}','MasterDataController@get_record_program');
	    Route::get('/gen-kode-program/{urusan}','MasterDataController@gen_kode_program');
	    Route::post('/insert','MasterDataController@insert_program');
	    Route::post('/update','MasterDataController@update_program');
	    Route::post('/delete','MasterDataController@delete_program');
	});


	
	/*Master Perencanaan > Visi */
	Route::group(['prefix'=>'master-visi'],function(){
	    Route::get('/','MasterPerencanaanController@index_visi');
	    Route::get('/datatable','DTMasterPerencanaanController@datatable_visi');
	    Route::get('/get/{uuid}','MasterPerencanaanController@get_record_visi');
	    Route::post('/insert','MasterPerencanaanController@insert_visi');
	    Route::post('/update','MasterPerencanaanController@update_visi');
	    Route::post('/delete','MasterPerencanaanController@delete_visi');
	});


});


