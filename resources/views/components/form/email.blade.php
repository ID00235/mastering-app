<div class="form-group">
	<label class="control-label col-md-3 col-sm-3 col-xs-12">{{$label}} @if($required==true)<span class="required">*</span>@endif
	</label>
	<div class="col-md-8 col-sm-8 col-xs-12">
	  <input class="form-control col-md-9 col-xs-12 {{$class}}" id="{{$fieldname}}" name="{{$fieldname}}" 
	  @if($required==true) required="required" @endif value="{{$value}}" 
	  type="email">
	</div>
</div>