<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Guru extends CI_Controller {

	function __construct() {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        $this->db->query("SET time_zone='+7:00'");
        $waktu_sql = $this->db->query("SELECT NOW() AS waktu")->row_array();
        $this->waktu_sql = $waktu_sql['waktu'];
        $this->load->model('web_app_model');
	}

	public function index()
	{
		$cek  = $this->session->userdata('logged_in');
		$stts = $this->session->userdata('status');
		if(!empty($cek) && $stts=='Guru')
		{
			$bc['status'] = $this->session->userdata('status');
			$bc['title'] = "Beranda";
			$bc['id_guru'] = $this->session->userdata('id_guru');

			$sess = $this->web_app_model->getWhereData('tbl_guru','id_guru',$bc['id_guru']);
			foreach ($sess->result() as $sess) {
				$bc['nama']			= $sess->nama_guru;
				$bc['foto']			= $sess->foto;
				$bc['username'] 	= $sess->username;
			}

			$get_self = $this->web_app_model->getWhereData('tbl_login','id_guru',$bc['id_guru']);
			foreach ($get_self->result() as $get) {
				$id_login = $get->id_login;
			}
			$bc['hitung_pesan'] = $this->web_app_model->HitungPesanPengirim($id_login);
			$bc['menu'] = $this->load->view('guru/menu',$bc,true);

			$bc['header'] = $this->load->view('guru/header',$bc,true);
			$bc['footer'] = $this->load->view('guru/footer',$bc,true);
			
			$this->load->view('guru/home',$bc);			
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
		if(!empty($cek) && $stts=='Guru')
		{
			$bc['nama'] = $this->session->userdata('nama');
			$bc['status'] = $this->session->userdata('status');
			$bc['id_guru'] = $this->session->userdata('id_guru');
			$bc['title'] = "Profil";

			$data = $this->web_app_model->getWhereData('tbl_guru','id_guru',$bc['id_guru']);
			foreach ($data->result_array() as $data) {
				$bc['nama'] = $data['nama_guru'];
				$bc['foto']	= $data['foto'];
			}
			
			$get_self = $this->web_app_model->getWhereData('tbl_login','id_guru',$bc['id_guru']);
			foreach ($get_self->result() as $get) {
				$id_login = $get->id_login;
			}
			$bc['hitung_pesan'] = $this->web_app_model->HitungPesanPengirim($id_login);
			$bc['menu'] = $this->load->view('guru/menu',$bc,true);

			$bc['header'] = $this->load->view('guru/header',$bc,true);
			$bc['footer'] = $this->load->view('guru/footer',$bc,true);

			$bc['guru'] = $this->web_app_model->getWhereData('tbl_guru','id_guru',$bc['id_guru']);
			
			$this->load->view('guru/view_profil',$bc);			
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
		if(!empty($cek) && $stts=='Guru')
		{
			$id_guru							= $this->input->post("id_guru");
			$simpan_login['nama']				= $this->input->post("nama");
			$simpan_komentar['nama_guru']		= $this->input->post("nama");
			$simpan_materi['pembuat']			= $this->input->post("nama");
			$simpan_tugas['pembuat']			= $this->input->post("nama");
			$simpan_profile['nama_guru']		= $this->input->post("nama");
			$simpan_profile['jk']				= $this->input->post("jk");
			$simpan_profile['tempat_lahir']		= $this->input->post("tempat_lahir");
			$simpan_profile['tanggal_lahir']	= $this->input->post("tanggal_lahir");
			$simpan_profile['alamat']			= $this->input->post("alamat");
			$nama_lama							= $this->input->post("nama_lama");

			$nip_lama = $this->input->post("nip_lama");
			$nip_baru = $this->input->post("nip");

			if(strcmp($nip_lama,$nip_baru)==0){
				$this->web_app_model->updateData('tbl_guru',$simpan_profile,'id_guru',$id_guru);
				$this->web_app_model->updateData('tbl_login',$simpan_login,'id_guru',$id_guru);
				$this->web_app_model->updateData('tbl_komentar',$simpan_komentar,'nama_guru',$nama_lama);
				$this->web_app_model->updateData('tbl_materi',$simpan_materi,'pembuat',$nama_lama);
				$this->web_app_model->updateData('tbl_tugas',$simpan_tugas,'pembuat',$nama_lama);

				$this->session->set_flashdata('berhasil', 'Berhasil disimpan!');
				redirect('guru/profile/');

			}else if(strcmp($nip_lama,$nip_baru)!=0 && $this->web_app_model->cekData('tbl_guru','nip',$nip_baru)==0){
				$simpan_profile['nip'] = $nip_baru;
				$this->web_app_model->updateData('tbl_guru',$simpan_profile,'id_guru',$id_guru);
				$this->web_app_model->updateData('tbl_login',$simpan_login,'id_guru',$id_guru);

				$this->session->set_flashdata('berhasil', 'Berhasil disimpan!');
				redirect('guru/profile/');
			}else if(strcmp($nip_lama,$nip_baru)!=0 && $this->web_app_model->cekData('tbl_guru','nip',$nip_baru)==1){
				$this->session->set_flashdata('gagal', 'Gagal, NIP telah terdaftar!');
				redirect('guru/profile/');
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
		if(!empty($cek) && $stts=='Guru')
		{
			$id_guru						= $this->input->post("id_guru");
			$user_baru						= $this->input->post("username");
			$user_lama						= $this->input->post("user_lama");		
			$password						= $this->input->post("password");
			$password2						= $this->input->post("password2");
			$nip							= $this->input->post("nip");

			if(strcmp($user_lama, $user_baru)==0){
				if(strcmp($password, $password2)==0){
					$simpan_profile['password']		= md5($password);
					$this->web_app_model->updateData('tbl_guru',$simpan_profile,'id_guru',$id_guru);

					$idguru	=	$this->web_app_model->getSelectedData('tbl_guru','id_guru','nip',$nip)->result();

					foreach ($idguru as $id_gr) {
						$simpan_login["id_guru"] = $id_gr->id_guru;	
					}

					$this->web_app_model->updateData('tbl_login',$simpan_profile,'id_guru',$id_guru);

					$this->session->set_flashdata('berhasil', 'Berhasil disimpan!');

					redirect('guru/profile#akun');

					
				} else if(strcmp($password, $password2)!=0){
					$this->session->set_flashdata('gagal', 'Password tidak sama!');

					redirect('guru/profile#akun');
				}
			}else{
				if(strcmp($password, $password2)==0 && $this->web_app_model->cekData('tbl_login','username',$user_baru)==0){
					$simpan_profile['username']		= $user_baru;
					$simpan_profile['password']		= md5($password);
					$this->web_app_model->updateData('tbl_guru',$simpan_profile,'id_guru',$id_guru);

					$idguru	=	$this->web_app_model->getSelectedData('tbl_guru','id_guru','nip',$nip)->result();

					foreach ($idguru as $id_gr) {
						$simpan_login["id_guru"] = $id_gr->id_guru;	
					}

					$this->web_app_model->updateData('tbl_login',$simpan_profile,'id_guru',$id_guru);

					$this->session->set_flashdata('berhasil', 'Berhasil disimpan!');

					redirect('guru/profile#akun');

				} else if($this->web_app_model->cekData('tbl_login','username',$user_baru)==1){
					$this->session->set_flashdata('gagal', 'Nama pengguna sudah terdaftar!');

					redirect('guru/profile/#akun');
				} else if(strcmp($password, $password2)!=0){
					$this->session->set_flashdata('gagal', 'Password tidak sama!');

					redirect('guru/profile#akun');
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
		if(!empty($cek) && $stts=='Guru')
		{
			$id_guru = $this->uri->segment(3);

			$cek_foto = $this->web_app_model->getWhereData('tbl_guru','id_guru',$id_guru);

			foreach ($cek_foto->result() as $cek) {

				if($cek->foto=='gurul.png' || $cek->foto=='gurup.png'){

					$path = './file/profile/guru/';
					$config['upload_path']          = $path;
	                $config['allowed_types']        = 'jpg|jpeg|JPG|JPEG|png';
	                $config['file_name']           	= $cek->nip;
	                $config['max_size']           	= 100000000000;

	                $this->load->library('upload', $config);

	                if ( ! $this->upload->do_upload())
	                {
	                    $this->session->set_flashdata('foto_gagal', 'Gagal, format foto tidak sesuai!');

						redirect('guru/profile/');
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
		                $config['new_image']= './file/profile/guru/';
		                $this->load->library('image_lib', $config);
		                $this->image_lib->resize();

		            	$simpan_foto = $config['file_name'].$foto['file_ext'];

						$this->db->query("UPDATE tbl_guru SET foto = '$simpan_foto' WHERE id_guru = '$id_guru'");
						$this->db->query("UPDATE tbl_komentar SET foto = '$simpan_foto' WHERE id_guru = '$id_guru'");

						$this->session->set_flashdata('foto_berhasil', 'Berhasil disimpan!');
						redirect('guru/profile/');
					}
				}else{
					$gambar_lama = $this->input->post('foto_lama');

					$path = './file/profile/guru/';
					$config['upload_path']          = $path;
	                $config['allowed_types']        = 'jpg|jpeg|JPG|JPEG|png';
	                $config['file_name']           	= $cek->nip;

	                $this->load->library('upload', $config);

	                @unlink($path.$gambar_lama);

	                if ( ! $this->upload->do_upload())
	                {
	                    $this->session->set_flashdata('foto_gagal', 'Gagal, format foto tidak sesuai!');

						redirect('guru/profile/');

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
		                $config['new_image']= './file/profile/guru/';
		                $this->load->library('image_lib', $config);
		                $this->image_lib->resize();

		            	$simpan_foto = $config['file_name'].$foto['file_ext'];

						$this->db->query("UPDATE tbl_guru SET foto = '$simpan_foto' WHERE id_guru = '$id_guru'");
						$this->db->query("UPDATE tbl_komentar SET foto = '$simpan_foto' WHERE id_guru = '$id_guru'");

						$this->session->set_flashdata('foto_berhasil', 'Berhasil disimpan!');

						redirect('guru/profile/');
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
		if(!empty($cek) && $stts=='Guru')
		{
			$id_guru = $this->uri->segment(3);
			$jk = $this->uri->segment(5);

			$cek_foto = $this->web_app_model->getWhereData('tbl_guru','id_guru',$id_guru);

			foreach ($cek_foto->result() as $cek) {

				if($cek->foto=='gurul.png' || $cek->foto=='gurup.png'){

					redirect('guru/profile/');
					
				}else{
					$path = './file/profile/guru/';
					$gambar_lama = $this->uri->segment(4);

					$config['upload_path']          = $path;

					$this->load->library('upload', $config);

	                @unlink($path.$gambar_lama);

	                if($jk=='P'){
						$this->db->query("UPDATE tbl_guru SET foto = 'gurup.png' WHERE id_guru = '$id_guru'");
						$this->db->query("UPDATE tbl_komentar SET foto = 'gurup.png' WHERE id_guru = '$id_guru'");
					} else if($jk=='L'){
						$this->db->query("UPDATE tbl_guru SET foto = 'gurul.png' WHERE id_guru = '$id_guru'");
						$this->db->query("UPDATE tbl_komentar SET foto = 'gurul.png' WHERE id_guru = '$id_guru'");
					}

					$this->session->set_flashdata('foto_hapus', 'Foto berhasil dihapus!');
					redirect('guru/profile/');
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
		if(!empty($cek) && $stts=='Guru')
		{
			$bc['status'] = $this->session->userdata('status');
			$bc['title'] = "Pesan";
			$bc['id_guru'] = $this->session->userdata('id_guru');

			$sess = $this->web_app_model->getWhereData('tbl_guru','id_guru',$bc['id_guru']);
			foreach ($sess->result() as $sess) {
				$bc['nama']			= $sess->nama_guru;
				$bc['foto']			= $sess->foto;
				$bc['username'] 	= $sess->username;
			}

			$get_self = $this->web_app_model->getWhereData('tbl_login','id_guru',$bc['id_guru']);
			foreach ($get_self->result() as $get) {
				$id_login = $get->id_login;
			}
			
			$bc['header'] = $this->load->view('guru/header',$bc,true);
			$bc['footer'] = $this->load->view('guru/footer',$bc,true);

			if($this->uri->segment(3)=="masuk"){
				$bc['ambil_pesan'] = $this->web_app_model->getPesan($id_login);
				$bc['hitung_pesan'] = $this->web_app_model->HitungPesanPengirim($id_login);
				$bc['menu'] = $this->load->view('guru/menu',$bc,true);
				$bc['hitung_pesan_detail'] = $this->web_app_model->HitungPesanPengirim($id_login);
				
				$this->load->view('guru/view_pesan_masuk',$bc);		
			} else if($this->uri->segment(3)=="keluar"){
				$bc['ambil_pesan'] = $this->web_app_model->getPesanKeluar($id_login);
				$bc['hitung_pesan'] = $this->web_app_model->HitungPesanPengirim($id_login);
				$bc['menu'] = $this->load->view('guru/menu',$bc,true);	

				$this->load->view('guru/view_pesan_keluar',$bc);		
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
		if(!empty($cek) && $stts=='Guru')
		{
			$bc['status'] = $this->session->userdata('status');
			$bc['title'] = "Pesan";
			$bc['id_guru'] = $this->session->userdata('id_guru');

			$sess = $this->web_app_model->getWhereData('tbl_guru','id_guru',$bc['id_guru']);
			foreach ($sess->result() as $sess) {
				$bc['nama']			= $sess->nama_guru;
				$bc['foto']			= $sess->foto;
				$bc['username'] 	= $sess->username;
			}

			$get_self = $this->web_app_model->getWhereData('tbl_login','id_guru',$bc['id_guru']);
			foreach ($get_self->result() as $get) {
				$id_login = $get->id_login;
			}
			$bc['hitung_pesan'] = $this->web_app_model->HitungPesanPengirim($id_login);
			$bc['menu'] = $this->load->view('guru/menu',$bc,true);

			$bc['header'] = $this->load->view('guru/header',$bc,true);
			$bc['footer'] = $this->load->view('guru/footer',$bc,true);

			$pengirim = $this->uri->segment(3);

			$bc['det_pesan'] = $this->web_app_model->getPesanDetail($id_login,$pengirim);

			$update['opened'] = 1;

			$this->web_app_model->updateTripleWhere('tbl_pesan',$update,'type_id',1,'owner_id',$id_login,'sender_receiver_id',$pengirim);
			
			$this->load->view('guru/view_pesan_detail',$bc);			
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
		if(!empty($cek) && $stts=='Guru')
		{
			$bc['id_guru'] = $this->session->userdata('id_guru');

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

				$get_self = $this->web_app_model->getWhereData('tbl_login','id_guru',$bc['id_guru']);
				foreach ($get_self->result() as $get) {
					$simpan_pengirim['owner_id'] 			= $get->id_login;
					$simpan_penerima['sender_receiver_id']  = $get->id_login;
				}

				$this->web_app_model->insertData('tbl_pesan',$simpan_pengirim);
				$this->web_app_model->insertData('tbl_pesan',$simpan_penerima);
				
				redirect('guru/tampil_pesan_detail/'.$simpan_pengirim['sender_receiver_id'].'');		
			}else if($this->uri->segment(3)=="baru"){
				$bc['status'] = $this->session->userdata('status');
				$bc['title'] = "Kirim Pesan";
				$bc['id_guru'] = $this->session->userdata('id_guru');

				$sess = $this->web_app_model->getWhereData('tbl_guru','id_guru',$bc['id_guru']);
				foreach ($sess->result() as $sess) {
					$bc['nama']			= $sess->nama_guru;
					$bc['foto']			= $sess->foto;
					$bc['username'] 	= $sess->username;
				}

				$get_self = $this->web_app_model->getWhereData('tbl_login','id_guru',$bc['id_guru']);
				foreach ($get_self->result() as $get) {
					$id_login = $get->id_login;
				}
				$bc['hitung_pesan'] = $this->web_app_model->HitungPesanPengirim($id_login);
				$bc['menu'] = $this->load->view('guru/menu',$bc,true);

				$bc['header'] = $this->load->view('guru/header',$bc,true);
				$bc['footer'] = $this->load->view('guru/footer',$bc,true);

				$this->load->view('guru/view_kirim_pesan',$bc);
			} else if($this->uri->segment(3)=="kirim"){
				$bc['status'] = $this->session->userdata('status');
				$bc['title'] = "Kirim Pesan";
				$bc['id_guru'] = $this->session->userdata('id_guru');

				$sess = $this->web_app_model->getWhereData('tbl_guru','id_guru',$bc['id_guru']);
				foreach ($sess->result() as $sess) {
					$bc['nama']			= $sess->nama_guru;
					$bc['foto']			= $sess->foto;
					$bc['username'] 	= $sess->username;
				}

				$get_self = $this->web_app_model->getWhereData('tbl_login','id_guru',$bc['id_guru']);
				foreach ($get_self->result() as $get) {
					$id_login = $get->id_login;
				}
				$bc['hitung_pesan'] = $this->web_app_model->HitungPesanPengirim($id_login);
				$bc['menu'] = $this->load->view('guru/menu',$bc,true);

				$bc['header'] = $this->load->view('guru/header',$bc,true);
				$bc['footer'] = $this->load->view('guru/footer',$bc,true);

				$username = $this->input->post('username');

				$ambil = $this->web_app_model->getData('tbl_login','id_login');
				foreach ($ambil->result_array() as $row) {
					$user = $row['nama'];

					if(strcmp($bc['username'],$user)==0){
						if(strcmp($username,$user)==0){
							$this->session->set_flashdata('gagal', 'Tidak bisa mengirim pesan ke akun sendiri!');
							redirect('guru/kirim_pesan/baru');
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

						$get_self = $this->web_app_model->getWhereData('tbl_login','id_guru',$bc['id_guru']);
						foreach ($get_self->result() as $get) {
							$simpan_pengirim['owner_id'] 			= $get->id_login;
							$simpan_penerima['sender_receiver_id']  = $get->id_login;
						}

						$this->web_app_model->insertData('tbl_pesan',$simpan_pengirim);
						$this->web_app_model->insertData('tbl_pesan',$simpan_penerima);

						$this->session->set_flashdata('berhasil', 'Pesan berhasil terkirim');
						redirect('guru/tampil_pesan/keluar');
					} 
				}
				$no_recipient = $this->web_app_model->cekData('tbl_login','username',$username);
				if($no_recipient==0){
					$this->session->set_flashdata('gagal', 'Nama pengirim tidak terdaftar!');
					redirect('guru/kirim_pesan/baru');
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
					'label'			=> $row->nama,
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
		if(!empty($cek) && $stts=='Guru')
		{
			$bc['id_guru'] = $this->session->userdata('id_guru');
			$pesan 	= $this->uri->segment(4);

			$tipe = $this->uri->segment(3);

			if($tipe == "satu"){
				$id_pesan = $this->uri->segment(5);

				$this->web_app_model->deleteData('tbl_pesan','id',$id_pesan);
				redirect('guru/tampil_pesan_detail/'.$pesan.'');		
			} else if($tipe == "masuk"){
				$get_self = $this->web_app_model->getWhereData('tbl_login','id_guru',$bc['id_guru']);
				foreach ($get_self->result() as $get) {
					$owner_id 			= $get->id_login;
				}
				$sender = $this->uri->segment(4);

				$this->web_app_model->deleteMultipleWhere('tbl_pesan','owner_id',$owner_id,'sender_receiver_id',$sender);
				redirect('guru/tampil_pesan/masuk');
			} else if($tipe == "keluar"){
				$get_self = $this->web_app_model->getWhereData('tbl_login','id_guru',$bc['id_guru']);
				foreach ($get_self->result() as $get) {
					$owner_id 			= $get->id_login;
				}
				$sender = $this->uri->segment(4);

				$this->web_app_model->deleteMultipleWhere('tbl_pesan','owner_id',$owner_id,'sender_receiver_id',$sender);
				redirect('guru/tampil_pesan/keluar');
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
		if(!empty($cek) && $stts=='Guru')
		{
			$bc['status'] = $this->session->userdata('status');
			$bc['title'] = "Jadwal";
			$bc['id_guru'] = $this->session->userdata('id_guru');

			$sess = $this->web_app_model->getWhereData('tbl_guru','id_guru',$bc['id_guru']);
			foreach ($sess->result() as $sess) {
				$bc['nama']			= $sess->nama_guru;
				$bc['foto']			= $sess->foto;
				$bc['username'] 	= $sess->username;
			}

			$get_self = $this->web_app_model->getWhereData('tbl_login','id_guru',$bc['id_guru']);
			foreach ($get_self->result() as $get) {
				$id_login = $get->id_login;
			}
			$bc['hitung_pesan'] = $this->web_app_model->HitungPesanPengirim($id_login);
			$bc['menu'] = $this->load->view('guru/menu',$bc,true);

			$bc['header'] = $this->load->view('guru/header',$bc,true);
			$bc['footer'] = $this->load->view('guru/footer',$bc,true);
			
			$bc['hari'] = $this->web_app_model->getHari();
			$bc['jadwal'] = $this->web_app_model->getJadwal($bc['id_guru']);

			$this->load->view('guru/view_jadwal_mengajar',$bc);			
		}
		else
		{
			header('location:'.base_url().'index.php/web');	
		}
	}

	public function tambah_jadwal_ajar()
	{
		$cek  = $this->session->userdata('logged_in');
		$stts = $this->session->userdata('status');
		if(!empty($cek) && $stts=='Guru')
		{
			$bc['status'] = $this->session->userdata('status');
			$bc['title'] = "Tambah Jadwal";
			$bc['id_guru'] = $this->session->userdata('id_guru');

			$sess = $this->web_app_model->getWhereData('tbl_guru','id_guru',$bc['id_guru']);
			foreach ($sess->result() as $sess) {
				$bc['nama']			= $sess->nama_guru;
				$bc['foto']			= $sess->foto;
				$bc['username'] 	= $sess->username;
			}

			$get_self = $this->web_app_model->getWhereData('tbl_login','id_guru',$bc['id_guru']);
			foreach ($get_self->result() as $get) {
				$id_login = $get->id_login;
			}
			$bc['hitung_pesan'] = $this->web_app_model->HitungPesanPengirim($id_login);
			$bc['menu'] = $this->load->view('guru/menu',$bc,true);

			$bc['header'] = $this->load->view('guru/header',$bc,true);
			$bc['footer'] = $this->load->view('guru/footer',$bc,true);

			$bc['tugas'] = $this->web_app_model->getTugas($bc['nama']);

			$bc['kelas'] = $this->web_app_model->getAllKelasChild('tbl_kelas');
			$bc['mapel'] = $this->web_app_model->getAllDataMapel('tbl_mapel');

			$this->load->view('guru/view_tambah_jadwal',$bc);			
		}
		else
		{
			header('location:'.base_url().'index.php/web');	
		}
	}

	public function simpan_jadwal()
	{
		$cek  = $this->session->userdata('logged_in');
		$stts = $this->session->userdata('status');
		if(!empty($cek) && $stts=='Guru')
		{
			$simpan_jadwal["hari_id"]		= $this->input->post("hari_id");
			$simpan_jadwal["id_kelas"]		= $this->input->post("kelas");
			$simpan_kelas["id_kelas"]		= $this->input->post("kelas");
			$simpan_jadwal["id_mapel"]		= $this->input->post("mapel");
			$simpan_kelas["id_mapel"]		= $this->input->post("mapel");
			$simpan_jadwal["jam_mulai"]		= $this->input->post("jam_mulai");
			$simpan_jadwal["jam_selesai"]	= $this->input->post("jam_selesai");
			$simpan_jadwal["id_guru"]		= $this->session->userdata('id_guru');
			$simpan_kelas["id_guru"]		= $this->session->userdata('id_guru');

			$this->web_app_model->insertData('tbl_mapel_ajar',$simpan_jadwal);
			$this->web_app_model->insertData('tbl_kelas_ajar',$simpan_kelas);

			$this->session->set_flashdata('berhasil', 'Berhasil disimpan!');
			header('location:'.base_url().'index.php/guru/tampil_jadwal');
		}
		else
		{
			header('location:'.base_url().'index.php/web');	
		}
	}

	public function edit_jadwal()
	{
		$cek  = $this->session->userdata('logged_in');
		$stts = $this->session->userdata('status');
		if(!empty($cek) && $stts=='Guru')
		{
			$bc['status'] = $this->session->userdata('status');
			$bc['title'] = "Sunting Jadwal";
			$bc['id_guru'] = $this->session->userdata('id_guru');

			$sess = $this->web_app_model->getWhereData('tbl_guru','id_guru',$bc['id_guru']);
			foreach ($sess->result() as $sess) {
				$bc['nama']			= $sess->nama_guru;
				$bc['foto']			= $sess->foto;
				$bc['username'] 	= $sess->username;
			}

			$get_self = $this->web_app_model->getWhereData('tbl_login','id_guru',$bc['id_guru']);
			foreach ($get_self->result() as $get) {
				$id_login = $get->id_login;
			}
			$bc['hitung_pesan'] = $this->web_app_model->HitungPesanPengirim($id_login);
			$bc['menu'] = $this->load->view('guru/menu',$bc,true);

			$bc['header'] = $this->load->view('guru/header',$bc,true);
			$bc['footer'] = $this->load->view('guru/footer',$bc,true);

			$bc['kelas'] = $this->web_app_model->getAllKelasChild('tbl_kelas');
			$bc['mapel'] = $this->web_app_model->getAllDataMapel('tbl_mapel');

			$id = $this->uri->segment(3);
			$bc['edit_jadwal'] = $this->web_app_model->getWhereData('tbl_mapel_ajar','id',$id);
			
			$this->load->view('guru/view_edit_jadwal',$bc);			
		}
		else
		{
			header('location:'.base_url().'index.php/web');	
		}
	}

	public function update_jadwal()
	{
		$cek  = $this->session->userdata('logged_in');
		$stts = $this->session->userdata('status');
		if(!empty($cek) && $stts=='Guru')
		{
			$simpan_jadwal["id"]			= $this->input->post("id");
			$simpan_jadwal["id_kelas"]		= $this->input->post("kelas");
			$simpan_kelas["id_kelas"]		= $this->input->post("kelas");
			$simpan_jadwal["id_mapel"]		= $this->input->post("mapel");
			$simpan_kelas["id_mapel"]		= $this->input->post("mapel");
			$simpan_jadwal["jam_mulai"]		= $this->input->post("jam_mulai");
			$simpan_jadwal["jam_selesai"]	= $this->input->post("jam_selesai");
			$simpan_kelas["id_guru"]		= $this->session->userdata('id_guru');
			$kelas_lama						= $this->input->post("kelas_lama");
			$mapel_lama						= $this->input->post("mapel_lama");

			$this->web_app_model->updateData('tbl_mapel_ajar',$simpan_jadwal,'id',$simpan_jadwal["id"]);
			$ambil = $this->web_app_model->getTripleWhere('tbl_kelas_ajar','id_kelas',$kelas_lama,'id_mapel',$mapel_lama,'id_guru',$simpan_kelas["id_guru"]);

			foreach ($ambil->result() as $ambil) {
				$id_kelas_ajar = $ambil->id;
				$this->web_app_model->updateData('tbl_kelas_ajar',$simpan_kelas,'id',$id_kelas_ajar);
			}

			$this->session->set_flashdata('berhasil', 'Berhasil disimpan!');
			header('location:'.base_url().'index.php/guru/tampil_jadwal');
		}
		else
		{
			header('location:'.base_url().'index.php/web');	
		}
	}

	public function hapus_jadwal()
	{
		$cek  = $this->session->userdata('logged_in');
		$stts = $this->session->userdata('status');
		if(!empty($cek) && $stts=='Guru')
		{
			$id_jadwal	= $this->uri->segment(3);
			$id_kelas	= $this->uri->segment(4);
			$id_mapel	= $this->uri->segment(5);

			$this->web_app_model->deleteData('tbl_mapel_ajar','id',$id_jadwal);
			$this->web_app_model->deleteMultipleWhere('tbl_kelas_ajar','id_kelas',$id_kelas,'id_mapel',$id_mapel);

			$this->session->set_flashdata('berhasil', 'Berhasil dihapus!');
			header('location:'.base_url().'index.php/guru/tampil_jadwal');
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
		if(!empty($cek) && $stts=='Guru')
		{
			$bc['status'] = $this->session->userdata('status');
			$bc['title'] = "Tugas";
			$bc['id_guru'] = $this->session->userdata('id_guru');

			$sess = $this->web_app_model->getWhereData('tbl_guru','id_guru',$bc['id_guru']);
			foreach ($sess->result() as $sess) {
				$bc['nama']			= $sess->nama_guru;
				$bc['foto']			= $sess->foto;
				$bc['username'] 	= $sess->username;
			}

			$get_self = $this->web_app_model->getWhereData('tbl_login','id_guru',$bc['id_guru']);
			foreach ($get_self->result() as $get) {
				$id_login = $get->id_login;
			}
			$bc['hitung_pesan'] = $this->web_app_model->HitungPesanPengirim($id_login);
			$bc['menu'] = $this->load->view('guru/menu',$bc,true);

			$bc['header'] = $this->load->view('guru/header',$bc,true);
			$bc['footer'] = $this->load->view('guru/footer',$bc,true);
			
			$bc['tugas'] = $this->web_app_model->getTugas($bc['nama']);
			$bc['jumlah_pilgan'] = $this->web_app_model->getData('tbl_soal_pilgan','id_tugas');
			$bc['jumlah_upload'] = $this->web_app_model->getData('tbl_soal_upload','id_tugas');

			$this->load->view('guru/view_tugas',$bc);			
		}
		else
		{
			header('location:'.base_url().'index.php/web');	
		}
	}

	public function tambah_tugas()
	{
		$cek  = $this->session->userdata('logged_in');
		$stts = $this->session->userdata('status');
		if(!empty($cek) && $stts=='Guru')
		{
			$bc['status'] = $this->session->userdata('status');
			$bc['title'] = "Tambah Tugas";
			$bc['id_guru'] = $this->session->userdata('id_guru');

			$sess = $this->web_app_model->getWhereData('tbl_guru','id_guru',$bc['id_guru']);
			foreach ($sess->result() as $sess) {
				$bc['nama']			= $sess->nama_guru;
				$bc['foto']			= $sess->foto;
				$bc['username'] 	= $sess->username;
			}

			$get_self = $this->web_app_model->getWhereData('tbl_login','id_guru',$bc['id_guru']);
			foreach ($get_self->result() as $get) {
				$id_login = $get->id_login;
			}
			$bc['hitung_pesan'] = $this->web_app_model->HitungPesanPengirim($id_login);
			$bc['menu'] = $this->load->view('guru/menu',$bc,true);

			$bc['header'] = $this->load->view('guru/header',$bc,true);
			$bc['footer'] = $this->load->view('guru/footer',$bc,true);

			$tipe = $this->uri->segment(3);

			if($tipe=="pg"){

				$bc['kelas'] = $this->web_app_model->getKelas($bc['id_guru']);
				
				$this->load->view('guru/view_tugas_pg_tambah',$bc);			
			}else if($tipe=="upload"){

				$bc['kelas'] = $this->web_app_model->getKelas($bc['id_guru']);
				
				$this->load->view('guru/view_tugas_upload_tambah',$bc);			
			}
		}
		else
		{
			header('location:'.base_url().'index.php/web');	
		}
	}

	public function ambil_mapel()
	{
		$id_guru = $this->session->userdata('id_guru');
			
		if($this->input->post('id_kelas'))
		{
			echo $this->web_app_model->getMapel($this->input->post('id_kelas'),$id_guru);
		}
	 }

	 public function ambil_kelas_salin()
	{
		if($this->input->post('id_tugas'))
		{
			echo $this->web_app_model->getKelasSalin($this->input->post('id_tugas'));
		}
	 }


	public function aktif_tugas()
	{
		$cek  = $this->session->userdata('logged_in');
		$stts = $this->session->userdata('status');
		if(!empty($cek) && $stts=='Guru')
		{
			$data['status'] = "Aktif";
			$id_tugas = $this->uri->segment(3);

			$this->web_app_model->updateData('tbl_tugas',$data,'id_tugas',$id_tugas);

			$this->session->set_flashdata('berhasil', 'Tugas berhasil diaktifkan!');
			header('location:'.base_url().'guru/tampil_tugas');			
		}
		else
		{
			header('location:'.base_url().'index.php/web');	
		}
	}

	public function nonaktif_tugas()
	{
		$cek  = $this->session->userdata('logged_in');
		$stts = $this->session->userdata('status');
		if(!empty($cek) && $stts=='Guru')
		{
			$data['status'] = "Tidak Aktif";
			$id_tugas = $this->uri->segment(3);

			$this->web_app_model->updateData('tbl_tugas',$data,'id_tugas',$id_tugas);

			$this->session->set_flashdata('berhasil', 'Tugas berhasil dinon-aktifkan!');
			header('location:'.base_url().'guru/tampil_tugas');			
		}
		else
		{
			header('location:'.base_url().'index.php/web');	
		}
	}

	public function simpan_tugas()
	{
		$cek  = $this->session->userdata('logged_in');
		$stts = $this->session->userdata('status');
		if(!empty($cek) && $stts=='Guru')
		{
			$tipe = $this->uri->segment(3);

			if($tipe=="pg"){

				$simpan_tugas["tipe_tugas"]		= "Pilihan Ganda";
				$simpan_tugas["judul"]			= $this->input->post("judul");
				$simpan_tugas["id_kelas"]		= $this->input->post("kelas");
				$simpan_tugas["id_mapel"]		= $this->input->post("mapel");
				$simpan_tugas["tgl_mulai"]		= $this->input->post("tgl_mulai");
				$simpan_tugas["terlambat"]		= $this->input->post("terlambat");
				$simpan_tugas["waktu_soal"]		= $this->input->post("waktu_soal")*60;
				$simpan_tugas["status"]			= "Tidak Aktif";
				$simpan_tugas["pembuat"]		= $this->session->userdata('nama_guru');

				$this->web_app_model->insertData('tbl_tugas',$simpan_tugas);

				$this->session->set_flashdata('berhasil', 'Berhasil disimpan!');
				header('location:'.base_url().'index.php/guru/tampil_tugas');
			}else if($tipe=="upload"){

				$simpan_tugas["tipe_tugas"]		= "Upload";
				$simpan_tugas["judul"]			= $this->input->post("judul");
				$simpan_tugas["id_kelas"]		= $this->input->post("kelas");
				$simpan_tugas["id_mapel"]		= $this->input->post("mapel");
				$simpan_tugas["tgl_mulai"]		= $this->input->post("tgl_mulai");
				$simpan_tugas["terlambat"]		= $this->input->post("terlambat");
				$simpan_tugas["waktu_soal"]		= NULL;
				$simpan_tugas["status"]			= "Tidak Aktif";
				$simpan_tugas["pembuat"]		= $this->session->userdata('nama_guru');

				$this->web_app_model->insertData('tbl_tugas',$simpan_tugas);

				$this->session->set_flashdata('berhasil', 'Berhasil disimpan!');
				header('location:'.base_url().'index.php/guru/tampil_tugas');
			}
		}
		else
		{
			header('location:'.base_url().'index.php/web');	
		}
	}

	public function edit_tugas()
	{
		$cek  = $this->session->userdata('logged_in');
		$stts = $this->session->userdata('status');
		if(!empty($cek) && $stts=='Guru')
		{
			$bc['status'] = $this->session->userdata('status');
			$bc['title'] = "Sunting Tugas";
			$bc['id_guru'] = $this->session->userdata('id_guru');

			$sess = $this->web_app_model->getWhereData('tbl_guru','id_guru',$bc['id_guru']);
			foreach ($sess->result() as $sess) {
				$bc['nama']			= $sess->nama_guru;
				$bc['foto']			= $sess->foto;
				$bc['username'] 	= $sess->username;
			}

			$get_self = $this->web_app_model->getWhereData('tbl_login','id_guru',$bc['id_guru']);
			foreach ($get_self->result() as $get) {
				$id_login = $get->id_login;
			}
			$bc['hitung_pesan'] = $this->web_app_model->HitungPesanPengirim($id_login);
			$bc['menu'] = $this->load->view('guru/menu',$bc,true);

			$bc['header'] = $this->load->view('guru/header',$bc,true);
			$bc['footer'] = $this->load->view('guru/footer',$bc,true);

			$id 			= $this->uri->segment(3);
			$id_kelas 		= $this->uri->segment(4);

			$bc['kelas'] = $this->web_app_model->getKelas($bc['id_guru']);
			$bc['mapel'] = $this->web_app_model->getMapelEdit($id_kelas,$bc['id_guru']);
			
			$bc['edit_tugas'] = $this->web_app_model->getWhereData('tbl_tugas','id_tugas',$id);
			
			$this->load->view('guru/view_tugas_edit',$bc);			
		}
		else
		{
			header('location:'.base_url().'index.php/web');	
		}
	}

	public function update_tugas()
	{
		$cek  = $this->session->userdata('logged_in');
		$stts = $this->session->userdata('status');
		if(!empty($cek) && $stts=='Guru')
		{
			$simpan_tugas["id_tugas"]		= $this->input->post("id_tugas");
			$simpan_tugas["tipe_tugas"]		= $this->input->post("tipe_tugas");
			$simpan_tugas["judul"]			= $this->input->post("judul");
			$simpan_tugas["id_kelas"]		= $this->input->post("kelas");
			$simpan_tugas["id_mapel"]		= $this->input->post("mapel");
			$simpan_tugas["tgl_mulai"]		= $this->input->post("tgl_mulai");
			$simpan_tugas["terlambat"]		= $this->input->post("terlambat");
			$simpan_tugas["waktu_soal"]		= $this->input->post("waktu_soal")*60;
			$simpan_tugas["pembuat"]		= $this->session->userdata('nama_guru');

			$this->web_app_model->updateData('tbl_tugas',$simpan_tugas,'id_tugas',$simpan_tugas["id_tugas"]);

			$this->session->set_flashdata('berhasil', 'Berhasil disimpan!');
			header('location:'.base_url().'index.php/guru/tampil_tugas');
		}
		else
		{
			header('location:'.base_url().'index.php/web');	
		}
	}

	public function hapus_tugas()
	{
		$cek  = $this->session->userdata('logged_in');
		$stts = $this->session->userdata('status');
		if(!empty($cek) && $stts=='Guru')
		{
			$id_tugas		= $this->uri->segment(3);
			$this->web_app_model->deleteData('tbl_tugas','id_tugas',$id_tugas);

			$this->session->set_flashdata('berhasil', 'Berhasil dihapus!');
			header('location:'.base_url().'index.php/guru/tampil_tugas');
		}
		else
		{
			header('location:'.base_url().'index.php/web');	
		}
	}

	public function h_tugas()
	{
		$cek  = $this->session->userdata('logged_in');
		$stts = $this->session->userdata('status');
		if(!empty($cek) && $stts=='Guru')
		{
			$bc['status'] = $this->session->userdata('status');
			$bc['title'] = "Tugas";
			$bc['id_guru'] = $this->session->userdata('id_guru');

			$sess = $this->web_app_model->getWhereData('tbl_guru','id_guru',$bc['id_guru']);
			foreach ($sess->result() as $sess) {
				$bc['nama']			= $sess->nama_guru;
				$bc['foto']			= $sess->foto;
				$bc['username'] 	= $sess->username;
			}

			$get_self = $this->web_app_model->getWhereData('tbl_login','id_guru',$bc['id_guru']);
			foreach ($get_self->result() as $get) {
				$id_login = $get->id_login;
			}
			$bc['hitung_pesan'] = $this->web_app_model->HitungPesanPengirim($id_login);
			$bc['menu'] = $this->load->view('guru/menu',$bc,true);

			$bc['header'] = $this->load->view('guru/header',$bc,true);
			$bc['footer'] = $this->load->view('guru/footer',$bc,true);
			
			$uri3 = $this->uri->segment(3);
			$uri4 = $this->uri->segment(4);
			$uri5 = $this->uri->segment(5);
			$uri6 = $this->uri->segment(6);
			$uri7 = $this->uri->segment(7);

			if($uri3 == "det_tugas")
			{
				$bc['detil_tugas'] = $this->web_app_model->getHasilTugas($uri5);

				$bc['statistik'] = $this->db->query("SELECT MAX(nilai) AS max_, MIN(nilai) AS min_, AVG(nilai) AS avg_ 
												FROM tbl_ikut_tugas
												WHERE tbl_ikut_tugas.id_tugas = '$uri5'")->row();

				$bc['list_peserta'] = $this->db->query("
		        	SELECT a.id, b.nama_siswa, b.nis, a.nilai, a.jml_benar, a.nilai_bobot, a.list_jawaban, a.nilai, a.id_tugas, a.kelompok, a.nilai_kelompok
					FROM tbl_ikut_tugas a
					INNER JOIN tbl_siswa b ON a.id_siswa = b.id_siswa
					WHERE a.id_tugas = '$uri5'
					ORDER BY a.tgl_selesai DESC"); 

				if($uri4 == "PG"){
					$this->load->view('guru/view_hasil_tugas_pg',$bc);	
				}else if($uri4 == "upload"){
					$this->load->view('guru/view_hasil_tugas_upload',$bc);	
				}

			}else if ($uri3 == "batalkan_ujian") {
				if($uri4 == "PG"){
					$this->db->query("DELETE FROM tbl_ikut_tugas WHERE id = '$uri6'");
					$kel = $uri7;

					if($kel=="" || $kel==NULL){
					}else{
						$ambil_kelompok = $this->web_app_model->getMultipleWhere('tbl_ikut_tugas','id_tugas',$uri5,'kelompok',$kel);

						if($ambil_kelompok->num_rows()>=1){
							$hitung = "";
							$nilai_kelompok = "";
							foreach ($ambil_kelompok->result_array() as $ambil) {
								$nilai_individu = $ambil['nilai'];
								$nilai_kelompok = $nilai_kelompok + $nilai_individu;
								$hitung++;
							}
							$kelo['nilai_kelompok'] = $nilai_kelompok/$hitung;

							$this->web_app_model->updateMultipleWhere('tbl_ikut_tugas',$kelo,'id_tugas',$uri5,'kelompok',$kel);
						}
					}
					redirect('guru/h_tugas/det_tugas/PG/'.$uri5.'');

				}else if($uri4 == "upload"){
					$this->db->query("DELETE FROM tbl_ikut_tugas WHERE id = '$uri6'");
					$kel = $uri7;

					if($kel=="" || $kel==NULL){
					}else{
						$ambil_kelompok = $this->web_app_model->getMultipleWhere('tbl_ikut_tugas','id_tugas',$uri5,'kelompok',$kel);

						if($ambil_kelompok->num_rows()>=1){
							$hitung = "";
							$nilai_kelompok = "";
							foreach ($ambil_kelompok->result_array() as $ambil) {
								$nilai_individu = $ambil['nilai'];
								$nilai_kelompok = $nilai_kelompok + $nilai_individu;
								$hitung++;
							}
							$kelo['nilai_kelompok'] = $nilai_kelompok/$hitung;

							$this->web_app_model->updateMultipleWhere('tbl_ikut_tugas',$kelo,'id_tugas',$uri5,'kelompok',$kel);
						}
					}
					redirect('guru/h_tugas/det_tugas/upload/'.$uri5.'');
				}
			}		
		}
		else
		{
			header('location:'.base_url().'index.php/web');	
		}
	}

	public function update_nilai()
	{
		$cek  = $this->session->userdata('logged_in');
		$stts = $this->session->userdata('status');
		if(!empty($cek) && $stts=='Guru')
		{
			$id 				= $this->input->post('id');
			$id_tugas 			= $this->input->post('id_tugas');
			$simpan['nilai'] 	= $this->input->post('nilai');

			$this->web_app_model->updateData('tbl_ikut_tugas',$simpan,'id',$id);

			$ambil_kelompok = $this->web_app_model->getWhereData('tbl_ikut_tugas','id',$id);

			foreach ($ambil_kelompok->result() as $ambil) {
				$kelompok = $ambil->kelompok;
			}

			if($kelompok!=NULL){
				$all_kelompok = $this->web_app_model->getMultipleWhere('tbl_ikut_tugas','id_tugas',$id_tugas,'kelompok',$kelompok);

				$hitung = "";
				$nilai_kelompok = "";
				foreach ($all_kelompok->result_array() as $all) {
					$nilai = $all['nilai'];
					$nilai_kelompok = $nilai_kelompok + $nilai;
					$hitung++;
				}
				$kel['nilai_kelompok'] = $nilai_kelompok/$hitung;

				$this->web_app_model->updateMultipleWhere('tbl_ikut_tugas',$kel,'id_tugas',$id_tugas,'kelompok',$kelompok);
			}

			redirect('guru/h_tugas/det_tugas/upload/'.$id_tugas.'');
				
		}
		else
		{
			header('location:'.base_url().'index.php/web');	
		}
	}

	public function update_nilai_upload()
	{
		$cek  = $this->session->userdata('logged_in');
		$stts = $this->session->userdata('status');
		if(!empty($cek) && $stts=='Guru')
		{
			$bc['status'] = $this->session->userdata('status');
			$bc['title'] = "Tugas";
			$bc['id_guru'] = $this->session->userdata('id_guru');

			$sess = $this->web_app_model->getWhereData('tbl_guru','id_guru',$bc['id_guru']);
			foreach ($sess->result() as $sess) {
				$bc['nama']			= $sess->nama_guru;
				$bc['foto']			= $sess->foto;
				$bc['username'] 	= $sess->username;
			}

			$get_self = $this->web_app_model->getWhereData('tbl_login','id_guru',$bc['id_guru']);
			foreach ($get_self->result() as $get) {
				$id_login = $get->id_login;
			}
			$bc['hitung_pesan'] = $this->web_app_model->HitungPesanPengirim($id_login);
			$bc['menu'] = $this->load->view('guru/menu',$bc,true);

			$bc['header'] = $this->load->view('guru/header',$bc,true);
			$bc['footer'] = $this->load->view('guru/footer',$bc,true);
			
			$uri3 = $this->uri->segment(3);
			$uri4 = $this->uri->segment(4);
			$uri5 = $this->uri->segment(5);

		}
		else
		{
			header('location:'.base_url().'index.php/web');	
		}
	}

	public function tambah_soal()
	{
		$cek  = $this->session->userdata('logged_in');
		$stts = $this->session->userdata('status');
		if(!empty($cek) && $stts=='Guru')
		{
			$bc['status'] = $this->session->userdata('status');
			$bc['title'] = "Tambah Soal";
			$bc['id_guru'] = $this->session->userdata('id_guru');

			$sess = $this->web_app_model->getWhereData('tbl_guru','id_guru',$bc['id_guru']);
			foreach ($sess->result() as $sess) {
				$bc['nama']			= $sess->nama_guru;
				$bc['foto']			= $sess->foto;
				$bc['username'] 	= $sess->username;
			}

			$get_self = $this->web_app_model->getWhereData('tbl_login','id_guru',$bc['id_guru']);
			foreach ($get_self->result() as $get) {
				$id_login = $get->id_login;
			}
			$bc['hitung_pesan'] = $this->web_app_model->HitungPesanPengirim($id_login);
			$bc['menu'] = $this->load->view('guru/menu',$bc,true);

			$bc['header'] = $this->load->view('guru/header',$bc,true);
			$bc['footer'] = $this->load->view('guru/footer',$bc,true);

			$tipe = $this->uri->segment(3);
			$id_tgs = $this->uri->segment(4);

			if($tipe == "pilgan"){
				$bc['pilgan'] = $this->web_app_model->getWhereData('tbl_soal_pilgan','id_tugas',$id_tgs);
				$bc['jumlah_pilgan'] = $this->web_app_model->getWhereData('tbl_soal_pilgan','id_tugas',$id_tgs);
				$bc['detail_tugas'] = $this->web_app_model->getDetailTugas($id_tgs);

				$this->load->view('guru/tambah_soal_pilgan',$bc);
			}else if($tipe == "upload"){
				$bc['detail_tugas'] = $this->web_app_model->getDetailTugas($id_tgs);
				$bc['upload'] 		= $this->web_app_model->getWhereData('tbl_soal_upload','id_tugas',$id_tgs);

				$this->load->view('guru/tambah_soal_upload',$bc);
			}			
		}
		else
		{
			header('location:'.base_url().'index.php/web');	
		}
	}

	public function simpan_soalpilgan()
	{
		$cek  = $this->session->userdata('logged_in');
		$stts = $this->session->userdata('status');
		if(!empty($cek) && $stts=='Guru')
		{
			$simpan_pilgan["id_tugas"]		= $this->input->post("id_tugas");
			$simpan_pilgan["pertanyaan"]	= $this->input->post("pertanyaan");
			$simpan_pilgan["opsi_a"]		= $this->input->post("pilA");
			$simpan_pilgan["opsi_b"]		= $this->input->post("pilB");
			$simpan_pilgan["opsi_c"]		= $this->input->post("pilC");
			$simpan_pilgan["opsi_d"]		= $this->input->post("pilD");
			$simpan_pilgan["opsi_e"]		= $this->input->post("pilE");
			$simpan_pilgan["kunci"]			= $this->input->post("kunci");

			$this->web_app_model->insertData('tbl_soal_pilgan',$simpan_pilgan);

			redirect('guru/daftar_soal/PG/'.$simpan_pilgan["id_tugas"].'');
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
		if(!empty($cek) && $stts=='Guru')
		{
			$path = './file/soal/';
			$config['upload_path']          = $path;
            $config['allowed_types']        = 'doc|zip|rar|txt|docx|xls|xlsx|pdf|tar|gz|jpg|jpeg|JPG|JPEG|png|ppt|pptx';
            $config['max_size']             = '10000';
            $config['max_width']            = '5000';
            $config['max_height']           = '5000';

            $file_lama = $this->input->post('ganti_file');

            $this->load->library('upload', $config);

            if ( ! $this->upload->do_upload())
            {
                $simpan_upload["id_tugas"]	= $this->input->post("id_tugas");
				$simpan_upload["info"]		= $this->input->post("info");
				$simpan_upload["file"]		= NULL;

				$this->web_app_model->insertData('tbl_soal_upload',$simpan_upload);

				header('location:'.base_url().'guru/tampil_tugas');
            }
            else
            {
				$materi = $this->upload->data();
            	$simpan_upload["file"] 		= $materi['file_name']; 
            	$simpan_upload["id_tugas"]	= $this->input->post("id_tugas");
				$simpan_upload["info"]		= $this->input->post("info");

				$this->web_app_model->insertData('tbl_soal_upload',$simpan_upload);

				header('location:'.base_url().'guru/tampil_tugas');
			}
		}
		else
		{
			header('location:'.base_url().'index.php/web');	
		}
	}

	public function update_upload()
	{
		$cek  = $this->session->userdata('logged_in');
		$stts = $this->session->userdata('status');
		if(!empty($cek) && $stts=='Guru')
		{
			$path = './file/soal/';
			$config['upload_path']          = $path;
            $config['allowed_types']        = 'doc|zip|rar|txt|docx|xls|xlsx|pdf|tar|gz|jpg|jpeg|JPG|JPEG|png|ppt|pptx';
            $config['max_size']             = '10000';
            $config['max_width']            = '5000';
            $config['max_height']           = '5000';

            $file_lama = $this->input->post('ganti_file');

            $this->load->library('upload', $config);

            if ( ! $this->upload->do_upload())
            {
                $simpan_upload["id_tugas"]	= $this->input->post("id_tugas");
				$simpan_upload["info"]		= $this->input->post("info");

				$this->web_app_model->updateData('tbl_soal_upload',$simpan_upload,'id_tugas',$simpan_upload["id_tugas"]);

				header('location:'.base_url().'guru/tampil_tugas');
            }
            else
            {
				$materi = $this->upload->data();
            	$simpan_upload["file"] 		= $materi['file_name']; 
            	$simpan_upload["id_tugas"]	= $this->input->post("id_tugas");
				$simpan_upload["info"]		= $this->input->post("info");

				@unlink($path.$file_lama);

				$this->web_app_model->updateData('tbl_soal_upload',$simpan_upload,'id_tugas',$simpan_upload["id_tugas"]);

				header('location:'.base_url().'guru/tampil_tugas');
			}
		}
		else
		{
			header('location:'.base_url().'index.php/web');	
		}
	}

	public function edit_pilgan()
	{
		$cek  = $this->session->userdata('logged_in');
		$stts = $this->session->userdata('status');
		if(!empty($cek) && $stts=='Guru')
		{
			$bc['status'] = $this->session->userdata('status');
			$bc['title'] = "Sunting Soal";
			$bc['id_guru'] = $this->session->userdata('id_guru');

			$sess = $this->web_app_model->getWhereData('tbl_guru','id_guru',$bc['id_guru']);
			foreach ($sess->result() as $sess) {
				$bc['nama']			= $sess->nama_guru;
				$bc['foto']			= $sess->foto;
				$bc['username'] 	= $sess->username;
			}

			$get_self = $this->web_app_model->getWhereData('tbl_login','id_guru',$bc['id_guru']);
			foreach ($get_self->result() as $get) {
				$id_login = $get->id_login;
			}
			$bc['hitung_pesan'] = $this->web_app_model->HitungPesanPengirim($id_login);
			$bc['menu'] = $this->load->view('guru/menu',$bc,true);

			$bc['header'] = $this->load->view('guru/header',$bc,true);
			$bc['footer'] = $this->load->view('guru/footer',$bc,true);

			$bc['kelas'] = $this->web_app_model->getKelas($bc['id_guru']);

			$id_tugas = $this->uri->segment(3);
			$id_pilgan = $this->uri->segment(4);
			$bc['edit_pilgan'] = $this->web_app_model->getMultipleWhere('tbl_soal_pilgan','id_tugas',$id_tugas,'id_pilgan',$id_pilgan);
			
			$this->load->view('guru/view_edit_pilgan',$bc);			
		}
		else
		{
			header('location:'.base_url().'index.php/web');	
		}
	}

	public function update_pilgan()
	{
		$cek  = $this->session->userdata('logged_in');
		$stts = $this->session->userdata('status');
		if(!empty($cek) && $stts=='Guru')
		{
			$simpan_pilgan["id_tugas"]		= $this->input->post("id_tugas");
			$simpan_pilgan["id_pilgan"]		= $this->input->post("id_pilgan");
			$simpan_pilgan["pertanyaan"]	= $this->input->post("pertanyaan");
			$simpan_pilgan["gambar"]		= $this->input->post("gambar");
			$simpan_pilgan["opsi_a"]			= $this->input->post("pilA");
			$simpan_pilgan["opsi_b"]			= $this->input->post("pilB");
			$simpan_pilgan["opsi_c"]			= $this->input->post("pilC");
			$simpan_pilgan["opsi_d"]			= $this->input->post("pilD");
			$simpan_pilgan["opsi_e"]			= $this->input->post("pilE");
			$simpan_pilgan["kunci"]			= $this->input->post("kunci");

			$this->web_app_model->updateData('tbl_soal_pilgan',$simpan_pilgan,'id_pilgan',$simpan_pilgan["id_pilgan"]);

			redirect('guru/daftar_soal/PG/'.$simpan_pilgan["id_tugas"].'');

		}
		else
		{
			header('location:'.base_url().'index.php/web');	
		}
	}

	public function hapus_pilgan()
	{
		$cek  = $this->session->userdata('logged_in');
		$stts = $this->session->userdata('status');
		if(!empty($cek) && $stts=='Guru')
		{
			$id_tugas		= $this->uri->segment(3);
			$id_pilgan		= $this->uri->segment(4);
			$this->web_app_model->deleteData('tbl_soal_pilgan','id_pilgan',$id_pilgan);
			redirect('guru/daftar_soal/PG/'.$id_tugas.'');
		}
		else
		{
			header('location:'.base_url().'index.php/web');	
		}
	}

	

	public function hapus_essay()
	{
		$cek  = $this->session->userdata('logged_in');
		$stts = $this->session->userdata('status');
		if(!empty($cek) && $stts=='Guru')
		{
			$id_tugas		= $this->uri->segment(3);
			$id_essay		= $this->uri->segment(4);
			$this->web_app_model->deleteData('tbl_soal_essay','id_essay',$id_essay);
			redirect('guru/daftar_soal/'.$id_tugas.'/'.$id_essay.'');
		}
		else
		{
			header('location:'.base_url().'index.php/web');	
		}
	}

	public function daftar_soal()
	{
		$cek  = $this->session->userdata('logged_in');
		$stts = $this->session->userdata('status');
		if(!empty($cek) && $stts=='Guru')
		{
			$bc['status'] = $this->session->userdata('status');
			$bc['title'] = "Daftar Soal";
			$bc['id_guru'] = $this->session->userdata('id_guru');

			$sess = $this->web_app_model->getWhereData('tbl_guru','id_guru',$bc['id_guru']);
			foreach ($sess->result() as $sess) {
				$bc['nama']			= $sess->nama_guru;
				$bc['foto']			= $sess->foto;
				$bc['username'] 	= $sess->username;
			}

			$get_self = $this->web_app_model->getWhereData('tbl_login','id_guru',$bc['id_guru']);
			foreach ($get_self->result() as $get) {
				$id_login = $get->id_login;
			}
			$bc['hitung_pesan'] = $this->web_app_model->HitungPesanPengirim($id_login);
			$bc['menu'] = $this->load->view('guru/menu',$bc,true);

			$bc['header'] = $this->load->view('guru/header',$bc,true);
			$bc['footer'] = $this->load->view('guru/footer',$bc,true);

			$tipe = $this->uri->segment(3);
			$id_tgs = $this->uri->segment(4);
			$bc['tipe_tugas']	= $this->uri->segment(3);
			$bc['id_tugas']		= $this->uri->segment(4);

			if($tipe == "PG"){
				$bc['detail_tugas'] = $this->web_app_model->getDetailTugas($id_tgs);
				$bc['jumlah_pilgan'] = $this->web_app_model->getWhereData('tbl_soal_pilgan','id_tugas',$id_tgs);
				$bc['detail_pilgan'] = $this->web_app_model->getWhereData('tbl_soal_pilgan','id_tugas',$id_tgs);

				$type = "Pilihan Ganda";
				$bc['tugas'] = $this->web_app_model->getTugasType($bc['nama'],$type);
				
				$this->load->view('guru/lihat_soal_pilgan',$bc);	
			}else if($tipe == "upload"){
				$bc['detail_tugas'] = $this->web_app_model->getDetailTugas($id_tgs);
				$bc['jumlah_upload'] = $this->web_app_model->getWhereData('tbl_soal_upload','id_tugas',$id_tgs);
				$bc['upload'] = $this->web_app_model->getWhereData('tbl_soal_upload','id_tugas',$id_tgs);

				$this->load->view('guru/soal_upload',$bc);
			}	
		}
		else
		{
			header('location:'.base_url().'index.php/web');	
		}
	}

	public function salin_semua_soal()
	{
		$cek  = $this->session->userdata('logged_in');
		$stts = $this->session->userdata('status');
		if(!empty($cek) && $stts=='Guru')
		{
			$id_tugas_asal		= $this->input->post("id_tugas_asal");
			$id_tugas_tujuan	= $this->input->post("tugas");
			$tipe_tugas			= $this->input->post("tipe_tugas");

			if($tipe_tugas=="PG"){
				$ambil 	= $this->web_app_model->getWhereData('tbl_soal_pilgan','id_tugas',$id_tugas_asal);	

				foreach ($ambil->result_array() as $ambil) {
					$simpan['id_tugas'] 	= $id_tugas_tujuan;
					$simpan['pertanyaan'] 	= $ambil['pertanyaan'];
					$simpan['opsi_a'] 		= $ambil['opsi_a'];
					$simpan['opsi_b'] 		= $ambil['opsi_b'];
					$simpan['opsi_c'] 		= $ambil['opsi_c'];
					$simpan['opsi_d'] 		= $ambil['opsi_d'];
					$simpan['opsi_e'] 		= $ambil['opsi_e'];
					$simpan['kunci'] 		= $ambil['kunci'];

					$this->web_app_model->insertData('tbl_soal_pilgan',$simpan);
				}
				$this->session->set_flashdata('berhasil', 'Soal berhasil disalin!');
				redirect('guru/daftar_soal/PG/'.$id_tugas_asal.'');
			}
		}
		else
		{
			header('location:'.base_url().'index.php/web');	
		}
	}

	public function salin_satu_soal()
	{
		$cek  = $this->session->userdata('logged_in');
		$stts = $this->session->userdata('status');
		if(!empty($cek) && $stts=='Guru')
		{
			$id_pilgan			= $this->input->post("id_pilgan");
			$id_tugas_asal		= $this->input->post("id_tugas_asal");
			$id_tugas_tujuan	= $this->input->post("tugas");
			$tipe_tugas			= $this->input->post("tipe_tugas");

			if($tipe_tugas=="PG"){
				$ambil 	= $this->web_app_model->getWhereData('tbl_soal_pilgan','id_pilgan',$id_pilgan);	

				foreach ($ambil->result_array() as $ambil) {
					$simpan['id_tugas'] 	= $id_tugas_tujuan;
					$simpan['pertanyaan'] 	= $ambil['pertanyaan'];
					$simpan['opsi_a'] 		= $ambil['opsi_a'];
					$simpan['opsi_b'] 		= $ambil['opsi_b'];
					$simpan['opsi_c'] 		= $ambil['opsi_c'];
					$simpan['opsi_d'] 		= $ambil['opsi_d'];
					$simpan['opsi_e'] 		= $ambil['opsi_e'];
					$simpan['kunci'] 		= $ambil['kunci'];

					$this->web_app_model->insertData('tbl_soal_pilgan',$simpan);
				}
				$this->session->set_flashdata('berhasil', 'Soal berhasil disalin!');
				redirect('guru/daftar_soal/PG/'.$id_tugas_asal.'');
			}
		}
		else
		{
			header('location:'.base_url().'index.php/web');	
		}
	}

	public function tampil_kelompok()
	{
		$cek  = $this->session->userdata('logged_in');
		$stts = $this->session->userdata('status');
		if(!empty($cek) && $stts=='Guru')
		{
			header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
			header("Cache-Control: post-check=0, pre-check=0", false);
			header("Pragma: no-cache");

			$bc['status'] = $this->session->userdata('status');
			$bc['title'] = "Kelompok";
			$bc['id_guru'] = $this->session->userdata('id_guru');

			$sess = $this->web_app_model->getWhereData('tbl_guru','id_guru',$bc['id_guru']);
			foreach ($sess->result() as $sess) {
				$bc['nama']			= $sess->nama_guru;
				$bc['foto']			= $sess->foto;
				$bc['username'] 	= $sess->username;
			}

			$get_self = $this->web_app_model->getWhereData('tbl_login','id_guru',$bc['id_guru']);
			foreach ($get_self->result() as $get) {
				$id_login = $get->id_login;
			}
			$bc['hitung_pesan'] = $this->web_app_model->HitungPesanPengirim($id_login);
			$bc['menu'] = $this->load->view('guru/menu',$bc,true);

			$bc['header'] = $this->load->view('guru/header',$bc,true);
			$bc['footer'] = $this->load->view('guru/footer',$bc,true);

			$bc['uri3'] = $this->uri->segment(3);
			$bc['uri4'] = $this->uri->segment(4);

			$bc['kelompok'] = $this->web_app_model->getAnggotaKelompok($bc['uri4']);
			$bc['kelompok2'] = $this->web_app_model->getKelompok($bc['uri3']);

			$this->load->view('guru/view_kelompok',$bc);			
		}
		else
		{
			header('location:'.base_url().'index.php/web');	
		}
	}

	public function update_kelompok()
	{
		$cek  = $this->session->userdata('logged_in');
		$stts = $this->session->userdata('status');
		if(!empty($cek) && $stts=='Guru')
		{
			$bc['status'] = $this->session->userdata('status');
			$bc['title'] = "Kelompok";
			$bc['id_guru'] = $this->session->userdata('id_guru');

			$sess = $this->web_app_model->getWhereData('tbl_guru','id_guru',$bc['id_guru']);
			foreach ($sess->result() as $sess) {
				$bc['nama']			= $sess->nama_guru;
				$bc['foto']			= $sess->foto;
				$bc['username'] 	= $sess->username;
			}

			$get_self = $this->web_app_model->getWhereData('tbl_login','id_guru',$bc['id_guru']);
			foreach ($get_self->result() as $get) {
				$id_login = $get->id_login;
			}
			$bc['hitung_pesan'] = $this->web_app_model->HitungPesanPengirim($id_login);
			$bc['menu'] = $this->load->view('guru/menu',$bc,true);

			$bc['header'] = $this->load->view('guru/header',$bc,true);
			$bc['footer'] = $this->load->view('guru/footer',$bc,true);

			$id_tugas = $this->uri->segment(3);
			$id_siswa = $this->uri->segment(4);
			$id_kelas = $this->input->post("id_kelas");

			$cek_kelompok = $this->web_app_model->cekKelompok($id_tugas,$id_siswa);

			if($cek_kelompok->num_rows() < 1){
				$simpan_kelompok["id_tugas"]		= $this->input->post("id_tugas");
				$simpan_kelompok["id_siswa"]		= $this->input->post("id_siswa");
				$simpan_kelompok["nama_siswa"]		= $this->input->post("nama_siswa");
				$simpan_kelompok["kelompok"]		= $this->input->post("kelompok");

				$this->web_app_model->insertData('tbl_kelompok',$simpan_kelompok);

			}else if($cek_kelompok->num_rows() > 0){
				$simpan_kelompok["id_tugas"]		= $this->input->post("id_tugas");
				$simpan_kelompok["id_siswa"]		= $this->input->post("id_siswa");
				$simpan_kelompok["nama_siswa"]		= $this->input->post("nama_siswa");
				$simpan_kelompok["kelompok"]		= $this->input->post("kelompok");

				$this->web_app_model->updateMultipleWhere('tbl_kelompok',$simpan_kelompok,'id_tugas',$simpan_kelompok['id_tugas'],'id_siswa',$simpan_kelompok['id_siswa']);
			}

			redirect('guru/tampil_kelompok/'.$id_tugas.'/'.$id_kelas.'');			
		}
		else
		{
			header('location:'.base_url().'index.php/web');	
		}
	}

	public function hapus_kelompok()
	{
		$cek  = $this->session->userdata('logged_in');
		$stts = $this->session->userdata('status');
		if(!empty($cek) && $stts=='Guru')
		{
			$bc['status'] = $this->session->userdata('status');
			$bc['title'] = "Kelompok";
			$bc['id_guru'] = $this->session->userdata('id_guru');

			$sess = $this->web_app_model->getWhereData('tbl_guru','id_guru',$bc['id_guru']);
			foreach ($sess->result() as $sess) {
				$bc['nama']			= $sess->nama_guru;
				$bc['foto']			= $sess->foto;
				$bc['username'] 	= $sess->username;
			}

			$get_self = $this->web_app_model->getWhereData('tbl_login','id_guru',$bc['id_guru']);
			foreach ($get_self->result() as $get) {
				$id_login = $get->id_login;
			}
			$bc['hitung_pesan'] = $this->web_app_model->HitungPesanPengirim($id_login);
			$bc['menu'] = $this->load->view('guru/menu',$bc,true);

			$bc['header'] = $this->load->view('guru/header',$bc,true);
			$bc['footer'] = $this->load->view('guru/footer',$bc,true);

			$id_tugas = $this->uri->segment(3);
			$id_kelas = $this->uri->segment(4);
			$id_kelompok = $this->uri->segment(5);

			$this->web_app_model->deleteData('tbl_kelompok','id_kelompok',$id_kelompok);

			redirect('guru/tampil_kelompok/'.$id_tugas.'/'.$id_kelas.'');			
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
		if(!empty($cek) && $stts=='Guru')
		{
			$bc['status'] = $this->session->userdata('status');
			$bc['title'] = "Materi";
			$bc['id_guru'] = $this->session->userdata('id_guru');

			$sess = $this->web_app_model->getWhereData('tbl_guru','id_guru',$bc['id_guru']);
			foreach ($sess->result() as $sess) {
				$bc['nama']			= $sess->nama_guru;
				$bc['foto']			= $sess->foto;
				$bc['username'] 	= $sess->username;
			}

			$get_self = $this->web_app_model->getWhereData('tbl_login','id_guru',$bc['id_guru']);
			foreach ($get_self->result() as $get) {
				$id_login = $get->id_login;
			}
			$bc['hitung_pesan'] = $this->web_app_model->HitungPesanPengirim($id_login);
			$bc['menu'] = $this->load->view('guru/menu',$bc,true);

			$bc['header'] = $this->load->view('guru/header',$bc,true);
			$bc['footer'] = $this->load->view('guru/footer',$bc,true);

			$bc['materi'] = $this->web_app_model->getMateri($bc['nama']);
			
			$this->load->view('guru/view_materi',$bc);			
		}
		else
		{
			header('location:'.base_url().'index.php/web');	
		}
	}

	public function tambah_materi()
	{
		$cek  = $this->session->userdata('logged_in');
		$stts = $this->session->userdata('status');
		if(!empty($cek) && $stts=='Guru')
		{
			$bc['status'] = $this->session->userdata('status');
			$bc['title'] = "Tambah Materi";
			$bc['id_guru'] = $this->session->userdata('id_guru');

			$sess = $this->web_app_model->getWhereData('tbl_guru','id_guru',$bc['id_guru']);
			foreach ($sess->result() as $sess) {
				$bc['nama']			= $sess->nama_guru;
				$bc['foto']			= $sess->foto;
				$bc['username'] 	= $sess->username;
			}

			$get_self = $this->web_app_model->getWhereData('tbl_login','id_guru',$bc['id_guru']);
			foreach ($get_self->result() as $get) {
				$id_login = $get->id_login;
			}
			$bc['hitung_pesan'] = $this->web_app_model->HitungPesanPengirim($id_login);
			$bc['menu'] = $this->load->view('guru/menu',$bc,true);

			$bc['header'] = $this->load->view('guru/header',$bc,true);
			$bc['footer'] = $this->load->view('guru/footer',$bc,true);

			$uri3 = $this->uri->segment(3);

			if($uri3=='tertulis'){
				$bc['kelas'] = $this->web_app_model->getKelas($bc['id_guru']);
				
				$this->load->view('guru/view_materi_tulis_tambah',$bc);
			}else if($uri3=='file'){
				$bc['kelas'] = $this->web_app_model->getKelas($bc['id_guru']);
				
				$this->load->view('guru/view_materi_file_tambah',$bc);
			}
		}
		else
		{
			header('location:'.base_url().'index.php/web');	
		}
	}

	public function simpan_materi()
	{
		$cek  = $this->session->userdata('logged_in');
		$stts = $this->session->userdata('status');
		if(!empty($cek) && $stts=='Guru')
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
                $config['max_size']             = '100000000';

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

	public function edit_materi()
	{
		$cek  = $this->session->userdata('logged_in');
		$stts = $this->session->userdata('status');
		if(!empty($cek) && $stts=='Guru')
		{
			$bc['status'] = $this->session->userdata('status');
			$bc['title'] = "Sunting Materi";
			$bc['id_guru'] = $this->session->userdata('id_guru');

			$sess = $this->web_app_model->getWhereData('tbl_guru','id_guru',$bc['id_guru']);
			foreach ($sess->result() as $sess) {
				$bc['nama']			= $sess->nama_guru;
				$bc['foto']			= $sess->foto;
				$bc['username'] 	= $sess->username;
			}

			$get_self = $this->web_app_model->getWhereData('tbl_login','id_guru',$bc['id_guru']);
			foreach ($get_self->result() as $get) {
				$id_login = $get->id_login;
			}
			$bc['hitung_pesan'] = $this->web_app_model->HitungPesanPengirim($id_login);
			$bc['menu'] = $this->load->view('guru/menu',$bc,true);

			$bc['header'] = $this->load->view('guru/header',$bc,true);
			$bc['footer'] = $this->load->view('guru/footer',$bc,true);

			$id 		= $this->uri->segment(3);
			$id_kelas 	= $this->uri->segment(4);
			$id_guru 	= $this->session->userdata('id_guru');

			$bc['kelas'] = $this->web_app_model->getKelas($bc['id_guru']);
			$bc['mapel'] = $this->web_app_model->getMapelEdit($id_kelas,$id_guru);

			$bc['edit_materi'] = $this->web_app_model->getWhereData('tbl_materi','id_materi',$id);
			
			$this->load->view('guru/view_materi_file_edit',$bc);			
		}
		else
		{
			header('location:'.base_url().'index.php/web');	
		}
	}

	public function update_materi()
	{
		$cek  = $this->session->userdata('logged_in');
		$stts = $this->session->userdata('status');
		if(!empty($cek) && $stts=='Guru')
		{
			$uri3 = $this->uri->segment(3);

			if($uri3=='file'){
				$path = './file/materi/';
				$config['upload_path']          = $path;
                $config['allowed_types']        = 'doc|zip|rar|txt|docx|xls|xlsx|pdf|tar|gz|jpg|jpeg|JPG|JPEG|png|ppt|pptx';
                $config['max_size']             = '10000';
                $config['max_width']            = '5000';
                $config['max_height']           = '5000';

                $gambar_lama = $this->input->post('ganti_gambar');

                $this->load->library('upload', $config);

                if ( ! $this->upload->do_upload())
                {
                    $simpan_materi["id_materi"]		= $this->input->post("id_materi");
	            	$simpan_materi["judul"]			= $this->input->post("judul");
					$simpan_materi["id_kelas"]		= $this->input->post("kelas");
					$simpan_materi["id_mapel"]		= $this->input->post("mapel");
					$simpan_materi["tgl_buat"]		= $this->input->post("tgl_buat");
					$simpan_materi["konten"]		= NULL;

					$this->web_app_model->updateData('tbl_materi',$simpan_materi,'id_materi',$simpan_materi["id_materi"]);

					header('location:'.base_url().'guru/tampil_materi');
                }
                else
                {
					$materi = $this->upload->data();
	            	$simpan_materi["file"] 			= $materi['file_name']; 
	            	$simpan_materi["id_materi"]		= $this->input->post("id_materi");
	            	$simpan_materi["judul"]			= $this->input->post("judul");
					$simpan_materi["id_kelas"]		= $this->input->post("kelas");
					$simpan_materi["id_mapel"]		= $this->input->post("mapel");
					$simpan_materi["tgl_buat"]		= $this->input->post("tgl_buat");
					$simpan_materi["konten"]		= NULL;

					@unlink($path.$gambar_lama);

					$this->web_app_model->updateData('tbl_materi',$simpan_materi,'id_materi',$simpan_materi["id_materi"]);

					header('location:'.base_url().'guru/tampil_materi');
				}
			}
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
		if(!empty($cek) && $stts=='Guru')
		{
			$bc['status'] = $this->session->userdata('status');
			$bc['title'] = "Detail Materi";
			$bc['id_guru'] = $this->session->userdata('id_guru');

			$sess = $this->web_app_model->getWhereData('tbl_guru','id_guru',$bc['id_guru']);
			foreach ($sess->result() as $sess) {
				$bc['nama']			= $sess->nama_guru;
				$bc['foto']			= $sess->foto;
				$bc['username'] 	= $sess->username;
			}

			$get_self = $this->web_app_model->getWhereData('tbl_login','id_guru',$bc['id_guru']);
			foreach ($get_self->result() as $get) {
				$id_login = $get->id_login;
			}
			$bc['hitung_pesan'] = $this->web_app_model->HitungPesanPengirim($id_login);
			$bc['menu'] = $this->load->view('guru/menu',$bc,true);

			$bc['header'] = $this->load->view('guru/header',$bc,true);
			$bc['footer'] = $this->load->view('guru/footer',$bc,true);

			$bc['kelas'] = $this->web_app_model->getKelas($bc['id_guru']);

			$bc['tipe_materi']	= $this->uri->segment(3);
			$bc['id_materi'] 	= $this->uri->segment(4);

			if($bc['tipe_materi']=='file'){
				$bc['materi'] 	= $this->web_app_model->getMateriDetail($bc['id_materi']);
				$bc['komentar'] = $this->web_app_model->getKomentar($bc['id_materi']);
				
				$this->load->view('guru/view_materi_file_detail',$bc);
			}else if($bc['tipe_materi']=='tertulis'){
				$bc['materi'] = $this->web_app_model->getMateriDetail($bc['id_materi']);
				$bc['komentar2'] = $this->web_app_model->getKomentar($bc['id_materi']);
				
				$this->load->view('guru/view_materi_tertulis_detail',$bc);
			}
		}
		else
		{
			header('location:'.base_url().'index.php/web');	
		}
	}

	public function hapus_materi()
	{
		$cek  = $this->session->userdata('logged_in');
		$stts = $this->session->userdata('status');
		if(!empty($cek) && $stts=='Guru')
		{
			$id	= $this->uri->segment(3);

			$this->web_app_model->deleteData('tbl_materi','id_materi',$id);
			$this->web_app_model->deleteData('tbl_komentar','id_materi',$id);

			header('location:'.base_url().'index.php/guru/tampil_materi');
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
		if(!empty($cek) && $stts=='Guru')
		{
			$id_guru = $this->session->userdata('id_guru');

			$sess = $this->web_app_model->getWhereData('tbl_guru','id_guru',$id_guru);
			foreach ($sess->result() as $sess) {
				$simpan_komentar['nama_guru']		= $sess->nama_guru;
				$simpan_komentar['foto']			= $sess->foto;
			}

			$simpan_komentar['id_guru'] 	= $this->session->userdata('id_guru');
			$simpan_komentar['id_materi'] 	= $this->input->post('id_materi');
			$simpan_komentar['tgl_posting']	= $this->input->post('tgl_posting');
			$simpan_komentar['komentar']	= $this->input->post('komentar');

			$tipe_materi = $this->input->post('tipe_materi');

			$this->web_app_model->insertData('tbl_komentar',$simpan_komentar);

			if($tipe_materi == "file"){
				redirect('guru/detail_materi/file/'.$simpan_komentar['id_materi'].'');
			}else if($tipe_materi == "tertulis"){
				redirect('guru/detail_materi/tertulis/'.$simpan_komentar['id_materi'].'');
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

	public function download_soal(){		
		$uri3 	= 	$this->uri->segment(3);
	
		force_download('file/soal/'.$uri3, NULL); 
	}

	public function download_tugas_siswa(){		
		$jawaban = $this->input->post('jawaban');
		$ambil = str_replace(' ', '_', $jawaban);

		force_download('file/tugas/'.$ambil, NULL); 
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */