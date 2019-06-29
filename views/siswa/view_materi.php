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
        Daftar Materi
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
                <table id="example1" class="table table-striped">
                 <thead>
                    <tr>
                      <th style='text-align:center;vertical-align:middle'> No.</th>
                      <th style='text-align:left;vertical-align:middle'> Informasi Materi </th>
                      <th style='text-align:left;vertical-align:middle'> </th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      $no = 0;
                      foreach ($materi->result_array() as $materi) {
                        $no++;
                    ?>                    
                    <tr style="background-color: unset;">
                      <td><?php echo $no; ?></td>
                      <td style='vertical-align:middle;font-size: 16px;'>
                        <div>
                            <span style="color: #c09853; font-weight: 600;"><?php echo $materi['judul']; ?></span>
                            <br/>
                            <span style="display: flex; flex-wrap: wrap;"><?php echo $materi['tipe_materi']; ?><p style="margin-left: 5px; margin-right: 5px">/<p></span>
                         
                            <span style="display: flex; flex-wrap: wrap;"><?php echo $materi['nama_kelas']; ?><p style="margin-left: 5px; margin-right: 5px">/<p></span>
                         
                            <span style="display: flex; flex-wrap: wrap;"><?php echo $materi['nama_mapel']; ?><p style="margin-left: 5px; margin-right: 5px">/<p></span>

                            <span style="display: flex; flex-wrap: wrap;">Dibuat <?php echo $materi['tgl_buat']; ?><p style="margin-left: 5px; margin-right: 5px">/<p></span>

                            <span style="display: flex; flex-wrap: wrap;">
                              <?php
                                $komen = $this->db->query("SELECT * FROM tbl_komentar where id_materi = '".$materi['id_materi']."'");
                                $jml_komen = $komen->num_rows();
                              
                                echo $jml_komen; 
                              ?> Komentar
                            </span>
                        </div>
                      </td>
                       <td style='text-align:center;vertical-align:middle'>
                          <a 
                            <?php if($materi['tipe_materi'] == "Tertulis") { ?> href="<?php echo base_url();?>siswa/detail_materi/tertulis/<?php echo $materi['id_materi']; ?>"<?php } 
                            else if($materi['tipe_materi'] == "File") { ?>href="<?php echo base_url();?>siswa/detail_materi/file/<?php echo $materi['id_materi']; ?>"<?php } ?>>
                            <button class="btn btn-success"> 
                              <span class="green"><i class="fa fa-search-plus bigger-120"> Lihat Materi</i></span>
                            </button>
                          </a>
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