<style>    
    html{
        overflow-x:hidden;
    }
    #dataGrid tr td {
        white-space: pre-wrap !important; /* Maintains whitespace and allows wrapping */
        word-wrap: break-word  !important; /* Breaks long words */
        overflow: hidden  !important; /* Hides overflow */
    }
    .main-button {
      border: 0;
      cursor: pointer;
      position:relative;
      &:after {
        background-color: #C4D7FF;
        font-weight:bold;
        content: '';
        display:block;
        width:100%;
        height:100%;
        position:absolute;
        top:0;
        left:0;
        animation-name: blink;
        animation-duration: 1s;
        animation-iteration-count: infinite;
        animation-direction: alternate-reverse;
        animation-timing-function: cubic-bezier(0.19, 1, 0.22, 1);
      }
}

@keyframes blink {
  0% {
    transform:scale3d(1,1,1);
    opacity: 0.8;
  }
  100% {
    transform:scale3d(1.1,1.3,1.1);
    opacity:0;
  }
}
</style>
<!-- Content Header (Page header) -->
<section class="content-header">
	<div class="row">
		<div class="col-md-9 col-xs-9" style="font-size:20pt;"> 
		<?php if($menu == 1){ ?>
		<button class="btn" style="background:#333;color:white;" data-toggle="modal" data-target="#modal-menu"><i class='fa fa-navicon'></i></button>
		&nbsp;
		&nbsp;
		<?php } ?>
		<img src="<?=base_url()."/assets/images/logo.jpeg"?>" width="150px">
		</div>
		<div class="col-md-3 col-xs-3 " style="margin-top:8px;">
		    <button class="btn btn-primary pull-right" id="btn_live" onclick="javascript:live()" style="font-weight:bold; font-size:18pt;">LIVE </button>
		    <button class="btn btn-primary pull-right" style="background:black; color:white; font-size:18pt; margin-right:10px;" onclick="javascript:blank()">Blank </button>
		</div>
	</div>
</section>

<!-- Main content -->
<section class="content">
    
    <!-- Main row -->
    <div class="row">
        <div class="col-md-4" style="padding:4px;">
            <div class="box">
            <!-- Custom Tabs -->
            <div class="nav-tabs-custom" >
                <br>
                <ul class="nav nav-tabs" id="tab_transaksi">
                    <li class="active"><a href="#tab_grid" data-toggle="tab" ><label style="font-size:16pt;">Data Lagu</label></a></li>
                    <li><a href="#tab_form" data-toggle="tab"></a></li>
                    <li style="float:right">
                        <button class="btn btn-success" style="margin-top:2px;" onclick="javascript:tambah()">Tambah Lagu</button>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_grid">
                        <div class="box-body"  style="padding:0px;">
                            <table id="dataGrid" class="table table-bordered table-striped table-hover display nowrap" width="100%">
                                <!-- class="table-hover"> -->
                                <thead>
                                    <tr>
                                        <th>ID</th>        
                                        <th>Lirik</th>       
                                        <th>Penyanyi</th>            
                                        <th>Judul</th>
                                        <th>Lirik</th>
                                        <th width="82px;"></th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="tab_form">
                        <div class="box-body">
                            <div class="col-md-12">
                            <span style="float:right;"> <button type="button" id="btn_lihat_langsung" class="btn btn-warning" onclick="javascript:tampilkanInstant()"><i class='fa fa-eye'></i></button></span>
                            <br>
                            <!-- form start -->
                            <form role="form" id="form_input">
                                <input type="hidden" id="mode" name="mode">
                                <input type="hidden" id="IDLAGU" name="IDLAGU">
                                <div class="box-body">
    									
    									<label>Judul</label>
                                        <input type="text" class="form-control" id="NAMALAGU" name="NAMALAGU" placeholder="Ex : Terima Kasih Tuhan">
                                        <br>
    									
                                        <label>Penyanyi</label>
                                        <input type="text" class="form-control" id="NAMAPENYANYI" name="NAMAPENYANYI" placeholder="Ex : Sidney Mohede">
                                        <br>
    									
                                        <label>Lirik</label>
                                        <textarea class="form-control" rows="20" id="LIRIK" name="LIRIK" placeholder="Terima Kasih Tuhan Untuk ...."></textarea>
                                        <br>
    							
        							<div class="col-md-12" style="padding:0px;">
        							    <button type="button" style="float:left" id="btn_hapus" class="btn btn-danger" onclick="javascript:hapus()">Hapus Lagu</button>
        							    <button type="button"  style="float:right" id="btn_simpan" class="btn btn-primary" onclick="javascript:simpan()">Simpan Lagu</button>
                                    </div>
    							</div>
                            </form>
                         </div>
                        </div>
                    </div>
                    <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
            </div>
            <!-- nav-tabs-custom -->
            </div>
        </div>
        <div class="col-md-5" style="padding:4px;">
            <div class="box">
                <br>
                <div>
                    <label style="font-size:16pt;">&nbsp;&nbsp;Daftar</label> &nbsp;&nbsp;&nbsp;
						<select class="form-control select2"id="CB_LIST_LAGU" name="cb_list_lagu" placeholder="List Lagu" style="width:180px;">
						    <option value="0" selected="selected">-- BUAT LIST BARU --</option>
								<?=comboGridListLagu("model_master_lagu")?>
						</select>
						<select class="form-control select2"id="ukuranfont" name="ukuranfont" placeholder="List Font" style="width:100px;">
						</select>
					
                    <button class="btn btn-success" style="margin-left:5px;" onclick="javascript:simpanListLagu()">Simpan Daftar</button>
                    
                 	<button class="btn btn-warning" style="float:right; margin-top:3px; margin-right:8px;" onclick="javascript:tampilanLaguTerakhir()"><i class='fa fa-eye'></i></button>
            </div>
            <br>
            <div class="box-body"  style="height:350px; overflow-y:scroll; overflow-x:hidden;">
                     <div id="spaceListLagu" style="height:30px;">&nbsp;</div>
					 <button type="button" id="btn_hapus_list_lagu" class="btn btn-danger" onclick="javascript:hapusListLagu()">Hapus Daftar</button>
					 <div style="margin-top:-35px;" >
                            <table id="dataGridListLagu" class="table table-bordered table-striped table-hover display nowrap" width="100%">
                                <!-- class="table-hover"> -->
                                <thead>
                                    <tr>
                                        <th width="5%"></th>
                                        <th>ID</th>        
                                        <th>ID</th> 
                                        <th>Lirik</th>
                                        <th>Tanggal</th>                     
                                        <th width="70%">Judul</th>
                                        <th>Penyanyi</th>
                                    </tr>
                                </thead>
                            </table>
                    </div>
                 </div>
            <!-- nav-tabs-custom -->
            </div>
                 	 <div style="text-align:center; margin-top:-10px; margin-bottom:10px;">
                 	     <i>*Geser Lagu, untuk merubah urutan</i>
                 	     </div>
            <div>
             <hr>
            <div>
                    <label style="font-size:16pt;">&nbsp;&nbsp;Alkitab</label> &nbsp;&nbsp;&nbsp;
						<select class="form-control select2"id="CB_LIST_ALKITAB" name="cb_list_alkitab" placeholder="List Alkitab" style="width:180px;">
						    <option value="0" selected="selected">-- CARI KITAB --</option>
								<?=comboGrid("model_master_alkitab")?>
						</select>
						<select class="form-control select2"id="ukuranfontalkitab" name="ukuranfontalkitab" placeholder="List Font" style="width:100px;">
						</select>
						&nbsp;
                        <button class="btn btn-success" id="TAMBAHKANDAFTARKITAB" onclick="javascript:tambahkanAyatDaftar()">Tambah Daftar</button>
                        
						<button class="btn btn-warning" style="float:right; margin-top:3px; margin-right:8px;" onclick="javascript:tampilanKitabTerakhir()"><i class='fa fa-eye'></i></button>
            </div>
			<div id="pasal_ayat" style="margin-left:10px; font-size:18pt; font-weight:bold; margin-top:10px; margin-bottom:10px;">
			    
			</div>
            <div class="box-body" style="height:190px; overflow-y:scroll;overflow-x:hidden;">
                <div id="alkitab_title"  style="float:left; ">
                        
                </div>
                <div id="alkitab_value" style="float:left; margin-left:30px;">
                    
                </div>
				 <!-- ISI DISINI-->
            </div>
            <!-- nav-tabs-custom -->
            </div>
        </div>
        <div class="col-md-3" style="padding:4px;">
            <div class="box">
                <br>
                <label id="NAMECHOOSE" style="font-size:16pt;">[Judul Lagu / Kitab]</label>
                <br>
                <div id="SINGERCHOOSE"  style="font-size:14pt;"></div>
                <i>*Naik tekan <b>Page Up</b>, Turun tekan <b>Page Down</b></i>
            </div>
             <div class="box-body lirik-body" style="height:350px; overflow-y:auto;overflow-x:hidden;" >
                <div id="LIRIKCHOOSE" >
                    
                </div>
				 <!-- ISI DISINI-->
            </div>
        </div>
        <div class="col-md-3">
            <hr>
            <div style="background:white; text-align:center;">
            <i id="caption-layar"></i>
            <br><br>
            <div id="mini-screen" style="overflow-y:hidden;overflow-x:hidden; background:black; margin:auto;" >
            </div>
        </div>
        </div>
    <!-- /.col -->
    </div>
    <!-- /.row (main row) -->
