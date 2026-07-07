<style>
    .red{
        background:red;
    }
</style>
<!-- Content Header (Page header) -->
<section class="content-header">
	<div class="row">
		<div class="col-md-1 col-xs-1" style="text-align='center'">
			<button class="btn" style="background:#333;color:white;" data-toggle="modal" data-target="#modal-menu"><i class='fa fa-navicon'></i></button>
		</div>
		<div class="col-md-10 col-xs-10" style="font-size:20pt;">
			Jadwal Pelayanan
		</div>
		<div class="col-md-1 col-xs-1" style="text-align='center'">
			<button class="btn btn-success" onclick="javascript:tambah()"><i class='fa fa-plus'></i></button>
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
        <div class="nav-tabs-custom" >
            <ul class="nav nav-tabs" id="tab_transaksi">
                <li class="active"><a href="#tab_grid" data-toggle="tab">GRID</a></li>
                <li><a href="#tab_form" data-toggle="tab"></a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_grid">
                    <div class="box-body">
                        <table id="dataGrid" class="table table-bordered table-striped table-hover display nowrap" width="100%">
                            <!-- class="table-hover"> -->
                            <thead>
                                <tr>
                                    <th>ID</th>                                    
                                    <th width="100px">Bulan</th>
                                    <th width="100px">Tahun</th>
                                    <th>Catatan</th>
                                    <th width="100px">Status</th>
                                    <th width="100px"></th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <!-- /.tab-pane -->
                <div class="tab-pane" id="tab_form">
                    <div class="box-body">
                        <div class="col-md-12">
                        <!-- form start -->
                        <form role="form" id="form_input">
                            <input type="hidden" id="mode" name="mode">
                            <input type="hidden" id="DATAPELAYAN" name="DATAPELAYAN">
                            <input type="hidden" id="IDJADWAL" name="IDJADWAL">
                            <input type="hidden" id="BULANANGKA" name="BULANANGKA">
                            <input type="hidden" id="SIMPAN" name="SIMPAN">
                            <input type="hidden" id="TANGGALJADWAL">
                            <div class="box-body">
                                <div class="form-group col-md-12">	
                                    
									<div class="col-md-3 col-sm-3 col-xs-3"  style="padding: 0px 0px 5px 0px">
                                        <label>Bulan</label>
                                    </div>
                                    <div class="col-md-1 col-sm-1 col-xs-1"  style="padding: 0px 0px 5px 0px">
                                        &nbsp;
                                    </div>
                                    <div class="col-md-3 col-sm-3 col-xs-3"  style="padding: 0px 0px 5px 0px">
                                        <label>Tahun</label>
                                    </div> <div class="col-md-1 col-sm-1 col-xs-1"  style="padding: 0px 0px 5px 0px">
                                        &nbsp;
                                    </div>
                                    <div class="col-md-2 col-sm-2 col-xs-2"  style="padding: 0px 0px 5px 0px">
                                        <label>Tanggal Tambahan (selain Minggu)</label>
                                    </div>
									<div class="col-md-1 col-sm-1 col-xs-1"  style="padding: 0px 0px 5px 0px">
                                        &nbsp;
                                    </div>
									<div class="col-md-1 col-sm-1 col-xs-1"  style="padding: 0px 0px 5px 0px">
										<label></label> 
                                    </div>
									
									<div class="col-md-3 col-sm-6 col-xs-6"  style="padding: 0px 0px 5px 0px">
                                        <input type="text" class="form-control" id="sb_bulan"  name="BULAN" style=" border:1px solid #B5B4B4; border-radius:1px;">
                                    </div>
                                    <div class="col-md-1 col-sm-1 col-xs-1"  style="padding: 0px 0px 5px 0px">
                                        &nbsp;
                                    </div>
                                    <div class="col-md-3 col-sm-3 col-xs-3"  style="padding: 0px 0px 5px 0px">
                                        <input type="text" class="form-control" id="txt_tahun"  name="TAHUN" style=" border:1px solid #B5B4B4; border-radius:1px;">
                                    </div>
									<div class="col-md-1 col-sm-1 col-xs-1"  style="padding: 0px 0px 5px 0px">
                                        &nbsp;
                                    </div>
                                
                                    <div class="col-md-2 col-sm-2 col-xs-2"  style="padding: 0px 0px 5px 0px">
                                        <input type="text" class="form-control" id="tglpengecualian"  name="TGLPENGECUALIAN" style=" border:1px solid #B5B4B4; border-radius:1px;">
                                    </div>
                                    <div class="col-md-1 col-sm-1 col-xs-1"  style="padding: 0px 0px 5px 0px">
                                        &nbsp;
                                    </div>
									<div class="col-md-1 col-sm-1 col-xs-1"  style="padding: 0px 0px 5px 0px">
									   <button type="button" id="btn_generate" class="btn btn-primary" onclick="javascript:generate()">Buat Jadwal</button>
                                    </div>
                                    <div class=" col-md-12 col-sm-12 col-xs-12">
										<br>
										<br>
									</div>
									<div class=" col-md-12 col-sm-12 col-xs-12"style="text-align:center;">
										<label style="font-size:20pt;">Jadwal <span class="keteranganbulantahun" style="font-size:20pt;">Bulan</span></label>
										<br><small style="color:red;"><i>&nbsp;&nbsp;&nbsp;*Klik Grid Untuk Mengganti Jadwal </i></small>
										<br>
									</div>
									<div class=" col-md-12 col-sm-12 col-xs-12" style="text-align:center;">
										<span style="background:orange;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
										&nbsp;&nbsp; Pelayan melayani lebih dari Satu Jenis Pelayanan pada Hari yang Sama</td>
										<br><br>
									</div>
									<table id="datagridDetail" class="table table-bordered table-striped table-hover display nowrap" width="100%">
										<thead id="head"></thead>
									<!-- class="table-hover"> -->
										<tbody id="body"></tbody>
									</table>
									<br>
									<label>Catatan <i>(Disampaikan Ketika Kirim Whatsapp Dibawah Format WA Yang Sudah Ada)</i></label>
									<div style="color:grey">
									Format WA :
									<br>
									 Shallom bagi Rekan-Rekan Sepelayanan {NAMA GEREJA},
									 <br>kami selaku Koordinator Praise And Worship ingin bertanya.
									 <br>Apakah {NAMA PELAYAN} bersedia untuk melayani <b>{NAMA PELAYANAN}</b> 
			  						 <br>pada <b> Hari Minggu </b> tanggal <b> {TANGGAL PELAYANAN} </b>  ?
									 <br>
									 <br>{CATATAN}
									</div>
									<br>
									<textarea class="form-control" rows="5" id="CATATAN" name="CATATAN" placeholder="Catatan ..."></textarea>
								</div>
							</div>
                            <!-- /.box-body -->
							<div class="box-footer col-md-10">
							&nbsp;
							</div>
                            <div class="box-footer col-md-2">
                                <button type="button" id="btn_simpan" class="btn btn-primary" onclick="javascript:simpan('1')">Simpan</button>
                                <button type="button" id="btn_simpan_setuju" class="btn btn-success" onclick="javascript:simpan('2')">Simpan dan Disetujui</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
        </div>
        <!-- nav-tabs-custom -->
        </div>
    </div>
    <!-- /.col -->
    </div>
    <!-- /.row (main row) -->

	<div class="modal fade" id="modal-sendWA"  style="z-index:100000;">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body  modal-wapelayan">
				
            </div>
        </div>
        </div>
    </div>

    <div class="modal fade" id="modal-pelayan"  style="z-index:100000;">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <table id="table_pelayan" class="table table-bordered table-striped table-hover display nowrap" width="100%">
                    <thead >
                        <tr>
                            <th></th>
                            <th>Nama Pelayan</th>
                            <th>Telp</th>
                            <th>Jadwal Tabrakan</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        </div>
    </div>
	
	<div class="modal fade" id="modal-editpelayan" >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
        			<label>Jenis Pelayanan</label>
        			<input type="text" id="IDJENISPELAYANAN" name="IDJENISPELAYANAN" hidden>
        			<input type="text" class="form-control" id="NAMAJENISPELAYANAN" name="NAMAJENISPELAYANAN" placeholder="Jenis Pelayanan" readonly>
        			<br>
        			<label>Nama Pelayan</label>
        			<div class="input-group margin" style="padding:0; margin:0">
        				<input type="text" id="IDPELAYAN" name="IDPELAYAN" hidden>
        				<input type="text" class="form-control" id="NAMAPELAYAN" name="NAMAPELAYAN" placeholder="Nama Pelayan" readonly>
        				<div class="input-group-btn">
        					<button type="button" class="btn btn-primary btn-flat" data-toggle="modal" data-target="#modal-pelayan">Search</button>
        				</div>
        			</div>
        			<br>
        			<button type="button" id="btn_edit" class="btn btn-primary">Ubah</button>
        		
                </div>
            </div>
        </div>

    </div>
    
    <div class="modal fade" id="modal-editalasan" >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title">
            			<label style="font-size:16pt;">Alasan Tidak Ada Ibadah</label>
                    </div>
                </div>
                <div class="modal-body">
        			<label>Tanggal</label>
        			<input type="hidden"id="INDEXALASAN" name="INDEXALASAN">
        			<input type="hidden"id="TANGGAL" name="TANGGAL">
        			<input type="text" class="form-control" id="TANGGALFORMAT" name="TANGGALFORMAT" placeholder="Tanggal" readonly>
        			<br>
        			<label>Alasan</label>
        			<input type="text" class="form-control" id="ALASAN" name="ALASAN" placeholder="Alasan">
        			<br>
        			<button type="button" id="btn_simpan_alasan" class="btn btn-primary">Simpan Alasan</button>
                </div>
            </div>
        </div>

    </div>

