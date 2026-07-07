<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends MY_Controller {
	public function __construct(){
		parent::__construct();
	}
	
	public function index()
	{
    	    $data['menu']  = false;
    		$this->load->view('header_css');
    		$this->load->view('pages/v_test',$data);
	}
	
	public function live() {

		$this->load->view('pages/v_live');
    }
    
    public function liveword() {

		$this->load->view('pages/v_live_word');
    }
}
