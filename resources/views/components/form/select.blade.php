<div class="form-group">
	<label class="control-label col-md-3 col-sm-3 col-xs-12">{{$label}} @if($required==true)<span class="required">*</span>@endif
	</label>
	<div class="col-md-8 col-sm-8 col-xs-12">
	  <select class="form-control col-md-10 col-xs-12 {{$class}}" name="{{$fieldname}}" id="{{$fieldname}}" @if($required==true) required="required" @endif>
	  		<option value="">[Pilihan]</option>
	  	@if($data)
	  	@foreach($data as $d)
	  		<option value="{{$d->value}}">{{$d->text}}</option>
	  	@endforeach
	  	@endif
	  </select>
	</div>
</div>