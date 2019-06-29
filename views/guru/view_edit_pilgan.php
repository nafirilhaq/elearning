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
          <div class="panel-heading">Sunting Soal Pilihan Ganda</div>
            <div class="panel-body">
            <?php foreach($edit_pilgan->result_array() as $edit) {
            ?>
              <form method="post" action="<?php echo base_url();?>index.php/guru/update_pilgan">
                <input type="text" id="id_pilgan" name="id_pilgan" value="<?php echo $edit['id_pilgan']; ?>" hidden />
                <input type="text" id="id_tugas" name="id_tugas" value="<?php echo $edit['id_tugas']; ?>" hidden />
                <div class="col-md-2">
                  <label>Pertanyaan</label>
                </div>
                <div class="col-md-10">
                  <div class="form-group">
                    <textarea name="pertanyaan" class="form-control" rows="2" required><?php echo $edit['pertanyaan']; ?></textarea>
                  </div>
                </div>
                
                <div class="col-md-2">
                  <label>Pilihan A</label>
                </div>
                <div class="col-md-10">
                  <div class="form-group">
                    <textarea name="pilA" class="form-control" rows="1" required><?php echo $edit['opsi_a']; ?></textarea>
                  </div>
                </div>
                <div class="col-md-2">
                  <label>Pilihan B</label>
                </div>
                <div class="col-md-10">
                  <div class="form-group">
                    <textarea name="pilB" class="form-control" rows="1" required><?php echo $edit['opsi_b']; ?></textarea>
                  </div>
                </div>
                <div class="col-md-2">
                  <label>Pilihan C</label>
                </div>
                <div class="col-md-10">
                  <div class="form-group">
                    <textarea name="pilC" class="form-control" rows="1" required><?php echo $edit['opsi_c']; ?></textarea>
                  </div>
                </div>
                <div class="col-md-2">
                  <label>Pilihan D</label>
                </div>
                <div class="col-md-10">
                  <div class="form-group">
                    <textarea name="pilD" class="form-control" rows="1" required><?php echo $edit['opsi_d']; ?></textarea>
                  </div>
                </div>
                <div class="col-md-2">
                  <label>Pilihan E</label>
                </div>
                <div class="col-md-10">
                  <div class="form-group">
                    <textarea name="pilE" class="form-control" rows="1" required><?php echo $edit['opsi_e']; ?></textarea>
                  </div>
                        </div>
                        <div class="col-md-2">
                  <label>Kunci Jawaban</label>
                </div>
                <div class="col-md-10">
                  <div class="form-group">
                    <label class="radio-inline">
                        <input type="radio" name="kunci" value="A" <?php if($edit['kunci'] == 'A') echo 'checked';?>>A
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="kunci" value="B" <?php if($edit['kunci'] == "B") echo 'checked';?>>B
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="kunci" value="C" <?php if($edit['kunci'] == "C") echo 'checked';?>>C
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="kunci" value="D" <?php if($edit['kunci'] == "D") echo 'checked';?>>D
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="kunci" value="E" <?php if($edit['kunci'] == "E") echo 'checked';?>>E
                    </label>
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