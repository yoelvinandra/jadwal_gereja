<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function daftar($idperusahaan)
	{
		$_SESSION[NAMAPROGRAM]['IDGEREJA'] = $idperusahaan;
		$this->load->view('header_css');
		$this->load->view('pages/v_daftar');
	}

	public function page($page)
	{
		
		
		if (isset($_SESSION[NAMAPROGRAM]['IDGEREJA']))
		{
			$this->load->view('header_css');
			if($page == 'pelayan')
			{
				$this->load->view('pages/v_master_pelayan');
			}
			else if($page == 'jenispelayanan')
			{
				$this->load->view('pages/v_master_jenispelayanan');
			}
			else if($page == 'jadwal')
			{
				$this->load->view('pages/v_transaksi_jadwal_pelayanan');
			}
			else if($page == 'laporan')
			{
				$this->load->view('pages/v_laporan');
			}
			else 
			{
				session_destroy();
				redirect('auth/Login');
			}
		}
		else
		{
			redirect('auth/Login');
		}
	}
	
	public function exitform()
	{
		unset($_SESSION[NAMAPROGRAM]);
		$this->load->view('header_css');
		$this->load->view('pages/v_finish');
	}

}
