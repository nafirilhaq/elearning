<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Siswa extends CI_Controller {

	function __construct() {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        $this->db->query("SET time_zone='+7:00'");
        $waktu_sql = $this->db->query("SELECT NOW() AS waktu")->row_array();
        $this->waktu_sql = $waktu_sql['waktu'];
        $this->opsi = array("a","b","c","d","e");
	}

	public function index()
	{
		$cek  = $this->session->userdata('logged_in');
		$stts = $this->session->userdata('status');
		if(!empty($cek) && $stts=='Siswa')
		{
			$bc['status'] = $this->session->userdata('status');
			$bc['title'] = "Beranda";
			$id_siswa = $this->session->userdata('id_siswa');

			$sess = $this->web_app_model->getWhereData('tbl_siswa','id_siswa',$id_siswa);
			foreach ($sess->result() as $sess) {
				$bc['nama']			= $sess->nama_siswa;
				$bc['foto']			= $sess->foto;
				$bc['kelas']	 	= $sess->kelas;
			}

			$get_self = $this->web_app_model->getWhereData('tbl_login','id_siswa',$id_siswa);
			foreach ($get_self->result() as $get) {
				$id_login = $get->id_login;
			}
			$bc['hitung_pesan'] = $this->web_app_model->HitungPesanPengirim($id_login);
			$bc['menu'] = $this->load->view('siswa/menu',$bc,true);

			$bc['header'] = $this->load->view('siswa/header',$bc,true);
			$bc['footer'] = $this->load->view('siswa/footer',$bc,true);

			$bc['jadwal'] = $this->web_app_model->getJadwalKelas($bc['kelas']);

			$this->load->view('siswa/home',$bc);			
		}
		else
		{
			header('location:'.base_url().'index.php/web/logout');	
		}
	}

	public function profile()
	{
		$cek  = $this->session->userdata('logged_in');
		$stts = $this->session->userdata('status');
		if(!empty($cek) && $stts=='Siswa')
		{
			$bc['status'] = $this->session->userdata('status');
			$bc['title'] = "Profil";
			$id_siswa = $this->session->userdata('id_siswa');
			$id_kelas = $this->session->userdata('kelas');

			$sess = $this->web_app_model->getWhereData('tbl_siswa','id_siswa',$id_siswa);
			foreach ($sess->result() as $sess) {
				$bc['nama']			= $sess->nama_siswa;
				$bc['foto']			= $sess->foto;
				$bc['username'] 	= $sess->username;
			}
			
			$get_self = $this->web_app_model->getWhereData('tbl_login','id_siswa',$id_siswa);
			foreach ($get_self->result() as $get) {
				$id_login = $get->id_login;
			}
			$bc['hitung_pesan'] = $this->web_app_model->HitungPesanPengirim($id_login);
			$bc['menu'] = $this->load->view('siswa/menu',$bc,true);			
			$bc['header'] = $this->load->view('siswa/header',$bc,true);
			$bc['footer'] = $this->load->view('siswa/footer',$bc,true);
			
			$bc['data_siswa']	= $this->web_app_model->getEditSiswa($id_siswa);
			$bc['kelas'] = $this->web_app_model->getAllKelas();

			$bc['mapel'] = $this->web_app_model->getMapelRekap($id_kelas);
			
			$this->load->view('siswa/view_profile',$bc);			
		}
		else
		{
			header('location:'.base_url().'index.php/web');	
		}
	}

	public function update_profile()
	{
		$cek  = $this->session->userdata('logged_in');
		$stts = $this->session->userdata('status');
		if(!empty($cek) && $stts=='Siswa')
		{
			$id_siswa							= $this->input->post("id_siswa");
			$simpan_login['nama']				= $this->input->post("nama");
			$simpan_komentar['nama_siswa']		= $this->input->post("nama");
			$simpan_kelompok['nama_siswa']		= $this->input->post("nama");
			$simpan_profile['nama_siswa']		= $this->input->post("nama");
			$simpan_profile['jk']				= $this->input->post("jk");
			$simpan_profile['tahun_masuk']		= $this->input->post("tahun_masuk");
			$simpan_profile['kelas']			= $this->input->post("kelas");
			$simpan_profile['tempat_lahir']		= $this->input->post("tempat_lahir");
			$simpan_profile['tanggal_lahir']	= $this->input->post("tanggal_lahir");
			$simpan_profile['alamat']			= $this->input->post("alamat");
			$nama_lama							= $this->input->post("nama_lama");

			$nis_lama = $this->input->post("nis_lama");
			$nis_baru = $this->input->post("nis");

			if(strcmp($nip_lama,$nip_baru)==0){
				$this->web_app_model->updateData('tbl_siswa',$simpan_profile,'id_siswa',$id_siswa);
				$this->web_app_model->updateData('tbl_login',$simpan_login,'id_siswa',$id_siswa);
				$this->web_app_model->updateData('tbl_komentar',$simpan_komentar,'nama_siswa',$nama_lama);
				$this->web_app_model->updateData('tbl_kelompok',$simpan_kelompok,'nama_siswa',$nama_lama);

				$this->session->set_flashdata('berhasil', 'Berhasil disimpan!');
				redirect('siswa/profile/');

			}else if(strcmp($nis_lama,$nis_baru)!=0 && $this->web_app_model->cekData('tbl_siswa','nis',$nis_baru)==0){
				$simpan_profile['nis'] = $nis_baru;
				$this->web_app_model->updateData('tbl_siswa',$simpan_profile,'id_siswa',$id_siswa);
				$this->web_app_model->updateData('tbl_login',$simpan_login,'id_siswa',$id_siswa);

				$this->session->set_flashdata('berhasil', 'Berhasil disimpan!');
				redirect('siswa/profile/');
			}else if(strcmp($nis_lama,$nis_baru)!=0 && $this->web_app_model->cekData('tbl_guru','nis',$nis_baru)==1){
				$this->session->set_flashdata('gagal', 'Gagal, NIS telah terdaftar!');
				redirect('siswa/profile/');
			}
		}
		else
		{
			header('location:'.base_url().'index.php/web');	
		}
	}

	public function update_akun()
	{
		$cek  = $this->session->userdata('logged_in');
		$stts = $this->session->userdata('status');
		if(!empty($cek) && $stts=='Siswa')
		{
			$id_siswa						= $this->input->post("id_siswa");
			$user_baru						= $this->input->post("username");
			$user_lama						= $this->input->post("user_lama");		
			$password						= $this->input->post("password");
			$password2						= $this->input->post("password2");
			$nis							= $this->input->post("nis");

			if(strcmp($user_lama, $user_baru)==0){
				if(strcmp($password, $password2)==0){
					$simpan_profile['password']		= md5($password);
					$this->web_app_model->updateData('tbl_siswa',$simpan_profile,'id_siswa',$id_siswa);

					$idsiswa	=	$this->web_app_model->getSelectedData('tbl_siswa','id_siswa','nis',$nis)->result();

					foreach ($idsiswa as $id_gr) {
						$simpan_login["id_siswa"] = $id_gr->id_siswa;	
					}

					$this->web_app_model->updateData('tbl_login',$simpan_profile,'id_siswa',$id_siswa);

					$this->session->set_flashdata('berhasil', 'Berhasil disimpan!');

					redirect('siswa/profile#akun');

					
				} else if(strcmp($password, $password2)!=0){
					$this->session->set_flashdata('gagal', 'Password tidak sama!');

					redirect('siswa/profile#akun');
				}
			}else{
				if(strcmp($password, $password2)==0 && $this->web_app_model->cekData('tbl_login','username',$user_baru)==0){
					$simpan_profile['username']		= $user_baru;
					$simpan_profile['password']		= md5($password);
					$this->web_app_model->updateData('tbl_siswa',$simpan_profile,'id_siswa',$id_siswa);

					$idsiswa	=	$this->web_app_model->getSelectedData('tbl_siswa','id_siswa','nis',$nis)->result();

					foreach ($idsiswa as $id_gr) {
						$simpan_login["id_siswa"] = $id_gr->id_siswa;	
					}

					$this->web_app_model->updateData('tbl_login',$simpan_profile,'id_siswa',$id_siswa);

					$this->session->set_flashdata('berhasil', 'Berhasil disimpan!');

					redirect('siswa/profile#akun');

				} else if($this->web_app_model->cekData('tbl_login','username',$user_baru)==1){
					$this->session->set_flashdata('gagal', 'Nama pengguna sudah terdaftar!');

					redirect('siswa/profile#akun');
				} else if(strcmp($password, $password2)!=0){
					$this->session->set_flashdata('gagal', 'Password tidak sama!');

					redirect('siswa/profile#akun');
				}
			}


		}
		else
		{
			header('location:'.base_url().'index.php/web');	
		}
	}

	public function simpan_foto()
	{
		$cek  = $this->session->userdata('logged_in');
		$stts = $this->session->userdata('status');
		if(!empty($cek) && $stts=='Siswa')
		{
			$id_siswa = $this->uri->segment(3);

			$cek_foto = $this->web_app_model->getWhereData('tbl_siswa','id_siswa',$id_siswa);

			foreach ($cek_foto->result() as $cek) {

				if($cek->foto=='siswa.png' || $cek->foto=='siswi.png'){

					$path = './file/profile/siswa/';
					$config['upload_path']          = $path;
	                $config['allowed_types']        = 'jpg|jpeg|JPG|JPEG|png';
	                $config['file_name']           	= $cek->nis;
	                $config['max_size']           	= 100000000000;

	                $this->load->library('upload', $config);

	                if ( ! $this->upload->do_upload())
	                {
	                    $this->session->set_flashdata('foto_gagal', 'Gagal, format foto tidak sesuai!');

						redirect('siswa/profile/');
	                }
	                else
	                {
						$foto = $this->upload->data();
						//compress
						$config['image_library']	='gd2';
						$config['source_image']=$foto['full_path'];
		                $config['create_thumb']= FALSE;
		                $config['maintain_ratio']= TRUE;
		                $config['quality']= '100%';
		                $config['width']= "";
		                $config['height']= "";
		                $config['new_image']= './file/profile/siswa/';
		                $this->load->library('image_lib', $config);
		                $this->image_lib->resize();

		            	$simpan_foto = $config['file_name'].$foto['file_ext'];

						$this->db->query("UPDATE tbl_siswa SET foto = '$simpan_foto' WHERE id_siswa = '$id_siswa'");
						$this->db->query("UPDATE tbl_komentar SET foto = '$simpan_foto' WHERE id_siswa = '$id_siswa'");

						$this->session->set_flashdata('foto_berhasil', 'Berhasil disimpan!');
						redirect('siswa/profile/');
					}
				}else{
					$gambar_lama = $this->input->post('foto_lama');

					$path = './file/profile/siswa/';
					$config['upload_path']          = $path;
	                $config['allowed_types']        = 'jpg|jpeg|JPG|JPEG|png';
	                $config['file_name']           	= $cek->nis;

	                $this->load->library('upload', $config);

	                @unlink($path.$gambar_lama);

	                if ( ! $this->upload->do_upload())
	                {
	                    $this->session->set_flashdata('foto_gagal', 'Gagal, format foto tidak sesuai!');

						redirect('siswa/profile/');

	                }
	                else
	                {
						$foto = $this->upload->data();
						//compress
						$config['image_library']	='gd2';
						$config['source_image']=$foto['full_path'];
		                $config['create_thumb']= FALSE;
		                $config['maintain_ratio']= TRUE;
		                $config['quality']= '100%';
		                $config['width']= 160;
		                $config['height']= 160;
		                $config['new_image']= './file/profile/siswa/';
		                $this->load->library('image_lib', $config);
		                $this->image_lib->resize();

		            	$simpan_foto = $config['file_name'].$foto['file_ext'];

						$this->db->query("UPDATE tbl_siswa SET foto = '$simpan_foto' WHERE id_siswa = '$id_siswa'");
						$this->db->query("UPDATE tbl_komentar SET foto = '$simpan_foto' WHERE id_siswa = '$id_siswa'");

						$this->session->set_flashdata('foto_berhasil', 'Berhasil disimpan!');

						redirect('siswa/profile/');
					}
				}
			}
		}
		else
		{
			header('location:'.base_url().'index.php/web');	
		}
	}

	public function hapus_foto()
	{
		$cek  = $this->session->userdata('logged_in');
		$stts = $this->session->userdata('status');
		if(!empty($cek) && $stts=='Siswa')
		{
			$id_siswa = $this->uri->segment(3);
			$jk = $this->uri->segment(5);

			$cek_foto = $this->web_app_model->getWhereData('tbl_siswa','id_siswa',$id_siswa);

			foreach ($cek_foto->result() as $cek) {

				if($cek->foto=='siswa.png' || $cek->foto=='siswi.png'){

					redirect('siswa/profile/');
					
				}else{
					$path = './file/profile/siswa/';
					$gambar_lama = $this->uri->segment(4);

					$config['upload_path']          = $path;

					$this->load->library('upload', $config);

	                @unlink($path.$gambar_lama);

	                if($jk=='P'){
						$this->db->query("UPDATE tbl_siswa SET foto = 'siswi.png' WHERE id_siswa = '$id_siswa'");
						$this->db->query("UPDATE tbl_komentar SET foto = 'siswi.png' WHERE id_siswa = '$id_siswa'");
					} else if($jk=='L'){
						$this->db->query("UPDATE tbl_siswa SET foto = 'siswa.png' WHERE id_siswa = '$id_siswa'");
						$this->db->query("UPDATE tbl_komentar SET foto = 'siswa.png' WHERE id_siswa = '$id_siswa'");
					}

					$this->session->set_flashdata('foto_hapus', 'Foto berhasil dihapus!');
					redirect('siswa/profile/');
				}
			}
		}
		else
		{
			header('location:'.base_url().'index.php/web');	
		}
	}

	public function tampil_pesan()
	{
		$cek  = $this->session->userdata('logged_in');
		$stts = $this->session->userdata('status');
		if(!empty($cek) && $stts=='Siswa')
		{
			$bc['status'] = $this->session->userdata('status');
			$bc['title'] = "Pesan";
			$id_siswa = $this->session->userdata('id_siswa');

			$sess = $this->web_app_model->getWhereData('tbl_siswa','id_siswa',$id_siswa);
			foreach ($sess->result() as $sess) {
				$bc['nama']			= $sess->nama_siswa;
				$bc['foto']			= $sess->foto;
				$bc['username'] 	= $sess->username;
			}
			$get_self = $this->web_app_model->getWhereData('tbl_login','id_siswa',$id_siswa);
			foreach ($get_self->result() as $get) {
				$id_login = $get->id_login;
			}

			$bc['hitung_pesan'] = $this->web_app_model->HitungPesanPengirim($id_login);
			$bc['menu'] = $this->load->view('siswa/menu',$bc,true);

			$bc['header'] = $this->load->view('siswa/header',$bc,true);
			$bc['footer'] = $this->load->view('siswa/footer',$bc,true);


			if($this->uri->segment(3)=="masuk"){
				$bc['ambil_pesan'] = $this->web_app_model->getPesan($id_login);
				
				$this->load->view('siswa/view_pesan_masuk',$bc);		
			} else if($this->uri->segment(3)=="keluar"){
				$bc['ambil_pesan'] = $this->web_app_model->getPesanKeluar($id_login);

				$this->load->view('siswa/view_pesan_keluar',$bc);		
			}	
		}
		else
		{
			header('location:'.base_url().'index.php/web');	
		}
	}

	public function tampil_pesan_detail()
	{
		$cek  = $this->session->userdata('logged_in');
		$stts = $this->session->userdata('status');
		if(!empty($cek) && $stts=='Siswa')
		{
			$bc['status'] = $this->session->userdata('status');
			$bc['title'] = "Pesan Detail";
			$id_siswa = $this->session->userdata('id_siswa');

			$sess = $this->web_app_model->getWhereData('tbl_siswa','id_siswa',$id_siswa);
			foreach ($sess->result() as $sess) {
				$bc['nama']			= $sess->nama_siswa;
				$bc['foto']			= $sess->foto;
				$bc['username'] 	= $sess->username;
			}

			$get_self = $this->web_app_model->getWhereData('tbl_login','id_siswa',$id_siswa);
			foreach ($get_self->result() as $get) {
				$id_login = $get->id_login;
			}
			$bc['hitung_pesan'] = $this->web_app_model->HitungPesanPengirim($id_login);
			$bc['menu'] = $this->load->view('siswa/menu',$bc,true);

			$bc['header'] = $this->load->view('siswa/header',$bc,true);
			$bc['footer'] = $this->load->view('siswa/footer',$bc,true);

			$pengirim = $this->uri->segment(3);

			$bc['det_pesan'] = $this->web_app_model->getPesanDetail($id_login,$pengirim);

			$update['opened'] = 1;

			$this->web_app_model->updateTripleWhere('tbl_pesan',$update,'type_id',1,'owner_id',$id_login,'sender_receiver_id',$pengirim);
			
			$this->load->view('siswa/view_pesan_detail',$bc);			
		}
		else
		{
			header('location:'.base_url().'index.php/web');	
		}
	}

	public function kirim_pesan()
	{
		$cek  = $this->session->userdata('logged_in');
		$stts = $this->session->userdata('status');
		if(!empty($cek) && $stts=='Siswa')
		{
			if($this->uri->segment(3)=="balas"){

				$simpan_pengirim['content'] 			= $this->input->post('konten');
				$simpan_pengirim['sender_receiver_id'] 	= $this->uri->segment(4);
				$simpan_pengirim['tanggal'] 			= date('Y-m-d\TH:i:s');
				$simpan_pengirim['opened'] 				= 1;
				$simpan_pengirim['type_id'] 			= 2;
				$simpan_penerima['content'] 			= $this->input->post('konten');
				$simpan_penerima['owner_id']		 	= $this->uri->segment(4);
				$simpan_penerima['tanggal'] 			= date('Y-m-d\TH:i:s');
				$simpan_penerima['opened'] 				= 0;
				$simpan_penerima['type_id']				= 1;

				$get_self = $this->web_app_model->getWhereData('tbl_login','id_siswa',$bc['id_siswa']);
				foreach ($get_self->result() as $get) {
					$simpan_pengirim['owner_id'] 			= $get->id_login;
					$simpan_penerima['sender_receiver_id']  = $get->id_login;
				}

				$this->web_app_model->insertData('tbl_pesan',$simpan_pengirim);
				$this->web_app_model->insertData('tbl_pesan',$simpan_penerima);
				
				redirect('siswa/tampil_pesan_detail/'.$simpan_pengirim['sender_receiver_id'].'');		
			}else if($this->uri->segment(3)=="baru"){
				$bc['status'] = $this->session->userdata('status');
				$bc['title'] = "Kirim Pesan";
				$id_siswa = $this->session->userdata('id_siswa');

				$sess = $this->web_app_model->getWhereData('tbl_siswa','id_siswa',$id_siswa);
				foreach ($sess->result() as $sess) {
					$bc['nama']			= $sess->nama_siswa;
					$bc['foto']			= $sess->foto;
					$bc['username'] 	= $sess->username;
				}
				$get_self = $this->web_app_model->getWhereData('tbl_login','id_siswa',$id_siswa);
				foreach ($get_self->result() as $get) {
					$id_login = $get->id_login;
				}

				$bc['hitung_pesan'] = $this->web_app_model->HitungPesanPengirim($id_login);
				$bc['menu'] = $this->load->view('siswa/menu',$bc,true);

				$bc['header'] = $this->load->view('siswa/header',$bc,true);
				$bc['footer'] = $this->load->view('siswa/footer',$bc,true);

				$this->load->view('siswa/view_kirim_pesan',$bc);
			} else if($this->uri->segment(3)=="kirim"){
				
				$bc['status'] = $this->session->userdata('status');
				$bc['title'] = "Pesan";
				$id_siswa = $this->session->userdata('id_siswa');

				$sess = $this->web_app_model->getWhereData('tbl_siswa','id_siswa',$id_siswa);
				foreach ($sess->result() as $sess) {
					$bc['nama']			= $sess->nama_siswa;
					$bc['foto']			= $sess->foto;
					$bc['username'] 	= $sess->username;
				}

				$get_self = $this->web_app_model->getWhereData('tbl_login','id_siswa',$id_siswa);
				foreach ($get_self->result() as $get) {
					$id_login = $get->id_login;
				}

				$bc['hitung_pesan'] = $this->web_app_model->HitungPesanPengirim($id_login);
				$bc['menu'] = $this->load->view('siswa/menu',$bc,true);

				$bc['header'] = $this->load->view('siswa/header',$bc,true);
				$bc['footer'] = $this->load->view('siswa/footer',$bc,true);

				$username = $this->input->post('username');

				$ambil = $this->web_app_model->getData('tbl_login','id_login');
				foreach ($ambil->result_array() as $row) {
					$user = $row['username'];
					$pass = $row['password'];

					if(strcmp($bc['username'],$user)==0){
						if(strcmp($username,$user)==0){
							$this->session->set_flashdata('gagal', 'Tidak bisa mengirim pesan ke akun sendiri!');
							redirect('siswa/kirim_pesan/baru');
						}
					}else if(strcmp($username,$user)==0){
						$simpan_pengirim['content'] 			= $this->input->post('konten');
						$simpan_pengirim['sender_receiver_id'] 	= $this->input->post('id_login');
						$simpan_pengirim['tanggal'] 			= date('Y-m-d\TH:i:s');
						$simpan_pengirim['opened'] 				= 1;
						$simpan_pengirim['type_id'] 			= 2;
						$simpan_penerima['content'] 			= $this->input->post('konten');
						$simpan_penerima['owner_id']		 	= $this->input->post('id_login');
						$simpan_penerima['tanggal'] 			= date('Y-m-d\TH:i:s');
						$simpan_penerima['opened'] 				= 0;
						$simpan_penerima['type_id']				= 1;

						$get_self = $this->web_app_model->getWhereData('tbl_login','id_siswa',$bc['id_siswa']);
						foreach ($get_self->result() as $get) {
							$simpan_pengirim['owner_id'] 			= $get->id_login;
							$simpan_penerima['sender_receiver_id']  = $get->id_login;
						}

						$this->web_app_model->insertData('tbl_pesan',$simpan_pengirim);
						$this->web_app_model->insertData('tbl_pesan',$simpan_penerima);

						$this->session->set_flashdata('berhasil', 'Pesan berhasil terkirim');
						redirect('siswa/tampil_pesan/keluar');
					} 
				}
				$no_recipient = $this->web_app_model->cekData('tbl_login','username',$username);
				if($no_recipient==0){
					$this->session->set_flashdata('gagal', 'Nama pengirim tidak terdaftar!');
					redirect('siswa/kirim_pesan/baru');
				}
				
			} 
		}
		else
		{
			header('location:'.base_url().'index.php/web');	
		}
	}

	public function ambil_recipient()
	{
		if (isset($_GET['term'])) {
		  	$result = $this->web_app_model->getRecipient($_GET['term']);
		   	if (count($result) > 0) {
		    foreach ($result as $row)
		     	$arr_result[] = array(
					'label'				=> $row->nama,
					'id_login'			=> $row->id_login,
				);
		     	echo json_encode($arr_result);
		   	}
		}
	}

	public function hapus_pesan()
	{
		$cek  = $this->session->userdata('logged_in');
		$stts = $this->session->userdata('status');
		if(!empty($cek) && $stts=='Siswa')
		{
			$pesan 	= $this->uri->segment(4);

			$tipe = $this->uri->segment(3);

			if($tipe == "satu"){
				$id_pesan = $this->uri->segment(5);

				$this->web_app_model->deleteData('tbl_pesan','id',$id_pesan);
				redirect('siswa/tampil_pesan_detail/'.$pesan.'');		
			} else if($tipe == "masuk"){
				$get_self = $this->web_app_model->getWhereData('tbl_login','id_siswa',$bc['id_siswa']);
				foreach ($get_self->result() as $get) {
					$owner_id 			= $get->id_login;
				}
				$sender = $this->uri->segment(4);

				$this->web_app_model->deleteMultipleWhere('tbl_pesan','owner_id',$owner_id,'sender_receiver_id',$sender);
				redirect('siswa/tampil_pesan/masuk');
			} else if($tipe == "keluar"){
				$get_self = $this->web_app_model->getWhereData('tbl_login','id_siswa',$bc['id_siswa']);
				foreach ($get_self->result() as $get) {
					$owner_id 			= $get->id_login;
				}
				$sender = $this->uri->segment(4);

				$this->web_app_model->deleteMultipleWhere('tbl_pesan','owner_id',$owner_id,'sender_receiver_id',$sender);
				redirect('siswa/tampil_pesan/keluar');
			}
		}
		else
		{
			header('location:'.base_url().'index.php/web');	
		}
	}

	public function tampil_jadwal()
	{
		$cek  = $this->session->userdata('logged_in');
		$stts = $this->session->userdata('status');
		if(!empty($cek) && $stts=='Siswa')
		{
			$bc['status'] = $this->session->userdata('status');
			$bc['title'] = "Jadwal";
			$id_siswa = $this->session->userdata('id_siswa');

			$sess = $this->web_app_model->getWhereData('tbl_siswa','id_siswa',$id_siswa);
			foreach ($sess->result() as $sess) {
				$bc['nama']			= $sess->nama_siswa;
				$bc['foto']			= $sess->foto;
				$bc['kelas'] 		= $sess->kelas;
			}

			$get_self = $this->web_app_model->getWhereData('tbl_login','id_siswa',$id_siswa);
			foreach ($get_self->result() as $get) {
				$id_login = $get->id_login;
			}
			$bc['hitung_pesan'] = $this->web_app_model->HitungPesanPengirim($id_login);
			$bc['menu'] = $this->load->view('siswa/menu',$bc,true);

			$bc['header'] = $this->load->view('siswa/header',$bc,true);
			$bc['footer'] = $this->load->view('siswa/footer',$bc,true);
			
			$bc['hari'] = $this->web_app_model->getHari();
			$bc['jadwal'] = $this->web_app_model->getJadwalKelas($bc['kelas']);

			$this->load->view('siswa/view_jadwal',$bc);			
		}
		else
		{
			header('location:'.base_url().'index.php/web');	
		}
	}

	public function tampil_tugas()
	{
		$cek  = $this->session->userdata('logged_in');
		$stts = $this->session->userdata('status');
		if(!empty($cek) && $stts=='Siswa')
		{
			$bc['status'] = $this->session->userdata('status');
			$bc['title'] = "Tugas";
			$id_siswa = $this->session->userdata('id_siswa');

			$sess = $this->web_app_model->getWhereData('tbl_siswa','id_siswa',$id_siswa);
			foreach ($sess->result() as $sess) {
				$bc['nama']			= $sess->nama_siswa;
				$bc['foto']			= $sess->foto;
				$kelas	 		 	= $sess->kelas;
			}

			$get_self = $this->web_app_model->getWhereData('tbl_login','id_siswa',$id_siswa);
			foreach ($get_self->result() as $get) {
				$id_login = $get->id_login;
			}
			$bc['hitung_pesan'] = $this->web_app_model->HitungPesanPengirim($id_login);
			$bc['menu'] = $this->load->view('siswa/menu',$bc,true);

			$bc['header'] = $this->load->view('siswa/header',$bc,true);
			$bc['footer'] = $this->load->view('siswa/footer',$bc,true);
			
			/*$bc['tugas'] = $this->web_app_model->getTugasKelas($bc['kelas']);*/

			$bc['tugas'] = $this->db->query("SELECT 
									a.id_tugas, a.judul, a.pembuat, a.waktu_soal, a.tipe_tugas, a.tgl_mulai, a.terlambat,
									b.nama_mapel,d.nama_kelas, a.id_kelas,
									IF((c.status='Y' AND NOW() BETWEEN c.tgl_mulai AND a.terlambat),'Sedang Tes',
									IF(NOW() > a.terlambat,'Waktu Habis',
									IF(c.status='N' AND NOW() > c.tgl_mulai,'Selesai','Belum Ikut'))) status 
									FROM tbl_tugas a
									INNER JOIN tbl_mapel b ON a.id_mapel = b.id_mapel
									LEFT JOIN tbl_ikut_tugas c ON CONCAT($id_siswa,a.id_tugas) = CONCAT(c.id_siswa,c.id_tugas)
									JOIN tbl_kelas d ON a.id_kelas=d.id_kelas
									WHERE a.status = 'Aktif' AND a.id_kelas = $kelas ORDER BY a.id_tugas ASC");

			$this->load->view('siswa/view_tugas',$bc);			
		}
		else
		{
			header('location:'.base_url().'index.php/web');	
		}
	}

	public function mulai_tugas()
	{
		$cek  = $this->session->userdata('logged_in');
		$stts = $this->session->userdata('status');
		if(!empty($cek) && $stts=='Siswa')
		{
			$bc['nama'] = $this->session->userdata('nama_siswa');
			$bc['status'] = $this->session->userdata('status');
			$bc['kelas'] = $this->session->userdata('kelas');
			$bc['id_siswa'] = $this->session->userdata('id_siswa');
			
			$uri2 = $this->uri->segment(2);
			$uri3 = $this->uri->segment(3);
			$uri4 = $this->uri->segment(4);
			//var post from json
			$p = json_decode(file_get_contents('php://input'));
			if ($uri3 == "simpan_satu") {
				$p			= json_decode(file_get_contents('php://input'));
				
				$update_ 	= "";
				for ($i = 1; $i < $p->jml_soal; $i++) {
					$_tjawab 	= "opsi_".$i;
					$_tidsoal 	= "id_soal_".$i;
					$_ragu 		= "rg_".$i;
					$jawaban_ 	= empty($p->$_tjawab) ? "" : $p->$_tjawab;
					$update_	.= "".$p->$_tidsoal.":".$jawaban_.":".$p->$_ragu.",";
				}
				$update_		= substr($update_, 0, -1);
				$this->db->query("UPDATE tbl_ikut_tugas SET list_jawaban = '".$update_."' WHERE id_tugas = '$uri4' AND id_siswa = '".$bc['id_siswa']."'");
				//echo $this->db->last_query();

				$q_ret_urn 	= $this->db->query("SELECT list_jawaban FROM tbl_ikut_tugas WHERE id_tugas = '$uri4' AND id_siswa = '".$bc['id_siswa']."'");
				
				$d_ret_urn 	= $q_ret_urn->row_array();
				$ret_urn 	= explode(",", $d_ret_urn['list_jawaban']);
				$hasil 		= array();
				foreach ($ret_urn as $key => $value) {
					$pc_ret_urn = explode(":", $value);
					$idx 		= $pc_ret_urn[0];
					$val 		= $pc_ret_urn[1].'_'.$pc_ret_urn[2];
					$hasil[]= $val;
				}

				$d['data'] = $hasil;
				$d['status'] = "ok";

				j($d);
				exit;		

			} else if ($uri3 == "simpan_akhir") {
				$id_tugas = abs($uri4);

				$get_jawaban = $this->db->query("SELECT list_jawaban FROM tbl_ikut_tugas WHERE id_tugas = '$uri4' AND id_siswa = '".$bc['id_siswa']."'")->row_array();
				$pc_jawaban = explode(",", $get_jawaban['list_jawaban']);

				$jumlah_benar 	= 0;
				$jumlah_salah 	= 0;
				$jumlah_ragu  	= 0;
				$nilai_bobot 	= 0;
				$total_bobot	= 0;
				$jumlah_soal	= sizeof($pc_jawaban);

				for ($x = 0; $x < $jumlah_soal; $x++) {
					$pc_dt = explode(":", $pc_jawaban[$x]);
					$id_soal 	= $pc_dt[0];
					$kunci 	= $pc_dt[1];
					$ragu 		= $pc_dt[2];

					$cek_jwb 	= $this->db->query("SELECT bobot, kunci FROM tbl_soal_pilgan WHERE id_pilgan = '".$id_soal."'")->row();
					$total_bobot = $total_bobot + $cek_jwb->bobot;
					
					if (($cek_jwb->kunci == $kunci)) {
						//jika jawaban benar 
						$jumlah_benar++;
						$nilai_bobot = $nilai_bobot + $cek_jwb->bobot;
						$q_update_jwb = "UPDATE tbl_soal_pilgan SET jml_benar = jml_benar + 1 WHERE id_pilgan = '".$id_soal."'";
					} else {
						//jika jawaban salah
						$jumlah_salah++;
						$q_update_jwb = "UPDATE tbl_soal_pilgan SET jml_salah = jml_salah + 1 WHERE id_pilgan = '".$id_soal."'";
					}
					$this->db->query($q_update_jwb);
				}

				$nilai = ($jumlah_benar / $jumlah_soal)  * 100;
				$nilai_bobot = ($nilai_bobot / $total_bobot)  * 100;

				$kel = $this->web_app_model->cekKelompok($id_tugas,$bc['id_siswa']);
            	if($kel->num_rows()>0){
            		foreach ($kel->result() as $kel) {
            			$kelompok = $kel->kelompok;
            		}
            		$this->db->query("UPDATE tbl_ikut_tugas SET jml_benar = ".$jumlah_benar.", nilai = ".$nilai.", nilai_bobot = ".$nilai_bobot.", status = 'N', kelompok = '$kelompok' WHERE id_tugas = '$id_tugas' AND id_siswa = '".$bc['id_siswa']."'");
            	}else if($kel->num_rows()==0){
            		$kelompok = NULL;
            		$this->db->query("UPDATE tbl_ikut_tugas SET jml_benar = ".$jumlah_benar.", nilai = ".$nilai.", nilai_bobot = ".$nilai_bobot.", status = 'N' WHERE id_tugas = '$id_tugas' AND id_siswa = '".$bc['id_siswa']."'");
            	}

				

				$a['status'] = "ok";
				
				exit;
			} else {
				
				header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
				header("Cache-Control: post-check=0, pre-check=0", false);
				header("Pragma: no-cache");
				
				
				$cek_sdh_selesai= $this->db->query("SELECT id FROM tbl_ikut_tugas WHERE id_tugas = '$uri3' AND id_siswa = '".$bc['id_siswa']."' AND status = 'N'")->num_rows();
				
				//sekalian validasi waktu sudah berlalu...
				if ($cek_sdh_selesai < 1) {
					//ini jika ujian belum tercatat, belum ikut
					//ambil detil soal
					$cek_detil_tes = $this->db->query("SELECT * FROM tbl_tugas WHERE id_tugas = '$uri3'")->row();
					$q_cek_sdh_ujian= $this->db->query("SELECT id FROM tbl_ikut_tugas WHERE id_tugas = '$uri3' AND id_siswa = '".$bc['id_siswa']."'");
					$d_cek_sdh_ujian= $q_cek_sdh_ujian->row();
					$cek_sdh_ujian	= $q_cek_sdh_ujian->num_rows();

					if ($cek_sdh_ujian < 1)	{		
						$soal_urut_ok = array();
						$q_soal			= $this->db->query("SELECT * FROM tbl_soal_pilgan WHERE id_tugas = '$uri3'")->result();
						$i = 0;
						foreach ($q_soal as $s) {
							$soal_per = new stdClass();
							$soal_per->id_pilgan = $s->id_pilgan;
							$soal_per->pertanyaan = $s->pertanyaan;
							$soal_per->gambar = $s->gambar;
							$soal_per->opsi_a = $s->opsi_a;
							$soal_per->opsi_b = $s->opsi_b;
							$soal_per->opsi_c = $s->opsi_c;
							$soal_per->opsi_d = $s->opsi_d;
							$soal_per->opsi_e = $s->opsi_e;
							$soal_per->kunci = $s->kunci;
							$soal_urut_ok[$i] = $soal_per;
							$i++;
						}
						$soal_urut_ok = $soal_urut_ok;
						$list_id_soal	= "";
						$list_jw_soal 	= "";
						if (!empty($q_soal)) {
							foreach ($q_soal as $d) {
								$list_id_soal .= $d->id_pilgan.",";
								$list_jw_soal .= $d->id_pilgan."::N,";
							}
						}
						$list_id_soal = substr($list_id_soal, 0, -1);
						$list_jw_soal = substr($list_jw_soal, 0, -1);
						$waktu_selesai = tambah_jam_sql(($cek_detil_tes->waktu_soal)/60);
						$time_mulai		= date('Y-m-d H:i:s');
						$this->db->query("INSERT INTO tbl_ikut_tugas VALUES (null, '$uri3', '".$bc['id_siswa']."', '$list_id_soal', '$list_jw_soal', 0, 0, null, null, 0, '$time_mulai', ADDTIME('$time_mulai', '$waktu_selesai'), 'Y')");
						
						$detil_tes = $this->db->query("SELECT * FROM tbl_ikut_tugas WHERE id_tugas = '$uri3' AND id_siswa = '".$bc['id_siswa']."'")->row();

						$soal_urut_ok= $soal_urut_ok;
					} else {
						$q_ambil_soal 	= $this->db->query("SELECT * FROM tbl_ikut_tugas WHERE id_tugas = '$uri3' AND id_siswa = '".$bc['id_siswa']."'")->row();

						$urut_soal 		= explode(",", $q_ambil_soal->list_jawaban);
						$soal_urut_ok	= array();
						for ($i = 0; $i < sizeof($urut_soal); $i++) {
							$pc_urut_soal = explode(":",$urut_soal[$i]);
							$pc_urut_soal1 = empty($pc_urut_soal[1]) ? "''" : "'".$pc_urut_soal[1]."'";
							$ambil_soal = $this->db->query("SELECT *, $pc_urut_soal1 AS jawaban FROM tbl_soal_pilgan WHERE id_pilgan = '".$pc_urut_soal[0]."'")->row();
							$soal_urut_ok[] = $ambil_soal; 
						}
						
						$detil_tes = $q_ambil_soal;

						$soal_urut_ok = $soal_urut_ok;
					}

					$pc_list_jawaban = explode(",", $detil_tes->list_jawaban);

					$arr_jawab = array();
					foreach ($pc_list_jawaban as $v) {
					  $pc_v = explode(":", $v);
					  $idx = $pc_v[0];
					  $val = $pc_v[1];
					  $rg = $pc_v[2];

					  $arr_jawab[$idx] = array("j"=>$val,"r"=>$rg);
					}

					$html = '';
					$no = 1;
					if (!empty($soal_urut_ok)) {
					    foreach ($soal_urut_ok as $d) { 
					        $tampil_media = tampil_media("", 'auto','auto');
					        $vrg = $arr_jawab[$d->id_pilgan]["r"] == "" ? "N" : $arr_jawab[$d->id_pilgan]["r"];

					        $html .= '<input type="hidden" name="id_soal_'.$no.'" value="'.$d->id_pilgan.'">';
					        $html .= '<input type="hidden" name="rg_'.$no.'" id="rg_'.$no.'" value="'.$vrg.'">';
					        $html .= '<div class="step" id="widget_'.$no.'">';

					        $html .= $d->pertanyaan.'<br>'.$tampil_media.'<div class="funkyradio">';

					        for ($j = 0; $j < 5; $j++) {
					            $opsi = "opsi_".$this->opsi[$j];

					            $checked = $arr_jawab[$d->id_pilgan]["j"] == strtoupper($this->opsi[$j]) ? "checked" : "";

					            $pc_pilihan_opsi = explode("#####", $d->$opsi);

					            $tampil_media_opsi = (is_file('./upload/gambar_soal/'.$pc_pilihan_opsi[0]) || $pc_pilihan_opsi[0] != "") ? tampil_media('./upload/gambar_opsi/'.$pc_pilihan_opsi[0],'auto','auto') : '';
						    
						    	$pilihan_opsi = empty($pc_pilihan_opsi[0]) ? "-" : $pc_pilihan_opsi[0];
						    
					            $html .= '<div class="funkyradio-success" onclick="return simpan_sementara();">
					                <input type="radio" id="opsi_'.strtoupper($this->opsi[$j]).'_'.$d->id_pilgan.'" name="opsi_'.$no.'" value="'.strtoupper($this->opsi[$j]).'" '.$checked.'> <label for="opsi_'.strtoupper($this->opsi[$j]).'_'.$d->id_pilgan.'"><div class="huruf_opsi">'.$this->opsi[$j].'</div> <p>'.$pilihan_opsi.'</p><p>'.$tampil_media_opsi.'</p></label></div>';
					        }
					        $html .= '</div></div>';
					        $no++;
					    }
					}

					$a['jam_mulai'] = $detil_tes->tgl_mulai;
					$a['jam_selesai'] = $detil_tes->tgl_selesai;
					$a['id_tugas'] = $cek_detil_tes->id_tugas;
					$a['no'] = $no;
					$a['html'] = $html;

					$this->load->view('siswa/start_tugas', $a);
				} else {
					redirect('siswa/konfirmasi_tugas/PG/'.$uri4);
				}
			}
		}
		else
		{
			header('location:'.base_url().'index.php/web');	
		}
	}

	public function mulai_tugas_upload()
	{
		$cek  = $this->session->userdata('logged_in');
		$stts = $this->session->userdata('status');
		if(!empty($cek) && $stts=='Siswa')
		{
			$bc['status'] = $this->session->userdata('status');
			$bc['title'] = "Mulai Tugas";
			$id_siswa = $this->session->userdata('id_siswa');

			$sess = $this->web_app_model->getWhereData('tbl_siswa','id_siswa',$id_siswa);
			foreach ($sess->result() as $sess) {
				$bc['id_siswa']		= $sess->id_siswa;
				$bc['nama']			= $sess->nama_siswa;
				$bc['foto']			= $sess->foto;
				$bc['username'] 	= $sess->username;
			}

			$get_self = $this->web_app_model->getWhereData('tbl_login','id_siswa',$id_siswa);
			foreach ($get_self->result() as $get) {
				$id_login = $get->id_login;
			}
			$bc['hitung_pesan'] = $this->web_app_model->HitungPesanPengirim($id_login);
			$bc['menu'] = $this->load->view('siswa/menu',$bc,true);

			$bc['header'] = $this->load->view('siswa/header',$bc,true);
			$bc['footer'] = $this->load->view('siswa/footer',$bc,true);
			$bc['uri3'] = $this->uri->segment(3);
			
			$uri2 = $this->uri->segment(2);
			$uri3 = $this->uri->segment(3);
			$uri4 = $this->uri->segment(4);
			//var post from json
			$p = json_decode(file_get_contents('php://input'));
			
			if ($uri3 == "simpan_akhir") {
				$id_tugas = abs($uri4);

				$config['upload_path']          = './file/tugas/';
                $config['allowed_types']        = 'doc|zip|rar|txt|docx|xls|xlsx|pdf|tar|gz|jpg|jpeg|JPG|JPEG|png|ppt|pptx';
                $config['max_size']             = '100000000000000';
                $config['file_name']           	= $id_tugas.'-'.$bc['id_siswa'].'-'.$bc['nama'];

                $this->load->library('upload', $config);

                if ( ! $this->upload->do_upload())
                {
                    echo 'gagal';
                }
                else
                {
                	$tugas 			= $this->upload->data();
                	$simpan_tugas	= $config['file_name'].$tugas['file_ext']; 

                	$kel = $this->web_app_model->cekKelompok($id_tugas,$bc['id_siswa']);
                	if(!empty($kel)){
                		foreach ($kel->result() as $kel) {
                			$kelompok = $kel->kelompok;
                		}
                	}else{
                		$kelompok = NULL;
                	}

					$this->db->query("UPDATE tbl_ikut_tugas SET status = 'N', list_jawaban = '$simpan_tugas', kelompok = '$kelompok' WHERE id_tugas = '$id_tugas' AND id_siswa = '".$bc['id_siswa']."'");
					$a['status'] = "ok";
                    
                }
				
				header('location:'.base_url().'siswa/konfirmasi_tugas/Upload/'.$id_tugas.'');	
			} else if ($uri3 == "token") {
				header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
				header("Cache-Control: post-check=0, pre-check=0", false);
				header("Pragma: no-cache");
				
				$a['du'] = $this->db->query("SELECT a.id, a.tgl_mulai, a.terlambat, 
											a.token, a.nama_ujian, a.jumlah_soal, a.waktu,
											b.nama nmguru, c.nama nmmapel,
											(case
												when (now() < a.tgl_mulai) then 0
												when (now() >= a.tgl_mulai and now() <= a.terlambat) then 1
												else 2
											end) statuse
											FROM tr_guru_tes a 
											INNER JOIN m_guru b ON a.id_guru = b.id
											INNER JOIN m_mapel c ON a.id_mapel = c.id 
											WHERE a.id = '$uri4'")->row_array();

				$a['dp'] = $this->db->query("SELECT * FROM m_siswa WHERE id = '".$a['sess_konid']."'")->row_array();
				//$q_status = $this->db->query();

				if (!empty($a['du']) || !empty($a['dp'])) {
					$tgl_selesai = $a['du']['tgl_mulai'];
				    //$tgl_selesai2 = strtotime($tgl_selesai);
				    //$tgl_baru = date('F j, Y H:i:s', $tgl_selesai);

				    //$tgl_terlambat = strtotime("+".$a['du']['terlambat']." minutes", $tgl_selesai2);	
					$tgl_terlambat_baru = $a['du']['terlambat'];

					$a['tgl_mulai'] = $tgl_selesai;
					$a['terlambat'] = $tgl_terlambat_baru;

					$this->load->view('siswa/konfirmasi_tugas', $a);
				} else {
					redirect('siswa/ikuti_ujian');
				}
			} else {
				
				header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
				header("Cache-Control: post-check=0, pre-check=0", false);
				header("Pragma: no-cache");
				
				
				$cek_sdh_selesai= $this->db->query("SELECT id FROM tbl_ikut_tugas WHERE id_tugas = '$uri3' AND id_siswa = '".$bc['id_siswa']."' AND status = 'N'")->num_rows();
				
				//sekalian validasi waktu sudah berlalu...
				if ($cek_sdh_selesai < 1) {
					//ini jika ujian belum tercatat, belum ikut
					//ambil detil soal
					$cek_detil_tes = $this->db->query("SELECT * FROM tbl_tugas WHERE id_tugas = '$uri3'")->row();
					$q_cek_sdh_ujian= $this->db->query("SELECT id FROM tbl_ikut_tugas WHERE id_tugas = '$uri3' AND id_siswa = '".$bc['id_siswa']."'");
					$d_cek_sdh_ujian= $q_cek_sdh_ujian->row();
					$cek_sdh_ujian	= $q_cek_sdh_ujian->num_rows();

					if ($cek_sdh_ujian < 1)	{		
						$soal_urut_ok = array();
						$q_soal			= $this->db->query("SELECT * FROM tbl_soal_upload WHERE id_tugas = '$uri3'")->result();
						
						$waktu_selesai = tambah_jam_sql(($cek_detil_tes->waktu_soal)/60);
						$time_mulai		= date('Y-m-d H:i:s');
						$this->db->query("INSERT INTO tbl_ikut_tugas VALUES (null, '$uri3', '".$bc['id_siswa']."', null, null, 0, null, '-', '-', 0, '$time_mulai', ADDTIME('$time_mulai', '$waktu_selesai'), 'Y')");
						
						$detil_tes = $this->db->query("SELECT * FROM tbl_ikut_tugas WHERE id_tugas = '$uri3' AND id_siswa = '".$bc['id_siswa']."'")->row();

					} else {
						$q_ambil_soal 	= $this->db->query("SELECT * FROM tbl_ikut_tugas WHERE id_tugas = '$uri3' AND id_siswa = '".$bc['id_siswa']."'")->row();

						$urut_soal 		= explode(",", $q_ambil_soal->list_jawaban);
						$soal_urut_ok	= array();
						for ($i = 0; $i < sizeof($urut_soal); $i++) {
							$pc_urut_soal = explode(":",$urut_soal[$i]);
							$pc_urut_soal1 = empty($pc_urut_soal[1]) ? "''" : "'".$pc_urut_soal[1]."'";
							$ambil_soal = $this->db->query("SELECT *, $pc_urut_soal1 AS jawaban FROM tbl_soal_pilgan WHERE id_pilgan = '".$pc_urut_soal[0]."'")->row();
							$soal_urut_ok[] = $ambil_soal; 
						}
						
						$detil_tes = $q_ambil_soal;

						$soal_urut_ok = $soal_urut_ok;
					}

 					$this->load->view('siswa/start_tugas_upload', $bc);
				} else {
					redirect('siswa/konfirmasi_tugas_upload/'.$uri4);
				}
			}
		}
		else
		{
			header('location:'.base_url().'index.php/web');	
		}
	}

	public function konfirmasi_tugas()
	{
		$cek  = $this->session->userdata('logged_in');
		$stts = $this->session->userdata('status');
		if(!empty($cek) && $stts=='Siswa')
		{
			$bc['status'] = $this->session->userdata('status');
			$bc['title'] = "Konfirmasi Tugas";
			$id_siswa = $this->session->userdata('id_siswa');

			$sess = $this->web_app_model->getWhereData('tbl_siswa','id_siswa',$id_siswa);
			foreach ($sess->result() as $sess) {
				$bc['id_siswa']		= $sess->id_siswa;
				$bc['nama']			= $sess->nama_siswa;
				$bc['foto']			= $sess->foto;
				$bc['username'] 	= $sess->username;
				$bc['nis'] 			= $sess->nis;
			}

			$get_self = $this->web_app_model->getWhereData('tbl_login','id_siswa',$id_siswa);
			foreach ($get_self->result() as $get) {
				$id_login = $get->id_login;
			}
			$bc['hitung_pesan'] = $this->web_app_model->HitungPesanPengirim($id_login);
			$bc['menu'] = $this->load->view('siswa/menu',$bc,true);

			$bc['header'] = $this->load->view('siswa/header',$bc,true);
			$bc['footer'] = $this->load->view('siswa/footer',$bc,true);
			
			$tipe_tgs = $this->uri->segment(3);
			$id_tgs = $this->uri->segment(4);

			if($tipe_tgs == 'PG'){

				$bc['du'] = $this->db->query("SELECT a.id_tugas, a.tgl_mulai, a.terlambat, 
											a.judul, a.pembuat, a.waktu_soal,
											b.nama_mapel,
											(case
												when (now() < a.tgl_mulai) then 0
												when (now() >= a.tgl_mulai and now() <= a.terlambat) then 1
												else 2
											end) statuse
											FROM tbl_tugas a 
											INNER JOIN tbl_mapel b ON a.id_mapel = b.id_mapel 
											WHERE a.id_tugas = '$id_tgs'")->row_array();

				if (!empty($bc['du'])) {
					$tgl_selesai = $bc['du']['tgl_mulai'];
				    //$tgl_selesai2 = strtotime($tgl_selesai);
				    //$tgl_baru = date('F j, Y H:i:s', $tgl_selesai);

				    //$tgl_terlambat = strtotime("+".$a['du']['terlambat']." minutes", $tgl_selesai2);	
					$tgl_terlambat_baru = $bc['du']['terlambat'];

					$bc['tgl_mulai'] = $tgl_selesai;
					$bc['terlambat'] = $tgl_terlambat_baru;

					$q_nilai = $this->db->query("SELECT nilai, tgl_selesai, tgl_mulai FROM tbl_ikut_tugas WHERE id_tugas = '$id_tgs' AND id_siswa = '".$bc['id_siswa']."' AND status = 'N'")->row();

					$bc['nuldata'] = $this->db->query("SELECT * FROM tbl_ikut_tugas WHERE id_tugas = '$id_tgs' AND id_siswa = '".$bc['id_siswa']."'")->row();

					if (!empty($q_nilai)) {
						$bc['data'] = "<div class='alert alert-danger'>Anda telah selesai mengikuti ujian ini pada : <strong style='font-size: 16px'>".tjs($q_nilai->tgl_mulai, "l")."</strong>, dan mendapatkan nilai : <strong style='font-size: 16px'>".$q_nilai->nilai."</strong></div>";
					}

					$ambil_kelompok = $this->web_app_model->getMultipleWhere('tbl_ikut_tugas','id_tugas',$id_tgs,'id_siswa',$bc['id_siswa']);

					foreach ($ambil_kelompok->result() as $ambil) {
						$kelompok2 = $ambil->kelompok;
					
						if($kelompok2!=NULL){
							$all_kelompok = $this->web_app_model->getMultipleWhere('tbl_ikut_tugas','id_tugas',$id_tgs,'kelompok',$kelompok2);

							$hitung = "";
							$nilai_kelompok = "";
							foreach ($all_kelompok->result_array() as $all) {
								$nilai_individu = $all['nilai'];
								$nilai_kelompok = $nilai_kelompok + $nilai_individu;
								$hitung++;
							}
							$kel['nilai_kelompok'] = $nilai_kelompok/$hitung;

							$this->web_app_model->updateMultipleWhere('tbl_ikut_tugas',$kel,'id_tugas',$id_tgs,'kelompok',$kelompok2);
						}
					}

					$kelompok	= $this->web_app_model->getAnggotaKelompok2($id_tgs,$bc['id_siswa']);
					if($kelompok!=NULL){
						$bc['kelompok'] = $kelompok;
						$bc['status']	= 1;
						$this->load->view('siswa/konfirmasi_tugas_pg',$bc);	
					}else{
						$bc['status']	= 0;
						$this->load->view('siswa/konfirmasi_tugas_pg',$bc);	
					}
				} else {
					redirect('siswa/tampil_tugas');
				}
			} else if($tipe_tgs == 'Upload'){

				$bc['du'] = $this->db->query("SELECT a.id_tugas, a.tgl_mulai, a.terlambat, 
											a.judul, a.pembuat, a.waktu_soal,
											b.nama_mapel,
											(case
												when (now() < a.tgl_mulai) then 0
												when (now() >= a.tgl_mulai and now() <= a.terlambat) then 1
												else 2
											end) statuse
											FROM tbl_tugas a 
											INNER JOIN tbl_mapel b ON a.id_mapel = b.id_mapel 
											WHERE a.id_tugas = '$id_tgs'")->row_array();

				if (!empty($bc['du'])) {
					$tgl_selesai = $bc['du']['tgl_mulai'];
				    //$tgl_selesai2 = strtotime($tgl_selesai);
				    //$tgl_baru = date('F j, Y H:i:s', $tgl_selesai);

				    //$tgl_terlambat = strtotime("+".$a['du']['terlambat']." minutes", $tgl_selesai2);	
					$tgl_terlambat_baru = $bc['du']['terlambat'];

					$bc['tgl_mulai'] = $tgl_selesai;
					$bc['terlambat'] = $tgl_terlambat_baru;

					$q_nilai = $this->db->query("SELECT nilai, tgl_selesai, tgl_mulai FROM tbl_ikut_tugas WHERE id_tugas = '$id_tgs' AND id_siswa = '".$bc['id_siswa']."' AND status = 'N'")->row();

					$bc['nuldata'] = $this->db->query("SELECT * FROM tbl_ikut_tugas WHERE id_tugas = '$id_tgs' AND id_siswa = '".$bc['id_siswa']."'")->row();
					
					if (!empty($q_nilai)) {
						$bc['data'] = "<div class='alert alert-danger'>Anda telah selesai mengikuti ujian ini pada : <strong style='font-size: 16px'>".tjs($q_nilai->tgl_mulai, "l")."</strong></div>";
					}

					$ambil_jwb = $this->web_app_model->getMultipleWhere('tbl_ikut_tugas','id_tugas',$id_tgs,'id_siswa',$bc['id_siswa']);

					foreach ($ambil_jwb->result() as $jwbn) {
						$bc['jawaban'] = $jwbn->list_jawaban;
					}

					$kelompok	= $this->web_app_model->getAnggotaKelompok2($id_tgs,$bc['id_siswa']);
					if($kelompok!=NULL){
						$bc['kelompok'] = $kelompok;
						$bc['status']	= 1;
						$this->load->view('siswa/konfirmasi_tugas_upload',$bc);	
					}else{
						$bc['status']	= 0;
						$this->load->view('siswa/konfirmasi_tugas_upload',$bc);	
					}

				} else {
					redirect('siswa/tampil_tugas');
				}
			}

		}
		else
		{
			header('location:'.base_url().'index.php/web');	
		}
	}

	public function sudah_selesai_ujian() {
		$cek  = $this->session->userdata('logged_in');
		$stts = $this->session->userdata('status');
		if(!empty($cek) && $stts=='Siswa')
		{
			$bc['status'] = $this->session->userdata('status');
			$bc['title'] = "Tugas";
			$id_siswa = $this->session->userdata('id_siswa');

			$sess = $this->web_app_model->getWhereData('tbl_siswa','id_siswa',$id_siswa);
			foreach ($sess->result() as $sess) {
				$bc['nama']			= $sess->nama_siswa;
				$bc['foto']			= $sess->foto;
				$bc['username'] 	= $sess->username;
			}

			$get_self = $this->web_app_model->getWhereData('tbl_login','id_siswa',$id_siswa);
			foreach ($get_self->result() as $get) {
				$id_login = $get->id_login;
			}
			$bc['hitung_pesan'] = $this->web_app_model->HitungPesanPengirim($id_login);
			$bc['menu'] = $this->load->view('siswa/menu',$bc,true);

			$bc['header'] = $this->load->view('siswa/header',$bc,true);
			$bc['footer'] = $this->load->view('siswa/footer',$bc,true);

			//var def uri segment
			$uri2 = $this->uri->segment(2);
			$uri3 = $this->uri->segment(3);
			$uri4 = $this->uri->segment(4);
			
			$q_nilai = $this->db->query("SELECT nilai, tgl_selesai FROM tbl_ikut_tugas WHERE id_tugas = '$uri3' AND id_siswa = '".$bc['id_siswa']."' AND status = 'N'")->row();
			if (empty($q_nilai)) {
				redirect('siswa/mulai_tugas/'.$uri3);
			} else {
				$a['data'] = "<div class='alert alert-danger'>Anda telah selesai mengikuti ujian ini pada : <strong style='font-size: 16px'>".tjs($q_nilai->tgl_selesai, "l")."</strong>, dan mendapatkan nilai : <strong style='font-size: 16px'>".$q_nilai->nilai."</strong></div>";
			}
			$this->load->view('siswa/selesai_ujian', $a);
			}
	}

	public function mulai_upload()
	{
		$cek  = $this->session->userdata('logged_in');
		$stts = $this->session->userdata('status');
		if(!empty($cek) && $stts=='Siswa')
		{
			$bc['status'] = $this->session->userdata('status');
			$bc['title'] = "Mulai Tugas";
			$id_siswa = $this->session->userdata('id_siswa');

			$sess = $this->web_app_model->getWhereData('tbl_siswa','id_siswa',$id_siswa);
			foreach ($sess->result() as $sess) {
				$bc['nama']			= $sess->nama_siswa;
				$bc['foto']			= $sess->foto;
				$bc['username'] 	= $sess->username;
			}

			$get_self = $this->web_app_model->getWhereData('tbl_login','id_siswa',$id_siswa);
			foreach ($get_self->result() as $get) {
				$id_login = $get->id_login;
			}
			$bc['hitung_pesan'] = $this->web_app_model->HitungPesanPengirim($id_login);
			$bc['menu'] = $this->load->view('siswa/menu',$bc,true);

			$bc['header'] = $this->load->view('siswa/header',$bc,true);
			$bc['footer'] = $this->load->view('siswa/footer',$bc,true);

			$this->load->view('siswa/start_tugas_upload');			
		}
		else
		{
			header('location:'.base_url().'index.php/web');	
		}
	}

	public function simpan_upload()
	{
		$cek  = $this->session->userdata('logged_in');
		$stts = $this->session->userdata('status');
		if(!empty($cek) && $stts=='Siswa')
		{
			$uri3 = $this->uri->segment(3);

			if($uri3=='tertulis'){

				$simpan_materi["judul"]			= $this->input->post("judul");
				$simpan_materi["konten"]		= $this->input->post("konten");
				$simpan_materi["id_kelas"]		= $this->input->post("kelas");
				$simpan_materi["id_mapel"]		= $this->input->post("mapel");
				$simpan_materi["tgl_buat"]		= $this->input->post("tgl_buat");
				$simpan_materi["pembuat"]		= $this->session->userdata('nama_guru');
				$simpan_materi["tipe_materi"]	= "Tertulis";
				$simpan_materi["publish"]		= 0;

				$this->web_app_model->insertData('tbl_materi',$simpan_materi);

				header('location:'.base_url().'index.php/guru/tampil_materi');
			}else if($uri3=='file'){
				$config['upload_path']          = './file/materi/';
                $config['allowed_types']        = 'doc|zip|rar|txt|docx|xls|xlsx|pdf|tar|gz|jpg|jpeg|JPG|JPEG|png|ppt|pptx';
                $config['max_size']             = '10000';
                $config['max_width']            = '5000';
                $config['max_height']           = '5000';

                $this->load->library('upload', $config);

                if ( ! $this->upload->do_upload())
                {
                    echo 'gagal';
                }
                else
                {
                	$materi = $this->upload->data();
                	$simpan_materi["file"] 			= $materi['file_name']; 
                	$simpan_materi["judul"]			= $this->input->post("judul");
					$simpan_materi["id_kelas"]		= $this->input->post("kelas");
					$simpan_materi["id_mapel"]		= $this->input->post("mapel");
					$simpan_materi["tgl_buat"]		= $this->input->post("tgl_buat");
					$simpan_materi["pembuat"]		= $this->session->userdata('nama_guru');
					$simpan_materi["tipe_materi"]	= "File";
					$simpan_materi["konten"]		= NULL;
					$simpan_materi["publish"]		= 0;

					$this->web_app_model->insertData('tbl_materi',$simpan_materi);

					header('location:'.base_url().'index.php/guru/tampil_materi');
                    
                }

			}
		}
		else
		{
			header('location:'.base_url().'index.php/web');	
		}
	}

	public function tampil_materi()
	{
		$cek  = $this->session->userdata('logged_in');
		$stts = $this->session->userdata('status');
		if(!empty($cek) && $stts=='Siswa')
		{
			$bc['status'] = $this->session->userdata('status');
			$bc['title'] = "Materi";
			$id_siswa = $this->session->userdata('id_siswa');

			$sess = $this->web_app_model->getWhereData('tbl_siswa','id_siswa',$id_siswa);
			foreach ($sess->result() as $sess) {
				$bc['nama']			= $sess->nama_siswa;
				$bc['foto']			= $sess->foto;
				$bc['kelas'] 		= $sess->kelas;
			}

			$get_self = $this->web_app_model->getWhereData('tbl_login','id_siswa',$id_siswa);
			foreach ($get_self->result() as $get) {
				$id_login = $get->id_login;
			}
			$bc['hitung_pesan'] = $this->web_app_model->HitungPesanPengirim($id_login);
			$bc['menu'] = $this->load->view('siswa/menu',$bc,true);

			$bc['header'] = $this->load->view('siswa/header',$bc,true);
			$bc['footer'] = $this->load->view('siswa/footer',$bc,true);

			$bc['materi'] = $this->web_app_model->getMateriKelas($bc['kelas']);
			
			$this->load->view('siswa/view_materi',$bc);			
		}
		else
		{
			header('location:'.base_url().'index.php/web');	
		}
	}

	public function detail_materi()
	{
		$cek  = $this->session->userdata('logged_in');
		$stts = $this->session->userdata('status');
		if(!empty($cek) && $stts=='Siswa')
		{
			$bc['status'] = $this->session->userdata('status');
			$bc['title'] = "Detail Materi";
			$id_siswa = $this->session->userdata('id_siswa');

			$sess = $this->web_app_model->getWhereData('tbl_siswa','id_siswa',$id_siswa);
			foreach ($sess->result() as $sess) {
				$bc['nama']			= $sess->nama_siswa;
				$bc['foto']			= $sess->foto;
				$bc['username'] 	= $sess->username;
			}

			$get_self = $this->web_app_model->getWhereData('tbl_login','id_siswa',$id_siswa);
			foreach ($get_self->result() as $get) {
				$id_login = $get->id_login;
			}
			$bc['hitung_pesan'] = $this->web_app_model->HitungPesanPengirim($id_login);
			$bc['menu'] = $this->load->view('siswa/menu',$bc,true);

			$bc['header'] = $this->load->view('siswa/header',$bc,true);
			$bc['footer'] = $this->load->view('siswa/footer',$bc,true);

			$bc['tipe_materi']	= $this->uri->segment(3);
			$bc['id_materi'] 	= $this->uri->segment(4);

			if($bc['tipe_materi']=='file'){
				$bc['materi'] 	= $this->web_app_model->getMateriDetail($bc['id_materi']);
				$bc['komentar'] = $this->web_app_model->getKomentar($bc['id_materi']);
				
				$this->load->view('siswa/view_materi_file_detail',$bc);
			}else if($bc['tipe_materi']=='tertulis'){
				$bc['materi'] = $this->web_app_model->getMateriDetail($bc['id_materi']);
				$bc['komentar2'] = $this->web_app_model->getKomentar($bc['id_materi']);
				
				$this->load->view('siswa/view_materi_tertulis_detail',$bc);
			}
		}
		else
		{
			header('location:'.base_url().'index.php/web');	
		}
	}

	public function tambah_komentar()
	{
		$cek  = $this->session->userdata('logged_in');
		$stts = $this->session->userdata('status');
		if(!empty($cek) && $stts=='Siswa')
		{
			$id_siswa = $this->session->userdata('id_siswa');

			$sess = $this->web_app_model->getWhereData('tbl_siswa','id_siswa',$id_siswa);
			foreach ($sess->result() as $sess) {
				$simpan_komentar['nama_siswa']		= $sess->nama_siswa;
				$simpan_komentar['foto']			= $sess->foto;
			}
			$simpan_komentar['id_siswa'] 	= $this->session->userdata('id_siswa');
			$simpan_komentar['id_materi'] 	= $this->input->post('id_materi');
			$simpan_komentar['tgl_posting']	= $this->input->post('tgl_posting');
			$simpan_komentar['komentar']	= $this->input->post('komentar');

			$tipe_materi = $this->input->post('tipe_materi');

			$this->web_app_model->insertData('tbl_komentar',$simpan_komentar);

			if($tipe_materi == "file"){
				redirect('siswa/detail_materi/file/'.$simpan_komentar['id_materi'].'');
			}else if($tipe_materi == "tertulis"){
				redirect('siswa/detail_materi/tertulis/'.$simpan_komentar['id_materi'].'');
			}
		}
		else
		{
			header('location:'.base_url().'index.php/web');	
		}
	}

	public function download_materi(){		
		$uri3 	= 	$this->uri->segment(3);
	
		force_download('file/materi/'.$uri3, NULL); 
	}

	public function download_tugas(){		
		$uri3 	= str_replace('%20', '_', $this->uri->segment(3));

		force_download('file/tugas/'.$uri3, NULL); 
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */