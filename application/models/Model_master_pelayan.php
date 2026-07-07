<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_master_pelayan extends MY_Model{
	
	public function dataGrid(){
		
		$data = [];		
        $sql = "SELECT a.*,group_concat(c.namajenispelayanan) as jenispelayanan
                from mpelayan a
				inner join mpelayan_jenispelayanan b on a.idpelayan = b.idpelayan
                inner join mjenispelayanan c on b.idjenispelayanan = c.idjenispelayanan
				where a.idgereja = {$_SESSION[NAMAPROGRAM]['IDGEREJA']}
				group by a.idpelayan
				order BY a.namapelayan";
	
        $q = $this->db->query($sql);	
        // return $this->db->last_query();
		$data["rows"] = $q->result();
		$data["total"] = count($data["rows"]);
		return $data;
    }
	
	public function comboGridPanggilan(){
		
		$sql = "select a.panggilan as value, a.panggilan as text
				from mpelayan a
				where a.idgereja = {$_SESSION[NAMAPROGRAM]['IDGEREJA']} 
				group by a.panggilan
				";
		$query = $this->db->query($sql);
		
		$data['rows'] = $query->result();
		return $data;
	}
	
	function simpan($idtrans,$data,$jenispelayanan,$edit){
		// start transaction
		$this->db->trans_begin();
		
		if($edit){
			$this->db->where("idpelayan",$idtrans)
					 ->where('idgereja',$_SESSION[NAMAPROGRAM]['IDGEREJA']);
			$this->db->update('mpelayan',$data);
		}else{
			$this->db->insert('mpelayan',$data);
			$idtrans = $this->db->insert_id();
        }
        
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return 'Simpan Data Gagal <br>Kesalahan Pada Header Data Transaksi';
		}
		
		$this->db->where("idpelayan",$idtrans)
					 ->where('idgereja',$_SESSION[NAMAPROGRAM]['IDGEREJA']);
					 
		$this->db->delete('mpelayan_jenispelayanan');
			
		for($i = 0; $i < count($jenispelayanan) ; $i++){
			
			$data = array(
				'idgereja' => $_SESSION[NAMAPROGRAM]['IDGEREJA'],
				'idpelayan' => $idtrans,
				'idjenispelayanan' => explode("|",$jenispelayanan[$i])[0],
			);
			
			$this->db->insert('mpelayan_jenispelayanan',$data);
			
		}
		
		$this->db->trans_commit();
		return '';
	}
	
	function batal($id){
		$this->db->trans_begin();
		
		$this->db->where("idgereja",$_SESSION[NAMAPROGRAM]['IDGEREJA'])
				 ->where('idpelayan',$id)
				 ->delete('mpelayan');
		if ($this->db->trans_status() === FALSE) { 
			$this->trans_rollback();
			return 'Data Pelayan Tidak Dapat Dihapus, Data Sudah Digunakan Pada Transaksi'; 
		}
		
		$this->db->where("idgereja",$_SESSION[NAMAPROGRAM]['IDGEREJA'])
				 ->where('idpelayan',$id)
				 ->delete('mpelayan_jenispelayanan');
				 
		if ($this->db->trans_status() === FALSE) { 
			$this->trans_rollback();
			return 'Data Pelayan pada Jenis Pelayanan Tidak Dapat Dihapus, Data Sudah Digunakan Pada Transaksi'; 
		}
		
		$this->db->trans_commit();
		return '';
	}
	
	function cekNama($namapelayan){
		$sql = 'select count(*) as ada from mpelayan where namapelayan = "'.strtoupper($namapelayan).'"';
		$checkNama = $this->db->query($sql)->row()->ADA;
		
		if($checkNama > 0)
		{
			return 'Sudah Ada Pelayan dengan Nama Tersebut';
		}
		else
		{			
			return '';
		}
	}
	
	function getPelayanX(){
		$sql = 'select idpelayan,namapelayan from mpelayan where panggilan = "X" and idgereja = '.$_SESSION[NAMAPROGRAM]['IDGEREJA'].'';
		$dataPelayan = $this->db->query($sql)->row();
		
		return $dataPelayan;
	}
}
?>