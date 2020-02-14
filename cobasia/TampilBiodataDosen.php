<?php
require_once 'DB_Functions.php';
$db = new DB_Functions();
 
// json response array
$response = array("error" => FALSE);

if (isset($_GET['kode_pegawai'])) {
	
	$kode_pegawai = $_GET['kode_pegawai'];

	$dsn = $db->getDosen($kode_pegawai);

	if ($dsn != false) {
		
		$response["error"] = FALSE;
		$response["dosen"]["kode_pegawai"] = $dsn["kode_pegawai"];
		$response["dosen"]["nama_pegawai"] = $dsn["nama_pegawai"];
		$response["dosen"]["glr_dpn"] = $dsn["glr_dpn"];
		$response["dosen"]["glr_blk"] = $dsn["glr_blk"];
		$response["dosen"]["nik"] = $dsn["nik"];
		$response["dosen"]["file_nik"] = $dsn["file_nik"];
		$response["dosen"]["npwp"] = $dsn["npwp"];
		$response["dosen"]["file_npwp"] = $dsn["file_npwp"];
		$response["dosen"]["alamat_skr"] = $dsn["alamat_skr"];
		$response["dosen"]["telp_rumah"] = $dsn["telp_rumah"];
		$response["dosen"]["no_hp1"] = $dsn["no_hp1"];
		$response["dosen"]["email1"] = $dsn["email1"];
		$response["dosen"]["tempat_lahir"] = $dsn["tempat_lahir"];
		$response["dosen"]["tgl_lahir"] = date('Y-m-d', strtotime($dsn["tgl_lahir"]));
		$response["dosen"]["jenis_kelamin"] = $dsn["jenis_kelamin"];
		$response["dosen"]["status_keluar"] = $dsn["nama_status_keluar"];
		$response["dosen"]["status_pegawai"] = $dsn["nama_stats_pegawai"];
		$response["dosen"]["nidn"] = $dsn["nidn"];
		$response["dosen"]["alamat_ktp"] = $dsn["alamat_ktp"];
		$response["dosen"]["email2"] = $dsn["email2"];
		$response["dosen"]["no_hp2"] = $dsn["no_hp2"];
		$response["message"] = "Berhasil mengambil data";
		echo json_encode($response);
	}else{
		//dosen tidak ditemukan
		$response["error"] = TRUE;
		$response["error_msg"] = "Gagal mengambil data 1";
		echo json_encode($response);
	}
}else{
	$response["error"] = TRUE;
	$response["error_msg"] = "Gagal mengambil data";
	echo json_encode($response);
}
?>