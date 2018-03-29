<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use Illuminate\Contracts\Encryption\DecryptException;
use Hash;

class CodeGenController extends Controller
{
    //
    function index(){
    	$db_name = env('DB_DATABASE');
		$list_table = DB::select(
			"select TABLE_NAME as value, TABLE_NAME as text from information_schema.tables 
			where TABLE_SCHEMA = '$db_name' 
			and 
			TABLE_TYPE='BASE TABLE' ");
    	return view('crud-gen.index',['list_table'=>$list_table]);
    }

    function gen_route(Request $r){
    	$db_name = env('DB_DATABASE');
    	$table = $r->table;
    	$prefix = $r->prefix;
    	$crud_controller = $r->crud_controller;
    	$datatable_controller = $r->datatable_controller;
    	$list_columns = 
    	DB::select("select COLUMN_NAME, IS_NULLABLE, DATA_TYPE , EXTRA, COLUMN_KEY  from information_schema.COLUMNS where TABLE_SCHEMA = '$db_name' and TABLE_NAME='$table' and COLUMN_NAME !='uuid' ");

    	return view('crud-gen.gen-route',['table'=>$r->table,'prefix'=>$prefix, 'crud_controller'=>$crud_controller, 'datatable_controller'=>$datatable_controller, 'list_columns'=>$list_columns]);
    }

    function form_column($table){
        $db_name = env('DB_DATABASE');
    	$field = DB::select("select COLUMN_NAME, IS_NULLABLE, DATA_TYPE , EXTRA, COLUMN_KEY  from information_schema.COLUMNS where TABLE_SCHEMA = '$db_name' and TABLE_NAME='$table' ");
    	return view('crud-gen.form-columns',['field'=>$field]);
    }

    function gen_form_create(Request $r){
        return view('crud-gen.form-generate-create',['table'=>$r->table, 
                'action'=>$r->action, 'field'=>$r->field, 'jenis'=>$r->jenis]);
    }

    function gen_form_update(Request $r){
        return view('crud-gen.form-generate-update',['table'=>$r->table, 
                'action'=>$r->action, 'field'=>$r->field, 'jenis'=>$r->jenis]);
    }

    function gen_form_delete(Request $r){
        return view('crud-gen.form-generate-delete',['table'=>$r->table, 
                'action'=>$r->action, 'field'=>$r->field, 'jenis'=>$r->jenis]);
    }
}
