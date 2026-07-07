<?php

function get_saldo_stok($idperusahaan,$idbarang,$idlokasi,$tgltrans,$kodetrans,$jml){
	$CI =& get_instance();	
	$CI->load->database($_SESSION[NAMAPROGRAM]['CONFIG']);
		
	$SQL = "call GET_SALDO_STOK($idperusahaan,$idbarang,$idlokasi,'$tgltrans',@out1,@out2);";			
	$CI->db->query($SQL);

	//echo $CI->db->last_query();
	$result = $CI->db->query("SELECT @out1 as SALDOQTY,  @out2 as SALDOPRICE")->row();

	$sql = "select ifnull(sum(if(MK = 'M', JML, -JML)),0) as KARTUQTY, 
	ifnull(sum(if(MK = 'M', TOTALHARGA, -TOTALHARGA)),0) as KARTURP
	from KARTUSTOK
	where IDPERUSAHAAN = ?  
		  and IDLOKASI = ?
		  and KODETRANS = ?  
		  and IDBARANG = ?
	";

	$kartu = $CI->db->query($sql,[$idperusahaan,$idbarang,$idlokasi,$tgltrans])->row();

	$result = $CI->db->query("SELECT ($result->SALDOQTY+$kartu->KARTUQTY-$jml) as QTY,  @out2 as PRICE")->row();
	return $result;
}

function get_saldo_stok_penyesuaian($idperusahaan,$idbarang,$idlokasi,$tgltrans){
	$CI =& get_instance();	
	$CI->load->database($_SESSION[NAMAPROGRAM]['CONFIG']);
		
	$SQL = "call GET_SALDO_STOK($idperusahaan,$idbarang,$idlokasi,'$tgltrans',@out1,@out2);";			
	$CI->db->query($SQL);
	$result = $CI->db->query("SELECT @out1 as QTY,  @out2 as PRICE")->row();
	return $result;
}

function get_konversi_satuanutama($idbarang,$satuan){
	$CI =& get_instance();	
	$CI->load->database($_SESSION[NAMAPROGRAM]['CONFIG']);
	//call konversi satuan utama
	$SQL = "call GET_KONVERSI_SATUANUTAMA($idbarang,'$satuan',@out1,@out2);";
			
	$CI->db->query($SQL);
	$result = $CI->db->query("SELECT @out1 as KONVERSI,  @out2 as SATUANUTAMA")->row();
	return $result;
}

function comboGrid($model){
	$CI =& get_instance();	
	$CI->load->model($model);
	$response = $CI->$model->comboGrid();
	
	for($i=0; $i < count($response["rows"]);$i++){
		$value = $response["rows"][$i]->value;
		$text = $response["rows"][$i]->text;
		
		$html.="<option value='".$value."'>".$text."</option>";
	}
	echo $html;
}

// function comboGridPasalAyat($model){
// 	$CI =& get_instance();	
// 	$CI->load->model($model);
// 	$response = $CI->$model->comboGridPasalAyat();
	
// 	for($i=0; $i < count($response["rows"]);$i++){
// 		$value = $response["rows"][$i]->value;
// 		$text = $response["rows"][$i]->text;
		
// 		$html.="<option value='".$value."'>".$text."</option>";
// 	}
// 	echo $html;
// }

function comboGridListLagu($model){
	$CI =& get_instance();	
	$CI->load->model($model);
	$response = $CI->$model->comboGridListLagu();
	
	for($i=0; $i < count($response["rows"]);$i++){
		$value = $response["rows"][$i]->value;
		$text = $response["rows"][$i]->text;
		
		$html.="<option value='".$value."'>".$text."</option>";
	}
	echo $html;
}

function comboGridPanggilan($model){
	$CI =& get_instance();	
	$CI->load->model($model);
	$response = $CI->$model->comboGridPanggilan();
	
	for($i=0; $i < count($response["rows"]);$i++){
		$value = $response["rows"][$i]->value;
		$text = $response["rows"][$i]->text;
		
		$html.="<option value='".$value."'>".$text."</option>";
	}
	echo $html;
}

function comboGridTransaksi($model,$status = ""){
	$CI =& get_instance();	
	$CI->load->model($model);
	$response = $CI->$model->comboGridTransaksi($status);
	
	for($i=0; $i < count($response["rows"]);$i++){
		$value = $response["rows"][$i]->value;
		$text = $response["rows"][$i]->text;
		
		$html.="<option value='".$value."'>".$text."</option>";
	}
	echo $html;
}

function comboGridPerkiraan($jenis){
	$CI =& get_instance();	
	$CI->load->model("model_master_perkiraan");
	$response = $CI->model_master_perkiraan->comboGridPerkiraan($jenis);
	
	for($i=0; $i < count($response["rows"]);$i++){
		$value = $response["rows"][$i]->value;
		$text = $response["rows"][$i]->text;
		
		$html.="<option value='".$value."'>".$text."</option>";
	}
	echo $html;
}

function comboGridJurnal($model,$combogrid){
	$CI =& get_instance();	
	$CI->load->model($model);
	$response = $CI->$model->$combogrid();
	
	for($i=0; $i < count($response["rows"]);$i++){
		$value = $response["rows"][$i]->value;
		$text = $response["rows"][$i]->text;
		
		$html.="<option value='".$value."'>".$text."</option>";
	}
	echo $html;
}

function comboGridAkun($combogrid){ // KHUSUS LAPORAN KAS
	$CI =& get_instance();	
	$CI->load->model("model_master_perkiraan");
	$response = $CI->model_master_perkiraan->comboGridTransaksi($combogrid);
	
	for($i=0; $i < count($response["rows"]);$i++){
		$value = $response["rows"][$i]->value;
		$text = $response["rows"][$i]->text;
		
		$html.="<option value='".$value."' selected>".$text."</option>";
	}
	echo $html;
}

function where_laporan($data){
	$whereFilter;
	$data = json_decode($data);
	
	//SORTING AGAR BISA TENTUKAN AND DAN OR
	$arrKolom = array();
	$arrOperator = array();
	
	//CEK KOLOM DENGAN YANG LAMA
	$kolomLama = "";
	$operatorLama ="";
	$logika ="";
	
	$kolom;
	$operator;
	
	for($i = 0; $i<count($data);$i++)
	{
		$arrKolom[$i] = $data[$i]->KOLOM;
		$arrOperator[$i] = $data[$i]->OPERATOR;
	}
	
	array_multisort($arrKolom, SORT_ASC, $arrOperator, SORT_ASC, $data);
	
	//KONVERSI QUERY
	for($i = 0; $i<count($data);$i++)
	{
				
		if ($data[$i]->KOLOM != $kolomLama || $data[$i]->OPERATOR != $operatorLama) {
			$logika = " ) AND (";
			$kolomLama = $data[$i]->KOLOM;
			$operatorLama = $data[$i]->OPERATOR;
		} else {
			if (strpos($data[$i]->OPERATOR, "TIDAK") !== false) {
				$logika = " AND ";
			} else {
				$logika = " OR ";
			}
		}

			
		if($data[$i]->TIPEDATA == "STRING" )
		{
			if($data[$i]->OPERATOR == "ADALAH")
			{
				$whereFilter.= $logika.$data[$i]->KOLOM." = '".addslashes($data[$i]->NILAI)."'";
			}
			else if($data[$i]->OPERATOR == "TIDAK MENCAKUP")
			{
				$whereFilter.= $logika.$data[$i]->KOLOM." != '".addslashes($data[$i]->NILAI)."'";
			}
			else if($data[$i]->OPERATOR == "BERISI KATA")
			{
				$whereFilter.= $logika.$data[$i]->KOLOM." LIKE '%".addslashes(str_replace(' ', '%', $data[$i]->NILAI))."%'";
			}
			else if($data[$i]->OPERATOR == "TIDAK BERISI KATA")
			{
				$whereFilter.= $logika.$data[$i]->KOLOM." NOT LIKE '%".addslashes($data[$i]->NILAI)."%'";
			}
			else if($data[$i]->OPERATOR == "DIMULAI DENGAN")
			{
				$whereFilter.= $logika.$data[$i]->KOLOM." LIKE '".addslashes($data[$i]->NILAI)."%'";
			}
			else if($data[$i]->OPERATOR == "TIDAK DIMULAI DENGAN")
			{
				$whereFilter.= $logika.$data[$i]->KOLOM." NOT LIKE '".addslashes($data[$i]->NILAI)."%'";
			}
			else if($data[$i]->OPERATOR == "DIAKHIRI DENGAN")
			{
				$whereFilter.= $logika.$data[$i]->KOLOM." LIKE '%".addslashes($data[$i]->NILAI)."'";
			}
			else if($data[$i]->OPERATOR == "TIDAK DIAKHIRI DENGAN")
			{
				$whereFilter.= $logika.$data[$i]->KOLOM." NOT LIKE '%".addslashes($data[$i]->NILAI)."'";
			}
			else if($data[$i]->OPERATOR == "KOSONG")
			{
				$whereFilter.= $logika.$data[$i]->KOLOM." IS NULL OR ".$data[$i]->KOLOM." = '' ";
			}
			else if($data[$i]->OPERATOR == "TIDAK KOSONG")
			{
				$whereFilter.= $logika.$data[$i]->KOLOM." IS NOT NULL OR ".$data[$i]->KOLOM." != '' ";
			}
		}
		else if($data[$i]->TIPEDATA == "NUMBER")
		{		
			if($data[$i]->OPERATOR == "SAMA DENGAN")
			{
				$whereFilter.= $logika.$data[$i]->KOLOM." = ".$data[$i]->NILAI."";
			}
			else if($data[$i]->OPERATOR == "TIDAK SAMA DENGAN")
			{
				$whereFilter.= $logika.$data[$i]->KOLOM." != ".$data[$i]->NILAI."";
			}
			else if($data[$i]->OPERATOR == "LEBIH BESAR DARI")
			{
				$whereFilter.= $logika.$data[$i]->KOLOM." > ".$data[$i]->NILAI."";
			}
			else if($data[$i]->OPERATOR == "LEBIH BESAR SAMA DENGAN")
			{
				$whereFilter.= $logika.$data[$i]->KOLOM." >= ".$data[$i]->NILAI."";
			}
			else if($data[$i]->OPERATOR == "LEBIH KECIL DARI")
			{
				$whereFilter.= $logika.$data[$i]->KOLOM." < ".$data[$i]->NILAI."";
			}
			else if($data[$i]->OPERATOR == "LEBIH KECIL SAMA DENGAN")
			{
				$whereFilter.= $logika.$data[$i]->KOLOM." <= ".$data[$i]->NILAI."";
			}
			else if($data[$i]->OPERATOR == "NOL")
			{
				$whereFilter.= $logika.$data[$i]->KOLOM." = 0 ";
			}
			else if($data[$i]->OPERATOR == "TIDAK NOL")
			{
				$whereFilter.= $logika.$data[$i]->KOLOM." != 0 ";
			}
		}
	}
	
	// $whereFilter
	return $whereFilter;
}


