   <!-- Header -->

<?php echo $header;?>

  <!-- Side Menu -->

<?php echo $menu;?>

 <!-- Main content -->
 <div class="content-wrapper">
  <section class="content-header">
      <h1>
        Sunting Soal
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
                    Buat Jenis Soal : <a id="toggle_pg" class="btn btn-primary btn-sm">Pilihan Ganda</a> 
                    <a id="toggle_essay" class="btn btn-primary btn-sm">Essay</a>  
                </div>
              </div>
            </div>
          <!-- /.box -->
          </div>
        <!-- /.col -->
        </div>
      </div>

      <div class="row">
        <div class="panel panel-default">
          <div class="panel-heading">Sunting Soal Essay</div>
            <div class="panel-body">
            <?php foreach($edit_essay->result_array() as $edit) {
            ?>
              <form method="post" action="<?php echo base_url();?>index.php/guru/update_essay">
                  <input type="text" id="id_essay" name="id_essay" value="<?php echo $edit['id_essay']; ?>" hidden />
                <input type="text" id="id_tugas" name="id_tugas" value="<?php echo $edit['id_tugas']; ?>" hidden />
                <div class="col-md-2">
                  <label>Pertanyaan</label>
                </div>
                <div class="col-md-10">
                  <div class="form-group">
                    <textarea name="pertanyaan" class="form-control" rows="3" required><?php echo $edit['pertanyaan']; ?></textarea>
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
            <?php } ?>
            </div>
        </div>
    </div>
      <!-- /.row -->
    </section>
  </div>
    <!-- /.content -->

  <!-- Footer -->
<script>
  $('#pilgan').hide();  
  $('#essay').hide();  
  $("#toggle_pg").click(function(){
    $('#essay').hide();
    $("#pilgan").slideToggle("slow");
  });
  $("#toggle_essay").click(function(){
    $('#pilgan').hide();
    $("#essay").slideToggle("slow");
  });
</script>

<?php echo $footer;?>