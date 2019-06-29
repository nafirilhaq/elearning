   <!-- Header -->

<?php echo $header;?>

  <!-- Side Menu -->

<?php echo $menu;?>

<script type="text/javascript">
    function soal_kosong(){
        alert('Tugas Ini Belum Memiliki Soal');
    }
  </script>

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
            <div class="box-header">
              <a href="<?php echo base_url();?>index.php/guru/tambah_tugas">
                <button class="btn btn-primary">TAMBAH</button>
              </a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <table id="example1" class="table table-bordered table-striped">
                 <thead>
                    <tr>
                      <th style='text-align:center;vertical-align:middle' width="30px"> No.</th>
                      <th style='text-align:center;vertical-align:middle' width="200px"> Judul</th>
                      <th style='text-align:center;vertical-align:middle'> Kelas </th>
                      <th style='text-align:center;vertical-align:middle' width="100px"> Mata Pelajaran / Guru</th>
                      <th style='text-align:center;vertical-align:middle' width="100px"> Tipe Tugas</th>
                      <th style='text-align:center;vertical-align:middle' width="30px"> Status</th>
                      <th style='text-align:center;vertical-align:middle' width="140px"> Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $no = 1;
                    foreach ($tugas->result_array() as $tugas) {
                    ?>
                    <tr>
                      <td style='text-align:center;vertical-align:middle'><?php echo $no++;?></td>
                      <td style='vertical-align:middle'><?php echo $tugas['judul']; ?></td>
                      <td style='text-align:center;vertical-align:middle'><?php echo $tugas['nama_kelas']; ?></td>
                      <td style='vertical-align:middle'><?php echo $tugas['nama_mapel']; ?> /<br/> <?php echo $tugas['pembuat']; ?></td>
                      <td style='text-align:center;vertical-align:middle'><?php echo $tugas['tipe_tugas']; ?></td>
                      <td style='text-align:center;vertical-align:middle;font-size: 18px;'><?php if($tugas['status']=="Aktif"){ ?><span class="label label-success"><?php echo $tugas['status']; ?></span><?php } else if($tugas['status']=="Tidak Aktif"){ ?><span class="label label-danger"><?php echo $tugas['status']; ?></span><?php } ?></td>
                      <td align="center">
                        <?php 
                          $hitung_pilgan = $this->db->query("select * from tbl_soal_pilgan where id_tugas='".$tugas['id_tugas']."'");
                          $hitung_essay = $this->db->query("select * from tbl_soal_essay where id_tugas='".$tugas['id_tugas']."'");
                           
                        ?>
                          <?php if($tugas['status']=="Aktif"){ ?>
                            <a href="<?php echo base_url();?>index.php/guru/nonaktif_tugas/<?php echo $tugas['id_tugas']; ?>" class="NonaktifTugas badge" style="background-color:#FD1B0B;">Non-Aktifkan</a>
                          <?php } else if($tugas['status']=="Tidak Aktif" && ($hitung_pilgan->num_rows() || $hitung_essay->num_rows()) == 0){ ?>
                            <a class="GagalAktif badge" style="background-color:#62D416;">Aktifkan</a>
                          <?php } else if($tugas['status']=="Tidak Aktif" && ($hitung_pilgan->num_rows() || $hitung_essay->num_rows()) > 0){ ?>
                            <a href="<?php echo base_url();?>guru/aktif_tugas/<?php echo $tugas['id_tugas']; ?>" class="AktifTugas badge" style="background-color:#62D416;">Aktifkan</a>
                          <?php } ?>
                          <br/>
                          <a href="<?php echo base_url();?>guru/edit_tugas/<?php echo $tugas['id_tugas']; ?>" class="badge" style="background-color:#f60;">Sunting</a>
                          <a href="<?php echo base_url(); ?>index.php/guru/hapus_tugas/<?php echo $tugas['id_tugas']; ?>" class="AlertaEliminarCliente badge" style="background-color:#f00;">Hapus</a>
                          <br /><a <?php if($tugas['tipe_tugas'] == "Pilihan Ganda") { ?> href="<?php echo base_url();?>index.php/guru/tambah_soal/pilgan/<?php echo $tugas['id_tugas']; ?>"<?php } else if($tugas['tipe_tugas'] == "Essay") { ?>href="<?php echo base_url();?>index.php/guru/tambah_soal/essay/<?php echo $tugas['id_tugas']; ?>"<?php } ?> class="badge">Buat Soal</a>
                          <a <?php if($tugas['tipe_tugas'] == "Pilihan Ganda") { ?> href="<?php echo base_url();?>guru/daftar_soal/pilgan/<?php echo $tugas['id_tugas']; ?>"<?php } else if($tugas['tipe_tugas'] == "Essay") { ?>href="<?php echo base_url();?>guru/daftar_soal/essay/<?php echo $tugas['id_tugas']; ?>"<?php } ?> class="badge">Daftar Soal</a>
                          <a href="<?php echo base_url();?>guru/h_tugas/det_tugas/<?php echo $tugas['id_tugas']; ?>" class="badge">Peserta & Koreksi</a>
                      </td>
                    </tr>
                    <?php } ?>
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