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
        Manajemen Materi
      </h1>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
              <div class="panel panel-default">
                <div class="panel-heading">Sunting Materi &nbsp; <a href="<?php echo base_url();?>index.php/guru/tampil_materi" class="btn btn-warning btn-sm">Kembali</a></div>
                <div class="panel-body">
                  <?php foreach($edit_materi->result_array() as $edit) {
                  ?>
                    <?php echo form_open_multipart('guru/update_materi/file'); ?>
                        <input type="datetime-local" id="tgl_buat" name="tgl_buat" value="<?php echo date('Y-m-d\TH:i'); ?>"  hidden />

                         <input type="text" id="id_materi" name="id_materi" value="<?php echo $edit['id_materi']; ?>"  hidden />

                          <?php echo form_hidden('ganti_gambar', $edit['file']); ?>

                        <div class="form-group">
                            <label>Judul *</label>
                            <input type="text" id="judul" name="judul" value="<?php echo $edit['judul'] ?>" class="form-control"  required/>
                        </div>
                        <div class="form-group">
                            <label>Kelas *</label>                            
                            <select name="kelas" id="kelas" class="form-control" required>
                                <option value="">Pilih Kelas</option>
                                <?php foreach ($kelas as $row) {
                                ?>
                                   <option value="<?php echo $row->id_kelas; ?>" <?php if($row->id_kelas == $edit['id_kelas']) echo 'selected';?>><?php echo $row->nama_kelas ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Mata Pelajaran *</label>                            
                            <select name="mapel" id="mapel" class="form-control" required>
                                <option value="">Pilih Mapel</option>
                                <?php foreach ($mapel->result_array() as $rows) {
                                ?>
                                  <option value="<?php echo $rows['id_mapel'] ?>" <?php if($rows['id_mapel'] == $edit['id_mapel']) echo 'selected';?>><?php echo $rows['nama_mapel'] ?></option>
                                <?php } ?>
                            </select>
                        </div>

                         <div class="form-group">
                            <label>Materi </label> <br/>                           
                            <a href="<?php echo base_url();?>guru/download_materi/<?php echo $edit['file']; ?>" ><?php echo $edit['file']; ?></a>
                        </div>

                         <div class="form-group">
                            <label>Ganti File *</label>                            
                            <input type="file" name="userfile" src="<?php echo base_url('file/materi/'.$edit['file']) ?>">
                        </div>
                        
 
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary" name="simpan">Simpan</button>
                            <!-- <input type="submit" id="simpan" name="simpan" value="Simpan" class="btn btn-success" /> -->
                            <button type="reset" class="btn btn-default">Reset</button>
                        </div>
                      <?php echo form_close() ?>     
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
<script>
  $(document).ready(function(){
   $('#kelas').change(function(){
    var id_kelas = $('#kelas').val();
    if(id_kelas != '')
    {
     $.ajax({
      url:"<?php echo base_url(); ?>guru/ambil_mapel",
      method:"POST",
      data:{id_kelas:id_kelas},
      success:function(data)
      {
       $('#mapel').html(data);
      }
     });
    }
    else
    {
     $('#mapel').html('<option value="">Pilih Kelas</option>');
    }
   });

  });
</script>


<?php echo $footer;?>