{{ Form::bsText('action','Route to Action','',true,'') }}
<?php
$list_elemen = array('none','textfield','textarea','radio','selected','readonly','hidden');
$array = [];
foreach ($list_elemen as $d){
	array_push($array, ['value'=>$d,'text'=>$d]);
}
$list_elemen = json_decode(json_encode($array));
?>
<hr>
@foreach($field as $k)
{{ Form::bsText('field[]','Kolom',$k->COLUMN_NAME,true,'') }}
{{ Form::bsSelect('jenis[]','Jenis Komponen',$list_elemen,true,'select2') }}
<hr>
@endforeach