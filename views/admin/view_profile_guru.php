   <!-- Header -->

<?php echo $header;?>

  <!-- Side Menu -->

<?php echo $menu;?>


<?php
  foreach ($data_guru->result_array() as $data){
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
              <img class="profile-user-img img-responsive img-circle" src="
              <?php echo base_url();?>file/profile/guru/<?php echo $data['foto'];?>" alt="User profile picture">

              <p class="text-center" style="margin-top: 5px;">
                <a id="edit_foto" data-toggle="modal" data-target="#modal_foto">
                  <button class="btn btn-primary btn-sm">
                    Sunting Foto
                  </button>
                </a>
              </p>

              <h3 class="profile-username text-center"><?php echo $data['nama_guru']; ?></h3>

              <p class="text-muted text-center"><?php echo $data['nip']; ?></p>
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
              <li><a href="#jadwal" data-toggle="tab">Jadwal Mengajar</a></li>
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
                <form class="form-horizontal" method="post" action="<?php echo base_url();?>admin/update_profile_guru">
                  <input type="hidden" id="id_guru" name="id_guru" value="<?php echo $data['id_guru'] ?>">
                  <input type="hidden" id="nip_lama" name="nip_lama" value="<?php echo $data['nip'] ?>">

                  <div class="form-group">
                    <label for="nip" class="col-sm-2 control-label" style="text-align: left; padding-left: 21px;">NIP<font color="red"> *</font></label>

                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="nip" name="nip" value="<?php echo $data['nip'] ?>" required>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="nama" class="col-sm-2 control-label" style="text-align: left; padding-left: 21px;">Nama<font color="red"> *</font></label>

                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $data['nama_guru'] ?>" required>
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

              <!-- /.tab-pane -->
              <div class="tab-pane" id="jadwal">
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
                <!-- The timeline -->
                <div class="table-responsive">
                  <table class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th style='text-align:center;vertical-align:middle' width="70px"> HARI</th>
                        <th style='text-align:left;vertical-align:middle' colspan="2" width="70px"> MATA PELAJARAN DAN JAM </th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        $parent = 0;
                        foreach ($hari->result_array() as $hari) {
                        $parent++;
                      ?>                      
                      <tr style="background-color: unset;">
                        <th><?php echo $hari['hari']; ?></th>
                        <td style='vertical-align:middle;font-size: 16px;'>
                          <a id="tambah_jadwal" data-toggle="modal" data-target="#modal_jadwal" data-idhari="<?php echo $hari['hari_id']; ?>" data-idguru="<?php echo $data['id_guru']; ?>" data-hari="<?php echo $hari['hari']; ?>">
                            <button class="btn btn-primary" style="font-size: 11px;">TAMBAH</button>
                          </a>
                            <?php 
                              foreach ($jadwal->result_array() as $row) {
                            ?>
                            <?php if($row['hari_id'] == $parent) {
                            ?> 
                              <div style="width: 100%; display: flex; background-color: #d9edf7; margin-top: 5px; align-items: center;">
                                <div style="width: 20%;">
                                  <span><?php echo date('H:i', strtotime($row['jam_mulai']));  ?> - <?php echo date('H:i', strtotime($row['jam_selesai'])); ?></span>
                                </div>
                                <div style="width: 45%;">
                                  <span><?php echo $row['nama_mapel'];  ?></span>
                                </div>
                                <div style="width: 30%;">
                                  <span>KELAS <?php echo $row['nama_kelas'];  ?></span>
                                </div>
                                <div style="width: 30%;">
                                  <span>
                                    <a id="edit_jadwal" data-toggle="modal" data-target="#modal_jadwal_edit" data-idhari="<?php echo $hari['hari_id']; ?>" data-idguru="<?php echo $data['id_guru']; ?>" data-hari="<?php echo $hari['hari']; ?>" data-id="<?php echo $row['id']; ?>" data-idkelas="<?php echo $row['id_kelas']; ?>" data-idmapel="<?php echo $row['id_mapel']; ?>" data-jammulai="<?php echo $row['jam_mulai']; ?>" data-jamselesai="<?php echo $row['jam_selesai']; ?>" class="fa fa-edit" style="cursor: pointer;">
                                      Sunting
                                    </a> | <a href="<?php echo base_url(); ?>admin/hapus_jadwal_guru/<?php echo $row['id']; ?>/<?php echo $data['id_guru']; ?>/<?php echo $row['id_kelas']; ?>/<?php echo $row['id_mapel']; ?>" class="AlertaEliminarCliente fa fa-trash-o"> Hapus</a></span>
                                </div>
                              </div>
                              <?php } ?>
                            <?php } ?>
                        </td>
                      </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                </div>
              </div>
              <!-- /.tab-pane -->

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
                <form class="form-horizontal" method="post" action="<?php echo base_url();?>admin/update_akun_guru">
                  <input type="hidden" id="id_guru" name="id_guru" value="<?php echo $data['id_guru'] ?>">
                  <input type="hidden" id="user_lama" name="user_lama" value="<?php echo $data['username'] ?>">
                  <input type="hidden" id="nip" name="nip" value="<?php echo $data['nip'] ?>">

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

        <div id="modal_foto" class="modal fade" role="dialog">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;
                </button>
                <h4>Sunting Foto</h4>
              </div>
              <form class="form-horizontal" method="post" action="<?php echo base_url();?>admin/simpan_foto_guru/<?php echo $data['id_guru']; ?>" enctype="multipart/form-data">
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
                              <img class="img-polaroid" src="<?php echo base_url();?>file/profile/guru/<?php echo $data['foto'];?>">
                          </td>
                          <td>
                              <input type="file" name="userfile" class="btn btn-small" style="max-width:290px;" required>
                                
                          </td>
                        <tr>
                        <tr>
                            <td colspan="2">
                                <a href="<?php echo base_url();?>admin/hapus_foto_guru/<?php echo $data['id_guru']; ?>/<?php echo $data['foto'];?>/<?php echo $data['jk'];?>" class="pull-right btn btn-default AlertaEliminarCliente"><i class="fa fa-trash-o"></i> Hapus foto</a>

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

        <div id="modal_jadwal" class="modal fade" role="dialog">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;
                </button>
                <h4>Tambah Jadwal</h4>
              </div>
              <form class="form-horizontal" method="post" action="<?php echo base_url();?>admin/simpan_jadwal_guru/<?php echo $data['id_guru']; ?>">
                <div class="modal-body" id="tambah-body">
                  <input type="text" id="id_hari" name="id_hari" hidden>
                  <input type="text" id="id_guru" name="id_guru" hidden>

                  <div class="form-group">
                    <label for="nama_siswa" class="col-sm-3 control-label">Hari</label>

                    <div class="col-sm-8">
                      <input type="text" class="form-control" name="hari" id="hari" readonly />
                    </div>
                  </div>

                  <div class="form-group">
                      <label for="kelas" class="col-sm-3 control-label">Kelas *</label>        

                      <div class="col-sm-8">                   
                        <select name="kelas" id="kelas" class="form-control" required>
                            <option value="">- Pilih -</option>
                            <?php foreach ($kelas->result_array() as $kelas) {
                            ?>
                              <option value="<?php echo $kelas['id_kelas'] ?>"><?php echo $kelas['nama_kelas'] ?></option>
                            <?php } ?>
                        </select>
                      </div>
                  </div>

                  <div class="form-group">
                      <label for="mapel" class="col-sm-3 control-label">Mata Pelajaran *</label>        

                      <div class="col-sm-8">                   
                        <select name="mapel" id="mapel" class="form-control" required>
                            <option value="">- Pilih -</option>
                            <?php foreach ($mapel->result_array() as $mapel) {
                            ?>
                              <option value="<?php echo $mapel['id_mapel'] ?>"><?php echo $mapel['nama_mapel'] ?></option>
                            <?php } ?>
                        </select>
                      </div>
                  </div>
                      
                  <div class="form-group">
                      <label for="jam_mulai" class="col-sm-3 control-label">Jam Mulai *</label>

                      <div class="col-sm-8">
                        <input type="time" id="jam_mulai" name="jam_mulai" class="form-control" required />
                      </div>
                  </div>

                  <div class="form-group">
                      <label for="jam_selesai" class="col-sm-3 control-label">Jam Selesai *</label>

                      <div class="col-sm-8"> 
                        <input type="time" id="jam_selesai" name="jam_selesai" class="form-control" required />
                      </div>
                  </div>
                  
                  <div class="modal-footer">
                      <button type="submit" class="btn btn-primary" name="simpan">Simpan</button>
                      <!-- <input type="submit" id="simpan" name="simpan" value="Simpan" class="btn btn-success" /> -->
                      <button type="reset" class="btn btn-default">Reset</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>

        <div id="modal_jadwal_edit" class="modal fade" role="dialog">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;
                </button>
                <h4>Sunting Jadwal</h4>
              </div>
              <form class="form-horizontal" method="post" action="<?php echo base_url();?>admin/update_jadwal_guru/<?php echo $data['id_guru']; ?>">
                <div class="modal-body" id="edit-body">
                  <input type="text" id="id_hari" name="id_hari" hidden>
                  <input type="text" id="id_guru" name="id_guru" hidden>
                  <input type="text" id="id" name="id" hidden>
                  <input type="text" name="kelas_lama" id="kelas" hidden />
                  <input type="text" name="mapel_lama" id="mapel" hidden />

                  <div class="form-group">
                    <label for="nama_siswa" class="col-sm-3 control-label">Hari</label>

                    <div class="col-sm-8">
                      <input type="text" class="form-control" name="hari" id="hari" readonly />
                    </div>
                  </div>

                  <div class="form-group">
                      <label for="kelas" class="col-sm-3 control-label">Kelas *</label>        

                      <div class="col-sm-8">                   
                        <select name="kelas" id="kelas" class="form-control" required>
                            <option value="">- Pilih -</option>
                            <?php foreach ($kelas2->result_array() as $kelas) {
                            ?>
                              <option value="<?php echo $kelas['id_kelas'] ?>"><?php echo $kelas['nama_kelas'] ?></option>
                            <?php } ?>
                        </select>
                      </div>
                  </div>

                  <div class="form-group">
                      <label for="mapel" class="col-sm-3 control-label">Mata Pelajaran *</label>        

                      <div class="col-sm-8">                   
                        <select name="mapel" id="mapel" class="form-control" required>
                            <option value="">- Pilih -</option>
                            <?php foreach ($mapel2->result_array() as $mapel) {
                            ?>
                              <option value="<?php echo $mapel['id_mapel'] ?>"><?php echo $mapel['nama_mapel'] ?></option>
                            <?php } ?>
                        </select>
                      </div>
                  </div>
                      
                  <div class="form-group">
                      <label for="jam_mulai" class="col-sm-3 control-label">Jam Mulai *</label>

                      <div class="col-sm-8">
                        <input type="time" id="jam_mulai" name="jam_mulai" class="form-control" required />
                      </div>
                  </div>

                  <div class="form-group">
                      <label for="jam_selesai" class="col-sm-3 control-label">Jam Selesai *</label>

                      <div class="col-sm-8"> 
                        <input type="time" id="jam_selesai" name="jam_selesai" class="form-control" required />
                      </div>
                  </div>
                  
                  <div class="modal-footer">
                      <button type="submit" class="btn btn-primary" name="simpan">Simpan</button>
                      <!-- <input type="submit" id="simpan" name="simpan" value="Simpan" class="btn btn-success" /> -->
                      <button type="reset" class="btn btn-default">Reset</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      <?php } ?>

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
                $('#modal_foto').modal('show');
            });
          </script>
        <?php 
        } 
      ?>

      <script type="text/javascript">
        $(document).on("click", "#tambah_jadwal", function(){
            var idhari = $(this).data('idhari');
            var idguru = $(this).data('idguru');
            var hari   = $(this).data('hari');
            $("#tambah-body #id_hari").val(idhari);
            $("#tambah-body #id_guru").val(idguru);
            $("#tambah-body #hari").val(hari);
        })
      </script>

      <script type="text/javascript">
        $(document).on("click", "#edit_jadwal", function(){
            var id          = $(this).data('id');
            var idhari      = $(this).data('idhari');
            var idguru      = $(this).data('idguru');
            var hari        = $(this).data('hari');
            var idkelas     = $(this).data('idkelas');
            var idmapel     = $(this).data('idmapel');
            var jammulai    = $(this).data('jammulai');
            var jamselesai  = $(this).data('jamselesai');
            $("#edit-body #id").val(id);
            $("#edit-body #id_hari").val(idhari);
            $("#edit-body #id_guru").val(idguru);
            $("#edit-body #hari").val(hari);
            $("#edit-body #kelas").val(idkelas);
            $("#edit-body #mapel").val(idmapel);
            $("#edit-body #jam_mulai").val(jammulai);
            $("#edit-body #jam_selesai").val(jamselesai);
        })
      </script>
    
  </div>
  <!-- Footer -->
<script src="<?php echo base_url();?>assets/bower_components/jquery/dist/jquery.min.js"></script>
<?php echo $footer;?>