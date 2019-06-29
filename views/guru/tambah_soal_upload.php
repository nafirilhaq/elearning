   <!-- Header -->

<?php echo $header;?>

  <!-- Side Menu -->

<?php echo $menu;?>

 <!-- Main content -->
 <div class="content-wrapper">
  <section class="content-header">
      <h1>
        Buat Soal
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
                    Buat Jenis Soal : 
                    <a href="<?php echo base_url();?>guru/daftar_soal/upload/<?php echo $this->uri->segment(4); ?>" class="btn btn-primary btn-sm">Upload</a>  
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
      <div class="panel-heading">Buat Soal Essay</div>
        <div class="panel-body">
          <form method="post" action="<?php echo base_url();?>index.php/guru/simpan_soalessay">
            <input name="id_tugas" value="<?php echo $this->uri->segment(3); ?>" hidden></input>
          <div class="col-md-2">
            <label>Pertanyaan No. [ <?php echo $essay->num_rows() + 1; ?> ]</label>
          </div>
          <div class="col-md-10">
            <div class="form-group">
              <textarea name="pertanyaan" class="form-control" rows="3" required></textarea>
            </div>
          </div>

          <div class="col-md-2">
            <label>Gambar <sup>(Optional)</sup></label>
          </div>
          <div class="col-md-10">
            <div class="form-group">
              <input type="file" name="gambar" class="form-control" />
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary" name="simpan">Simpan</button>
                <!-- <input type="submit" id="simpan" name="simpan" value="Simpan" class="btn btn-success" /> -->
                <button type="reset" class="btn btn-default">Reset</button>
            </div>
          </div>
        </form>
        </div>
      </div>
    </div>
      <!-- /.row -->
    </section>
  </div>
    <!-- /.content -->

  <!-- Footer -->

<?php echo $footer;?>