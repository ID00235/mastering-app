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
		        <h2>Manajemen User</h2>
		        <div class="clearfix"></div>
		      </div>
		      <div class="x_content">
		        <p>
		        	@if(ucc())
		        	{{Html::bsLinkModal('tambah-user','modal-form-tambah-user','<i class="la la-plus"></i> User Baru','primary')}}
		        	@endif
		        </p>
		        <hr>
		        <div class="row">
			         <div class="col-md-12">
			         	<?php 
			         	$kolom = array(
			         				['name'=>'No.','width'=>'30px'],
			         				['name'=>'Username','width'=>''],
			         				['name'=>'Nama Pengguna','width'=>''],
			         				['name'=>'Email','width'=>''],
			         				['name'=>'Telp.','width'=>''],
			         				['name'=>'Role.','width'=>''],
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
{{Html::bsFormModalOpen('form-tambah-user','Tambah','setting-user/insert')}}
	{{ Form::bsText('username','Username','',true,'') }}
	{{ Form::bsText('nama_pengguna','Nama Pengguna','',true,'') }}
	{{ Form::bsEmail('email','Email Pengguna','',true,'') }}
	{{ Form::bsText('telp','Nomor Telp.','',true,'') }}
	{{ Form::bsPassword('password1','Password','',true,'') }}
	{{ Form::bsPassword('password2','Konfirmasi Password','',true,'') }}
{{Html::bsFormModalClose('<i class="la la-save"></i> Simpan','success')}}
@endif

@if(ucu())
{{Html::bsFormModalOpen('form-edit-user','Edit','setting-user/update')}}
	{{ Form::bsHidden('uuid') }}
	{{ Form::bsReadonly('username','Username') }}
	{{ Form::bsText('nama_pengguna','Nama Pengguna','',true,'') }}
	{{ Form::bsEmail('email','Email Pengguna','',true,'') }}
	{{ Form::bsText('telp','Nomor Telp.','',true,'') }}
{{Html::bsFormModalClose('<i class="la la-save"></i> Simpan','success')}}
@endif

@if(ucu())
{{Html::bsFormModalOpen('form-edit-password','Ubah Password','setting-user/update-password')}}
	{{ Form::bsHidden('uuid') }}
	{{ Form::bsReadonly('username','Username') }}
	{{ Form::bsPassword('password1','Password','',true,'') }}
	{{ Form::bsPassword('password2','Konfirmasi Password','',true,'') }}
{{Html::bsFormModalClose('<i class="la la-save"></i> Ubah Password','success')}}
@endif

@if(ucd())
{{Html::bsFormModalOpen('form-hapus-user','Anda Yakin Ingin Menghapus Data Berikut?','setting-user/delete')}}
	{{ Form::bsHidden('uuid') }}
	{{ Form::bsReadonly('username','Username') }}
{{Html::bsFormModalClose('<i class="la la-trash"></i> Hapus','warning')}}
@endif

@endsection


@section('js')
<script type="text/javascript">
$(function(){
//START JAVASCRIPT

$validator_tambah = $("#form-tambah-user").validate();
$validator_edit = $("#form-edit-user").validate();
$validator_password = $("#form-edit-password").validate();


<?php 
$field = array(
		['name'=>'','data'=>'DT_Row_Index','order'=>'false', 'search'=>'false','class'=>'text-center'],
		['name'=>'a.username','data'=>'username','order'=>'true', 'search'=>'true','class'=>''],
		['name'=>'a.nama_pengguna','data'=>'nama_pengguna','order'=>'true', 'search'=>'true','class'=>''],
		['name'=>'a.email','data'=>'email','order'=>'true', 'search'=>'true','class'=>''],
		['name'=>'a.telp','data'=>'telp','order'=>'true', 'search'=>'true','class'=>''],
		['name'=>'','data'=>'role','order'=>'false', 'search'=>'false','class'=>'text-center'],
		['name'=>'','data'=>'action','order'=>'false', 'search'=>'false','class'=>'text-center'],
	);
?>
{{Html::jsDatatable('tabel1',$field,url('setting-user/data'),25)}}

{{Html::jsModalShow('modal-form-tambah-user')}}
	$validator_tambah.resetForm();
	$("#form-tambah-user").clearForm();
{{Html::jsClose()}}


{{Html::jsModalShow('modal-form-edit-user')}}
	$validator_edit.resetForm();
	$("#form-edit-user").clearForm();
	$uuid  = $(e.relatedTarget).data('uuid');
	$.get("{{url('setting-user/get')}}/"+$uuid, function($data){
		{{Html::jsValueForm('form-edit-user','input','username')}}
		{{Html::jsValueForm('form-edit-user','input','nama_pengguna')}}
		{{Html::jsValueForm('form-edit-user','input','email')}}
		{{Html::jsValueForm('form-edit-user','input','telp')}}
		{{Html::jsValueForm('form-edit-user','input','uuid')}}
	});
{{Html::jsClose()}}

{{Html::jsModalShow('modal-form-edit-password')}}
	$validator_edit.resetForm();
	$("#form-edit-password").clearForm();
	$uuid  = $(e.relatedTarget).data('uuid');
	$.get("{{url('setting-user/get')}}/"+$uuid, function($data){
		{{Html::jsValueForm('form-edit-password','input','username')}}
		{{Html::jsValueForm('form-edit-password','input','uuid')}}
	});
{{Html::jsClose()}}

{{Html::jsModalShow('modal-form-hapus-user')}}
	$("#form-hapus-user").clearForm();
	$uuid  = $(e.relatedTarget).data('uuid');
	$.get("{{url('setting-user/get')}}/"+$uuid, function($data){
		{{Html::jsValueForm('form-hapus-user','input','username')}}
		{{Html::jsValueForm('form-hapus-user','input','uuid')}}
	});
{{Html::jsClose()}}

var callback_submit_tambah = function(){$tabel1.ajax.reload(null, true);}
{{Html::jsSubmitFormModal('form-tambah-user','callback_submit_tambah')}}

var callback_submit_update = function(){$tabel1.ajax.reload(null, false);}
{{Html::jsSubmitFormModal('form-edit-user','callback_submit_update')}}

var callback_submit_delete = function(){$tabel1.ajax.reload(null, false);}
{{Html::jsSubmitFormModal('form-hapus-user','callback_submit_delete')}}

var callback_submit_password = function(){$tabel1.ajax.reload(null, false);}
{{Html::jsSubmitFormModal('form-edit-password','callback_submit_password')}}

//END JAVASCRIPT
})
</script>
@endsection