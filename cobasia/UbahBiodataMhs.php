<?php
require_once 'DB_Functions.php';
$db = new DB_Functions();
 
// json response array
$response = array("error" => FALSE);
 
if (isset($_POST['nim']) && isset($_POST['kodeKabLahir']) && isset($_POST['tempatLahir']) && isset($_POST['tglLahir']) 
	&& isset($_POST['alamatSkr']) && isset($_POST['kodeKabSkr']) && isset($_POST['kodePosSkr']) && isset($_POST['alamatAsal']) 
&& isset($_POST['kodeKabAsal']) && isset($_POST['kodePosAsal']) && isset($_POST['namaAyah']) && isset($_POST['email']) 
&& isset($_POST['noHp']) && isset($_POST['nisn']) && isset($_POST['nik']) && isset($_POST['tglLahirAyah']) 
&& isset($_POST['namaIbu']) && isset($_POST['tglLahirIbu']) && isset($_POST['nikAyah']) && isset($_POST['nikIbu'])) {
 
    // menerima parameter POST 
    $nim = $_POST['nim'];
    $kodeKabLahir = $_POST['kodeKabLahir'];
	$tempatLahir = $_POST['tempatLahir'];
	$tglLahir = $_POST['tglLahir'];
	$alamatSkr = $_POST['alamatSkr'];
	$kodeKabSkr = $_POST['kodeKabSkr'];
	$kodePosSkr = $_POST['kodePosSkr'];
	$alamatAsal = $_POST['alamatAsal'];
	$kodeKabAsal = $_POST['kodeKabAsal'];
	$kodePosAsal = $_POST['kodePosAsal'];
	$namaAyah = $_POST['namaAyah'];
	$email = $_POST['email'];
	$noHp = $_POST['noHp'];
	$nisn = $_POST['nisn'];
	$nik = $_POST['nik'];
	$tglLahirAyah = $_POST['tglLahirAyah'];
	$namaIbu = $_POST['namaIbu'];
	$tglLahirIbu = $_POST['tglLahirIbu'];
	if(!empty($_POST['nikAyah'])) { $nikAyah = $_POST['nikAyah']; } else { $nikAyah = NULL; }
	if(!empty($_POST['nikIbu'])) { $nikIbu = $_POST['nikIbu']; } else { $nikIbu = NULL; }
	
    // get the user by email and password
    // get user berdasarkan email dan password
    $user = $db->getMahasiswa($nim);
 
    if ($user != false) {
		if (($kodeKabLahir === '') && ($tempatLahir === '')) {
			$response["error"] = TRUE;
			$response["error_msg"] = "Gagal mengubah biodata";
			echo json_encode($response);
		} else {
			// user ditemukan
			$ubah = $db->ubahBiodataMhs($nim, $kodeKabLahir, $tempatLahir, $tglLahir, $alamatSkr, $kodeKabSkr, 
			$kodePosSkr, $alamatAsal, $kodeKabAsal, $kodePosAsal, $namaAyah, $email, $noHp, $nisn, $nik, $tglLahirAyah, 
			$namaIbu, $tglLahirIbu, $nikAyah, $nikIbu);
			$response["error"] = FALSE;
			$response["message"] = "Biodata berhasil diubah";
			echo json_encode($response);
		}
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