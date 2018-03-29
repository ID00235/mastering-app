<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use User;
use Auth;
use Session;
use DB;
use Uuid;

class LoginController extends Controller
{
    //
    function submitLogin(Request $r){
    	$username = $r->username;
    	$password = $r->password;

    	if (Auth::attempt(['username' => $username, 'password' => $password])) {
           	$this->generate_user_menu();
            return redirect()->intended('beranda');
        }else{
        	return redirect('login')->with('warning', 'Username dan Password Tidak Sesuai');
        }
    }

    
    function logout(){
    	Auth::logout();
    	Session::flush();
    	return redirect('/');
    }

    function generate_user_menu(){
    	//ambil semua menu yang bisa diakses user
    	$id_user = Auth::user()->id;
    	$menu_user = array();
        
    	$menu_induk = DB::select("select d.*
							from user_role as a, role_menu as b, menu as c , menu as d
							where a.id_role = b.id_role and c.id_menu = b.id_menu  and c.id_menu_induk = d.id_menu
							and a.id_user = $id_user
							group by d.id_menu order by d.urutan");

    	foreach($menu_induk as $mni){
    		$menu_user[$mni->id_menu]['id_menu'] = $mni->id_menu;
    		$menu_user[$mni->id_menu]['url'] = $mni->url;
    		$menu_user[$mni->id_menu]['icon'] = $mni->icon;
    		$menu_user[$mni->id_menu]['nama_menu'] = $mni->nama_menu;

    		$id_menu_induk = $mni->id_menu;

    		$menu_anak = DB::select("select c.nama_menu, c.id_menu, c.url, c.urutan, c.id_menu_induk from 
                user_role as a, role_menu as b, menu as c , menu as d 
                where a.id_role = b.id_role and c.id_menu = b.id_menu and c.id_menu_induk = d.id_menu and a.id_user = $id_user and c.id_menu_induk=$id_menu_induk group by c.nama_menu, c.id_menu, c.url, c.urutan, c.id_menu_induk
                order by c.id_menu_induk, c.urutan ");

    		$temp_anak = array();
    		foreach($menu_anak as $mna){
    			array_push($temp_anak, array("id_menu"=>$mna->id_menu, "url"=>$mna->url, "nama_menu"=>$mna->nama_menu));
    		}
    		$menu_user[$mni->id_menu]['child'] = $temp_anak;
    	}	
        $menu_user = json_encode($menu_user);
        Session::put('menu_session',$menu_user);
    	
    }

   function test_uuid(){
        $data = DB::table('urusan')->get();
        foreach ($data as $d) {
            $uuid  =  $this->GenUuid();  
            $id = $d->id_urusan;
            DB::table('urusan')->where('id_urusan', $id)->update(['uuid'=>$uuid]);
        }
   }


   function import_proker(){
        $data = DB::table('import_proker')->where('jenis','PROGRAM')->get();
        $no = 1;

        foreach ($data as $d){
            $kode = trim(str_replace(",", ".", $d->kode));
            $kode_induk = trim(str_replace(",", ".", $d->kode_induk));
        }
        foreach ($data as $d) {

            $uuid = $this->GenUuid();
            $urusan = DB::table('urusan')->where('kode_urusan', $d->kode_urusan)->first();

            if ($urusan){
                $record = array("id_urusan"=>$urusan->id_urusan, 
                        "kode_program"=>$d->kode,
                         "nama_program"=>$d->nama_proker,
                         "uuid"=>$uuid
                     );
                DB::table('program')->insert($record);
            }else{  
                echo "TIDAK ADA URUSAN <br>";
            }
        }
   }
   
}
