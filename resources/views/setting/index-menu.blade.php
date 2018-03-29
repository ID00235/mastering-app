@extends('layout')
@section('content')
<?php
loadHelper('akses');
$list_menu_induk = DB::table('menu')->select('id_menu as value','nama_menu as text')->where('id_menu_induk',0)->get();
?>
<hr>
<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12 pd-20">
	    <div class="x_panel">
		      <div class="x_title">
		      	<div class="pull-right"><span class="loading-panel"></span></div>
		        <h2>Pengaturan Menu</h2>
		        <div class="clearfix"></div>
		      </div>
		      <div class="x_content">
		        <p>
		        	@if(ucc())
		        	{{Html::bsLinkModal('tambah-menu','modal-form-tambah-menu','<i class="la la-plus"></i> Menu Baru','primary')}}
		        	@endif
		        </p>
		        <hr>
		        <div class="row">
			         <div class="col-md-12">
			         	<?php 
			         	$kolom = array(
			         				['name'=>'No.','width'=>'30px'],
			         				['name'=>'Group Menu','width'=>''],
			         				['name'=>'Nama Menu','width'=>''],
			         				['name'=>'Urutan','width'=>''],
			         				['name'=>'URL','width'=>''],
			         				['name'=>'Action','width'=>'50px'],
			         			);
			         	?>
		         		{{Html::bsDatatable('tabel1',$kolom)}}
			         </div>
			        
		        </div>				
		      </div>
	    </div>
	  </div>
</div>
@endsection

@section("modal")
@if(ucc())
{{Html::bsFormModalOpen('form-tambah-menu','Tambah','setting-menu/insert')}}
	{{ Form::bsSelect('id_menu_induk','Group Menu',$list_menu_induk,true,'select2') }}
	{{ Form::bsText('urutan','Nomor Urutan','',true,'') }}
	{{ Form::bsText('nama_menu','Nama Menu','',true,'') }}
	{{ Form::bsText('url','URL Menu','',true,'') }}
{{Html::bsFormModalClose('<i class="la la-save"></i> Simpan','success')}}
@endif

@if(ucu())
{{Html::bsFormModalOpen('form-edit-menu','Edit','setting-menu/update')}}
	{{ Form::bsHidden('uuid') }}
	{{ Form::bsSelect('id_menu_induk','Group Menu',$list_menu_induk,true,'select2') }}
	{{ Form::bsText('urutan','Nomor Urut','',true,'') }}
	{{ Form::bsText('nama_menu','Nama Menu','',true,'') }}
	{{ Form::bsText('url','URL Menu','',true,'') }}
{{Html::bsFormModalClose('<i class="la la-save"></i> Simpan','success')}}
@endif

@if(ucd())
{{Html::bsFormModalOpen('form-hapus-menu','Anda Yakin Ingin Menghapus Data Berikut?','setting-menu/delete')}}
	{{ Form::bsHidden('uuid') }}
	{{ Form::bsReadonly('nama_menu','Nama Menu') }}
{{Html::bsFormModalClose('<i class="la la-trash"></i> Hapus','warning')}}
@endif

@endsection


@section('js')
<script type="text/javascript">
$(function(){
//START JAVASCRIPT

$validator_tambah = $("#form-tambah-menu").validate();
$validator_edit = $("#form-edit-menu").validate();


<?php 
$field = array(
		['name'=>'','data'=>'DT_Row_Index','order'=>'false', 'search'=>'false','class'=>'text-center'],
		['name'=>'b.nama_menu','data'=>'group_menu','order'=>'true', 'search'=>'true','class'=>''],
		['name'=>'a.nama_menu','data'=>'nama_menu','order'=>'true', 'search'=>'true','class'=>''],
		['name'=>'a.urutan','data'=>'urutan','order'=>'false', 'search'=>'false','class'=>'text-center'],
		['name'=>'a.url','data'=>'url','order'=>'true', 'search'=>'true','class'=>''],
		['name'=>'','data'=>'action','order'=>'false', 'search'=>'false','class'=>'text-center'],
	);
?>
{{Html::jsDatatable('tabel1',$field,url('setting-menu/data'),25)}}

{{Html::jsModalShow('modal-form-tambah-menu')}}
	$validator_tambah.resetForm();
	$("#form-tambah-menu").clearForm();
	{{Html::jsClearForm('form-tambah-menu','select','id_menu_induk')}}
{{Html::jsClose()}}


{{Html::jsModalShow('modal-form-edit-menu')}}
	$validator_edit.resetForm();
	$("#form-edit-menu").clearForm();
	{{Html::jsClearForm('form-edit-menu','select','id_menu_induk')}}
	$uuid  = $(e.relatedTarget).data('uuid');
	$.get("{{url('setting-menu/get')}}/"+$uuid, function($data){
		{{Html::jsValueForm('form-edit-menu','input','urutan')}}
		{{Html::jsValueForm('form-edit-menu','input','nama_menu')}}
		{{Html::jsValueForm('form-edit-menu','input','url')}}
		{{Html::jsValueForm('form-edit-menu','select','id_menu_induk')}}
		{{Html::jsValueForm('form-edit-menu','input','uuid')}}
	});
{{Html::jsClose()}}

{{Html::jsModalShow('modal-form-hapus-menu')}}
	$("#form-hapus-menu").clearForm();
	$uuid  = $(e.relatedTarget).data('uuid');
	$.get("{{url('setting-menu/get')}}/"+$uuid, function($data){
		{{Html::jsValueForm('form-hapus-menu','input','nama_menu')}}
		{{Html::jsValueForm('form-hapus-menu','input','uuid')}}
	});
{{Html::jsClose()}}

var callback_submit_tambah = function(){$tabel1.ajax.reload(null, true);}
{{Html::jsSubmitFormModal('form-tambah-menu','callback_submit_tambah')}}

var callback_submit_update = function(){$tabel1.ajax.reload(null, false);}
{{Html::jsSubmitFormModal('form-edit-menu','callback_submit_update')}}

var callback_submit_delete = function(){$tabel1.ajax.reload(null, false);}
{{Html::jsSubmitFormModal('form-hapus-menu','callback_submit_delete')}}


//END JAVASCRIPT
})
</script>
@endsection