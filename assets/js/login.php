<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->load->model([
			'model_master_menu', 'model_master_user'
		]);
	}

	public function index()
	{
		$this->load->view('login');
	}

	//untuk proses login
	public function cekLogin()
	{
		$namagereja 	= $this->input->post('namagereja');

		if ($namagereja == '') {
			return die(json_encode([
				'errorMsg' => 'Nama Gereja Kosong'
			]));
		}

		$user = $this->model_master_user->valid($namagereja);

		// jika status user adalah 1 (sudah verifikasi email)
		// maka bisa login
		if (count($user) > 0) {
			$_SESSION[NAMAPROGRAM]['IDGEREJA'] = $user->idgereja;
			$_SESSION[NAMAPROGRAM]['NAMAGEREJA'] = $user->namagereja;
			echo json_encode([
				'success'		=> true,
				'info'			=> 'Selamat Datang ' . $_SESSION[NAMAPROGRAM]['NAMAGEREJA'],
				'redirect'		=> base_url('Login/login')
			]);
		} else {
			$invalid_login_message = 'Gereja Tidak Terdaftar';
			echo json_encode([
				'success'	=> false,
				'errorMsg'	=> $invalid_login_message
			]);
		}
	}
	
	public function login()
	{
		$this->load->view('header_css');
		$this->load->view('menu');
	}

	public function logout()
	{
		session_start();
		unset($_SESSION[NAMAPROGRAM]);
		redirect(base_url());
	}
}
