   <!-- Header -->

<?php echo $header;?>

  <!-- Side Menu -->

<?php echo $menu;?>

 <!-- Main content -->
 <div class="content-wrapper">
  <section class="content-header">
      <h1>
        Rekap Nilai - <?php echo $nama_mapel; ?>
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
            <div class="box-body">
              <div class="panel panel-default">
                <div class="panel-heading"><a href="<?php echo base_url(); ?>admin/profile_siswa/<?php echo $id_siswa; ?>/<?php echo $id_kelas; ?>#rekap" class="btn btn-warning btn-sm">Kembali</a></div>
                <div class="panel-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th style='text-align:center;vertical-align:middle' width="30px"> No.</th>
                        <th style='text-align:center;vertical-align:middle' width="250px"> Nama Tugas</th>
                        <th style='text-align:center;vertical-align:middle' width="60px"> Nilai</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $no = 1;
                      foreach($tugas->result_array() as $tugas) {
                        $nilai = "";
                        $status = FALSE;
                      ?>
                      <tr>
                        <td style='text-align:center;vertical-align:middle'><?php echo $no++;?></td>
                        <td style='text-align:left;vertical-align:middle'><?php echo $tugas['judul']; ?></td>
                        <td style='text-align:center;vertical-align:middle'>
                          <?php foreach ($skor as $row) {
                            if($row->id_tugas == $tugas['id_tugas']){ 
                              // echo "Kelompok ".$row->kelompok;
                              $status=TRUE;
                              $nilai=$row->nilai;
                            }
                          }
                            if ($status==TRUE) {
                              echo $nilai;
                            }elseif ($status==FALSE) {
                              echo "-";
                            }?> 
                        </td>
                      </tr>
                      <?php } ?>
                    </tbody>
                  </table>
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

<script src="<?php echo base_url();?>assets/bower_components/jquery/dist/jquery.min.js"></script>

<?php echo $footer;?>