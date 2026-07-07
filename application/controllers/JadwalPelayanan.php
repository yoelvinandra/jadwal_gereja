<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class JadwalPelayanan extends MY_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model(['model_jadwal_pelayanan']);
	}
	
	public function index(){
		$kodeMenu = $this->input->get('kode');
		// panggil set page di MY_Controller
		$this->setPage($kodeMenu,$config);
    }
    
	public function dataGrid() {

		$filter = $this->setFilterGrid();
		
		$this->output->set_content_type('application/json');

		$response = $this->model_jadwal_pelayanan->dataGrid();
		echo json_encode($response); 
    }
	
	public function dataGridDetail() {

		$filter = $this->setFilterGrid();
		
		$this->output->set_content_type('application/json');
		
		$bulan =   $this->input->post('bulan');
		$tahun =	$this->input->post('tahun');
		
		$response = $this->model_jadwal_pelayanan->dataGridDetail($bulan,$tahun);
		echo json_encode($response); 
    }
	
	public function getDataPelayan() {

		$filter = $this->setFilterGrid();
		
		$this->output->set_content_type('application/json');
		
		$idjenispelayanan = $this->input->post('idjenispelayanan');
		$tgl = $this->input->post('tgl');

		$response = $this->model_jadwal_pelayanan->getDataPelayan($idjenispelayanan,$tgl);
		echo json_encode($response); 
    }
	
	public function generateDataGrid() {

		$filter = $this->setFilterGrid();
		
		$this->output->set_content_type('application/json');
		
		$bulan =  $this->input->post('bulan');
		$tahun =   $this->input->post('tahun');
		$tanggalselainminggu = $this->input->post('tanggalselainminggu');
		
		
		$response = $this->model_jadwal_pelayanan->generateDataGrid($bulan,$tahun, $tanggalselainminggu);
		
		if(count($response) == 1)
		{
			die(json_encode(array('errorMsg' => $response)));
		}
		
		echo json_encode($response); 
    }
		
	public function simpan(){

		$id           = $this->input->post('IDJADWAL','');
		$bulan        = $this->input->post('BULAN');
		$bulanangka   = $this->input->post('BULANANGKA');
		$tahun        = $this->input->post('TAHUN');
        $catatan      = $this->input->post('CATATAN')??'';
		$data_pelayan = json_decode($this->input->post('DATAPELAYAN'),true);

		$mode = $this->input->post('mode');
		if ($mode=='tambah') {
			$edit = 0;
		}
		else{
			$edit = 1;
		}
		
		// query header
		$data_values = array (
			'IDGEREJA'           	  => $_SESSION[NAMAPROGRAM]['IDGEREJA'],
			'BULAN' 			      => $bulan,
			'BULANANGKA' 			  => $bulanangka,
			'TAHUN' 			      => $tahun,
			'CATATAN'           	  => $catatan,
			'STATUS'                  => $this->input->post('SIMPAN'),
		);
		
		$response = $this->model_jadwal_pelayanan->simpan($id,$data_values,$data_pelayan,$edit);
		if ($response != ''){
			die(json_encode(array('errorMsg' => $response)));
		}

		echo json_encode(array('success' => true));
	}
	
	function batal(){
		$id   = $_POST['id'];
		
		$exe = $this->model_jadwal_pelayanan->batal($id);
		
		if ($exe != '') { die(json_encode(array('errorMsg'=>$exe))); }

		echo json_encode(array('success' => true));
	}
}
