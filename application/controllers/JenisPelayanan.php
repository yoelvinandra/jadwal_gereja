<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class JenisPelayanan extends MY_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model(['model_master_jenispelayanan']);
	}
    
	public function dataGrid() {

		$filter = $this->setFilterGrid();
		
		$this->output->set_content_type('application/json');

		$response = $this->model_master_jenispelayanan->dataGrid();
		echo json_encode($response); 
    }
	
	public function comboGrid() {
		$this->output->set_content_type('application/json');
		$response = $this->model_master_jenispelayanan->comboGrid();
		echo json_encode($response);
	}
	
	public function getDataJenisPelayanan() {
		$this->output->set_content_type('application/json');
		$idpelayan = $this->input->post('idpelayan');
		$response = $this->model_master_jenispelayanan->getDataJenisPelayanan($idpelayan);
		echo json_encode($response);
	}
	
	public function getUrutan() {
		$this->output->set_content_type('application/json');
		$response = $this->model_master_jenispelayanan->getUrutan();
		echo json_encode($response);
	}
	
	public function getNama() {
		$this->output->set_content_type('application/json');
		$idjenispelayanan = $this->input->post('idjenispelayanan');
		$response = $this->model_master_jenispelayanan->getNama($idjenispelayanan);
		echo json_encode($response);
	}
	
	public function simpan(){

		$id           			= $this->input->post('IDJENISPELAYANAN','');
		$namajenispelayanan    	= $this->input->post('NAMAJENISPELAYANAN');
        $urutan       			= $this->input->post('URUTAN');
        $status       			= $this->input->post('STATUS');

		$mode = $this->input->post('mode');
		if ($mode=='tambah') {
			
			$response = $this->model_master_jenispelayanan->cekNama($namajenispelayanan);
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
			'IDJENISPELAYANAN'            => $id,
			'NAMAJENISPELAYANAN' 		  => $namajenispelayanan,
			'URUTAN' 		  			  => $urutan,
			'STATUS'                  	  => $status,
		);
		
		$response = $this->model_master_jenispelayanan->simpan($id,$data_values,$edit);
		if ($response != ''){
			die(json_encode(array('errorMsg' => $response)));
		}

		echo json_encode(array('success' => true));
	}
	
	function batal(){
		$id   = $_POST['id'];
		
		$exe = $this->model_master_jenispelayanan->batal($id);
		
		if ($exe != '') { die(json_encode(array('errorMsg'=>$exe))); }

		echo json_encode(array('success' => true));
	}
}
