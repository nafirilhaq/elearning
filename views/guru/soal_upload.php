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
                <div class="panel-body">
                  <fieldset>
                    <legend>Info Tugas / Quiz</legend>
                    <?php
                    foreach ($detail_tugas->result_array() as $detail_tugas) {
                    ?>
                    <table style="margin-left: 40px;">
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

      <div class="row" id="pilgan">
        <div class="panel panel-default">
          <div class="panel-heading">Soal Upload</div>
            <div class="panel-body">
            <?php $isi = $upload->row() 
            ?>
              <form method="post" action="<?php if($jumlah_upload->num_rows() > 0) { echo base_url();?>guru/update_upload <?php } else if($jumlah_upload->num_rows() == 0) { echo base_url();?>guru/simpan_upload <?php } ?>" enctype="multipart/form-data">

                <input name="id_tugas" value="<?php echo $this->uri->segment(4); ?>" hidden></input>


                <?php if(!empty($isi->file)) { echo form_hidden('ganti_file', $isi->file); } ?>

                <div>
                  <label>Info Tugas</label>
                </div>
                <div>
                  <div class="form-group">
                    <textarea name="info" class="form-control" rows="4" required><?php if(!empty($isi->info)){ echo $isi->info; }?></textarea>
                  </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary" name="simpan">Simpan</button>
                    <!-- <input type="submit" id="simpan" name="simpan" value="Simpan" class="btn btn-success" /> -->
                    <button type="reset" class="btn btn-default">Reset</button>
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