<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Alkitab extends MY_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model(['model_master_alkitab']);
	}
	
	public function comboGrid() {
		$this->output->set_content_type('application/json');
		$response = $this->model_master_alkitab->comboGridPasal();
		echo json_encode($response);
	}
	
	public function getAyat() {
	    $urutankitab = $this->input->post("urutankitab");
	    $pasal = $this->input->post("pasal");
		$this->output->set_content_type('application/json');
		$response = $this->model_master_alkitab->getAyat($urutankitab,$pasal);
		echo json_encode($response);
	}
	
	public function getAPI() {

		$curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://beeble.vercel.app/api/v1/passage/list',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'GET',
        ));
        
        $response = curl_exec($curl);
        
        curl_close($curl);

		$data = json_decode($response, true)['data']; 
		$index = 1;
        foreach($data as $item)
        {
            
            $response = $this->getVerse($index,$item);
            
            if ($response != ''){
        		die(json_encode(array('errorMsg' => $response)));
        	}
            
        }
        
    }
    
    public function getVerse($index,$kitab) {
        // $kitab = $this->input->post("kitab");
        // $pasal = $this->input->post("pasal");
        
        for($x = 1 ; $x <= $kitab["chapter"] ; $x++)
        {
            $curl = curl_init();
    
            curl_setopt_array($curl, array(
              CURLOPT_URL => 'https://beeble.vercel.app/api/v1/passage/'.str_replace(" ","%20",$kitab["abbr"]).'/'.$x,
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => '',
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => 'GET',
            ));
            
            $responseKitab = curl_exec($curl);
            
            curl_close($curl);
    
    		$data = json_decode($responseKitab, true)['data']['verses']; 
    		
    		foreach($data as $item)
            {
               
    		    $response = $this->model_master_alkitab->simpanDataAPI($index,$kitab,$x,$item);
            }
        }
    }

}
