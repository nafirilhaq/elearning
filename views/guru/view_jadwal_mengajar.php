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
        Jadwal Mengajar
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
        
        <div class="box-body">
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
              <div class="table-responsive">
                <table class="table table-bordered table-striped">
                 <thead>
                    <tr>
                      <th style='text-align:center;vertical-align:middle' width="100px"> HARI</th>
                      <th style='text-align:left;vertical-align:middle' colspan="2" width="70px"> MATA PELAJARAN DAN JAM </th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      $parent = 0;
                      foreach ($hari->result_array() as $hari) {
                      $parent++;
                    ?>                      
                    <tr style="background-color: unset;">
                      <th><?php echo $hari['hari']; ?></th>
                      <td style='vertical-align:middle;font-size: 16px;'>
                        <a href="<?php echo base_url();?>index.php/guru/tambah_jadwal_ajar/<?php echo $hari['hari_id']; ?>" style="display: block;">
                          <button class="btn btn-primary" style="font-size: 11px;">TAMBAH</button>
                        </a>
                          <?php 
                            foreach ($jadwal->result_array() as $row) {
                          ?>
                          <?php if($row['hari_id'] == $parent) {
                          ?> 
                            <div style="width: 100%; display: flex; background-color: #d9edf7; margin-top: 5px; align-items: center;">
                              <div style="width: 15%;">
                                <span><?php echo date('H:i', strtotime($row['jam_mulai']));  ?> - <?php echo date('H:i', strtotime($row['jam_selesai'])); ?></span>
                              </div>
                              <div style="width: 40%;">
                                <span><?php echo $row['nama_mapel'];  ?></span>
                              </div>
                              <div style="width: 30%;">
                                <span>KELAS <?php echo $row['nama_kelas'];  ?></span>
                              </div>
                               <div style="width: 20%;">
                                <span><a href="<?php echo base_url(); ?>guru/edit_jadwal/<?php echo $row['id']; ?>" class="fa fa-edit"> Sunting</a> | <a href="<?php echo base_url(); ?>guru/hapus_jadwal/<?php echo $row['id']; ?>/<?php echo $row['id_kelas']; ?>/<?php echo $row['id_mapel']; ?>" class="AlertaEliminarCliente fa fa-trash-o"> Hapus</a></span>
                              </div>
                            <?php } ?>
                            </div>
                          <?php } ?>
                      </td>
                    <?php } ?>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
        <!-- /.box-body -->
        
        <!-- /.box-footer-->
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


  <!-- Footer -->

<?php echo $footer?>