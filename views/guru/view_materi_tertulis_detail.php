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
                <div class="panel-heading">Detail Materi &nbsp; <a href="<?php echo base_url();?>index.php/guru/tampil_materi" class="btn btn-warning btn-sm">Kembali</a></div>
                <div class="panel-body">
                    <?php
                      foreach ($materi->result_array() as $materi) {
                    ?>   
                    <div style="width: 100%; display: flex; margin-top: 5px; align-items: center;">
                        <div style="width: 5%; ">
                        </div>
                        <div style="width: 15%; ">
                          <span><b>Judul</b></span>
                        </div>
                        <div style="width: 40%;">
                          <span><?php echo $materi['judul']; ?></span>
                        </div>
                   </div>
                   <br/>
                   <div style="width: 100%; display: flex; margin-top: 5px; align-items: center;">
                        <div style="width: 5%; ">
                        </div>
                        <div style="width: 15%;">
                          <span><b>Mata Pelajaran</b></span>
                        </div>
                        <div style="width: 40%;">
                          <span><?php echo $materi['nama_mapel']; ?></span>
                        </div>
                   </div>
                   <br/>
                   <div style="width: 100%; display: flex; margin-top: 5px; align-items: center;">
                        <div style="width: 5%; ">
                        </div>
                        <div style="width: 15%;">
                          <span><b>Kelas</b></span>
                        </div>
                        <div style="width: 40%;">
                          <span><?php echo $materi['nama_kelas']; ?></span>
                        </div>
                   </div>
                   <br/>
                   <div style="width: 100%; display: flex; margin-top: 5px; align-items: center;">
                        <div style="width: 5%; ">
                        </div>
                        <div style="width: 15%;">
                          <span><b>Dibuat</b></span>
                        </div>
                        <div style="width: 40%;">
                          <span><?php echo $materi['tgl_buat']; ?></span>
                        </div>
                   </div>
                   <br/>
                   <div style="width: 100%; display: flex; margin-top: 5px; align-items: center;">
                        <div style="width: 5%; ">
                        </div>
                        <div style="width: 15%;">
                          <span><b>Materi</b></span>
                        </div>
                   </div>
                   <br/>
                   <div style="width: 100%; display: flex; background-color: #d9edf7; margin-top: 5px; align-items: center;">
                        <div style="width: 5%; ">
                        </div>
                        <div style="width: 15%;">
                          <span><?php echo $materi['konten']; ?></span>
                        </div>
                   </div>
                  <?php } ?>
                </div>

                <div class="box box-success">
                  <div class="box-header">
                    <i class="fa fa-comments-o"></i>
                    <h3 class="box-title">Komentar</h3>
                  </div>
                  <div class="box-body chat" id="chat-box">
                    <!-- chat item -->
                    <!-- /.item -->
                    <!-- chat item -->
                    <?php
                      foreach ($komentar2->result_array() as $komentar) {
                    ?>
                    <div class="item" style="background-color: #d9edf7;">
                      <?php if($komentar['id_siswa']!=NULL){?>
                        <img src="<?php echo base_url();?>file/profile/siswa/<?php echo $komentar['foto'];?>" alt="user image" class="online">
                      <?php } else if($komentar['id_guru']!=NULL){?>
                        <img src="<?php echo base_url();?>file/profile/guru/<?php echo $komentar['foto'];?>" alt="user image" class="online">
                      <?php } ?>
                      <p class="message">
                        <a href="#" class="name">
                          <small class="text-muted pull-right"><i class="fa fa-clock-o"></i> <?php echo date('Y-m-d\ H:i', strtotime($komentar['tgl_posting'])); ?></small>
                          <?php if($komentar['id_siswa']!=NULL){
                            echo $komentar['nama_siswa'];
                          }else if($komentar['id_guru']!=NULL){
                            echo $komentar['nama_guru'];
                          }?>
                        </a>
                        <?php echo $komentar['komentar']; ?>
                      </p>
                    </div>
                  <?php } ?>
                    <!-- /.item -->
                    <!-- chat item -->
                    <!-- /.item -->
                  </div>
                  <!-- /.chat -->
                  <div class="box-footer">
                    <form method="post" action="<?php echo base_url();?>guru/tambah_komentar">
                      <div class="input-group">
                        <input type="text" id="tipe_materi" name="tipe_materi" value="<?php echo $tipe_materi; ?>" hidden/>
                        <input type="text" id="id_materi" name="id_materi" value="<?php echo $id_materi; ?>" hidden/>
                        <input type="datetime-local" id="tgl_posting" name="tgl_posting" value="<?php echo date('Y-m-d\TH:i'); ?>" hidden/>

                        <input type="text" id="komentar" name="komentar" class="form-control" placeholder="Ketik pesan..." required />

                        <div class="input-group-btn">
                          <button type="submit" class="btn btn-success"><i class="fa fa-plus"></i></button>
                        </div>
                      </div>
                    </form>
                  </div>
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