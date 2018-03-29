<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use Datatables;

class DTSettingController extends Controller
{
    //DT MENU
    function data_menu(){
    	$query = DB::table('menu as a')
    	->select('a.id_menu as id_menu','a.nama_menu as nama_menu','a.uuid',
    		'a.url as url', 'a.urutan as urutan',
    		'b.nama_menu as group_menu')
    	->leftjoin('menu as b','b.id_menu','=','a.id_menu_induk')
    	->where('a.id_menu_induk','<>','0');

    	return Datatables::of($query)
    	->addColumn('action', function ($query) {

            $edit = ""; $delete = "";
            if($this->auu()){
                $edit = '<a href="#" class="act" data-toggle="modal" data-uuid="'.$query->uuid.'" data-target="#modal-form-edit-menu" title="Edit"><i class="la la-edit"></i></a> ';
            }
            if($this->aud()){
                $delete = '<a href="#" data-target="#modal-form-hapus-menu" data-uuid="'.$query->uuid.'"  title="Hapus" data-toggle="modal" class="act"><i class="la la-trash"></i></a> ';
            }
            $action =  $edit."".$delete;
            if ($action==""){$action='<a href="#" class="act"><i class="la la-lock"></i></a>'; }

            return $action;
        })
        ->addIndexColumn()
    	->make(true);
    }

    //DT ROLE
    function data_role(){
        $query = DB::table('roles as a')->
        select('a.id_role as id_role','a.nama_role as nama_role','a.uuid', DB::raw("count(b.id_menu) as n_menu"))
        ->leftjoin('role_menu as b','a.id_role','=','b.id_role')
        ->groupby('a.id_role');

        return Datatables::of($query)
        ->addColumn('menu', function($query){
            $btn =  "<a href=\"".url('setting-role/menu/'.$query->uuid)."\" class=\"btn btn-xs btn-default\">$query->n_menu Menu</a>";
            return $btn;
        })
        ->addColumn('action', function ($query) {

            $edit = ""; $delete = "";
            if($this->auu()){
                $edit = '<a href="#" class="act" data-toggle="modal" data-uuid="'.$query->uuid.'" data-target="#modal-form-edit-role" title="Edit"><i class="la la-edit"></i></a> ';
            }
            if($this->aud()){
                $delete = '<a href="#" data-target="#modal-form-hapus-role" data-uuid="'.$query->uuid.'"  title="Hapus" data-toggle="modal" class="act"><i class="la la-trash"></i></a> ';
            }
            $action =  $edit."".$delete;
            if ($action==""){$action='<a href="#" class="act"><i class="la la-lock"></i></a>'; }

            return $action;
        })
        ->addIndexColumn()
        ->rawColumns(['menu', 'action'])
        ->make(true);
    }

    //DT ROLE-MENU
    function data_role_menu($uuid_role){
        $role = DB::table('roles')->where('uuid', $uuid_role)->first();
        if(!$role){
            return array();
        }

        $query = DB::table('role_menu as a')->select('a.uuid as uuid','c.nama_menu as group_menu','b.nama_menu as nama_menu','a.a_create', 'a.a_update','a.a_delete')
        ->leftjoin('menu as b','a.id_menu','=','b.id_menu')
        ->leftjoin('menu as c','b.id_menu_induk','=','c.id_menu')
        ->where('a.id_role', $role->id_role);

        return Datatables::of($query)
        ->addColumn('action', function ($query) {
            $edit = ""; $delete = "";
            if($this->auu()){
                $edit = '<a href="#" class="act" data-toggle="modal" data-uuid="'.$query->uuid.'" data-target="#modal-form-edit-rolemenu" title="Edit"><i class="la la-edit"></i></a> ';
            }
            if($this->aud()){
                $delete = '<a href="#" data-target="#modal-form-hapus-rolemenu" data-uuid="'.$query->uuid.'"  title="Hapus" data-toggle="modal" class="act"><i class="la la-trash"></i></a> ';
            }
            $action =  $edit."".$delete;
            if ($action==""){$action='<a href="#" class="act"><i class="la la-lock"></i></a>'; }

            return $action;
        })
        ->editColumn('a_create', function($query){
            return  $query->a_create=="1" ? "<i class='fa fa-check'></i>" : "<i class='la la-minus'></i>";
        })
        ->editColumn('a_update', function($query){
           return $query->a_update=="1" ? "<i class='fa fa-check'></i>" : "<i class='la la-minus'></i>";
        })
        ->editColumn('a_delete', function($query){
            return $query->a_delete=="1" ? "<i class='fa fa-check'></i>" : "<i class='la la-minus'></i>";
        })
        ->addIndexColumn()
        ->rawColumns(['menu', 'action','a_create','a_update','a_delete'])
        ->make(true);
    }


