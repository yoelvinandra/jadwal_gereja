<!DOCTYPE html>
<html>

<head>
	<style type="text/css">
		.main-header {
			background-image: url(<?php echo base_url(); ?>.'assets/images/depan_sc.jpg');
			background-repeat: no-repeat;
			background-position: center;
			background-size: cover;
			width: 100%;
			height: 100%;
		}
	</style>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Jadwal Pelayanan | Log in</title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

</head>

<body class="hold-transition login-page" style="background-image:url('<?php echo base_url(); ?>assets/images/background.jpg');background-repeat: no-repeat; background-position: center; background-size: cover;">
	<?php
	if (isset($errMsg)) {
		echo '<script>alert(\'' . $errMsg . '\')</script>';
	}
	?>

	<div class="login-box" style="margin: 0 auto;transform: translateY(calc((100vh - 100%) / 2));">
		<div class="login-box-body">
			<p class="login-box-msg" style="font-weight:bold; font-size:16pt;">Shallom, Rekan Sepelayanan</p>
            
             <form method='post' target="" action='<?=base_url()?>Guest/lihatJadwal' id="form_input">
                    <table width="100%">
                        <tr>
                            <td width="30%">Pilih Jadwal</td>
                            <td>
                                <select id="namagereja" name="namagereja"  class="form-control select2" width="100%" style="width:100%;">
                			        <option value="">-Pilih-</option>
                			        <option value="umumgbias">Jadwal Umum</option>
                			        <option value="youthgbias">Jadwal Youth</option>
                			        <option value="smgbias">Jadwal Sekolah Minggu</option>
                			    </select>
                            </td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td width="30%">Siapa Anda</td>
                            <td>
                                <select id="namapelayan" name="idpelayan"  class="form-control select2" width="100%" style="width:100%;">
                                     <option value="">-Pilih-</option>
                			    </select>
                            </td>
                        </tr>
                    </table>
                    <br>
        			<div class="row">
        				<div class="col-xs-12">
        					<div id="btn_lihat" class="btn btn-primary btn-block btn-flat">Lihat Jadwal Pelayanan</div>
        				</div>
        				<!-- /.col -->
        			</div>
        			<br>
        			<div class="row">
        				<div class="col-xs-12">
        					<div id="btn_admin" class="btn btn-success btn-block btn-flat">Saya Admin</div>
        				</div>
        				<!-- /.col -->
        			</div>
        			
        	</form>
		</div>
		<!-- /.login-box-body -->
	</div>
	<!-- /.login-box -->
	
	<script>
	
        $(document).ready(function(){
            $('.select2').select2({
        		  theme: "classic"
        	});
        });
	    
        var base_url = '<?= base_url(); ?>';
		
		$('#namagereja').change(function(e){
			cekData();
		});
		
		$("#btn_lihat").click(function(){
		    //|| $("#namapelayan").val() == ""
		    if($("#namagereja").val() == "")
		    {
		        Swal.fire({
					title: "Jadwal Harus Dipilih",
					type: 'warning',
					showConfirmButton: false,
					timer: 15000000000
				});
		    }
		    else
		    {
		        $('#form_input').submit();
		    }
		});
		
		$("#btn_admin").click(function(){
		     window.location.replace("<?php echo base_url(); ?>Login");
		     return false;
		});
		
		function cekData(){
			$.ajax({
				type: 'POST',
				url: '<?php echo base_url(); ?>Login/cekLogin/',
				data: {
					namagereja: $("#namagereja").val(),
				},
				dataType: 'json',
				success: function(msg) {
					if (msg.success) {
					    $.ajax({
            				type: 'POST',
            				url: '<?php echo base_url(); ?>Pelayan/dataGrid/',
            				dataType: 'json',
            				success: function(msg) {
            					$("#namapelayan").html('');
            					$("#namapelayan").append("<option value=''>-Pilih-</option>");
            					for(var x = 0 ; x < msg.rows.length;x++)
            					{
            					    if(msg.rows[x].status == 1)
            					    {
            					        $("#namapelayan").append("<option value='"+msg.rows[x].idpelayan+"'>"+msg.rows[x].panggilan+" "+msg.rows[x].namapelayan+"</option>");
            					    }
            					}
            				}
            			});
					} else {
						Swal.fire({
							title: msg.errorMsg,
							type: 'error',
							showConfirmButton: false,
							timer: 15000000000
						});
					}
				}
			});
		}
		
	</script>
</body>

</html>