function operator_laporan($tipe_data){
	if($tipe_data == "String")
	{
		$operator = '<option value="ADALAH">Adalah</option>
					 <option value="TIDAK MENCAKUP">Tidak mencakup</option>
					 <option value="BERISI KATA">Berisi kata</option>
					 <option value="TIDAK BERISI KATA">Tidak berisi kata</option>
					 <option value="DIMULAI DENGAN">Dimulai dengan</option>
					 <option value="TIDAK DIMULAI DENGAN">Tidak dimulai dengan</option>
					 <option value="DIAKHIRI DENGAN">Diakhiri dengan</option>
					 <option value="TIDAK DIAKHIRI DENGAN">Tidak diakhiri dengan</option>
					 <option value="KOSONG">Kosong</option>
					 <option value="TIDAK KOSONG">Tidak kosong</option>
					';
	}
	else if($tipe_data == "Number")
	{
		$operator = '<option value="SAMA DENGAN">Sama dengan</option>
					 <option value="TIDAK SAMA DENGAN">Tidak sama dengan</option>
					 <option value="LEBIH BESAR DARI">Lebih besar dari</option>
					 <option value="LEBIH BESAR SAMA DENGAN">Lebih besar sama dengan</option>
					 <option value="LEBIH KECIL DARI">Lebih kecil dari</option>
					 <option value="LEBIH KECIL SAMA DENGAN">Lebih kecil sama dengan</option>
					 <option value="NOL">Nol</option>
					 <option value="TIDAK NOL">Tidak nol</option>
					';
	}
	return $operator;
}

function nama_terang($nama)
{
	$user ='';
	$len = strlen($nama);
	if($len != null)
	{
		//if($len < 16){$len = 16;}
		
		$user= "(";
		for($i=0;$i<(30-$len)/2;$i++)
		{
			$user.="&nbsp;";
		}
			$user.=$nama;
		for($i=0;$i<(30-$len)/2;$i++)
		{
			$user.="&nbsp;";
		}
		$user.=")";
	}
	else
	{
		$user = "(................)";
	}
	
	return $user;
}

function penyebut($nilai) {
	$nilai = abs($nilai);
	$huruf = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
	$temp = "";
	if ($nilai < 12) {
		$temp = " ". $huruf[$nilai];
	} else if ($nilai <20) {
		$temp = penyebut($nilai - 10). " Belas";
	} else if ($nilai < 100) {
		$temp = penyebut($nilai/10)." Puluh". penyebut($nilai % 10);
	} else if ($nilai < 200) {
		$temp = " Seratus" . penyebut($nilai - 100);
	} else if ($nilai < 1000) {
		$temp = penyebut($nilai/100) . " Ratus" . penyebut($nilai % 100);
	} else if ($nilai < 2000) {
		$temp = " Seribu" . penyebut($nilai - 1000);
	} else if ($nilai < 1000000) {
		$temp = penyebut($nilai/1000) . " Ribu" . penyebut($nilai % 1000);
	} else if ($nilai < 1000000000) {
		$temp = penyebut($nilai/1000000) . " Juta" . penyebut($nilai % 1000000);
	} else if ($nilai < 1000000000000) {
		$temp = penyebut($nilai/1000000000) . " Milyar" . penyebut(fmod($nilai,1000000000));
	} else if ($nilai < 1000000000000000) {
		$temp = penyebut($nilai/1000000000000) . " Trilyun" . penyebut(fmod($nilai,1000000000000));
	}     
	return $temp;
}
 
function terbilang($nilai) {
	if($nilai==0) {
		$hasil = "Nol ". trim(penyebut($nilai));
	} else if($nilai < 0){
		$hasil = "Minus ".trim(penyebut($nilai));   		
	} else {
		$hasil = trim(penyebut($nilai));
	}     		
	return $hasil." Rupiah";
}
function alamat_length($alamat)
{
	/*$len = strlen($alamat);
		if($len > 40)
		{
			$alamat = substr($alamat,0,40);
		}	*/
	return $alamat;
}

function insert_value_perkiraan($data,$idtrans){
	$CI =& get_instance();	
	$CI->load->database($_SESSION[NAMAPROGRAM]['CONFIG']);
	
	$exe = $CI->db->insert('valuePERKIRAAN',$data);
	if($CI->db->trans_status === false){
		$CI->db->trans_rollback();
		return 'Menyimpan value Perkiraan Gagal';
	}
	return '';	
}

