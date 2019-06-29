<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

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
		if(!empty($cek) && $stts=='Admin' || $stts=='Super Admin' )
		{
			$bc['status'] = $this->session->userdata('status');
			$bc['title'] = "Beranda";
			$id_admin = $this->session->userdata('id_admin');

			$sess = $this->web_app_model->getWhereData('tbl_admin','id_admin',$id_admin);
			foreach ($sess->result() as $sess) {
				$bc['nama']			= $sess->nama_admin;
				$bc['foto']			= $sess->foto;
				$bc['username'] 	= $sess->username;
			}

			$get_self = $this->web_app_model->getWhereData('tbl_login','id_admin',$id_admin);
			foreach ($get_self->result() as $get) {
				$id_login = $get->id_login;
			}
			$bc['hitung_pesan'] = $this->web_app_model->HitungPesanPengirim($id_login);
			$bc['menu'] = $this->load->view('admin/menu',$bc,true);

			$bc['header'] = $this->load->view('admin/header',$bc,true);
			$bc['footer'] = $this->load->view('admin/footer',$bc,true);
			
			$this->load->view('admin/home',$bc);			

		}
		else
		{
			header('location:'.base_url().'index.php/web/logout');	
		}
	}

	public function profile_admin()
	{
		$cek  = $this->session->userdata('logged_in');
		$stts = $this->session->userdata('status');
		if(!empty($cek) && $stts=='Admin' || $stts=='Super Admin')
		{
			$bc['nama'] = $this->session->userdata('nama');
			$bc['status'] = $this->session->userdata('status');
			$bc['id_admin'] = $this->session->userdata('id_admin');
			$bc['title'] = "Profil";

			$data = $this->web_app_model->getWhereData('tbl_admin','id_admin',$bc['id_admin']);
			foreach ($data->result_array() as $data) {
				$bc['nama'] = $data['nama_admin'];
				$bc['foto']	= $data['foto'];
			}
			
			$get_self = $this->web_app_model->getWhereData('tbl_login','id_admin',$bc['id_admin']);
			foreach ($get_self->result() as $get) {
				$id_login = $get->id_login;
			}
			$bc['hitung_pesan'] = $this->web_app_model->HitungPesanPengirim($id_login);
			$bc['menu'] = $this->load->view('admin/menu',$bc,true);

			$bc['header'] = $this->load->view('admin/header',$bc,true);
			$bc['footer'] = $this->load->view('admin/footer',$bc,true);

			$bc['admin'] = $this->web_app_model->getWhereData('tbl_admin','id_admin',$bc['id_admin']);
			
			$this->load->view('admin/view_profile_admin',$bc);			
		}
		else
		{
			header('location:'.base_url().'index.php/web');	
		}
	}

	public function simpan_foto_admin()
	{
		$cek  = $this->session->userdata('logged_in');
		$stts = $this->session->userdata('status');
		if(!empty($cek) && $stts=='Admin' || $stts=='Super Admin')
		{
			$id_admin = $this->uri->segment(3);

			$cek_foto = $this->web_app_model->getWhereData('tbl_admin','id_admin',$id_admin);

			foreach ($cek_foto->result() as $cek) {

				if($cek->foto=='default.png'){

					$path = './file/profile/admin/';
					$config['upload_path']          = $path;
	                $config['allowed_types']        = 'jpg|jpeg|JPG|JPEG|png';
	                $config['file_name']           	= $cek->id_admin;
	                $config['max_size']           	= 100000000000;

	                $this->load->library('upload', $config);

	                if ( ! $this->upload->do_upload())
	                {
	                    $this->session->set_flashdata('foto_gagal', 'Gagal, format foto tidak sesuai!');

						redirect('admin/profile_admin/'.$id_admin.'');
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
		                $config['new_image']= './file/profile/admin/';
		                $this->load->library('image_lib', $config);
		                $this->image_lib->resize();

		            	$simpan_foto = $config['file_name'].$foto['file_ext'];

						$this->db->query("UPDATE tbl_admin SET foto = '$simpan_foto' WHERE id_admin = '$id_admin'");

						$this->session->set_flashdata('foto_berhasil', 'Berhasil disimpan!');
						redirect('admin/profile_admin/'.$id_admin.'');
					}
				}else{
					$gambar_lama = $this->input->post('foto_lama');

					$path = './file/profile/admin/';
					$config['upload_path']          = $path;
	                $config['allowed_types']        = 'jpg|jpeg|JPG|JPEG|png';
	                $config['file_name']           	= $cek->id_admin;

	                $this->load->library('upload', $config);

	                @unlink($path.$gambar_lama);

	                if ( ! $this->upload->do_upload())
	                {
	                    $this->session->set_flashdata('foto_gagal', 'Gagal, format foto tidak sesuai!');

						redirect('admin/profile_admin/'.$id_admin.'');

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
		                $config['new_image']= './file/profile/admin/';
		                $this->load->library('image_lib', $config);
		                $this->image_lib->resize();

		            	$simpan_foto = $config['file_name'].$foto['file_ext'];

						$this->db->query("UPDATE tbl_admin SET foto = '$simpan_foto' WHERE id_admin = '$id_admin'");

						$this->session->set_flashdata('foto_berhasil', 'Berhasil disimpan!');

						redirect('admin/profile_admin/'.$id_admin.'');
					}
				}
			}
		}
		else
		{
			header('location:'.base_url().'index.php/web');	
		}
	}

	public function hapus_foto_admin()
	{
		$cek  = $this->session->userdata('logged_in');
		$stts = $this->session->userdata('status');
		if(!empty($cek) && $stts=='Admin' || $stts=='Super Admin')
		{
			$id_admin = $this->uri->segment(3);

			$cek_foto = $this->web_app_model->getWhereData('tbl_admin','id_admin',$id_admin);

			foreach ($cek_foto->result() as $cek) {

				if($cek->foto=='default.png'){

					redirect('admin/profile_admin/'.$id_admin.'');
					
				}else if($cek->foto!=NULL){
					$path = './file/profile/admin/';
					$gambar_lama = $this->uri->segment(4);

					$config['upload_path']          = $path;

					$this->load->library('upload', $config);

	                @unlink($path.$gambar_lama);

					$this->db->query("UPDATE tbl_admin SET foto = 'default.png' WHERE id_admin = '$id_admin'");

					$this->session->set_flashdata('foto_hapus', 'Foto berhasil dihapus!');
					redirect('admin/profile_admin/'.$id_admin.'');
				}
			}
		}
		else
		{
			header('location:'.base_url().'index.php/web');	
		}
	}

	public function update_profile_admin()
	{
		$cek  = $this->session->userdata('logged_in');
		$stts = $this->session->userdata('status');
		if(!empty($cek) && $stts=='Admin' || $stts=='Super Admin')
		{
			$id_admin							= $this->input->post("id_admin");
			$simpan_profile['nama_admin']		= $this->input->post("nama");
			$simpan_login['nama']				= $this->input->post("nama");
			$simpan_profile['jk']				= $this->input->post("jk");
			$simpan_profile['tempat_lahir']		= $this->input->post("tempat_lahir");
			$simpan_profile['tanggal_lahir']	= $this->input->post("tanggal_lahir");
			$simpan_profile['alamat']			= $this->input->post("alamat");

			$this->web_app_model->updateData('tbl_admin',$simpan_profile,'id_admin',$id_admin);
			$this->web_app_model->updateData('tbl_login',$simpan_login,'id_admin',$id_admin);

			$this->session->set_flashdata('berhasil', 'Berhasil disimpan!');
			redirect('admin/profile_admin/'.$id_admin.'');

		}
		else
		{
			header('location:'.base_url().'index.php/web');	
		}
	}

	public function update_akun_admin()
	{
		$cek  = $this->session->userdata('logged_in');
		$stts = $this->session->userdata('status');
		if(!empty($cek) && $stts=='Admin' || $stts=='Super Admin')
		{
			$id_admin						= $this->input->post("id_admin");
			$user_baru						= $this->input->post("username");
			$user_lama						= $this->input->post("user_lama");		
			$password						= $this->input->post("password");
			$password2						= $this->input->post("password2");

			if(strcmp($user_lama, $user_baru)==0){
				if(strcmp($password, $password2)==0){
					$simpan_profile['password']		= md5($password);
					$this->web_app_model->updateData('tbl_admin',$simpan_profile,'id_admin',$id_admin);

					$this->web_app_model->updateData('tbl_login',$simpan_profile,'id_admin',$id_admin);

					$this->session->set_flashdata('berhasil', 'Berhasil disimpan!');

					redirect('admin/profile_admin/'.$id_admin.'#akun');

					
				} else if(strcmp($password, $password2)!=0){
					$this->session->set_flashdata('gagal', 'Password tidak sama!');

					redirect('admin/profile_admin/'.$id_admin.'#akun');
				}
			}else{
				if(strcmp($password, $password2)==0 && $this->web_app_model->cekData('tbl_login','username',$user_baru)==0){
					$simpan_profile['username']		= $user_baru;
					$simpan_profile['password']		= md5($password);
					$this->web_app_model->updateData('tbl_admin',$simpan_profile,'id_admin',$id_admin);

					$this->web_app_model->updateData('tbl_login',$simpan_profile,'id_admin',$id_admin);

					$this->session->set_flashdata('berhasil', 'Berhasil disimpan!');

					redirect('admin/profile_admin/'.$id_admin.'#akun');

				} else if($this->web_app_model->cekData('tbl_login','username',$user_baru)==1){
					$this->session->set_flashdata('gagal', 'Nama pengguna sudah terdaftar!');

					redirect('admin/profile_admin/'.$id_admin.'#akun');
				} else if(strcmp($password, $password2)!=0){
					$this->session->set_flashdata('gagal', 'Password tidak sama!');

					redirect('admin/profile_admin/'.$id_admin.'#akun');
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
		if(!empty($cek) && $stts=='Admin' || $stts=='Super Admin')
		{
			$bc['nama'] = $this->session->userdata('nama');
			$bc['status'] = $this->session->userdata('status');
			$bc['id_admin'] = $this->session->userdata('id_admin');
			$bc['title'] = "Pesan";
			
			$sess = $this->web_app_model->getWhereData('tbl_admin','id_admin',$bc['id_admin']);
			foreach ($sess->result() as $sess) {
				$bc['nama']			= $sess->nama_admin;
				$bc['foto']			= $sess->foto;
				$bc['username'] 	= $sess->username;
			}
			$bc['header'] = $this->load->view('admin/header',$bc,true);
			$bc['footer'] = $this->load->view('admin/footer',$bc,true);


			$get_self = $this->web_app_model->getWhereData('tbl_login','id_admin',$bc['id_admin']);
			foreach ($get_self->result() as $get) {
				$id_login = $get->id_login;
			}

			if($this->uri->segment(3)=="masuk"){
				$bc['ambil_pesan'] = $this->web_app_model->getPesan($id_login);
				$bc['hitung_pesan'] = $this->web_app_model->HitungPesanPengirim($id_login);
				$bc['menu'] = $this->load->view('admin/menu',$bc,true);
				$bc['hitung_pesan_detail'] = $this->web_app_model->HitungPesanPengirim($id_login);
				
				$this->load->view('admin/view_pesan_masuk',$bc);		
			} else if($this->uri->segment(3)=="keluar"){
				$bc['ambil_pesan'] = $this->web_app_model->getPesanKeluar($id_login);
				$bc['hitung_pesan'] = $this->web_app_model->HitungPesanPengirim($id_login);
				$bc['menu'] = $this->load->view('admin/menu',$bc,true);	

				$this->load->view('admin/view_pesan_keluar',$bc);		
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
		if(!empty($cek) && $stts=='Admin' || $stts=='Super Admin')
		{
			$bc['nama'] = $this->session->userdata('nama');
			$bc['status'] = $this->session->userdata('status');
			$bc['id_admin'] = $this->session->userdata('id_admin');
			$bc['title'] = "Pesan";
			
			$sess = $this->web_app_model->getWhereData('tbl_admin','id_admin',$bc['id_admin']);
			foreach ($sess->result() as $sess) {
				$bc['nama']			= $sess->nama_admin;
				$bc['foto']			= $sess->foto;
				$bc['username'] 	= $sess->username;
			}
			$bc['header'] = $this->load->view('admin/header',$bc,true);
			$bc['footer'] = $this->load->view('admin/footer',$bc,true);


			$get_self = $this->web_app_model->getWhereData('tbl_login','id_admin',$bc['id_admin']);
			foreach ($get_self->result() as $get) {
				$id_login = $get->id_login;
			}

			$get_self = $this->web_app_model->getWhereData('tbl_login','id_admin',$bc['id_admin']);
			foreach ($get_self->result() as $get) {
				$id_login = $get->id_login;
			}
			$bc['hitung_pesan'] = $this->web_app_model->HitungPesanPengirim($id_login);
			$bc['menu'] = $this->load->view('admin/menu',$bc,true);

			$pengirim = $this->uri->segment(3);

			$bc['det_pesan'] = $this->web_app_model->getPesanDetail($id_login,$pengirim);

			$update['opened'] = 1;

			$this->web_app_model->updateTripleWhere('tbl_pesan',$update,'type_id',1,'owner_id',$id_login,'sender_receiver_id',$pengirim);
			
			$this->load->view('admin/view_pesan_detail',$bc);			
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
		if(!empty($cek) && $stts=='Admin' || $stts=='Super Admin')
		{
			$bc['id_admin'] = $this->session->userdata('id_admin');

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

				$get_self = $this->web_app_model->getWhereData('tbl_login','id_admin',$bc['id_admin']);
				foreach ($get_self->result() as $get) {
					$simpan_pengirim['owner_id'] 			= $get->id_login;
					$simpan_penerima['sender_receiver_id']  = $get->id_login;
				}

				$this->web_app_model->insertData('tbl_pesan',$simpan_pengirim);
				$this->web_app_model->insertData('tbl_pesan',$simpan_penerima);
				
				redirect('admin/tampil_pesan_detail/'.$simpan_pengirim['sender_receiver_id'].'');		
			}else if($this->uri->segment(3)=="baru"){
				$bc['nama'] = $this->session->userdata('nama');
				$bc['status'] = $this->session->userdata('status');
				$bc['id_admin'] = $this->session->userdata('id_admin');
				$bc['title'] = "Kirim Pesan";
				
				$get_self = $this->web_app_model->getWhereData('tbl_login','id_admin',$bc['id_admin']);
				foreach ($get_self->result() as $get) {
					$id_login = $get->id_login;
				}
				$sess = $this->web_app_model->getWhereData('tbl_admin','id_admin',$bc['id_admin']);
				foreach ($sess->result() as $sess) {
					$bc['nama']			= $sess->nama_admin;
					$bc['foto']			= $sess->foto;
					$bc['username'] 	= $sess->username;
				}
				$bc['hitung_pesan'] = $this->web_app_model->HitungPesanPengirim($id_login);
				$bc['menu'] = $this->load->view('admin/menu',$bc,true);
				$bc['header'] = $this->load->view('admin/header',$bc,true);
				$bc['footer'] = $this->load->view('admin/footer',$bc,true);

				$this->load->view('admin/view_kirim_pesan',$bc);
			} else if($this->uri->segment(3)=="kirim"){
				
				$bc['username'] = $this->session->userdata('nama');
				
				$bc['nama'] = $this->session->userdata('nama');
				$bc['status'] = $this->session->userdata('status');
				$bc['id_admin'] = $this->session->userdata('id_admin');
				$bc['title'] = "Pesan";

				$get_self = $this->web_app_model->getWhereData('tbl_login','id_admin',$bc['id_admin']);
				foreach ($get_self->result() as $get) {
					$id_login = $get->id_login;
				}
				$sess = $this->web_app_model->getWhereData('tbl_admin','id_admin',$bc['id_admin']);
				foreach ($sess->result() as $sess) {
					$bc['nama']			= $sess->nama_admin;
					$bc['foto']			= $sess->foto;
					$bc['username'] 	= $sess->username;
				}
				$bc['hitung_pesan'] = $this->web_app_model->HitungPesanPengirim($id_login);
				$bc['menu'] = $this->load->view('admin/menu',$bc,true);
				$bc['header'] = $this->load->view('admin/header',$bc,true);
				$bc['footer'] = $this->load->view('admin/footer',$bc,true);

				$username = $this->input->post('username');

				$ambil = $this->web_app_model->getData('tbl_login','id_login');
				foreach ($ambil->result_array() as $row) {
					$user = $row['nama'];

					if(strcmp($bc['username'],$user)==0){
						if(strcmp($username,$user)==0){
							$this->session->set_flashdata('gagal', 'Tidak bisa mengirim pesan ke akun sendiri!');
							redirect('admin/kirim_pesan/baru');
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

						$get_self = $this->web_app_model->getWhereData('tbl_login','id_admin',$bc['id_admin']);
						foreach ($get_self->result() as $get) {
							$simpan_pengirim['owner_id'] 			= $get->id_login;
							$simpan_penerima['sender_receiver_id']  = $get->id_login;
						}

						$this->web_app_model->insertData('tbl_pesan',$simpan_pengirim);
						$this->web_app_model->insertData('tbl_pesan',$simpan_penerima);

						$this->session->set_flashdata('berhasil', 'Pesan berhasil terkirim');
						redirect('admin/tampil_pesan/keluar');
					} 
				}
				$no_recipient = $this->web_app_model->cekData('tbl_login','nama',$username);
				if($no_recipient==0){
					$this->session->set_flashdata('gagal', 'Nama pengirim tidak terdaftar!');
					redirect('admin/kirim_pesan/baru');
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
		if(!empty($cek) && $stts=='Admin' || $stts=='Super Admin')
		{
			$bc['id_admin'] = $this->session->userdata('id_admin');
			$pesan 	= $this->uri->segment(4);

			$tipe = $this->uri->segment(3);

			if($tipe == "satu"){
				$id_pesan = $this->uri->segment(5);

				$this->web_app_model->deleteData('tbl_pesan','id',$id_pesan);
				redirect('admin/tampil_pesan_detail/'.$pesan.'');		
			} else if($tipe == "masuk"){
				$get_self = $this->web_app_model->getWhereData('tbl_login','id_admin',$bc['id_admin']);
				foreach ($get_self->result() as $get) {
					$owner_id 			= $get->id_login;
				}
				$sender = $this->uri->segment(4);

				$this->web_app_model->deleteMultipleWhere('adminpesan','owner_id',$owner_id,'sender_receiver_id',$sender);
				redirect('admin/tampil_pesan/masuk');
			} else if($tipe == "keluar"){
				$get_self = $this->web_app_model->getWhereData('tbl_login','id_admin',$bc['id_admin']);
				foreach ($get_self->result() as $get) {
					$owner_id 			= $get->id_login;
				}
				$sender = $this->uri->segment(4);

				$this->web_app_model->deleteMultipleWhere('tbl_pesan','owner_id',$owner_id,'sender_receiver_id',$sender);
				redirect('admin/tampil_pesan/keluar');
			}
		}
		else
		{
			header('location:'.base_url().'index.php/web');	
		}
	}

	public function siswa()
	{	
		$cek  = $this->session->userdata('logged_in');
		$stts = $this->session->userdata('status');
		if(!empty($cek) && $stts=='Admin' || $stts=='Super Admin')
		{
			$data['status'] = $this->session->userdata('status');
			$id_admin = $this->session->userdata('id_admin');
			$data['title'] = "Data Siswa";

			$sess = $this->web_app_model->getWhereData('tbl_admin','id_admin',$id_admin);
			foreach ($sess->result() as $sess) {
				$data['nama']			= $sess->nama_admin;
				$data['foto']			= $sess->foto;
				$data['username'] 	= $sess->username;
			}

			$get_self = $this->web_app_model->getWhereData('tbl_login','id_admin',$id_admin);
			foreach ($get_self->result() as $get) {
				$id_login = $get->id_login;
			}
			$data['hitung_pesan'] = $this->web_app_model->HitungPesanPengirim($id_login);
			$data['menu'] = $this->load->view('admin/menu',$data,true);

			$data['header'] = $this->load->view('admin/header',$data,true);
			$data['footer'] = $this->load->view('admin/footer',$data,true);

			$data['kelas'] = $this->web_app_model->getAllKelas();
			$data['data_siswa']	= $this->web_app_model->getAllDataSiswa('tbl_siswa');

			$this->load->view('admin/view_siswa',$data);		
		}
		else
		{
			header('location:'.base_url().'index.php/web/logout');	
		}
	}

	public function daftar_siswa()
	{
		$cek  = $this->session->userdata('logged_in');
		$stts = $this->session->userdata('status');
		if(!empty($cek) && $stts=='Admin' || $stts=='Super Admin')
		{
			$simpan_login["username"] 					= $this->input->post("username");
			$simpan_login["password"] 					= md5($this->input->post("password"));
			$simpan_login["status"] 					= "Siswa";
			$simpan_login["nama"]			 			= $this->input->post("nama_siswa");
			$simpan_siswa["nis"]			 			= $this->input->post("nis");
			$simpan_siswa["nama_siswa"]			 		= $this->input->post("nama_siswa");
			$simpan_siswa["jk"]			 				= $this->input->post("jk");
			$simpan_siswa["tahun_masuk"]				= $this->input->post("tahun_masuk");
			$simpan_siswa["kelas"]						= $this->input->post("kelas");
			$simpan_siswa["username"]	 				= $this->input->post("username");	
			$simpan_siswa["password"]	 				= md5($this->input->post("password"));	

			if($this->web_app_model->cekData('tbl_siswa','nis',$simpan_siswa["nis"])==0 && $this->web_app_model->cekData('tbl_login','username',$simpan_siswa["username"])==0)
			{
				if($simpan_siswa["jk"]=='L'){
					$simpan_siswa["foto"] 					= "siswa.png";
				} else if($simpan_siswa["jk"]=='P'){
					$simpan_siswa["foto"] 					= "siswi.png";
				}
				$this->web_app_model->insertData('tbl_siswa',$simpan_siswa);

				$id_siswa	=	$this->web_app_model->getSelectedData('tbl_siswa','id_siswa','nis',$simpan_siswa["nis"])->result();

				foreach ($id_siswa as $id_sis) {
					$simpan_login["id_siswa"] = $id_sis->id_siswa;	
				}
				

				$this->web_app_model->insertData('tbl_login',$simpan_login);

				$this->session->set_flashdata('berhasil', 'Berhasil disimpan!');
				redirect('admin/siswa');
			}
			else if($this->web_app_model->cekData('tbl_siswa','nis',$simpan_siswa["nis"])==1)
			{
				$this->session->set_flashdata('gagal', 'Gagal, NIS telah terdaftar!');
				redirect('admin/siswa');
							
			}
			else if($this->web_app_model->cekData('tbl_login','username',$simpan_siswa["username"])==1)
			{
				$this->session->set_flashdata('gagal', 'Gagal, Nama pengguna telah terdaftar!');
				redirect('admin/siswa');
			}
		}
	}

	public function profile_siswa()
	{
		$cek  = $this->session->userdata('logged_in');
		$stts = $this->session->userdata('status');
		if(!empty($cek) && $stts=='Admin' || $stts=='Super Admin')
		{
			$bc['status'] = $this->session->userdata('status');
			$bc['title'] = "Profil Siswa";
			$id_admin = $this->session->userdata('id_admin');

			$sess = $this->web_app_model->getWhereData('tbl_admin','id_admin',$id_admin);
			foreach ($sess->result() as $sess) {
				$bc['nama']			= $sess->nama_admin;
				$bc['foto']			= $sess->foto;
				$bc['username'] 	= $sess->username;
			}
			
			$get_self = $this->web_app_model->getWhereData('tbl_login','id_admin',$id_admin);
			foreach ($get_self->result() as $get) {
				$id_login = $get->id_login;
			}
			$bc['hitung_pesan'] = $this->web_app_model->HitungPesanPengirim($id_login);
			$bc['menu'] = $this->load->view('admin/menu',$bc,true);			
			$bc['header'] = $this->load->view('admin/header',$bc,true);
			$bc['footer'] = $this->load->view('admin/footer',$bc,true);
			
			$bc['data_siswa']	= $this->web_app_model->getEditSiswa($this->uri->segment(3));
			$bc['kelas'] = $this->web_app_model->getAllKelas();

			$bc['mapel'] = $this->web_app_model->getMapelRekap($this->uri->segment(4));
			
			$this->load->view('admin/view_profile_siswa',$bc);			
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
		if(!empty($cek) && $stts=='Admin' || $stts=='Super Admin')
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

						redirect('admin/profile_siswa/'.$id_siswa.'');
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

						$this->session->set_flashdata('foto_berhasil', 'Berhasil disimpan!');
						redirect('admin/profile_siswa/'.$id_siswa.'');
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

						redirect('admin/profile_siswa/'.$id_siswa.'');

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

						$this->session->set_flashdata('foto_berhasil', 'Berhasil disimpan!');

						redirect('admin/profile_siswa/'.$id_siswa.'');
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
		if(!empty($cek) && $stts=='Admin' || $stts=='Super Admin')
		{
			$id_siswa = $this->uri->segment(3);
			$jk = $this->uri->segment(5);

			$cek_foto = $this->web_app_model->getWhereData('tbl_siswa','id_siswa',$id_siswa);

			foreach ($cek_foto->result() as $cek) {

				if($cek->foto=='siswa.png' || $cek->foto=='siswi.png'){

					redirect('admin/profile_siswa/'.$id_siswa.'');
					
				}else{
					$path = './file/profile/siswa/';
					$gambar_lama = $this->uri->segment(4);

					$config['upload_path']          = $path;

					$this->load->library('upload', $config);

	                @unlink($path.$gambar_lama);

	                if($jk=='P'){
						$this->db->query("UPDATE tbl_siswa SET foto = 'siswi.png' WHERE id_siswa = '$id_siswa'");
					} else if($jk=='L'){
						$this->db->query("UPDATE tbl_siswa SET foto = 'siswa.png' WHERE id_siswa = '$id_siswa'");
					}

					$this->session->set_flashdata('foto_hapus', 'Foto berhasil dihapus!');
					redirect('admin/profile_siswa/'.$id_siswa.'');
				}
			}
		}
		else
		{
			header('location:'.base_url().'index.php/web');	
		}
	}

	public function update_profile_siswa()
	{
		$cek  = $this->session->userdata('logged_in');
		$stts = $this->session->userdata('status');
		if(!empty($cek) && $stts=='Admin' || $stts=='Super Admin')
		{
			$id_siswa							= $this->input->post("id_siswa");
			$simpan_login['nama']				= $this->input->post("nama");
			$simpan_profile['nama_siswa']		= $this->input->post("nama");
			$simpan_profile['jk']				= $this->input->post("jk");
			$simpan_profile['tahun_masuk']		= $this->input->post("tahun_masuk");
			$simpan_profile['kelas']			= $this->input->post("kelas");
			$simpan_profile['tempat_lahir']		= $this->input->post("tempat_lahir");
			$simpan_profile['tanggal_lahir']	= $this->input->post("tanggal_lahir");
			$simpan_profile['alamat']			= $this->input->post("alamat");

			$nis_lama = $this->input->post("nis_lama");
			$nis_baru = $this->input->post("nis");

			if(strcmp($nis_lama,$nis_baru)==0){
				$this->web_app_model->updateData('tbl_siswa',$simpan_profile,'id_siswa',$id_siswa);
				$this->web_app_model->updateData('tbl_login',$simpan_login,'id_siswa',$id_siswa);

				$this->session->set_flashdata('berhasil', 'Berhasil disimpan!');
				redirect('admin/profile_siswa/'.$id_siswa.'');

			}else if(strcmp($nis_lama,$nis_baru)!=0 && $this->web_app_model->cekData('tbl_siswa','nis',$nis_baru)==0){
				$simpan_profile['nis'] = $nis_baru;
				$this->web_app_model->updateData('tbl_siswa',$simpan_profile,'id_siswa',$id_siswa);
				$this->web_app_model->updateData('tbl_login',$simpan_login,'id_siswa',$id_siswa);

				$this->session->set_flashdata('berhasil', 'Berhasil disimpan!');
				redirect('admin/profile_siswa/'.$id_siswa.'');
			}else if(strcmp($nis_lama,$nis_baru)!=0 && $this->web_app_model->cekData('tbl_siswa','nis',$nis_baru)==1){
				$this->session->set_flashdata('gagal', 'Gagal, NIS telah terdaftar!');
				redirect('admin/profile_siswa/'.$id_siswa.'');
			}
		}
		else
		{
			header('location:'.base_url().'index.php/web');	
		}
	}

	public function update_akun_siswa()
	{
		$cek  = $this->session->userdata('logged_in');
		$stts = $this->session->userdata('status');
		if(!empty($cek) && $stts=='Admin' || $stts=='Super Admin')
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

					foreach ($idsiswa as $id_sis) {
						$simpan_login["id_siswa"] = $id_sis->id_siswa;	
					}

					$this->web_app_model->updateData('tbl_login',$simpan_profile,'id_siswa',$id_siswa);

					$this->session->set_flashdata('berhasil', 'Berhasil disimpan!');

					redirect('admin/profile_siswa/'.$id_siswa.'#akun');

					
				} else if(strcmp($password, $password2)!=0){
					$this->session->set_flashdata('gagal', 'Password tidak sama!');

					redirect('admin/profile_siswa/'.$id_siswa.'#akun');
				}
			}else{
				if(strcmp($password, $password2)==0 && $this->web_app_model->cekData('tbl_login','username',$user_baru)==0){
					$simpan_profile['username']		= $user_baru;
					$simpan_profile['password']		= md5($password);
					$this->web_app_model->updateData('tbl_siswa',$simpan_profile,'id_siswa',$id_siswa);

					$idsiswa	=	$this->web_app_model->getSelectedData('tbl_siswa','id_siswa','nis',$nis)->result();

					foreach ($idsiswa as $id_sis) {
						$simpan_login["id_siswa"] = $id_sis->id_siswa;	
					}

					$this->web_app_model->updateData('tbl_login',$simpan_profile,'id_siswa',$id_siswa);

					$this->session->set_flashdata('berhasil', 'Berhasil disimpan!');

					redirect('admin/profile_siswa/'.$id_siswa.'#akun');

				} else if($this->web_app_model->cekData('tbl_login','username',$user_baru)==1){
					$this->session->set_flashdata('gagal', 'Nama pengguna sudah terdaftar!');

					redirect('admin/profile_siswa/'.$id_siswa.'#akun');
				} else if(strcmp($password, $password2)!=0){
					$this->session->set_flashdata('gagal', 'Password tidak sama!');

					redirect('admin/profile_siswa/'.$id_siswa.'#akun');
				}
			}


		}
		else
		{
			header('location:'.base_url().'index.php/web');	
		}
	}

	public function rekap_nilai()
	{
		$cek  = $this->session->userdata('logged_in');
		$stts = $this->session->userdata('status');
		if(!empty($cek) && $stts=='Admin' || $stts=='Super Admin')
		{
			$bc['status'] = $this->session->userdata('status');
			$bc['title'] = "Rekap Nilai";
			$id_admin = $this->session->userdata('id_admin');

			$sess = $this->web_app_model->getWhereData('tbl_admin','id_admin',$id_admin);
			foreach ($sess->result() as $sess) {
				$bc['nama']		= $sess->nama_admin;
				$bc['foto']			= $sess->foto;
				$bc['username'] 	= $sess->username;
			}
			$get_self = $this->web_app_model->getWhereData('tbl_login','id_admin',$id_admin);
			foreach ($get_self->result() as $get) {
				$id_login = $get->id_login;
			}
			$bc['hitung_pesan'] = $this->web_app_model->HitungPesanPengirim($id_login);
			$bc['menu'] = $this->load->view('admin/menu',$bc,true);
			
			$bc['header'] = $this->load->view('admin/header',$bc,true);
			$bc['footer'] = $this->load->view('admin/footer',$bc,true);

			$bc['id_siswa']		= $this->uri->segment(3);
			$bc['id_kelas']		= $this->uri->segment(4);
			$bc['id_mapel']		= $this->uri->segment(5);
			$nm_mapel			= $this->web_app_model->getSelectedData('tbl_mapel','nama_mapel','id_mapel',$bc['id_mapel']);

			foreach ($nm_mapel->result() as $nmmapel) {
				$bc['nama_mapel']	= $nmmapel->nama_mapel;
			}

			$bc['tugas'] = $this->web_app_model->getMultipleWhere('tbl_tugas','id_kelas',$bc['id_kelas'],'id_mapel',$bc['id_mapel']);

			$bc['skor'] = $this->web_app_model->getRekapNilai($bc['id_siswa']);
			
			$this->load->view('admin/rekap_siswa',$bc);			
		}
		else
		{
			header('location:'.base_url().'index.php/web');	
		}
	}

	public function hapus_siswa()
	{
		$cek  = $this->session->userdata('logged_in');
		$stts = $this->session->userdata('status');
		if(!empty($cek) && $stts=='Admin' || $stts=='Super Admin')
		{
			$id = $this->uri->segment(3);
			$this->web_app_model->deleteData('tbl_siswa','username',$id);
			$this->web_app_model->deleteData('tbl_login','username',$id);

			$this->session->set_flashdata('berhasil', 'Data berhasil dihapus!');
			header('location:'.base_url().'index.php/admin/siswa');
		}
		else
		{
			header('location:'.base_url().'index.php/web');	
		}
	}

	public function guru()
	{	
		$cek  = $this->session->userdata('logged_in');
		$stts = $this->session->userdata('status');
		if(!empty($cek) && $stts=='Admin' || $stts=='Super Admin')
		{
			$data['status'] = $this->session->userdata('status');
			$data['title'] = "Data Guru";
			$id_admin = $this->session->userdata('id_admin');

			$sess = $this->web_app_model->getWhereData('tbl_admin','id_admin',$id_admin);
			foreach ($sess->result() as $sess) {
				$data['nama']		= $sess->nama_admin;
				$data['foto']			= $sess->foto;
				$data['username'] 	= $sess->username;
			}
			$data['data_guru']	= $this->web_app_model->getAllDataGuru('tbl_guru');

			$get_self = $this->web_app_model->getWhereData('tbl_login','id_admin',$id_admin);
			foreach ($get_self->result() as $get) {
				$id_login = $get->id_login;
			}
			$data['hitung_pesan'] = $this->web_app_model->HitungPesanPengirim($id_login);
			$data['menu'] = $this->load->view('admin/menu',$data,true);
			$data['header'] = $this->load->view('admin/header',$data,true);
			$data['footer'] = $this->load->view('admin/footer',$data,true);

			$this->load->view('admin/view_guru',$data);		
		}
		else
		{
			header('location:'.base_url().'index.php/web/logout');	
		}

		
	}

	public function daftar_guru()
	{
		$cek  = $this->session->userdata('logged_in');
		$stts = $this->session->userdata('status');
		if(!empty($cek) && $stts=='Admin' || $stts=='Super Admin')
		{
			$simpan_login["username"] 					= $this->input->post("username");
			$simpan_login["password"] 					= md5($this->input->post("username"));
			$simpan_login["status"] 					= "Guru";
			$simpan_login["nama"]				 		= $this->input->post("nama_guru");
			$simpan_guru["nip"]			 				= $this->input->post("nip");
			$simpan_guru["nama_guru"]			 		= $this->input->post("nama_guru");
			$simpan_guru["jk"]			 				= $this->input->post("jk");
			$simpan_guru["username"]	 				= $this->input->post("username");	
			$simpan_guru["password"]	 				= md5($this->input->post("password"));	
			
			if($this->web_app_model->cekData('tbl_guru','nip',$simpan_guru["nip"])==0 && $this->web_app_model->cekData('tbl_guru','username',$simpan_guru["username"])==0)
			{
				if($simpan_guru["jk"]=='L'){
					$simpan_guru["foto"] 					= "gurul.png";
				} else if($simpan_guru["jk"]=='P'){
					$simpan_guru["foto"] 					= "gurup.png";
				}
				$this->web_app_model->insertData('tbl_guru',$simpan_guru);
				
				$id_guru	=	$this->web_app_model->getSelectedData('tbl_guru','id_guru','nip',$simpan_guru["nip"])->result();

				foreach ($id_guru as $id_gr) {
					$simpan_login["id_guru"] = $id_gr->id_guru;	
				}

				$this->web_app_model->insertData('tbl_login',$simpan_login);

				$this->session->set_flashdata('berhasil', 'Berhasil disimpan!');
				header('location:'.base_url().'index.php/admin/guru');
			}
			else if($this->web_app_model->cekData('tbl_guru','nip',$simpan_guru["nip"])==1)
			{
				$this->session->set_flashdata('gagal', 'Gagal, NIP telah terdaftar!');
				header('location:'.base_url().'index.php/admin/guru');
			}
			else if($this->web_app_model->cekData('tbl_guru','username',$simpan_guru["username"])==1)
			{
				$this->session->set_flashdata('gagal', 'Nama Pengguna telah terdaftar!');
				header('location:'.base_url().'index.php/admin/guru');
			}
		}
	}

	public function profile_guru()
	{
		$cek  = $this->session->userdata('logged_in');
		$stts = $this->session->userdata('status');
		if(!empty($cek) && $stts=='Admin' || $stts=='Super Admin')
		{
			$bc['status'] = $this->session->userdata('status');
			$bc['title'] = "Profil Guru";
			$id_admin = $this->session->userdata('id_admin');

			$sess = $this->web_app_model->getWhereData('tbl_admin','id_admin',$id_admin);
			foreach ($sess->result() as $sess) {
				$bc['nama']			= $sess->nama_admin;
				$bc['foto']			= $sess->foto;
				$bc['username'] 	= $sess->username;
			}
			
			$get_self = $this->web_app_model->getWhereData('tbl_login','id_admin',$id_admin);
			foreach ($get_self->result() as $get) {
				$id_login = $get->id_login;
			}
			$bc['hitung_pesan'] = $this->web_app_model->HitungPesanPengirim($id_login);
			$bc['menu'] = $this->load->view('admin/menu',$bc,true);			
			$bc['header'] = $this->load->view('admin/header',$bc,true);
			$bc['footer'] = $this->load->view('admin/footer',$bc,true);
			
			$bc['data_guru']	= $this->web_app_model->getEditguru($this->uri->segment(3));
			$bc['hari']			= $this->web_app_model->getHari();
			$bc['jadwal'] 		= $this->web_app_model->getJadwal($this->uri->segment(3));
			$bc['kelas'] 		= $this->web_app_model->getAllKelasChild('tbl_kelas');
			$bc['kelas2'] 		= $this->web_app_model->getAllKelasChild('tbl_kelas');
			$bc['mapel'] 		= $this->web_app_model->getAllDataMapel('tbl_mapel');
			$bc['mapel2'] 		= $this->web_app_model->getAllDataMapel('tbl_mapel');
			
			$this->load->view('admin/view_profile_guru',$bc);			
		}
		else
		{
			header('location:'.base_url().'index.php/web');	
		}
	}

	public function update_profile_guru()
	{
		$cek  = $this->session->userdata('logged_in');
		$stts = $this->session->userdata('status');
		if(!empty($cek) && $stts=='Admin' || $stts=='Super Admin')
		{
			$id_guru							= $this->input->post("id_guru");
			$simpan_login['nama']				= $this->input->post("nama");
			$simpan_profile['nama_guru']		= $this->input->post("nama");
			$simpan_profile['jk']				= $this->input->post("jk");
			$simpan_profile['tempat_lahir']		= $this->input->post("tempat_lahir");
			$simpan_profile['tanggal_lahir']	= $this->input->post("tanggal_lahir");
			$simpan_profile['alamat']			= $this->input->post("alamat");

			$nip_lama = $this->input->post("nip_lama");
			$nip_baru = $this->input->post("nip");

			if(strcmp($nip_lama,$nip_baru)==0){
				$this->web_app_model->updateData('tbl_guru',$simpan_profile,'id_guru',$id_guru);
				$this->web_app_model->updateData('tbl_login',$simpan_login,'id_guru',$id_guru);

				$this->session->set_flashdata('berhasil', 'Berhasil disimpan!');
				redirect('admin/profile_guru/'.$id_guru.'');

			}else if(strcmp($nip_lama,$nip_baru)!=0 && $this->web_app_model->cekData('tbl_guru','nip',$nip_baru)==0){
				$simpan_profile['nip'] = $nip_baru;
				$this->web_app_model->updateData('tbl_guru',$simpan_profile,'id_guru',$id_guru);
				$this->web_app_model->updateData('tbl_login',$simpan_login,'id_guru',$id_guru);

				$this->session->set_flashdata('berhasil', 'Berhasil disimpan!');
				redirect('admin/profile_guru/'.$id_guru.'');
			}else if(strcmp($nip_lama,$nip_baru)!=0 && $this->web_app_model->cekData('tbl_guru','nip',$nip_baru)==1){
				$this->session->set_flashdata('gagal', 'Gagal, NIP telah terdaftar!');
				redirect('admin/profile_guru/'.$id_guru.'');
			}
		}
		else
		{
			header('location:'.base_url().'index.php/web');	
		}
	}

	public function update_akun_guru()
	{
		$cek  = $this->session->userdata('logged_in');
		$stts = $this->session->userdata('status');
		if(!empty($cek) && $stts=='Admin' || $stts=='Super Admin')
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

					redirect('admin/profile_guru/'.$id_guru.'#akun');

					
				} else if(strcmp($password, $password2)!=0){
					$this->session->set_flashdata('gagal', 'Password tidak sama!');

					redirect('admin/profile_guru/'.$id_guru.'#akun');
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

					redirect('admin/profile_guru/'.$id_guru.'#akun');

				} else if($this->web_app_model->cekData('tbl_login','username',$user_baru)==1){
					$this->session->set_flashdata('gagal', 'Nama pengguna sudah terdaftar!');

					redirect('admin/profile_guru/'.$id_guru.'#akun');
				} else if(strcmp($password, $password2)!=0){
					$this->session->set_flashdata('gagal', 'Password tidak sama!');

					redirect('admin/profile_guru/'.$id_guru.'#akun');
				}
			}


		}
		else
		{
			header('location:'.base_url().'index.php/web');	
		}
	}

	public function simpan_foto_guru()
	{
		$cek  = $this->session->userdata('logged_in');
		$stts = $this->session->userdata('status');
		if(!empty($cek) && $stts=='Admin' || $stts=='Super Admin')
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

						redirect('admin/profile_guru/'.$id_guru.'');
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

						$this->session->set_flashdata('foto_berhasil', 'Berhasil disimpan!');
						redirect('admin/profile_guru/'.$id_guru.'');
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

						redirect('admin/profile_guru/'.$id_guru.'');

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

						$this->session->set_flashdata('foto_berhasil', 'Berhasil disimpan!');

						redirect('admin/profile_guru/'.$id_guru.'');
					}
				}
			}
		}
		else
		{
			header('location:'.base_url().'index.php/web');	
		}
	}

	public function hapus_foto_guru()
	{
		$cek  = $this->session->userdata('logged_in');
		$stts = $this->session->userdata('status');
		if(!empty($cek) && $stts=='Admin' || $stts=='Super Admin')
		{
			$id_guru = $this->uri->segment(3);
			$jk = $this->uri->segment(5);

			$cek_foto = $this->web_app_model->getWhereData('tbl_guru','id_guru',$id_guru);

			foreach ($cek_foto->result() as $cek) {

				if($cek->foto=='gurul.png' || $cek->foto=='gurup.png'){

					redirect('admin/profile_guru/'.$id_guru.'');
					
				}else{
					$path = './file/profile/guru/';
					$gambar_lama = $this->uri->segment(4);

					$config['upload_path']          = $path;

					$this->load->library('upload', $config);

	                @unlink($path.$gambar_lama);

	                if($jk=='P'){
						$this->db->query("UPDATE tbl_guru SET foto = 'gurup.png' WHERE id_guru = '$id_guru'");
					} else if($jk=='L'){
						$this->db->query("UPDATE tbl_guru SET foto = 'gurul.png' WHERE id_guru = '$id_guru'");
					}

					$this->session->set_flashdata('foto_hapus', 'Foto berhasil dihapus!');
					redirect('admin/profile_guru/'.$id_guru.'');
				}
			}
		}
		else
		{
			header('location:'.base_url().'index.php/web');	
		}
	}

	public function simpan_jadwal_guru()
	{
		$cek  = $this->session->userdata('logged_in');
		$stts = $this->session->userdata('status');
		if(!empty($cek) && $stts=='Admin' || $stts=='Super Admin')
		{
			$simpan_jadwal["hari_id"]		= $this->input->post("id_hari");
			$simpan_jadwal["id_kelas"]		= $this->input->post("kelas");
			$simpan_kelas["id_kelas"]		= $this->input->post("kelas");
			$simpan_jadwal["id_mapel"]		= $this->input->post("mapel");
			$simpan_kelas["id_mapel"]		= $this->input->post("mapel");
			$simpan_jadwal["jam_mulai"]		= $this->input->post("jam_mulai");
			$simpan_jadwal["jam_selesai"]	= $this->input->post("jam_selesai");
			$simpan_jadwal["id_guru"]		= $this->input->post("id_guru");
			$simpan_kelas["id_guru"]		= $this->input->post("id_guru");

			$id_guru = $this->uri->segment(3);

			$this->web_app_model->insertData('tbl_mapel_ajar',$simpan_jadwal);
			$this->web_app_model->insertData('tbl_kelas_ajar',$simpan_kelas);

			$this->session->set_flashdata('berhasil', 'Berhasil disimpan!');
			redirect('admin/profile_guru/'.$id_guru.'#jadwal');
		}
		else
		{
			header('location:'.base_url().'index.php/web');	
		}
	}

	public function update_jadwal_guru()
	{
		$cek  = $this->session->userdata('logged_in');
		$stts = $this->session->userdata('status');
		if(!empty($cek) && $stts=='Admin' || $stts=='Super Admin')
		{
			$simpan_jadwal["id"]			= $this->input->post("id");
			$simpan_jadwal["id_kelas"]		= $this->input->post("kelas");
			$simpan_kelas["id_kelas"]		= $this->input->post("kelas");
			$simpan_jadwal["id_mapel"]		= $this->input->post("mapel");
			$simpan_kelas["id_mapel"]		= $this->input->post("mapel");
			$simpan_jadwal["jam_mulai"]		= $this->input->post("jam_mulai");
			$simpan_jadwal["jam_selesai"]	= $this->input->post("jam_selesai");
			$simpan_kelas["id_guru"]		= $this->uri->segment(3);
			$kelas_lama						= $this->input->post("kelas_lama");
			$mapel_lama						= $this->input->post("mapel_lama");

			$this->web_app_model->updateData('tbl_mapel_ajar',$simpan_jadwal,'id',$simpan_jadwal["id"]);

			$ambil = $this->web_app_model->getTripleWhere('tbl_kelas_ajar','id_kelas',$kelas_lama,'id_mapel',$mapel_lama,'id_guru',$simpan_kelas["id_guru"]);

			foreach ($ambil->result() as $ambil) {
				$id_kelas_ajar = $ambil->id;
				$this->web_app_model->updateData('tbl_kelas_ajar',$simpan_kelas,'id',$id_kelas_ajar);
			}

			$id_guru = $this->uri->segment(3);
			$this->session->set_flashdata('berhasil', 'Berhasil disimpan!');
			redirect('admin/profile_guru/'.$id_guru.'#jadwal');
		}
		else
		{
			header('location:'.base_url().'index.php/web');	
		}
	}

	public function hapus_jadwal_guru()
	{
		$cek  = $this->session->userdata('logged_in');
		$stts = $this->session->userdata('status');
		if(!empty($cek) && $stts=='Admin' || $stts=='Super Admin')
		{
			$id_jadwal	= $this->uri->segment(3);
			$id_guru	= $this->uri->segment(4);
			$id_kelas	= $this->uri->segment(5);
			$id_mapel	= $this->uri->segment(6);

			$this->web_app_model->deleteData('tbl_mapel_ajar','id',$id_jadwal);
			$this->web_app_model->deleteMultipleWhere('tbl_kelas_ajar','id_kelas',$id_kelas,'id_mapel',$id_mapel);

			$this->session->set_flashdata('berhasil', 'Data berhasil dihapus!');
			redirect('admin/profile_guru/'.$id_guru.'#jadwal');
		}
		else
		{
			header('location:'.base_url().'index.php/web');	
		}
	}

	public function hapus_guru()
	{
		$cek  = $this->session->userdata('logged_in');
		$stts = $this->session->userdata('status');
		if(!empty($cek) && $stts=='Admin' || $stts=='Super Admin')
		{
			$id = $this->uri->segment(3);
			$this->web_app_model->deleteData('tbl_guru','id_guru',$id);
			$this->web_app_model->deleteData('tbl_login','id_guru',$id);
			header('location:'.base_url().'index.php/admin/guru');
		}
		else
		{
			header('location:'.base_url().'index.php/web');	
		}
	}

	public function kelas()
	{	
		$cek  = $this->session->userdata('logged_in');
		$stts = $this->session->userdata('status');
		if(!empty($cek) && $stts=='Admin' || $stts=='Super Admin')
		{
			$data['status'] = $this->session->userdata('status');
			$data['title'] = "Manajemen Kelas";
			$id_admin = $this->session->userdata('id_admin');

			$sess = $this->web_app_model->getWhereData('tbl_admin','id_admin',$id_admin);
			foreach ($sess->result() as $sess) {
				$data['nama']		= $sess->nama_admin;
				$data['foto']			= $sess->foto;
				$data['username'] 	= $sess->username;
			}

			$data['kelas_parent']	= $this->web_app_model->getAllDataKelasParent('tbl_kelas',NULL);
			$data['wali_kelas']	= $this->web_app_model->getAllDataGuru('tbl_guru');
			$data['wali_kelas2'] = $this->web_app_model->getData('tbl_guru','id_guru');
			$data['kelas1']	= $this->web_app_model->getAllDataKelasChild(1);
			$data['kelas2']	= $this->web_app_model->getAllDataKelasChild(2);
			$data['kelas3']	= $this->web_app_model->getAllDataKelasChild(3);

			$get_self = $this->web_app_model->getWhereData('tbl_login','id_admin',$id_admin);
			foreach ($get_self->result() as $get) {
				$id_login = $get->id_login;
			}
			$data['hitung_pesan'] = $this->web_app_model->HitungPesanPengirim($id_login);
			$data['menu'] = $this->load->view('admin/menu',$data,true);
			$data['header'] = $this->load->view('admin/header',$data,true);
			$data['footer'] = $this->load->view('admin/footer',$data,true);

			$this->load->view('admin/view_kelas',$data);		
		}
		else
		{
			header('location:'.base_url().'index.php/web/logout');	
		}
	}

	public function tambah_kelas()
	{
		$cek  = $this->session->userdata('logged_in');
		$stts = $this->session->userdata('status');
		if(!empty($cek) && $stts=='Admin' || $stts=='Super Admin')
		{
			$simpan_kelas["nama_kelas"]	= $this->input->post("nama_kelas");	
			$simpan_kelas["wali_kelas"]	= $this->input->post("wali_kelas");	
			
			if($this->web_app_model->cekData('tbl_kelas','nama_kelas',$simpan_kelas["nama_kelas"])==0)
			{
				if(substr($simpan_kelas["nama_kelas"], 0, 4)=="VII " || substr($simpan_kelas["nama_kelas"], 0, 4)=="vii "){
					$simpan_kelas["parent"] = 1;
					$this->web_app_model->insertData('tbl_kelas',$simpan_kelas);

					$this->session->set_flashdata('berhasil', 'Berhasil disimpan!');
					header('location:'.base_url().'index.php/admin/kelas');
				}else if(substr($simpan_kelas["nama_kelas"], 0, 4)=="VIII" || substr($simpan_kelas["nama_kelas"], 0, 4)=="viii"){
					$simpan_kelas["parent"] = 2;
					$this->web_app_model->insertData('tbl_kelas',$simpan_kelas);

					$this->session->set_flashdata('berhasil', 'Berhasil disimpan!');
					header('location:'.base_url().'index.php/admin/kelas');
				}else if(substr($simpan_kelas["nama_kelas"], 0, 2)=="IX" || substr($simpan_kelas["nama_kelas"], 0, 2)=="ix"){
					$simpan_kelas["parent"] = 3;
					$this->web_app_model->insertData('tbl_kelas',$simpan_kelas);

					$this->session->set_flashdata('berhasil', 'Berhasil disimpan!');
					header('location:'.base_url().'index.php/admin/kelas');
				}else{
					$this->session->set_flashdata('gagal', 'Gagal! Format kelas tidak sesuai');
					header('location:'.base_url().'index.php/admin/kelas');
				}
			}else{
				$this->session->set_flashdata('gagal', 'Gagal! Nama Kelas sudah terdaftar');
				header('location:'.base_url().'index.php/admin/kelas');	
			}
		}
	}

	public function edit_kelas()
	{
		$cek  = $this->session->userdata('logged_in');
		$stts = $this->session->userdata('status');
		if(!empty($cek) && $stts=='Admin' || $stts=='Super Admin')
		{
			$simpan_kelas["id_kelas"]	= $this->input->post("id_kelas");	
			$simpan_kelas["nama_kelas"]	= $this->input->post("nama_kelas");	
			$simpan_kelas["wali_kelas"]	= $this->input->post("wali_kelas");	
			$kelaslama					= $this->input->post("kelas_lama");

			$ambil_nama = $this->web_app_model->getSelectedData("tbl_mapel","nama_mapel","id_mapel",$simpan["id_mapel"]);
			$cek_nama = strcmp($ambil_nama, $simpan["nama_mapel"]);
			
			if($this->web_app_model->cekData('tbl_kelas','nama_kelas',$simpan_kelas["nama_kelas"])==0 || strcmp($kelaslama,$simpan_kelas["nama_kelas"])==0)
			{
				if(substr($simpan_kelas["nama_kelas"], 0, 4)=="VII " || substr($simpan_kelas["nama_kelas"], 0, 4)=="vii "){
					$simpan_kelas["parent"] = 1;
					$this->web_app_model->updateData('tbl_kelas',$simpan_kelas,"id_kelas",$simpan_kelas["id_kelas"]);

					$this->session->set_flashdata('berhasil', 'Berhasil disimpan!');
					header('location:'.base_url().'index.php/admin/kelas');
				}else if(substr($simpan_kelas["nama_kelas"], 0, 4)=="VIII" || substr($simpan_kelas["nama_kelas"], 0, 4)=="viii"){
					$simpan_kelas["parent"] = 2;
					$this->web_app_model->updateData('tbl_kelas',$simpan_kelas,"id_kelas",$simpan_kelas["id_kelas"]);

					$this->session->set_flashdata('berhasil', 'Berhasil disimpan!');
					header('location:'.base_url().'index.php/admin/kelas');
				}else if(substr($simpan_kelas["nama_kelas"], 0, 2)=="IX" || substr($simpan_kelas["nama_kelas"], 0, 2)=="ix"){
					$simpan_kelas["parent"] = 3;
					$this->web_app_model->updateData('tbl_kelas',$simpan_kelas,"id_kelas",$simpan_kelas["id_kelas"]);

					$this->session->set_flashdata('berhasil', 'Berhasil disimpan!');
					header('location:'.base_url().'index.php/admin/kelas');
				}else{
					$this->session->set_flashdata('gagal', 'Gagal! Format kelas tidak sesuai');
					header('location:'.base_url().'index.php/admin/kelas');
				}
			}else{
				$this->session->set_flashdata('gagal', 'Gagal! Nama Kelas sudah terdaftar');
				header('location:'.base_url().'index.php/admin/kelas');
			}
		}
	}

	public function hapus_kelas()
	{
		$cek  = $this->session->userdata('logged_in');
		$stts = $this->session->userdata('status');
		if(!empty($cek) && $stts=='Admin' || $stts=='Super Admin')
		{
			$id = $this->uri->segment(3);
			$this->web_app_model->deleteData('tbl_kelas','id_kelas',$id);

			$this->session->set_flashdata('berhasil', 'Kelas berhasil dihapus!');
			header('location:'.base_url().'index.php/admin/kelas');
		}
		else
		{
			header('location:'.base_url().'index.php/web');	
		}
	}

	public function mapel_kelas()
	{	
		$cek  = $this->session->userdata('logged_in');
		$stts = $this->session->userdata('status');
		if(!empty($cek) && $stts=='Admin' || $stts=='Super Admin')
		{
			$data['status'] = $this->session->userdata('status');
			$data['title'] = "Mata Pelajaran Kelas";
			$id_admin = $this->session->userdata('id_admin');

			$sess = $this->web_app_model->getWhereData('tbl_admin','id_admin',$id_admin);
			foreach ($sess->result() as $sess) {
				$data['nama']			= $sess->nama_admin;
				$data['foto']			= $sess->foto;
				$data['username'] 		= $sess->username;
			}
			$data['kelas_parent']	= $this->web_app_model->getAllDataKelasParent('tbl_kelas',NULL);
			$data['wali_kelas']	= $this->web_app_model->getAllDataGuru('tbl_guru');
			$data['kelas1']	= $this->web_app_model->getAllDataKelasChild(1);
			$data['kelas2']	= $this->web_app_model->getAllDataKelasChild(2);
			$data['kelas3']	= $this->web_app_model->getAllDataKelasChild(3);

			$get_self = $this->web_app_model->getWhereData('tbl_login','id_admin',$id_admin);
			foreach ($get_self->result() as $get) {
				$id_login = $get->id_login;
			}
			$data['hitung_pesan'] = $this->web_app_model->HitungPesanPengirim($id_login);
			$data['menu'] = $this->load->view('admin/menu',$data,true);
			$data['header'] = $this->load->view('admin/header',$data,true);
			$data['footer'] = $this->load->view('admin/footer',$data,true);

			$this->load->view('admin/view_kelas_mapel',$data);		
		}
		else
		{
			header('location:'.base_url().'index.php/web/logout');	
		}
	}

	public function mapel_kelas_detail()
	{
		$cek  = $this->session->userdata('logged_in');
		$stts = $this->session->userdata('status');
		if(!empty($cek) && $stts=='Admin' || $stts=='Super Admin')
		{
			$bc['status'] = $this->session->userdata('status');
			$bc['title'] = "Mata Pelajaran Kelas";
			$id_admin = $this->session->userdata('id_admin');

			$sess = $this->web_app_model->getWhereData('tbl_admin','id_admin',$id_admin);
			foreach ($sess->result() as $sess) {
				$bc['nama']			= $sess->nama_admin;
				$bc['foto']			= $sess->foto;
				$bc['username'] 	= $sess->username;
			}
			$get_self = $this->web_app_model->getWhereData('tbl_login','id_admin',$id_admin);
			foreach ($get_self->result() as $get) {
				$id_login = $get->id_login;
			}
			$bc['hitung_pesan'] = $this->web_app_model->HitungPesanPengirim($id_login);
			$bc['menu'] = $this->load->view('admin/menu',$bc,true);
			$bc['header'] = $this->load->view('admin/header',$bc,true);
			$bc['footer'] = $this->load->view('admin/footer',$bc,true);
			
			$kelas = $this->uri->segment(3);

			$bc['hari'] = $this->web_app_model->getHari();
			$bc['kelas2'] = $this->web_app_model->getWhereData('tbl_kelas','id_kelas',$kelas);
			$bc['jadwal'] = $this->web_app_model->getJadwalKelas($kelas);

			$this->load->view('admin/view_kelas_mapel_detail',$bc);			
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
		if(!empty($cek) && $stts=='Admin' || $stts=='Super Admin')
		{
			$bc['status'] = $this->session->userdata('status');
			$bc['title'] = "Tambah Jadwal";
			$id_admin = $this->session->userdata('id_admin');

			$sess = $this->web_app_model->getWhereData('tbl_admin','id_admin',$id_admin);
			foreach ($sess->result() as $sess) {
				$bc['nama']			= $sess->nama_admin;
				$bc['foto']			= $sess->foto;
				$bc['username'] 	= $sess->username;
			}

			$get_self = $this->web_app_model->getWhereData('tbl_login','id_admin',$id_admin);
			foreach ($get_self->result() as $get) {
				$id_login = $get->id_login;
			}
			$bc['hitung_pesan'] = $this->web_app_model->HitungPesanPengirim($id_login);
			$bc['menu'] = $this->load->view('admin/menu',$bc,true);
			
			$bc['header'] = $this->load->view('admin/header',$bc,true);
			$bc['footer'] = $this->load->view('admin/footer',$bc,true);

			$kelas = $this->uri->segment(3);
			$bc['kelas2'] = $this->web_app_model->getWhereData('tbl_kelas','id_kelas',$kelas);

			$bc['mapel'] = $this->web_app_model->getAllDataMapel('tbl_mapel');
			$bc['guru'] = $this->web_app_model->getAllDataGuru('tbl_guru');
			
			$this->load->view('admin/view_tambah_jadwal',$bc);			
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
		if(!empty($cek) && $stts=='Admin' || $stts=='Super Admin')
		{
			$simpan_jadwal["hari_id"]		= $this->input->post("hari_id");
			$simpan_jadwal["id_kelas"]		= $this->input->post("id_kelas");
			$simpan_kelas["id_kelas"]		= $this->input->post("id_kelas");
			$simpan_jadwal["id_mapel"]		= $this->input->post("mapel");
			$simpan_kelas["id_mapel"]		= $this->input->post("mapel");
			$simpan_jadwal["jam_mulai"]		= $this->input->post("jam_mulai");
			$simpan_jadwal["jam_selesai"]	= $this->input->post("jam_selesai");
			$simpan_jadwal["id_guru"]		= $this->input->post("id_guru");
			$simpan_kelas["id_guru"]		= $this->input->post("id_guru");

			$this->web_app_model->insertData('tbl_mapel_ajar',$simpan_jadwal);
			$this->web_app_model->insertData('tbl_kelas_ajar',$simpan_kelas);

			$uri3 = $this->uri->segment(3);

			redirect('admin/mapel_kelas_detail/'.$uri3.'');
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
		if(!empty($cek) && $stts=='Admin' || $stts=='Super Admin')
		{
			$bc['status'] = $this->session->userdata('status');
			$bc['title'] = "Sunting Jadwal";
			$id_admin = $this->session->userdata('id_admin');

			$sess = $this->web_app_model->getWhereData('tbl_admin','id_admin',$id_admin);
			foreach ($sess->result() as $sess) {
				$bc['nama']			= $sess->nama_admin;
				$bc['foto']			= $sess->foto;
				$bc['username'] 	= $sess->username;
			}

			$get_self = $this->web_app_model->getWhereData('tbl_login','id_admin',$id_admin);
			foreach ($get_self->result() as $get) {
				$id_login = $get->id_login;
			}
			$bc['hitung_pesan'] = $this->web_app_model->HitungPesanPengirim($id_login);
			$bc['menu'] = $this->load->view('admin/menu',$bc,true);
			
			$bc['header'] = $this->load->view('admin/header',$bc,true);
			$bc['footer'] = $this->load->view('admin/footer',$bc,true);

			$kelas = $this->uri->segment(3);
			$bc['kelas2'] = $this->web_app_model->getWhereData('tbl_kelas','id_kelas',$kelas);

			$bc['kelas'] = $this->web_app_model->getAllKelasChild('tbl_kelas');
			$bc['mapel'] = $this->web_app_model->getAllDataMapel('tbl_mapel');
			$bc['guru'] = $this->web_app_model->getAllDataGuru('tbl_guru');

			$id = $this->uri->segment(5);
			$bc['edit_jadwal'] = $this->web_app_model->getWhereData('tbl_mapel_ajar','id',$id);
			
			$this->load->view('admin/view_edit_jadwal',$bc);			
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
		if(!empty($cek) && $stts=='Admin' || $stts=='Super Admin')
		{
			$simpan_jadwal["id"]			= $this->input->post("id");
			$simpan_jadwal["id_mapel"]		= $this->input->post("mapel");
			$simpan_kelas["id_mapel"]		= $this->input->post("mapel");
			$simpan_jadwal["jam_mulai"]		= $this->input->post("jam_mulai");
			$simpan_jadwal["jam_selesai"]	= $this->input->post("jam_selesai");
			$simpan_jadwal["id_guru"]		= $this->input->post("id_guru");
			$simpan_kelas["id_guru"]		= $this->input->post("id_guru");
			$kelas_lama						= $this->input->post("id_kelas");
			$mapel_lama						= $this->input->post("mapel_lama");

			$this->web_app_model->updateData('tbl_mapel_ajar',$simpan_jadwal,'id',$simpan_jadwal["id"]);
			$this->web_app_model->updateMultipleWhere('tbl_kelas_ajar',$simpan_kelas,'id_kelas',$kelas_lama,'id_mapel',$mapel_lama);

			$uri3 = $this->uri->segment(3);

			redirect('admin/mapel_kelas_detail/'.$uri3.'');
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
		if(!empty($cek) && $stts=='Admin' || $stts=='Super Admin')
		{
			$id_jadwal	= $this->uri->segment(3);
			$id_kelas	= $this->uri->segment(4);
			$id_mapel	= $this->uri->segment(5);

			$this->web_app_model->deleteData('tbl_mapel_ajar','id',$id_jadwal);
			$this->web_app_model->deleteMultipleWhere('tbl_kelas_ajar','id_kelas',$id_kelas,'id_mapel',$id_mapel);
			redirect('admin/mapel_kelas_detail/'.$id_kelas.'');
		}
		else
		{
			header('location:'.base_url().'index.php/web');	
		}
	}

	public function mapel()
	{	
		$cek  = $this->session->userdata('logged_in');
		$stts = $this->session->userdata('status');
		if(!empty($cek) && $stts=='Admin' || $stts=='Super Admin')
		{
			$data['status'] = $this->session->userdata('status');
			$data['title'] = "Mata Pelajaran";
			$id_admin = $this->session->userdata('id_admin');

			$sess = $this->web_app_model->getWhereData('tbl_admin','id_admin',$id_admin);
			foreach ($sess->result() as $sess) {
				$data['nama']			= $sess->nama_admin;
				$data['foto']			= $sess->foto;
				$data['username'] 	= $sess->username;
			}

			$data['data_mapel']	= $this->web_app_model->getAllDataMapel('tbl_mapel');

			$get_self = $this->web_app_model->getWhereData('tbl_login','id_admin',$id_admin);
			foreach ($get_self->result() as $get) {
				$id_login = $get->id_login;
			}
			$data['hitung_pesan'] = $this->web_app_model->HitungPesanPengirim($id_login);
			$data['menu'] = $this->load->view('admin/menu',$data,true);

			$data['header'] = $this->load->view('admin/header',$data,true);
			$data['footer'] = $this->load->view('admin/footer',$data,true);

			$this->load->view('admin/view_mapel',$data);		
		}
		else
		{
			header('location:'.base_url().'index.php/web/logout');	
		}
	}

	public function tambah_mapel()
	{
		$cek  = $this->session->userdata('logged_in');
		$stts = $this->session->userdata('status');
		if(!empty($cek) && $stts=='Admin' || $stts=='Super Admin')
		{
			$simpan_mapel["kd_mapel"]	= $this->input->post("kd_mapel");	
			$simpan_mapel["nama_mapel"]	= $this->input->post("nama_mapel");	
			
			if($this->web_app_model->cekData('tbl_mapel','kd_mapel',$simpan_mapel["kd_mapel"])==0 && $this->web_app_model->cekData('tbl_mapel','nama_mapel',$simpan_mapel["nama_mapel"])==0)
			{
				$this->web_app_model->insertData('tbl_mapel',$simpan_mapel);

				$this->session->set_flashdata('berhasil', 'Berhasil disimpan!');
				header('location:'.base_url().'index.php/admin/mapel');
			}else{
				$this->session->set_flashdata('gagal', 'Kode Mapel/Nama Mapel sudah terdaftar!');
				header('location:'.base_url().'index.php/admin/mapel');
			}
		}
	}

	public function edit_mapel()
	{
		$cek  = $this->session->userdata('logged_in');
		$stts = $this->session->userdata('status');
		if(!empty($cek) && $stts=='Admin' || $stts=='Super Admin')
		{
			$simpan["id_mapel"] 			= $this->input->post("id_mapel");
			$simpan["kd_mapel"] 			= $this->input->post("kd_mapel");
			$simpan["nama_mapel"] 			= $this->input->post("nama_mapel");
			
			$ambil_kd 	= $this->web_app_model->getSelectedData("tbl_mapel","kd_mapel","id_mapel",$simpan["id_mapel"]);
			$cek_kd = strcmp($ambil_kd, $simpan["kd_mapel"]);
			$ambil_nama = $this->web_app_model->getSelectedData("tbl_mapel","nama_mapel","id_mapel",$simpan["id_mapel"]);
			$cek_nama = strcmp($ambil_nama, $simpan["nama_mapel"]);

			if($this->web_app_model->cekData('tbl_mapel','kd_mapel',$simpan["kd_mapel"])==0 && $this->web_app_model->cekData('tbl_mapel','nama_mapel',$simpan["nama_mapel"])==0)
			{
				$this->web_app_model->updateData('tbl_mapel',$simpan,"id_mapel",$simpan["id_mapel"]);

				$this->session->set_flashdata('berhasil', 'Berhasil disimpan!');
				header('location:'.base_url().'index.php/admin/mapel');
			}else if($cek_kd==0 && $this->web_app_model->cekData('tbl_mapel','nama_mapel',$simpan["nama_mapel"])==0)
			{
				$this->web_app_model->updateData('tbl_mapel',$simpan,"id_mapel",$simpan["id_mapel"]);

				$this->session->set_flashdata('berhasil', 'Berhasil disimpan!');
				header('location:'.base_url().'index.php/admin/mapel');
			}else if($cek_nama==0 && $this->web_app_model->cekData('tbl_mapel','kd_mapel',$simpan["kd_mapel"])==0)
			{
				$this->web_app_model->updateData('tbl_mapel',$simpan,"id_mapel",$simpan["id_mapel"]);

				$this->session->set_flashdata('berhasil', 'Berhasil disimpan!');
				header('location:'.base_url().'index.php/admin/mapel');
			}else{
				$this->session->set_flashdata('gagal', 'Kode Mapel/Nama Mapel sudah terdaftar!');
				header('location:'.base_url().'index.php/admin/mapel');
			}
		}
	}

	public function hapus_mapel()
	{
		$cek  = $this->session->userdata('logged_in');
		$stts = $this->session->userdata('status');
		if(!empty($cek) && $stts=='Admin' || $stts=='Super Admin')
		{
			$id = $this->uri->segment(3);
			$this->web_app_model->deleteData('tbl_mapel','id_mapel',$id);
			$this->web_app_model->deleteData('tbl_mapel_ajar','id_mapel',$id);
			$this->web_app_model->deleteData('tbl_kelas_ajar','id_mapel',$id);

			$this->session->set_flashdata('berhasil', 'Berhasil dihapus!');
			header('location:'.base_url().'index.php/admin/mapel');
		}
		else
		{
			header('location:'.base_url().'index.php/web');	
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
