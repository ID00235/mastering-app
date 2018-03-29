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
		        <h2>Menu Role : {{$role->nama_role}}</h2>
		        <div class="clearfix"></div>
		      </div>
		      <div class="x_content">
		        <p>
		        	{{Html::bsBtnLink('<i class="la la-arrow-left"></i> Back','btn-default',url("setting-role"))}}
		        	@if(ucc())
		        	{{Html::bsLinkModal('tambah-role','modal-form-tambah-rolemenu','<i class="la la-plus"></i> Menu Role','primary')}}
		        	@endif
		        </p>
		        <hr>
		        <div class="row">
			         <div class="col-md-12">
			         	<?php 
			         	$kolom = array(
			         				['name'=>'No.','width'=>'30px'],
			         				['name'=>'Group Menu','width'=>'20%'],
			         				['name'=>'Nama Menu','width'=>''],
			         				['name'=>'Create','width'=>'40px'],
			         				['name'=>'Update','width'=>'40px'],
			         				['name'=>'Delete','width'=>'40px'],
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

<?php 
$option_yes_no = json_decode(json_encode(array(["value"=>0, "text"=>"No"] , ["value"=>1, "text"=>"Yes"])));
?>
@section("modal")

@if(ucc())
{{Html::bsFormModalOpen('form-tambah-rolemenu','Tambah',"setting-role/menu/".$role->uuid."/insert")}}
	{{ Form::bsHidden('id_role') }}
	{{ Form::bsReadonly('nama_role','Role',$role->nama_role) }}
	{{ Form::bsSelect('id_menu','Menu',$list_menu,true,'select2') }}
	{{ Form::bsRadionInline('a_create','Allow Create',$option_yes_no,true) }}
	{{ Form::bsRadionInline('a_update','Allow Update',$option_yes_no,true) }}
	{{ Form::bsRadionInline('a_delete','Allow Delete',$option_yes_no,true) }}
{{Html::bsFormModalClose('<i class="la la-save"></i> Simpan','success')}}
@endif

@if(ucu())
{{Html::bsFormModalOpen('form-edit-rolemenu','Edit',"setting-role/menu/".$role->uuid."/update")}}
	{{ Form::bsHidden('uuid') }}
	{{ Form::bsReadonly('nama_role','Role',$role->nama_role) }}
	{{ Form::bsSelect('id_menu','Menu', $list_menu, true, 'select2') }}
	{{ Form::bsRadionInline('a_create','Allow Create',$option_yes_no,true) }}
	{{ Form::bsRadionInline('a_update','Allow Update',$option_yes_no,true) }}
	{{ Form::bsRadionInline('a_delete','Allow Delete',$option_yes_no,true) }}
{{Html::bsFormModalClose('<i class="la la-save"></i> Simpan','success')}}
@endif

@if(ucd())
{{Html::bsFormModalOpen('form-hapus-rolemenu','Anda Yakin Ingin Menghapus Data Berikut?',"setting-role/menu/".$role->uuid."/delete")}}
	{{ Form::bsHidden('uuid') }}
	{{ Form::bsReadonly('nama_menu','Nama Menu') }}
{{Html::bsFormModalClose('<i class="la la-trash"></i> Hapus','warning')}}
@endif

@endsection


@section('js')
<script type="text/javascript">
$(function(){
//START JAVASCRIPT

$validator_tambah = $("#form-tambah-rolemenu").validate();
$validator_edit = $("#form-edit-rolemenu").validate();


<?php 
$field = array(
		['name'=>'','data'=>'DT_Row_Index','order'=>'false', 'search'=>'false','class'=>'text-center'],
		['name'=>'c.nama_menu','data'=>'group_menu','order'=>'true', 'search'=>'true','class'=>''],
		['name'=>'b.nama_menu','data'=>'nama_menu','order'=>'true', 'search'=>'true','class'=>''],
		['name'=>'','data'=>'a_create','order'=>'false', 'search'=>'false','class'=>'text-center'],
		['name'=>'','data'=>'a_update','order'=>'false', 'search'=>'false','class'=>'text-center'],
		['name'=>'','data'=>'a_delete','order'=>'false', 'search'=>'false','class'=>'text-center'],
		['name'=>'','data'=>'action','order'=>'false', 'search'=>'false','class'=>'text-center'],
	);
?>
{{Html::jsDatatable('tabel1',$field,url('setting-role/menu/'.$role->uuid.'/data'),25)}}

{{Html::jsModalShow('modal-form-tambah-rolemenu')}}
	$validator_tambah.resetForm();
	$("#form-tambah-rolemenu").clearForm();
	{{Html::jsClearForm('form-tambah-rolemenu','select','id_menu')}}

	$data= {'id_role':"{{Crypt::encrypt($role->id_role)}}", 'nama_role':"{{$role->nama_role}}"}
	{{Html::jsValueForm('form-tambah-rolemenu','input','nama_role')}}
	{{Html::jsValueForm('form-tambah-rolemenu','hidden','id_role')}}

{{Html::jsClose()}}


{{Html::jsModalShow('modal-form-edit-rolemenu')}}
	$validator_edit.resetForm();
	$("#form-edit-role").clearForm();
	$uuid  = $(e.relatedTarget).data('uuid');
	$data= {'nama_role':"{{$role->nama_role}}"}
	{{Html::jsValueForm('form-tambah-rolemenu','input','nama_role')}}

	$.get("{{url('setting-role/menu/'.$role->uuid.'/get')}}/"+$uuid, function($data){
		{{Html::jsValueForm('form-edit-rolemenu','select','id_menu')}}
		{{Html::jsValueForm('form-edit-rolemenu','radio','a_create')}}
		{{Html::jsValueForm('form-edit-rolemenu','radio','a_update')}}
		{{Html::jsValueForm('form-edit-rolemenu','radio','a_delete')}}
		{{Html::jsValueForm('form-edit-rolemenu','input','uuid')}}
	});
{{Html::jsClose()}}

{{Html::jsModalShow('modal-form-hapus-rolemenu')}}
	$("#form-hapus-role").clearForm();
	$uuid  = $(e.relatedTarget).data('uuid');
	$.get("{{url('setting-role/menu/'.$role->uuid.'/get')}}/"+$uuid, function($data){
		{{Html::jsValueForm('form-hapus-rolemenu','input','nama_menu')}}
		{{Html::jsValueForm('form-hapus-rolemenu','input','uuid')}}
	});
{{Html::jsClose()}}

var callback_submit_tambah = function(){$tabel1.ajax.reload(null, true);}
{{Html::jsSubmitFormModal('form-tambah-rolemenu','callback_submit_tambah')}}

var callback_submit_update = function(){$tabel1.ajax.reload(null, false);}
{{Html::jsSubmitFormModal('form-edit-rolemenu','callback_submit_update')}}

var callback_submit_delete = function(){$tabel1.ajax.reload(null, false);}
{{Html::jsSubmitFormModal('form-hapus-rolemenu','callback_submit_delete')}}


//END JAVASCRIPT
})
</script>
@endsection