function insert_kartu_stok($idtrans,$param,$modul = 'INVENTORI'){
	$CI =& get_instance();	
	$CI->load->database($_SESSION[NAMAPROGRAM]['CONFIG']);
	
	//karena terima transfer agak berbeda di lokasi,barang dan jml
	$idlokasi = $param['idlokasi']??'IDLOKASI';
	$barang = $param['barang']??'IDBARANG';
	$jml = $param['jml']??'JML';
	$subtotal = $param['subtotal']??"b.SUBTOTAL";

	//untuk yg tidak punya field ppn (Terima Transfer)
	if($param['tanpappn'] == 1)$ppn = ",null as PAKAIPPN,0 as PPNPERSEN";
	else $ppn = ",b.PAKAIPPN,b.PPNPERSEN";
	
	if($param['jenisbarang'] != ""){
		$JENISBARANG = "AND c.{$param['jenisbarang']} = 1";
	}
	$sql = "select a.IDPERUSAHAAN,a.{$idlokasi},a.{$param['id']} as IDTRANS,a.{$param['kode']} as KODETRANS,b.{$barang} as IDBARANG,a.TGLTRANS,b.{$jml} as JML,b.SATUAN,{$subtotal} as SUBTOTAL{$ppn}";
	
	$sql .= " from {$param['table']} a
			left join {$param['tabledtl']} b on a.{$param['id']} = b.{$param['id']}
			left join mbarang c on b.idbarang = c.idbarang
			where a.IDPERUSAHAAN = {$_SESSION[NAMAPROGRAM]['IDPERUSAHAAN']} and a.{$param['id']} = {$idtrans}
			$JENISBARANG
			";
		
	$query = $CI->db->query($sql)->result();
	foreach($query as $item){
		$jmlpo = $jml = $jmlso = 0;
		$idtransreferensi = 0;$kodetransreferensi = '';
		
		//jika penjualan tidak perlu mengisi subtotal
		if($param['tanpasubtotal'] == 1)$subttl = 0;
		else $subttl = $item->SUBTOTAL;
		
		//jika PPN include maka kurangi subtotal seperti hitung DPP
		if($item->PAKAIPPN == 2){
			$subttl = round($subttl * 10/11,$_SESSION[NAMAPROGRAM]['DECIMALDIGITAMOUNT']);
		}
		
		//Cari JML dengan satuan terkecil
		$sql = "select SATUAN,SATUAN2,SATUAN3,KONVERSI1,KONVERSI2
				from mbarang
				where idbarang = {$item->IDBARANG}";
		$konversi = $CI->db->query($sql)->row();
		if($item->SATUAN == $konversi->SATUAN && $konversi->KONVERSI1 > 0){
			$jmlkonversi = $item->JML * $konversi->KONVERSI1;
			if($konversi->KONVERSI2 > 0)
				$jmlkonversi = $jmlkonversi * $konversi->KONVERSI2;
		}else if($item->SATUAN == $konversi->SATUAN2 && $konversi->KONVERSI2 > 0){
			$jmlkonversi = $item->JML * $konversi->KONVERSI2;
		}else{
			$jmlkonversi = $item->JML;
		}
		
		//jika mk tidak diisi maka jumlah 0
		if($param['mkpo']!=''){
			$jmlpo = $jmlkonversi;
		}if($param['mk']!=''){
			$jml = $jmlkonversi;
		}if($param['mkso']!=''){
			$jmlso = $jmlkonversi;
		}
		
		if($param['approve'] == '1'){
			//jika approve transaksi, lakukan update
			$data = array (
				'IDTRANSREFERENSI'  => $item->IDTRANS,
				'KODETRANSREFERENSI'=> $item->KODETRANS,
				'STATUS'            => 1,
				'TOTALHARGA'        => round($subttl,$_SESSION[NAMAPROGRAM]['DECIMALDIGITAMOUNT']),
			);
			//update terpenuhi di tprdtl
			$CI->db->where('KODETRANS',$param['kodetrans'])
					->where('IDPERUSAHAAN',$_SESSION[NAMAPROGRAM]['IDPERUSAHAAN'])
					->where('MODUL',$modul)
					->where('IDBARANG',$item->IDBARANG)
					->where('KETERANGAN NOT LIKE','%(BONUS)%')
					->update('KARTUSTOK',$data);
			if($CI->db->trans_status === false){
				$CI->db->trans_rollback();
				return 'Ubah Data Kartu Stok Gagal';
			}
		}else{
			//cek apakah barang sudah diinsert? jika sudah update saja
			$exist = $CI->db->where('IDPERUSAHAAN' ,$item->IDPERUSAHAAN)
						->where('MODUL' ,$modul)
						->where('KODETRANS' ,$item->KODETRANS)
						->where('IDBARANG' ,$item->IDBARANG)
						->get('KARTUSTOK')->row();
			if($exist->IDBARANG && $exist->IDBARANG != ''){
				$data = array (
					'JMLPO'             => $jmlpo + $exist->JMLPO,
					'JML'               => $jml + $exist->JML,
					'JMLSO'             => $jmlso + $exist->JMLSO,
					'TOTALHARGA'        => round($subttl + $exist->TOTALHARGA,$_SESSION[NAMAPROGRAM]['DECIMALDIGITAMOUNT']),
				);
				$CI->db->where('IDPERUSAHAAN' ,$item->IDPERUSAHAAN)
					->where('MODUL' ,$modul)
					->where('KODETRANS' ,$item->KODETRANS)
					->where('IDBARANG' ,$item->IDBARANG)
					->update('KARTUSTOK',$data);
				if($CI->db->trans_status === false){
					$CI->db->trans_rollback();
					return 'Update Data Kartu Stok Gagal';
				}
			}else{
				$data = array (
					'IDPERUSAHAAN'      => $item->IDPERUSAHAAN,
					'IDLOKASI'          => $item->IDLOKASI,
					'MODUL'      	    => $modul,
					'IDTRANS'      		=> $item->IDTRANS,
					'KODETRANS'  		=> $item->KODETRANS,
					'IDTRANSREFERENSI'  => '',
					'KODETRANSREFERENSI'=> '',
					'IDBARANG'  		=> $item->IDBARANG,
					'KONVERSI1'  		=> $konversi->KONVERSI1,
					'KONVERSI2'  		=> $konversi->KONVERSI2,
					'TGLTRANS'          => $item->TGLTRANS,
					'JENISTRANS'        => $param['jenis'],
					'KETERANGAN'        => $param['keterangan'],
					'MKPO'              => $param['mkpo'], 
					'JMLPO'             => $jmlpo,
					'MK'                => $param['mk'], 
					'JML'               => $jml,
					'MKSO'              => $param['mkso'], 
					'JMLSO'             => $jmlso,
					'TOTALHARGA'        => round($subttl,$_SESSION[NAMAPROGRAM]['DECIMALDIGITAMOUNT']),
					'STATUS'            => $param['approve']==-1?1:0,
				);
				$CI->db->insert('KARTUSTOK',$data);
				if($CI->db->trans_status === false){
					$CI->db->trans_rollback();
					return 'Input Data Kartu Stok Gagal';
				}
			}
		}
	}
	return '';
}
function hapus_kartu_stok($kodetrans,$approve,$modul = "INVENTORI"){
	$CI =& get_instance();	
	$CI->load->database($_SESSION[NAMAPROGRAM]['CONFIG']);
	
	if($approve == 1){
		//jika approve transaksi, lakukan update status dan pengosongan IDTRANSREFERENSI
		$data = array (
			'IDTRANSREFERENSI'  => '',
			'KODETRANSREFERENSI'=> '',
			'STATUS'            => 0,
		);
		//update terpenuhi di tprdtl
		$CI->db->where('KODETRANSREFERENSI',$kodetrans)
				->where('IDPERUSAHAAN',$_SESSION[NAMAPROGRAM]['IDPERUSAHAAN'])
				->where('MODUL',$modul)
				->update('KARTUSTOK',$data);
		if($CI->db->trans_status === false){
			$CI->db->trans_rollback();
			return 'Hapus Data Kartu Stok Gagal';
		}
	}else{
		$CI->db->where('KODETRANS',$kodetrans)
				->where('IDPERUSAHAAN',$_SESSION[NAMAPROGRAM]['IDPERUSAHAAN'])
				->where('MODUL',$modul)
				->delete('KARTUSTOK');
		if($CI->db->trans_status === false){
			$CI->db->trans_rollback();
			return 'Hapus Data Kartu Stok Gagal';
		}
	}
	return '';
}
function postCURL($_url, $_param){
	$postData = http_build_query($_param);
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$_url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($ch, CURLOPT_HEADER, false); 
	curl_setopt($ch, CURLOPT_POST, count($postData));
	curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);    

	$output=curl_exec($ch);

	curl_close($ch);

	return $output;
}

function ubah_tgl_mysql($tanggalnya) {
	//merubah format dari dd/mm/yyyy ke yyyy-mm-dd
	if ($tanggalnya!=NULL) {
		$pecah = explode('/', $tanggalnya);
		return $pecah[2] . '-' . $pecah[1] . '-' . $pecah[0];
	}
}
function ubah_tgl_indo($tgl) {
	//merubah format dari yyyy-mm-dd ke dd/mm/yyyy

	if ($tgl!=NULL) {
		return substr($tgl,8,2) . '/' . substr($tgl,5,2) . '/' . substr($tgl,0,4);
	}
	
	
	return $tgl;
	
}

function FormatDateIndo($tgl) {
	//merubah format dari yyyy-mm-dd ke dd/mm/yyyy


	if ($tgl!=NULL) {
		return substr($tgl,8,2) . '/' . substr($tgl,5,2) . '/' . substr($tgl,0,4);
	}

}

function ubah_tgl_firebird($tgl) {
	//merubah format dari dd/mm/yyyy ke yyyy.mm.dd
	return $tgl;
	/*
	if ($tgl!=NULL) {
		return substr($tgl,6,4) . '/' . substr($tgl,3,2) . '/' . substr($tgl,0,2);
	}
	*/
}

function cek_bulan($id) {
	switch ($id) {
		case '01' : $bulan = 'Januari'; break;
		case '02' : $bulan = 'Februari'; break;
		case '03' : $bulan = 'Maret'; break;
		case '04' : $bulan = 'April'; break;
		case '05' : $bulan = 'Mei'; break;
		case '06' : $bulan = 'Juni'; break;
		case '07' : $bulan = 'Juli'; break;
		case '08' : $bulan = 'Agustus'; break;
		case '09' : $bulan = 'September'; break;
		case '10' : $bulan = 'Oktober'; break;
		case '11' : $bulan = 'November'; break;
		case '12' : $bulan = 'Desember'; break;
	}
	return $bulan;
}

function cek_tgl($tgl) {
	if (substr($tgl,0,4) > 1000 and substr($tgl,0,4) < 2100) // format en sistem
		return 'en';
	else if (substr($tgl,6,4) > 1000 and substr($tgl,6,4) < 2100) // format in sistem
		return 'in';
}

