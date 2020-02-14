<?php
require_once 'DB_Functions.php';
$db = new DB_Functions();
 
// json response array
$response = array("error" => FALSE);
 
if (isset($_GET['kode_pegawai'])) {
 
    // menerima parameter GET ( nim )
    $kode_pegawai = $_GET['kode_pegawai'];
 
    // get mahasiswa
    $statuspegawai = $db->getStatusPegawai($kode_pegawai);
 
    if ($statuspegawai != false) {
        // user ditemukan
        $response["error"] = FALSE;
        $response["status_pegawai"] = $statuspegawai["nama_stats_pegawai"];
        echo json_encode($response);
    } else {
        // user tidak ditemukan password/email salah
        $response["error"] = TRUE;
        $response["error_msg"] = "Gagal mengambil data";
        echo json_encode($response);
    }
} else {
    $response["error"] = TRUE;
    $response["error_msg"] = "Gagal mengambil data";
    echo json_encode($response);
}
?>