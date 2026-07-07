function cek_tanggal_tutup_periode(tgltrans, jenisclosing, callback) {
	var str_jenisclosing = [
		'HITUNGHPP',
		'AKUNTANSI'
	];

	$.ajax({
		type: 'POST',
		url: base_url + 'Home/cekTanggalTutupPeriode',
		data: {
			tgltrans: tgltrans,
			jenisclosing: str_jenisclosing[jenisclosing]
		},
		async: false,
		success: function (response) {
			callback(response)
		}
	})
}