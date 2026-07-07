<!-- Content Header (Page header) -->
<section class="content-header">
	<div class="row">
		<div class="col-md-1 col-xs-1" style="text-align='center'">
			<button class="btn" style="background:#333;color:white;" data-toggle="modal" data-target="#modal-menu"><i class='fa fa-navicon'></i></button>
		</div>
		<div class="col-md-10 col-xs-10" style="font-size:20pt;">
			Cetak Laporan
		</div>
		<div class="col-md-1 col-xs-1" style="text-align='center';">
			<button class="btn btn-primary pull-right " id="btn_print" ><i class="fa fa-print" ></i></button>
		</div>
	</div>
</section>

<!-- Main content -->
<section class="content">
    <div class="row" style="overflow-y:hidden;">
        <div class="col-md-12">
            <div class="box">
                <!-- Custom Tabs -->
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs" id="tab-filter" >
                        <li class="active" id="tab_filter"><a href="#tab_form" data-toggle="tab">FILTER</a></li>
                    </ul>
                    <div class="tab-content" id="tab-report">
                        <div class="tab-pane active" id="tab_form">
							
                            <div class="col-sm-12">
                                <!-- form start -->
                                <form method='post' target="" action='<?=base_url()?>Laporan/laporan' id="form_input">
                                    <div class="box-body">
                                        <div class="form-group col-sm-6">
											<h4 class="box-title">
												<b>Filter Data</b>
											</h4>
											
											<div class="form-group col-sm-6 ">
                                                <label for="Bulan">Bulan Awal</label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-calendar-check-o"></i>
                                                    </div>
                                                    <input type="text" class="form-control " id="txt_bulan_aw" name="txt_bulan_aw" placeholder="Bulan..." style="width:97%;" >
													
                                                </div>
                                            </div>
											
											<div class="form-group col-sm-6 ">
                                                <label for="Tahun">Tahun Awal</label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-calendar-plus-o"></i>
                                                    </div>
                                                     <input type="text" class="form-control " id="txt_tahun_aw" name="txt_tahun_aw" placeholder="Bulan..." style="width:97%;" >
													
                                                </div>
                                            </div>
											
												<div class="form-group col-sm-6 ">
                                                <label for="Bulan">Bulan Akhir</label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-calendar-check-o"></i>
                                                    </div>
                                                    <input type="text" class="form-control " id="txt_bulan_ak" name="txt_bulan_ak" placeholder="Bulan..." style="width:97%;" >
													
                                                </div>
                                            </div>
											
											<div class="form-group col-sm-6 ">
                                                <label for="Tahun">Tahun Akhir</label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-calendar-plus-o"></i>
                                                    </div>
                                                     <input type="text" class="form-control " id="txt_tahun_ak" name="txt_tahun_ak" placeholder="Bulan..." style="width:97%;" >
													
                                                </div>
                                            </div>
                                            <div class="form-group col-sm-6 ">
                                                <div class="input-group">
                                                   <input type="checkbox" name="pelayanAktifSaja" value ="1"> Pelayan Yang Aktif Saja
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-sm-6">
											<h4 class="box-title">
												<b>Jenis Laporan</b>
											</h4>
											<div class="form-group">
												<label>
												  <input type="radio" id="excel" name="excel" value="tidak" class="flat-blue" checked> Cetak 
												</label>
												&nbsp;&nbsp;&nbsp;
												<label>
												  <input type="radio" name="excel" value="ya" class="flat-blue"> Ubah Jadi Excel
												</label>
											</div>
											<div class="info-box bg-yellow" onclick="simpan('DAFTAR PELAYAN')" style="cursor:pointer;">
												<span class="info-box-icon"><i class="ion ion-ios-book-outline" style="margin-top:20%; font-size:40pt;"></i></span>

												<div class="info-box-content">
												   <span class="info-box-number">Daftar Pelayan</span>
												   <span>Menampilkan daftar pelayan yang ada di gereja.</span>
												</div>
												<!-- /.info-box-content -->
											</div>
											<div class="info-box bg-yellow" onclick="simpan('DAFTAR PELAYANAN')" style="cursor:pointer;">
												<span class="info-box-icon"><i class="ion ion-ios-book-outline" style="margin-top:20%; font-size:40pt;"></i></span>

												<div class="info-box-content">
												   <span class="info-box-number">Daftar Pelayan dengan Jenis Pelayanannya</span>
												   <span>Menampilkan daftar pelayan berdasarkan jenis pelayanannya.</span>
												</div>
												<!-- /.info-box-content -->
											</div>
											<div class="info-box bg-yellow" onclick="simpan('JADWAL PELAYANAN')" style="cursor:pointer;">
												<span class="info-box-icon"><i class="ion ion-ios-book-outline" style="margin-top:20%; font-size:40pt;"></i></span>

												<div class="info-box-content">
												   <span class="info-box-number">Jadwal Pelayanan</span>
												   <span>Menampilkan Jadwal Pelayanan Sesuai Filter Bulan</span>
												</div>
												<!-- /.info-box-content -->
											</div>
											<div class="info-box bg-yellow" onclick="simpan('TOTAL PELAYANAN')" style="cursor:pointer;">
												<span class="info-box-icon"><i class="ion ion-ios-book-outline" style="margin-top:20%; font-size:40pt;"></i></span>

												<div class="info-box-content">
												   <span class="info-box-number">Total Pelayanan</span>
												   <span>Menampilkan Total Pelayanan Setiap Pelayan Sesuai Filter Bulan</span>
												</div>
												<!-- /.info-box-content -->
											</div>
                                        </div>
                                    </div>
									
									<!-- NAMA LAPORAN -->
									<input type="hidden" name="file_name" id="file_name" value="">
									<input type="hidden" id="data_tampil" name="data_tampil">
									<input type="hidden" id="blnAw" name="blnAw">
									<input type="hidden" id="blnAk" name="blnAk">
									<input type="hidden" id="thnAw" name="thnAw">
									<input type="hidden" id="thnAk" name="thnAk">
                                    <!-- /.box-body -->
                                </form>
                                <!-- Button -->
                            </div>
                            <!-- /.tab-pane -->
                        </div>
                        <!-- /.tab-content -->
                    </div>

                </div>
            </div>
            <!-- /.col -->
        </div>
    </div>
    <!-- /.row (main row) -->
