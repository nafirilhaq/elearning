<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title>Halaman Masuk</title>

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
		<script type="text/javascript">
			function cekform(){
				if(!$("#username").val()){
					alert('Nama Pengguna tidak boleh kosong');
					$('#username').focus();
					return false;
				}

				if(!$("#password").val()){
					alert('Password tidak boleh kosong');
					$('#password').focus();
					return false;
				}
			}
		</script>
	</head>

	<body class="login-layout">
		<div class="main-container">
			<div class="main-content">
				<div class="row">
					<div class="col-sm-10 col-sm-offset-1">
						<div class="login-container">
							<div class="center">
								<h1>									
									<span class="red">Tunas Unggul</span>
									<p><span class="white" id="id-text2">Kota Bandung</span></p>
								</h1>
							</div>

							<div class="space-6"></div>

							<div class="position-relative">
								<div id="login-box" class="login-box visible widget-box no-border">
									<div class="widget-body">
										<div class="widget-main">
											<h4 class="header blue lighter bigger">
												<i class="ace-icon fa fa-coffee blue"></i>
												Masukkan Informasi Berikut
											</h4>

											<div class="space-6"></div>										

											<form method="POST" action="<?php echo base_url();?>index.php/web/login" onsubmit="return cekform();">
												<fieldset>
													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="text" name="username" id="username" class="form-control" placeholder="Nama Pengguna" />
															<i class="ace-icon fa fa-user"></i>
														</span>
													</label>

													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="password" name="password" id="password" class="form-control" placeholder="Kata Sandi" />												
															<i class="ace-icon fa fa-lock"></i>
														</span>
													</label>

													<label class="block clearfix">
														<?php
															$info = $this->session->flashdata('info');
															if(!empty($info))
															{
																echo $info;
															}
														?>													
													</label>

													<div class="space"></div>

													<div class="clearfix">
														
														<button type="submit" class="width-35 pull-right btn btn-sm btn-primary">
															<i class="ace-icon fa fa-key"></i>
															<span class="bigger-110">Masuk</span>
														</button>
													</div>

													<div class="space-4"></div>
												</fieldset>
											</form>											
										</div><!-- /.widget-main -->

									
										<div class="toolbar clearfix">
											<div></div>
											<div>
												<a href="<?php echo base_url(); ?>index.php/web/daftar" class="white	">
													Daftar
													<i class="ace-icon fa fa-arrow-right"></i>
												</a>
											</div>
										</div>						
										
									</div><!-- /.widget-body -->
								</div><!-- /.login-box -->

								<script type="text/javascript">
									function cekform2(){
										if(!$("#nama2").val()){
											alert('Nama tidak boleh kosong');
											$('#nama').focus();
											return false;
										}

										if(!$("#nisn2").val()){
											alert('Nama Pengguna tidak boleh kosong');
											$('#username').focus();
											return false;
										}

										if(!$("#password2").val()){
											alert('Kata Sandi tidak boleh kosong');
											$('#password').focus();
											return false;
										}
									}
								</script>
								<div id="signup-box" class="signup-box widget-box no-border">
									<div class="widget-body">
										<div class="widget-main">
											<h4 class="header green lighter bigger">
												<i class="ace-icon fa fa-users blue"></i>
												Registrasi
											</h4>

											<div class="space-6"></div>
											<p> <h5>Masukkan Informasi Berikut: </h5></p>

											<form method="POST" action="<?php echo base_url();?>index.php/daftar/get_daftar" onsubmit="return cekform2();">
												<fieldset>
													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="text" name="username2" id="nisn2" class="form-control" placeholder="Nama Pengguna" />
															<i class="ace-icon fa fa-user"></i>
														</span>
													</label>

													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="text" name="nama2" id="nama2" class="form-control" placeholder="Nama" />
															<i class="ace-icon fa fa-user"></i>
														</span>
													</label>

													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="password" name="password2" id="password2" class="form-control" placeholder="Kata Sandi" />
															<i class="ace-icon fa fa-lock"></i>
														</span>
													</label>

													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															Daftar Sebagai															
														</span>
													</label>

													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<select name="jk">
														<option type="radio" value="Laki-laki"> </option>
														<option type="radio" value="Laki-laki"> Siswa</option>
      													<option type="radio" value="Perempuan"> Guru</option>
														</select>
															
														</span>
													</label>

													<div class="space-24"></div>

													<div class="clearfix">
														<button type="reset" class="width-30 pull-left btn btn-sm">
															<i class="ace-icon fa fa-refresh"></i>
															<span class="bigger-110">Reset</span>
														</button>

														<button type="submit" class="width-65 pull-right btn btn-sm btn-success">
															<span class="bigger-110">Daftar</span>

															<i class="ace-icon fa fa-arrow-right icon-on-right"></i>
														</button>
													</div>
												</fieldset>
											</form>
										</div>

										<div class="toolbar center">
											<a href="#" data-target="#login-box" class="back-to-login-link">
												<i class="ace-icon fa fa-arrow-left"></i>
												Masuk
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
