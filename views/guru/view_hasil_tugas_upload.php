   <!-- Header -->

<?php echo $header;?>

  <!-- Side Menu -->

<?php echo $menu;?>
 <!-- Main content -->
 <link rel="stylesheet" type="text/css" href="" />
 <div class="content-wrapper">
  <section class="content-header">
      <h1>
        Hasil Tugas
      </h1>
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
                        <tr><td>Waktu</td><td>-</td></tr>
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
            </div>

            <div class="box">
              <div class="box-body">
                <div class="table-responsive">
                  <table class="table table-bordered" id="example1">
                    <thead>
                      <tr>
                         <th width="5%" style='text-align:center;vertical-align:middle'>No</th>
                        <th width="10%" style='text-align:center;vertical-align:middle'>NIS</th>
                        <th width="25%" style='text-align:center;vertical-align:middle'>Nama Peserta</th>
                        <th width="10%" style='text-align:center;vertical-align:middle'>Nilai</th>
                        <th width="10%" style='text-align:center;vertical-align:middle'>Kelompok</th>
                        <th width="15%" style='text-align:center;vertical-align:middle'>Nilai Kelompok</th>
                        <th width="17%" style='text-align:center;vertical-align:middle'>Aksi</th>
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
                        <td style='text-align: center; vertical-align:middle'><?php echo $list['nilai']; ?></td>
                        <td style='text-align:center;vertical-align:middle'><?php echo $list['kelompok']; ?></td>
                        <td style='text-align:center;vertical-align:middle'><?php echo $list['nilai_kelompok']; ?></td>
                        <td style='text-align: center; vertical-align:middle'>
                          <span>
                           <a class="btn btn-info btn-xs" id="modal_detail" data-toggle="modal" data-target="#modal_koreksi" data-id="<?php echo $list['id']; ?>" data-idtugas="<?php echo $list['id_tugas']; ?>" data-jawaban="<?php echo $list['list_jawaban']; ?>" data-nilai="<?php echo $list['nilai']; ?>"><i class="fa fa-eye" style="margin-left: 0px; color: #fff"></i>&nbsp;&nbsp;Detail</a>

                           <a href="<?php echo base_url(); ?>guru/h_tugas/batalkan_ujian/upload/<?php echo $list['id_tugas']; ?>/<?php echo $list['id']; ?>/<?php echo $list['kelompok']; ?>" class="AlertaEliminarCliente btn btn-danger btn-xs"><i class="glyphicon glyphicon-remove" style="margin-left: 0px; color: #fff"></i>&nbsp;&nbsp;Batalkan Ujian</a>
                          </span>
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

      <div id="modal_koreksi" class="modal fade" role="dialog">
          <div class="modal-dialog modal-sm">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;
                </button>
                <h4>Detail Jawaban</h4>
              </div>
                <div class="modal-body" id="edit-body">
                    <div style="width: 100%; display: flex; align-items: center;">
                        <div style="width: 3%; ">
                        </div>
                        <div style="width: 30%; ">
                          <span><b>File</b></span>
                        </div>
                        <div style="width: 80%;">
                          <span id="jawaban"></span>
                          <form method="post" action="<?php echo base_url();?>guru/download_tugas_siswa">
                            <input type="text" id="jawaban" name="jawaban" hidden>
                            
                            <button type="submit" class="btn btn-primary" name="simpan"><i class="fa fa-download"></i> Download File</button>
                          </form>
                        </div>
                    </div>
                    <div style="margin-top: 5px;">
                      <form class="form-horizontal" method="post" action="<?php echo base_url(); ?>guru/update_nilai">
                          <input type="text" id="id" name="id" hidden>
                          <input type="text" id="id_tugas" name="id_tugas" hidden>
                          
                          <div class="form-group">
                            <label for="username" class="col-sm-3 control-label" style="text-align: right; padding-left: 15px; padding-top: 20px;">Nilai<font color="red"> *</font></label>

                            <div class="col-sm-4" style="padding-top: 10px;">
                              <input type="text" class="form-control" id="nilai" name="nilai" required>
                            </div>
                          </div>
                    </div>
                </div>
                <div class="modal-footer">
                  <button type="submit" class="btn btn-primary" name="simpan">Simpan</button>
                </div>
                </form>
            </div>
          </div>
        </div>

        <script type="text/javascript">
          $(document).on("click", "#modal_detail", function(){
              var id          = $(this).data('id');
              var idtugas     = $(this).data('idtugas');
              var jawaban     = $(this).data('jawaban');
              var nilai       = $(this).data('nilai');
              $("#edit-body #id").val(id);
              $("#edit-body #id_tugas").val(idtugas);
              $("#edit-body #jawaban").val(jawaban);
              $("#edit-body #nilai").val(nilai);
              document.getElementById('jawaban').innerHTML = $(this).data('jawaban');
          })
        </script>
      <!-- /.row -->
    </section>
  </div>
    <!-- /.content -->

  <!-- Footer -->
<script src="<?php echo base_url();?>assets/bower_components/jquery/dist/jquery.min.js"></script>
<?php echo $footer;?>