</section>
<!-- /.content -->

<script>
var oldJenisLokasi = "";
var base_url = '<?=base_url()?>';

var iddetail = "";
var classdetail = "";

var idpelayanx = "";
var namapelayanx = "";

$(document).ready(function() {
    $("#mode").val('tambah');
    $("#STATUS").prop('checked',true).iCheck('update');
	
	$('#sb_bulan').datepicker({
		format: 'MM',
		viewMode: "months", 
		minViewMode: "months"
	}).on("change", function() {
		$("#head").html('');
		$("#body").html('');
	    if($("#txt_tahun").val() != "" && $("#sb_bulan").val() != "" && $("#tglpengecualian").val() != "")
	    {
	        var arrTgl = $("#tglpengecualian").val().split("-");
	        
		    $("#tglpengecualian").datepicker('setDate', $("#txt_tahun").val()+"-"+($('#sb_bulan').datepicker('getDate').getMonth()+1)+"-"+arrTgl[2]);
	    }
	 });
	
	$('#txt_tahun').datepicker({
		format: 'yyyy',
		viewMode: "years", 
		minViewMode: "years"
	}).on("change", function() {
		$("#head").html('');
		$("#body").html('');
		if($("#txt_tahun").val() != "" && $("#sb_bulan").val() != "" && $("#tglpengecualian").val() != "")
	    {
	        var arrTgl = $("#tglpengecualian").val().split("-");
	        
		    $("#tglpengecualian").datepicker('setDate', $("#txt_tahun").val()+"-"+($('#sb_bulan').datepicker('getDate').getMonth()+1)+"-"+arrTgl[2]);
	    }
	});
	 
	$('#tglpengecualian').datepicker({
		format: 'yyyy-mm-dd',
	}).on("change", function() {
		$("#head").html('');
		$("#body").html('');
// 		if($("#txt_tahun").val() != "" && $("#sb_bulan").val() != "" && $("#tglpengecualian").val() != "")
// 	    {
// 	        var arrTgl = $("#tglpengecualian").val().split("-");
	    
// 		    $("#tglpengecualian").datepicker('setDate', $("#txt_tahun").val()+"-"+($('#sb_bulan').datepicker('getDate').getMonth()+1)+"-"+arrTgl[2]);
// 	    }
	 });
	 
	 
	$.ajax({
		type      : 'POST',
		url       : base_url+'Pelayan/getPelayanX',
		dataType  : 'json',
		beforeSend: function (){
			//$.messager.progress();
		},
		success: function(msg){
		    idpelayanx = msg.idpelayan;
		    namapelayanx = msg.namapelayan;
		}
	});
	
	$('.select2').select2({
		  theme: "classic"
	});
	
	 $('#dataGrid').DataTable({
        'paging'      : true,
        'lengthChange': true,
        'searching'   : true,
        'ordering'    : false,
        'info'        : true,
        'autoWidth'   : false,
		"scrollX"	  : true,
		ajax		  : {
			url    : base_url+'JadwalPelayanan/dataGrid',
			dataSrc: "rows",
		},
        columns:[
            {data: 'idjadwal', visible:false},
            {data: 'bulan', className:"text-center"},
            {data: 'tahun', className:"text-center"},
            {data: 'catatan', className:"text-center"},{data: 'status', className:"text-center", 
            render: function(data) { 
                if(data == "1") {
                  return 'BELUM DISETUJUI' 
                }
                else {
                  return 'DISETUJUI'
                }

              },
            },
			{data: ''},
        ],
		columnDefs: [ 
			{
                "targets": -1,
                "data": null,
                "defaultContent": "<button id='btn_ubah' class='btn btn-primary'><i class='fa fa-edit'></i></button>&nbsp;<button id='btn_wa' class='btn btn-success'><img src='<?=base_url();?>/assets/images/whatsapp.png' style='height:16px;'></button>&nbsp;<button id='btn_hapus' class='btn btn-danger'><i class='fa fa-trash' aria-hidden='true' ></button>"	
			},
		],
    });  
	
    //DAPATKAN INDEX
	$('#dataGrid tbody').on( 'click', 'button', function () {
		var table = $('#dataGrid').DataTable();
		var row = table.row( $(this).parents('tr') ).data();
		var mode = $(this).attr("id");
		
		if(mode == "btn_ubah"){ ubah(row); }
		else if(mode == "btn_wa"){ bukaWA(row); }
		else if(mode == "btn_hapus"){ hapus(row); }
	});
	
	$('#datagridDetail tbody').on( 'click','tr', function () {
	    var lastTd = $(this).find("td:last-child").attr("id");
		$("#TANGGALJADWAL").val(lastTd.split(".")[0]);
    	$("#table_pelayan").DataTable().ajax.reload();
	});
	
	$('#datagridDetail tbody').on( 'click','tr td', function () {

		iddetail 				= $(this).attr("id");
		classdetail 			= $(this).attr("class");

		if($(this).attr("class").split("_")[1] === "alasanvalue")
		{
    	    var tanggal 			= $(this).attr("id");
    	    var indexAlasan 		= $(this).attr("class");
    	 
    	    $("#TANGGAL").val(tanggal);
    	    $("#TANGGALFORMAT").val($.datepicker.formatDate('dd / MM / yy', new Date(tanggal)));
    	    $("#ALASAN").val($("."+indexAlasan).text());
    	    $("#INDEXALASAN").val(indexAlasan);
    		$("#modal-editalasan").modal('show');
		}
		else
		{
		    var urutani 			= $(this).attr("class").split("_")[0];
    		var urutanj				= $(this).attr("class").split("_")[1];
    		var idjenispelayanan 	= $(this).attr("class").split("_")[2];
		
		
    		var idpelayan			= $(this).attr("class").split("_")[3];
    		var namajenispelayanan 	= $(this).attr("id").replaceAll('_', ' ');
    		var namapelayan 		= $(this).html();
    		
    		if(namajenispelayanan != "TANGGAL")
    		{
    			$("#IDJENISPELAYANAN").val(idjenispelayanan);
    			$("#NAMAJENISPELAYANAN").val(namajenispelayanan);
    			$("#IDPELAYAN").val(idpelayan);
    			$("#NAMAPELAYAN").val(namapelayan);
    			$("#modal-editpelayan").modal('show');
    		}
    		
		}
	} );
	
	$('#table_pelayan').DataTable({
        'paging'      : false,
        'lengthChange': false,
        'searching'   : false,
        'ordering'    : false,
        'info'        : true,
        'autoWidth'   : false,
		"scrollX"	  : true,
		ajax		  : {
			url    : base_url+'JadwalPelayanan/getDataPelayan',
			dataSrc	: "rows",
			type   	: "POST",
			data   : function(e){
					e.idjenispelayanan 		 = getIDJenisPelayan();
					e.tgl                    = getTgl();
			}
		},
        columns:[
            {data: 'idpelayan',visible: false,},
            {data: 'namapelayan', className:""},
            {data: 'telp', className:""},
            {data: 'namajadwaltabrakan', render: function(data) { 
                if(data != "") {
                  return '<div style="background:yellow; margin:0px; padding-left:5px; padding-right:5px; font-style:italic;">'+data+'</div>' 
                }
                else {
                  return ''
                }

              },},
        ],
    });

	$('#modal-pelayan').on('shown.bs.modal', function (e) {
		$('#table_pelayan').DataTable().columns.adjust().draw();
	});
	
	$('#table_pelayan tbody').on('click', 'tr', function () {
		
		var row = $('#table_pelayan').DataTable().row( this ).data();
		$("#modal-pelayan").modal('hide');	
		
		$("#NAMAPELAYAN").val(row.namapelayan);
		$("#IDPELAYAN").val(row.idpelayan);
	});	
	
	$("#btn_edit").click( function () {

		var namajenispelayanan 	= $("#NAMAJENISPELAYANAN").val();
		var idjenispelayanan 	= $("#IDJENISPELAYANAN").val();
		var namapelayan			= $("#NAMAPELAYAN").val();
		var idpelayan 		    = $("#IDPELAYAN").val();
		var urutani				= $("."+classdetail).attr("class").split("_")[0];
		var urutanj				= $("."+classdetail).attr("class").split("_")[1];
		
		$("."+classdetail).html(namapelayan);
		
		//GANTI CLASS nya
		$("."+classdetail).attr("class",urutani+"_"+urutanj+"_"+idjenispelayanan+"_"+idpelayan);
		
		//AMBIL NAMAPELAYANKEMBAR
		var listnamapelayan = [];
		var tableData = $('table#datagridDetail tr#'+urutani).find('td');
		if (tableData.length > 0) {
			tableData.each(function() { 
				listnamapelayan.push($(this).text());
			});
		}
		
		var tableData = $('table#datagridDetail tr#'+urutani).find('td');
		if (tableData.length > 0) {
			tableData.each(function() { 
				$(this).css('background','');
				if(listnamapelayan.filter(x => x == $(this).text()).length > 1)
				{
					$(this).css('background','orange');
				}
			});
		}
		
    	$("."+urutani+"_alasanvalue").text("");
		
		$("#NAMAJENISPELAYANAN").val('');
		$("#IDJENISPELAYANAN").val('');
		$("#NAMAPELAYAN").val('');
		$("#IDPELAYAN").val('');
		
		$("#modal-editpelayan").modal('hide');
	});
	
	$("#btn_simpan_alasan").click( function () {
        
        if($("#ALASAN").val() != "" && $("#ALASAN").val() != "-")
        {
    		var urutani 	= $("#INDEXALASAN").val().split("_")[0];
    		var urutanj     = 0;
    
    		//UBAH SEMUA CLASS nya ATAS TANGGAL TSB
    		var tableData = $('table#datagridDetail tr#'+urutani).find('td');
    		if (tableData.length > 0) {
    			tableData.each(function() { 
    			    if(urutanj > 0 && urutanj < tableData.length-1)
    			    {
        			    $(this).attr("class",urutani+"_"+urutanj+"_"+$(this).attr("class").split("_")[2]+"_"+idpelayanx);
    
            	        $(this).text(namapelayanx);
    			    }
    			    urutanj++;
    			});
    			
    		}
    		
    		//AMBIL NAMAPELAYANKEMBAR
    		var listnamapelayan = [];
    		var tableData = $('table#datagridDetail tr#'+urutani).find('td');
    		if (tableData.length > 0) {
    			tableData.each(function() { 
    				listnamapelayan.push($(this).text());
    			});
    		}
    		
    		var tableData = $('table#datagridDetail tr#'+urutani).find('td');
    		if (tableData.length > 0) {
    			tableData.each(function() { 
    				$(this).css('background','');
    				if(listnamapelayan.filter(x => x == $(this).text()).length > 1)
    				{
    					$(this).css('background','orange');
    				}
    			});
    		}
    		
    		$("#NAMAJENISPELAYANAN").val('');
    		$("#IDJENISPELAYANAN").val('');
    		$("#TANGGALFORMAT").val('');
    		$("#TANGGAL").val('');
    		$("."+$("#INDEXALASAN").val()).text($("#ALASAN").val());
    		
    		$("#modal-editalasan").modal('hide');
        }
        else
        {
            Swal.fire({
				title            : "Alasan Ibadah Ditiadakan Harus Ada",
				type             : 'warning',
				showConfirmButton: false,
				timer            : 3000
			});
        }
	});
});