function cetak_tgl($date) {
	if (cek_tgl($date) == 'en') {
		$tgl   = substr($date,8,2);
		$bulan = substr($date,5,2);
		$tahun = substr($date,0,4);
	} else {
		$tgl   = substr($date,0,2);
		$bulan = substr($date,3,2);
		$tahun = substr($date,6,4);
	}

	return $tgl.' '.cek_bulan($bulan).' '.$tahun;
}

function selisih_hari($tgl_awal, $tgl_akhir){
	$selisih = strtotime($tgl_akhir) -  strtotime($tgl_awal);
	$hari = $selisih/(60*60*24);
	//60 detik * 60 menit * 24 jam = 1 hari

	return $hari;
}

function selisih_jatuh_tempo($selisih_hari, $tgl) {
	// FORMAT TANGGAL HARUS YYYY-MM-DD
	//$newdate = date('d/m/Y', strtotime('+'.$selisih_hari.' days', strtotime($tgl)));
	$newdate = date('Y-m-d', strtotime('+'.$selisih_hari.' days', strtotime($tgl)));
	return $newdate;
}

function get_urutan($get_array) {
	$i = 1;
	if (count($get_array)>0) {
		foreach ($get_array as $item) {
			$array_urutan[] = $item->urutan;
		}

		// urutkan id berdasarkan asc
		sort($array_urutan);

		// ambil urutan paling akhir dan tambahkan 1
		$i = end($array_urutan)+1;
	}
	return $i;
}

function ubah_angka_romawi($n){
	$hasil = "";
	$iromawi = array("","I","II","III","IV","V","VI","VII","VIII","IX","X",
	20=>"XX",30=>"XXX",40=>"XL",50=>"L",60=>"LX",70=>"LXX",80=>"LXXX",
	90=>"XC",100=>"C",200=>"CC",300=>"CCC",400=>"CD",500=>"D",
	600=>"DC",700=>"DCC",800=>"DCCC",900=>"CM",1000=>"M",
	2000=>"MM",3000=>"MMM");

	if(array_key_exists($n,$iromawi)){
		$hasil = $iromawi[$n];
	} else if ($n >= 11 && $n <= 99){
		$i = $n % 10;
		$hasil = $iromawi[$n-$i] . ubah_angka_romawi($n % 10);
	} else if ($n >= 101 && $n <= 999){
		$i = $n % 100;
		$hasil = $iromawi[$n-$i] . ubah_angka_romawi($n % 100);
	} else {
		$i = $n % 1000;
		$hasil = $iromawi[$n-$i] . ubah_angka_romawi($n % 1000);
	}

	return $hasil;
}

function autogen($setting,$filter = []){
	$CI =& get_instance();
	$CI->load->database($_SESSION[NAMAPROGRAM]['CONFIG']);
	$field = $setting->CONFIG; $table = $setting->MODUL;
	$kodetrans = $setting->PREFIX;$count = $setting->JUMLAHDIGIT;
	
	$kodetrans = str_replace('[KODECUSTOM]',$filter['kodeCustom'],$kodetrans);
	$kodetrans = str_replace('[LOKASI]',$filter['lokasi'],$kodetrans);
	$kodetrans = str_replace('[YY]',substr($filter['tgltrans'], 2, 2),$kodetrans);
	$kodetrans = str_replace('[MM]',substr($filter['tgltrans'], 5, 2),$kodetrans);
	$kodetrans = str_replace('[DD]',substr($filter['tgltrans'], 8, 2),$kodetrans);
	$kodetrans = str_replace('[NUM]','%',$kodetrans);
	
	//max urutan
	$j = 1;
	for ($i=0; $i<$count; $i++) {
		$j .= 0;
	}
	$j++;

	$query = $CI->db->query("select max($field) as KODE from $table where $field like '$kodetrans'");
	$r = $query->row();
	if($r->KODE != '')$urutan = substr($r->KODE,strpos($kodetrans,'%'),$count)+$j;
	else $urutan = $j;
	$kodetrans = str_replace('%',substr($urutan, 1),$kodetrans);
	return $kodetrans;
}

class angka_terbilang {
	function baca($n) {
		$this->dasar = array(1 => 'satu', 'dua', 'tiga', 'empat', 'lima', 'enam','tujuh', 'delapan', 'sembilan');
		$this->angka = array(1000000000, 1000000, 1000, 100, 10, 1);
		$this->satuan = array('milyar', 'juta', 'ribu', 'ratus', 'puluh', '');
		$pecah = explode('.', $n);

		$n = $pecah[0];
		$k = $pecah[1];

		if ($k<>'' and (substr($k, 0, 1)<>0 and substr($k, 1, 1)<>0)) {
			$koma = 'koma ';
			if (substr($k, 0, 1)==0) {
				$koma .= 'nol ';
				$k = substr($k, 1, 1);
			}

			$i = 0;
			while ($k != 0) {
				$count = (int)($k/$this->angka[$i]);
				if ($count >= 10) {
					$koma .= $this->baca($count). " ".$this->satuan[$i]." ";
				} else if($count > 0 && $count < 10){
					$koma .= $this->dasar[$count] . " ".$this->satuan[$i]." ";
				}
				$k -= $this->angka[$i] * $count;
				$i++;
			}
			$koma = preg_replace("/satu puluh (\w+)/i", "\\1 belas", $koma);
			$koma = preg_replace("/satu (ribu|ratus|puluh|belas)/i", "se\\1", $koma);
		}
		$i = 0;
		if ($n==0) {
			$str = "nol";
		} else {
			while ($n != 0) {
				$count = (int)($n/$this->angka[$i]);
				if ($count >= 10) {
					$str .= $this->baca($count). " ".$this->satuan[$i]." ";
				} else if($count > 0 && $count < 10){
					$str .= $this->dasar[$count] . " ".$this->satuan[$i]." ";
				}
				$n -= $this->angka[$i] * $count;
				$i++;
			}
			$str = preg_replace("/satu puluh (\w+)/i", "\\1 belas", $str);
			$str = preg_replace("/satu (ribu|ratus|puluh|belas)/i", "se\\1", $str);
		}
		return $str.$koma;
	}
}

function get_max_urutan($table, $field, $temp_kodetrans, $count){
	$CI =& get_instance();

	$j = 1;
	for ($i=0; $i<$count; $i++) {
		$j .= 0;
	}
	$j++;

	$query = $CI->db->query("select max($field) as KODE from $table where $field like '$temp_kodetrans%'");
	$r = $query->row();
	if($r->KODE != '')$urutan = substr($r->KODE, -$count)+$j;
	else $urutan = $j;
	return substr($urutan, 1);
}

function cek_valid_data($tabel, $field, $kode, $nama) {
	$CI =& get_instance();	

	if ($kode=='') die(json_encode(array('errorMsg' => 'Harap Input Data '.$nama.' yang Valid')));

	//$db = new DB;
	$query = $CI->db->select('count(*) as data ')
					->get_where($tabel,array($field => $kode));
	$rs = $query->row();
	if ($rs->DATA<1) die(json_encode(array('errorMsg' => $nama.' Tidak Terdapat Pada Database')));
}

function cek_valid_piutang($kodetrans, $kodecustomer, $grandtotal) {
	global $db;

	//$db = new DB;
	if ($kodetrans!=''){
		$query = $db->query("select kodecustomer, grandtotal from tjual where kodejual='".$kodetrans."'");
		$rs = $db->fetch($query);

		$kodecustomer = $rs->KODECUSTOMER;
		$grandtotal = $rs->GRANDTOTAL;
	}

	//die(json_encode(array('errorMsg' => "select sum(sisa) as sisa from kartupiutang where kodecustomer='".$kodecustomer."' and kodetrans<>'".$kodetrans."'")));
	$query = $db->query("select sum(sisa) as sisa from kartupiutang where kodecustomer='".$kodecustomer."' and kodetrans<>'".$kodetrans."'");
	$rs = $db->fetch($query);

	$sisa = $rs->SISA;

	$query2 = $db->query("select if(maxcredit is null, 0, maxcredit) as maxcredit from mcustomer where kodecustomer='".$kodecustomer."'");

	$rs2 = $db->fetch($query2);
	//die(json_encode(array('errorMsg' => $sisa+$grandtotal)));
	//die(json_encode(array('errorMsg' => $rs2->MAXCREDIT)));

	if (($sisa+$grandtotal) > $rs2->MAXCREDIT) die(json_encode(array('errorMsg' => 'Total Piutang Customer Sudah Melebihi Limit Piutang, Transaksi Tidak Dapat di Dilanjutkan ')));

}
function cek_valid_datagrid($tabel, $field, $kode, $nama) {
	global $db;

	if ($kode=='') die(json_encode(array('isError' => 'Harap Input Data '.$nama.' yang Valid')));

	//$db = new DB;
	$query = $db->select($tabel, array(' count(*) as data '), array($field => $kode));
	$rs = $db->fetch($query);

	if ($rs->DATA<1) die(json_encode(array('isError' => true, 'msg' => $nama.' Tidak Terdapat Pada Database')));
}

