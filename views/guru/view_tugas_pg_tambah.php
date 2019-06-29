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
        Manajemen Tugas
      </h1>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
              <div class="panel panel-default">
                <div class="panel-heading">Tambah Tugas / Pilihan Ganda&nbsp; <a href="<?php echo base_url();?>index.php/guru/tampil_tugas" class="btn btn-warning btn-sm">Kembali</a></div>
                <div class="panel-body">
                    <form method="post" action="<?php echo base_url();?>guru/simpan_tugas/pg">
                        
                        <div class="form-group">
                            <label>Judul *</label>
                            <input type="text" id="judul" name="judul" class="form-control" placeholder="Contoh: Ulangan Harian 1" required />
                        </div>
                        <div class="form-group">
                            <label>Kelas *</label>                            
                            <select name="kelas" id="kelas" class="form-control" required>
                                <option value="">Pilih Kelas</option>
                                <?php foreach ($kelas as $row) {
                                ?>
                                  <option value="<?php echo $row->id_kelas; ?>"><?php echo $row->nama_kelas; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Mata Pelajaran * (Pilih Kelas Dahulu)</label>                            
                            <select name="mapel" id="mapel" class="form-control" required>
                                <option value="">Pilih Mapel</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Tanggal Mulai *</label>
                            <input type="datetime-local" id="tgl_mulai" name="tgl_mulai" value="<?php echo date('Y-m-d\TH:i'); ?>" class="form-control" required />
                        </div>
                        <div class="form-group">
                            <label>Tanggal Selesai *</label>
                            <input type="datetime-local" id="terlambat" name="terlambat" value="<?php echo date('Y-m-d\TH:i'); ?>" class="form-control" required />
                        </div>
                        <div class="form-group">
                            <label>Waktu Tugas * <sub>(dalam menit)</sub></label>
                            <input type="text" id="waktu_soal" name="waktu_soal" class="form-control" required />
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