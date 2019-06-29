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
        <?php
          foreach($kelas2->result() as $kls){
        ?>
            Mata Pelajaran Kelas - <?php echo $kls->nama_kelas; ?>
        
      </h1>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
              <div class="panel panel-default">
                <div class="panel-heading"><a href="<?php echo base_url();?>admin/mapel_kelas_detail/<?php echo $kls->id_kelas; ?>" class="btn btn-warning btn-sm">Kembali</a></div>
                <div class="panel-body">
                    <form method="post" action="<?php echo base_url();?>admin/simpan_jadwal/<?php echo $kls->id_kelas; ?>">
                        <input type="text" id="hari_id" name="hari_id" value="<?php echo $this->uri->segment(4); ?>"  hidden/>
                        <input type="text" name="id_kelas" id="id_kelas" value="<?php echo $kls->id_kelas; ?>" hidden>

                        <div class="form-group">
                            <label>Kelas *</label>                            
                            <input type="text" name="nama_kelas" id="nama_kelas" class="form-control" value="<?php echo $kls->nama_kelas; ?>" readonly>
                        </div>

                        <div class="form-group">
                            <label>Mata Pelajaran *</label>                            
                            <select name="mapel" class="form-control" required>
                                <option value="">- Pilih -</option>
                                <?php foreach ($mapel->result_array() as $mapel) {
                                ?>
                                  <option value="<?php echo $mapel['id_mapel'] ?>"><?php echo $mapel['nama_mapel'] ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Pengajar *</label>                            
                            <select name="id_guru" class="form-control" required>
                                <option value="">- Pilih -</option>
                                <?php foreach ($guru->result_array() as $guru) {
                                ?>
                                  <option value="<?php echo $guru['id_guru'] ?>"><?php echo $guru['nama_guru'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                            
                        <div class="form-group">
                            <label>Jam Mulai *</label>
                            <input type="time" id="jam_mulai" name="jam_mulai" class="form-control" required />
                        </div>

                        <div class="form-group">
                            <label>Jam Selesai *</label>
                            <input type="time" id="jam_selesai" name="jam_selesai" class="form-control" required />
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
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    <?php } ?>
    </section>
  </div>
    <!-- /.content -->

  <!-- Footer -->
<script src="<?php echo base_url();?>assets/bower_components/jquery/dist/jquery.min.js"></script>
<?php echo $footer;?>