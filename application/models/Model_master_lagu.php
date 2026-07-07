<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_master_lagu extends MY_Model{
	
	public function dataGrid(){
		
		$data = [];		
        $sql = "SELECT a.idlagu,a.namalagu,a.namapenyanyi,a.lirik,CONCAT(SUBSTRING(a.lirik,1,75),'...') as liriksingkat,a.status
                from mlagu a
                where a.idgereja = {$_SESSION[NAMAPROGRAM][IDGEREJA]}
				order BY a.namalagu";
	
        $q = $this->db->query($sql);	
        // return $this->db->last_query();
		$data["rows"] = $q->result();
		$data["total"] = count($data["rows"]);
		return $data;
    }
    
    public function dataGridListLagu($idlist){
		
		$data = [];	
		if($idlist != "")
		{
            $sql = "SELECT a.idlistlagu,a.idlagu,a.tanggal,b.namalagu,b.namapenyanyi,b.lirik,a.ukuranfont
                    from tlistlagu a
                    inner join mlagu b on a.idlagu = b.idlagu
                    where a.idlistlagu = {$idlist} and a.idgereja = {$_SESSION[NAMAPROGRAM][IDGEREJA]}
    				order BY a.urutan asc";
    	
            $q = $this->db->query($sql);	
           	$data["rows"] = $q->result();
        	$data["total"] = count($data["rows"]);
		}
		else
		{
		    $data["rows"] = [];
		    $data["total"] = 0;
		}
		return $data;
    }
	
	public function comboGrid(){
		$data = [];	
		if(isset($_SESSION[NAMAPROGRAM][IDGEREJA]))
		{
           		$sql = "select a.lirik as value, a.namalagu as text
				from mlagu a
				where a.idgereja = ".$_SESSION[NAMAPROGRAM][IDGEREJA];
    	
            $q = $this->db->query($sql);	
           	$data["rows"] = $q->result();
		}
		else
		{
		    $data["rows"] = [];
		}
		return $data;
	}
    
    public function comboGridListLagu(){
		$data = [];	
		if(isset($_SESSION[NAMAPROGRAM][IDGEREJA]))
		{
           	$sql = "select a.idlistlagu as value, a.namalistlagu as text
				from tlistlagu a
				where a.idgereja = {$_SESSION[NAMAPROGRAM][IDGEREJA]}
				group by a.idlistlagu";
    	
            $q = $this->db->query($sql);	
           	$data["rows"] = $q->result();
		}
		else
		{
		    $data["rows"] = [];
		}
		return $data;
	}
	
	function simpan($idtrans,$data,$edit){
		// start transaction
		$this->db->trans_begin();
		
		if($edit){
			$this->db->where("idlagu",$idtrans);
			$this->db->where("idgereja",$_SESSION[NAMAPROGRAM][IDGEREJA]);
			$this->db->update('mlagu',$data);
		}else{
			$this->db->insert('mlagu',$data);
			$idtrans = $this->db->insert_id();
        }
        
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return 'Simpan Data Gagal <br>Kesalahan Pada Header Data Transaksi';
		}
		
		$this->db->trans_commit();
		return '';
	}
	
	function simpanListLagu($detail,$edit){
		// start transaction
		$this->db->trans_begin();
		
		if($edit){
			$this->db->where("idlistlagu",$detail[0]['idlistlagu'])
			->where("idgereja",$_SESSION[NAMAPROGRAM][IDGEREJA])
			->delete('tlistlagu');
		}
		
        foreach($detail as $item)
        {
            $item['idgereja'] = $_SESSION[NAMAPROGRAM][IDGEREJA];
            $this->db->insert('tlistlagu',$item);
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
		
		$this->db->where('idlagu',$id)
		         ->where('idgereja', $_SESSION[NAMAPROGRAM][IDGEREJA])
				 ->delete('mlagu');
		if ($this->db->trans_status() === FALSE) { 
			$this->trans_rollback();
			return 'Data Lagu Tidak Dapat Dihapus, Data Sudah Digunakan Pada Transaksi'; 
		}
		
		$this->db->trans_commit();
		return '';
	}
	
	function cekNama($namapelayan){
		$sql = 'select count(*) as ada from mlagu where namalagu = "'.strtoupper($namapelayan).'" and mlagu.idgereja = '.$_SESSION[NAMAPROGRAM][IDGEREJA];
		$checkNama = $this->db->query($sql)->row()->ADA;
		
		if($checkNama > 0)
		{
			return 'Sudah Ada Lagu dengan Nama Tersebut';
		}
		else
		{			
			return '';
		}
	}
	
	function batalList($id){
		$this->db->trans_begin();
		$this->db->where('idlistlagu',$id)
		         ->where('idgereja', $_SESSION[NAMAPROGRAM][IDGEREJA])
				 ->delete('tlistlagu');
		if ($this->db->trans_status() === FALSE) { 
			$this->trans_rollback();
			return 'Data Lagu Tidak Dapat Dihapus, Data Sudah Digunakan Pada Transaksi'; 
		}
		
		$this->db->trans_commit();
		return '';
	}
	
	function getLaguByID($id){
	    $sql = "select * from mlagu where idlagu = $id and mlagu.idgereja = {$_SESSION[NAMAPROGRAM][IDGEREJA]}";
	    return $this->db->query($sql)->row();
	}
	
	function getIDListLagu(){
	    $sql = "select max(idlistlagu) as idlistlagu from tlistlagu";
	    return ($this->db->query($sql)->row()->idlistlagu+1);
	}
}
?>