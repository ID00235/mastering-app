<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Illuminate\Http\Request;
use Uuid;
use DB;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    function GenUuid(){
    	list($usec, $sec) = explode(" ", microtime());
    	$time = ((float)$usec + (float)$sec);
    	$time = str_replace(".", "-", $time);
    	$panjang = strlen($time);
    	$sisa = substr($time, -1*($panjang-5));
    	return Uuid::generate(3,rand(10,99).rand(0,9).substr($time, 0,5).'-'.rand(0,9).rand(0,9)."-".$sisa,Uuid::NS_DNS);
    }

   // function allow_user_update(){
    function auu(){
    	loadHelper('akses'); return ucu();
    }

   // function allow_user_delete(){
    function aud(){
    	loadHelper('akses'); return ucd();
    }

    // function allow_user_create(){
    function auc(){
    	loadHelper('akses'); return ucc();
    }

    function getEnumTable($table, $field){
        $type = DB::select("SHOW COLUMNS FROM {$table} WHERE Field = '{$field}'");
        preg_match("/^enum\(\'(.*)\'\)$/", $type[0]->Type, $matches);
        $enum = explode("','", $matches[1]);
        $arr = array();
        foreach ($enum as $e){
            array_push($arr, ['value'=>$e, 'text'=>$e]);
        }
        $arr = json_decode(json_encode($arr));
        return $arr;
    }

    function base_route($path=""){
        $route = request()->segment(1);
        if($path!=""){
            return url($route."/".$path);
        }
        return url($route);
    }
}
