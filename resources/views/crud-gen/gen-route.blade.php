<?php
$tab1 = "&nbsp;&nbsp;&nbsp;&nbsp;";
$tab2 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
$tab3 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
$tab4 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
$tab5 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
?>

 <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
        <li role="presentation" class="active"><a href="#tab_rest_route1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Route/web.php</a>
        </li>
        <li role="presentation" class=""><a href="#tab_rest_route2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">CRUD Controller</a>
        </li>
        <li role="presentation" class=""><a href="#tab_rest_route3" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">DT Controller</a>
        </li>
        <li role="presentation" class=""><a href="#tab_rest_route4" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false">Blade Template</a>
        </li>
      </ul>
      <div id="myTabContent" class="tab-content">
        <div role="tabpanel" class="tab-pane fade active in" id="tab_rest_route1" aria-labelledby="home-tab">
<h4>Copi Code ke Route/Web.php</h4>
<pre>
<code>
	/*Group Menu > Nama Menu */
	Route::group(['prefix'=>'{{$prefix}}'],function(){
	{{$tab1}}Route::get('/','{{$crud_controller}}@index_{{$table}}');
	{{$tab1}}Route::get('/datatable','{{$datatable_controller}}@datatable_{{$table}}');
	{{$tab1}}Route::get('/get/{uuid}','{{$crud_controller}}@get_record_{{$table}}');
	{{$tab1}}Route::post('/insert','{{$crud_controller}}@insert_{{$table}}');
	{{$tab1}}Route::post('/update','{{$crud_controller}}@update_{{$table}}');
	{{$tab1}}Route::post('/delete','{{$crud_controller}}@delete_{{$table}}');
	});
</code>
</pre>
        </div>
        <div role="tabpanel" class="tab-pane fade" id="tab_rest_route2" aria-labelledby="profile-tab">
