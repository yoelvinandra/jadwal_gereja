<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pelayan extends MY_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model(['model_master_pelayan']);
	}
    
	public function dataGrid() {

		$filter = $this->setFilterGrid();
		
		$this->output->set_content_type('application/json');

		$response = $this->model_master_pelayan->dataGrid();
		echo json_encode($response); 
    }
	
	public function simpan(){

		$id           	= $this->input->post('IDPELAYAN','');
		$panggilan      = $this->input->post('PANGGILAN');
		$namapelayan    = $this->input->post('NAMAPELAYAN');
		$telp        	= $this->input->post('TELP')??'';
        $status       	= $this->input->post('STATUS');
        $jenispelayanan = $this->input->post('cb_jenis_pelayanan',[]);

		$mode = $this->input->post('mode');
		if ($mode=='tambah') {
			
			$response = $this->model_master_pelayan->cekNama($namapelayan);
			if ($response != ''){
				die(json_encode(array('errorMsg' => $response)));
			}
		
			$edit = 0;
		}
		else{
			$edit = 1;
		}
		
		// query header
		$data_values = array (
			'IDGEREJA'           	  	  => $_SESSION[NAMAPROGRAM]['IDGEREJA'],
			'IDPELAYAN'           	      => $id,
			'PANGGILAN' 			      => $panggilan,
			'NAMAPELAYAN' 			      => $namapelayan,
			'TELP'           	 		  => $telp,
			'STATUS'                  	  => $status,
		);
		
		$response = $this->model_master_pelayan->simpan($id,$data_values,$jenispelayanan,$edit);
		if ($response != ''){
			die(json_encode(array('errorMsg' => $response)));
		}

		echo json_encode(array('success' => true));
	}
	
	function batal(){
		$id   = $_POST['id'];
		
		$exe = $this->model_master_pelayan->batal($id);
		
		if ($exe != '') { die(json_encode(array('errorMsg'=>$exe))); }

		echo json_encode(array('success' => true));
	}
	
	function getPelayanX(){
		$response = $this->model_master_pelayan->getPelayanX();

		echo json_encode(array('success' => true, 'namapelayan' => $response->namapelayan, 'idpelayan' => $response->idpelayan));
	}
}
