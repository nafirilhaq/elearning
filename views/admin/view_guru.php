   <!-- Header -->

<?php echo $header;?>

  <!-- Side Menu -->

<?php echo $menu;?>

 <!-- Main content -->
 <div class="content-wrapper">
  <section class="content-header">
      <h1>
        Data Guru
      </h1>
      <ol class="breadcrumb">
        <strong><script language="JavaScript">document.write(tanggallengkap);</script>
        <i id="output"></i>
        </strong>
      </ol>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
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

              <button class="btn btn-primary" data-toggle="modal" data-target="#tambah_guru" data-backdrop="static">TAMBAH</button>
            </div>

            <div id="tambah_guru" class="modal fade" role="dialog">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;
                    </button>
                    <h4>Tambah Data guru</h4>
                  </div>
                  <form class="form-horizontal" method="post" action="<?php echo base_url();?>index.php/admin/daftar_guru" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-group">
                          <label for="nis" class="col-sm-3 control-label">NIP</label>

                          <div class="col-sm-8">
                            <input type="text" class="form-control" name="nip" id="nip" required />
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="nama_siswa" class="col-sm-3 control-label">Nama</label>

                          <div class="col-sm-8">
                            <input type="text" class="form-control" name="nama_guru" id="nama_guru" required />
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
                    </div>
                    <div class="modal-footer">
                      <button type="reset" class="btn btn-default">Reset</button>
                      <button type="submit" class="btn btn-primary" name="simpan">Simpan</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
               <thead>
                          <tr>
                            <th style='text-align:center;vertical-align:middle' width="30px"> No.</th>
                            <th style='text-align:center;vertical-align:middle'> NIP</th>
                            <th style='text-align:center;vertical-align:middle'> Nama Guru </th>
                            <th style='text-align:center;vertical-align:middle'> JK </th>
                            <th style='text-align:center;vertical-align:middle' width="200px"> Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $no = 1;
                          foreach ($data_guru->result_array() as $guru) {
                          ?>
                          <tr>
                            <td style='text-align:center;vertical-align:middle'><?php echo $no++;?></td>
                            <td style='text-align:center;vertical-align:middle'><?php echo $guru['nip']; ?></td>
                            <td style='vertical-align:middle'><?php echo $guru['nama_guru']; ?></td>
                            <td style='text-align:center;vertical-align:middle'><?php echo $guru['jk']; ?></td>
                            <td style='text-align:center;vertical-align:middle'>
                    <a href="<?php echo base_url(); ?>index.php/admin/profile_guru/<?php echo $guru['id_guru']; ?>"><button class="btn btn-primary">
                        <span class="green"><i class="fa fa-search-plus bigger-120"> Lihat Profil</i></span></button></a>
                    <a href="<?php echo base_url(); ?>index.php/admin/hapus_guru/<?php echo $guru['id_guru']; ?>"  class="AlertaEliminarCliente">
                        <button class="btn btn-danger">
                        <span class="red"><i class="fa fa-trash-o bigger-120"> Hapus</i></span></button></a>
                  </td>
                          </tr>
                          <?php } ?>
                        </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
  </div>
    <!-- /.content -->

  <!-- Footer -->
<script src="<?php echo base_url();?>assets/bower_components/jquery/dist/jquery.min.js"></script>
<?php echo $footer;?>