</section>
<!-- /.content -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lz-string/1.5.0/lz-string.min.js" integrity="sha512-qtX0GLM3qX8rxJN1gyDfcnMFFrKvixfoEOwbBib9VafR5vbChV5LeE5wSI/x+IlCkTY5ZFddFDCCfaVJJNnuKQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>

var oldJenisLokasi = "";
var base_url = '<?=base_url()?>';

var iddetail = "";
var idlistlagu = 0;
var namalistlagu = "-- BUAT LIST BARU --";
var classdetail = "";
var newTab;
var liveTab = false;
var batasTeks = 235; //360
var fontSizeLagu = 25;
var fontSizeAlkitab = 20; // 20
var fontSizeMiniScreen = fontSizeLagu;
var alkitab = [];
var alkitab2 = [];
var alkitab3 = [];
var alkitab4 = [];
var alkitab5 = [];
var alkitab6 = [];

var lebarLayar = 1024;
var tinggiLayar = 768;
    
    $("#caption-layar").html("*Untuk hasil maksimal, pastikan layar extend berukuran <b>"+lebarLayar+" x "+tinggiLayar+"</b>");
    $('#CB_LIST_ALKITAB').on('select2:open', function () {
      let searchBox = document.querySelector('.select2-container--open .select2-search__field');

      if (searchBox) {
        searchBox.addEventListener('input', function () {
          var text = searchBox.value;
          if(text.includes(" "))
          {
              if(text.split(" ").length == 3 && text.split(" ")[2] != "")
              {
                   var values = $('#CB_LIST_ALKITAB option').map(function() {
                    if($(this).val().split("-")[2] == text.split(" ")[0].toUpperCase()+" "+text.split(" ")[1].toUpperCase())
                    {
                        namakitab = $(this).text();
	                    namakitabSingkatan = $(this).val().split("-")[2];
                        idkitab = parseInt($(this).val().split("-")[0]);
                        
                        clickPasal(text.split(" ")[2].split(":")[0]);
                    }
                  }).get();
              }
              else if(text.split(" ").length == 2 && text.split(" ")[1] != "")
              {
                   var values = $('#CB_LIST_ALKITAB option').map(function() {
                    if($(this).val().split("-")[2] == text.split(" ")[0].toUpperCase())
                    {
                        namakitab = $(this).text();
	                    namakitabSingkatan = $(this).val().split("-")[2];
                        idkitab = parseInt($(this).val().split("-")[0]);
                        
                        clickPasal(text.split(" ")[1].split(":")[0]);
                    }
                  }).get();
              }
              if(text.split(":").length == 2  && text.split(":")[1] != "")
              {
                clickAyat(parseInt(text.split(":")[1])-1);
              }
          }
        });
      }
    });

    if(localStorage.getItem("Alkitab") == null || localStorage.getItem("Alkitab2") == null || localStorage.getItem("Alkitab3") == null  || localStorage.getItem("Alkitab4") == null  || localStorage.getItem("Alkitab5") == null  || localStorage.getItem("Alkitab6") == null)
    {
        alkitab = [
        <?php 
            for ($x = 0 ; $x < intval((count($_SESSION[NAMAPROGRAM]['ALKITAB']) / 6)) ;$x++)
            {
                $_SESSION[NAMAPROGRAM]['ALKITAB'][$x]->text = str_replace("'","_",$_SESSION[NAMAPROGRAM]['ALKITAB'][$x]->text);
                 $_SESSION[NAMAPROGRAM]['ALKITAB'][$x]->text = str_replace('"','+',$_SESSION[NAMAPROGRAM]['ALKITAB'][$x]->text);
        ?>
            {
                'urutankitab'   : '<?=$_SESSION[NAMAPROGRAM]['ALKITAB'][$x]->urutankitab?>',
                'pasal'         : '<?=$_SESSION[NAMAPROGRAM]['ALKITAB'][$x]->pasal?>',
                'ayat'          : '<?=$_SESSION[NAMAPROGRAM]['ALKITAB'][$x]->ayat?>',
                'text'          : '<?=$_SESSION[NAMAPROGRAM]['ALKITAB'][$x]->text?>',
            },
        <?php    
            }
        ?>
        ];
        
        alkitab2 = [
        <?php 
            for ($x = intval((count($_SESSION[NAMAPROGRAM]['ALKITAB']) / 6)) ; $x < intval(count($_SESSION[NAMAPROGRAM]['ALKITAB']) / 6 * 2);$x++)
            {
                $_SESSION[NAMAPROGRAM]['ALKITAB'][$x]->text = str_replace("'","_",$_SESSION[NAMAPROGRAM]['ALKITAB'][$x]->text);
                 $_SESSION[NAMAPROGRAM]['ALKITAB'][$x]->text = str_replace('"','+',$_SESSION[NAMAPROGRAM]['ALKITAB'][$x]->text);
        ?>
            {
                'urutankitab'   : '<?=$_SESSION[NAMAPROGRAM]['ALKITAB'][$x]->urutankitab?>',
                'pasal'         : '<?=$_SESSION[NAMAPROGRAM]['ALKITAB'][$x]->pasal?>',
                'ayat'          : '<?=$_SESSION[NAMAPROGRAM]['ALKITAB'][$x]->ayat?>',
                'text'          : '<?=$_SESSION[NAMAPROGRAM]['ALKITAB'][$x]->text?>',
            },
        <?php    
            }
        ?>
        ];
        
        alkitab3 = [
        <?php 
            for ($x = intval((count($_SESSION[NAMAPROGRAM]['ALKITAB']) / 6 * 2)) ; $x < intval(count($_SESSION[NAMAPROGRAM]['ALKITAB']) / 6 *3);$x++)
            {
                $_SESSION[NAMAPROGRAM]['ALKITAB'][$x]->text = str_replace("'","_",$_SESSION[NAMAPROGRAM]['ALKITAB'][$x]->text);
                 $_SESSION[NAMAPROGRAM]['ALKITAB'][$x]->text = str_replace('"','+',$_SESSION[NAMAPROGRAM]['ALKITAB'][$x]->text);
        ?>
            {
                'urutankitab'   : '<?=$_SESSION[NAMAPROGRAM]['ALKITAB'][$x]->urutankitab?>',
                'pasal'         : '<?=$_SESSION[NAMAPROGRAM]['ALKITAB'][$x]->pasal?>',
                'ayat'          : '<?=$_SESSION[NAMAPROGRAM]['ALKITAB'][$x]->ayat?>',
                'text'          : '<?=$_SESSION[NAMAPROGRAM]['ALKITAB'][$x]->text?>',
            },
        <?php    
            }
        ?>
        ];
        
        alkitab4 = [
        <?php 
            for ($x = intval((count($_SESSION[NAMAPROGRAM]['ALKITAB']) / 6 * 3)) ; $x < intval(count($_SESSION[NAMAPROGRAM]['ALKITAB']) / 6 *4);$x++)
            {
                $_SESSION[NAMAPROGRAM]['ALKITAB'][$x]->text = str_replace("'","_",$_SESSION[NAMAPROGRAM]['ALKITAB'][$x]->text);
                 $_SESSION[NAMAPROGRAM]['ALKITAB'][$x]->text = str_replace('"','+',$_SESSION[NAMAPROGRAM]['ALKITAB'][$x]->text);
        ?>
            {
                'urutankitab'   : '<?=$_SESSION[NAMAPROGRAM]['ALKITAB'][$x]->urutankitab?>',
                'pasal'         : '<?=$_SESSION[NAMAPROGRAM]['ALKITAB'][$x]->pasal?>',
                'ayat'          : '<?=$_SESSION[NAMAPROGRAM]['ALKITAB'][$x]->ayat?>',
                'text'          : '<?=$_SESSION[NAMAPROGRAM]['ALKITAB'][$x]->text?>',
            },
        <?php    
            }
        ?>
        ];
        
        alkitab5 = [
        <?php 
            for ($x = intval((count($_SESSION[NAMAPROGRAM]['ALKITAB']) / 6 * 4)) ; $x < intval(count($_SESSION[NAMAPROGRAM]['ALKITAB']) / 6 *5);$x++)
            {
                $_SESSION[NAMAPROGRAM]['ALKITAB'][$x]->text = str_replace("'","_",$_SESSION[NAMAPROGRAM]['ALKITAB'][$x]->text);
                 $_SESSION[NAMAPROGRAM]['ALKITAB'][$x]->text = str_replace('"','+',$_SESSION[NAMAPROGRAM]['ALKITAB'][$x]->text);
        ?>
            {
                'urutankitab'   : '<?=$_SESSION[NAMAPROGRAM]['ALKITAB'][$x]->urutankitab?>',
                'pasal'         : '<?=$_SESSION[NAMAPROGRAM]['ALKITAB'][$x]->pasal?>',
                'ayat'          : '<?=$_SESSION[NAMAPROGRAM]['ALKITAB'][$x]->ayat?>',
                'text'          : '<?=$_SESSION[NAMAPROGRAM]['ALKITAB'][$x]->text?>',
            },
        <?php    
            }
        ?>
        ];
        
        alkitab6 = [
        <?php 
            for ($x = intval((count($_SESSION[NAMAPROGRAM]['ALKITAB']) / 6 * 5)) ; $x < count($_SESSION[NAMAPROGRAM]['ALKITAB']);$x++)
            {
                $_SESSION[NAMAPROGRAM]['ALKITAB'][$x]->text = str_replace("'","_",$_SESSION[NAMAPROGRAM]['ALKITAB'][$x]->text);
                 $_SESSION[NAMAPROGRAM]['ALKITAB'][$x]->text = str_replace('"','+',$_SESSION[NAMAPROGRAM]['ALKITAB'][$x]->text);
        ?>
            {
                'urutankitab'   : '<?=$_SESSION[NAMAPROGRAM]['ALKITAB'][$x]->urutankitab?>',
                'pasal'         : '<?=$_SESSION[NAMAPROGRAM]['ALKITAB'][$x]->pasal?>',
                'ayat'          : '<?=$_SESSION[NAMAPROGRAM]['ALKITAB'][$x]->ayat?>',
                'text'          : '<?=$_SESSION[NAMAPROGRAM]['ALKITAB'][$x]->text?>',
            },
        <?php    
            }
        ?>
        ];
        if(alkitab.length > 0)
        {
            localStorage.setItem("Alkitab", LZString.compressToUTF16(JSON.stringify(alkitab)));
            localStorage.setItem("Alkitab2",LZString.compressToUTF16(JSON.stringify(alkitab2)));
            localStorage.setItem("Alkitab3",LZString.compressToUTF16(JSON.stringify(alkitab3)));
            localStorage.setItem("Alkitab4",LZString.compressToUTF16(JSON.stringify(alkitab4)));
            localStorage.setItem("Alkitab5",LZString.compressToUTF16(JSON.stringify(alkitab5)));
            localStorage.setItem("Alkitab6",LZString.compressToUTF16(JSON.stringify(alkitab6)));
        }
        
    }
    else
    {
        alkitab  = JSON.parse(LZString.decompressFromUTF16(localStorage.getItem("Alkitab")));
        alkitab2 = JSON.parse(LZString.decompressFromUTF16(localStorage.getItem("Alkitab2")));
        alkitab3 = JSON.parse(LZString.decompressFromUTF16(localStorage.getItem("Alkitab3")));
        alkitab4 = JSON.parse(LZString.decompressFromUTF16(localStorage.getItem("Alkitab4")));
        alkitab5 = JSON.parse(LZString.decompressFromUTF16(localStorage.getItem("Alkitab5")));
        alkitab6 = JSON.parse(LZString.decompressFromUTF16(localStorage.getItem("Alkitab6")));
    }

