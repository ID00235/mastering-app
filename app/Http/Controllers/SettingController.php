<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use Illuminate\Contracts\Encryption\DecryptException;
use Hash;

class SettingController extends Controller
{
    //SETTING > MENU

    function index_menu(){
    	return view('setting.index-menu');
    }

    function getRecordMenu($uuid){
    	$record = DB::table('menu as a')->where('uuid', $uuid)->first();
    	if($record){
    		return response()->json($record);
    	}else{
    		return -1;
    	}
    }

    function insert_menu(Request $r){

        $respon = array('status'=>false,'message'=>'Data Tidak Valid!');
        $uuid = $this->GenUuid();
        $record = array(
            "nama_menu"=>$r->nama_menu, 
            "id_menu_induk"=>$r->id_menu_induk,
            "url"=>$r->url, 
            "urutan"=>$r->urutan, 
            "uuid"=>$uuid);

        if (DB::table('menu')->insert($record)){
            $respon = array('status'=>true,'message'=>'Berhasil Menambahkan Menu Baru!');
        }        
        return response()->json($respon);

    }

    function update_menu(Request $r){
        
        $respon = array('status'=>true,'message'=>'Data Menu Berhasil Disimpan!');
        $record = array("nama_menu"=>$r->nama_menu, 
            "id_menu_induk"=>$r->id_menu_induk,
            "url"=>$r->url, 
            "urutan"=>$r->urutan);

        DB::table('menu')->where('uuid',$r->uuid)->update($record);      
        return response()->json($respon);
        
    }

    function delete_menu(Request $r){
        
        $respon = array('status'=>true,'message'=>'Data Menu Berhasil Dihapus!');
        DB::table('menu')->where('uuid',$r->uuid)->delete();     
        return response()->json($respon);
    }


    //SETTING ROLE

    function index_role(){

        return view('setting.index-role');
    }

    function getRecordRole($uuid){
        $record = DB::table('roles as a')->where('uuid', $uuid)->first();
        if($record){
            return response()->json($record);
        }else{
            return -1;
        }
    }

    function insert_role(Request $r){

        if(!$this->auc()){
            $respon = array('status'=>false,'message'=>'Akses Ditolak!');
        }

        $respon = array('status'=>false,'message'=>'Data Tidak Valid!');
        $uuid = $this->GenUuid();
        $record = array(
            "nama_role"=>$r->nama_role,  
            "uuid"=>$uuid);

        if (DB::table('roles')->insert($record)){
            $respon = array('status'=>true,'message'=>'Berhasil Menambahkan Role Baru!');
        }        
        return response()->json($respon);
    }

    function update_role(Request $r){
        
        if(!$this->auu()){
            $respon = array('status'=>false,'message'=>'Akses Ditolak!');
        }

        $respon = array('status'=>true,'message'=>'Data Role Berhasil Disimpan!');
        $record = array("nama_role"=>$r->nama_role);

        DB::table('roles')->where('uuid',$r->uuid)->update($record);      
        return response()->json($respon);
    }

     function delete_role(Request $r){
        
        if(!$this->aud()){
            $respon = array('status'=>false,'message'=>'Akses Ditolak!');
        }

        $respon = array('status'=>true,'message'=>'Data Role Berhasil Dihapus!');
        $record = DB::table('roles')->where('uuid', $r->uuid)->first();
        if($record){
            DB::table('roles')->where('uuid',$r->uuid)->delete(); 
            //hapus tabel anak
            DB::table('role_menu')->where('id_role', $record->id_role)->delete();
        }
            
        return response()->json($respon);
    }

    //SETTING ROLE-MENU

    function index_role_menu($uuid){

       

        $role = DB::table('roles')->where('uuid',$uuid)->first();
        if(!$role){
            return redirect('404');
        }

        $list_menu =DB::table('menu as a')
            ->select('a.id_menu as value',DB::raw("concat(b.nama_menu,' : ' , a.nama_menu) as text"))
            ->leftjoin('menu as b','a.id_menu_induk','=','b.id_menu')
            ->where('a.id_menu_induk','>','0')
            ->orderby('a.id_menu_induk','asc')
            ->orderby('a.urutan','asc')
            ->get();

        return view('setting.index-role-menu',['role'=>$role,'list_menu'=>$list_menu]);
    }

    function getRecordRoleMenu($uuid_role, $uuid_role_menu){

        $record = DB::table('role_menu as a')
                ->select('a.*', 'b.nama_menu')
                ->leftjoin('menu as b', 'a.id_menu', '=','b.id_menu')
                ->where('a.uuid', $uuid_role_menu)->first();

        if($record){
            return response()->json($record);
        }else{
            return -1;
        }
    }

    function insert_role_menu(Request $r, $uuid){

        if(!$this->auc()){
            $respon = array('status'=>false,'message'=>'Akses Ditolak!');
        }

        $respon = array('status'=>false,'message'=>'Terjadi Kesalahan Data Tidak Valid!');
        $uuid = $this->GenUuid();
        $id_role = decrypt($r->id_role);
        $record = array(
            "id_role"=>$id_role,  
            "id_menu"=>$r->id_menu,  
            "a_create"=>$r->a_create,  
            "a_update"=>$r->a_update,  
            "a_delete"=>$r->a_delete, 
            "uuid"=>$uuid);

        //cek existing
        $exist = DB::table('role_menu')->where('id_role', $id_role)->where('id_menu', $r->id_menu)->count();
        if(!$exist){
            if (DB::table('role_menu')->insert($record)){
                $respon = array('status'=>true,'message'=>'Berhasil Menambahkan Role Menu Baru!');
            }  
        }else{
            $respon = array('status'=>false,'message'=>'Role Menu Sudah Ditambahkan Sebelumnya!');
        }
              
        return response()->json($respon);
    }

