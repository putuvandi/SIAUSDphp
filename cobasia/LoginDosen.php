<?php
require_once 'DB_Functions.php';
$db = new DB_Functions();
 
// json response array
$response = array("error" => FALSE);
 
if (isset($_POST['user']) && isset($_POST['password'])) {
 
    // menerima parameter POST ( email dan password )
    $user = $_POST['user'];
    $password = $_POST['password'];

    if (!($user === '') && !($password === '')) {
        // get the dosen by email and password
        // get dosen berdasarkan email dan password
        $dosen = $db->getDosenByEmailAndPassword($user, $password);
 
        if ($dosen != false) {
            // dosen ditemukan
            $response["error"] = FALSE;
            //$response["uid"] = $dosen["unique_id"];
            $response["dosen"]["user"] = $dosen["user"];
            $response["dosen"]["kode_pegawai"] = $dosen["kode_pegawai"];
            //$response["dosen"]["email"] = $dosen["email"];
            echo json_encode($response);
        } else {
            // dosen tidak ditemukan password/email salah
            $response["error"] = TRUE;
            $response["error_msg"] = "Login gagal. Username atau Password salah";
            echo json_encode($response);
        }
    } else {
        $response["error"] = TRUE;
        $response["error_msg"] = "Usename password ada yang kurang";
        echo json_encode($response);
    }
}
?>