<table class="table @if($model=='')table-striped @endif @if($model=='non-striped') @endif @if($model=='bordered') table-bordered @endif table-condensed table-hover" id="{{$id}}">
    <thead>
      <tr>
      	@foreach($field as $f)
        <th @if($f['width']!='')width="{{$f['width']}};"@endif><center>{{$f['name']}}</center></th>
        @endforeach
      </tr>
    </thead>
	<tbody></tbody>
</table>