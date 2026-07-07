<?php
session_start();
if ($excel == 'ya'){
	include dirname(__FILE__)."/../export_to_excel.php";
}

if($errorMsg != ''){
	echo "<script>alert('$errorMsg'); window.close();</script>";
}

$CI =& get_instance();	
$CI->load->database($_SESSION[NAMAPROGRAM]['CONFIG']);

if($tampil != "JADWAL PELAYANAN" && $tampil != "TOTAL PELAYANAN"){
	$query = $CI->db->query($sql)->result();
}

?>
<!DOCTYPE HTML>
<html>
<head>
    <title>..:: Laporan ::..</title>
    <style>
     table{
	 border-collapse: collapse;
	 border:1px solid;
	}
	
     .HEADER {
        font-family: Tahoma, Verdana, Geneva, sans-serif;
        font-weight: bold;
        font-size: 18px;
        color: #000;
        text-align:left;
    }
	th{
		border:1px solid;
	}
	
    th, td{
        font-family:Tahoma, Verdana, Geneva, sans-serif;
        font-size:10px;
        padding: 2px;
		
    }
	
	span{
		 font-family:Tahoma, Verdana, Geneva, sans-serif;
		 font-size:12px;
	}
	
	.border-right{
		border-right:1px solid;
	}
    </style>