function getIDJenisPelayan(){
	return $("#IDJENISPELAYANAN").val();
}

function getTgl(){
    return $("#TANGGALJADWAL").val();
}

function tambah(){
	$("#mode").val('tambah');
	
	//pindah tab & ganti judul tab
	$('.nav-tabs a[href="#tab_form"]').tab('show');
	$('.nav-tabs a[href="#tab_form"]').html('TAMBAH');

	$("#CATATAN").val("");
	
	resetForm();
}

function ubah(row){
	
	$("#mode").val('ubah');
	//pindah tab & ganti judul tab
	$('.nav-tabs a[href="#tab_form"]').tab('show');
	$('.nav-tabs a[href="#tab_form"]').html('UBAH');
	
	$('#btn_generate').css('filter', 'grayscale(100%)');$('#btn_generate').removeAttr('onclick');
	
	$("#sb_bulan").datepicker('setDate',row.bulan).attr('disabled','disabled');
	$("#txt_tahun").datepicker('setDate',row.tahun).attr('disabled','disabled');
	$("#tglpengecualian").datepicker('setDate', "").attr('disabled','disabled');   
	$("#IDJADWAL").val(row.idjadwal);
	setDatagridDetail();
}

var dataJadwal;
function bukaWA(row){

	 $.ajax({
		type      : 'POST',
		url       : base_url+'JadwalPelayanan/dataGridDetail',
		data      : {bulan:row.bulan,tahun:row.tahun},
		dataType  : 'json',
		beforeSend: function (){
			//$.messager.progress();
		},
		success: function(msg){

			var content = "";
			var oldtanggal = "";

			dataJadwal = msg.rows;

			//HEADER
			for(var i = 0 ; i < msg.rows.length; i++)
			{
				if(oldtanggal != msg.rows[i].tanggal && i == 0)
				{
					oldtanggal = msg.rows[i].tanggal;
					content += "<table id='table_wa' class='table table-striped table-hover display nowrap' width='100%'>\
									<tr>\
										<td colspan='4' style='font-weight:bold; font-size:16pt; background:yellow;'>PELAYANAN UMUM <span style='font-size:16pt; float:right'>"+$.datepicker.formatDate('dd / MM / yy', new Date(oldtanggal))+"</span></td>\
									</tr>\
									<tr>\
										<td style='width:15px; vertical-align:middle;'>"+msg.rows[i].namajenispelayanan+"</td>\
										<td style='width:5px;  vertical-align:middle'>:</td>\
										<td style='vertical-align:middle'>"+msg.rows[i].panggilan+" "+msg.rows[i].namapelayan+"</td>\
										<td style='width:100px; text-align:right;  vertical-align:middle'><button class='btn btn-kirim-"+i+"' style='width:120px;'  onclick='kirimWA("+i+")'></button></td>\
									</tr>\
					";
				}
				else if(oldtanggal != msg.rows[i].tanggal)
				{
					oldtanggal = msg.rows[i].tanggal;
					content += "</table>\
								<table id='table_wa' class='table table-striped table-hover display nowrap' width='100%'>\
									<tr>\
										<td colspan='4' style='font-weight:bold; font-size:16pt; background:yellow;'>PELAYANAN UMUM <span style='font-size:16pt; float:right'>"+$.datepicker.formatDate('dd / MM / yy', new Date(oldtanggal))+"</span></td>\
									</tr>\
									<tr>\
										<td style='width:15px;  vertical-align:middle'>"+msg.rows[i].namajenispelayanan+"</td>\
										<td style='width:5px;  vertical-align:middle'>:</td>\
										<td style='vertical-align:middle'>"+msg.rows[i].panggilan+" "+msg.rows[i].namapelayan+"</td>\
										<td style='width:100px; text-align:right;  vertical-align:middle'><button class='btn btn-kirim-"+i+"' style='width:120px;' onclick='kirimWA("+i+")'></button></td>\
									</tr>\
					";
				}
				else
				{
					content += "<tr>\
									<td style='width:15px;  vertical-align:middle'>"+msg.rows[i].namajenispelayanan+"</td>\
									<td style='width:5px;  vertical-align:middle'>:</td>\
									<td style='vertical-align:middle'>"+msg.rows[i].panggilan+" "+msg.rows[i].namapelayan+"</td>\
									<td style='width:100px; text-align:right;  vertical-align:middle'><button class='btn btn-kirim-"+i+"' style='width:120px;' onclick='kirimWA("+i+")'></button></td>\
								</tr>\
					";
				}

				
			}
			
			content += "</table>";
			
			$(".modal-wapelayan").html(content);

			for(var i = 0 ; i < msg.rows.length; i++)
			{
				if(msg.rows[i].telp == "" || msg.rows[i].telp == null){
					$(".btn-kirim-"+i).addClass('btn-danger');
					$(".btn-kirim-"+i).text("Tidak Ada Telp");
					$(".btn-kirim-"+i).removeAttr("onclick");
				}
				else
				{
					$(".btn-kirim-"+i).addClass('btn-success');
					$(".btn-kirim-"+i).text("Kirim Whatsapp");
				}
			}
			
		}	
	});

	$("#modal-sendWA").modal('show');
}

