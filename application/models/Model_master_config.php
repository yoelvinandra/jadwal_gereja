<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_master_config extends CI_Model
{
	public function getConfig($modul, $conf)
	{
		return $this->db->where('MODUL', $modul)
						->where('CONFIG', $conf)
						->where('IDPERUSAHAAN', $_SESSION[NAMAPROGRAM]['IDPERUSAHAAN'])
						->get('MCONFIG')
						->row()
						->VALUE;

		echo $this->db->last_query();
	}

	public function getConfigAll($modul, $conf)
	{
		return $this->db->where('MODUL', $modul)
						->where('CONFIG', $conf)
						->where('IDPERUSAHAAN', $_SESSION[NAMAPROGRAM]['IDPERUSAHAAN'])
						->get('MCONFIG')->row();
	}

	public function getPPN()
	{
		$q = $this->db->where('CONFIG', "PPNPERSEN")
						->where('IDPERUSAHAAN', $_SESSION[NAMAPROGRAM]['IDPERUSAHAAN'])
						->get('MCONFIG')
						->row_array();

		return $q["VALUE"];
	}

	public function setConfig($conf, $val)
	{
		$q = $this->db->where('CONFIG', $conf)
						->where('IDPERUSAHAAN', $_SESSION[NAMAPROGRAM]['IDPERUSAHAAN'])
						->get('MCONFIG');

		if ($q->num_rows() > 0) {
			$this->db->set('VALUE', $val)
						->where('CONFIG', $conf)
						->where('IDPERUSAHAAN', $_SESSION[NAMAPROGRAM]['IDPERUSAHAAN'])
						->update('MCONFIG');
		} else {
			$data = array(
				'IDPERUSAHAAN' => $_SESSION[NAMAPROGRAM]['IDPERUSAHAAN'],
				'CONFIG'       => $conf,
				'VALUE'        => $val
			);
			$this->db->insert('MCONFIG', $data);
		}

		return true;
	}

	public function getAkses($kodemenu)
	{
		useGlobalConnection();

		if ($_SESSION[NAMAPROGRAM]['USERID'] === 'VISION') {
			return [
				'TAMBAH'			=> 1,
				'UBAH'				=> 1,
				'HAPUS'				=> 1,
				'OTORISASI'			=> 1,
				'TAMPILGRANDTOTAL'	=> 1,
				'PRINTULANG'		=> 1,
				'BLOKIR'			=> 1,
				'INPUTHARGA'		=> 1,
				'LIHATHARGA'		=> 1
			];
		}

		$query = $this->db->from('MUSERAKSES a')
							->join('MMENU b', 'a.KODEMENU = b.KODEMENU', 'left')
							->where('b.KODEMENU', $kodemenu)
							->where('b.STATUS', 1)
							->where('a.IDUSER', $_SESSION[NAMAPROGRAM]['IDUSER'])
							->get()
							->row_array();

		usePerusahaanConnection();

		return $query;
	}

	public function getPersentasePendaftaranFlamboyan()
	{
		$q = $this->db->where('CONFIG', "PERSENTASEDAFTARFLAMBOYAN")
						->where('IDPERUSAHAAN', $_SESSION[NAMAPROGRAM]['IDPERUSAHAAN'])
						->get('MCONFIG')
						->row_array();

		return $q["VALUE"];
	}
}