function get_status($tabel, $field, $kodetrans) {
	global $db;

	if ($kodetrans=='') die(json_encode(array('errorMsg' => ' Please Choose Transaction ID First')));

	//$db = new DB;
	$query = $db->select($tabel, array('status'), array($field => $kodetrans));
	$rs = $db->fetch($query);

	return $rs->STATUS;
}

function cek_pelunasan($jenis, $kodetrans) {
	global $db;

	if ($jenis=='piutang'){
		$tabel = 'pelunasanpiutang a inner join pelunasanpiutangdtl b on a.kodepelunasan=b.kodepelunasan';
	}else if ($jenis=='hutang'){
		$tabel = 'pelunasanhutang a inner join pelunasanhutangdtl b on a.kodepelunasan=b.kodepelunasan';
	}else if ($jenis=='hutangkomisi'){
		$tabel = 'pelunasanhutangkomisi a inner join pelunasanhutangkomisidtl b on a.kodepelunasan=b.kodepelunasan';
	}
	//$db = new DB;
	$query = $db->select($tabel, array('b.kodetrans', 'a.status'), array('b.kodetrans' => $kodetrans));
	$rs = $db->fetch($query);

	if($rs->KODETRANS<>'' && $rs->STATUS<>'D') {
		if ($jenis=='piutang'){
			die(json_encode(array('errorMsg' => 'Sudah Terdapat Pelunasan Piutang, Transaksi Tidak Dapat Diubah/Dibatalkan')));
		}else if ($jenis=='hutang'){
			die(json_encode(array('errorMsg' => 'Sudah Terdapat Pelunasan Hutang, Transaksi Tidak Dapat Diubah/Dibatalkan')));
		}else if ($jenis=='hutangkomisi'){
			die(json_encode(array('errorMsg' => 'Sudah Terdapat Pembayaran Komisi, Transaksi Tidak Dapat Diubah/Dibatalkan')));
		}
	}
}

function encrypt_data($password) {
	return md5($password);
}

function get_harga_jual_terakhir($kodecustomer, $kodebarang, $tgltrans, $kodelokasi) {
	global $db;

	//HARGA BELI MENGACU KE HARGA BELI TERAKHIR PADA LOKASI DC SAJA
	$sql = "select (b.hargakurs-b.discrp1-b.discrp2-b.discrp3-b.discrp4-b.discrp5) as harga, b.satuan
			from tjual a
			inner join tjualdtl b on a.kodejual = b.kodejual
			where a.status <> 'D' and
				  b.kodebarang = ? and
				  a.kodelokasi = ? and
				  a.kodecustomer = ? and
				  a.tgltrans = (select max(a.tgltrans)
								from tjual a
								inner join tjualdtl b on a.kodejual=b.kodejual
								where a.status <> 'D' and
									  b.kodebarang = ? and
									  a.kodelokasi = ? and
									  a.kodecustomer = ? and
									  a.tgltrans <= ?)
			order by a.tgltrans desc, a.jaminput desc
			limit 0, 1";
	$pr = $db->prepare($sql);
	$ex = $db->execute($pr, array($kodebarang, $kodelokasi, $kodecustomer, $kodebarang, $kodelokasi, $kodecustomer, $tgltrans));
	$rs = $db->fetch($ex);

	return $rs->HARGA<>'' ? $rs->HARGA : 0;
}

function get_harga_beli_terakhir($kode_barang, $tgl_trans) {
    global $db;

	//HARGA BELI MENGACU KE HARGA BELI TERAKHIR PADA LOKASI DC SAJA
	$sql = "select first 1 skip 0 (b.hargakurs-b.discrp1-b.discrp2-b.discrp3-b.discrp4-b.discrp5) as harga, b.satuan
			from tbeli a inner join tbelidtl b on a.kodebeli=b.kodebeli
			where b.kodebarang='$kode_barang' and a.status<>'D'
				  and a.kodelokasi='1001'
				  and a.tgltrans=(
						select max(a.tgltrans)
						from tbeli a inner join tbelidtl b on a.kodebeli=b.kodebeli
						where a.tgltrans<='$tgl_trans'
						and b.kodebarang='$kode_barang' and a.status<>'D'
					)
			order by a.kodebeli desc";
	//$db = new DB;
	$query = $db->query($sql);
	$r = $db->fetch($query);

	$harga	= $r->HARGA<>'' ? $r->HARGA : 0;
	$satuan = $r->SATUAN;
	if ($harga>0) {
		$query = $db->query("select satuan, satuan2, satuan3, konversi1, konversi2 from mbarang where kodebarang='$kode_barang'");
		$r = $db->fetch($query);
		if ($satuan==$r->SATUAN) {
			$harga = $harga;
		} else if ($satuan==$r->SATUAN2) {
			$harga = $harga*$r->KONVERSI1;
		} else if ($satuan==$r->SATUAN3) {
			$harga = $harga*($r->KONVERSI1*$r->KONVERSI2);
		}
	}
	return $harga;
}

function cek_periode($tgl_trans, $jenis) {
	global $db;
	//$db = new DB;

	/*$q = $db->select('historytanggal', array('kodelokasi', 'status'), array('kodelokasi'=>$_SESSION[NAMAPROGRAM]['KODELOKASI'], 'tanggal'=>$tgl_trans));
	$r = $db->fetch($q);
	if ($r->STATUS == NULL) {
		die(json_encode(array('errorMsg' => 'Transaksi Tidak Bisa di'.$jenis.'<br>Tanggal Transaksi Belum Dibuka<br>Silahkan Hubungi AR yang Bertanggung Jawab')));
	} else if ($r->STATUS == 0) {
		die(json_encode(array('errorMsg' => 'Transaksi Tidak Bisa di'.$jenis.'<br>Tanggal Transaksi Sudah Ditutup<br>Silahkan Hubungi AR yang Bertanggung Jawab')));
	}*/

	/*
	$q = $db->query('select kodesaldoperkiraan from saldoperkiraan');
	$r = $db->fetch($q);
	if ($r->KODESALDOPERKIRAAN<>'') {
		$q = $db->query("select tgltrans from saldoperkiraan where tgltrans<='$tgl_trans'");
		$r = $db->fetch($q);
		if ($r->TGLTRANS=='') {
			die(json_encode(array('errorMsg' => 'Transaction Can Not be '.$jenis.'<br>The Transaction Date Not Allowed Less Than Beginning Stock Date')));
		}
	}
	$q = $db->query("select max(tglakhir) as tglakhir from mclosing where tglakhir>='$tgl_trans'");
	$r = $db->fetch($q);
	if ($r->TGLAKHIR<>'') {
		die(json_encode(array('errorMsg' => 'Transaction Can Not be '.$jenis.'<br>Existing Last Closing On Date '.ubah_tgl_indo($r->TGLAKHIR))));
	}

	$q = $db->query("select tanggal from historytanggal where tanggal='$tgl_trans'");
	$r = $db->fetch($q);
	if ($r->TANGGAL<>'') {
		die(json_encode(array('errorMsg' => 'Transaction Can Not be '.$jenis.'<br>Date Transaction Already In Close')));
	}
	*/
}

function get_tgl_trans($table, $field, $kodetrans) {
	$CI =& get_instance();
	//$db = new DB;

	$r = $CI->db->query("select tgltrans from $table where $field=$kodetrans")->row;

	//return ubah_tgl_firebird(ubah_tgl_indo($r->TGLTRANS));
	return $r->TGLTRANS;
}

function tutup_all_trans($param,$idtrans,$tutup){
	$CI =& get_instance();	
	$CI->load->database($_SESSION[NAMAPROGRAM]['CONFIG']);
	
	$CI->db->set('TUTUP',$tutup)
		->where($param['id'],$idtrans)
		->where('IDPERUSAHAAN',$_SESSION[NAMAPROGRAM]['IDPERUSAHAAN'])
		->update($param['tabledtl']);
	if($CI->db->trans_status()===FALSE){
		$CI->db->trans_rollback();
		return 'Tutup Gagal';
	}	
	
	//update status sesuai parameter, true maka 'P', false maka 'S'
	$CI->db->set('STATUS',$tutup?'P':'S')
			->where($param['id'],$idtrans)
			->where('IDPERUSAHAAN',$_SESSION[NAMAPROGRAM]['IDPERUSAHAAN'])
			->update($param['table']);
			
	if($CI->db->trans_status()===FALSE){
		$CI->db->trans_rollback();
		return 'Update Status Gagal';
	}		
		
}

