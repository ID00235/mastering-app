<?php
$tab1 = "&nbsp;&nbsp;&nbsp;&nbsp;";
$tab2 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
$tab3 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
$tab4 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
$tab5 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
?>
<?php 
$n= 0;
$model = array();
//array('none','textfield','textarea','radio','selected','readonly','hidden');
foreach ($field as $f) {
	if ($jenis[$n]=='textfield'){
		array_push($model,["name"=>$f ,"jenis"=>'textfield']);
	}
	if ($jenis[$n]=='textarea'){
		array_push($model,["name"=>$f ,"jenis"=>'textarea']);
	}
	if ($jenis[$n]=='radio'){
		array_push($model,["name"=>$f ,"jenis"=>'radio']);
	}
	if ($jenis[$n]=='selected'){
		array_push($model,["name"=>$f ,"jenis"=>'selected']);
	}
	if ($jenis[$n]=='readonly'){
		array_push($model,["name"=>$f ,"jenis"=>'readonly']);
	}
	if ($jenis[$n]=='hidden'){
		array_push($model,["name"=>$f ,"jenis"=>'hidden']);
	}
	$n++;
}
?>
 <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
        <li role="presentation" class="active"><a href="#tab_gen_form_create1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">{{'@'}}section('modal')</a>
        </li>
        <li role="presentation" class=""><a href="#tab_gen_form_create2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">{{'@'}}section('js')</a>
        </li>
      </ul>
      <div id="myTabContent" class="tab-content">
        <div role="tabpanel" class="tab-pane" id="tab_gen_form_create1" aria-labelledby="home-tab">
<pre>
<code>
	{{"@"}}if(ucu())
	{{"{"}}{{"{"}}Html::bsFormModalOpen('form-edit-{{$table}}','Edit Data','{{$action}}') {{"}"}}{{"}"}}
<?php foreach($model as $m) {$name = $m['name']; $element = $m['jenis']; ?>
@if($element=='textfield')
	{{$tab1}}{{"{"}}{{"{"}} Form::bsText('{{$name}}','{{$name}}','',true,'') {{"}"}}{{"}"}}
@endif
@if($element=='textarea')
	{{$tab1}}{{"{"}}{{"{"}} Form::bsTextarea('{{$name}}','{{$name}}','',true,'') {{"}"}}{{"}"}}
@endif
@if($element=='selected')
	{{$tab1}}{{"{"}}{{"{"}} Form::bsSelect('{{$name}}','{{$name}}',$list_{{$name}},true,'select2') {{"}"}}{{"}"}}
@endif
@if($element=='radio')
	{{$tab1}}{{"{"}}{{"{"}} Form::bsRadionInline('{{$name}}','{{$name}}',$option_{{$name}},true) {{"}"}}{{"}"}}
@endif
@if($element=='hidden')
	{{$tab1}}{{"{"}}{{"{"}} Form::bsHidden('{{$name}}') {{"}"}}{{"}"}}
@endif
@if($element=='readonly')
	{{$tab1}}{{"{"}}{{"{"}} Form::bsReadonly('{{$name}}','{{$name}}') {{"}"}}{{"}"}}
@endif
<?php } ?>
	{{$tab1}}{{"{{"}}Html::bsFormModalClose('Simpan','success') {{"}"}}{{"}"}}
	{{"@"}}endif
</code>
</pre>
        </div>
        <div role="tabpanel" class="tab-pane fade" id="tab_gen_form_create2" aria-labelledby="profile-tab">
<pre>
<code>
	 $validator_edit_{{$table}} = $("#form-edit-{{$table}}").validate();
	 {{"{"}}{{"{"}}Html::jsModalShow('modal-form-edit-{{$table}}') {{"}"}}{{"}"}}
		$validator_edit_{{$table}}.resetForm();
		$("#form-edit-{{$table}}").clearForm();
<?php foreach($model as $m) {$name = $m['name']; $element = $m['jenis']; ?>
@if($element=='selected')
		{{"{"}}{{"{"}}Html::jsClearForm('form-edit-{{$table}}','select','{{$name}}') {{"}"}}{{"}"}}
@endif
<?php } ?>
	{{$tab1}}$uuid  = $(e.relatedTarget).data('uuid');
	{{$tab1}}$.get("{{"{"}}{{"{"}}url($base_route.'/get'){{"}"}}{{"}"}}/"+$uuid, function($data){
<?php foreach($model as $m) {$name = $m['name']; $element = $m['jenis']; ?>
@if($element=='textfield')
	{{$tab1}}{{"{"}}{{"{"}} Html::jsValueForm('form-edit-{{$table}}','input','{{$name}}') {{"}"}}{{"}"}}
@endif
@if($element=='textarea')
	{{$tab1}}{{"{"}}{{"{"}} Html::jsValueForm('form-edit-{{$table}}','textarea','{{$name}}')  {{"}"}}{{"}"}}
@endif
@if($element=='selected')
	{{$tab1}}{{"{"}}{{"{"}}  Html::jsValueForm('form-edit-{{$table}}','select','{{$name}}') {{"}"}}{{"}"}}
@endif
@if($element=='radio')
	{{$tab1}}{{"{"}}{{"{"}}  Html::jsValueForm('form-edit-{{$table}}','radio','{{$name}}') {{"}"}}{{"}"}}
@endif
@if($element=='hidden')
	{{$tab1}}{{"{"}}{{"{"}} Html::jsValueForm('form-edit-{{$table}}','input','{{$name}}') {{"}"}}{{"}"}}
@endif
@if($element=='readonly')
	{{$tab1}}{{"{"}}{{"{"}} Html::jsValueForm('form-edit-{{$table}}','input','{{$name}}') {{"}"}}{{"}"}}
@endif
<?php } ?>
	})
	{{"{"}}{{"{"}}Html::jsClose() {{"}"}}{{"}"}}
	<br>
	var callback_submit_edit_{{$table}} = function(){$tabel1.ajax.reload(null, false);}
	{{"{"}}{{"{"}} Html::jsSubmitFormModal('form-edit-{{$table}}','callback_submit_edit_{{$table}}') {{"}"}}{{"}"}}
</code>
</pre>
        </div>
        
      </div>
	