function kirimWA(i){
	$(".btn-kirim-"+i).removeClass('btn-success');

	$(".btn-kirim-"+i).addClass('btn-warning');

	$(".btn-kirim-"+i).text("Sudah Terkirim");

	var text = "Shallom bagi Rekan-Rekan Sepelayanan <?=$_SESSION[NAMAPROGRAM]['NAMAGEREJA']?>, %0A\
				kami selaku Koordinator Praise And Worship ingin bertanya. %0A\
				Apakah "+dataJadwal[i].panggilan+" "+dataJadwal[i].namapelayan+" bersedia untuk melayani *"+dataJadwal[i].namajenispelayanan+"* %0A\
				pada *Hari Minggu* tanggal *"+$.datepicker.formatDate('dd / MM / yy', new Date(dataJadwal[i].tanggal))+"* ?%0A%0A\
				"+dataJadwal[i].catatan+"";

	window.open("https://wa.me/"+dataJadwal[i].telp+"?text="+text,"_blank")
	
}

function simpan(statusSimpan) {
	
	$("#sb_bulan").removeAttr('disabled');
	$("#txt_tahun").removeAttr('disabled');
	
	var table = $('#datagridDetail').DataTable();
	
	var rows = table.rows().data().toArray();
	
	$("#DATAPELAYAN").val(JSON.stringify(rows));
	
	$('#BULANANGKA').val($('#sb_bulan').datepicker('getDate').getMonth()+1);
	
	$('#SIMPAN').val(statusSimpan);
	
	if (1) {
		mode = $('[name=mode]').val();
        
        $.ajax({
            type      : 'POST',
            url       : base_url+'JadwalPelayanan/simpan',
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
                    location.reload();
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

function hapus(row){
	Swal.fire({
		title: 'Anda Yakin Akan Menghapus Jadwal '+row.bulan+' '+row.tahun+' ?',
		showCancelButton: true,
		confirmButtonText: 'Yakin',
		cancelButtonText: 'Tidak',
		}).then((result) => {
		/* Read more about isConfirmed, isDenied below */
			if (result.value) {
				$("#mode").val('hapus');
				if (row) {
					$.ajax({
						type    : 'POST',
						dataType: 'json',
						url     : base_url+"JadwalPelayanan/batal",
						data    : "id="+row.idjadwal,
						cache   : false,
						success : function(msg){
							if (msg.success) {
								Swal.fire({
									title            : 'Jadwal '+row.bulan+' '+row.tahun+' telah dihapus',
									type             : 'success',
									showConfirmButton: false,
									timer            : 3000
								});
								$("#dataGrid").DataTable().ajax.reload();
								$('.nav-tabs a[href="#tab_grid"]').tab('show');
							} else {
									Swal.fire({
										title            : msg.errorMsg,
										type             : 'error',
										showConfirmButton: false,
										timer            : 3000
									});
							}
						}
					});
				}
			} 
	})
	
}

function setDatagridDetail(){
	var bulan = $.datepicker.formatDate('MM', $("#sb_bulan").datepicker('getDate'));
	var bulan_angka = $('#sb_bulan').datepicker('getDate').getMonth()+1;
	var tahun = $("#txt_tahun").val();
	 $(".keteranganbulantahun").html(bulan+" "+tahun);
	 
	 $.ajax({
		type      : 'POST',
		url       : base_url+'JadwalPelayanan/dataGridDetail',
		data      : {bulan:$.datepicker.formatDate('MM', $("#sb_bulan").datepicker('getDate')),tahun:$("#txt_tahun").val()},
		dataType  : 'json',
		beforeSend: function (){
			//$.messager.progress();
		},
		success: function(msg){
		
			var content;
			var oldtanggal = "";
			
			content += "<tr>";
			
			content += "<th align='center'>Tanggal</th>";
			//HEADER
			for(var i = 0 ; i < msg.rows.length; i++)
			{
				if(oldtanggal != msg.rows[i].tanggal && oldtanggal == "")
				{
					
					oldtanggal = msg.rows[i].tanggal;
					content += "<th align='center'>"+msg.rows[i].namajenispelayanan+"</th>";
				}
				else if( oldtanggal == msg.rows[i].tanggal)
				{
					content += "<th align='center'>"+msg.rows[i].namajenispelayanan+"</th>";
				}
			}
			
			content += "<th align='center'>ALASAN IBADAH DITIADAKAN</th>";
			
			content += "</tr>";
			
			$("#head").html(content);
			
			content = "";
			
			oldtanggal = "";
			
			var x=-1;
			var y=1;
			
			//DETAIL
			for(var i = 0 ; i < msg.rows.length; i++)
			{
				if(msg.rows[i].catatandetail == "")
				{
				    msg.rows[i].catatandetail = "-";
				}
				
				if(oldtanggal != msg.rows[i].tanggal )
				{
					x++;
					if(i != 0)
					{
					    content += "<td id='"+oldtanggal+"' class='"+(x-1)+"_alasanvalue' >"+msg.rows[i-1].catatandetail+"</td>";
						content += "</tr>";
					}
					y=1;
					
					oldtanggal = msg.rows[i].tanggal;
					
				
					content += "<tr id='"+x+"'><td>"+$.datepicker.formatDate('dd / MM / yy', new Date(msg.rows[i].tanggal))+"</td>";
					
					var namajenispelayanan = msg.rows[i].namajenispelayanan.replaceAll(' ', '_');
					content += "<td id='"+namajenispelayanan+"' class='"+x+"_"+y+"_"+msg.rows[i].idjenispelayanan+"_"+msg.rows[i].idpelayan+"'>"+msg.rows[i].namapelayan+"</td>";
				}
				else
				{
					y++;
					var namajenispelayanan = msg.rows[i].namajenispelayanan.replaceAll(' ', '_');
					content += "<td id='"+namajenispelayanan+"' class='"+x+"_"+y+"_"+msg.rows[i].idjenispelayanan+"_"+msg.rows[i].idpelayan+"'>"+msg.rows[i].namapelayan+"</td>";
				}
			}
			content += "<td id='"+oldtanggal+"' class='"+x+"_alasanvalue' >"+msg.rows[msg.rows.length-1].catatandetail+"</td>";
			content +="</tr>";
			
			$("#body").html(content);
			
			
			for(var i = 0 ; i <= x ; i++)
			{
				//AMBIL NAMAPELAYANKEMBAR
				var listnamapelayan = [];
				var tableData = $('table#datagridDetail tr#'+i).find('td');
				if (tableData.length > 0) {
					tableData.each(function() { 
						listnamapelayan.push($(this).text());
					});
				}
				
				var tableData = $('table#datagridDetail tr#'+i).find('td');
				if (tableData.length > 0) {
					tableData.each(function() { 
						$(this).css('background','');
						if(listnamapelayan.filter(x => x == $(this).text()).length > 1)
						{
							$(this).css('background','orange');
						}
					});
				}
			}
			
		}	
	});
	
}

function generate(){
	var bulan = $.datepicker.formatDate('MM', $("#sb_bulan").datepicker('getDate'));
	var bulan_angka = $('#sb_bulan').datepicker('getDate').getMonth()+1;
	var tahun = $("#txt_tahun").val();
	var tglpengecualian =  $('#tglpengecualian').val();

	 $.ajax({
		type      : 'POST',
		url       : base_url+'JadwalPelayanan/generateDatagrid',
		data      : {bulan:bulan_angka,tahun:tahun, tanggalselainminggu : tglpengecualian},
		dataType  : 'json',
		beforeSend: function (){
			//$.messager.progress();
		},
		success: function(msg){
			
			if(msg.errorMsg == null){
				$(".keteranganbulantahun").html(bulan+" "+tahun);
	 
				var content;
				var oldtanggal = "";
				
				content += "<tr>";
				
				content += "<th align='center'>Tanggal</th>";
				//HEADER
				for(var i = 0 ; i < msg.rows[0].length; i++)
				{
					
					content += "<th align='center'>"+ msg.rows[0][i].namajenispelayanan+"</th>";
					
				}
				content += "<th align='center'>ALASAN IBADAH DITIADAKAN</th>";
				content += "</tr>";
				
				$("#head").html(content);
				
				content = "";
				
				//DETAIL
				for(var i = 0 ; i < msg.rows.length; i++)
				{
					content += "<tr id='"+i+"'>";
					
					var d = msg.rows[i][0].tanggal.split("-")[2]+" / "+bulan+" / "+tahun;
					
					content += "<td id='TANGGAL' class='"+d+"'>"+ d+"</td>";
					for(var j = 0 ; j < msg.rows[i].length; j++)
					{
						var namajenispelayanan = msg.rows[i][j].namajenispelayanan.replaceAll(' ', '_');
						content += "<td style='background:"+msg.rows[i][j].warna+";' id='"+namajenispelayanan+"' class='"+i+"_"+j+"_"+msg.rows[i][j].idjenispelayanan+"_"+msg.rows[i][j].idpelayan+"'>"+ msg.rows[i][j].namapelayan+"</td>";
					}
					
					content += "<td id='"+msg.rows[i][0].tanggal+"' class='"+i+"_alasanvalue' >-</td>";
						
					content += "</tr>";
				}
				
				$("#body").html(content);
			}
			else
			{
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

function resetForm() {
		 
	$("#sb_bulan").datepicker('setDate', $.datepicker.formatDate('MM',new Date())).removeAttr('disabled');
	$("#txt_tahun").datepicker('setDate', new Date()).removeAttr('disabled');
	
	$("#tglpengecualian").datepicker('setDate',"").removeAttr('disabled');
	
	$("#CATATAN").val('');
	
	var bulan = $.datepicker.formatDate('MM', $("#sb_bulan").datepicker('getDate'));
	var tahun = $("#txt_tahun").val();
	$(".keteranganbulantahun").html('Jadwal Bulan');
	$('#btn_generate').css('filter', ''); 
	$('#btn_generate').attr('onClick','generate()');
	
	$("#head").html('');
	$("#body").html('');
}

</script>