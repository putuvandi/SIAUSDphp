<?php
 
class DB_Functions {
 
    private $conn;
 
    // constructor
    function __construct() {
        require_once 'DB_Connect.php';
        // koneksi ke database
        $db = new Db_Connect();
        $this->conn = $db->connect();
    }
 
    // destructor
    function __destruct() {
         
    }
	
	public function getDosenByUserAndPassword($user, $password) {
 
		if ($stmt = $this->conn->prepare("SELECT * FROM sdm.passwordpegawai s WHERE s.user = ? AND s.password = ?")) {
 
			$stmt->bind_param("ss", $user, $password);
 
			if ($stmt->execute()) {
				$dosen = $stmt->get_result()->fetch_assoc();
				$stmt->close();

				return $dosen;
			} else {
				return NULL;
			}
		}
    }
	
	public function ubahPasswordDosen($user, $passwordbaru) {
		
		if ($stmt = $this->conn->prepare("UPDATE sdm.passwordpegawai s SET s.password = ? WHERE s.user = ?")) {
			
			$stmt->bind_param("ss", $passwordbaru, $user);
			
			if ($stmt->execute()) {
				$stmt->close();
				
				return true;
			} else {
				echo "Gagal mengubah password";
			}
		}
		
	}
	
	public function ubahBiodataDosen($kode_pegawai, $glr_dpn, $glr_blk, $nik, $npwp, $alamat_skr, $telp_rumah, $no_hp1, $email1, $tempat_lahir, $tgl_lahir, $nama_status_keluar, $nama_stats_pegawai, $nidn, $alamat_ktp, $email2, $no_hp2){

		$queryKodeStatusKeluar = "SELECT kode_status_keluar FROM acuan.status_keluar WHERE nama_status_keluar = ?";
		$queryKodeStatusPegawai = "SELECT kode_status_pegawai FROM acuan.status_pegawai WHERE nama_stats_pegawai = ?";
		
		if ($stmt = $this->conn->prepare("UPDATE sdm.pegawai p SET glr_dpn = ?, glr_blk = ?, nik = ?, npwp = ?, alamat_skr = ?, telp_rumah = ?, no_hp1 = ?, email1 = ?, tempat_lahir = ?, tgl_lahir = ?, kode_status_keluar = (".$queryKodeStatusKeluar."), kode_status_pegawai = (".$queryKodeStatusPegawai."), nidn = ?, alamat_ktp = ?, email2 = ?, no_hp2 = ? WHERE p.kode_pegawai = ?")) {
			
			$stmt->bind_param("sssssssssssssssss", $glr_dpn, $glr_blk, $nik, $npwp, $alamat_skr, $telp_rumah, $no_hp1, $email1, $tempat_lahir, $tgl_lahir, $nama_status_keluar, $nama_stats_pegawai, $nidn, $alamat_ktp, $email2, $no_hp2, $kode_pegawai);
			
			if ($stmt->execute()) {
				$stmt->close();
				
				return true;
			} else {
				echo "Gagal update biodata";
			}
		}
	}
	
	public function getDosen($kode_pegawai){

		$queryNamaSex = "SELECT nama_sex FROM acuan.sex s INNER JOIN sdm.pegawai p ON p.kode_sex = s.kode_sex WHERE p.kode_pegawai = ?";
		$queryStatusKeluar = "SELECT nama_status_keluar FROM acuan.status_keluar s INNER JOIN sdm.pegawai p ON p.kode_status_keluar = s.kode_status_keluar WHERE p.kode_pegawai = ?";
		$queryStatusPegawai = "SELECT nama_stats_pegawai FROM acuan.status_pegawai s INNER JOIN sdm.pegawai p ON p.kode_status_pegawai = s.kode_status_pegawai WHERE p.kode_pegawai = ?";

		if ($stmt = $this->conn->prepare("SELECT kode_pegawai, nama_pegawai, glr_dpn, glr_blk, nik, file_nik, npwp, file_npwp, alamat_skr, telp_rumah, no_hp1, email1, tempat_lahir, tgl_lahir, (".$queryNamaSex.") as jenis_kelamin, (".$queryStatusKeluar.") as nama_status_keluar, (".$queryStatusPegawai.") as nama_stats_pegawai, nidn, alamat_ktp, email2, no_hp2 FROM sdm.pegawai p WHERE p.kode_pegawai = ?")) {
			
			$stmt->bind_param("ssss", $kode_pegawai, $kode_pegawai, $kode_pegawai, $kode_pegawai);

			if ($stmt->execute()) {
				$dsn = $stmt->get_result()->fetch_assoc();
				$stmt->close();

				return $dsn;
			}else{
				return NULL;
			}
		}
	}
	
	/**
     * Get all status keluar
     */
	public function getAllStatusKeluar() {
 
		if ($stmt = $this->conn->query("SELECT nama_status_keluar from acuan.status_keluar")) {
 
			$output = array();
			while ($baris = mysqli_fetch_assoc($stmt)) {
				array_push($output,array("status_keluar"=>$baris['nama_status_keluar']));
			}
			echo json_encode(array('result'=>$output));
		}
    }
	
