   <!-- Header -->

<?php echo $header;?>

  <!-- Side Menu -->

<?php echo $menu;?>

 <!-- Main content -->
 <div class="content-wrapper">
  <section class="content-header">
      <h1>
        Daftar Tugas / Kuis / Ujian
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
              <div class="table-responsive">
                <table id="example1" class="table table-bordered table-striped">
                 <thead>
                    <tr>
                      <th style='text-align:center;vertical-align:middle' width="10px"> No.</th>
                      <th style='text-align:center;vertical-align:middle' width="300px"> Informasi Tugas</th>
                      <th style='text-align:center;vertical-align:middle' width="100px"> Tipe Tugas</th>
                      <th style='text-align:center;vertical-align:middle' width="30px"> Status</th>
                      <th style='text-align:center;vertical-align:middle' width="140px"> Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                      if (!empty($tugas)) {
                        $no = 1;
                        foreach ($tugas->result_array() as $tugas) {
                    ?> 
                    <tr>
                      <td style='text-align:center;vertical-align:middle'><?php echo $no++;?></td>
                      <td style='vertical-align:middle;font-size: 16px;'>
                        <div>
                            <span style="color: #c09853; font-weight: 600;"><?php echo $tugas['judul']; ?></span>
                            <br/>
                         
                            <span style="display: flex; flex-wrap: wrap; font-size: 12px; padding-top: 10px;"><?php echo $tugas['nama_mapel']; ?><p style="margin-left: 5px; margin-right: 5px">,<p></span>

                            <span style="display: flex; flex-wrap: wrap;"><?php echo $tugas['nama_kelas']; ?>
                            <?php if($tugas['tipe_tugas']=="Pilihan Ganda"){ ?>
                              <p style="margin-left: 5px; margin-right: 5px">,<p></span>

                            
                              <span style="display: flex; flex-wrap: wrap;"><?php echo $tugas['waktu_soal']/60; ?> menit</span>
                            <?php } ?>
                        </div>
                        <div>
                            <span style="display: flex; flex-wrap: wrap; font-size: 12px; padding-top: 1px;"><b>Waktu</b><p style="margin-left: 5px; margin-right: 5px">:<p></span>
                         
                            <span style="display: flex; flex-wrap: wrap;"><?php echo $tugas['tgl_mulai']; ?> s/d <?php echo $tugas['terlambat']; ?></span>
                        </div>
                        <div>
                            <span style="display: flex; flex-wrap: wrap; font-size: 12px; padding-top: 1px;"><b>Pembuat</b><p style="margin-left: 5px; margin-right: 5px">:<p></span>
                         
                            <span style="display: flex; flex-wrap: wrap;"><?php echo $tugas['pembuat']; ?></span>
                        </div>
                      </td>
                      
                      <td style='text-align:center;vertical-align:middle'><?php echo $tugas['tipe_tugas'];?></td>

                      <td style='text-align:center;vertical-align:middle'><?php echo $tugas['status'];?></td>

                      <td style="text-align:center;vertical-align:middle">
                        <?php
                          if ($tugas['status'] == "Belum Ikut" && $tugas['tipe_tugas'] == "Pilihan Ganda") {
                           echo '<a href="'.base_url().'siswa/konfirmasi_tugas/PG/'.$tugas["id_tugas"].'" class="btn btn-info btn-xs"><i class="glyphicon glyphicon-pencil" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Mulai Tugas</a>';
                          } else if ($tugas['status'] == "Belum Ikut" && $tugas['tipe_tugas'] == "Upload") {
                           echo '<a href="'.base_url().'siswa/konfirmasi_tugas/Upload/'.$tugas["id_tugas"].'" class="btn btn-info btn-xs"><i class="glyphicon glyphicon-pencil" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Mulai Tugas</a>';
                          } else if ($tugas['status'] == "Sedang Tes" && $tugas['tipe_tugas'] == "Pilihan Ganda") {
                            echo '<a href="'.base_url().'siswa/konfirmasi_tugas/PG/'.$tugas["id_tugas"].'" class="btn btn-success btn-xs"><i class="glyphicon glyphicon-pencil" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp; <blink>Tugas Sedang Aktif</blink></a>';
                          } else if ($tugas['status'] == "Sedang Tes" && $tugas['tipe_tugas'] == "Upload") {
                            echo '<a href="'.base_url().'siswa/konfirmasi_tugas/Upload/'.$tugas["id_tugas"].'" class="btn btn-success btn-xs"><i class="glyphicon glyphicon-pencil" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp; <blink>Tugas Sedang Aktif</blink></a>';
                          } else if ($tugas['status'] == "Waktu Habis" && $tugas['tipe_tugas'] == "Pilihan Ganda") {
                            echo '<a href="'.base_url().'siswa/konfirmasi_tugas/PG/'.$tugas["id_tugas"].'" class="btn btn-warning btn-xs"><i class="glyphicon glyphicon-pencil" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp; <blink>Waktu Habis</blink></a>';
                          } else if ($tugas['status'] == "Waktu Habis" && $tugas['tipe_tugas'] == "Upload") {
                            echo '<a href="'.base_url().'siswa/konfirmasi_tugas/Upload/'.$tugas["id_tugas"].'" class="btn btn-warning btn-xs"><i class="glyphicon glyphicon-pencil" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp; <blink>Waktu Habis</blink></a>';
                          } if ($tugas['status'] == "Selesai" && $tugas['tipe_tugas'] == "Pilihan Ganda") {
                           echo '<a href="'.base_url().'siswa/konfirmasi_tugas/PG/'.$tugas["id_tugas"].'" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-ok" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Anda Sudah Ikut</a>';
                          } else if ($tugas['status'] == "Selesai" && $tugas['tipe_tugas'] == "Upload") {
                           echo '<a href="'.base_url().'siswa/konfirmasi_tugas/Upload/'.$tugas["id_tugas"].'" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-ok" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Anda Sudah Ikut</a>';
                          } 
                        ?>
                      </td>
                    </tr>
                    <?php }} ?>
                  </tbody>
                </table>
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