function send_mail($table, $column_field, $kodetrans, $jtrans, $kodemenu) {
	global $db;
	//$db = new DB;

	$list_user_penerima = array();
	$list_email_penerima = array();
	$sql = 'select
				distinct c.userid, c.username, c.email
			from
				mmenulink a inner join muserakses b on a.kodemenu=b.kodemenu and b.hakakses=1
				inner join muser c on b.userid=c.userid
			where a.induk=?';
	$pr  = $db->prepare($sql);
	$exe = $db->execute($pr, $kodemenu);
	while ($rs = $db->fetch($exe)) {
		$list_user_penerima[] = $rs->USERNAME;
		$list_email_penerima[] = $rs->EMAIL;
	}

	$sql = 'select * from mmenu where kodemenu=?';
	$pr  = $db->prepare($sql);
	$exe = $db->execute($pr, $kodemenu);
	$rs  = $db->fetch($exe);
	$namamenu = $rs->NAMAMENUINGGRIS;

	$sql = 'select * from '.$table.' where '.$column_field.'=?';
	$pr  = $db->prepare($sql);
	$exe = $db->execute($pr, $kodetrans);
	$rs  = $db->fetch($exe);

	$jam_input = $rs->JAMINPUT;
	$tgl_input = ubah_tgl_firebird($rs->TGLINPUT);

	// email ke pengirim

	$mail = new PHPMailer;
	$mail->isSMTP();
	$mail->Host = 'smtp.gmail.com';
	$mail->SMTPAuth = true;
	$mail->Username = 'canadagreengate2015@gmail.com';
	$mail->Password = 'C4n4d4greengate';
	$mail->SMTPSecure = 'ssl';
	$mail->Port = 465;
	$mail->From = 'canadagreengate2015@gmail.com';
	$mail->FromName = 'Canada Green Gate';

	$mail->addAddress($_SESSION[NAMAPROGRAM]['email_user'], $_SESSION[NAMAPROGRAM]['user']);
	$mail->isHTML(true);
	$mail->Subject = 'Information';

	$body = 'Salam,'.
			'<br><br>'.
			'Anda melakukan '.$jtrans.' data '.$namamenu.
			'<br>'.
			'dengan nomor '.$kodetrans.','.
			'pada tanggal '.$tgl_input.' jam '.$jam_input.
			'<br>'.
			'kepada '.implode(", ", $list_user_penerima).
			'<br><br><br>'.
			'Terima Kasih';
	$mail->Body    = $body;
	if(!$mail->send()) {
		return $mail->ErrorInfo;
	}

	// email ke pengirim
	$mail = new PHPMailer;
	$mail->isSMTP();
	$mail->Host = 'smtp.gmail.com';
	$mail->SMTPAuth = true;
	$mail->Username = 'canadagreengate2015@gmail.com';
	$mail->Password = 'C4n4d4greengate';
	$mail->SMTPSecure = 'ssl';
	$mail->Port = 465;
	$mail->From = 'canadagreengate2015@gmail.com';
	$mail->FromName = 'Canada Green Gate';

	for ($i=0; $i<count($list_user_penerima); $i++) {
		$mail->addAddress($list_email_penerima[$i], $list_user_penerima[$i]);
	}
	$mail->isHTML(true);
	$mail->Subject = 'Information';
	$body = 'Salam,'.
			'<br><br>'.
			'Sdr/i '.$_SESSION[NAMAPROGRAM]['user'].
			'<br>'.
			'melakukan '.$jtrans.' data '.$namamenu.
			'<br>'.
			'dengan nomor '.$kodetrans.','.
			'<br>'.
			'pada tanggal '.$tgl_input.' jam '.$jam_input.
			'<br>'.
			'Harap segera lakukan cek data'.
			'<br><br><br>'.
			'Terima Kasih';
	$mail->Body    = $body;
	$mail->send();

	if(!$mail->send()) {
		return $mail->ErrorInfo;
	} else {
		return true;
	}
}

function kirim_notifikasi($table, $column_field, $kodetrans, $jtrans, $kodemenu) {
	global $db;
	//$db = new DB;

	$tr = $db->start_trans();

	$data_userid = array();
	$data_username = array();

	$sql = 'select
				distinct c.userid, c.username, c.email
			from
				mmenulink a inner join muserakses b on a.kodemenu=b.kodemenu and b.hakakses=1
				inner join muser c on b.userid=c.userid
			where a.induk=?';
	$pr  = $db->prepare($sql, $tr);
	$exe = $db->execute($pr, $kodemenu);
	while ($rs = $db->fetch($exe)) {
		$data_userid[] = $rs->userid;
		$data_username[] = $rs->USERNAME;
	}

	$sql = 'select * from mmenu where kodemenu=?';
	$pr  = $db->prepare($sql, $tr);
	$exe = $db->execute($pr, $kodemenu);
	$rs  = $db->fetch($exe);
	$namamenu = $rs->NAMAMENUINGGRIS;

	$sql = 'select * from '.$table.' where '.$column_field.'=?';
	$pr  = $db->prepare($sql, $tr);
	$exe = $db->execute($pr, $kodetrans);
	$rs  = $db->fetch($exe);

	$jam_input = $rs->JAMINPUT;
	$tgl_input = ubah_tgl_firebird($rs->TGLINPUT);

	$sql = $db->insert('tpemberitahuan', 4, $tr, true);
	$pr  = $db->prepare($sql, $tr);

	// ke pengirim
	$ket = 'Salam,'.
			chr(13).chr(13).
		   'Anda melakukan '.$jtrans.' data '.$namamenu.
			chr(13).
			'dengan nomor '.$kodetrans.', pada tanggal '.$tgl_input.' jam '.$jam_input.
			chr(13).
			'kepada '.implode(", ", $data_username).
			chr(13).chr(13).chr(13).
			'Terima Kasih';
	$data_values = array(
		0, $_SESSION[NAMAPROGRAM]['userid'], $ket, 'I'
	);
	$exe = $db->execute($pr, $data_values);

	// ke penerima
	$ket = 'Salam,'.
			chr(13).chr(13).
			'Sdr/i '.$_SESSION[NAMAPROGRAM]['user'].
			chr(13).
			'melakukan '.$jtrans.' data '.$namamenu.
			chr(13).
			'dengan nomor '.$kodetrans.','.
			chr(13).
			'pada tanggal '.$tgl_input.' jam '.$jam_input.
			chr(13).
			'Harap segera lakukan cek data'.
			chr(13).chr(13).chr(13).
			'Terima Kasih';
	for ($i=0; $i<count($data_userid); $i++) {
		$data_values = array(
			0, $data_userid[$i], $ket, 'I'
		);
		$exe = $db->execute($pr, $data_values);
	}

	$db->commit($tr);

	return true;
}

function log_history($kode, $menu, $act, $data_table, $kasir) {
	$CI =& get_instance();	
	$CI->load->database($_SESSION[NAMAPROGRAM]['CONFIG']);

	$json = array('kode'=>$kode);
	
	$data_table = json_decode(json_encode($data_table));

	$a_data = array();
	if(count($data_table)>0) {
		foreach ($data_table as $item => $value) {
			$sql = 'select * from '.$value->tabel.' where '.$value->kode.' = ?';
			
			$tempKode = $kode;
			if (strtolower(substr($value->kode, 0, 2)) == 'id') {
				$tempKode = $value->id;
			}

			$exe = $CI->db->query($sql, [$tempKode]);
			$json[$value->tabel][] = $exe->result();
		}
	}

	// GET MAC ADDRESS
	$_IP_ADDRESS = $_SERVER['REMOTE_ADDR'];
	$_PERINTAH = "arp -a $_IP_ADDRESS";
	ob_start();
	system($_PERINTAH);
	$_HASIL = ob_get_contents();
	ob_clean();
	$_PECAH = strstr($_HASIL, $_IP_ADDRESS);
	$_PECAH_STRING = explode($_IP_ADDRESS, str_replace(" ", "", $_PECAH));
	$_MAC = substr($_PECAH_STRING[1], 0, 17);
	//LAST END SCRIPT GET MAC ADDRESS

	$json['ip'] = $_IP_ADDRESS;
	$json['macaddress'] = $_MAC;

	$file_name = date('Ymd_His') . '_' . strtoupper($menu) . '_' . strtoupper($act) . '_' . $kasir . '.json';

	// change the name below for the folder you want
	$dir = $CI->config->item('datalog_path') . date('Y-m-d');

	if(is_dir($dir) === false ) {
		mkdir($dir, 0777, true);
	}

	$fp = fopen($dir . '/' . $file_name, "wb");
	fwrite($fp, json_encode($json, JSON_PRETTY_PRINT));
	fclose($fp);

	$datavalues = [
		'idperusahaan' => $_SESSION[NAMAPROGRAM]['IDPERUSAHAAN'],
		'kodetrans' => $kode,
		'aksi' => $act,
		'tglentry' => date('Y-m-d H:i:s'),
		'userentry' => $kasir,
		'namafile' => $file_name,
		'macaddress' => $_MAC,
		'ipaddress' => $_IP_ADDRESS,
	];

	$CI->db->insert('historyprogram', $datavalues);
}

