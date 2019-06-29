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
        Manajemen Kelas
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
          <button class="btn btn-primary" data-toggle="modal" data-target="#tambah_siswa" data-backdrop="static">TAMBAH DATA KELAS</button>
        </div>

        <div id="tambah_siswa" class="modal fade" role="dialog">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;
                </button>
                <h4>Tambah Data Kelas</h4>
              </div>
              <form method="post" action="<?php echo base_url();?>index.php/admin/tambah_kelas">
                <div class="modal-body">
                    <label class="control-label" for="nama_kelas">Nama Kelas</label>
                    <input type="text" name="nama_kelas" class="form-control" id="nama_kelas" required>
                    </br>
                    <label class="control-label" for="wali_kelas">Wali Kelas</label>
                    <br/>
                    <select name="wali_kelas" class="form-control" id="wali_kelas" required>
                      <option>--Pilih Wali Kelas--</option>
                      <?php foreach ($wali_kelas->result() as $row) {
                      ?>
                        <option value="<?php echo $row->id_guru; ?>"><?php echo $row->nama_guru; ?></option>
                      <?php } ?>
                    </select>
                </div>
                <div class="modal-footer">
                  <button type="reset" class="btn btn-default">Reset</button>
                  <button type="submit" class="btn btn-primary" name="simpan">Simpan</button>
                </div>
              </form>
            </div>
          </div>
        </div>

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
                        $wali = "";
                        $status = FALSE;
                    ?>
                          <table id="tabel" class="table table-striped">
                            <tbody>
                              <tr style="background-color:#3B5998">
                                <td style='width:40%; text-align:left;vertical-align:middle;color: white'>&emsp; <a href="#" style="color: white">KELAS <?php echo $kelas['nama_kelas']; ?></a></td>
                                <td style='width:40%; text-align:left;vertical-align:middle;color: white'>&emsp; <a href="#" style="color: white">Wali Kelas: 
                                  <?php foreach ($wali_kelas2->result_array() as $row) {
                                    if($row['id_guru'] == $kelas['wali_kelas']){ 
                                      // echo "Kelompok ".$row->kelompok;
                                      $wali = $row['nama_guru'];
                                      $status = TRUE;
                                    }
                                  }
                                  if ($status==TRUE) {
                                    echo $wali;
                                  }elseif ($status==FALSE) {
                                    echo "-";
                                  }?> 
                                </a></td>
                                <td style='text-align:center;vertical-align:middle' width="200px">
                                <a id="edit_kelas" data-toggle="modal" data-target="#modal_edit" data-idkelas="<?php echo $kelas['id_kelas']; ?>" data-namakelas="<?php echo $kelas['nama_kelas']; ?>" data-walikelas="<?php echo $kelas['wali_kelas']; ?>" data-kelaslama="<?php echo $kelas['nama_kelas']; ?>">
                                  <button class="btn btn-primary">
                                    <span class="green"><i class="fa fa-search-plus bigger-120"> Sunting</i></span></button></a>
                                <a href="<?php echo site_url('admin/hapus_kelas/'.$kelas['id_kelas']); ?>" class="AlertaEliminarCliente">
                                    <button class="btn btn-danger">
                                    <span class="red"><i class="fa fa-trash-o bigger-120"> Hapus</i></span></button></a>
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
                               <td style='width:40%; text-align:left;vertical-align:middle;color: white'>&emsp; <a href="#" style="color: white">KELAS <?php echo $kelas['nama_kelas']; ?></a></td>
                                <td style='width:40%; text-align:left;vertical-align:middle;color: white'>&emsp; <a href="#" style="color: white">Wali Kelas: 
                                  <?php foreach ($wali_kelas2->result_array() as $row) {
                                    if($row['id_guru'] == $kelas['wali_kelas']){ 
                                      // echo "Kelompok ".$row->kelompok;
                                      $wali = $row['nama_guru'];
                                      $status = TRUE;
                                    }
                                  }
                                  if ($status==TRUE) {
                                    echo $wali;
                                  }elseif ($status==FALSE) {
                                    echo "-";
                                  }?> 
                                </a></td>
                                <td style='text-align:center;vertical-align:middle' width="200px">
                                <a id="edit_kelas" data-toggle="modal" data-target="#modal_edit" data-idkelas="<?php echo $kelas['id_kelas']; ?>" data-namakelas="<?php echo $kelas['nama_kelas']; ?>" data-walikelas="<?php echo $kelas['wali_kelas']; ?>" data-kelaslama="<?php echo $kelas['nama_kelas']; ?>"><button class="btn btn-primary">
                                    <span class="green"><i class="fa fa-search-plus bigger-120"> Sunting</i></span></button></a>
                                <a href="<?php echo site_url('admin/hapus_kelas/'.$kelas['id_kelas']); ?>" class="AlertaEliminarCliente">
                                    <button class="btn btn-danger">
                                    <span class="red"><i class="fa fa-trash-o bigger-120"> Hapus</i></span></button></a>
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
                                <td style='width:40%; text-align:left;vertical-align:middle;color: white'>&emsp; <a href="#" style="color: white">KELAS <?php echo $kelas['nama_kelas']; ?></a></td>
                                <td style='width:40%; text-align:left;vertical-align:middle;color: white'>&emsp; <a href="#" style="color: white">Wali Kelas: 
                                  <?php foreach ($wali_kelas2->result_array() as $row) {
                                    if($row['id_guru'] == $kelas['wali_kelas']){ 
                                      // echo "Kelompok ".$row->kelompok;
                                      $wali = $row['nama_guru'];
                                      $status = TRUE;
                                    }
                                  }
                                  if ($status==TRUE) {
                                    echo $wali;
                                  }elseif ($status==FALSE) {
                                    echo "-";
                                  }?> 
                                </a></td>
                                <td style='text-align:center;vertical-align:middle' width="200px">
                                <a id="edit_kelas" data-toggle="modal" data-target="#modal_edit" data-idkelas="<?php echo $kelas['id_kelas']; ?>" data-namakelas="<?php echo $kelas['nama_kelas']; ?>" data-walikelas="<?php echo $kelas['wali_kelas']; ?>" data-kelaslama="<?php echo $kelas['nama_kelas']; ?>"><button class="btn btn-primary">
                                    <span class="green"><i class="fa fa-search-plus bigger-120"> Sunting</i></span></button></a>
                                <a href="<?php echo site_url('admin/hapus_kelas/'.$kelas['id_kelas']); ?>" class="AlertaEliminarCliente">
                                    <button class="btn btn-danger">
                                    <span class="red"><i class="fa fa-trash-o bigger-120"> Hapus</i></span></button></a>
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
            <div id="modal_edit" class="modal fade" role="dialog">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;
                    </button>
                    <h4>Sunting Data</h4>
                  </div>
                  <form class="form-horizontal" method="post" action="<?php echo base_url();?>index.php/admin/edit_kelas">
                    <div class="modal-body" id="edit-body">
                        <input type="hidden" name="id_kelas" class="form-control" id="id_kelas">
                        <input type="hidden" name="kelas_lama" class="form-control" id="kelas_lama">

                        <label class="control-label" for="nama_kelas">Nama Kelas</label>
                        <input type="text" name="nama_kelas" class="form-control" id="nama_kelas" required>
                        </br>
                        <label class="control-label" for="wali_kelas">Wali Kelas</label>
                        <br/>
                        <select name="wali_kelas" class="form-control" id="wali_kelas" required>
                          <option>--Pilih Wali Kelas--</option>
                          <?php foreach ($wali_kelas->result() as $row) {
                          ?>
                            <option value="<?php echo $row->id_guru; ?>"><?php echo $row->nama_guru; ?></option>
                          <?php } ?>
                        </select>
                    </div>
                    <div class="modal-footer">
                      <button type="submit" class="btn btn-primary" name="simpan">Simpan</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>

                  <script src="<?php echo base_url();?>assets/bower_components/jquery/dist/jquery-3.3.1.min.js"></script>
                  <script type="text/javascript">
                    $(document).on("click", "#edit_kelas", function(){
                        var idkelas = $(this).data('idkelas');
                        var namakelas = $(this).data('namakelas');
                        var kelaslama = $(this).data('kelaslama');
                        var walikelas = $(this).data('walikelas');
                        $("#edit-body #id_kelas").val(idkelas);
                        $("#edit-body #nama_kelas").val(namakelas);
                        $("#edit-body #kelas_lama").val(kelaslama);
                        $("#edit-body #wali_kelas").val(walikelas);
                    })
                  </script>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


  <!-- Footer -->
<script src="<?php echo base_url();?>assets/bower_components/jquery/dist/jquery.min.js"></script>
<?php echo $footer?>