    function update_role_menu(Request $r, $uuid){

        if(!$this->auu()){
            $respon = array('status'=>false,'message'=>'Akses Ditolak!');
        }

        $respon = array('status'=>false,'message'=>'Terjadi Kesalahan Data Tidak Valid!');

        //cek existing
        $exist = DB::table('role_menu')->where('uuid', $r->uuid)->where('id_menu', $r->id_menu)->count();
        if($exist){
           $record = array(
                "a_create"=>$r->a_create,  
                "a_update"=>$r->a_update,  
                "a_delete"=>$r->a_delete, 
                );
           DB::table('role_menu')->where('uuid',$r->uuid)->update($record);
           $respon = array('status'=>true,'message'=>'Perubahan Data Berhasil Disimpan!');
        }else{
            $respon = array('status'=>false,'message'=>'Role Menu Tidak Ditemukan!');
        }
              
        return response()->json($respon);
    }

     function delete_role_menu(Request $r, $uuid){
        
        if(!$this->aud()){
            $respon = array('status'=>false,'message'=>'Akses Ditolak!');
        }

        $respon = array('status'=>true,'message'=>'Role Menu Berhasil Dihapus!');
        DB::table('role_menu')->where('uuid',$r->uuid)->delete();     
        return response()->json($respon);
    }



    //SETTING USER

    function index_user(){
        return view('setting.index-user');
    }
    
    function getRecordUser($uuid){
        $record = DB::table('users as a')
                        ->select('a.uuid','a.username','a.nama_pengguna','a.id','a.email','a.telp')
                        ->where('uuid', $uuid)->first();
        if($record){
            return response()->json($record);
        }else{
            return -1;
        }
    }

    function insert_user(Request $r){
        $respon = array('status'=>false,'message'=>'Data Tidak Valid!');
        if($r->password1!=$r->password2){
            return response()->json($respon);
        }
        $password = Hash::make($r->password1);
        $uuid = $this->GenUuid();
        $record = array(
            "username"=>$r->username, 
            "nama_pengguna"=>$r->nama_pengguna,
            "email"=>$r->email,
            "telp"=>$r->telp,
            "password"=>$password,
            "created_at"=>date('Y-m-d H:i:s'),
            "uuid"=>$uuid);

        if(DB::table('users')->where('username', $r->username)->count()){
             return response()->json( array('status'=>false,'message'=>'Username Sudah Digunakan!'));
        }      

        if (DB::table('users')->insert($record)){
            $respon = array('status'=>true,'message'=>'Berhasil Menambahkan User Baru!');
        }  
        return response()->json($respon);
    }

    function update_user(Request $r){
        
        $respon = array('status'=>true,'message'=>'Data User Berhasil Disimpan!');
        $record = array(
                    "nama_pengguna"=>$r->nama_pengguna,
                    "email"=>$r->email,
                    "telp"=>$r->telp,
                );


        DB::table('users')->where('uuid',$r->uuid)->update($record);      
        return response()->json($respon);
    }

    function delete_user(Request $r){
        
        $respon = array('status'=>true,'message'=>'Data Berhasil Dihapus!');
        $user = DB::table('users')->where('uuid',$r->uuid)->first();

        DB::table('users')->where('uuid',$r->uuid)->delete();     
        DB::table('user_role')->where('id_user',$user->id)->delete();     
        DB::table('user_role_instansi')->where('id_user',$user->id)->delete();     
        return response()->json($respon);
    }


    //SETTING USER - ROLE
    function index_user_role($uuid){
        $user = DB::table('users')->where('uuid', $uuid)->first();
        $role = DB::table('roles')->select('id_role as value','nama_role as text')->get();
        return view('setting.index-user-role',['list_role'=>$role,'user'=>$user]);
    }

    function getRecordUserRole($uuid){
        $record = DB::table('user_role as a')
            ->select('b.nama_role','a.uuid')
            ->join('roles as b','a.id_role','b.id_role')
            ->where('a.uuid', $uuid)
            ->first();
        return response()->json($record);
    }

    function insert_user_role(Request $r){
        $uuid = $this->GenUuid();
        $respon = array('status'=>true,'message'=>'Data Role Berhasil Disimpan!');
        $id_user = decrypt($r->id_user);
        $id_role = $r->id_role;

        //cek existing
        if(DB::table('user_role')->where('id_user', $id_user)->where('id_role',$id_role)->count()==0){
            DB::table('user_role')->insert(['id_role'=>$id_role, 'id_user'=>$id_user, "uuid"=>$uuid]);
        }else{
            $respon = array('status'=>false,'message'=>'Role User Sudah Ada!');
        }

        return response()->json($respon);
    }

    function delete_user_role(Request $r){

        $respon = array('status'=>true,'message'=>'Data Berhasil Dihapus!');
        $user_role = DB::table('user_role')->where('uuid',$r->uuid)->first();

        DB::table('user_role')->where('uuid',$r->uuid)->delete(); 
        //tabel anak    
        DB::table('user_role_instansi')
            ->where('id_user',$user_role->id_user)
            ->where('id_role',$user_role->id_role)
            ->delete();        

        return response()->json($respon);
    }

    //SETTING USER - ROLE - INSTANSI
    function index_user_role_instansi($uuid){
        $user_role = DB::table('user_role as a')
        ->select('a.*','b.nama_role','c.username')
        ->leftjoin('roles as b', 'b.id_role','=','a.id_role')
        ->leftjoin('user as c', 'c.id_user','=','a.id_user')
        ->where('a.uuid', $uuid)->first();
        
        
        return view('setting.index-user-role',['list_role'=>$role,'id_user'=>$user]);
    }


}
