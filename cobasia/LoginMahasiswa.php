<?php
require_once 'DB_Functions.php';
$db = new DB_Functions();
 
// json response array
$response = array("error" => FALSE);
 
if (isset($_POST['nim']) && isset($_POST['password'])) {
	
	// menerima parameter POST ( email dan password )
	$nim = $_POST['nim'];
	$password = $_POST['password'];
	
	$regex = '/[^A-Za-z0-9\.]/';
	
	if (!($nim === '') && !($password === '')) {
		if((preg_match($regex, $nim) || substr_count($nim, '.') > 1) || (preg_match($regex, $password) || substr_count($password, '.') > 1)){
			$response["error"] = TRUE;
			$response["error_msg"] = "Login gagal. NIM atau Password salah";
			echo json_encode($response);
		} else {
			// get the user by email and password
			// get user berdasarkan email dan password
			$user = $db->getMhsByNimAndPassword($nim, $password);
 
			if ($user != false) {
				// user ditemukan
				$response["error"] = FALSE;
				$response["user"]["nim"] = $user["nim"];
				echo json_encode($response);
			} else {
				// user tidak ditemukan password/email salah
				$response["error"] = TRUE;
				$response["error_msg"] = "Login gagal. NIM atau Password salah";
				echo json_encode($response);
			}
		}
		
	} else {
		$response["error"] = TRUE;
		$response["error_msg"] = "NIM atau password tidak boleh kosong";
		echo json_encode($response);
	}
} 
?>