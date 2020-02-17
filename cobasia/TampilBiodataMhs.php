<?php
require_once 'DB_Functions.php';
$db = new DB_Functions();
 
// json response array
$response = array("error" => FALSE);
 
if (isset($_GET['nim'])) {
 
    // menerima parameter GET ( nim )
    $nim = $_GET['nim'];
 
    // get mahasiswa
    $mhs = $db->getMahasiswa($nim);
 
    if ($mhs != false) {
        // user ditemukan
        $response["error"] = FALSE;
        $response["mahasiswa"]["nim"] = $mhs["nim"];
		$response["mahasiswa"]["nama_mahasiswa"] = $mhs["nama_mahasiswa"];
		$response["mahasiswa"]["kode_kabupaten_lahir"] = $mhs["kode_kab_lahir"];
		$response["mahasiswa"]["tempat_lahir"] = $mhs["tempat_lahir"];
		$response["mahasiswa"]["tgl_lahir"] = date('Y-m-d', strtotime($mhs["tgl_lahir"]));
		$response["mahasiswa"]["jenis_kelamin"] = $mhs["jenis_kelamin"];
		$response["mahasiswa"]["alamat_skr"] = $mhs["alamat_skr"];
		$response["mahasiswa"]["kode_kabupaten_skr"] = $mhs["kode_kab_skr"];
		$response["mahasiswa"]["kode_pos_skr"] = $mhs["kode_pos_skr"];
		$response["mahasiswa"]["alamat_asal"] = $mhs["alamat_asal"];
		$response["mahasiswa"]["kode_kabupaten_asal"] = $mhs["kode_kab_asal"];
		$response["mahasiswa"]["kode_pos_asal"] = $mhs["kode_pos_asal"];
		$response["mahasiswa"]["nama_ayah"] = $mhs["nama_ayah"];
		$response["mahasiswa"]["email"] = $mhs["email"];
		$response["mahasiswa"]["no_hp"] = $mhs["no_hp"];
		$response["mahasiswa"]["nisn"] = $mhs["nisn"];
		$response["mahasiswa"]["nik"] = $mhs["nik"];
		$response["mahasiswa"]["tgl_lahir_ayah"] = date('Y-m-d', strtotime($mhs["tgl_lahir_ayah"]));
		$response["mahasiswa"]["nama_ibu_kandung"] = $mhs["nama_ibu_kandung"];
		$response["mahasiswa"]["tgl_lahir_ibu_kandung"] = date('Y-m-d', strtotime($mhs["tgl_lahir_ibu_kandung"]));
		$response["mahasiswa"]["nik_ayah"] = $mhs["nik_ayah"];
		$response["mahasiswa"]["nik_ibu_kandung"] = $mhs["nik_ibu_kandung"];
        echo json_encode($response);
    } else {
        // user tidak ditemukan password/email salah
        $response["error"] = TRUE;
        $response["error_msg"] = "Gagal mengambil data";
        echo json_encode($response);
    }
} else {
    $response["error"] = TRUE;
    $response["error_msg"] = "tidak dapat mengambil data";
    echo json_encode($response);
}
?>