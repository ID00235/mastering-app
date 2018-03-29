<?php
loadHelper('akses');
?>
@extends('layout')
@section('content')
<hr>
<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12 pd-20">
	    <div class="x_panel">
		      <div class="x_title">
		      	<div class="pull-right"><span class="loading-panel"></span></div>
		        <h2>Pengaturan Role</h2>
		        <div class="clearfix"></div>
		      </div>
		      <div class="x_content">
		        <p>
		        	@if(ucc())
		        	{{Html::bsLinkModal('tambah-role','modal-form-tambah-role','<i class="la la-plus"></i> Role Baru','primary')}}
		        	@endif
		        </p>
		        <hr>
		        <div class="row">
			         <div class="col-md-12">
			         	<?php 
			         	$kolom = array(
			         				['name'=>'No.','width'=>'30px'],
			         				['name'=>'Nama Role','width'=>''],
			         				['name'=>'Menu','width'=>''],
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
{{Html::bsFormModalOpen('form-tambah-role','Tambah','setting-role/insert')}}
	{{ Form::bsText('nama_role','Nama Role','',true,'') }}
{{Html::bsFormModalClose('<i class="la la-save"></i> Simpan','success')}}
@endif

@if(ucu())
{{Html::bsFormModalOpen('form-edit-role','Edit','setting-role/update')}}
	{{ Form::bsHidden('uuid') }}
	{{ Form::bsText('nama_role','Nama Role','',true,'') }}
{{Html::bsFormModalClose('<i class="la la-save"></i> Simpan','success')}}
@endif

@if(ucd())
{{Html::bsFormModalOpen('form-hapus-role','Anda Yakin Ingin Menghapus Data Berikut?','setting-role/delete')}}
	{{ Form::bsHidden('uuid') }}
	{{ Form::bsReadonly('nama_role','Nama Role') }}
{{Html::bsFormModalClose('<i class="la la-trash"></i> Hapus','warning')}}
@endif

@endsection


@section('js')
<script type="text/javascript">
$(function(){
//START JAVASCRIPT

$validator_tambah = $("#form-tambah-role").validate();
$validator_edit = $("#form-edit-role").validate();


<?php 
$field = array(
		['name'=>'a.id_role','data'=>'id_role','order'=>'true', 'search'=>'true','class'=>'text-center'],
		['name'=>'a.nama_role','data'=>'nama_role','order'=>'true', 'search'=>'true','class'=>''],
		['name'=>'','data'=>'menu','order'=>'false', 'search'=>'false','class'=>'text-center'],
		['name'=>'','data'=>'action','order'=>'false', 'search'=>'false','class'=>'text-center'],
	);
?>
{{Html::jsDatatable('tabel1',$field,url('setting-role/data'),25)}}

{{Html::jsModalShow('modal-form-tambah-role')}}
	$validator_tambah.resetForm();
	$("#form-tambah-role").clearForm();
{{Html::jsClose()}}


{{Html::jsModalShow('modal-form-edit-role')}}
	$validator_edit.resetForm();
	$("#form-edit-role").clearForm();
	$uuid  = $(e.relatedTarget).data('uuid');
	$.get("{{url('setting-role/get')}}/"+$uuid, function($data){
		{{Html::jsValueForm('form-edit-role','input','nama_role')}}
		{{Html::jsValueForm('form-edit-role','input','uuid')}}
	});
{{Html::jsClose()}}

{{Html::jsModalShow('modal-form-hapus-role')}}
	$("#form-hapus-role").clearForm();
	$uuid  = $(e.relatedTarget).data('uuid');
	$.get("{{url('setting-role/get')}}/"+$uuid, function($data){
		{{Html::jsValueForm('form-hapus-role','input','nama_role')}}
		{{Html::jsValueForm('form-hapus-role','input','uuid')}}
	});
{{Html::jsClose()}}

var callback_submit_tambah = function(){$tabel1.ajax.reload(null, true);}
{{Html::jsSubmitFormModal('form-tambah-role','callback_submit_tambah')}}

var callback_submit_update = function(){$tabel1.ajax.reload(null, false);}
{{Html::jsSubmitFormModal('form-edit-role','callback_submit_update')}}

var callback_submit_delete = function(){$tabel1.ajax.reload(null, false);}
{{Html::jsSubmitFormModal('form-hapus-role','callback_submit_delete')}}


//END JAVASCRIPT
})
</script>
@endsection