var ukuranFont = 
    [
       {
            "ukuran" : 15,
            "nama" : "F. KECIL",
            "select": false
       }
       ,
       {
            "ukuran" : 25,
            "nama" : "F. NORMAL",
            "select": true
       }
       ,
       {
            "ukuran" : 35,
            "nama" : "F. BESAR",
            "select": false
       }
    ]
    
var ukuranFontAlkitab = 
    [
       {
            "ukuran" : 18,
            "nama" : "F. KECIL",
            "select": false
       }
       ,
       {
            "ukuran" : 20,
            "nama" : "F. NORMAL",
            "select": true
       }
       ,
       {
            "ukuran" : 28,
            "nama" : "F. BESAR",
            "select": false
       }
    ]

$("#TAMBAHKANDAFTARKITAB").attr("disabled","disabled");
var sesi = "LAGU";

var contentNewTab = "";
var x_index = 0;
var arrayLirik = [];
var namalagu = "";
var namapenyanyi = "";
var indexlagu = "";

var idkitab = 0;
var namakitab = "";
var namakitabSingkatan = "";
var pasal = "";
var ayat = "";

var arrayShow = [];
var styleNewTab = "<style>html{background:black;color:white;}body{background:black;color:white; font-family: Tahoma, 'Trebuchet MS', sans-serif; text-align:center; line-height:1.5; margin-top:5px; margin:auto; font-weight:bold;}</style><body></body><script>window.fullScreenClick = fullScreenClick; function fullScreenClick(){ document.documentElement.requestFullscreen(); } function fullScreenExit(){ document.exitFullscreen(); } document.addEventListener('click', function() {fullScreenClick();});<\/script>";

