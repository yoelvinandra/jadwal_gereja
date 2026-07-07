<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends MY_Controller {
	public function __construct()
	{
		parent::__construct();
	}
	
	public function laporan()
	{		
		$data['errorMsg'] = '';
		
		$bulanAwal  = $this->input->post('blnAw');
		$tahunAwal  = $this->input->post('thnAw');
		$bulanAkhir = $this->input->post('blnAk');
		$tahunAkhir = $this->input->post('thnAk');
		$pelayanAktifSaja = $this->input->post('pelayanAktifSaja');
		$tampil     = $this->input->post('data_tampil');
		
		if($pelayanAktifSaja == 1)
		{
		    $wherePelayanAktif = "AND MPELAYAN.STATUS = ".$pelayanAktifSaja;
		}
		
		if($tampil == "DAFTAR PELAYAN"){
		
			$sql = "SELECT * FROM MPELAYAN WHERE IDGEREJA = {$_SESSION[NAMAPROGRAM]['IDGEREJA']} $wherePelayanAktif  ORDER BY NAMAPELAYAN,STATUS desc";
		}
		else if($tampil == "DAFTAR PELAYANAN"){
			
			$sql = "SELECT a.idjenispelayanan,a.namajenispelayanan,if(mpelayan.idpelayan is null ,'',mpelayan.idpelayan) as idpelayan,if(mpelayan.panggilan is null ,'',mpelayan.panggilan) as panggilan,if(mpelayan.namapelayan is null ,'',mpelayan.namapelayan) as namapelayan,a.status 
                from mjenispelayanan a
				left join mpelayan_jenispelayanan b on a.idjenispelayanan = b.idjenispelayanan
				left join mpelayan  on mpelayan.idpelayan = b.idpelayan
                where a.idgereja = {$_SESSION[NAMAPROGRAM]['IDGEREJA']} $wherePelayanAktif
				order BY a.urutan,mpelayan.namapelayan";
		}
		else if($tampil == "JADWAL PELAYANAN"){
			// buat parameter tgl
			$countBulan = 0;
			
			
			
			if($bulanAwal > $bulanAkhir  && $tahunAwal < $tahunAkhir )
			{
				$countBulan = ($bulanAkhir+12) - ($bulanAwal - 1);
			}else
			{
				$countBulan = $bulanAkhir - $bulanAwal+1;
			}
			
			if($bulanAwal == 1)
			{
				$paramTgl = array($this->makeFirstDate(12, $tahunAwal-1), $this->makeLastDate(12, $tahunAwal-1));
			}
			else
			{
				$paramTgl = array($this->makeFirstDate($bulanAwal-1, $tahunAwal), $this->makeLastDate($bulanAwal-1, $tahunAwal));
			}
			
			$tahun = $tahunAwal;
			$bulan = $bulanAwal;

			
			if($bulanAwal == $bulanAkhir && ($tahunAkhir - $tahunAwal) > 0){
				$data['errorMsg'] = 'Maks. Range Periode hanya 12 Bulan ';
			}
			
			
			if (($countBulan	< 1 || $countBulan > 12) || ($tahunAkhir - $tahunAwal) > 1 ) {
				$data['errorMsg'] = 'Maks. Range Periode hanya 12 Bulan ';
			}
			
			
			
			for ($i = 0; $i < $countBulan; $i++) {
				
				$paramTgl[] = $this->makeFirstDate($bulan, $tahun);
				$paramTgl[] = $this->makeLastDate($bulan, $tahun);
				
				if($bulan == 12)
				{
					$tahun++;
					$bulan = 1;
				}
				else
				{
					$bulan++;
				}
			}
			$data['tgl']	  = $paramTgl;
		
		}
		
		else if($tampil == "TOTAL PELAYANAN"){
			// buat parameter tgl
			$countBulan = 0;
			
			
			
			if($bulanAwal > $bulanAkhir  && $tahunAwal < $tahunAkhir )
			{
				$countBulan = ($bulanAkhir+12) - ($bulanAwal - 1);
			}else
			{
				$countBulan = $bulanAkhir - $bulanAwal+1;
			}
			
			$tahun = $tahunAwal;
			$bulan = $bulanAwal;

			
			if($bulanAwal == $bulanAkhir && ($tahunAkhir - $tahunAwal) > 0){
				$data['errorMsg'] = 'Maks. Range Periode hanya 12 Bulan ';
			}
			
			
			if (($countBulan	< 1 || $countBulan > 12) || ($tahunAkhir - $tahunAwal) > 1 ) {
				$data['errorMsg'] = 'Maks. Range Periode hanya 12 Bulan ';
			}
		
		}
	
		//$whereLokasiHeader = " and a.kodelokasi = '{$lokasi}' ";
		//$whereLokasi = " and c.kodelokasi = '{$lokasi}' ";

		$data['periode']     = date('F', mktime(0, 0, 0, $bulanAwal, 10)).' '.$tahunAwal.' s/d '.date('F', mktime(0, 0, 0, $bulanAkhir, 10)).' '.$tahunAkhir;
		$data['tahunAwal']	 = $tahunAwal;
		$data['bulanAwal']	 = $bulanAwal;
		$data['tampil']      = $tampil;
		$data['sql'] 		 = $sql;
		$data['countBulan']  = $countBulan;
		$data['excel']       = $this->input->post('excel');
		$data['filename']    = $this->input->post('file_name');
		
		$dir = 'reports/v_';
		
		if($data['errorMsg'] != ''){
			echo "<script>alert('".$data['errorMsg']."'); window.close();</script>";
		}
		else
		{	
	
			$this->load->view($dir."report.php",$data);
		}
		
	}

	function makeFirstDate($bulan, $tahun) {
		return date('Y.m.d', mktime(0, 0, 0, $bulan, 1, $tahun));
	}
	function makeLastDate($bulan, $tahun) {
		return date('Y.m.t', mktime(0, 0, 0, $bulan, 1, $tahun));
	}
	function makeDate($a, $b, $c, $d) {
		return [
			'tgl_aw' => date('Y.m.d', mktime(0, 0, 0, $a, 1, $b)),
			'tgl_ak' => date('Y.m.t', mktime(0, 0, 0, $c, 1, $d))
		];
	}
}
