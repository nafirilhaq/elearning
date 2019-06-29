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
        Manajemen Tugas / Kuis
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
            <div class="box-header">
              <?php
              $berhasil = $this->session->flashdata('berhasil');
              $gagal = $this->session->flashdata('gagal');
              if(!empty($berhasil))
              {?>
                <div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <?php echo $berhasil; ?>
                </div>
              <?php 
              } else if(!empty($gagal))
              {?>
                
                <div class="alert alert-danger alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <?php echo $gagal; ?>
                </div>
              <?php 
              } 
            ?>
              <a href="<?php echo base_url();?>guru/tambah_tugas/pg">
                <button class="btn btn-primary">Tambah Tugas Pilihan Ganda</button>
              </a>
              <a href="<?php echo base_url();?>guru/tambah_tugas/upload">
                <button class="btn btn-primary">Tambah Tugas Upload</button>
              </a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <table id="table_tugas" class="table table-bordered table-striped">
                 <thead>
                    <tr>
                      <th style='text-align:center;vertical-align:middle' width="10px"> No.</th>
                      <th style='text-align:center;vertical-align:middle' width="200px"> Informasi Tugas</th>
                      <th style='text-align:center;vertical-align:middle' width="30px"> Kelas</th>
                      <th style='text-align:center;vertical-align:middle' width="50px"> Tipe Tugas</th>
                      <th style='text-align:center;vertical-align:middle' width="50px"> Jumlah Soal</th>
                      <th style='text-align:center;vertical-align:middle' width="30px"> Status</th>
                      <th style='text-align:center;vertical-align:middle' width="80px"> Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $no = 1;
                    foreach ($tugas->result_array() as $tugas) {
                    ?>
                    <tr>
                      <td style='text-align:center;vertical-align:middle'><?php echo $no++;?></td>
                      <td style='vertical-align:middle;font-size: 16px;'>
                        <div>
                            <span style="color: #c09853; font-weight: 600;"><?php echo $tugas['judul']; ?></span>
                            <br/>
                        </div>
                        <div>
                            <span style="display: flex; flex-wrap: wrap; font-size: 12px; padding-top: 5px;"><b>Mata Pelajaran</b><p style="margin-left: 5px; margin-right: 5px">:<p></span>
                         
                            <span style="display: flex; flex-wrap: wrap;"><?php echo $tugas['nama_mapel']; ?></span>
                        </div>
                        <div>
                            <span style="display: flex; flex-wrap: wrap; font-size: 12px; padding-top: 1px;"><b>Waktu</b><p style="margin-left: 5px; margin-right: 5px">:<p></span>
                         
                            <span style="display: flex; flex-wrap: wrap;"><?php echo $tugas['tgl_mulai']; ?> s/d <?php echo $tugas['terlambat']; ?></span>
                        </div>

                        <?php if($tugas['tipe_tugas']=="Pilihan Ganda"){ ?>
                        <div>
                            <span style="display: flex; flex-wrap: wrap; font-size: 12px; padding-top: 1px;"><b>Durasi</b><p style="margin-left: 5px; margin-right: 5px">:<p></span>
                         
                            <span style="display: flex; flex-wrap: wrap;"><?php echo $tugas['waktu_soal']/60; ?> menit</span>
                        </div>
                        <?php } ?>

                        <div>
                            <span style="display: flex; flex-wrap: wrap; font-size: 12px; padding-top: 1px;"><b>Pembuat</b><p style="margin-left: 5px; margin-right: 5px">:<p></span>
                         
                            <span style="display: flex; flex-wrap: wrap;"><?php echo $tugas['pembuat']; ?></span>
                        </div>
                      </td>
                      
                      <td style='text-align:center;vertical-align:middle'><?php echo $tugas['nama_kelas'];?></td>

                      <td style='text-align:center;vertical-align:middle'><?php echo $tugas['tipe_tugas'];?></td>

                      <td style='text-align:center;vertical-align:middle'>
                        <?php 
                        if($tugas['tipe_tugas']=="Pilihan Ganda"){
                          $soal = 0;
                          foreach ($jumlah_pilgan->result_array() as $jumlah) {
                            if($jumlah['id_tugas']==$tugas['id_tugas']){
                              $soal++;
                            }
                          }echo $soal." Soal";
                        }else if($tugas['tipe_tugas']=="Upload"){
                          $soal = 0;
                          foreach ($jumlah_upload->result_array() as $jumlah) {
                            if($jumlah['id_tugas']==$tugas['id_tugas']){
                              $soal++;
                            }
                          }echo $soal." Soal";
                        }?>
                      </td>

                      <td style='text-align:center;vertical-align:middle;font-size: 18px;'><?php if($tugas['status']=="Aktif"){ ?><span class="label label-success"><?php echo $tugas['status']; ?></span><?php } else if($tugas['status']=="Tidak Aktif"){ ?><span class="label label-danger"><?php echo $tugas['status']; ?></span><?php } ?></td>

                      <td style='text-align:center;vertical-align:middle;'>
                        <?php 
                          $hitung_pilgan = $this->db->query("select * from tbl_soal_pilgan where id_tugas='".$tugas['id_tugas']."'");
                          $hitung_upload = $this->db->query("select * from tbl_soal_upload where id_tugas='".$tugas['id_tugas']."'");
                        ?>

                        <div style="padding-top: 3px">
                          <?php if($tugas['status']=="Aktif"){ ?>
                            <a href="<?php echo base_url();?>index.php/guru/nonaktif_tugas/<?php echo $tugas['id_tugas']; ?>" class="NonaktifTugas">
                              <button class="btn btn-danger btn-xs"><i class="fa fa-close"> Non-Aktifkan</i>
                              </button>
                            </a>
                          <?php } else if($tugas['status']=="Tidak Aktif" && ($hitung_pilgan->num_rows() || $hitung_upload->num_rows()) == 0){ ?>
                            <a class="GagalAktif">
                              <button class="btn btn-success btn-xs"><i class="fa fa-check"> Aktifkan</i></button>
                            </a>
                          <?php } else if($tugas['status']=="Tidak Aktif" && ($hitung_pilgan->num_rows() || $hitung_upload->num_rows()) > 0){ ?>
                            <a href="<?php echo base_url();?>guru/aktif_tugas/<?php echo $tugas['id_tugas']; ?>" class="AktifTugas">
                              <button class="btn btn-success btn-xs"><i class="fa fa-check"> Aktifkan</i>
                              </button>
                            </a>
                          <?php } ?>
                        </div>

                        <div style="padding-top: 3px">
                          <a href="<?php echo base_url();?>guru/edit_tugas/<?php echo $tugas['id_tugas']; ?>/<?php echo $tugas['id_kelas']; ?>">
                            <button class="btn btn-primary btn-xs">
                              <i class="fa fa-edit"> Sunting</i>
                            </button>                            
                          </a>

                          <a href="<?php echo base_url(); ?>index.php/guru/hapus_tugas/<?php echo $tugas['id_tugas']; ?>" class="AlertaEliminarCliente">
                            <button class="btn btn-danger btn-xs">
                              <i class="fa fa-trash-o"> Hapus</i>
                            </button> 
                          </a>
                        </div>

                        <div style="padding-top: 3px">
                          <a <?php if($tugas['tipe_tugas'] == "Pilihan Ganda") { ?> href="<?php echo base_url();?>guru/daftar_soal/PG/<?php echo $tugas['id_tugas']; ?>"<?php } else if($tugas['tipe_tugas'] == "Upload") { ?>href="<?php echo base_url();?>guru/daftar_soal/upload/<?php echo $tugas['id_tugas']; ?>"<?php } ?>>
                            <button class="btn btn-info btn-xs">
                              <i class="fa fa-server"> Soal</i>
                            </button> 
                          </a>
                        </div>

                        <div style="padding-top: 3px">
                          <a href="<?php echo base_url();?>guru/tampil_kelompok/<?php echo $tugas['id_tugas']; ?>/<?php echo $tugas['id_kelas']; ?>">
                            <button class="btn btn-primary btn-xs">
                              <i class="fa fa-group"> Kelompok</i>
                            </button> 
                          </a>
                        </div>

                        <div style="padding-top: 3px">
                          <?php 
                            if($tugas['tipe_tugas'] == "Pilihan Ganda") { 
                          ?>
                          <a href="<?php echo base_url();?>guru/h_tugas/det_tugas/PG/<?php echo $tugas['id_tugas']; ?>">
                            <button class="btn btn-success btn-xs">
                              <i class="fa fa-eye"> Lihat Nilai</i>
                            </button> 
                          </a>
                          <?php } else if($tugas['tipe_tugas'] == "Upload") { 
                          ?>
                          <a href="<?php echo base_url();?>guru/h_tugas/det_tugas/upload/<?php echo $tugas['id_tugas']; ?>">
                            <button class="btn btn-success btn-xs">
                              <i class="fa fa-check-square-o"> Koreksi</i>
                            </button> 
                          </a>
                          <?php } ?>
                        </div>
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