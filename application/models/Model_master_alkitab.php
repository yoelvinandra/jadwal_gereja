<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_master_alkitab extends MY_Model{
	
	public function dataGrid(){
		
		$data = [];		
        $sql = "SELECT a.idlagu,a.namalagu,a.namapenyanyi,a.lirik,CONCAT(SUBSTRING(a.lirik,1,75),'...') as liriksingkat,a.status
                from mlagu a
				order BY a.namalagu";
	
        $q = $this->db->query($sql);	
        // return $this->db->last_query();
		$data["rows"] = $q->result();
		$data["total"] = count($data["rows"]);
		return $data;
    }
    
    public function comboGrid(){
		
		$sql = "select concat(a.urutankitab,'-',a.totalpasal,'-',a.namasingkat) as value, a.namakitab as text from malkitab a group by a.urutankitab order by a.urutankitab";
		$query = $this->db->query($sql);
		
		$data['rows'] = $query->result();
		return $data;
	}
	
// 	public function comboGridPasalAyat(){
		
// 		$sql = "select concat(urutankitab,'-',totalpasal,'-',totalayat) as value, concat(namasingkat,' ',pasal,':', ayat) as text from malkitab where tipe = 'CONTENT' group by urutankitab order by urutankitab";
// 		$query = $this->db->query($sql);
		
// 		$data['rows'] = $query->result();
// 		return $data;
// 	}
	
	function getAllAlkitab(){
	    $sql = "select urutankitab, pasal, ayat, text from malkitab where tipe = 'CONTENT'";
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	
	function getAyat($urutankitab,$pasal){
// 	    $sql = "select * from malkitab where urutankitab = {$urutankitab} and pasal = {$pasal} and tipe = 'CONTENT'";
// 		$query = $this->db->query($sql);
// 		return $query->result();
        $ayat = [];
        foreach($_SESSION[NAMAPROGRAM]['ALKITAB'] as $item)
        {
            if($item->urutankitab == $urutankitab && $item->pasal == $pasal)
            {
                array_push($ayat,[
                    'urutankitab'   => $item->urutankitab,
                    'pasal'         => $item->pasal,
                    'ayat'          => $item->ayat,
                    'text'          => $item->text
                ]);
            }
        }
            
        return $ayat;
	}
	
	function simpanDataAPI($urutankitab,$kitab,$chapter,$ayat){
		// start transaction
		$this->db->trans_begin();
		
		$data = array (
		    "namakitab" => $kitab['name'],
		    "urutankitab" => $urutankitab,
		    "namasingkat" => $kitab['abbr'],
		    "totalpasal" => 0,
		    "pasal" => $chapter,
		    "totalayat" => 0,
		    "ayat" => $ayat['verse'],
		    "tipe" => $ayat['type'],
		    "text" => $ayat['content'],
		);
		$this->db->insert('malkitab',$data);
        
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return "ERROR ".$data['tipe']." ".$data['namakitab']." ".$data['pasal']." : ".$data['ayat'];
		}
		
		$this->db->trans_commit();
		return '';
	}
	
	function updateTotalPasal($urutankitab){
		// start transaction
		$this->db->trans_begin();
		
		$sql = "SELECT MAX(pasal) as maxpasal FROM malkitab WHERE urutankitab = {$urutankitab}";
		$kitab = $this->db->query($sql)->result();
		
		foreach($kitab as $itemKitab)
		{
		    for($x = 0 ; $x <= $itemKitab->maxpasal;$x++)
		    {
        		        $sql = "update malkitab SET totalayat = (SELECT MAX(ayat) FROM malkitab WHERE urutankitab = {$urutankitab}   and pasal = {$x} ) where urutankitab = {$urutankitab}  and pasal = {$x}";
        		
        		$this->db->query($sql);
		    }
		}
		
		
		$this->db->trans_commit();
		return '';
	}
}
?>