    //DT USER
    function data_user(){
        
        $query = DB::table('users as a')
        ->select('a.id as id_user','a.username as username','a.uuid',
            'a.nama_pengguna as nama_pengguna', 'a.email as email',
            'a.telp as telp',DB::raw("count(b.id_user_role) as role") )
        ->leftjoin('user_role as b', 'b.id_user','=','a.id')
        ->groupby('a.id');

        return Datatables::of($query)
        ->addColumn('action', function ($query) {

            $edit = ""; $delete = "";
            if($this->auu()){
                $edit = '<a href="#" class="act" data-toggle="modal" data-uuid="'.$query->uuid.'" data-target="#modal-form-edit-user" title="Edit"><i class="la la-edit"></i></a> ';
            }
            if($this->auu()){
                $edit .= '<a href="#" class="act" data-toggle="modal" data-uuid="'.$query->uuid.'" data-target="#modal-form-edit-password" title="Ubah Password"><i class="la la-key"></i></a> ';
            }
            if($this->aud()){
                $delete = '<a href="#" data-target="#modal-form-hapus-user" data-uuid="'.$query->uuid.'"  title="Hapus" data-toggle="modal" class="act"><i class="la la-trash"></i></a> ';
            }
            $action =  $edit."".$delete;
            if ($action==""){$action='<a href="#" class="act"><i class="la la-lock"></i></a>'; }

            return $action;
        })
        ->editColumn('role', function($query){
            return "<a href=\"".url('setting-user/role/uuid/'.$query->uuid)."\" class=\"btn btn-xs btn-default\">$query->role Role</a>";
        })
        ->addIndexColumn()
        ->rawColumns(['action','role'])
        ->make(true);
    }

    //DT USER - ROLE
    function data_user_role($uuid){
       
        $user  = DB::table('users')->where('uuid', $uuid)->first();
        $id_user = $user->id;

        $query = DB::table('user_role as a')
        ->select('a.uuid','b.nama_role', DB::raw("count(c.id_user_role_instansi) as instansi"))
        ->join('roles as b', 'b.id_role','=','a.id_role')
        ->leftjoin('user_role_instansi as c', function($join) use($id_user){
            $join->on('c.id_role','=','a.id_role')
              ->where('c.id_user','=', $id_user);
          })
        ->where('a.id_user','=',$id_user)
        ->groupby('a.id_role')
        ->groupby('a.uuid')
        ->groupby('b.nama_role');

        return Datatables::of($query)
                  ->addColumn('action', function ($query) {
                        $edit = ""; $delete = "";
                        if($this->aud()){
                            $delete = '<a href="#" data-target="#modal-form-hapus-user-role" data-uuid="'.$query->uuid.'"  title="Hapus" data-toggle="modal" class="act"><i class="la la-trash"></i></a> ';
                        }
                        $action =  $edit."".$delete;
                        if ($action==""){$action='<a href="#" class="act"><i class="la la-lock"></i></a>'; }

                        return $action;
                    })
                  ->editColumn('instansi', function($query){
                        return "<a href=\"".url('setting-user/role-instansi/uuid/'.$query->uuid)."\" class=\"btn btn-xs btn-default\">$query->instansi Instansi</a>";
                    })
                 ->addIndexColumn()
                 ->rawColumns(['action','instansi'])
                 ->make(true);

    }
}
