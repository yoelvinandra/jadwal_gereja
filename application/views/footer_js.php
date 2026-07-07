
<script>
    var format_uang   = $.fn.dataTable.render.number(',', '.', 2, '');
	var format_number = $.fn.dataTable.render.number(',', '.', 0, '');
    
    //Flat blue color scheme for iCheck
    $('input[type="checkbox"].flat-blue, input[type="radio"].flat-blue').iCheck({
        checkboxClass: 'icheckbox_flat-blue',
        radioClass   : 'iradio_flat-blue'
    })  
	//UNTUK EMAIL
	$(function () {
		//Add text editor
		$("#compose-textarea").wysihtml5();
	});
	
	$(".menu-header a").click(function(){
		
		//CEK APAKAH CONTENT NYA LAPORAN ATAU TIDAK
		if($("#mySidenav").html() != null)
		{
			$(".content-wrapper").html("");
		}
	});

	function halamanPilihPerusahaan() {
		Swal.fire({
			text: 'Anda Yakin Akan Kembali ke Halaman Pilih Perusahaan ?',
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Ya',
			cancelButtonText: 'Batal'
		}).then((result) => {
			if (result.value) {
				window.location = base_url + 'Perusahaan';
			}
		})
	}
	
</script>