$(document).ready(function() {
    if(!'<?=isset($_SESSION[NAMAPROGRAM][IDGEREJA])?>')
    {
      popUpLogin();
    }
    else
    {
        setData();
    }
	
});

function popUpLogin(){
     var logo = '<img src="<?=base_url()."/assets/images/logo.jpeg"?>" width="300px" >';
      Swal.fire({
    	  title: '',
          width: '500px',
    	  icon: 'info',
    	  html: '<div ><br>\
    	        <div style="text-align:center;"><br>\
    	        <div style="text-align:center; font-size:14pt; font-weight:bold;">'+logo+'<br><br>Shallom, silahkan masukkan inisial anda</div> <br>\
    			<input type="text" style="font-size:14pt; height:50px;"  class="form-control has-feedback-left" id="INISIAL" placeholder="Inisial Gereja / Persekutuan Doa / Dll">\
    			<br></div>\
    			',
    	  showCloseButton: false,
    	  showCancelButton: false,
    	  focusConfirm: false,
    	  allowOutsideClick: false,
    	  confirmButtonText:
    		'Masuk'
    	}).then((result) => {
    	    if (result.value) {
    	        login();
    	    }
      });
      
     $('#INISIAL').keyup(function(e){
		if(e.keyCode == 13)
		{
			login();
		}
	});
	
	
	function login() {
	   $.ajax({
    	type: 'POST',
    	url: '<?php echo base_url(); ?>Login/cekLogin/',
    	data: {
    		namagereja: $("#INISIAL").val(),
    	},
    	dataType: 'json',
    	success: function(msg) {
    		if (msg.success) {
    			Swal.fire({
    				title: msg.info,
    				type: 'success',
    				showConfirmButton: false,
    				timer: 1000
    			}).then(function() {
    				window.location.reload();
    			});
    		} else {
    			Swal.fire({
    				title: msg.errorMsg,
    				type: 'error',
    				showConfirmButton: false,
    				timer: 1000
    			});
    			setTimeout(function() {popUpLogin()}, 1000);
    		}
    	}
    });
	}
}

