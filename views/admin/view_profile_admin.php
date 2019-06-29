   <!-- Header -->

<?php echo $header;?>

  <!-- Side Menu -->

<?php echo $menu;?>

<?php
  foreach ($admin->result_array() as $data){
?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Profil
      </h1>
      <ol class="breadcrumb">
        <strong><script language="JavaScript">document.write(tanggallengkap);</script>
        <i id="output"></i>
        </strong>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="row">
        <div class="col-md-3">
          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive img-circle" src="<?php echo base_url();?>file/profile/admin/<?php echo $data['foto'];?>" alt="User profile picture">

              <p class="text-center" style="margin-top: 5px;">
                <a id="edit_kelas" data-toggle="modal" data-target="#modal_edit">
                  <button class="btn btn-primary btn-sm">
                    Sunting Foto
                  </button>
                </a>
              </p>

              <h3 class="profile-username text-center"><?php echo $data['nama_admin']; ?></h3>

              <p class="text-muted text-center"><?php echo $status; ?></p>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#profil" data-toggle="tab">Profil</a></li>
              <li><a href="#akun" data-toggle="tab">Pengaturan Akun</a></li>
            </ul>
            <div class="tab-content">
              <div class="active tab-pane" id="profil">
                <!-- Post -->
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
                } ?>
                <form class="form-horizontal" method="post" action="<?php echo base_url();?>admin/update_profile_admin">
                  <input type="hidden" id="id_admin" name="id_admin" value="<?php echo $data['id_admin'] ?>">

                  <div class="form-group">
                    <label for="nama" class="col-sm-2 control-label" style="text-align: left; padding-left: 21px;">Nama<font color="red"> *</font></label>

                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $data['nama_admin'] ?>" required>
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-2 control-label" style="text-align: left; padding-left: 21px;">Jenis Kelamin<font color="red"> *</font></label>

                    <div class="col-sm-10 radio">
                      <label class="radio inline"><input type="radio" name="jk" value="L" <?php if($data['jk'] == 'L') echo 'checked';?> required/> Laki-laki</label>
                      &nbsp;
                      <label class="radio inline"><input type="radio" name="jk" value="P" <?php if($data['jk'] == 'P') echo 'checked';?> /> Perempuan</label>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="tempat_lahir" class="col-sm-2 control-label" style="text-align: left; padding-left: 21px;">Tempat Lahir</label>

                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" value="<?php echo $data['tempat_lahir'] ?>" >
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="tanggal_lahir" class="col-sm-2 control-label" style="text-align: left; padding-left: 21px;">Tanggal Lahir</label>

                    <div class="col-sm-10">
                      <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="<?php echo $data['tanggal_lahir'] ?>" >
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="alamat" class="col-sm-2 control-label" style="text-align: left; padding-left: 21px;">Alamat</label>

                    <div class="col-sm-10">
                      <textarea class="form-control" id="alamat" name="alamat"><?php echo $data['alamat'] ?></textarea>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                  </div>
                </form>
                <!-- /.post -->
              </div>

              <div class="tab-pane" id="akun">
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
                <form class="form-horizontal" method="post" action="<?php echo base_url();?>admin/update_akun_admin">
                  <input type="hidden" id="id_admin" name="id_admin" value="<?php echo $data['id_admin'] ?>">
                  <input type="hidden" id="user_lama" name="user_lama" value="<?php echo $data['username'] ?>">

                  <div class="form-group">
                    <label for="username" class="col-sm-3 control-label">Nama Pengguna<font color="red"> *</font></label>

                    <div class="col-sm-8">
                      <input type="text" class="form-control" id="username" name="username" value="<?php echo $data['username'] ?>" required>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="password" class="col-sm-3 control-label">Kata Sandi Baru<font color="red"> *</font></label>

                    <div class="col-sm-8">
                      <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="password2" class="col-sm-3 control-label">Ulangi Kata Sandi<font color="red"> *</font></label>

                    <div class="col-sm-8">
                      <input type="password" class="form-control" id="password2" name="password2" required>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-8">
                      <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                  </div>
                </form>
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>

        <div id="modal_edit" class="modal fade" role="dialog">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;
                </button>
                <h4>Sunting Foto</h4>
              </div>
              <form class="form-horizontal" method="post" action="<?php echo base_url();?>admin/simpan_foto_admin/<?php echo $data['id_admin']; ?>" enctype="multipart/form-data">
                <div class="modal-body" id="edit-body">
                    <?php
                    $foto_berhasil  = $this->session->flashdata('foto_berhasil');
                    $foto_gagal     = $this->session->flashdata('foto_gagal');
                    $foto_hapus     = $this->session->flashdata('foto_hapus');
                    if(!empty($foto_berhasil))
                    {?>
                      <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <?php echo $foto_berhasil; ?>
                      </div>
                    <?php 
                    } else if(!empty($foto_gagal))
                    {?>
                      <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <?php echo $foto_gagal; ?>
                      </div>
                    <?php 
                    } else if(!empty($foto_hapus))
                    {?>
                      <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <?php echo $foto_hapus; ?>
                      </div>
                    <?php 
                    } 
                  ?>
                    <input type="hidden" name="foto_lama" class="form-control" id="foto_lama" value="<?php echo $data['foto'];?>">

                      <table class="table table-striped">
                      <tbody>
                        <tr>
                          <td>
                              <img class="img-polaroid" src="<?php echo base_url();?>file/profile/admin/<?php echo $data['foto'];?>">
                          </td>
                          <td>
                              <input type="file" name="userfile" class="btn btn-small" style="max-width:290px;" required>
                                
                          </td>
                        <tr>
                        <tr>
                            <td colspan="2">
                                <a href="<?php echo base_url();?>admin/hapus_foto_admin/<?php echo $data['id_admin']; ?>/<?php echo $data['foto'];?>" class="pull-right btn btn-default AlertaEliminarCliente"><i class="fa fa-trash-o"></i> Hapus foto</a>

                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </td>
                        </tr>
                      </tbody>
                  </table>
                </div>
              </form>
            </div>
          </div>
        </div>
      <?php } ?>
        <!-- /.col -->
      </div>
      <!-- /.row -->

    </section>
    <!-- /.content -->

     <?php
        $foto_berhasil = $this->session->flashdata('foto_berhasil');
        $foto_gagal    = $this->session->flashdata('foto_gagal');
        $foto_hapus    = $this->session->flashdata('foto_hapus');
        if(!empty($foto_berhasil) || !empty($foto_gagal) || !empty($foto_hapus))
        {?>
          <script type="text/javascript">
            $( document ).ready(function() {
                $('#modal_edit').modal('show');
            });
          </script>
        <?php 
        } 
      ?>
    
  </div>
  <!-- Footer -->
<script src="<?php echo base_url();?>assets/bower_components/jquery/dist/jquery.min.js"></script>
<?php echo $footer;?>