<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Guest extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function index()
	{
		$this->load->view('header_css');
		$this->load->view('guest');
	}
	
	public function lihatJadwal()
	{
	    $idpelayan = $this->input->post('idpelayan');
	    
		$this->load->view('header_css');
		$sql = "SELECT a.idjenispelayanan,a.namajenispelayanan,if(mpelayan.idpelayan is null ,'',mpelayan.idpelayan) as idpelayan,if(mpelayan.panggilan is null ,'',mpelayan.panggilan) as panggilan,if(mpelayan.namapelayan is null ,'',mpelayan.namapelayan) as namapelayan,a.status 
            from mjenispelayanan a
			left join mpelayan_jenispelayanan b on a.idjenispelayanan = b.idjenispelayanan
			left join mpelayan  on mpelayan.idpelayan = b.idpelayan
            where a.idgereja = {$_SESSION[NAMAPROGRAM]['IDGEREJA']} and a.STATUS = 1
			order BY a.urutan,mpelayan.namapelayan";
				
		// buat parameter tgl
		$countBulan = 0;
		
		$tglnow = $this->input->post('bulantahunberikutnya') != null? $this->input->post('bulantahunberikutnya')."-01":date('Y-m-d');
	
		$month = explode('-',$tglnow);
		
		if($month[1] % 3 == 1)
		{
		    $arrDateAwal =  explode('-',$tglnow);
		    $arrDateAkhir = explode('-',date('Y-m', strtotime('+2 months', strtotime($tglnow))));
		    $arrDateDepan = explode('-',date('Y-m', strtotime('+3 months', strtotime($tglnow))));
		}
		else if($month[1] % 3 == 2)
		{
		    $arrDateAwal =  explode('-',date('Y-m', strtotime('-1 months', strtotime($tglnow))));
		    $arrDateAkhir = explode('-',date('Y-m', strtotime('+1 months', strtotime($tglnow))));
		     $arrDateDepan = explode('-',date('Y-m', strtotime('+2 months', strtotime($tglnow))));
		    
		}
		else if($month[1] % 3 == 0)
		{
		    $arrDateAwal =  explode('-',date('Y-m', strtotime('-2 months', strtotime($tglnow))));
		    $arrDateAkhir = explode('-',$tglnow);
		    $arrDateDepan = explode('-',date('Y-m', strtotime('+1 months', strtotime($tglnow))));
		}
		
		$bulanAwal  = $arrDateAwal[1]; 
    	$bulanAkhir = $arrDateAkhir[1]; 
    		
    	$tahunAwal  = $arrDateAwal[0]; 
    	$tahunAkhir = $arrDateAkhir[0]; 
		
		if($bulanAwal > $bulanAkhir && $tahunAwal < $tahunAkhir )
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
		$data['periode']     = date('F', mktime(0, 0, 0, $bulanAwal, 10)).' '.$tahunAwal.' s/d '.date('F', mktime(0, 0, 0, $bulanAkhir, 10)).' '.$tahunAkhir;
		$data['idpelayan']   = $idpelayan;
		$data['tahunAwal']	 = $tahunAwal;
		$data['bulanAwal']	 = $bulanAwal;
		$data['tampil']      = "JADWAL PELAYANAN";
		$data['sql'] 		 = $sql;
		$data['countBulan']  = $countBulan;
		$data['guest']       = true;
		$data['excel']       = false;
		$data['filename']    = $this->input->post('file_name');
		
		//CHECK ADA JADWAL KEDEPAN
		$sqlCheck = "select count(*) as ada from tjadwal where bulanangka = '".(int)$arrDateDepan[1]."' and tahun = '".(int)$arrDateDepan[0]."' and idgereja = {$_SESSION[NAMAPROGRAM]['IDGEREJA']}";
		
		$data['jadwalberikutnya'] = $this->db->query($sqlCheck)->row()->ada;
		$data['bulantahunberikutnya'] = $arrDateDepan[0]."-".$arrDateDepan[1];
		
		$dir = 'reports/v_';
		
		if($data['errorMsg'] != ''){
			echo "<script>alert('".$data['errorMsg']."'); window.close();</script>";
		}
		else
		{	
	
			return $this->load->view($dir."report.php",$data);
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
