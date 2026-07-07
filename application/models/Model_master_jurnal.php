<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_master_jurnal extends MY_Model{
    function get($transaksi, $jenis = '', $jenissetting="") {
		$tempSql = ($jenis <> '') ? 	   " and a.jenis = '{$jenis}'" : '';
		$tempSql .= ($jenissetting <> '') ? " and a.jenissetting = '{$jenissetting}'" : '';

		$sql = "select a.*, b.idperkiraan, b.namaperkiraan
				from settingjurnallink a
				left join mperkiraan b on a.kodeperkiraan = b.kodeperkiraan
				where a.idperusahaan = {$_SESSION[NAMAPROGRAM]['IDPERUSAHAAN']} and
				 	   b.idperusahaan = {$_SESSION[NAMAPROGRAM]['IDPERUSAHAAN']} and
				 	   a.transaksi = '{$transaksi}'
				 	   {$tempSql};";
		$q = $this->db->query($sql);
		return $q->result();
	}

	function loadAll() {
		$sql = "select a.*, b.idperkiraan, b.namaperkiraan
				from settingjurnallink a
				left join mperkiraan b on a.kodeperkiraan = b.kodeperkiraan and b.idperusahaan = {$_SESSION[NAMAPROGRAM]['IDPERUSAHAAN']}
				where a.idperusahaan = {$_SESSION[NAMAPROGRAM]['IDPERUSAHAAN']}
				order by a.transaksi, a.urutan, a.saldo, a.jenis";
		$q = $this->db->query($sql);
		return $q->result();
	}

	public function dataGrid($jenissetting,$transaksi){
		$data = [];
		
		$whereTransaksi = "";
		if($transaksi != "")
		{
			$whereTransaksi = "and a.TRANSAKSI = '$transaksi'";
		}
		
		$sql = "select a.*,b.NAMAPERKIRAAN
				from SETTINGJURNALLINK a
				LEFT JOIN MPERKIRAAN b on a.KODEPERKIRAAN = b.KODEPERKIRAAN
				where a.IDPERUSAHAAN = {$_SESSION[NAMAPROGRAM]['IDPERUSAHAAN']} 
						and 1=1	and jenissetting = '$jenissetting' 
						$whereTransaksi
				order by a.urutan";
		$query = $this->db->query($sql);

		$data['rows'] = $query->result();


		return $data;
	}
	
	public function comboGridCaraBayar($transaksi)
	{
		
		$sql = "select a.JENIS as VALUE, a.JENIS as TEXT
				from SETTINGJURNALLINK a
				where a.IDPERUSAHAAN = {$_SESSION[NAMAPROGRAM]['IDPERUSAHAAN']} and JENISSETTING = 'CARABAYAR' and TRANSAKSI = '$transaksi' 
				order by a.urutan";

		//echo $sql;		
		$query = $this->db->query($sql);
		
		$data['rows'] = $query->result();
		return $data;
	}
		
	function simpan($data){
		$this->db->trans_begin();
		
		$this->db->where("IDPERUSAHAAN" ,$data["idperusahaan"]);
		$this->db->where("TRANSAKSI"	,$data["transaksi"]);
		$this->db->where("JENIS"		,$data["jenis"]);
		$this->db->where("JENISSETTING"	,$data["jenissetting"]);
		$this->db->where("SALDO"		,$data["saldo"]);
		$this->db->update('SETTINGJURNALLINK',$data);
		
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return 'Gagal menyimpan pada database';
		}
		
		$this->db->trans_commit();
		return '';
	}
	
	function simpanCaraBayar($dataHeader,$data){ //DARI CONTROLLER LOKASI
		$this->db->trans_begin();
		
		$this->db->where("TRANSAKSI"		,$dataHeader["JENISLOKASI"]);
		$this->db->where("JENISSETTING"		,'CARABAYAR');
		$this->db->delete('SETTINGJURNALLINK');
		
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return 'Gagal menyimpan pada database';
		}
		
		$i=1;
		
		foreach($data as $row)
		{
			
			$dataSimpan = array(
				"IDPERUSAHAAN" => $_SESSION[NAMAPROGRAM]["IDPERUSAHAAN"],
				"JENISSETTING" => "CARABAYAR",
				"TRANSAKSI"    => $dataHeader["JENISLOKASI"],
				"URUTAN"       => $i,
				"JENIS"        => $row->jenis,
				"KODEPERKIRAAN"=> $row->kodeperkiraan,
				"SALDO"		   => 'DEBET',
				"CHARGE"	   => $row->charge??0,
			
			);
			
			$this->db->insert('SETTINGJURNALLINK',$dataSimpan);
			
			$i++;
			
			if ($this->db->trans_status() === FALSE){
				$this->db->trans_rollback();
				return 'Gagal menyimpan pada database';
			}
		
		}
		
		$this->db->trans_commit();
		return '';
	}
	
	function hapusCaraBayar($jenislokasi){ //DARI CONTROLLER LOKASI
		$this->db->trans_begin();
		
		$this->db->where("TRANSAKSI"		,$jenislokasi);
		$this->db->where("JENISSETTING"		,'CARABAYAR');
		$this->db->delete('SETTINGJURNALLINK');
		
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return 'Gagal menyimpan pada database';
		}
		
		$this->db->trans_commit();
		return '';
	}
}
?>