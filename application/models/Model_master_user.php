<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_master_user extends MY_Model
{
	public function valid($namagereja)
	{
	    $sql = "select * from mgereja where namagereja = '$namagereja' or username = '$namagereja'";
		return $this->db->query($sql)->row();
	}
}
