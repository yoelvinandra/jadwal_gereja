<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_jadwal_pelayanan extends MY_Model{
	
	public function dataGrid(){
		
		$data = [];		
        $sql = "SELECT a.*
                from tjadwal a
                where a.idgereja = {$_SESSION[NAMAPROGRAM]['IDGEREJA']}
				order BY a.tahun DESC,a.bulanangka DESC";
	
        $q = $this->db->query($sql);	
        // return $this->db->last_query();
		$data["rows"] = $q->result();
		$data["total"] = count($data["rows"]);
		return $data;
    }
	
	public function dataGridDetail($bulan,$tahun){
		
		$data = [];		
        $sql = "SELECT a.idjadwal,b.tanggal,c.namapelayan,c.panggilan,c.telp,d.namajenispelayanan,d.urutan,c.idpelayan,d.idjenispelayanan, a.catatan,a.status,b.catatan as catatandetail
                from tjadwal a
				inner join tjadwaldtl b on a.idjadwal = b.idjadwal
				left join  mpelayan c on b.idpelayan = c.idpelayan 
				inner join mjenispelayanan d on b.idjenispelayanan = d.idjenispelayanan 
                where a.idgereja = {$_SESSION[NAMAPROGRAM]['IDGEREJA']} and a.bulan = '$bulan' and a.tahun = '$tahun'
				order BY b.tanggal ASC,d.urutan asc";
	
        $q = $this->db->query($sql);	
        // return $this->db->last_query();
		$data["rows"] = $q->result();
		$data["total"] = count($data["rows"]);
		return $data;
    }
	
	public function generateDataGrid($bulan,$tahun,$tanggalselainminggu=""){
		
		$dataminggu = [];
		
		$begin  = new DateTime(date('Y-m-d', mktime(0, 0, 0, $bulan, 1, $tahun)));
		$end    = new DateTime(date('Y-m-t', mktime(0, 0, 0, $bulan, 1, $tahun)));
		while ($begin <= $end) // Loop will work begin to the end date 
		{
			if($begin->format("D") == "Sun") //Check that the day is Sunday here
			{
				array_push($dataminggu,$begin->format("Y-m-d"));
			}
			else
			{
			    if($tanggalselainminggu != "")
			    {
        		    if($tanggalselainminggu == $begin->format("Y-m-d")){
        		       array_push($dataminggu,$begin->format("Y-m-d"));
        		    }
			    }
		    
			}

			$begin->modify('+1 day');
		}	
			
        $sql = "SELECT a.*
                from tjadwal a
                where a.idgereja = {$_SESSION[NAMAPROGRAM]['IDGEREJA']}
					and a.status = 1 and a.bulan = '".date('F', mktime(0, 0, 0, $bulan, 10))."' and a.tahun = '$tahun'";
	
        $q = $this->db->query($sql)->result();	
	
		if($q != null)
		{
			return "Jadwal Bulan ".date('F', mktime(0, 0, 0, $bulan, 10))." ".$tahun." Sudah Pernah Dibuat";
		}
		
		$sql = "select idjenispelayanan, namajenispelayanan from mjenispelayanan where idgereja = {$_SESSION[NAMAPROGRAM]['IDGEREJA']} and  status = 1 order by urutan";
		$datajenispelayanan = $this->db->query($sql)->result();
		
		$data = [];
		
		for($i = 0 ; $i < count($dataminggu) ; $i++)
		{
			$datapelayan = [];
			foreach($datajenispelayanan as $row)
			{
				$sqlpelayan = "select mpelayan.idpelayan,mpelayan.namapelayan
								from mpelayan_jenispelayanan
								inner join mpelayan on mpelayan.idpelayan = mpelayan_jenispelayanan.idpelayan
								where mpelayan_jenispelayanan.idgereja = {$_SESSION[NAMAPROGRAM]['IDGEREJA']} and mpelayan.status = 1 and mpelayan.namapelayan <> 'X' and  mpelayan_jenispelayanan.idjenispelayanan = ".$row->idjenispelayanan;
				$datanamapelayan = $this->db->query($sqlpelayan)->result();
				
				//random dari pelayan2x yang ada
				$pelayan = $datanamapelayan[rand(0,count($datanamapelayan)-1)];
				
				$data_values = array(
					'tanggal' 			=> $dataminggu[$i],
					'idpelayan' 		=> $pelayan->idpelayan??"0",
					'idjenispelayanan' 	=> $row->idjenispelayanan,
					'namapelayan' 		=> $pelayan->namapelayan??"",
					'namajenispelayanan'=> $row->namajenispelayanan,
					'warna'				=> '',
				);
				
				for($c = 0 ; $c < count($datapelayan) ; $c++)
				{
					if($pelayan->namapelayan == $datapelayan[$c]['namapelayan']){
						$datapelayan[$c]['warna'] = 'orange';
						$data_values['warna'] = 'orange';
					}
				}
				
				array_push($datapelayan,$data_values);
			}
			
			array_push($data,$datapelayan);
		}
		
		$data["rows"] = $data;
		
		return $data;
    }
    
    function simpan($idtrans,$data,$data_pelayan,$edit){
		// start transaction
		$this->db->trans_begin();
		
		if($edit){
			$this->db->where("idjadwal",$idtrans)
					 ->where('idgereja',$_SESSION[NAMAPROGRAM]['IDGEREJA']);
			$this->db->update('tjadwal',$data);
		}else{
		
			$this->db->insert('tjadwal',$data);
			$idtrans = $this->db->insert_id();
        }
        
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return 'Simpan Data Gagal <br>Kesalahan Pada Header Data Transaksi';
		}
		
		$sqljenispelayanan = "select mjenispelayanan.idjenispelayanan
						from mjenispelayanan
						where mjenispelayanan.idgereja = {$_SESSION[NAMAPROGRAM]['IDGEREJA']} and mjenispelayanan.status = 1
						order by mjenispelayanan.urutan
		";
		
		$queryjenispelayanan = $this->db->query($sqljenispelayanan)->result();
		
		$this->db->where("idjadwal",$idtrans)
				 ->where('idgereja',$_SESSION[NAMAPROGRAM]['IDGEREJA']);
		$this->db->delete('tjadwaldtl');
		
		if ($this->db->trans_status() === FALSE) { 
			$this->db->trans_rollback();
			return 'Data Jadwal Tidak Dapat Dibatalkan'; 
		}
				 
		for($i = 0 ; $i < count($data_pelayan);$i++)
		{
			$j=1;// UNTUK NAMA, YANG 0 TANGGAL
			
			foreach($queryjenispelayanan as $rowsJenisPelayanan)
			{
			    if($j <= count($queryjenispelayanan))
			    {
    				$idjenispelayanan = $rowsJenisPelayanan->idjenispelayanan;
    				
    				$sqlpelayan = "select mpelayan.idpelayan
    								from mpelayan
    								where mpelayan.idgereja = {$_SESSION[NAMAPROGRAM]['IDGEREJA']} and mpelayan.namapelayan = '{$data_pelayan[$i][$j]}'
    				 ";
    				$idpelayan = $this->db->query($sqlpelayan)->row()->idpelayan;
    				
    				$tgl = explode(' / ',$data_pelayan[$i][0]);
    				
    				if(strlen($data['BULANANGKA']) == 1)
    				{
    					$data['BULANANGKA'] = '0'.$data['BULANANGKA'];
    				}
    				$data_jadwal = array(
    					'idgereja'	   		=> $_SESSION[NAMAPROGRAM]['IDGEREJA'],
    					'idjadwal'     		=> $idtrans,
    					'idpelayan'   		=> $idpelayan,
    					'idjenispelayanan'  => $idjenispelayanan,
    					'tanggal'  			=> $tgl[2].'-'.$data['BULANANGKA'].'-'.$tgl[0],
    					'catatan'           => $data_pelayan[$i][count($data_pelayan[$i])-1]
    				);
    				
    				$exe = $this->db->insert('tjadwaldtl',$data_jadwal);
    				if($this->db->trans_status === false){
    					$this->db->trans_rollback();
    					return 'Menyimpan Tjadwaldtl Gagal';
    				}
			    }
				$j++;
			}
		}
		$this->db->trans_commit();
		return '';
	}
	
	function batal($id){
		$this->db->trans_begin();
		
		$this->db->where("idgereja",$_SESSION[NAMAPROGRAM]['IDGEREJA'])
				 ->where('idjadwal',$id)
				 ->delete('tjadwal');
				 
		if ($this->db->trans_status() === FALSE) { 
			$this->trans_rollback();
			return 'Data Header Jadwal Tidak Dapat Dihapus, Data Sudah Digunakan Pada Transaksi'; 
		}
		
		$this->db->where("idgereja",$_SESSION[NAMAPROGRAM]['IDGEREJA'])
				 ->where('idjadwal',$id)
				 ->delete('tjadwaldtl');
				 
		if ($this->db->trans_status() === FALSE) { 
			$this->trans_rollback();
			return 'Data Detail Jadwal Tidak Dapat Dihapus, Data Sudah Digunakan Pada Transaksi'; 
		}
		
		$this->db->trans_commit();
		return '';
	}
	
	public function getDataPelayan($idjenispelayanan,$tgl){
		
		if($idjenispelayanan != "")
		{
			$whereJenisPelayanan = "and mpelayan_jenispelayanan.idjenispelayanan = ".$idjenispelayanan;
		}
			
        $sql = "select mpelayan.idpelayan,mpelayan.namapelayan,mpelayan.telp, '' as namajadwaltabrakan
								from mpelayan
								inner join mpelayan_jenispelayanan on mpelayan.idpelayan = mpelayan_jenispelayanan.idpelayan
								where mpelayan_jenispelayanan.idgereja = {$_SESSION[NAMAPROGRAM]['IDGEREJA']} and mpelayan.status = 1 $whereJenisPelayanan
								group by mpelayan.idpelayan
								;
				";
        $data['rows'] = $this->db->query($sql)->result();
        
        //CEK DENGAN SEKOLAH MINGGU
        if($idjenispelayanan != "" && $_SESSION[NAMAPROGRAM]['IDGEREJA'] == 1)
		{
            foreach($data['rows'] as $rs){
                
                $sqljadwal = "select mjenispelayanan.namajenispelayanan from tjadwaldtl
                              left join mpelayan on mpelayan.idpelayan = tjadwaldtl.idpelayan
                              left join mjenispelayanan on mjenispelayanan.idjenispelayanan = tjadwaldtl.idjenispelayanan
                              where tjadwaldtl.tanggal = '".$tgl."' and mpelayan.namapelayan = '".$rs->namapelayan."' and tjadwaldtl.idgereja = 3";  
                $dataSM = $this->db->query($sqljadwal)->result();
                $label = "";
                $index = 0 ;
                foreach($dataSM as $rsSM){
                    if($index > 0)
                    {
                        $label .= ", ";
                    }
                    $label .= $rsSM->namajenispelayanan;
                    $index++;
                }
                if($label != "")
                {
                    $rs->namajadwaltabrakan = $label." di Sekolah Minggu"; 
                }
            }
            
            foreach($data['rows'] as $rs){
                
                $sqljadwal = "select mjenispelayanan.namajenispelayanan from tjadwaldtl
                              left join mpelayan on mpelayan.idpelayan = tjadwaldtl.idpelayan
                              left join mjenispelayanan on mjenispelayanan.idjenispelayanan = tjadwaldtl.idjenispelayanan
                              where tjadwaldtl.tanggal = '".$tgl."' and mpelayan.namapelayan = '".$rs->namapelayan."' and tjadwaldtl.idgereja = 2";  
                $dataSM = $this->db->query($sqljadwal)->result();
                $label = "";
                $index = 0 ;
                foreach($dataSM as $rsSM){
                    if($index > 0)
                    {
                        $label .= ", ";
                    }
                    $label .= $rsSM->namajenispelayanan;
                    $index++;
                }
                if($label != "")
                {
                    if($rs->namajadwaltabrakan != "")
                    {
                        $rs->namajadwaltabrakan .= ", ";
                    }
                    $rs->namajadwaltabrakan .= $label." di Youth"; 
                }
            }
		}
		else if($idjenispelayanan != "" && $_SESSION[NAMAPROGRAM]['IDGEREJA'] == 2)
		{
            foreach($data['rows'] as $rs){
                
                $sqljadwal = "select mjenispelayanan.namajenispelayanan from tjadwaldtl
                              left join mpelayan on mpelayan.idpelayan = tjadwaldtl.idpelayan
                              left join mjenispelayanan on mjenispelayanan.idjenispelayanan = tjadwaldtl.idjenispelayanan
                              where tjadwaldtl.tanggal = '".$tgl."' and mpelayan.namapelayan = '".$rs->namapelayan."' and tjadwaldtl.idgereja = 1";  
                $dataSM = $this->db->query($sqljadwal)->result();
                $label = "";
                $index = 0 ;
                foreach($dataSM as $rsSM){
                    if($index > 0)
                    {
                        $label .= ", ";
                    }
                    $label .= $rsSM->namajenispelayanan;
                    $index++;
                }
                
                if($label != "")
                {
                $rs->namajadwaltabrakan = $label." di Umum"; 
                }
            }
		}
		else if($idjenispelayanan != "" && $_SESSION[NAMAPROGRAM]['IDGEREJA'] == 3)
		{
            foreach($data['rows'] as $rs){
                
                $sqljadwal = "select mjenispelayanan.namajenispelayanan from tjadwaldtl
                              left join mpelayan on mpelayan.idpelayan = tjadwaldtl.idpelayan
                              left join mjenispelayanan on mjenispelayanan.idjenispelayanan = tjadwaldtl.idjenispelayanan
                              where tjadwaldtl.tanggal = '".$tgl."' and mpelayan.namapelayan = '".$rs->namapelayan."' and tjadwaldtl.idgereja = 1";  
                $dataSM = $this->db->query($sqljadwal)->result();
                $label = "";
                $index = 0 ;
                foreach($dataSM as $rsSM){
                    if($index > 0)
                    {
                        $label .= ", ";
                    }
                    $label .= $rsSM->namajenispelayanan;
                    $index++;
                }
                
                if($label != "")
                {
                $rs->namajadwaltabrakan = $label." di Umum"; 
                }
            }
		}
        
		return $data;
    }
}
?>