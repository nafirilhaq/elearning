   <!-- Header -->

<?php echo $header;?>

  <!-- Side Menu -->

<?php echo $menu;?>

 <!-- Main content -->
 <div class="content-wrapper">
  <section class="content-header">
      <h1>
        Manajemen Tugas / Kuis / Ujian
      </h1>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
              <div class="panel panel-default">
                <div class="panel-heading">Sunting Tugas / Kuis &nbsp; <a href="<?php echo base_url();?>index.php/guru/tampil_tugas" class="btn btn-warning btn-sm">Kembali</a></div>
                <div class="panel-body">
                  <?php foreach($edit_tugas->result_array() as $edit) {
                  ?>
                    
                    <form method="post" action="<?php echo base_url();?>guru/update_tugas">

                        <input type="text" id="id_tugas" name="id_tugas" value="<?php echo $edit['id_tugas']; ?>" hidden />
                        <div class="form-group">
                            <label>Tipe Tugas *</label>
                            <input type="text" name="tipe_tugas" id="tipe_tugas" class="form-control" value="<?php echo $edit['tipe_tugas'] ?>" readonly>  
                        </div>

                        <div class="form-group">
                            <label>Judul *</label>
                            <input type="text" id="judul" name="judul" class="form-control" placeholder="Ex: Ulangan Harian 1" value="<?php echo $edit['judul']; ?>" required />
                        </div>

                        <div class="form-group">
                            <label>Kelas *</label>                            
                            <select name="kelas" id="kelas" class="form-control" required>
                                <option value="">Pilih Kelas</option>
                                <?php foreach ($kelas as $row) {
                                ?>
                                   <option value="<?php echo $row->id_kelas; ?>" <?php if($row->id_kelas == $edit['id_kelas']) echo 'selected';?>><?php echo $row->nama_kelas; ?></option>
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
                            <label>Tanggal Mulai *</label>
                            <input type="datetime-local" id="tgl_mulai" name="tgl_mulai" value="<?php echo date('Y-m-d\TH:i', strtotime($edit['tgl_mulai'])); ?>" class="form-control" required />
                        </div>
                        <div class="form-group">
                            <label>Tanggal Selesai *</label>
                            <input type="datetime-local" id="terlambat" name="terlambat" value="<?php echo date('Y-m-d\TH:i', strtotime($edit['terlambat'])); ?>" class="form-control" required />
                        </div>

                        <?php if ($edit['tipe_tugas']=="Pilihan Ganda"){ ?>
                        <div class="form-group">
                            <label>Waktu Soal * <sub>(dalam menit)</sub></label>
                            <input type="text" id="waktu_soal" name="waktu_soal" value="<?php echo $edit['waktu_soal']/60; ?>" class="form-control" required />
                        </div>
                        <?php } ?>
                        
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