<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_master_jenispelayanan extends MY_Model{
	
	public function dataGrid(){
		
		$data = [];		
        $sql = "SELECT a.*
                from mjenispelayanan a
                where a.idgereja = {$_SESSION[NAMAPROGRAM]['IDGEREJA']}
				order BY a.urutan";
	
        $q = $this->db->query($sql);	
        // return $this->db->last_query();
		$data["rows"] = $q->result();
		$data["total"] = count($data["rows"]);
		return $data;
    }
	
	public function comboGrid(){
		
		$sql = "select concat(a.idjenispelayanan,' | ',a.namajenispelayanan) as value, concat(a.namajenispelayanan) as text
				from mjenispelayanan a
				where a.idgereja = {$_SESSION[NAMAPROGRAM]['IDGEREJA']} 
				order BY a.urutan
				";
		$query = $this->db->query($sql);
		
		$data['rows'] = $query->result();
		return $data;
	}
	
	public function getDataJenisPelayanan($idpelayan){
		$sql = "select concat(a.idjenispelayanan,' | ',a.namajenispelayanan) as value, concat(a.namajenispelayanan) as text
				from mjenispelayanan a
				inner join mpelayan_jenispelayanan b on a.idjenispelayanan = b.idjenispelayanan
				where a.idgereja = {$_SESSION[NAMAPROGRAM]['IDGEREJA']} and b.idpelayan = $idpelayan
				order BY a.urutan";
		$query = $this->db->query($sql);
		
		$data['rows'] = $query->result();
		return $data;
	}
	
	public function getUrutan(){
		$sql = "select (max(a.urutan)+1) as urutan
				from mjenispelayanan a
				where a.idgereja = {$_SESSION[NAMAPROGRAM]['IDGEREJA']} ";
		$query = $this->db->query($sql);
		
		$data['rows'] = $query->row();
		return $data;
	}
	
	function simpan($idtrans,$data,$edit){
		// start transaction
		$this->db->trans_begin();
		
		if($edit){
			$this->db->where("idjenispelayanan",$idtrans)
					 ->where('idgereja',$_SESSION[NAMAPROGRAM]['IDGEREJA']);
			$this->db->update('mjenispelayanan',$data);
		}else{
			$this->db->insert('mjenispelayanan',$data);
			$idtrans = $this->db->insert_id();
        }
        
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return 'Simpan Data Gagal <br>Kesalahan Pada Header Data Transaksi';
		}
		
		
		$this->db->trans_commit();
		return '';
	}
	
	function batal($id){
		$this->db->trans_begin();
		
		$this->db->where("idgereja",$_SESSION[NAMAPROGRAM]['IDGEREJA'])
				 ->where('idjenispelayanan',$id)
				 ->delete('mjenispelayanan');
		if ($this->db->trans_status() === FALSE) { 
			$this->trans_rollback();
			return 'Data Jenis Pelayanan Tidak Dapat Dihapus, Data Sudah Digunakan Pada Transaksi'; 
		}
		
		$this->db->trans_commit();
		return '';
	}
	
	function cekNama($namajenispelayanan){
		$sql = 'select count(*) as ada from mjenispelayanan where namajenispelayanan = "'.strtoupper($namajenispelayanan).'"';
		$checkNama = $this->db->query($sql)->row()->ADA;
		
		if($checkNama > 0)
		{
			return 'Sudah Ada Jenis Pelayan dengan Nama Tersebut';
		}
		else
		{			
			return '';
		}
	}
	
	public function getNama($idjenispelayanan){
		
		$sql = "select a.namajenispelayanan
				from mjenispelayanan a
				where a.idgereja = {$_SESSION[NAMAPROGRAM]['IDGEREJA']} and a.idjenispelayanan = {$idjenispelayanan}
				order by a.urutan
				";
		$query = $this->db->query($sql)->row();
		return $query;
	}
}
?>