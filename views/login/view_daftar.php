
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Login</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="http://siad.cs.upi.edu/theme/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="http://siad.cs.upi.edu/theme/bower_components/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="http://siad.cs.upi.edu/theme/bower_components/Ionicons/css/ionicons.min.css">
  <link rel="stylesheet" href="http://siad.cs.upi.edu/theme/dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="http://siad.cs.upi.edu/theme/plugins/iCheck/square/blue.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <link rel="stylesheet" href="<?php echo base_url();?>assets/dist/css/custom.css">
  
 
</head>
<body class="hold-transition login-page">
<div class="container" style="width: 600px;">
<div class="col-md-20">
      
    
  <div class="login-box-body col-sm-10 col-sm-offset-1">
  <div class="login-logo">
    <img width="40px" src="<?php echo base_url();?>assets/logo.png"/><br/><b>E-Learning </b><br/>Tunas Unggul   
  </div>
  </div>

  <!-- /.login-logo -->
  <div class="login-box-body col-sm-10 col-sm-offset-1">
    <div>
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#personal" data-toggle="tab">Daftar Sebagai Siswa</a></li>
              <li><a href="#rekap" data-toggle="tab">Daftar Sebagai Guru</a></li>
            </ul>
            <div class="tab-content">
              <div class="active tab-pane" id="personal">
                <!-- Post -->
                <form action="<?php echo base_url();?>index.php/web/daftar_siswa" onsubmit="return cekform();" method="post">
                  <?php
                    $berhasil = $this->session->flashdata('berhasil');
                    $gagal = $this->session->flashdata('gagal');
                    if(!empty($berhasil))
                    {?>
                      <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <?php echo $berhasil; ?>
                      </div>
                    <?php 
                    } else if(!empty($gagal))
                    {?>
                      
                      <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <?php echo $gagal; ?>
                      </div>
                    <?php 
                    } 
                  ?>
                  <div class="form-group row">
                    <label for="nis" class="col-sm-4 control-label">NIS</label>

                    <div class="col-sm-8">
                      <input type="text" class="form-control" name="nis" id="nis" required />
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="nama_siswa" class="col-sm-4 control-label">Nama Siswa</label>

                    <div class="col-sm-8">
                      <input type="text" class="form-control" name="nama_siswa" id="nama_siswa" required />
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="col-sm-4 control-label">Jenis Kelamin</label>

                    <div class="col-sm-8 radio">
                      <label class="radio inline"><input type="radio" name="jk" value="L" required /> Laki-laki</label>
                      &nbsp;
                      <label class="radio inline"><input type="radio" name="jk" value="P" /> Perempuan</label>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="tahun_masuk" class="col-sm-4 control-label">Tahun Masuk</label>

                    <div class="col-sm-8">
                      <input type="number" class="form-control" name="tahun_masuk" id="tahun_masuk" required />
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="col-sm-4 control-label">Kelas</label>

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

                  <div class="form-group row">
                    <label for="username" class="col-sm-4 control-label">Nama Pengguna</label>

                    <div class="col-sm-8">
                      <input type="text" class="form-control" name="username" id="username" required />
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="password" class="col-sm-4 control-label">Kata Sandi</label>

                    <div class="col-sm-8">
                      <input type="password" class="form-control" name="password" id="password" required />
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-xs-8">
                      <div class="checkbox icheck">
                      </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-xs-4">
                      <button type="submit" class="btn btn-primary btn-block btn-flat">Daftar</button>
                    </div>
                    <!-- /.col -->
                  </div>
                </form>
                
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="rekap">
                <!-- The timeline -->
                <form action="<?php echo base_url();?>index.php/web/daftar_guru" onsubmit="return cekform();" method="post">
                  <?php
                    $berhasil = $this->session->flashdata('berhasil');
                    $gagal = $this->session->flashdata('gagal');
                    if(!empty($berhasil))
                    {?>
                      <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <?php echo $berhasil; ?>
                      </div>
                    <?php 
                    } else if(!empty($gagal))
                    {?>
                      
                      <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <?php echo $gagal; ?>
                      </div>
                    <?php 
                    } 
                  ?>
                  <div class="form-group row">
                    <label for="nis" class="col-sm-4 control-label">NIP</label>

                    <div class="col-sm-8">
                      <input type="text" class="form-control" name="nip" id="nip" required />
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="nama_siswa" class="col-sm-4 control-label">Nama</label>

                    <div class="col-sm-8">
                      <input type="text" class="form-control" name="nama_guru" id="nama_guru" required />
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="col-sm-4 control-label">Jenis Kelamin</label>

                    <div class="col-sm-8 radio">
                      <label class="radio inline"><input type="radio" name="jk" value="L" required /> Laki-laki</label>
                      &nbsp;
                      <label class="radio inline"><input type="radio" name="jk" value="P" /> Perempuan</label>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="username" class="col-sm-4 control-label">Nama Pengguna</label>

                    <div class="col-sm-8">
                      <input type="text" class="form-control" name="username" id="username" required />
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="password" class="col-sm-4 control-label">Kata Sandi</label>

                    <div class="col-sm-8">
                      <input type="password" class="form-control" name="password" id="password" required />
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-xs-8">
                      <div class="checkbox icheck">
                      </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-xs-4">
                      <button type="submit" class="btn btn-primary btn-block btn-flat">Daftar</button>
                    </div>
                    <!-- /.col -->
                  </div>
                </form>
               
              </div>
              <!-- /.tab-pane -->
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>

  </div>
  <!-- /.login-box-body -->
</div>
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="http://siad.cs.upi.edu/theme/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="http://siad.cs.upi.edu/theme/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="http://siad.cs.upi.edu/theme/plugins/iCheck/icheck.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script>
</body>
</html>