/**
 * This file is part of the array_column library
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright Copyright (c) Ben Ramsey (http://benramsey.com)
 * @license http://opensource.org/licenses/MIT MIT
 */
if (!function_exists('array_column')) {
    /**
     * Returns the values from a single column of the input array, identified by
     * the $columnKey.
     *
     * Optionally, you may provide an $indexKey to index the values in the returned
     * array by the values from the $indexKey column in the input array.
     *
     * @param array $input A multi-dimensional array (record set) from which to pull
     *                     a column of values.
     * @param mixed $columnKey The column of values to return. This value may be the
     *                         integer key of the column you wish to retrieve, or it
     *                         may be the string key name for an associative array.
     * @param mixed $indexKey (Optional.) The column to use as the index/keys for
     *                        the returned array. This value may be the integer key
     *                        of the column, or it may be the string key name.
     * @return array
     */
    function array_column($input = null, $columnKey = null, $indexKey = null)
    {
        // Using func_get_args() in order to check for proper number of
        // parameters and trigger errors exactly as the built-in array_column()
        // does in PHP 5.5.
        $argc = func_num_args();
        $params = func_get_args();
        if ($argc < 2) {
            trigger_error("array_column() expects at least 2 parameters, {$argc} given", E_USER_WARNING);
            return null;
        }
        if (!is_array($params[0])) {
            trigger_error(
                'array_column() expects parameter 1 to be array, ' . gettype($params[0]) . ' given',
                E_USER_WARNING
            );
            return null;
        }
        if (!is_int($params[1])
            && !is_float($params[1])
            && !is_string($params[1])
            && $params[1] !== null
            && !(is_object($params[1]) && method_exists($params[1], '__toString'))
        ) {
            trigger_error('array_column(): The column key should be either a string or an integer', E_USER_WARNING);
            return false;
        }
        if (isset($params[2])
            && !is_int($params[2])
            && !is_float($params[2])
            && !is_string($params[2])
            && !(is_object($params[2]) && method_exists($params[2], '__toString'))
        ) {
            trigger_error('array_column(): The index key should be either a string or an integer', E_USER_WARNING);
            return false;
        }
        $paramsInput = $params[0];
        $paramsColumnKey = ($params[1] !== null) ? (string) $params[1] : null;
        $paramsIndexKey = null;
        if (isset($params[2])) {
            if (is_float($params[2]) || is_int($params[2])) {
                $paramsIndexKey = (int) $params[2];
            } else {
                $paramsIndexKey = (string) $params[2];
            }
        }
        $resultArray = array();
        foreach ($paramsInput as $row) {
            $key = $value = null;
            $keySet = $valueSet = false;
            if ($paramsIndexKey !== null && array_key_exists($paramsIndexKey, $row)) {
                $keySet = true;
                $key = (string) $row[$paramsIndexKey];
            }
            if ($paramsColumnKey === null) {
                $valueSet = true;
                $value = $row;
            } elseif (is_array($row) && array_key_exists($paramsColumnKey, $row)) {
                $valueSet = true;
                $value = $row[$paramsColumnKey];
            }
            if ($valueSet) {
                if ($keySet) {
                    $resultArray[$key] = $value;
                } else {
                    $resultArray[] = $value;
                }
            }
        }
        return $resultArray;
    }
}

function number($amount, $nofilter = false, $decimal = 2) {
	//if(is_numeric($amount) == false or ($nofilter == false && $_SESSION[NAMAPROGRAM]['TAMPILGRANDTOTAL'] == 0))
	//	$amount = 0;

	return number_format(floatVal($amount), $decimal, '.', ',');
}


// pengecekan stok
function cek_stok($kodebarang, $tgltrans, $jml, $satuan, $kodelokasi = '', $kodegudang = '') {
	global $db;
	//$db = new DB;

	// remark pengecekan stok
	// 09/01/2017
	return true;

	//return true;
	//if ($_SESSION[NAMAPROGRAM]['CEKSTOK'] == 1) {
		// jika gudang dan lokasi kosong
		// maka lokasi dari session dan gudang dari gudang utama
		if ($kodelokasi == '') {
			$kodelokasi = $_SESSION[NAMAPROGRAM]['KODELOKASI'];
		}

		/*$pr  = $db->prepare('call get_konversi_satuanutama(?, ?, @konversi, @satuanutama)');
		$exe = $db->execute($pr, array($rs->KODEBARANG, $rs->SATUAN));
		$exe = $db->query('select @konversi as konversi, @satuanutama as satuanutama');
		$r   = $db->fetch($exe);

		$konversi = $r2->KONVERSI==0 ? 1 : $r2->KONVERSI;*/

		// sisa data kartustok
		/*$pr	 = $db->prepare('call get_saldostok(?, ?, ?, @saldoqty)');
		$exe = $db->execute($pr, array($rs->KODEBARANG, $rs->KODELOKASI, $rs->TGLTRANS));
		$exe = $db->query('select @saldoqty as saldoqty');
		$r	 = $db->fetch($exe);

		$saldo_qty = $r->SALDOQTY;
		*/

		// sisa data mbarangdtl
		//$ex = $db->select('mbarangdtl', array('sum(sisa) as sisa'), array('kodelokasi'=>$kodelokasi, 'kodebrg'=>$kodebarang, 'tgltrans'=>));
		$sql = "select sum(sisa) as sisa
				from mbarangdtl
		        where kodelokasi = ? and
					  kodebarang = ? and
					  sisa > 0 and
					  tgltrans <= ?";
		$pr = $db->prepare($sql);
		$ex = $db->execute($pr, array($kodelokasi, $kodebarang, $tgltrans));
		$rs = $db->fetch($ex);
		$sisa_stok_fifo = $rs->SISA == '' ? 0 : $rs->SISA;

		if (/*$jml > $sisa_stok* or */$jml > $sisa_stok_fifo) {
			return false;
		} else {
			return true;
		}
	//} else {
	//	return true;
	//}

}

return_array_post_filter();

/* untuk memfilter dari serangan xss */
function return_array_post_filter(){
    $return_array = array();

    foreach($_POST as $postKey => $postVar){
		if (is_array($postVar) == false)
			$return_array[$postKey] = post_filter($postVar);
		else
			$return_array[$postKey] = $postVar;
    }

	$_POST = $return_array;
}

function post_filter($data) {
	$data = trim($data);

	//$data = stripslashes($data);
	//$data = htmlspecialchars($data, ENT_NOQUOTES);

	$data = str_replace('<script', '</script', $data);
	$data = str_replace('<?php', '</php', $data);
	$data = str_replace('<? ', '</php', $data);
	$data = str_replace('<?=', '</php=', $data);
	$data = str_replace('<style', '</style', $data);

	$data = str_replace('<SCRIPT', '</SCRIPT', $data);
	$data = str_replace('<?PHP', '</PHP', $data);
	$data = str_replace('<STYLE', '</STYLE', $data);

	return $data;

}

function get_new_urutan($table, $field, $param, $count = 6){
	global $db;

	$j = 1;
	for ($i=0; $i<$count; $i++) {
		$j .= 0;
	}
	$j++;

	// dapatkan panjang kode/kodetrans
	// lalu tambahkan angka 1
	$ln = strlen($param[0]) + $count;

	//$db = new DB;

	$sql = "select right(max(kode), $count) as URUTAN
			from (select substring($field from 1 for $ln) as kode, right($field, 2) as tahun
				  from $table)
			where kode like '%'||?||'%' and tahun = ?";
	$pr  = $db->prepare($sql);
	$exe = $db->execute($pr, $param);
	$rs  = $db->fetch($exe);

	$urutan = $rs->URUTAN + $j;

	return substr($urutan, 1);
}

