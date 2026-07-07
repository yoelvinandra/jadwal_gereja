<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lagu extends MY_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model(['model_master_lagu']);
	}
    
	public function dataGrid() {

		$filter = $this->setFilterGrid();
		
		$this->output->set_content_type('application/json');

		$response = $this->model_master_lagu->dataGrid();
		echo json_encode($response); 
    }
    
    public function comboGridListLagu() {
		$this->output->set_content_type('application/json');
		$response = $this->model_master_lagu->comboGridListLagu();
		echo json_encode($response);
	}
    
    public function dataGridListLagu() {

		$filter = $this->setFilterGrid();
		
		$this->output->set_content_type('application/json');
		
		$id = $this->input->post('id','');

		$response = $this->model_master_lagu->dataGridListLagu($id);
		echo json_encode($response); 
    }
	
	public function simpan(){

		$id           	= $this->input->post('IDLAGU','');
		$namalagu       = $this->input->post('NAMALAGU')??"";
		$namapenyanyi   = $this->input->post('NAMAPENYANYI')??"";
		$lirik        	= $this->input->post('LIRIK')??'';
        $status       	= $this->input->post('STATUS')??1;
        
        $lirik          = str_replace("\r\n","<br>",$lirik);
        
		$mode = $this->input->post('mode');
		if ($mode=='tambah') {
			
			$response = $this->model_master_lagu->cekNama($namalagu);
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
		    'IDGEREJA'                    => $_SESSION[NAMAPROGRAM][IDGEREJA],
			'IDLAGU'           	          => $id,
			'NAMALAGU' 			          => $namalagu,
			'NAMAPENYANYI' 			      => $namapenyanyi,
			'LIRIK'           	 		  => $lirik,
			'STATUS'                  	  => $status,
		);
		
		$response = $this->model_master_lagu->simpan($id,$data_values,$edit);
		if ($response != ''){
			die(json_encode(array('errorMsg' => $response)));
		}

		echo json_encode(array('success' => true));
	}
	
	public function simpanListLagu(){

		$detail = json_decode($this->input->post('detail'),true);
		$mode = $this->input->post('mode');
		if ($mode=='tambah') {
			
			$response = $this->model_master_lagu->cekNama($detail[0]['namalistlagu']);
			if ($response != ''){
				die(json_encode(array('errorMsg' => $response)));
			}
		
			$edit = 0;
		}
		else{
			$edit = 1;
		}
		
		$response = $this->model_master_lagu->simpanListLagu($detail,$edit);
		if ($response != ''){
			die(json_encode(array('errorMsg' => $response)));
		}

		echo json_encode(array('success' => true));
	}
	
	function batal(){
		$id   = $_POST['id'];
		
		$exe = $this->model_master_lagu->batal($id);
		
		if ($exe != '') { die(json_encode(array('errorMsg'=>$exe))); }

		echo json_encode(array('success' => true));
	}
	
	function batalList(){
		$id   = $_POST['id'];
		
		$exe = $this->model_master_lagu->batalList($id);
		
		if ($exe != '') { die(json_encode(array('errorMsg'=>$exe))); }

		echo json_encode(array('success' => true));
	}
	
	function getLaguByID(){
	    
		$id   = $_POST['id'];
		$data = $this->model_master_lagu->getLaguByID($id);

		echo json_encode(array('success' => true,'namalagu' => $data->namalagu,'namapenyanyi' => $data->namapenyanyi,'lirik' => $data->lirik));
	}
	
	function getIDListLagu(){
		$id = $this->model_master_lagu->getIDListLagu();

		echo json_encode(array('success' => true,'id' => $id));
	}
}
