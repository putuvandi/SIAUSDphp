<?php
require_once 'DB_Functions.php';
$db = new DB_Functions();
 
// json response array
$response = array("error" => FALSE);
 
if (isset($_POST['user']) && isset($_POST['passwordlama']) && isset($_POST['passwordbaru']) && isset($_POST['konfpassword'])) {
 
    // menerima parameter POST ( email dan password )
    $user = $_POST['user'];
    $passwordlama = $_POST['passwordlama'];
    $passwordbaru = $_POST['passwordbaru'];
    $konfpassword = $_POST['konfpassword'];
    
    // get the user by email and password
    // get user berdasarkan email dan password
    $dosen = $db->getDosenByEmailAndPassword($user, $passwordlama);
 
    if ($dosen != false) {
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
            $ubah = $db->ubahPasswordDosen($user, $konfpassword);
            $response["error"] = FALSE;
            $response["message"] = "Password berhasil diubah";
            //$response["user"]["nim"] = $user["nim"];
            echo json_encode($response);
        }
    } else {
        // user tidak ditemukan password/email salah
        $response["error"] = TRUE;
        $response["error_msg"] = "Gagal mengubah password. Password lama salah";
        echo json_encode($response);
    }
} else {
    $response["error"] = TRUE;
    $response["error_msg"] = "Gagal mengubah password. Lengkapi inputan";
    echo json_encode($response);
}
?>