function cek_sisa_stok($mode, $data) {
	global $db;

	// blm ada procedure get stok, remark dulu
	// 26.05.2017
	return true;

	// mode tambah = data_detail
	// mode ubah = kodetrans, data_detail
	// mode hapus = kodetrans

	if ($mode == 'tambah') {
		$kodelokasi = $_SESSION[NAMAPROGRAM]['KODELOKASI'];
		$tgltrans = $data['tgltrans']; //date('Y-m-d');

		if (isset($data['kodelokasi']) or $data['kodelokasi']!='') {
			$kodelokasi = $data['kodelokasi'];
		}

		$sql = "
			select a.kodebarang, b.konversi, c.saldo, d.namalokasi
			from mbarang a
			left join get_konversi_satuanutama(a.kodebarang, ?) b on 1=1
			left join get_saldostok(a.kodebarang, ?, ?) c on 1=1
			inner join mlokasi d on 1=1
			where a.kodebarang = ? and
				  d.kodelokasi = ?
		";
		$pr = $db->prepare($sql);

		foreach ($data['data_detail'] as $item) {
			$exe = $db->execute($pr, array($item->satuan, $kodelokasi, $tgltrans, $item->kodebarang, $kodelokasi));
			$rs = $db->fetch($exe);

			$jml_asli = $item->jml * $rs->KONVERSI;
			if ($rs->SALDO < $jml_asli) {
				die(json_encode(array('errorMsg' => 'Stok barang '.$item->kodebarang.' ('.$item->namabarang.') tidak mencukupi, Sisa stok per tanggal '.$tgltrans.' di lokasi '.$rs->NAMALOKASI.' = '.number($rs->SALDO))));
			}
		}
	} else if ($mode == 'ubah' or $mode == 'hapus') {
		$tgltrans = $data['tgltrans']; //date('Y-m-d');
		$not_deleted_items = $deleted_items = $new_items = array();
		$sql = '
			select a.kodebarang, a.jml, b.namabarang, c.saldo, d.namalokasi, a.kodelokasi, a.mk
			from kartustok a
			inner join mbarang b on a.kodebarang=b.kodebarang
			inner join mlokasi d on a.kodelokasi=d.kodelokasi
			left join get_saldostok(a.kodebarang, a.kodelokasi, ?) c on 1=1
			where a.kodetrans=?
			order by a.mk desc
		';
		$pr = $db->prepare($sql);
		$ex = $db->execute($pr, array($tgltrans, $data['kodetrans']));
		while ($r = $db->fetch($ex)) {
			// dapatkan kodebarang, satuan, jml
			$barang = new stdClass();
			if (count($data['data_detail']) > 0) {
				foreach ($data['data_detail'] as $item) {
					if ($r->KODEBARANG == $item->kodebarang) {
						// get konversi
						$pr = $db->prepare('select * from get_konversi_satuanutama(?, ?)');
						$q  = $db->execute($pr, array($item->kodebarang, $item->satuan));
						$rs = $db->fetch($q);

						$barang->kodebarang = $item->kodebarang;
						$barang->satuan = $item->satuan;
						$barang->jml = $item->jml * $rs->KONVERSI;

						// masukkan data sebagai barang yang tidak dihapus
						$not_deleted_items[] = $item->kodebarang;
						break;
					}
				}
			}

			// jika barang tidak ada dalam data detail, maka bisa dikatakan item dihapus
			if ($barang->kodebarang == '') {
				// masukkan data sebagai barang yang dihapus
				$deleted_items[] = $r->KODEBARANG;

				$new_qty = 0;
			} else {
				$new_qty = $barang->jml;
			}

			if ($r->MK == 'K') {
				$old_saldo = $r->JML + $r->SALDO;

				$new_saldo = $old_saldo - $new_qty;

				if ($mode == 'ubah' && $barang->kodebarang == '') {
					$new_saldo = 0;
				}
			} else {
				$old_saldo = $r->SALDO - $r->JML;

				$new_saldo = $old_saldo + $new_qty;
			}

			if ($new_saldo < 0) {
				die(json_encode(array('errorMsg' => 'Stok barang '.$r->KODEBARANG.' ('.$r->NAMABARANG.') tidak mencukupi, Sisa stok per tanggal '.$tgltrans.' di lokasi '.$r->NAMALOKASI.' = '.number($r->SALDO))));
			}
		}

		// disini cari barang yang tidak ada di array barang yg dihapus dan array barang yang tidak dihapus
		if (count($data['data_detail']) > 0) {
			foreach ($data['data_detail'] as $item) {
				if (!in_array($item->kodebarang, $deleted_items) && !in_array($item->kodebarang, $not_deleted_items)) {
					$new_items[] = $item;
				}
			}
		}

		if (count($new_items) > 0)
			cek_sisa_stok('tambah', array('tgltrans'=>$tgltrans, 'data_detail'=>$new_items));

	}
}
function cek_pemakaian_stok($kodetrans, $data_detail = array()) {
	global $db;
	//$db = new DB;

	/*$sql = 'select b.kodebarang, b.namabarang
			from mbarangdtl a
			inner join mbarang b on a.kodebrg = b.kodebarang
			where a.kodetrans = ? and
				  a.jmlout > 0 and
				  a.sisa < a.jmlin';
	$pr = $db->prepare($sql);
	$qr = $db->execute($pr, array($kodetrans));
	while ($rs = $db->fetch($qr)) {
		die(json_encode(array('errorMsg' => 'Ada Barang Yang Telah Digunakan')));
		break;
	}*/

	$data_barang = array();
	if (count($data_detail) > 0) {
		foreach ($data_detail as $item) {
			$data_barang[$item->kodebarang] = $item->jml;
		}
	}

	// ambil max tgltrans dr kartustok
	$q = $db->select('kartustok', array('max(tgltrans) as tgltrans'));
	$r = $db->fetch($q);
	$tgltrans = $r->TGLTRANS;

	$sql = 'select a.kodebarang, a.jml, b.namabarang, c.saldo, d.namalokasi, a.kodelokasi, a.mk
			from kartustok a
			inner join mbarang b on a.kodebarang=b.kodebarang
			inner join mlokasi d on a.kodelokasi=d.kodelokasi
			left join GET_SALDOSTOK(a.kodebarang, a.kodelokasi, ?) c on 1=1
			where a.kodetrans=?';
	$pr = $db->prepare($sql);
	$ex = $db->execute($pr, array($tgltrans, $kodetrans));
	while ($r = $db->fetch($ex)) {
		if ($r->MK == 'K') {
			$new_qty = $data_barang[$r->KODEBARANG] =='' ? 0 : $data_barang[$r->KODEBARANG];

			$old_saldo = $r->JML + $r->SALDO;

			$new_saldo = $old_saldo - $new_qty;
		} else {
			$new_qty = $data_barang[$r->KODEBARANG] =='' ? 0 : $data_barang[$r->KODEBARANG];

			$old_saldo = $r->SALDO - $r->JML;

			$new_saldo = $old_saldo + $new_qty;
		}

		if ($new_saldo < 0) {
			die(json_encode(array('errorMsg' => 'Stok barang '.$r->KODEBARANG.' ('.$r->NAMABARANG.') tidak mencukupi, Sisa stok per tanggal '.$tgltrans.' di lokasi '.$r->NAMALOKASI.' = '.number($saldo_qty))));
		}
	}
}

// filter untuk datagrid-row-filter
function filter_datagrid($data) {
	$data = json_decode($data);
	$sql_filter = '';
	$param = array();
	if (count($data) > 0) {
		foreach ($data as $item) {
			$sql_filter .= 'and '.$item->field.' like ? ';
			$param[] = '%'.$item->value.'%';
		}
		if ($sql_filter <> '') {
			$sql_filter = ' and '.substr($sql_filter, 3).' ';
		}
	}

	return((object) array('sql'=>$sql_filter, 'param'=>$param));
}

// fungsi ini dijalankan utk mengecek salah satu field di datagrid apakah sesuai dengan master di database
function cek_data($rows, $field, $table) {
	
	$CI =& get_instance();	

	$jml_item = count($rows);

	$temp_item = array();
	$temp_sql = '';
	for ($i=0; $i<$jml_item; $i++) {
		$row = (array) $rows[$i];

		$temp_item[] = $row[$field];
		$temp_sql .= 'or '.$field.'=? ';
	}

	$sql = 'select count(*) as JML from '.$table.($temp_sql <> '' ? ' where '.substr($temp_sql, 2) : '');

	$r = $CI->db->query($sql,$temp_item)->row();

	// remove duplicate data
	$jml = count(array_unique($temp_item));

	if ($r->JML <> $jml) {
		die(json_encode(array('errorMsg' => 'Cek Detil Transaksi, Ada '.$field.' Yang Tidak Sesuai Dengan Data')));
	}
}

function cek_faktur_terpakai($kodetrans) {
	// pakai sistem baru periodik 11.01.2018

	return '';
	/*global $db;

	$ex = $db->select('mbarangdtlout', array('kodebarang'), array('kodetransin' => $kodetrans));
	$rs = $db->fetch($ex);

	return $rs->KODEBARANG;*/
}

// enter untuk keterangan
function format_remark($keterangan) {
	if ($keterangan == 'undefined')
		return '';
	else
		return str_replace("\n", "<br>",$keterangan);
}

function halaman($halaman,$rows,$max_item)
{
		
		if($rows == 0)
		{
			$max_hal = 1;
		}
		else
		{
			$max_hal = ceil($rows / $max_item);
		}
		
		return 'Hal : '.$halaman.' of '.$max_hal;
}
?>