</section>
<script>
var counter = 0;
var tglsaldoawal = 0;
$(document).ready(function(){
	
	$('#txt_bulan_aw').datepicker({
		format: 'MM',
		viewMode: "months", 
		minViewMode: "months"
	});
	
	$('#txt_tahun_aw').datepicker({
		format: 'yyyy',
		viewMode: "years", 
		minViewMode: "years"
	});
	
	$('#txt_bulan_ak').datepicker({
		format: 'MM',
		viewMode: "months", 
		minViewMode: "months"
	});
	
	$('#txt_tahun_ak').datepicker({
		format: 'yyyy',
		viewMode: "years", 
		minViewMode: "years"
	});
	
	$("#txt_bulan_aw").datepicker('setDate', "<?=date('Y-m-d');?>");
	$("#txt_bulan_ak").datepicker('setDate', "<?=date('Y-m-d');?>");
	$("#txt_tahun_aw").datepicker('setDate', "<?=date('Y-m-d');?>");
	$("#txt_tahun_ak").datepicker('setDate', "<?=date('Y-m-d');?>");

    var format_uang = $.fn.dataTable.render.number(',', '.', 2, '');
});


function simpan(modeSimpan) {
	var check = 0;
	var bulanAwal = $('#txt_bulan_aw').datepicker('getDate').getMonth()+1;
	var bulanAkhir = $('#txt_bulan_ak').datepicker('getDate').getMonth()+1;
	var tahunAwal = $('#txt_tahun_aw').datepicker('getDate').getFullYear();
	var tahunAkhir = $('#txt_tahun_ak').datepicker('getDate').getFullYear();

	
	
	$('#blnAw').val(bulanAwal);
	$('#blnAk').val(bulanAkhir);
	$('#thnAw').val(tahunAwal);
	$('#thnAk').val(tahunAkhir);
	var tahunSaldo = '<?=$saldostoksplit[0]?>';
	var bulanSaldo = '<?=$saldostoksplit[1]?>';
		
		
	if(tahunSaldo >= tahunAwal && bulanSaldo >= bulanAwal){
		check++;
		errMsg = "Periode laporan dimulai dari bulan "+'<?=$namabulan." ".$saldostoksplit[0]?>';
	}

	if ((bulanAkhir >= bulanAwal) && (tahunAkhir - tahunAwal) > 0){
		// Tahun akhir lebih besar dari setahun dari Tahun awal, maka bulan awal lebih kecil sama dengan dari akhir
		check++;
		errMsg = "Maks. Range Periode hanya 12 Bulan dari Bulan Awal  ";
	}
	
	if ((bulanAkhir - bulanAwal) < 0 && (tahunAkhir - tahunAwal) == 0)
	{ // Dalam Tahun yang sama, bulan awal tidak mungkin lebih besar dari akhir
		check++;
		errMsg = "Maks. Range Periode hanya 12 Bulan dari Bulan Awal  ";
	}

	if (tahunAwal > tahunAkhir)
	{
		check++;
		errMsg = "Maks. Range Periode hanya 12 Bulan dari Bulan Awal  ";
	}
	
	//SIMPAN DATA JENIS LAPORAN
	$('#data_tampil').val(modeSimpan);
	
	if(check == 0){
		$("#file_name").val(modeSimpan);
		$("#form_input").attr('target',modeSimpan);
		
		var tab_title = $('#file_name').val();
		var tab_name = tab_title+counter;
		$('#form_input').attr('target',tab_name);
		
		if($("input[name='excel']:checked").val() == "tidak"){
			$("#tab-filter li").removeClass("active");
			$("#tab-report div").removeClass("active");
			$("#tab-filter").append('<li class="active" id="tab_'+counter+'"><a href="#tab_grid_'+counter+'" data-toggle="tab" >'+tab_title+'&nbsp;<i class="fa fa-close" style="cursor:pointer;" onclick=hapus_tab('+counter+')></i></a></li>');
			
			$("#tab-report").append('<div class="tab-pane active report" style="border:0px;" id="tab_grid_'+counter+'"><iframe id="'+tab_name+'" name="'+tab_name+'" width="100%"  style="height:100%;"  frameBorder="0" src="#"></iframe></div>');
			
			$(".report").css("height",(screen.height)+"px");
			
			counter++;
		}	
		
		$('#form_input').submit();
		return false;
	}
	else
	{
		alert(errMsg);
		
	}

}

function hapus_tab(index)
{
	$("#tab-filter li").removeClass("active");
	$("#tab-report div").removeClass("active");
		
	$("#tab_"+index).remove();
	$("#tab_grid_"+index).remove();
	
	$("#tab_filter").addClass("active");
	$("#tab_form").addClass("active");
}

$("#btn_print").click(function(){
	var tab_title = $('#file_name').val();
	var index = tab_title+$(".active").attr("id").substr(-1);
	
	window.frames[index].print();
})
</script>