<h4>Controller: {{$crud_controller}}.php</h4>
<pre>
<code>
	/*Start Code Route {{$prefix}}*/
	/*============================*/

	function index_{{$table}}(){
	{{$tab1}}/* tambahkan baris code jika perlu */
	{{$tab1}}return view('group.nama_menu',['var1'=>$var1]);
	}
	
	function get_record_{{$table}}($uuid){
	{{$tab1}}/*tambahkan baris code jika perlu*/
	{{$tab1}}$record = DB::table('{{$table}} as a')->where('a.uuid', $uuid)->first();
	{{$tab1}}if($record){
	{{$tab1}}{{$tab1}}return response()->json($record);
	{{$tab1}}}else{
	{{$tab1}}{{$tab1}}return -1;
	{{$tab1}}{{'}'}}
	}
	
	function insert_{{$table}}(Request $r){
	{{$tab1}}$respon = array('status'=>false,'message'=>'Gagal Menambahkan Data, Data Tidak Valid!');
	{{$tab1}}$uuid = $this->GenUuid();
	{{$tab1}}$record = array(
@foreach($list_columns as $d)
@if($d->EXTRA!='auto_increment')
	{{$tab2}}"{{$d->COLUMN_NAME}}"=>$r->{{$d->COLUMN_NAME}},
@endif
@if($d->COLUMN_NAME=='created_at')
	{{$tab2}}"{{$d->COLUMN_NAME}}"=>date('Y-m-d H:i:s'),
@endif
@if($d->COLUMN_NAME=='created_by')
	{{$tab2}}"{{$d->COLUMN_NAME}}"=>Auth::user()->id,
@endif
@endforeach
	{{$tab2}}"uuid"=>$uuid,
	{{$tab1}});
    {{$tab2}}/* tambahkan baris code jika perlu */
    {{$tab2}}if(DB::table('{{$table}}')->insert($record)){
    	{{$tab2}}$respon = array('status'=>true,'message'=>'Berhasil Menambahkan Data!');
    {{$tab2}}{{'}'}}
    {{$tab2}}return response()->json($respon);
	}

	function update_{{$table}}(Request $r){
	{{$tab1}}$respon = array('status'=>false,'message'=>'Gagal Menyimpan Data, Data Tidak Valid!');
	{{$tab1}}$uuid = $r->uuid;
	{{$tab1}}$current = DB::table('{{$table}} as a')->where('a.uuid', $uuid)->first();
	{{$tab1}}$record = array(
@foreach($list_columns as $d)
@if($d->EXTRA!='auto_increment')
	{{$tab2}}"{{$d->COLUMN_NAME}}"=>$r->{{$d->COLUMN_NAME}},
@endif
@if($d->COLUMN_NAME=='updated_at')
	{{$tab2}}"{{$d->COLUMN_NAME}}"=>date('Y-m-d H:i:s'),
@endif
@if($d->COLUMN_NAME=='updated_by')
	{{$tab2}}"{{$d->COLUMN_NAME}}"=>Auth::user()->id,
@endif
@endforeach
	{{$tab1}});
    {{$tab2}}/* tambahkan baris code jika perlu */
    {{$tab2}}if(DB::table('{{$table}} as a')->where('a.uuid',$r->uuid)->update($record)){
    	{{$tab2}}$respon = array('status'=>true,'message'=>'Update Data Berhasil Disimpan!');
    {{$tab2}}{{'}'}}
    {{$tab2}}return response()->json($respon);
	}

	function delete_{{$table}}(Request $r){
	{{$tab1}}$uuid=$r->uuid; $record = DB::table('{{$table}} as a')->where('a.uuid', $r->uuid)->first();
	{{$tab1}}if($record){
	{{$tab2}}/* tambahkan baris code jika perlu */
	{{$tab1}}{{$tab1}}DB::table('{{$table}}')->where('uuid',$uuid)->delete();
	{{$tab1}}{{$tab1}}$respon = array('status'=>true,'message'=>'Data Berhasil Dihapus!');
	{{$tab1}}}else{
	{{$tab2}}$respon = array('status'=>false,'message'=>'Data Tidak Ditemukan!');
	{{$tab1}}{{'}'}}
	{{$tab1}}return response()->json($respon);
	}

	/*============================*/
	/*End Code Route {{$prefix}}*/
</code>
</pre>
        </div>
        <div role="tabpanel" class="tab-pane fade" id="tab_rest_route3" aria-labelledby="profile-tab">
<h4>Controller: {{$datatable_controller}}.php</h4>
<pre>
<code>
	/*Datatable {{$prefix}} : Table=> {{$table}}*/
	/*============================*/
	function datatable_{{$table}}(){
	{{$tab1}}$query = DB::table('{{$table}} as a')->select('a.*');
	{{$tab1}}return Datatables::of($query)
	{{$tab2}}->addColumn('action', function ($query) {
    {{$tab2}}$edit = ""; $delete = "";
    {{$tab2}}if($this->auu()){
    {{$tab2}}{{$tab1}}$edit = '{{'<'}}a href="#" class="act" data-toggle="modal" data-uuid="'.$query->uuid.'"data-target="#modal-form-edit-{{$table}}" title="Edit">{{'<'}}i class="la la-edit">{{'<'}}/i>{{'<'}}/a> ';
            }
    {{$tab2}}if($this->aud()){
    {{$tab2}}{{$tab1}}$delete = '{{'<'}}a href="#" data-target="#modal-form-hapus-{{$table}}" data-uuid="'.$query->uuid.'"  title="Hapus" data-toggle="modal" class="act">{{"<"}}i class="la la-trash">{{"<"}}/i>{{"<"}}/a> ';
    {{$tab2}}}
    {{$tab2}}{{$tab1}}$action =  $edit."".$delete;
    {{$tab2}}if ($action==""){$action='{{'<'}}a href="#" class="act">{{'<'}}i class="la la-lock">{{'<'}}/i>{{'<'}}/a>'; }
    {{$tab2}}{{$tab1}}return $action;
    {{$tab2}}})
    {{$tab2}}->addIndexColumn()
    {{$tab2}}->rawColumns(['action'])
    {{$tab2}}->make(true);
	}
	/*============================*/
	/*End Datatable*/
</code>
</pre>          
        </div>

        <div role="tabpanel" class="tab-pane fade" id="tab_rest_route4" aria-labelledby="profile-tab">
<h4>Template Blade</h4>
<pre>
<code>
	{{'@'}}extends('layout')
	{{'@'}}section('content')
	{{'<'}}?php
	loadHelper('akses');
	$base_route = '{{$prefix}}';
	?>
	{{'<'}}hr>
	{{'<'}}div class="row">
	{{$tab1}}{{'<'}}div class="col-md-12 col-sm-12 col-xs-12 pd-20">
	{{$tab2}}{{'<'}}div class="x_panel">
	{{$tab3}}{{'<'}}div class="x_title">
	{{$tab4}}{{'<'}}div class="pull-right">{{'<'}}span class="loading-panel">{{'<'}}/span>{{'<'}}/div>
	{{$tab4}}{{$tab1}}{{'<'}}h2>{TITLE PAGE}{{'<'}}/h2>
	{{$tab4}}{{$tab1}}{{'<'}}div class="clearfix">{{'<'}}/div>
	{{$tab3}}{{'<'}}/div>
	{{$tab3}}{{'<'}}div class="x_content">
	{{$tab3}}{{$tab1}}{{'<'}}p>
	{{$tab3}}{{$tab1}}{{'<'}}!--tombol aksi disini cuy-->
	{{$tab3}}{{$tab1}}{{'<'}}/p>
	{{$tab3}}{{$tab1}}{{'<'}}hr>
	{{$tab3}}{{$tab1}}{{'<'}}div class="row">
	{{$tab3}}{{$tab1}}{{$tab1}}{{'<'}}div class="col-md-12">
	{{$tab3}}{{$tab1}}{{$tab1}}{{'<'}}!--Kopikan disini cuy-->
	{{$tab3}}{{$tab1}}{{$tab1}}{{'<'}}/div>			        
	{{$tab3}}{{$tab1}}{{'<'}}/div>				
	{{$tab3}}{{'<'}}/div>
	{{$tab2}}{{'<'}}/div>
	{{$tab1}}{{'<'}}/div>
	{{'<'}}/div>
	{{'@'}}endsection

	{{'@'}}section("modal")
		{{'<'}}!--Kopikan disini cuy-->
	{{'@'}}endsection


	{{'@'}}section('js')
	{{'<'}}script type="text/javascript">
		$(function(){
			//Kopikan disini cuy
		})
	{{'<'}}/script>
	{{'@'}}endsection
</code>
</pre>     
        </div>
      </div>
