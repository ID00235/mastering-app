@extends('layout')
@section('content')
<?php
loadHelper('akses');
?>
<hr>
<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12 pd-20">
	    <div class="x_panel">
		      <div class="x_title">
		      	<div class="pull-right"><span class="loading-panel"></span></div>
		        <h2>Manajemen Role User {Username: {{$user->username}}}</h2>
		        <div class="clearfix"></div>
		      </div>
		      <div class="x_content">
		        <p>
		        	{{Html::bsBtnLink('<i class="la la-arrow-left"></i> Back','btn-default',url("setting-user"))}}
		        	@if(ucc())
		        	{{Html::bsLinkModal('tambah-user-role','modal-form-tambah-user-role','<i class="la la-plus"></i> Role User','primary')}}
		        	@endif
		        </p>
		        <hr>
		        <div class="row">
			         <div class="col-md-12">
			         	<?php 
			         	$kolom = array(
				         				['name'=>'No.','width'=>'30px'],
				         				['name'=>'Role Name','width'=>'20%'],
				         				['name'=>'Role Instansi','width'=>''],
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
	{{Html::bsFormModalOpen('form-tambah-user-role','Tambah Role User','setting-user/role/insert')}}
		{{ Form::bsHidden('id_user') }}
		{{ Form::bsSelect('id_role','Role',$list_role,true,'select2') }}
	{{Html::bsFormModalClose('<i class="la la-save"></i> Simpan','success')}}
	@endif

	@if(ucd())
	{{Html::bsFormModalOpen('form-hapus-user-role','Hapus Role User?','setting-user/role/delete')}}
		{{ Form::bsHidden('uuid') }}
		{{ Form::bsReadonly('nama_role','Role','') }}
	{{Html::bsFormModalClose('<i class="la la-trash"></i> Hapus','warning')}}
	@endif
@endsection


@section('js')
<script type="text/javascript">
$(function(){
//START JAVASCRIPT
<?php 
$field = array(
		['name'=>'','data'=>'DT_Row_Index','order'=>'false', 'search'=>'false','class'=>'text-center'],
		['name'=>'b.nama_role','data'=>'nama_role','order'=>'true', 'search'=>'true','class'=>''],
		['name'=>'','data'=>'instansi','order'=>'false', 'search'=>'false','class'=>'text-center'],
		['name'=>'','data'=>'action','order'=>'false', 'search'=>'false','class'=>'text-center'],
	);
?>
{{Html::jsDatatable('tabel1',$field,url('setting-user/role/data/'.$user->uuid),25)}}


$validator_tambah = $("#form-tambah-user-role").validate();

{{Html::jsModalShow('modal-form-tambah-user-role')}}
	$validator_tambah.resetForm();
	$("#form-tambah-user-role").clearForm();
	$data= {'id_user':"{{Crypt::encrypt($user->id)}}"}
	{{Html::jsValueForm('form-tambah-user-role','hidden','id_user')}}
	{{Html::jsClearForm('form-tambah-user-role','select','id_role')}}
{{Html::jsClose()}}

var callback_submit_tambah = function(){$tabel1.ajax.reload(null, true);}
{{Html::jsSubmitFormModal('form-tambah-user-role','callback_submit_tambah')}}

{{Html::jsModalShow('modal-form-hapus-user-role')}}
	$("#form-hapus-role").clearForm();
	$uuid  = $(e.relatedTarget).data('uuid');
	$.get("{{url('setting-user/role/get/')}}/"+$uuid, function($data){
		{{Html::jsValueForm('form-hapus-user-role','input','nama_role')}}
		{{Html::jsValueForm('form-hapus-user-role','input','uuid')}}
	});
{{Html::jsClose()}}

var callback_submit_hapus = function(){$tabel1.ajax.reload(null, true);}
{{Html::jsSubmitFormModal('form-hapus-user-role','callback_submit_hapus')}}


//END JAVASCRIPT
})
</script>
@endsection