   <!-- Header -->
<?php date_default_timezone_set('Asia/Jakarta');
?>  
<?php echo $header;?>

  <!-- Side Menu -->

<?php echo $menu;?>

 <!-- Main content -->
 <div class="content-wrapper">
  <section class="content-header">
      <h1>
        Jadwal Mengajar
      </h1>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
              <div class="panel panel-default">
                <div class="panel-heading"><a href="<?php echo base_url();?>index.php/guru/tampil_jadwal" class="btn btn-warning btn-sm">Kembali</a></div>
                <div class="panel-body">
                  <?php foreach($edit_jadwal->result_array() as $edit) {
                  ?>
                    <form method="post" action="<?php echo base_url();?>index.php/guru/update_jadwal">
                        <input type="text" id="hari_id" name="hari_id" value="<?php echo $this->uri->segment(3); ?>"  hidden/>

                        <input type="text" id="id" name="id" value="<?php echo $edit['id']; ?>" hidden />
                        <input type="text" name="kelas_lama" value="<?php echo $edit['id_kelas']; ?>" hidden />
                        <input type="text" name="mapel_lama" value="<?php echo $edit['id_mapel']; ?>" hidden />

                        <div class="form-group">
                            <label>Kelas *</label>                            
                            <select name="kelas" class="form-control" required>
                                <option value="">- Pilih -</option>
                                <?php foreach ($kelas->result_array() as $kelas) {
                                ?>
                                  <option value="<?php echo $kelas['id_kelas'] ?>" <?php if($kelas['id_kelas'] == $edit['id_kelas']) echo 'selected';?>><?php echo $kelas['nama_kelas'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Mata Pelajaran *</label>                            
                            <select name="mapel" class="form-control" required>
                                <option value="">- Pilih -</option>
                                <?php foreach ($mapel->result_array() as $mapel) {
                                ?>
                                  <option value="<?php echo $mapel['id_mapel'] ?>" <?php if($mapel['id_mapel'] == $edit['id_mapel']) echo 'selected';?>><?php echo $mapel['nama_mapel'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                            
                        <div class="form-group">
                            <label>Jam Mulai *</label>
                            <input type="time" id="jam_mulai" name="jam_mulai" value="<?php echo date('H:i', strtotime($edit['jam_mulai'])); ?>" class="form-control" required />
                        </div>

                        <div class="form-group">
                            <label>Jam Selesai *</label>
                            <input type="time" id="jam_selesai" name="jam_selesai" value="<?php echo date('H:i', strtotime($edit['jam_selesai'])); ?>" class="form-control" required />
                        </div>
                        
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary" name="simpan">Simpan</button>
                            <!-- <input type="submit" id="simpan" name="simpan" value="Simpan" class="btn btn-success" /> -->
                            <button type="reset" class="btn btn-default">Reset</button>
                        </div>
                    </form>
                    <?php } ?>
                </div>
            </div>
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

<?php echo $footer;?>