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
        <?php
          foreach($kelas2->result() as $kls){
        ?>
            <a href="<?php echo base_url();?>admin/mapel_kelas">
              Mata Pelajaran Kelas 
            </a> / <?php echo $kls->nama_kelas; ?>
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
                        <a href="<?php echo base_url();?>admin/tambah_jadwal_ajar/<?php echo $kls->id_kelas; ?>/<?php echo $hari['hari_id']; ?>" style="display: block;">
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
                                <span>Pengajar : <?php echo $row['nama_guru'];  ?></span>
                              </div>
                               <div style="width: 20%;">
                                <span><a href="<?php echo base_url(); ?>admin/edit_jadwal/<?php echo $kls->id_kelas; ?>/<?php echo $hari['hari_id']; ?>/<?php echo $row['id']; ?>" class="fa fa-edit"> Sunting</a> | <a href="<?php echo base_url(); ?>admin/hapus_jadwal/<?php echo $row['id']; ?>/<?php echo $row['id_kelas']; ?>/<?php echo $row['id_mapel']; ?>" class="AlertaEliminarCliente fa fa-trash-o"> Hapus</a></span>
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
  <?php } ?>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


  <!-- Footer -->
<script src="<?php echo base_url();?>assets/bower_components/jquery/dist/jquery.min.js"></script>
<?php echo $footer?>