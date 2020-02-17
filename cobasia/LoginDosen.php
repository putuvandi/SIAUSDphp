<?php
require_once 'DB_Functions.php';
$db = new DB_Functions();
 
// json response array
$response = array("error" => FALSE);
 
if (isset($_POST['user']) && isset($_POST['password'])) {
 
    // menerima parameter POST ( email dan password )
    $user = $_POST['user'];
    $password = $_POST['password'];
	
	$regex = '/[^A-Za-z0-9\.]/';

    if (!($user === '') && !($password === '')) {
		if((preg_match($regex, $user) || substr_count($user, '.') > 1) || (preg_match($regex, $password) || substr_count($password, '.') > 1)){
			$response["error"] = TRUE;
			$response["error_msg"] = "Login gagal. Username atau Password salah";
			echo json_encode($response);
		} else {
			// get the dosen by email and password
			// get dosen berdasarkan email dan password
			$dosen = $db->getDosenByUserAndPassword($user, $password);
 
			if ($dosen != false) {
				// dosen ditemukan
				$response["error"] = FALSE;
				$response["dosen"]["user"] = $dosen["user"];
				$response["dosen"]["kode_pegawai"] = $dosen["kode_pegawai"];
				echo json_encode($response);
			} else {
				// dosen tidak ditemukan password/email salah
				$response["error"] = TRUE;
				$response["error_msg"] = "Login gagal. Username atau Password salah";
				echo json_encode($response);
			}
		}
    } else {
        $response["error"] = TRUE;
        $response["error_msg"] = "Usename password ada yang kurang";
        echo json_encode($response);
    }
}
?>