function setData(){
    $("#mini-screen").css("height",(tinggiLayar/3).toString()+"px");
    $("#mini-screen").css("width",(lebarLayar/3).toString()+"px");
    
	$('.select2').select2({
		  theme: "classic"
	});
	
    $("#mode").val('tambah');
    $("#spaceListLagu").show();
    $("#btn_hapus_list_lagu").hide();
    
    var arr = [];
    for(var i = 0 ; i < ukuranFont.length;i++)
    {
        var selected = '';
        if(ukuranFont[i].select)
        {
            selected = ' selected="selected"';
            fontSizeLagu = ukuranFont[i].ukuran;
        }
    	arr.push("<option value="+ukuranFont[i].ukuran+""+selected+">"+ukuranFont[i].nama+"</option>");
    }
    
    $("#ukuranfont").html(arr);
    
    
    arr = [];
    for(var i = 0 ; i < ukuranFontAlkitab.length;i++)
    {
        var selected = '';
        if(ukuranFontAlkitab[i].select)
        {
            selected = ' selected="selected"';
            fontSizeLagu = ukuranFontAlkitab[i].ukuran;
        }
    	arr.push("<option value="+ukuranFontAlkitab[i].ukuran+""+selected+">"+ukuranFontAlkitab[i].nama+"</option>");
    }
    $("#ukuranfontalkitab").html(arr);
	
	 $('#dataGrid').DataTable({
	    'pageLength'  : 5,
        'paging'      : true,
        'lengthChange': false,
        'searching'   : true,
        'ordering'    : false,
        'info'        : false,
        'autoWidth'   : false,
		"scrollX"	  : false,
		ajax		  : {
			url    : base_url+'lagu/dataGrid',
			dataSrc: "rows",
		},
        columns:[
            {data: 'idlagu', visible:false},
            {data: 'lirik', visible:false},
            {data: 'namapenyanyi', visible:false},
            {data: 'namalagu', className:"text-left"},
            {data: 'liriksingkat', className:"text-left"},
			{data: ''},
        ],
		columnDefs: [ 
			{
                "targets": -1,
                "data": null,
                "defaultContent": "<button id='btn_ubah' class='btn btn-primary'><i class='fa fa-edit'></i></button>&nbsp;<button id='btn_masuk' class='btn btn-success'><i class='fa fa-arrow-right' aria-hidden='true' ></button>"	
			},
			 {
                "targets":-2, // Change this to the index of the column you want to wrap
                "render": function(data, type, row, meta) {
                    return `<div style="word-wrap: break-word; width:200px;">${data}</div>`;
                }
            }
		],
    });  
	
    //DAPATKAN INDEX
	$('#dataGrid tbody').on( 'click', 'button', function () {
		var table = $('#dataGrid').DataTable();
		var row = table.row( $(this).parents('tr') ).data();
		var mode = $(this).attr("id");
		
		if(mode == "btn_ubah"){ ubah(row); }
		else if(mode == "btn_masuk"){ 
		    var dataList = {
    		    idlistlagu:idlistlagu,
                idlagu:row.idlagu,
                tanggal:"",
                lirik:row.lirik,
                namalagu:row.namalagu,
                namapenyanyi:row.namapenyanyi,
    		};
    		$('#dataGridListLagu').DataTable().row.add(dataList).draw();
		}
	});
	
	
	
	$('#dataGridListLagu').DataTable({
        'paging': false,
        'lengthChange': false,
        'searching': true,
        'ordering': false,
        'info': false,
        'autoWidth': false,
        ajax: {
            url: base_url + 'lagu/dataGridListLagu',
            dataSrc: function(json) {
                // Check if the data is present and has rows, if not return an empty array
                return json.rows ? json.rows : [];
            }
        },
        columns: [
			{data: ''},
            {data: 'idlistlagu', visible: false},
            {data: 'idlagu', visible: false},
            {data: 'tanggal', visible: false},
            {data: 'lirik', visible:false},
            {data: 'namalagu', className: "text-left"},
            {data: 'namapenyanyi', className: "text-left"},
        ],
        columnDefs: [
            {
                "targets": 0,
                "data": null,
                "defaultContent": "<button id='btn_keluar' class='btn btn-danger'><i class='fa fa-arrow-left' aria-hidden='true'></i></button>&nbsp;<button id='btn_ubah_list' class='btn btn-primary'><i class='fa fa-edit'></i></button>&nbsp;<button id='btn_show' class='btn btn-warning'><i class='fa fa-eye'></i></button>"
            },
        ],
    });
    
    // Enable sorting
    const tbody = $('#dataGridListLagu tbody')[0];
    const sortable = new Sortable(tbody, {
        animation: 150,
        ghostClass: 'dragging',
        handle: 'tr',
        onEnd: function(evt) {
            let movedData = $('#dataGridListLagu').DataTable().row(evt.oldIndex).data();
            let temp;
            
            var dataList = $('#dataGridListLagu').DataTable().rows().data();
            $('#dataGridListLagu').DataTable().clear();
            
            for(var x = 0 ; x < dataList.length; x++)
            {
                if(evt.newIndex <= evt.oldIndex)
                {
                    
                   if(x == evt.newIndex)
                   {
                       temp = dataList[x];
                       dataList[x] = movedData;
                       movedData = temp;
                   }
                   else if(x <= evt.oldIndex && x > evt.newIndex)
                   {
                       temp = dataList[x];
                       dataList[x] = movedData;
                       movedData = temp;
                   }
                     $('#dataGridListLagu').DataTable().row.add(dataList[x]).draw();
                }
                else
                {
                   if(x >= evt.oldIndex && x < evt.newIndex)
                   {
                       dataList[x] = dataList[x+1];
                   }
                   else if(x == evt.newIndex)
                   {
                       dataList[x] = movedData;
                   }
                 $('#dataGridListLagu').DataTable().row.add(dataList[x]).draw();
                }
            }
        }
    });
    
    //DAPATKAN INDEX
    $('#dataGridListLagu tbody').on( 'click', 'button', function () {
		var table = $('#dataGridListLagu').DataTable();
		var row = table.row( $(this).parents('tr') ).data();
		var mode = $(this).attr("id");
		
		if(mode == "btn_ubah_list"){ 
		    if(row.namapenyanyi != "AYAT")
		    {
		     ubah(row);
		    }
		}
		if(mode == "btn_show"){
		    if(row.namapenyanyi != "AYAT")
		    {
    		    namalagu = row.namalagu;
    		    namapenyanyi = row.namapenyanyi;
    		    arrayLirik = row.lirik.split("<BR><BR>");
    		    indexlagu = 0;
    		    setLagu();
		    }
		    else
		    {
                namakitab = row.tanggal;
                $('#CB_LIST_ALKITAB option').each(function() {
                  if ($(this).text() === namakitab) {
                    // Set the option with the matching text as selected
                    $(this).prop('selected', true);
                  }
                });
                    
                $('#CB_LIST_ALKITAB').trigger('change'); // Update the value
              
		        setTimeout(function() {
    		          pasal = row.idlistlagu;
		                clickPasal(pasal);
                }, 100);
                setTimeout(function() {
    		        ayat = row.idlagu; 
    		        clickAyat(ayat-1);
                }, 200);
          
                
		    }
		}
		else if(mode == "btn_keluar"){ 
            // Get the row that the clicked button belongs to and remove it
            table.row($(this).parents('tr')).remove().draw();
		}
	});
	
	$("#ukuranfont").change(function(){
        fontSizeLagu = $(this).val();
	    miniLive();
	    
	});
	
	$("#ukuranfontalkitab").change(function(){
        fontSizeAlkitab = $(this).val();
	    miniLive();
	});
	
	$("#CB_LIST_LAGU").change(function(){
	    idlistlagu = $(this).val();
	    namalistlagu = $(this).find('option:selected').text();
	    
        $('#dataGridListLagu').DataTable().clear();
	    if (idlistlagu != 0)
	    {
	        
            $("#spaceListLagu").hide();
	        $("#btn_hapus_list_lagu").show();
            $.ajax({
                type    : 'POST',
                dataType: 'json',
                url     :  base_url+'lagu/dataGridListLagu',
                data    : "id="+idlistlagu,
                cache   : false,
                success : function(msg){
                    var dataList = msg.rows;
                     $('#dataGridListLagu').DataTable().rows.add(dataList).draw();
                     
                      var arr = [];
                      for(var i = 0 ; i < ukuranFont.length;i++)
                      {
                          var selected = '';
                          if(dataList[0].ukuranfont == ukuranFont[i].ukuran)
                          {
                              selected = ' selected="selected"';
                              fontSizeLagu = dataList[0].ukuranfont;
                          }
                      	arr.push("<option value="+ukuranFont[i].ukuran+""+selected+">"+ukuranFont[i].nama+"</option>");
                      }
                      
                      $("#ukuranfont").html(arr)
                }
            });
    
	       
	    }
	    else
	    {
           $("#spaceListLagu").show();
	       $("#btn_hapus_list_lagu").hide();
	       $("#dataGridListLagu").DataTable().ajax.reload();
    	   var arr = [];
            for(var i = 0 ; i < ukuranFont.length;i++)
            {
                var selected = '';
                if(ukuranFont[i].select)
                {
                    selected = ' selected="selected"';
                    fontSizeLagu = ukuranFont[i].ukuran;
                }
            	arr.push("<option value="+ukuranFont[i].ukuran+""+selected+">"+ukuranFont[i].nama+"</option>");
            }
            
            $("#ukuranfont").html(arr)
	        }
	})
	
	$("#CB_LIST_ALKITAB").change(function(){
	 chooseKitab();
	})
    
}

function setLagu()
{
	$("#NAMECHOOSE").html(namalagu);
	$("#SINGERCHOOSE").html(namapenyanyi);
	$("#LIRIKCHOOSE").html("");
	
	for(var x = 0 ;x < arrayLirik.length;x++)
	{
	    $("#LIRIKCHOOSE").append("<button style='width:100%;' id='separated"+x+"' onclick='javascript:changeWord("+x+")'>"+arrayLirik[x]+"</button><br><br>");
	}
	arrayShow = [];
	arrayShow = arrayLirik;
	sesi = "LAGU";
	changeWord(indexlagu);
}

function tampilkanInstant(){
    $("#NAMECHOOSE").html($("#NAMALAGU").val());
	$("#SINGERCHOOSE").html($("#NAMAPENYANYI").val());
	$("#LIRIKCHOOSE").html("");
	
	let arrayLirikLangsung = $("#LIRIK").val().split("\n\n");
	
	for(var x = 0 ;x < arrayLirikLangsung.length;x++)
	{
	    $("#LIRIKCHOOSE").append("<button style='width:100%;' id='separated"+x+"' onclick='javascript:changeWord("+x+")'>"+arrayLirikLangsung[x]+"</button><br><br>");
	}
	arrayShow = [];
	arrayShow = arrayLirikLangsung;
	sesi = "LAGU";
	changeWord(indexlagu);
}

function changeWord(x)
{
    $('.lirik-body').animate({
        scrollTop:  $('#separated'+x).position().top + $('.lirik-body').scrollTop()-100
    }, 100); 
    
   if(sesi == "ALKITAB")
   {
       ayat = (x+1);
       setPasalAyat();
       $("#NAMECHOOSE").html($("#pasal_ayat").html());
   }
   else
   {
       indexlagu = x;
   }
   
    x_index = x;
    for(var y = 0; y < arrayShow.length;y++)
    {
        $("#separated"+y).css("background","");
    }
    
    $("#separated"+x_index).css("background","yellow");
    
    contentNewTab = arrayShow[x_index];
    
    miniLive();
}
var isiKitab = [];

