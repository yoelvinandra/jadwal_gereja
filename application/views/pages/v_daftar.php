
<!-- Content Header (Page header) -->
<section class="content-header">
	<div class="row">
		<div class="col-md-12 col-xs-12" style="font-size:20pt; text-align:center;">
			Formulir Pendaftaran Minat pada Bidang Praise and Worship (PAW)
		</div>
	</div>
</section>

<!-- Main content -->
<section class="content">
    
    <!-- Main row -->
    <div class="row">
        <div class="col-md-12">
        <div class="box">
        <!-- Custom Tabs -->
        <div class="box-body">
				<div class="col-md-3">
				</div>
				<div class="col-md-6">
				<!-- form start -->
				<form role="form" id="form_input">
					<input type="hidden" id="mode" name="mode">
					<input type="hidden" id="IDPELAYAN" name="IDPELAYAN">
						<div class="box-body">
							<div style="color:red;">
								<span style="font-size:20pt;" >>>> MOHON DIBACA TERLEBIH DAHULU <<<</span>
								<ol>
									 <li style="margin-bottom:10px;">Formulir ini bertujuan untuk mengetahui MINAT dari para Pelayan Praise dan Worship (PAW).</li>
									 <li style="margin-bottom:10px;">Pelayan Tuhan bisa memilih jenis pelayanan LEBIH DARI 1, yang diminati.</li>
									 <li style="margin-bottom:10px;">Data yang tersimpan hanya untuk SURVEY MINAT saja.</li>
								</ol>
							</div>
							<br>
							<label>Panggilan &nbsp; &nbsp; <span style="font-weight:normal; font-style:italic;">Cth : Bpk, Ibu, Sdr, Sdri</span> <input type="checkbox" class="flat-blue" id="STATUS" name="STATUS" value="1" style="display:none;"></label>
							<br>
							<select class="form-control " id="CB_PANGGILAN"style="width:40%; float:left;">
									<option selected value="">--Daftar Panggilan--</option>
									<?=comboGridPanggilan("model_master_pelayan")?>
							</select>
							<input type="hidden" class="form-control" id="PANGGILAN" name="PANGGILAN" placeholder="Panggilan" style="width:58%; float:right;">
							<br>
							<br>
							<br>
							
							<label>Nama Panggilan di Gereja</label> 
							<input type="text" class="form-control" id="NAMAPELAYAN" name="NAMAPELAYAN" placeholder="Gunakan Nama Singkat Saja">
							<br>
							
							<label>HP (Utamakan No WA)</label>
							<input type="text" class="form-control" id="TELP" name="TELP" placeholder="Gunakan Format 62, Contoh : 62895000000">
							<br>
							
							<label>Jenis Pelayanan Yang Dipilih</label>
					
								<select class="form-control select2" multiple="multiple" id="CB_JENIS_PELAYANAN" name="cb_jenis_pelayanan[]" placeholder="Jenis Pelayanan" style="width:100%;">
										<?=comboGrid("model_master_jenispelayanan")?>
								</select>
							<i>*Klik pada kotak untuk memilih, jangan diketik</i>
							<br>
							<br>
							<br>
							<button type="button" id="btn_simpan" style="width:100%;" class="btn btn-primary" onclick="javascript:simpan()">Simpan Data</button>
						</div>
					</div>
				</form>
			</div>
        <!-- nav-tabs-custom -->
        </div>
    </div>
    <!-- /.col -->
    </div>
    <!-- /.row (main row) -->

</section>
<!-- /.content -->

<script>
var oldJenisLokasi = "";
var base_url = '<?=base_url()?>';

var iddetail = "";
var classdetail = "";

$(document).ready(function() {
	$('.select2').select2({
		  theme: "classic"
	});
	
	$("#CB_PANGGILAN").change(function(){
		$("#PANGGILAN").val($(this).val());
	});
	
	$("#PANGGILAN").change(function(){
		$("#CB_PANGGILAN").val("");
	});
	
    $("#mode").val('tambah');
    $("#STATUS").prop('checked',true).iCheck('update');
	
});

function tambah(){
	$("#mode").val('tambah');
	
	//pindah tab & ganti judul tab
	$('.nav-tabs a[href="#tab_form"]').tab('show');
	$('.nav-tabs a[href="#tab_form"]').html('TAMBAH');
	
	resetForm($("#form_input"));
}

function simpan() {
	
	if (1) {
		mode = $('[name=mode]').val();
        
        $.ajax({
            type      : 'POST',
            url       : base_url+'Pelayan/simpan',
            data      : $('#form_input :input').serialize(),
            dataType  : 'json',
            beforeSend: function (){
                //$.messager.progress();
            },
            success: function(msg){
                if (msg.success) {
                    Swal.fire({
                        title            : 'Simpan Data Sukses',
                        type             : 'success',
                        showConfirmButton: false,
                        timer            : 1500
                    });
					
					window.location.replace(base_url+'Home/exitform');
					
                } else {
                    Swal.fire({
                        title            : msg.errorMsg,
                        type             : 'error',
                        showConfirmButton: false,
                        timer            : 1500
                    });
                }
            }
        });
	}
}

function resetForm($form) {
    $form.find('input:text, input:password, input:file, select, textarea').val('');
    $form.find('input:radio, input:checkbox')
         .removeAttr('checked').removeAttr('selected');
	$(".select2").select2().val('').trigger('change.select2')
}

</script>