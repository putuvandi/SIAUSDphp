<?php
require_once 'DB_Functions.php';
$db = new DB_Functions();
 
// json response array
$response = array("error" => FALSE);
 
if (isset($_POST['nim']) && isset($_POST['passwordlama']) && isset($_POST['passwordbaru']) && isset($_POST['konfpassword'])) {
 
    // menerima parameter POST 
    $nim = $_POST['nim'];
    $passwordlama = $_POST['passwordlama'];
	$passwordbaru = $_POST['passwordbaru'];
	$konfpassword = $_POST['konfpassword'];
	
	$regex = '/[^A-Za-z0-9\.]/';
	
	if((preg_match($regex, $passwordlama) || substr_count($passwordlama, '.') > 1) ||
		(preg_match($regex, $passwordbaru) || substr_count($passwordbaru, '.') > 1) ||
		(preg_match($regex, $konfpassword) || substr_count($konfpassword, '.') > 1)){
			$response["error"] = TRUE;
			$response["error_msg"] = "Gagal mengubah password";
			echo json_encode($response);
		} else {
			// get the user by email and password
			// get user berdasarkan email dan password
			$user = $db->getMhsByNimAndPassword($nim, $passwordlama);
 
			if ($user != false) {
				if ($passwordbaru !== $konfpassword) {
					$response["error"] =  TRUE;
					$response["error_msg"] = "Password baru dan password konfirmasi tidak sama";
					echo json_encode($response);
				} else if (($passwordbaru === '') && ($konfpassword === '')) {
					$response["error"] = TRUE;
					$response["error_msg"] = "Gagal mengubah password. Password baru tidak boleh kosong";
					echo json_encode($response);
				}else {
					// user ditemukan
					$ubah = $db->ubahPasswordMhs($nim, $konfpassword);
					$response["error"] = FALSE;
					$response["message"] = "Password berhasil diubah";
					echo json_encode($response);
				}
			} else {
				// user tidak ditemukan password/email salah
				$response["error"] = TRUE;
				$response["error_msg"] = "Gagal mengubah password. Password lama salah";
				echo json_encode($response);
			}
		}
} else {
    $response["error"] = TRUE;
    $response["error_msg"] = "Gagal mengubah password. Lengkapi inputan";
    echo json_encode($response);
}
?>