function chooseKitab(){
    $("#TAMBAHKANDAFTARKITAB").attr("disabled","disabled");
	arrAlkitab = $("#CB_LIST_ALKITAB").find('option:selected').val().split("-");
	namakitab = $("#CB_LIST_ALKITAB").find('option:selected').text();
	namakitabSingkatan = arrAlkitab[2];
	
    idkitab = arrAlkitab[0];
    var content = "";
    for(var x = 1 ; x <= arrAlkitab[1];x++)
    {
        content +="<button style='width:40px; margin-left:7px; margin-bottom:7px; font-size:16pt; font-weight:bold; padding:3px;' onclick='clickPasal("+x+")'>"+x+"</button>";
        
        if(x % 10 == 0)
        {
            content += "<br>";
        }
    }
    $("#alkitab_title").html("<div style='font-weight:bold; font-size:18pt; margin-bottom:10px; '>P<br>A<br>S<br>A<br>L</div>");
    $("#alkitab_value").html(content);
    pasal = "";
    ayat = "";
    setPasalAyat();
}

function clickPasal(x)
{
    $("#TAMBAHKANDAFTARKITAB").attr("disabled","disabled");
    $("#LIRIKCHOOSE").html("");
    $("#SINGERCHOOSE").html("");
    pasal = x;
    ayat = "";
    setPasalAyat();
    isiKitab = [];
    
    //  $.ajax({
    //     type    : 'POST',
    //     dataType: 'json',
    //     url     :  base_url+'Alkitab/getAyat',
    //     data    : "urutankitab="+idkitab+"&pasal="+pasal,
    //     cache   : false,
    //     async   : false,
    //     success : function(msg){
    //       isiKitab = msg;
    //     }
    // });
    var found = false;
    if(!found)
    {
        for(var a = 0 ; a < alkitab.length ; a++)
        {
            if(alkitab[a].urutankitab == idkitab && alkitab[a].pasal == pasal)
            { 
                alkitab[a].text = alkitab[a].text.replaceAll("_","\'").replaceAll('+','\"');
                isiKitab.push(alkitab[a]);
                found = true;
                continue;
            }
        }
    }
    
    if(!found)
    {
        for(var a = 0 ; a < alkitab2.length ; a++)
        {
            if(alkitab2[a].urutankitab == idkitab && alkitab2[a].pasal == pasal)
            { 
                alkitab2[a].text = alkitab2[a].text.replaceAll("_","\'").replaceAll('+','\"');
                isiKitab.push(alkitab2[a]);
                found = true;
                continue;
            }
        }
    }
    
    if(!found)
    {
        for(var a = 0 ; a < alkitab3.length ; a++)
        {
            if(alkitab3[a].urutankitab == idkitab && alkitab3[a].pasal == pasal)
            { 
                alkitab3[a].text = alkitab3[a].text.replaceAll("_","\'").replaceAll('+','\"');
                isiKitab.push(alkitab3[a]);
                found = true;
                continue;
            }
        }
    }
    
    if(!found)
    {
        for(var a = 0 ; a < alkitab4.length ; a++)
        {
            if(alkitab4[a].urutankitab == idkitab && alkitab4[a].pasal == pasal)
            { 
                alkitab4[a].text = alkitab4[a].text.replaceAll("_","\'").replaceAll('+','\"');
                isiKitab.push(alkitab4[a]);
                found = true;
                continue;
            }
        }
    }
    
    if(!found)
    {
        for(var a = 0 ; a < alkitab5.length ; a++)
        {
            if(alkitab5[a].urutankitab == idkitab && alkitab5[a].pasal == pasal)
            { 
                alkitab5[a].text = alkitab5[a].text.replaceAll("_","\'").replaceAll('+','\"');
                isiKitab.push(alkitab5[a]);
                found = true;
                continue;
            }
        }
    }
    
    if(!found)
    {
        for(var a = 0 ; a < alkitab6.length ; a++)
        {
            if(alkitab6[a].urutankitab == idkitab && alkitab6[a].pasal == pasal)
            { 
                alkitab6[a].text = alkitab6[a].text.replaceAll("_","\'").replaceAll('+','\"');
                isiKitab.push(alkitab6[a]);
                found = true;
                continue;
            }
        }
    }
                           
    var content = "";
    
	for(var x = 0 ; x < isiKitab.length;x++)
	{
	    content +="<button style='width:40px; margin-left:7px; margin-bottom:7px; font-size:16pt; font-weight:bold; padding:3px;' onclick='clickAyat("+x+")'>"+(x+1)+"</button>";
	    
	    if((x+1) % 10 == 0)
	    {
	        content += "<br>";
	    }
	}
	$("#alkitab_title").html("<div style='font-weight:bold; font-size:18pt; margin-bottom:10px; '>A<br>Y<br>A<br>T</div>");
	$("#alkitab_value").html(content);
	
	
    $("#NAMECHOOSE").html($("#pasal_ayat").html());
    
    for(var x = 0 ; x < isiKitab.length;x++)
	{
	    $("#LIRIKCHOOSE").append("<button style='width:100%;' id='separated"+x+"' onclick='javascript:changeWord("+x+")'>"+(x+1)+". "+isiKitab[x].text+"</button><br><br>");
	}
	
	arrayShow = [];
	for(var x = 0 ; x < isiKitab.length;x++)
	{
	     arrayShow.push("<span style='color:yellow'>"+namakitabSingkatan+" "+pasal+":"+(x+1)+"</span> "+isiKitab[x].text);
	}
	sesi = "ALKITAB";
// 	changeWord(0);
}

function clickAyat(i)
{
    $("#TAMBAHKANDAFTARKITAB").removeAttr("disabled");
    $("#LIRIKCHOOSE").html("");
    $("#SINGERCHOOSE").html("");
    ayat = (parseInt(i)+1);
    setPasalAyat();
    
    $("#NAMECHOOSE").html($("#pasal_ayat").html());
    
    for(var x = 0 ; x < isiKitab.length;x++)
	{
	    $("#LIRIKCHOOSE").append("<button style='width:100%;' id='separated"+x+"' onclick='javascript:changeWord("+x+")'>"+(x+1)+". "+isiKitab[x].text+"</button><br><br>");
	}
	
    arrayShow = [];
	for(var x = 0 ; x < isiKitab.length;x++)
	{
	    arrayShow.push("<span style='color:yellow'>"+namakitabSingkatan+" "+pasal+":"+(x+1)+"</span> "+isiKitab[x].text);
	}
	sesi = "ALKITAB";
	changeWord(i);
}

function setPasalAyat()
{
    var content = namakitab;
     if(pasal.toString() != "")
     {
         content += "  <span style='font-size:18pt; font-weight:bold; text-decoration:underline; cursor:pointer;' onclick='chooseKitab()'>"+pasal.toString()+"</span> : ";
     }
     
     if(ayat.toString() != "")
     {
        content += "<span style='font-size:18pt; font-weight:bold; text-decoration:underline; cursor:pointer;' onclick='clickPasal("+pasal+")'>"+ayat.toString()+"</span>"; 
     }
    $("#pasal_ayat").html(content);
}

