  <!-- Header -->

<?php echo $header;?>

  <!-- Side Menu -->

<?php echo $menu;?>

  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Detail Tugas
      </h1>
      <ol class="breadcrumb">
        <strong><script language="JavaScript">document.write(tanggallengkap);</script>
        <i id="output"></i>
        </strong>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="row col-md-12 ini_bodi">
          <div class="panel panel-info">
            <div class="panel-heading">Konfirmasi Data</div>

            <div class="panel-body">
              <?php 
              $ket = 0;

              if(!empty($nuldata)){
                if($nuldata->status=='N'){
                  echo $data;
                  $ket = 1;
                }
              } else{
                $ket = 2;
              } ?>

              <input type="hidden" name="id_ujian" id="id_ujian" value="<?php echo $du['id_tugas']; ?>">
              <input type="hidden" name="_tgl_sekarang" id="_tgl_sekarang" value="<?php echo date('Y-m-d H:i:s'); ?>">
              <input type="hidden" name="_tgl_mulai" id="_tgl_mulai" value="<?php echo $du['tgl_mulai']; ?>">
              <input type="hidden" name="_terlambat" id="_terlambat" value="<?php echo $du['terlambat']; ?>">
              <input type="hidden" name="_statuse" id="_statuse" value="<?php echo $du['statuse']; ?>">
              <input type="hidden" name="_ket" id="_ket" value="<?php echo $ket; ?>">
              <div class="col-md-7">
                <div class="panel panel-default">
                  <div class="panel-body">
                    <table class="table table-bordered">
                      <tr><td width="35%">Nama</td><td width="65%"><?php echo $nama; ?></td></tr>
                      <tr><td>NIS</td><td><?php echo $nis; ?></td></tr>
                      <tr><td>Guru / Mapel</td><td><?php echo $du['pembuat']." / ".$du['nama_mapel']; ?></td></tr>
                      <tr><td>Nama Tugas</td><td><?php echo $du['judul']; ?></td></tr>
                      <tr><td>Waktu Mulai</td><td><?php echo $du['tgl_mulai']; ?></td></tr>
                      <tr><td>Waktu Selesai</td><td><?php echo $du['terlambat']; ?></td></tr>
                      <tr><td>Waktu</td><td><?php echo $du['waktu_soal']/60; ?> Menit</td></tr>
                      <tr><td style="vertical-align: middle;">Kelompok</td><td>
                        <?php
                        if($status==1){
                          foreach ($kelompok->result_array() as $kelompok) {
                            $nama = $kelompok['nama_siswa'];
                            echo $nama.'<br/>';
                          }
                        }else if($status==0){
                          echo '<i>Tidak ada kelompok</i>';
                        }
                        ?>
                      </td></tr>
                      <tr><td>Nilai</td><td><?php if(empty($nuldata)){ echo '<i>-</i>';}else{?><?php echo $nuldata->nilai; }?></td></tr>
                    </table>
                  </div>
                </div>
              </div>
              
              <div class="col-md-5">
                <div class="panel panel-default">
                  <div class="panel-body">

                    <div id="btn_mulai">Tugas/Ujian akan mulai dalam <div id="akan_mulai"></div></div>

                    <div class="callout callout-danger" id="waktu_" style="margin-top: 20px">
                      Sisa waktu mengikuti ujian <br>
                      <span id="waktu_akhir_ujian"></span>
                    </div>

                    <div id="waktu_game_over"></div>

                    <!--
                    <a href="#" class="btn btn-success btn-lg" id="tbl_mulai" onclick="return konfirmasi_token(<?php echo $du['id']; ?>)"><i class="fa fa-check-circle"></i> MULAI TUGAS</a>
                    <div class="btn btn-danger" id="ujian_selesai">UJIAN TELAH SELESAI</div>
                    -->
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>
        <!-- /.box-footer-->
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


<?php echo $footer?>