</head>
<body>
	<div style="margin:15px;">
	<?php
	if ($tampil=='DAFTAR PELAYAN') {    	
		
		$content = '<tr style="background:skyblue;">';
		$content .= '<th>No.</th>';
		$content .= '<th width="200px" colspan="2">Nama</th>';
		$content .= '<th>Telp</th>';
		$content .= '</tr>';
		$i = 0;

		foreach($query as $row){
			
			$bgcolor = "background:white;";
			if($row->status == 0)
			{
				$bgcolor = "background:#cccccc;";
			}
					
			$i++;
			$contentDetail .= "<tr style='".$bgcolor."'>";
			$contentDetail .= '<td width="20px" align="center" class="border-right">'.$i.'</td>';
			$contentDetail .= '<td width="20px" align="left" >'.$row->panggilan.'</td>';
			$contentDetail .= '<td width="170px" align="left" class="border-right">'.$row->namapelayan.'</td>';
			$contentDetail .= '<td width="100px" align="left" class="border-right">'.$row->telp.'</td>';
			$contentDetail .= "</tr>";
		}
		
		echo '<strong class="HEADER">Daftar Pelayan '.$_SESSION[NAMAPROGRAM]['NAMAGEREJA'].'</strong>';
		
		echo '<hr></hr>';
		
		echo '<table>';
		
		echo '<thead>';
			echo $content;								
		echo '</thead>';
		
		echo '<tbody>';	
		
		echo $contentDetail;							
		
		echo '</tbody>';	
		
		echo '</table>';
		
		echo '<br>';
			
		echo '<span style="font-weight: bold;" >Keterangan : </span>';
			
		echo '<br>';
			
		echo '<span style="background:#cccccc;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>&nbsp;<span>Pelayan Non Aktif</span>';
	}
	if ($tampil=='DAFTAR PELAYANAN') {
		//print_r($query);    	
		$content = "";
		$contentDetail = "";
		$oldjenispelayanan = "";
			
		$query2 = $query;
		//HEADER
			for($i = 0 ; $i < count($query); $i++)
			{
				if($oldjenispelayanan != $query[$i]->namajenispelayanan)
				{
					if($i == 0)
					{
						$content .= "<tr style='background:skyblue;'>";
						$contentDetail .= "<tr>";
					}
					
					$bgcolor = "background:white;";
					if($query[$i]->status == 0)
					{
						$bgcolor = "background:#cccccc;";
					}
					
					$oldjenispelayanan = $query[$i]->namajenispelayanan;
					$content .= "<th width='100px;' style='".$bgcolor."'>".$query[$i]->namajenispelayanan."</th>";
					
					$contentDetail .= "<td valign='top' style='".$bgcolor." border:1px solid;'><table style='border:0px;'>";
					for($j=0; $j < count($query2);$j++)
					{
						if($query[$i]->namajenispelayanan == $query2[$j]->namajenispelayanan)
						{
							$contentDetail .= ("<tr ><td valign='top' width='30px;' >".$query2[$j]->panggilan."&nbsp;&nbsp;&nbsp;</td><td valign='top' width='70px;'>".$query2[$j]->namapelayan."</td></tr>");
						}
						
					}
					$contentDetail .= "</table></td>";
					
					if($i == (count($query)-1))
					{
						$content .= "</tr>";
						$contentDetail .= "</tr>";
					}
				}
			}
			
			echo '<strong class="HEADER">Daftar Jenis Pelayanan '.$_SESSION[NAMAPROGRAM]['NAMAGEREJA'].'</strong>';
			echo '<hr></hr>';
		
			echo '<table>';
			
			echo '<thead>';
			
			echo $content;	
			
			echo '</thead>';
			
			echo '<tbody>';	
			
			echo $contentDetail;							
			
			echo '</tbody>';	
			
			echo '</table>';
			
			echo '<br>';
			
			echo '<span style="font-weight: bold;" >Keterangan : </span>';
			
			echo '<br>';
			
			echo '<span style="background:#cccccc;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>&nbsp;<span>Jenis Pelayanan Non Aktif</span>';
			
	}
	if($tampil=='JADWAL PELAYANAN'){
	    
	    //CEK JADWAL KEDEPAN
	    $sqlTanggal = "SELECT a.tanggal as tanggalberikutnya
                from tjadwaldtl a
                where a.idgereja = {$_SESSION[NAMAPROGRAM]['IDGEREJA']} and a.tanggal >= '".date("Y-m-d")."'
				order BY a.tanggal ASC";
				
		$tanggalBerikutnya = $CI->db->query($sqlTanggal)->row()->tanggalberikutnya;
		
		$content = "";
		$contentDetail = "";
		
		$bulan = $bulanAwal;
		$tahun = $tahunAwal;
			
		$oldtanggal = "";
		
		$countheader = 0;
		
		$choose="style='background:orange'";
		
		$content .= "<th width='40px;' style='background:skyblue;text-align:center;' >Tgl</th>";
		
	
		for($a=$bulanAwal;$a < ($bulanAwal+$countBulan) ;$a++)
		{
						
			
			$sql = "SELECT a.idjadwal,b.tanggal,c.namapelayan,c.telp,d.namajenispelayanan,d.urutan,c.idpelayan,d.idjenispelayanan,c.panggilan,a.status,b.catatan as catatandetail
                from tjadwal a
				inner join tjadwaldtl b on a.idjadwal = b.idjadwal
				left join  mpelayan c on b.idpelayan = c.idpelayan 
				inner join mjenispelayanan d on b.idjenispelayanan = d.idjenispelayanan 
                where a.idgereja = {$_SESSION[NAMAPROGRAM]['IDGEREJA']}
					and a.bulan = '".date('F', mktime(0, 0, 0, $bulan, 10))."' and a.tahun = '{$tahun}' and d.STATUS = 1
				order BY b.tanggal ASC,d.urutan asc";
				
			$query = $CI->db->query($sql)->result();
			
			
			for($i = 0 ; $i < count($query); $i++)
			{
				if($oldtanggal != $query[$i]->tanggal && $oldtanggal == "")
				{
					$countheader+=3;
					$oldtanggal = $query[$i]->tanggal;
					$content .= "<th  valign='top' colspan='2' style='background:skyblue; text-align:center;'>".$query[$i]->namajenispelayanan."</th>";
				}
				else if($oldtanggal == $query[$i]->tanggal)
				{
					$countheader+=2;
					$content .= "<th  valign='top'colspan='2' style='background:skyblue; text-align:center;'>".$query[$i]->namajenispelayanan."</th>";
				}
			}
			
			$oldtanggalDetail = "";
			for($i = 0 ; $i < count($query); $i++)
			{
			    
				
			    $style="";
			    $menunggupersetujuan = false;
				if($query[$i]->idpelayan == $idpelayan)
				{
				    $style=$choose;
				}
				if($oldtanggalDetail != $query[$i]->tanggal)
				{
					if(date('F', mktime(0, 0, 0, $oldtanggalDetail, 10)) != date('F', mktime(0, 0, 0, $query[$i]->tanggal, 10))){
						$contentDetail .= "<tr  valign='top'><td colspan='".$countheader."' style='border:1px solid;  background:yellow;' align='center'>".date("F Y", strtotime($query[$i]->tanggal))."</td></tr>";
						$menunggupersetujuan = true;
					}
					
					$oldtanggalDetail = $query[$i]->tanggal;
					
					if($i != 0)
					{
						$contentDetail .= "</tr>";
					}
				
					
					if($query[$i]->status == '2' || !$guest)
					{
					    if($query[$i]->catatandetail == "" || $query[$i]->catatandetail == "-")
					    {
					        $warna = "";
					        if($tanggalBerikutnya == $query[$i]->tanggal)
					        {
					            $warna = "background:orange;";
					        }
        					$contentDetail .= "<tr  valign='top' style='".$warna."'><td class='border-right' align='center' >".date("d", strtotime($query[$i]->tanggal))."</td>";
        				
        					$contentDetail .= "<td width='30px;' $style>".$query[$i]->panggilan."</td>";
        					$contentDetail .= "<td width='100px;' class='border-right' $style>".$query[$i]->namapelayan."</td>";
					    }
					    else
					    {
					        $contentDetail .= "<tr  valign='top'><td class='border-right' align='center' style='background:#b5e8a4;'>".date("d", strtotime($query[$i]->tanggal))."</td>";
					        $contentDetail .= "<td colspan='".$countheader."' class='border-right' align='center' style='font-style:italic; font-weight:bold; background:#b5e8a4;' >".$query[$i]->catatandetail."</td>";
					    }
					}
					else
					{
					    
					    if($menunggupersetujuan && $guest)
					    {
					        $contentDetail .= "<tr  valign='top' ><td colspan='".$countheader."' class='border-right' align='center' style='font-style:italic' >Menunggu Persetujuan</td>";
					    }
					}
				}
				else
				{
				    if($query[$i]->status == '2' || !$guest)
					{
					    if($query[$i]->catatandetail == "" || $query[$i]->catatandetail == "-")
					    {
        					$contentDetail .= "<td width='30px;' $style >".$query[$i]->panggilan."</td>";
        					$contentDetail .= "<td width='100px;' class='border-right' $style >".$query[$i]->namapelayan."</td>";
					    }
					}
				}
			}
			
			if($bulan == 12)
			{
				$bulan = 1;
				$tahun++;
			}
			else
			{
				$bulan++;
			}
		}
		
        echo '<form method="post" target="" action="'.base_url().'Guest/lihatJadwal" id="form_input"><input type="hidden" name="idpelayan" value="'.$idpelayan.'"><input type="hidden" name="bulantahunberikutnya" value="'.$bulantahunberikutnya.'">';
		echo '<table style="border:0px; width:100%;"><tr><td><strong class="HEADER">Jadwal Pelayanan '.$_SESSION[NAMAPROGRAM]['NAMAGEREJA'].'</strong></td> <td rowspan="2">'.($jadwalberikutnya == 1 ? '<button style="background:#367fa9; color:white; float:right; border:0px; border-radius:5px; font-size:12pt; padding:15px 15px 15px 15px;" >Lihat Jadwal Terbaru -> </button>':'').'</td></tr>';
		echo '<tr><td><strong class="HEADER">Periode : '.$periode.'</td></tr></table>';
		
		echo "</form>";
		
		echo '<hr></hr>';
		
		echo '<table>';
		
		echo '<thead>';
		
		echo $content;	
		
		echo '</thead>';
		
		echo '<tbody>';	
		
		echo $contentDetail;							
		
		echo '</tbody>';	
		
		echo '</table>';
		
		echo '<br><br><a href="https://docs.google.com/spreadsheets/d/1vfHhC1os2VpHzu0572O5n7zE58Br2C9oFuWZx-oa0Uk/edit?gid=0#gid=0" style="background:#367fa9; color:white; border:0px; border-radius:5px; font-size:12pt; padding:15px 15px 15px 15px;">Lihat Bank Lagu</a> ';
		
	}
	if($tampil=='TOTAL PELAYANAN'){
			
		$oldtanggal = "";
		
		$countheader = 0;
		
		
		
		echo '<strong class="HEADER">Total Pelayanan '.$_SESSION[NAMAPROGRAM]['NAMAGEREJA'].'</strong>';
		echo '<br>';
		echo '<strong class="HEADER">Periode : '.$periode;
		
		echo '<hr></hr>';
			
		
		$sql = "select * from mpelayan 
				where mpelayan.status = 1 and idgereja = {$_SESSION[NAMAPROGRAM]['IDGEREJA']}
				order by mpelayan.namapelayan";
		
		$querypelayan = $CI->db->query($sql)->result();
		
		foreach($querypelayan as $row)
		{
			echo $row->panggilan.' '.$row->namapelayan;
			$content = "";
			$contentDetail = "";
			
			$bulan = $bulanAwal;
			$tahun = $tahunAwal;
			
			$arrJenisPelayanan = [];
			$arrIDJenisPelayanan = [];
		
			$content .= "<th width='40px;' style='background:skyblue;text-align:center;' >Jenis Pelayanan</th>";
			for($a=$bulanAwal;$a < ($bulanAwal+$countBulan) ;$a++)
			{
				$content .= "<th style='background:skyblue; text-align:center;'>".date('F', mktime(0, 0, 0, $bulan, 10))." ".$tahun."</th>";
				
				$sqljenispelayanan = "SELECT c.idjenispelayanan, c.namajenispelayanan
					from tjadwal a
					inner join tjadwaldtl b on a.idjadwal = b.idjadwal
					inner join mjenispelayanan c on b.idjenispelayanan = c.idjenispelayanan
					where a.idgereja = {$_SESSION[NAMAPROGRAM]['IDGEREJA']}
						and a.status = 1 and b.idpelayan = '{$row->idpelayan}' and a.bulan = '".date('F', mktime(0, 0, 0, $bulan, 10))."' and a.tahun = '{$tahun}'
					group by c.idjenispelayanan
				";
				
				$queryJenisPelayanan = $CI->db->query($sqljenispelayanan)->result();
			
				foreach($queryJenisPelayanan as $rowJenisPelayanan)
				{
					if (!in_array($rowJenisPelayanan->idjenispelayanan, $arrIDJenisPelayanan)) {
					  array_push($arrIDJenisPelayanan,$rowJenisPelayanan->idjenispelayanan);
					  array_push($arrJenisPelayanan,$rowJenisPelayanan->namajenispelayanan);
					}
				}
				
				if($bulan == 12)
				{
					$bulan = 1;
					$tahun++;
				}
				else
				{
					$bulan++;
				}			
			}
		
			$content .= "<th colspan='2' style='background:skyblue; text-align:center;'>Total Pelayanan</th>";
			
			//DAPATKAN GRUP JENISPELAYANAN JADWAL
		
			for($i = 0 ; $i < count($arrIDJenisPelayanan);  $i++){
							
				$bulan = $bulanAwal;
				$tahun = $tahunAwal;
				
				$totaljmlpelayanan = 0;
			
				$contentDetail .= "<tr>";
				$contentDetail .= "<td class='border-right' align='center'>".$arrJenisPelayanan[$i]."</td>";
				for($a=$bulanAwal;$a < ($bulanAwal+$countBulan) ;$a++)
				{			
					
					$sql = "SELECT count(a.idjadwal) as jmlpelayanan 
						from tjadwal a
						inner join tjadwaldtl b on a.idjadwal = b.idjadwal
						inner join mjenispelayanan c on b.idjenispelayanan = c.idjenispelayanan
						where a.idgereja = {$_SESSION[NAMAPROGRAM]['IDGEREJA']}
							and a.status = 1 and b.idpelayan = '{$row->idpelayan}' and b.idjenispelayanan = '".$arrIDJenisPelayanan[$i]."'and a.bulan = '".date('F', mktime(0, 0, 0, $bulan, 10))."' and a.tahun = '{$tahun}'
						group by a.bulan,c.urutan,b.idjenispelayanan";
						
					$jmlpelayanan = $CI->db->query($sql)->row()->jmlpelayanan??0;
				
					$contentDetail .= "<td class='border-right' align='center'>".$jmlpelayanan."x</td>";
					
					$totaljmlpelayanan +=$jmlpelayanan;
					
					if($bulan == 12)
					{
						$bulan = 1;
						$tahun++;
					}
					else
					{
						$bulan++;
					}
		
				}
				$contentDetail .= "<td class='border-right' align='center'>".$totaljmlpelayanan."x</td>";
				$contentDetail .= "</tr>";
			}
			
			
				
				echo '<table>';
		
				echo '<thead>';
				
				echo $content;	
				
				echo '</thead>';
				
				echo '<tbody>';	
				
				echo $contentDetail;							
				
				echo '</tbody>';	
				
				echo '</table> <br>';
		}
		
			
	}
	?>
	</div>
</body>
</html>