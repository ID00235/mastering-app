@extends('layout')
@section('content')
<?php
loadHelper('akses,url');
$url_submit_code_form_create = base_route('gen-form-create');
$url_submit_code_form_update= base_route('gen-form-update');
$url_submit_code_form_delete= base_route('gen-form-delete');
$url_submit_code_route = base_route('gen-route');

?>
<hr>
<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12 pd-20">
	    <div class="x_panel">
		      <div class="x_title">
		      	<div class="pull-right"><span class="loading-panel"></span></div>
		        <h2>Code Generator</h2>
		        <div class="clearfix"></div>
		      </div>
		      <div class="x_content">
		        <div class="" role="tabpanel" data-example-id="togglable-tabs">
                      <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Route</a>
                        </li>
                        <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">Form Create</a>
                        </li>
                        <li role="presentation" class=""><a href="#tab_content3" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false">Form Update</a>
                        </li>
                        <li role="presentation" class=""><a href="#tab_content4" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false">Form Delete</a>
                        </li>
                      </ul>
                      <div id="myTabContent" class="tab-content">
                        <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
                          {{Form::bsOpen('form-gen-route', $url_submit_code_route)}}
                          	 {{ Form::bsSelect('table','Tabel Master',$list_table,true,'select2') }}
                         	 {{ Form::bsText('prefix','Path Prefix','',true,'') }}
                         	 {{ Form::bsText('crud_controller','Crud Controller','',true,'') }}
                         	 {{ Form::bsText('datatable_controller','Datatable Controller','',true,'') }}
                          {{Form::bsSubmitCloseForm('Generate','success')}}
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">
                          {{Form::bsOpen('form-code-form-create', $url_submit_code_form_create)}}
                         	 {{ Form::bsSelect('table','Tabel',$list_table,true,'select2') }}
                         	 <div class="form-group" id="form-columns-create">

                         	 </div>
                          {{Form::bsSubmitCloseForm('Generate','success')}}
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="profile-tab">
                          {{Form::bsOpen('form-code-form-update', $url_submit_code_form_update)}}
                           {{ Form::bsSelect('table','Tabel',$list_table,true,'select2') }}
                           <div class="form-group" id="form-columns-update">

                           </div>
                          {{Form::bsSubmitCloseForm('Generate','success')}}
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="tab_content4" aria-labelledby="profile-tab">
                          {{Form::bsOpen('form-code-form-delete', $url_submit_code_form_delete)}}
                           {{ Form::bsSelect('table','Tabel',$list_table,true,'select2') }}
                           <div class="form-group" id="form-columns-delete">

                           </div>
                          {{Form::bsSubmitCloseForm('Generate','success')}}
                        </div>
                        
                      </div>
                    </div>				
		      </div>
	    </div>
	  </div>
</div>
@endsection

@section("modal")
<!-- Modal -->
<div id="modal-result" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Modal Result Code</h4>
      </div>
      <div class="modal-body" id="content-result">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
@endsection


@section('js')
<script type="text/javascript">
	$(function(){
		$validator_tambah = $("#form-gen-route").validate();
		$('#form-gen-route').ajaxForm({
				beforeSubmit:function(){startLoading()},
				success:function($respon){
					stopLoading();
					$("#content-result").html($respon);
					$("#modal-result").modal('show');
				},
				error:function(){
					showAlert('Gagal','Terjadi Kesalahan Sistem!');
				}
		});

		$("#form-code-form-create select[name=table]").on('change', function(){
			$value = $(this).val();
			$.get("{{url('code-gen/form-columns')}}" +'/' + $value, function($respon){
         $("#form-columns-create").html($respon);
      });
		})

    $validator_form_create_tambah = $("#form-code-form-create").validate();
    $('#form-code-form-create').ajaxForm({
        beforeSubmit:function(){startLoading()},
        success:function($respon){
          stopLoading();
          $("#content-result").html($respon);
          $("#modal-result").modal('show');
        },
        error:function(){
          showAlert('Gagal','Terjadi Kesalahan Sistem!');
        }
    });

    $("#form-code-form-update select[name=table]").on('change', function(){
      $value = $(this).val();
      $.get("{{url('code-gen/form-columns')}}" +'/' + $value, function($respon){
         $("#form-columns-update").html($respon);
      });
    })

    $validator_form_create_update = $("#form-code-form-update").validate();
    $('#form-code-form-update').ajaxForm({
        beforeSubmit:function(){startLoading()},
        success:function($respon){
          stopLoading();
          $("#content-result").html($respon);
          $("#modal-result").modal('show');
        },
        error:function(){
          showAlert('Gagal','Terjadi Kesalahan Sistem!');
        }
    });

    $("#form-code-form-delete select[name=table]").on('change', function(){
      $value = $(this).val();
      $.get("{{url('code-gen/form-columns')}}" +'/' + $value, function($respon){
         $("#form-columns-delete").html($respon);
      });
    })

    $validator_form_create_delete= $("#form-code-form-delete").validate();
    $('#form-code-form-delete').ajaxForm({
        beforeSubmit:function(){startLoading()},
        success:function($respon){
          stopLoading();
          $("#content-result").html($respon);
          $("#modal-result").modal('show');
        },
        error:function(){
          showAlert('Gagal','Terjadi Kesalahan Sistem!');
        }
    });
    
	})
</script>
@endsection