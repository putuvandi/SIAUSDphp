<?php
require_once 'DB_Functions.php';
$db = new DB_Functions();
 
// json response array
$response = array("error" => FALSE);
 
if (isset($_POST['nim']) && isset($_POST['kodeKabLahir'])) {
 
    // menerima parameter POST 
    $nim = $_POST['nim'];
    $kodeKabLahir = $_POST['kodeKabLahir'];
	
    // get the user by email and password
    // get user berdasarkan email dan password
    $user = $db->getMahasiswa($nim);
 
    if ($user != false) {
		// user ditemukan
		$ubah = $db->ubahKodeKabupatenLahir($nim, $kodeKabLahir);
		$response["error"] = FALSE;
		$response["message"] = "Biodata berhasil diubah";
		//$response["user"]["nim"] = $user["nim"];
		echo json_encode($response);
		
    } else {
        // user tidak ditemukan password/email salah
        $response["error"] = TRUE;
        $response["error_msg"] = "Gagal mengubah biodata";
        echo json_encode($response);
    }
} else {
    $response["error"] = TRUE;
    $response["error_msg"] = "Gagal mengubah biodata. Lengkapi inputan";
    echo json_encode($response);
}
?>