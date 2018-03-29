@if($tag=='input') $("#{{$id}} input[name={{$name}}]").val($data.{{$name}}); @endif
@if($tag=='select') $("#{{$id}} select[name={{$name}}]").val($data.{{$name}}); $("#{{$id}} select[name={{$name}}]").trigger('change');@endif
@if($tag=='hidden') $("#{{$id}} input[name={{$name}}]").val($data.{{$name}}); @endif
@if($tag=='radio') $("#{{$id}} input[name={{$name}}][value=" + $data.{{$name}} +"]").prop('checked',true); @endif