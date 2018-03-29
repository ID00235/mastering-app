var ${{$id}} = $('#{{$id}}').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{$url}}',
        "iDisplayLength": {{$length}},
        columns: [
        @foreach($field as $f)
         {data:'{{$f['data']}}' @if($f['name']!=''), name:"{{$f['name']}}" @endif, orderable:{{$f['order']}}, searchable: {{$f['search']}},sClass:"{{$f['class']}}"},
        @endforeach
        ],
        @if($useRowClass==true)
        "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
            $(nRow).addClass( aData["rowClass"] );
            return nRow;
        },
        @endif
         "drawCallback": function( settings ) {
            //$('.act').tooltip();
        },
        @if($sort!='')
            "order": [[{{$sort}}, "asc" ]]
        @endif
    });