function tampilanKitabTerakhir(){
    if(pasal != "" && ayat != "")
    {
        clickAyat(ayat-1);
    }
}

function tampilanLaguTerakhir(){
    if(namalagu != "")
    {
        setLagu();
    }
}

function tambah(){
	$("#mode").val('tambah');
	
	//pindah tab & ganti judul tab
	$('.nav-tabs a[href="#tab_form"]').tab('show');
	$('.nav-tabs a[href="#tab_form"]').html('<i>Tambah</i>');
	$("#btn_hapus").hide();
	$("#IDLAGU").val("");
	resetForm($("#form_input"));
}

function ubah(row){
	$("#mode").val('ubah');
	$("#btn_hapus").show();
	//pindah tab & ganti judul tab
	$('.nav-tabs a[href="#tab_form"]').tab('show');
	$('.nav-tabs a[href="#tab_form"]').html('<i>Ubah</i>');
	
	$("#IDLAGU").val(row.idlagu);
	$("#NAMALAGU").val(row.namalagu);
	$("#NAMAPENYANYI").val(row.namapenyanyi);
	$("#LIRIK").val(row.lirik.replaceAll("<BR>","\r\n"));
}

function simpan() {
	
	if (1) {
		mode = $('[name=mode]').val();
        
        $.ajax({
            type      : 'POST',
            url       : base_url+'lagu/simpan',
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
                    var dataListLagu = $('#dataGridListLagu').DataTable().rows().data();
                    $('#dataGridListLagu').DataTable().clear();
                    for(var x = 0 ; x < dataListLagu.length; x++)
                    {
                        if($("#IDLAGU").val() == dataListLagu[x]['idlagu'])
                        {
                              $.ajax({
                                type    : 'POST',
                                dataType: 'json',
                                url     :  base_url+'lagu/getLaguByID',
                                data    : "id="+$("#IDLAGU").val(),
                                cache   : false,
                                async   : false,
                                success : function(msg){
                                    
                                    dataListLagu[x]['namalagu'] = msg.namalagu;
                                    dataListLagu[x]['namapenyanyi'] = msg.namapenyanyi;
                                    dataListLagu[x]['lirik'] = msg.lirik;
                                    console.log(dataListLagu[x]);
                                }
                            });
                        }
                        
                        $('#dataGridListLagu').DataTable().row.add(dataListLagu[x]).draw();
                    }
                    
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

function hapus(){
    Swal.fire({
		title: 'Anda Yakin Akan Menghapus lagu '+$("#NAMALAGU").val()+' ?',
		showCancelButton: true,
		confirmButtonText: 'Yakin',
		cancelButtonText: 'Tidak',
		}).then((result) => {
		/* Read more about isConfirmed, isDenied below */
			if (result.value) {
                $("#mode").val('hapus');
                    $.ajax({
                        type    : 'POST',
                        dataType: 'json',
                        url     : base_url+"lagu/batal",
                        data    : "id="+$("#IDLAGU").val(),
                        cache   : false,
                        success : function(msg){
                            if (msg.success) {
                                Swal.fire({
                                    title            : $("#NAMALAGU").val()+' telah dihapus',
                                    type             : 'success',
                                    showConfirmButton: false,
                                    timer            : 3000
                                });
                                $("#dataGrid").DataTable().ajax.reload();
                                
                                var dataListLagu = $('#dataGridListLagu').DataTable().rows().data();
                                $('#dataGridListLagu').DataTable().clear();
                                for(var x = 0 ; x < dataListLagu.length; x++)
                                {
                                    if($("#IDLAGU").val() != dataListLagu[x]['idlagu'])
                                    {
                                         
                                        $('#dataGridListLagu').DataTable().row.add(dataListLagu[x]).draw();
                                    }
                                    
                                }
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
	})
	
}

function hapusListLagu(){
    Swal.fire({
		title: 'Anda Yakin Akan Menghapus lagu '+namalistlagu+' ?',
		showCancelButton: true,
		confirmButtonText: 'Yakin',
		cancelButtonText: 'Tidak',
		}).then((result) => {
		/* Read more about isConfirmed, isDenied below */
			if (result.value) {
                $("#mode").val('hapus');
                    $.ajax({
                        type    : 'POST',
                        dataType: 'json',
                        url     : base_url+"lagu/batalList",
                        data    : "id="+idlistlagu,
                        cache   : false,
                        success : function(msg){
                            if (msg.success) {
                                Swal.fire({
                                    title            : namalistlagu+' telah dihapus',
                                    type             : 'success',
                                    showConfirmButton: false,
                                    timer            : 3000
                                });
                                $("#dataGridListLagu").DataTable().ajax.reload();
                                $.ajax({
                                 type      : 'POST',
                                 url       : base_url+'Lagu/comboGridListLagu',
                                 dataType  : 'json',
                                 beforeSend: function (){
                                     //$.messager.progress();
                                 },
                                 success: function(msg){
                            			 var arr = ['<option value="0">-- BUAT LIST BARU --</option>'];
                            			for(var i = 0 ; i < msg.rows.length;i++)
                            			{
                            			    var selected = '';
                            			    if(idlistlagu == msg.rows[i].value)
                            			    {
                            			        selected = ' selected="selected"';
                            			    }
                            				arr.push("<option value="+msg.rows[i].value+""+selected+">"+msg.rows[i].text+"</option>");
                            			}
                            			
                            			$("#CB_LIST_LAGU").html(arr)
                            			
                            			var arr = [];
                                        for(var i = 0 ; i < ukuranFont.length;i++)
                                        {
                                            var selected = '';
                                            if(ukuranFont[i].select)
                                            {
                                                selected = ' selected="selected"';
                                                fontSizeLagu = ukuranFont[i].ukuran;
                                            }
                                        	arr.push("<option value="+ukuranFont[i].ukuran+""+selected+">"+ukuranFont[i].nama+"</option>");
                                        }
                                        
                                        $("#ukuranfont").html(arr)
                            			
                                     }
                                 });
                                idlistlagu = 0;
                                namalistlagu = "-- BUAT LIST BARU --";
                                $("#spaceListLagu").show();
                                $("#btn_hapus_list_lagu").hide();
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
	})
	
}

function simpanListLagu(){
    
    Swal.fire({
	  title: '',
      width: '500px',
	  icon: 'info',
	  html: '<div ><br>\
	        <div style="text-align:center;"><br>\
	        <div style="text-align:center; font-size:14pt; font-weight:bold;">Apakah anda yakin menyimpan list lagu ini ? </div> <br>\
			<input type="text" style="font-size:14pt; height:50px;"  class="form-control has-feedback-left" id="FILENAME" placeholder="Beri Nama List Lagu.  Ex : Lagu Ibadah Umum">\
			<br><div style="font-style:italic; font-size:12pt;">*Untuk ayat pada daftar tidak akan tersimpan</div>\
			<br></div>\
			',
	  showCloseButton: false,
	  showCancelButton: false,
	  focusConfirm: false,
	  confirmButtonText:
		'Ya, Simpan'
	}).then((result) => {
	  /* Read more about isConfirmed, isDenied below */
	  if (result.value) {
	      if($("#FILENAME").val() != "")
	      {
	           var arrayDetail = $('#dataGridListLagu').DataTable().rows().data();
	           if(arrayDetail.length == 0)
	           {
    	        Swal.fire({
                       title            : "Tambahkan lagu minimal 1",
                       type             : 'error',
                       showConfirmButton: false,
                       timer            : 3000
                  });
    	      }
    	      else
    	      {
    	        
                namalistlagu =  $("#FILENAME").val();
    	        var mode = "TAMBAH";
                if(idlistlagu != 0)
                {
                    mode = "UBAH";
                }
                
                if(mode == "TAMBAH")
                {
                    $.ajax({
                        type      : 'POST',
                        async     : false,
                        url       : base_url+'lagu/getIDListLagu',
                        dataType  : 'json',
                        beforeSend: function (){
                            //$.messager.progress();
                        },
                        success: function(msg){
                            if (msg.success) {
                                idlistlagu = msg.id;
                            }
                        }
                        
                    });
                }
            
                var simpanArray = [];
                for(var x = 0 ; x < arrayDetail.length;x++)
                {
                    if(arrayDetail[x].namapenyanyi != "AYAT")
                    {
                        arrayDetail[x].namalistlagu = namalistlagu;
                        arrayDetail[x].idlistlagu = idlistlagu;
                        arrayDetail[x].urutan = (x+1);
                        simpanArray.push({
                            idlagu       : arrayDetail[x].idlagu,
                            idlistlagu   : arrayDetail[x].idlistlagu,
                            namalistlagu : arrayDetail[x].namalistlagu,
                            urutan       : arrayDetail[x].urutan,
                            ukuranfont   : $("#ukuranfont").val()
                        })
                    }
                    
                }
          
                var dataDetail = JSON.stringify(simpanArray);
                
                 $.ajax({
                    type      : 'POST',
                    url       : base_url+'lagu/simpanListLagu',
                    data      : {mode:mode, detail:dataDetail},
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
                            
                            $.ajax({
                             type      : 'POST',
                             url       : base_url+'Lagu/comboGridListLagu',
                             dataType  : 'json',
                             beforeSend: function (){
                                 //$.messager.progress();
                             },
                             success: function(msg){
                        			 var arr = ['<option value="0">-- BUAT LIST BARU --</option>'];
                        			for(var i = 0 ; i < msg.rows.length;i++)
                        			{
                        			    var selected = '';
                        			    if(idlistlagu == msg.rows[i].value)
                        			    {
                        			        selected = ' selected="selected"';
                        			    }
                        				arr.push("<option value="+msg.rows[i].value+""+selected+">"+msg.rows[i].text+"</option>");
                        			}
                        			
                        			$("#CB_LIST_LAGU").html(arr)
                                    $("#spaceListLagu").hide();
                                    $("#btn_hapus_list_lagu").show();
                                 }
                             });
                            
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
	      else
	      {
	        Swal.fire({
                   title            : "Nama List tidak boleh kosong",
                   type             : 'error',
                   showConfirmButton: false,
                   timer            : 3000
              });
	      }
	  }
	})
	if(namalistlagu != "-- BUAT LIST BARU --")
	{
        $("#FILENAME").val(namalistlagu);
	}
	else
	{
	    $("#FILENAME").val('');
	}
}

function showSlide(){
     if(newTab != null)
     {
        newTab.document.title = $("#NAMECHOOSE").val();
        
         
        var fontSizeTab = parseFloat(fontSizeMiniScreen) * (parseFloat(tinggiLayar) / parseFloat($("#mini-screen").css("height").split("px")[0]));    
        
        // var widthSc = parseFloat(window.innerWidth);
        // if(widthVar > widthSc)
        // {
        //     width = (parseFloat($("#mini-screen").css("height").split("px")[0]) * 3).toString()+"px";
        // }
        
        newTab.document.body.innerHTML = "<div style='width:100%; overflow-y:auto; overflow-x:hidden; height:100%; font-size:"+fontSizeTab+"px; '><div style='width:"+lebarLayar+"px; margin:auto;'>"+contentNewTab+"</div></div>";

     }
}

function miniLive(){
    if(sesi == "LAGU")
    {
        fontSizeMiniScreen = fontSizeLagu;
    }
    else
    {
        if(contentNewTab.length > batasTeks)
        {
            selisihSize = parseFloat(contentNewTab.length) - parseFloat(batasTeks);
            fontSizeMiniScreen =  parseFloat(fontSizeAlkitab) - (parseFloat(selisihSize) / 50);
        }
        else
        {
            fontSizeMiniScreen = fontSizeAlkitab;
        }
    }
    var styleMiniScreen = "<style>#mini-screen{background:black; color:white; font-size:"+fontSizeMiniScreen+"px; font-family: Tahoma, 'Trebuchet MS', sans-serif; text-align:center; height:100%; line-height:1.5; margin-top:5px; margin:auto; font-weight:bold;}#mini-screen span{background:black;font-size:"+fontSizeMiniScreen+"px; font-family: Tahoma, 'Trebuchet MS', sans-serif; text-align:center; height:100%; line-height:1.5; margin-top:5px; margin:auto; font-weight:bold;}</style><body></body>";
    $("#mini-screen").html(styleMiniScreen+" "+contentNewTab);
    
    if(liveTab)
    {
         showSlide();
    }
    
}

function live(){
    liveTab = !liveTab;
    if(newTab == null)
    {

        newTab = window.open(base_url+'wordandworship/live', '_blank','left='+window.innerWidth+',resizable=yes,scrollbars=yes,width=' + screen.width + ',height='+ screen.height);
                        
        newTab.document.write(styleNewTab);
    }
    
    if(liveTab)
    {
        $("#btn_live").addClass("main-button");
        showSlide();
    }
    else
    {
        $("#btn_live").removeClass("main-button");
    }

}

function tambahkanAyatDaftar(){
    var data = {};
    data.idlagu = ayat;
    data.tanggal = namakitab;
    data.idlistlagu = pasal;
    data.namalagu = $("#pasal_ayat").text();
    data.namapenyanyi = "AYAT";
    data.lirik = "";
             
                        
    $('#dataGridListLagu').DataTable().row.add(data).draw();
}

function blank(){
    if(newTab == null)
    {
         newTab = window.open(base_url+'wordandworship/live', '_blank','left='+window.innerWidth+',resizable=yes,scrollbars=yes,width=' + screen.width + ',height='+ screen.height);
    }
    newTab.document.body.innerHTML = '';
    newTab.document.write(styleNewTab);
}

function resetForm($form) {
    $form.find('input:text, input:password, input:file, select, textarea').val('');
    $form.find('input:radio, input:checkbox')
         .removeAttr('checked').removeAttr('selected');
}

document.addEventListener("keydown", function(event) {
    if (event.key === "F5" || event.keyCode === 116) {
        if(newTab != null)
        {
             newTab.close();
        }
    }
    else if(event.keyCode === 33)
    {
        if(x_index > 0)
        {
            x_index--;
            changeWord(x_index);
        }
        event.preventDefault();
        
    }
    else if(event.keyCode === 34)
    {
        if(x_index < arrayShow.length-1)
        {
            x_index++;
            changeWord(x_index);
        }
        event.preventDefault();
    }
});

window.addEventListener("beforeunload", function(event) {
    if(newTab != null)
    {
         newTab.close();
    }
});

</script>