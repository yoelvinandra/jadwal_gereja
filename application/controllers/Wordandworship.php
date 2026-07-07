<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Wordandworship extends MY_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model([
		    'model_master_alkitab'
		]);
	}
	
	public function index()
	{
	    if(!isset($_SESSION[NAMAPROGRAM]['ALKITAB']))
	    {
	        $_SESSION[NAMAPROGRAM]['ALKITAB'] = $this->model_master_alkitab->getAllAlkitab();
	    }
	    else
	    {
	        $_SESSION[NAMAPROGRAM]['ALKITAB'] = [];
	    }
      
        $data['menu']  =  ($this->input->get('menu')??0);
        $this->load->view('header_css');
        $this->load->view('pages/v_word_worship',$data);
	}
	
	public function live() {

		$this->load->view('pages/v_live');
    }
    
    public function liveword() {

		$this->load->view('pages/v_live_word');
    }
}
