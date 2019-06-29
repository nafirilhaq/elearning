<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title>Daftar Siswa</title>

		<meta name="description" content="User login page" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

		<!-- bootstrap & fontawesome -->
		<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.min.css" />
		<link rel="stylesheet" href="<?php echo base_url();?>assets/font-awesome/4.5.0/css/font-awesome.min.css" />

		<!-- text fonts -->
		<link rel="stylesheet" href="<?php echo base_url();?>assets/css/fonts.googleapis.com.css" />

		<!-- ace styles -->
		<link rel="stylesheet" href="<?php echo base_url();?>assets/css/ace.min.css" />

		<!--[if lte IE 9]>
			<link rel="stylesheet" href="assets/css/ace-part2.min.css" />
		<![endif]-->
		<link rel="stylesheet" href="<?php echo base_url();?>assets/css/ace-rtl.min.css" />

		<!--[if lte IE 9]>
		  <link rel="stylesheet" href="assets/css/ace-ie.min.css" />
		<![endif]-->

		<!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->

		<!--[if lte IE 8]>
		<script src="assets/js/html5shiv.min.js"></script>
		<script src="assets/js/respond.min.js"></script>
		<![endif]-->
	</head>

	<body class="login-layout">
		<div class="main-container">
			<div class="main-content">
				<div class="row">
					<div class="col-sm-10 col-sm-offset-1">
						<div class="login-container">
							<div class="center">
								<a href="<?php echo base_url(); ?>index.php/web">
									<h1>									
										<span class="red">Tunas Unggul</span>
										<p><span class="white" id="id-text2">Kota Bandung</span></p>
									</h1>
								</a>
							</div>

							<div class="space-6"></div>

							<div class="position-relative">
								
								<script type="text/javascript">
									function cekform_siswa(){
										if(!$("#nama_siswa").val()){
											alert('Nama Lengkap tidak boleh kosong');
											$('#nama_siswa').focus();
											return false;
										}

										if(!$("#nis").val()){
											alert('NIS tidak boleh kosong');
											$('#nis').focus();
											return false;
										}

										if(!$("#username").val()){
											alert('Nama Pengguna tidak boleh kosong');
											$('#username').focus();
											return false;
										}

										if(!$("#password").val()){
											alert('Kata Sandi tidak boleh kosong');
											$('#password').focus();
											return false;
										}
									}
								</script>

								<div class="position-relative">
								<div id="login-box" class="signup-box visible widget-box no-border">
									<div class="widget-body">
										<div class="widget-main">
											<h4 class="header green lighter bigger">
												<i class="ace-icon fa fa-users green"></i>
												Registrasi - Siswa
											</h4>

											<div class="space-6"></div>
											<p> <h5>Masukkan Informasi Berikut: </h5></p>

					<form method="POST" action="<?php echo base_url();?>index.php/web/daftar_siswa" onsubmit="return cekform_siswa();">
						<div class="form-group">
                          <label for="nis" class="col-sm-3 control-label">NIS</label>

                          <div class="col-sm-8">
                            <input type="text" class="form-control" name="nis" id="nis" required />
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="nama_siswa" class="col-sm-3 control-label">Nama Siswa</label>

                          <div class="col-sm-8">
                            <input type="text" class="form-control" name="nama_siswa" id="nama_siswa" required />
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="col-sm-3 control-label">Jenis Kelamin</label>

                          <div class="col-sm-8 radio">
                            <label class="radio inline"><input type="radio" name="jk" value="L" required /> Laki-laki</label>
                            &nbsp;
                            <label class="radio inline"><input type="radio" name="jk" value="P" /> Perempuan</label>
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="tahun_masuk" class="col-sm-3 control-label">Tahun Masuk</label>

                          <div class="col-sm-8">
                            <input type="number" class="form-control" name="tahun_masuk" id="tahun_masuk" required />
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="col-sm-3 control-label">Kelas</label>

                          <div class="col-sm-8">
                            <select name="kelas" id="kelas" class="form-control" required>
                                <option value="">Pilih Kelas</option>
                                <?php foreach ($kelas as $row) {
                                ?>
                                  <option value="<?php echo $row->id_kelas; ?>"><?php echo $row->nama_kelas; ?></option>
                                <?php } ?>
                            </select>
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="username" class="col-sm-3 control-label">Nama Pengguna</label>

                          <div class="col-sm-8">
                            <input type="text" class="form-control" name="username" id="username" required />
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="password" class="col-sm-3 control-label">Kata Sandi</label>

                          <div class="col-sm-8">
                            <input type="password" class="form-control" name="password" id="password" required />
                          </div>
                        </div>
											</form>
										</div>

										<div class="toolbar center">
											<a href="<?php echo base_url(); ?>index.php/web/daftar" class="white">
												
													<i class="ace-icon fa fa-arrow-left"></i>
													Kembali
												</h4>
											</a>
										</div>
									</div><!-- /.widget-body -->
								</div><!-- /.signup-box -->
							</div><!-- /.position-relative -->

							
						</div>
					</div><!-- /.col -->
				</div><!-- /.row -->
			</div><!-- /.main-content -->
		</div><!-- /.main-container -->

		<!-- basic scripts -->

		<!--[if !IE]> -->
		<script src="<?php echo base_url();?>assets/js/jquery-2.1.4.min.js"></script>

		<!-- <![endif]-->

		<!--[if IE]>
<script src="assets/js/jquery-1.11.3.min.js"></script>
<![endif]-->
		<script type="text/javascript">
			if('ontouchstart' in document.documentElement) document.write("<script src='<?php echo base_url();?>assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>

		<!-- inline scripts related to this page -->
		<script type="text/javascript">
			jQuery(function($) {
			 $(document).on('click', '.toolbar a[data-target]', function(e) {
				e.preventDefault();
				var target = $(this).data('target');
				$('.widget-box.visible').removeClass('visible');//hide others
				$(target).addClass('visible');//show target
			 });
			});
			
			
			
			
		</script>
	</body>
</html>