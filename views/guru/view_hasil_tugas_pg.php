   <!-- Header -->

<?php echo $header;?>

  <!-- Side Menu -->

<?php echo $menu;?>
 <!-- Main content -->
 <div class="content-wrapper">
  <section class="content-header">
      <h1>
        Hasil Tugas
      </h1>
      <ol class="breadcrumb">
        <strong><script language="JavaScript">document.write(tanggallengkap);</script>
        <i id="output"></i>
        </strong>
      </ol>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <!-- /.box-header -->
            <div class="row col-md-12 ini_bodi">
            <div class="panel panel-info">
               
              <div class="panel-body">

                <div class="col-lg-12" style="margin-bottom: 20px; background-color: #fcf8e3; border-color: #faebcc">
                  <div class="col-md-6" style="padding-top: 20px; padding-bottom: 20px;">
                    <?php foreach ($detil_tugas->result_array() as $detil) {
                    ?>
                      <table class="table table-bordered" style="margin-bottom: 0px">
                        <tr><td>Mata Pelajaran</td><td><?php echo $detil['nama_mapel']; ?></td></tr>
                        <tr><td>Nama Guru</td><td><?php echo $detil['pembuat']; ?></td></tr>
                        <tr><td width="30%">Nama Tugas</td><td width="70%"><?php echo $detil['judul']; ?></td></tr>
                        <tr><td>Waktu</td><td><?php echo $detil['waktu_soal']/60; ?> menit</td></tr>
                      </table>

                  </div>
                  <!--<div class="col-md-2"></div>-->
                  <div class="col-md-6" style="padding-top: 20px; padding-bottom: 20px;">
                      <table class="table table-bordered" style="margin-bottom: 0px">
                        <tr><td width="30%">Tipe Soal</td><td><?php echo $detil['tipe_tugas']; ?></td></tr>
                      <?php } ?>
                        <tr><td>Tertinggi</td><td><?php echo $statistik->max_; ?></td></tr>
                        <tr><td>Terendah</td><td><?php echo $statistik->min_; ?></td></tr>
                        <tr><td>Rata-rata</td><td><?php echo number_format($statistik->avg_); ?></td></tr>
                      </table>
                  </div>
                </div>

              </div>

              <div class="box">
                <div class="box-body">
                  <div class="table-responsive">
                    <table class="table table-bordered" id="example1">
                      <thead>
                        <tr>
                          <th width="5%" style='text-align:center;vertical-align:middle'>No</th>
                          <th width="15%" style='text-align:center;vertical-align:middle'>NIS</th>
                          <th width="30%" style='text-align:center;vertical-align:middle'>Nama Peserta</th>
                          <th width="15%" style='text-align:center;vertical-align:middle'>Nilai</th>
                          <th width="15%" style='text-align:center;vertical-align:middle'>Kelompok</th>
                          <th width="15%" style='text-align:center;vertical-align:middle'>Nilai Kelompok</th>
                          <th width="10%" style='text-align:center;vertical-align:middle'>Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $no = 1;
                        foreach ($list_peserta->result_array() as $list) {
                        ?>
                        <tr>
                          <td style='text-align:center;vertical-align:middle'><?php echo $no++;?></td>
                          <td style='vertical-align:middle'><?php echo $list['nis']; ?></td>
                          <td style='vertical-align:middle'><?php echo $list['nama_siswa']; ?></td>
                          <td style='vertical-align:middle; text-align: center'><?php echo $list['nilai']; ?></td>
                          <td style='text-align:center;vertical-align:middle'><?php echo $list['kelompok']; ?></td>
                          <td style='text-align:center;vertical-align:middle'><?php echo $list['nilai_kelompok']; ?></td>
                          <td align="center">
                             <a href="<?php echo base_url(); ?>guru/h_tugas/batalkan_ujian/PG/<?php echo $list['id_tugas']; ?>/<?php echo $list['id']; ?>/<?php echo $list['kelompok']; ?>" class="AlertaEliminarCliente btn btn-danger btn-xs"><i class="glyphicon glyphicon-remove" style="margin-left: 0px; color: #fff"></i>&nbsp;&nbsp;Batalkan Ujian</a>
                          </td>
                        </tr>
                        <?php } ?>

                      </tbody>
                    </table>
                  </div>
              
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