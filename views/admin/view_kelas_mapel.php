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
        Mata Pelajaran Kelas
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
            <div class="panel-group" id="accordion">
              <?php
                $no = 0;
                foreach ($kelas_parent->result_array() as $parent) {
                  $no++;
              ?>
              <div class="panel panel-success">
                <div class="panel-heading" style="background-color: #305777">
                <a data-toggle="collapse" href="#<?php echo $no; ?>" >
                  <h4 class="panel-title" style="color: white">
                    KELAS <?php echo $parent['nama_kelas']; ?>
                  </h4>
                </a>
                </div>
                <div class="panel-collapse collapse in" id="<?php echo $no; ?>">
                  <div class="panel-body">
                    <?php
                      if($no==1){
                        foreach ($kelas1->result_array() as $kelas){
                    ?>
                          <table id="tabel" class="table table-striped">
                            <tbody>
                              <tr style="background-color:#3B5998">
                                <td style='text-align:left;vertical-align:middle;color: white'>&emsp; <a href="#" style="color: white">KELAS <?php echo $kelas['nama_kelas']; ?></a></td>
                                <td style='text-align:center;vertical-align:middle' width="200px">
                                <a href="<?php echo base_url();?>admin/mapel_kelas_detail/<?php echo $kelas['id_kelas']; ?>">
                                  <button class="btn btn-primary">
                                    <span class="green"><i class="fa fa-search-plus bigger-120"> Lihat Jadwal</i></span>
                                  </button>
                                </a>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        <?php } 
                      }else if($no==2){
                        foreach ($kelas2->result_array() as $kelas){
                        ?>
                          <table id="tabel" class="table table-striped">
                            <tbody>
                              <tr style="background-color:#3B5998">
                               <td style='text-align:left;vertical-align:middle;color: white'>&emsp; <a href="#" style="color: white">KELAS <?php echo $kelas['nama_kelas']; ?></a></td>
                                <td style='text-align:center;vertical-align:middle' width="200px">
                                <a href="<?php echo base_url();?>admin/mapel_kelas_detail/<?php echo $kelas['id_kelas']; ?>"">
                                  <button class="btn btn-primary">
                                    <span class="green"><i class="fa fa-search-plus bigger-120"> Lihat Jadwal</i></span>
                                  </button>
                                </a>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                          <?php }
                      }else if($no==3){
                        foreach ($kelas3->result_array() as $kelas){
                        ?>
                          <table id="tabel" class="table table-striped">
                            <tbody>
                              <tr style="background-color:#3B5998">
                                <td style='text-align:left;vertical-align:middle;color: white'>&emsp; <a href="#" style="color: white">KELAS <?php echo $kelas['nama_kelas']; ?></a></td>
                                <td style='text-align:center;vertical-align:middle' width="200px">
                                <a href="<?php echo base_url();?>admin/mapel_kelas_detail/<?php echo $kelas['id_kelas']; ?>"">
                                  <button class="btn btn-primary">
                                    <span class="green"><i class="fa fa-search-plus bigger-120"> Lihat Jadwal</i></span>
                                  </button>
                                </a>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        <?php } 
                      } ?>
                  </div>
                  
                </div>
              </div>
            <?php } ?>
            </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


  <!-- Footer -->
<script src="<?php echo base_url();?>assets/bower_components/jquery/dist/jquery.min.js"></script>
<?php echo $footer?>