<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Web_App_Model extends CI_Model {

	//query otomatis
	public function getData($table,$order)
	{	
		$this->db->order_by($order);
		return $this->db->get($table);
	}

	public function getAllDataSiswa($table)
	{	
		$query =  $this->db->query("SELECT * FROM tbl_siswa JOIN tbl_kelas ON tbl_siswa.kelas = tbl_kelas.id_kelas ORDER BY tbl_kelas.parent,tbl_kelas.nama_kelas,tbl_siswa.nis");

		return $query;
	}

	public function getAllDataGuru($table)
	{	
		$this->db->order_by('nama_guru');
		return $this->db->get($table);
	}

	public function getAllDataKelasParent($table,$parent)
	{	
		$this->db->order_by('id_kelas');
		$this->db->where('parent',$parent,false);
		return $this->db->get($table);
	}	

	public function getAllDataKelasChild($parent)
	{	
		return $this->db->query("SELECT * FROM tbl_kelas WHERE tbl_kelas.parent=$parent ORDER BY tbl_kelas.nama_kelas");
	}

	public function getAllKelasChild($table)
	{	
		$this->db->order_by('parent');
		$this->db->order_by('nama_kelas');
		$this->db->where('parent is not null');
		return $this->db->get($table);
	}

	public function getAllKelas()
	{	
		$query =  $this->db->query("SELECT * FROM tbl_kelas WHERE tbl_kelas.parent IS NOT NULL ORDER BY tbl_kelas.parent,tbl_kelas.nama_kelas");

		return $query->result();
	}

	public function getKelas($id)
	{	
		$query =  $this->db->query("SELECT DISTINCT tbl_kelas.nama_kelas,tbl_kelas.id_kelas FROM tbl_kelas_ajar JOIN tbl_guru ON tbl_kelas_ajar.id_guru = tbl_guru.id_guru JOIN tbl_kelas ON tbl_kelas_ajar.id_kelas = tbl_kelas.id_kelas WHERE tbl_kelas_ajar.id_guru = $id ORDER BY tbl_kelas.parent,tbl_kelas.nama_kelas");

		return $query->result();
	}

	public function getAnggotaKelompok($kelas)
	{	
		$query =  $this->db->query("SELECT tbl_siswa.nis, tbl_siswa.nama_siswa, tbl_siswa.id_siswa FROM tbl_siswa WHERE kelas='".$kelas."' ORDER BY tbl_siswa.nama_siswa");

		return $query;
	}

	public function getKelompok($tugas)
	{	
		$query =  $this->db->query("SELECT * FROM tbl_kelompok WHERE id_tugas='".$tugas."'");

		return $query->result();
	}

	public function cekKelompok($tugas,$siswa)
	{	
		$query =  $this->db->query("SELECT * FROM tbl_kelompok WHERE id_tugas='".$tugas."' AND id_siswa='".$siswa."'");

		return $query;
	}

	public function getAnggotaKelompok2($tugas,$siswa)
	{	
		$ambil =  $this->db->query("SELECT * FROM tbl_kelompok WHERE id_tugas='".$tugas."' AND id_siswa='".$siswa."'");

		$daftar = NULL;
		if($ambil->num_rows()>0){
			foreach ($ambil->result() as $ambil) {
				$nmr_kelompok = $ambil->kelompok;
			}
			$daftar = $this->db->query("SELECT * FROM tbl_kelompok WHERE id_tugas='".$tugas."' AND kelompok='".$nmr_kelompok."'");
			return $daftar;
		}
	}

	public function getMapel($id_kelas, $id_guru)
	{	
		$query = $this->db->query("SELECT DISTINCT tbl_mapel.nama_mapel,tbl_mapel.id_mapel FROM tbl_kelas_ajar JOIN tbl_mapel ON tbl_kelas_ajar.id_mapel = tbl_mapel.id_mapel WHERE tbl_kelas_ajar.id_kelas = $id_kelas AND tbl_kelas_ajar.id_guru = $id_guru");

		$output = '<option value="">Pilih Mapel</option>';
	  	
	  	foreach($query->result() as $row)
	  	{
	   		$output .= '<option value="'.$row->id_mapel.'">'.$row->nama_mapel.'</option>';
	  	}

	  	return $output;
	}

	public function getKelasSalin($id_tugas)
	{	
		$query = $this->db->query("SELECT DISTINCT tbl_kelas.nama_kelas,tbl_kelas.id_kelas FROM tbl_tugas JOIN tbl_kelas ON tbl_tugas.id_kelas = tbl_kelas.id_kelas WHERE tbl_tugas.id_tugas = $id_tugas");

		$output = 'Pilih Tugas';
	  	
	  	foreach($query->result() as $row)
	  	{
	   		$output = $row->nama_kelas;
	  	}

	  	return $output;
	}

	public function getMapel2($id)
	{	
		$query =  $this->db->query("SELECT DISTINCT tbl_mapel.nama_mapel,tbl_mapel.id_mapel FROM tbl_kelas_ajar JOIN tbl_guru ON tbl_kelas_ajar.id_guru = tbl_guru.id_guru JOIN tbl_mapel ON tbl_kelas_ajar.id_mapel = tbl_mapel.id_mapel WHERE tbl_kelas_ajar.id_guru = $id ORDER BY tbl_mapel.nama_mapel");

		return $query->result();
	}

	public function getMapelEdit($id_kelas, $id_guru)
	{	
		$query = $this->db->query("SELECT DISTINCT tbl_mapel.nama_mapel,tbl_mapel.id_mapel FROM tbl_kelas_ajar  JOIN tbl_mapel ON tbl_kelas_ajar.id_mapel = tbl_mapel.id_mapel WHERE tbl_kelas_ajar.id_kelas = $id_kelas AND tbl_kelas_ajar.id_guru = $id_guru");

	  	return $query;
	}

	public function getAllDataMapel($table)
	{	
		$this->db->order_by('nama_mapel');
		return $this->db->get($table);
	}

	public function getSelectedData($table,$pilih,$key,$value)
	{
		$this->db->select($pilih); 
		$this->db->where($key, $value); 
		return $this->db->get($table);
	}

	public function getWhereData($table,$key,$value)
	{
		$this->db->where($key, $value); 
		return $this->db->get($table);
	}

	public function getPesan($id)
	{
		$query = $this->db->query("SELECT * FROM tbl_pesan a INNER JOIN (SELECT type_id, sender_receiver_id, MAX(tanggal) AS coba FROM tbl_pesan WHERE type_id=1 GROUP BY sender_receiver_id) b ON a.tanggal = b.coba AND a.sender_receiver_id = b.sender_receiver_id JOIN tbl_login ON a.sender_receiver_id=tbl_login.id_login WHERE a.type_id=1 AND a.owner_id=$id");

		return $query;
	}

	public function getPesanKeluar($id)
	{
		$query = $this->db->query("SELECT * FROM tbl_pesan a INNER JOIN (SELECT type_id, sender_receiver_id, MAX(tanggal) AS coba FROM tbl_pesan WHERE type_id=2 GROUP BY sender_receiver_id) b ON a.tanggal = b.coba AND a.sender_receiver_id = b.sender_receiver_id JOIN tbl_login ON a.sender_receiver_id=tbl_login.id_login WHERE a.type_id=2 AND a.owner_id=$id");

		return $query;
	}

	public function getPesanDetail($pemilik,$id)
	{
		$query = $this->db->query("SELECT * FROM tbl_pesan a JOIN tbl_login b ON b.id_login = (CASE WHEN a.type_id=1 THEN a.sender_receiver_id ELSE a.owner_id END) WHERE a.owner_id=$pemilik AND a.sender_receiver_id=$id ORDER BY a.id desc");
		return $query;
	}

	public function HitungPesanPengirim($pemilik)
	{
		$query = $this->db->query("SELECT * FROM tbl_pesan a WHERE a.owner_id=$pemilik AND a.opened=0");
		return $query;
	}

	public function getRecipient($title){
		$this->db->like('nama', $title, 'BOTH');
		$this->db->limit(10);
		return $this->db->get('tbl_login')->result();
	}

	public function getHari()
	{
		$this->db->where('hari IS NOT NULL'); 
		return $this->db->get('tbl_mapel_ajar');
	}

	public function getHasilTugas($id)
	{
		$query = $this->db->query("SELECT * FROM tbl_tugas JOIN tbl_mapel ON tbl_tugas.id_mapel = tbl_mapel.id_mapel WHERE tbl_tugas.id_tugas = $id");

		return $query;
	}

	public function getJadwal($nama)
	{
		$query = $this->db->query("SELECT * FROM tbl_mapel_ajar JOIN tbl_kelas ON tbl_mapel_ajar.id_kelas = tbl_kelas.id_kelas JOIN tbl_mapel ON tbl_mapel_ajar.id_mapel = tbl_mapel.id_mapel WHERE tbl_mapel_ajar.hari IS NULL AND tbl_mapel_ajar.id_guru=$nama ORDER BY tbl_mapel_ajar.jam_mulai ASC");
		return $query;
	}

	public function getJadwalKelas($kelas)
	{
		$query = $this->db->query("SELECT * FROM tbl_mapel_ajar JOIN tbl_kelas ON tbl_mapel_ajar.id_kelas = tbl_kelas.id_kelas JOIN tbl_guru ON tbl_mapel_ajar.id_guru = tbl_guru.id_guru JOIN tbl_mapel ON tbl_mapel_ajar.id_mapel = tbl_mapel.id_mapel WHERE tbl_mapel_ajar.hari IS NULL AND tbl_mapel_ajar.id_kelas=$kelas ORDER BY tbl_mapel_ajar.jam_mulai ASC");
		return $query;
	}

	public function getMultipleWhere($table,$key1,$value1,$key2,$value2)
	{
		$this->db->where($key1, $value1); 
		$this->db->where($key2, $value2); 
		return $this->db->get($table);
	}

	public function getTripleWhere($table,$key1,$value1,$key2,$value2,$key3,$value3)
	{
		$this->db->where($key1, $value1); 
		$this->db->where($key2, $value2); 
		$this->db->where($key3, $value3); 
		return $this->db->get($table);
	}

	function updateData($table,$data,$dimana,$value)
	{
		$this->db->where($dimana,$value);
		$this->db->update($table,$data);
	}

	function updateMultipleWhere($table,$data,$dimana1,$value1,$dimana2,$value2)
	{
		$this->db->where($dimana1,$value1);
		$this->db->where($dimana2,$value2);
		$this->db->update($table,$data);
	}

	function updateTripleWhere($table,$data,$dimana1,$value1,$dimana2,$value2,$dimana3,$value3)
	{
		$this->db->where($dimana1,$value1);
		$this->db->where($dimana2,$value2);
		$this->db->where($dimana3,$value3);
		$this->db->update($table,$data);
	}

	function insertData($table,$data)
	{
		$this->db->insert($table,$data);
	}

	function getEditSiswa($id_siswa)
	{
		$query =  $this->db->query("SELECT * FROM tbl_siswa JOIN tbl_kelas ON tbl_siswa.kelas = tbl_kelas.id_kelas WHERE tbl_siswa.id_siswa = $id_siswa");

		return $query;
	}

	function getEditGuru($id)
	{
		return $this->db->query("SELECT * FROM tbl_guru where id_guru='".$id."'");	
	}

	public function getMapelRekap($id_kelas)
	{	
		$query = $this->db->query("SELECT DISTINCT tbl_mapel.nama_mapel,tbl_mapel.id_mapel,tbl_tugas.id_kelas FROM tbl_tugas JOIN tbl_mapel ON tbl_tugas.id_mapel = tbl_mapel.id_mapel WHERE tbl_tugas.id_kelas = '".$id_kelas."' ORDER BY tbl_mapel.nama_mapel");

	  	return $query;
	}

	function getRekap($id_siswa)
	{
		return $this->db->query("SELECT * FROM tbl_ikut_tugas JOIN tbl_tugas ON tbl_ikut_tugas.id_tugas = tbl_tugas.id_tugas JOIN tbl_mapel ON tbl_tugas.id_mapel = tbl_mapel.id_mapel WHERE tbl_ikut_tugas.id_siswa='".$id_siswa."' ");
	}

	public function getRekapNilai($id_siswa)
	{	
		$query = $this->db->query("SELECT * FROM tbl_ikut_tugas WHERE id_siswa='".$id_siswa."'");

		return $query->result();

	}

	function getTugas($nama)
	{
		return $this->db->query("SELECT * FROM tbl_tugas JOIN tbl_kelas ON tbl_tugas.id_kelas = tbl_kelas.id_kelas JOIN tbl_mapel ON tbl_tugas.id_mapel = tbl_mapel.id_mapel WHERE pembuat='$nama' ORDER BY tbl_tugas.id_tugas DESC");
	}

	function getTugasType($nama,$type)
	{
		return $this->db->query("SELECT * FROM tbl_tugas JOIN tbl_kelas ON tbl_tugas.id_kelas = tbl_kelas.id_kelas JOIN tbl_mapel ON tbl_tugas.id_mapel = tbl_mapel.id_mapel WHERE pembuat='$nama' AND tipe_tugas='$type' ORDER BY tbl_tugas.id_tugas DESC");
	}

	function getTugasKelas($kelas)
	{
		return $this->db->query("SELECT * FROM tbl_tugas JOIN tbl_kelas ON tbl_tugas.id_kelas = tbl_kelas.id_kelas JOIN tbl_mapel ON tbl_tugas.id_mapel = tbl_mapel.id_mapel WHERE tbl_tugas.id_kelas='".$kelas."'");
	}


	function getDetailTugas($id)
	{
		return $this->db->query("SELECT * FROM tbl_tugas JOIN tbl_kelas ON tbl_tugas.id_kelas = tbl_kelas.id_kelas JOIN tbl_mapel ON tbl_tugas.id_mapel = tbl_mapel.id_mapel WHERE tbl_tugas.id_tugas = '".$id."'");
	}


	function getMateri($nama)
	{
		return $this->db->query("SELECT * FROM tbl_materi JOIN tbl_kelas ON tbl_materi.id_kelas = tbl_kelas.id_kelas JOIN tbl_mapel ON tbl_materi.id_mapel = tbl_mapel.id_mapel WHERE pembuat='".$nama."'");
	}

	function getMateriKelas($kelas)
	{
		return $this->db->query("SELECT * FROM tbl_materi JOIN tbl_kelas ON tbl_materi.id_kelas = tbl_kelas.id_kelas JOIN tbl_mapel ON tbl_materi.id_mapel = tbl_mapel.id_mapel WHERE tbl_materi.id_kelas='".$kelas."' ");
	}

	function getMateriDetail($id)
	{
		return $this->db->query("SELECT * FROM tbl_materi JOIN tbl_kelas ON tbl_materi.id_kelas = tbl_kelas.id_kelas JOIN tbl_mapel ON tbl_materi.id_mapel = tbl_mapel.id_mapel WHERE id_materi='".$id."' ");
	}

	function getKomentar($id)
	{
		return $this->db->query("SELECT * FROM tbl_komentar JOIN tbl_materi ON tbl_komentar.id_materi = tbl_materi.id_materi  WHERE tbl_komentar.id_materi=$id ORDER BY tbl_komentar.tgl_posting DESC");
	}

	function deleteData($table,$where,$data)
	{
		$this->db->where($where, $data);
		$this->db->delete($table);
	}

	function deleteMultipleWhere($table,$where1,$data1,$where2,$data2)
	{
		$this->db->where($where1, $data1);
		$this->db->where($where2, $data2);
		$this->db->delete($table);
	}

	//model login user	
	public function getLoginData($usr,$psw)
	{
		$u = mysql_real_escape_string($usr);
		$p = mysql_real_escape_string($psw);
		
		$q_cek_login = $this->db->get_where('tbl_login', array('username' => $u, 'password' => $p));
		if(count($q_cek_login->result())>0)
		{
			foreach ($q_cek_login->result() as $qck)
			{
				if($qck->status=='Siswa')
				{
					$q_ambil_data = $this->db->get_where('tbl_siswa', array('username' => $u, 'password' => $p));
					foreach($q_ambil_data -> result() as $qad)
					{
						$sess_data['logged_in']		= 'yes';
						$sess_data['id_siswa'] 		= $qad->id_siswa;
						$sess_data['nis'] 			= $qad->nis;
						$sess_data['nama_siswa'] 	= $qad->nama_siswa;
						$sess_data['kelas'] 		= $qad->kelas;
						$sess_data['status'] 		= 'Siswa';						
						$this->session->set_userdata($sess_data);
					}
					header('location:'.base_url().'index.php/siswa');
				}
				else if($qck->status=='Guru')
				{
					$q_ambil_data = $this->db->get_where('tbl_guru', array('username' => $u, 'password' => $p));
					foreach($q_ambil_data -> result() as $qad)
					{
						$sess_data['logged_in']		= 'yes';
						$sess_data['id_guru'] 		= $qad->id_guru;
						$sess_data['nip'] 			= $qad->nip;
						$sess_data['nama_guru'] 	= $qad->nama_guru;
						$sess_data['username']	 	= $qad->username;
						$sess_data['status'] 		= 'Guru';
						$this->session->set_userdata($sess_data);
					}
					header('location:'.base_url().'index.php/guru');
				}
				else if($qck->status=='Admin')
				{
					$q_ambil_data = $this->db->get_where('tbl_admin', array('username' => $u, 'password' => $p));
					foreach($q_ambil_data -> result() as $qad)
					{
						$sess_data['logged_in']		= 'yes';
						$sess_data['id_admin'] 		= $qad->id_admin;
						$sess_data['nama'] 			= $qad->nama_admin;
						$sess_data['jk'] 			= $qad->jk;
						$sess_data['tempat_lahir']	= $qad->tempat_lahir;
						$sess_data['tanggal_lahir']	= $qad->tanggal_lahir;
						$sess_data['alamat'] 		= $qad->alamat;
						$sess_data['foto'] 			= $qad->foto;
						$sess_data['username']	 	= $qad->username;
						$sess_data['status'] 		= 'Admin';
						$this->session->set_userdata($sess_data);
					}
					header('location:'.base_url().'index.php/admin');
				}
				else if($qck->status=='Super Admin')
				{
					$q_ambil_data = $this->db->get_where('tbl_admin', array('username' => $u, 'password' => $p));
					foreach($q_ambil_data -> result() as $qad)
					{
						$sess_data['logged_in']		= 'yes';
						$sess_data['id_admin'] 		= $qad->id_admin;
						$sess_data['nama'] 			= $qad->nama_admin;
						$sess_data['jk'] 			= $qad->jk;
						$sess_data['tempat_lahir']	= $qad->tempat_lahir;
						$sess_data['tanggal_lahir']	= $qad->tanggal_lahir;
						$sess_data['alamat'] 		= $qad->alamat;
						$sess_data['foto'] 			= $qad->foto;
						$sess_data['username']	 	= $qad->username;
						$sess_data['status'] 		= 'Super Admin';
						$this->session->set_userdata($sess_data);
					}
					header('location:'.base_url().'index.php/admin');
				}
			}
		}
			else
			{
				header('location:'.base_url().'index.php/web');
				$this->session->set_flashdata('gagal', 'Akun tidak terdaftar');
			}
		}	

		//model daftar

		function cekData($table,$where,$value)
		{
			$q =  $this->db->query("select * from ".$table." where ".$where."='".$value."'");

			$cek = 0;
			if($q->num_rows()>0)
			{
				$cek = 1;	
			}
			return $cek;
		}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */