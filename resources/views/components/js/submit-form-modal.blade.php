$('#{{$id}}').ajaxForm({
	beforeSubmit:function(){$("#modal-{{$id}}").modal('hide'); startLoading()},
	success:function($respon){
		stopLoading();
		if ($respon.status==true){
			showNotify('Berhasil',$respon.message);
			@if($callback!='') {{$callback}}(); @endif
		}else{
			showAlert('Gagal',$respon.message);
		}

	},
	error:function(){
		showAlert('Gagal','Terjadi Kesalahan, Periksa Koneksi Internet!');
	}
}); 