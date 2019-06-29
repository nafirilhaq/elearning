   <!-- Header -->

<?php echo $header;?>

  <!-- Side Menu -->

<?php echo $menu;?>

 <!-- Main content -->
 <div class="content-wrapper">
  <section class="content-header">
      <h1>
        Daftar Soal
      </h1>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
              <div class="panel panel-default">
                <div class="panel-heading">
                    <a onclick="self.history.back();" class="btn btn-danger btn-sm">Kembali</a> &nbsp; 
                    Tambah Soal : <a href="<?php echo base_url();?>guru/tambah_soal/pilgan/<?php echo $this->uri->segment(3); ?>" class="btn btn-primary btn-sm">Pilihan Ganda</a> 
                </div>
                <div class="panel-body">
                  <fieldset>
                    <legend>Info Tugas / Quiz</legend>
                    <?php
                    foreach ($detail_tugas->result_array() as $detail_tugas) {
                    ?>
                    <table align="center">
                      <tr>
                        <td>Judul</td>
                        <td align="center" width="50px">:</td>
                        <td><?php echo $detail_tugas['judul']; ?></td>
                      </tr>
                      <tr>
                        <td>Kelas</td>
                        <td align="center" width="50px">:</td>
                        <td><?php echo $detail_tugas['nama_kelas']; ?></td>
                      </tr>
                      <tr>
                        <td>Mata Pelajaran</td>
                        <td align="center" width="50px">:</td>
                        <td><?php echo $detail_tugas['nama_mapel']; ?></td>
                      </tr>
                      <tr>
                        <td>Waktu Pengerjaan</td>
                        <td align="center" width="50px">:</td>
                        <td><?php echo $detail_tugas['waktu_soal'] / 60 ." menit"; ?></td>
                      </tr>
                      <?php } ?>
                    </table>
                  </fieldset>
                </div>
              </div>
            </div>
          <!-- /.box -->
          </div>
        <!-- /.col -->
        </div>
      </div>

      <div class="row" id="essay">
        <div class="panel panel-default">
          <div class="panel-heading">Soal Essay &nbsp; <a href="" class="btn btn-primary btn-sm">Tambah Soal </a></div>
          <div class="panel-body">
            <div class="table-responsive">
              <table class="table table-striped table-bordered table-hover">
                <thead>
                  <?php
                    if($jumlah_essay->num_rows() > 0) {
                    $no = 1;
                  ?>
                  <tr>
                    <th style='text-align:center'>No</th>
                    <th style='text-align:center'>Pertanyaan</th>
                    <th style='text-align:center'>Gambar</th>
                    <th style='text-align:center'>Opsi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    foreach ($detail_essay->result_array() as $row) {
                  ?>
                  <tr>
                    <td align="center" width="40px"><?php echo $no++; ?></td>
                    <td width="200px"><?php echo $row['pertanyaan']; ?></td>
                    <td align="center" width="150px">
                      <?php
                      if($row['gambar'] != '') {
                        echo '<img src="img/gambar_soal_essay/'.$row['gambar'].'" width="100px" />';
                      } else {
                        echo "<i>Tidak ada gambar</i>";
                      } ?>
                    </td>
                    <td align="center" width="120px">
                      <a href="<?php echo base_url();?>index.php/guru/edit_essay/<?php echo $row['id_tugas']; ?>/<?php echo $row['id_essay']; ?>"><button class="btn btn-primary">
                        <span class="green"><i class="fa fa-search-plus bigger-120"> Sunting</i></span></button></a></a>
                      <a href="<?php echo base_url(); ?>index.php/guru/hapus_essay/<?php echo $row['id_tugas']; ?>/<?php echo $row['id_essay']; ?>" class="AlertaEliminarCliente"><button class="btn btn-danger">
                        <span class="red"><i class="fa fa-trash-o bigger-120"> Hapus</i></span></button></a>
                    </td>
                  </tr>
                  <?php
                  } ?>
                </tbody>
                 <?php 
                  } else { ?>
                    <div class="alert alert-danger">Data soal essay tidak ditemukan</div>
                    <?php
                  } ?>
              </table>
            </div>
          </div>
        </div>
      </div>
      <!-- /.row -->
    </section>
  </div>
    <!-- /.content -->

  <!-- Footer -->


<?php echo $footer;?>