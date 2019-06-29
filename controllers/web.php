<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Web extends CI_Controller {

	public function _construct()
	{
		session_start();	
	}
	
	
	public function index()
	{
		$cek = $this->session->userdata('logged_in');
		if(empty($cek))
		{
			$this->load->view('login/view_login');	
		}
		else
		{
			$st = $this->session->userdata('status');
			if($st=='Siswa')
			{
				header('location:'.base_url().'index.php/siswa');	
			}
			else if($st=='Guru')
			{
				header('location:'.base_url().'index.php/guru');	
			}
			else if($st=='Admin')
			{
				header('location:'.base_url().'index.php/admin');	
			}
		}
	}
	
	public function daftar()
	{
		$data['kelas'] = $this->web_app_model->getAllKelas();
		$this->load->view('login/view_daftar',$data);	
	}

	public function daftar_siswa_view()
	{
		$this->load->view('login/daftar_siswa');	
	}

	public function daftar_guru_view()
	{
		$this->load->view('login/daftar_guru');	
	}

	public function daftar_siswa()
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

			$this->session->set_flashdata('berhasil', 'Akun berhasil dibuat! Silakan login');
			redirect('web');
		}
		else if($this->web_app_model->cekData('tbl_siswa','nis',$simpan_siswa["nis"])==1)
		{
			$this->session->set_flashdata('gagal', 'Gagal, NIS telah terdaftar!');
			redirect('web/daftar');
						
		}
		else if($this->web_app_model->cekData('tbl_login','username',$simpan_siswa["username"])==1)
		{
			$this->session->set_flashdata('gagal', 'Gagal, Nama pengguna telah terdaftar!');
			redirect('web/daftar');
		}
		
	}

	public function daftar_guru()
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

			$this->session->set_flashdata('berhasil', 'Akun berhasil dibuat! Silakan login');
			redirect('web');
		}
		else if($this->web_app_model->cekData('tbl_guru','nip',$simpan_guru["nip"])==1)
		{
			$this->session->set_flashdata('gagal', 'Gagal, NIP telah terdaftar!');
			redirect('web/daftar#rekap');
		}
		else if($this->web_app_model->cekData('tbl_guru','username',$simpan_guru["username"])==1)
		{
			$this->session->set_flashdata('gagal', 'Nama Pengguna telah terdaftar!');
			redirect('web/daftar#rekap');
		}
		
	}
	
	public function login()
	{
		$u = $this->input->post('username');
		$p = md5($this->input->post('password'));
		$this->web_app_model->getLoginData($u,$p);
	}
	
	public function logout()
	{
		$cek = $this->session->userdata('logged_in');
		if(empty($cek))
		{
			header('location:'.base_url().'index.php/web');	
		}
		else
		{
			$this->session->sess_destroy();
			header('location:'.base_url().'index.php/web');	
		}
	}
	
	
	
	
	
	
	
	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */