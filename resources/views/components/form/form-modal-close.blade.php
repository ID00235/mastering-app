	  </div>
	  </div>
      <div class="modal-footer">
      	@if($submit_title!='')
      	<button type="submit" class="btn @if($submit_class=='') btn-success @else btn-{{$submit_class}} @endif btn-sm">{!!$submit_title!!}</button>
      	@endif
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
</form>