	/**
     * Get all status pegawai
     */
    public function getAllStatusPegawai() {
 
		if ($stmt = $this->conn->query("SELECT nama_stats_pegawai from acuan.status_pegawai")) {
 
			$output = array();
			while ($baris = mysqli_fetch_assoc($stmt)) {
				array_push($output,array("status_pegawai"=>$baris['nama_stats_pegawai']));
			}
			echo json_encode(array('result'=>$output));
		}
    }
	
	/**
	 * Mengganti biodata mahasiswa 
	 */
	public function ubahBiodataMhs($nim, $kodeKabLahir, $tempatLahir, $tglLahir, $alamatSkr, $kodeKabSkr, $kodePosSkr, 
	$alamatAsal, $kodeKabAsal, $kodePosAsal, $namaAyah, $email, $noHp, $nisn, $nik, $tglLahirAyah, $namaIbu, $tglLahirIbu, 
	$nikAyah, $nikIbu) {
		
		$subquery = "SELECT kode_kabupaten FROM acuan.kabupaten WHERE nama_kabupaten = ?";
		
		$query = "UPDATE mahasiswa5314 SET kode_kabupaten_lahir = (".$subquery."), tempat_lahir = ?, tgl_lahir = ?, ".
			"alamat_skr = ?, kode_kabupaten_skr = (".$subquery."), kode_pos_skr = ?, alamat_asal = ?, ".
			"kode_kabupaten_asal = (".$subquery."), kode_pos_asal = ?, nama_ayah = ?, email = ?, no_hp = ?, nisn = ?, nik = ?, ".
			"tgl_lahir_ayah = ?, nama_ibu_kandung = ?, tgl_lahir_ibu_kandung = ?, nik_ayah = ?, nik_ibu_kandung = ? WHERE nim = ?";
		
		if ($stmt = $this->conn->prepare($query)) {
			
			$stmt->bind_param("ssssssssssssssssssss", $kodeKabLahir, $tempatLahir, $tglLahir, $alamatSkr, $kodeKabSkr, 
			$kodePosSkr, $alamatAsal, $kodeKabAsal, $kodePosAsal, $namaAyah, $email, $noHp, $nisn, $nik, $tglLahirAyah, 
			$namaIbu, $tglLahirIbu, $nikAyah, $nikIbu, $nim);
			
			if ($stmt->execute()) {
				$stmt->close();
				
				//echo "Password berhasil diubah";
				return true;
			} else {
				echo "Gagal mengubah biodata";
				//return false;
			}
		}
	}
	
	/**
     * Get user berdasarkan email dan password
     */
    public function getMhsByNimAndPassword($nim, $password) {
 
		if ($stmt = $this->conn->prepare("SELECT * FROM password5314 WHERE nim = ? AND password = ?")) {
 
			$stmt->bind_param("ss", $nim, $password);
 
			if ($stmt->execute()) {
				$user = $stmt->get_result()->fetch_assoc();
				$stmt->close();
				return $user;
			} else {
				return NULL;
			}
		}
    }
	
	/**
	 * Mengganti password user 
	 */
	public function ubahPasswordMhs($nim, $passwordbaru) {
		
		if ($stmt = $this->conn->prepare("UPDATE password5314 SET password = ? WHERE nim = ?")) {
			
			$stmt->bind_param("ss", $passwordbaru, $nim);
			
			if ($stmt->execute()) {
				$stmt->close();
				return true;
			} else {
				echo "Gagal mengubah password";
			}
		}
		
	}
	
	/**
     * Get user berdasarkan nim
     */
    public function getMahasiswa($nim) {
		
		$subquery = "SELECT nama_kabupaten FROM acuan.kabupaten k WHERE k.kode_kabupaten = ";
		$subquery2 = "(SELECT nama_sex FROM acuan.sex s INNER JOIN dbase5314.mahasiswa5314 m ON m.kode_sex = s.kode_sex WHERE m.nim = ?)";
		
		$query = "SELECT nim, nama_mahasiswa, (".$subquery."kode_kabupaten_lahir) as kode_kab_lahir, tempat_lahir, tgl_lahir, ".
		$subquery2." as jenis_kelamin, alamat_skr, (".$subquery."kode_kabupaten_skr) as kode_kab_skr, kode_pos_skr, alamat_asal, ".
		"(".$subquery."kode_kabupaten_asal) as kode_kab_asal, kode_pos_asal, nama_ayah, email, no_hp, nisn, nik, tgl_lahir_ayah, ".
		"nama_ibu_kandung, tgl_lahir_ibu_kandung, nik_ayah, nik_ibu_kandung FROM mahasiswa5314 WHERE nim = ?";
		
		if ($stmt = $this->conn->prepare($query)) {
 
			$stmt->bind_param("ss", $nim, $nim);
 
			if ($stmt->execute()) {
				$mhs = $stmt->get_result()->fetch_assoc();
				$stmt->close();
 
				return $mhs;
			} else {
				return NULL;
			}
		}
    }
	
	/**
     * Get jenis kelamin berdasarkan kodeSex
     */
    public function getAllKabupaten() {
 
		if ($stmt = $this->conn->query("SELECT nama_kabupaten from acuan.kabupaten")) {
			$output = array();
			while ($baris = mysqli_fetch_assoc($stmt)) {
				array_push($output,array("kabupaten"=>$baris['nama_kabupaten']));
			}
			echo json_encode(array('result'=>$output));
		}
    }
}
 
?>