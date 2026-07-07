
<!-- Content Header (Page header) -->
<section class="content-header">
	<div class="row">
		<div class="col-md-1 col-xs-1" style="text-align='center'">
			<button class="btn" style="background:#333;color:white;" data-toggle="modal" data-target="#modal-menu"><i class='fa fa-navicon'></i></button>
		</div>
		<div class="col-md-10 col-xs-10" style="font-size:20pt;">
			Jenis Pelayanan
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
                                    <th width="90%">Nama</th>
                                    <th width="10%">Aktif</th>
                                    <th width="10%"></th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <!-- /.tab-pane -->
                <div class="tab-pane" id="tab_form">
                    <div class="box-body">
                        <div class="col-md-6">
                        <!-- form start -->
                        <form role="form" id="form_input">
                            <input type="hidden" id="mode" name="mode">
                            <input type="hidden" id="IDJENISPELAYANAN" name="IDJENISPELAYANAN">
                            <div class="box-body">
									
									<label>Nama Jenis Pelayanan  &nbsp; &nbsp; <input type="checkbox" class="flat-blue" id="STATUS" name="STATUS" value="1">&nbsp; Aktif &nbsp;&nbsp;&nbsp; </label>
                                    <input type="text" class="form-control" id="NAMAJENISPELAYANAN" name="NAMAJENISPELAYANAN" placeholder="Nama Jenis Pelayanan">
                                    <br>
									
									<label>Urutan Tampilan</label>
                                    <input type="number" class="form-control" id="URUTAN" name="URUTAN" placeholder="Urutan">
                                    <br>
                                    
                                </div>
							</div>
                            <!-- /.box-body -->
							<div class="box-footer col-md-11">
							&nbsp;
							</div>
                            <div class="box-footer col-md-1">
                                <button type="button" id="btn_simpan" class="btn btn-primary" onclick="javascript:simpan()">Simpan</button>
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

</section>
<!-- /.content -->

<script>
var oldJenisLokasi = "";
var base_url = '<?=base_url()?>';

var iddetail = "";
var classdetail = "";

$(document).ready(function() {
    $("#mode").val('tambah');
    $("#STATUS").prop('checked',true).iCheck('update');
	
	 $('#dataGrid').DataTable({
        'paging'      : true,
        'lengthChange': true,
        'searching'   : true,
        'ordering'    : true,
        'info'        : true,
        'autoWidth'   : false,
		"scrollX"	  : true,
		ajax		  : {
			url    : base_url+'JenisPelayanan/dataGrid',
			dataSrc: "rows",
		},
        columns:[
            {data: 'idjenispelayanan', visible:false},
            {data: 'namajenispelayanan', className:"text-center"},
            {data: 'status', className:"text-center" },
			{data: ''},
        ],
		columnDefs: [ 
			{
                "targets": -1,
                "data": null,
                "defaultContent": "<button id='btn_ubah' class='btn btn-primary'><i class='fa fa-edit'></i></button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button id='btn_hapus' class='btn btn-danger'><i class='fa fa-trash' aria-hidden='true' ></button>"	
			},
			{
                "targets": 2,
                "render" :function (data) 
                        {
                            if (data == 1) return 'YA';
                            else return 'TIDAK';
                        },	
			},
		],
    });  
	
    //DAPATKAN INDEX
	$('#dataGrid tbody').on( 'click', 'button', function () {
		var table = $('#dataGrid').DataTable();
		var row = table.row( $(this).parents('tr') ).data();
		var mode = $(this).attr("id");
		
		if(mode == "btn_ubah"){ ubah(row); }
		else if(mode == "btn_hapus"){ hapus(row); }
	});
	
});

function tambah(){
	$("#mode").val('tambah');
	
	//pindah tab & ganti judul tab
	$('.nav-tabs a[href="#tab_form"]').tab('show');
	$('.nav-tabs a[href="#tab_form"]').html('TAMBAH');
	
	resetForm($("#form_input"));
	
	$.ajax({
            type      : 'POST',
            url       : base_url+'JenisPelayanan/getUrutan',
            dataType  : 'json',
            beforeSend: function (){
                //$.messager.progress();
            },
            success: function(msg){
                $("#URUTAN").val(msg.rows.URUTAN);
            }
      });
	
}

function ubah(row){
	$("#mode").val('ubah');
	//pindah tab & ganti judul tab
	$('.nav-tabs a[href="#tab_form"]').tab('show');
	$('.nav-tabs a[href="#tab_form"]').html('UBAH');
	
	if(row.status == 1){
		$("#STATUS").prop('checked',true).iCheck('update');
	}
	else
	{
		$("#STATUS").prop('checked',false).iCheck('update');
	}
	
	$("#IDJENISPELAYANAN").val(row.idjenispelayanan);
	$("#NAMAJENISPELAYANAN").val(row.namajenispelayanan);
	$("#URUTAN").val(row.urutan);
}

function simpan() {
	
	if (1) {
		mode = $('[name=mode]').val();
        
        $.ajax({
            type      : 'POST',
            url       : base_url+'JenisPelayanan/simpan',
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
                    $("#dataGrid").DataTable().ajax.reload();
                    tambah();
                    $('.nav-tabs a[href="#tab_grid"]').tab('show');
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
		title: 'Anda Yakin Akan Menghapus Jenis Pelayanan '+row.namajenispelayanan+' ?',
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
                        url     : base_url+"JenisPelayanan/batal",
                        data    : "id="+row.idjenispelayanan,
                        cache   : false,
                        success : function(msg){
                            if (msg.success) {
                                Swal.fire({
                                    title            : row.namajenispelayanan+' telah dihapus',
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

function resetForm($form) {
    $form.find('input:text, input:password, input:file, select, textarea').val('');
    $form.find('input:radio, input:checkbox')
         .removeAttr('checked').removeAttr('selected');
	
	$(".select2").select2().val('').trigger('change.select2')
}

</script>