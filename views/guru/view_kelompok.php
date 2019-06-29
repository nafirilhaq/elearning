   <!-- Header -->

<?php 
echo $header;
?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/number.css">

<script src="<?php echo base_url(); ?>assets/dist/number.js"></script>


  <!-- Side Menu -->

<?php echo $menu;?>

 <!-- Main content -->
 <div class="content-wrapper">
  <section class="content-header">
      <h1>
        Manajemen Kelompok
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
                      <th style='text-align:center;vertical-align:middle' width="100px"> NIS</th>
                      <th style='text-align:center;vertical-align:middle' width="300px"> Nama Siswa</th>
                      <th style='text-align:center;vertical-align:middle' width="140px"> Kelompok</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php
                        $no = 1;
                        foreach ($kelompok->result_array() as $kel) {
                          $klmpk="";
                          $status=FALSE;
                      ?>
                      <tr>
                        <td style='text-align:center;vertical-align:middle'><?php echo $no++;?></td>
                        <td style='text-align:center;vertical-align:middle'><?php echo $kel['nis']; ?></td>
                        <td style='vertical-align:middle'><?php echo $kel['nama_siswa']; ?></td>
                        <td style='text-align:center;vertical-align:middle'>
                        <?php foreach ($kelompok2 as $row) {
                          if($row->id_siswa == $kel['id_siswa']){ 
                            // echo "Kelompok ".$row->kelompok;
                            $status=TRUE;
                            $klmpk=$row->kelompok;
                            $id_kelompok=$row->id_kelompok;
                          }
                        }?>

                          <a id="edit_kelas" data-toggle="modal" data-target="#modal-edit" data-kelompok="<?php echo $klmpk; ?>" data-namasiswa="<?php echo $kel['nama_siswa']; ?>" data-idsiswa="<?php echo $kel['id_siswa']; ?>" data-idtugas="<?php echo $uri3; ?>" data-idkelas="<?php echo $uri4; ?>">
                            <button class="btn btn-primary">
                              <span class="green">
                                <?php 
                                if ($status==TRUE) {
                                  echo "Kelompok ".$klmpk;
                                }elseif ($status==FALSE) {
                                  echo "Belum ada kelompok";
                                }?>    
                              </span>
                            </button></a>
                            <?php
                            if($status==TRUE){?>
                              <a href="<?php echo base_url(); ?>guru/hapus_kelompok/<?php echo $uri3; ?>/<?php echo $uri4; ?>/<?php echo $id_kelompok; ?>" class="btn btn-danger btn-xs" style="border-radius: 100%;">
                                <i class="fa fa-remove" style="margin-left: 0px; color: #fff"></i>
                              </a>
                            <?php } ?>
                        </td>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>

              <div id="modal-edit" class="modal fade" role="dialog">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;
                    </button>
                    <h4>Manajemen Kelompok</h4>
                  </div>
                  <form class="form-action" enctype="multipart/form-data" method="post">
                    <div class="modal-body" id="edit-body">
                        <label class="control-label" for="nama_guru">Nama</label>
                        <input type="text" name="id_siswa" id="id_siswa" hidden>
                        <input type="text" name="id_tugas" id="id_tugas" hidden>
                        <input type="text" name="id_kelas" id="id_kelas" hidden>
                        <input type="text" name="nama_siswa" class="form-control" id="nama_siswa" readonly>
                        </br>
                        <label class="control-label" for="nama_guru">Kelompok</label>
                        <input type="number" class="form-control" id="kelompok" name="kelompok" required>
                        </br>
                    </div>
                    <div class="modal-footer">
                      <button type="submit" class="btn btn-primary" name="simpan">Simpan</button>
                    </div>
                  </form>
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
      <!-- /.row -->
    </section>
  </div>

<script type="text/javascript">
  $(document).on("click", "#edit_kelas", function(){
      var kelompk = $(this).data('kelompok');
      var idtugas = $(this).data('idtugas');
      var idkelas = $(this).data('idkelas');
      var idsiswa = $(this).data('idsiswa');
      var namasiswa = $(this).data('namasiswa');
      $("#edit-body #kelompok").val(kelompk);
      $("#edit-body #id_tugas").val(idtugas);
      $("#edit-body #id_kelas").val(idkelas);
      $("#edit-body #id_siswa").val(idsiswa);
      $("#edit-body #nama_siswa").val(namasiswa);

      $(".form-action").on("submit", function(){
        console.log('masuk');
        var idsiswa1 = $("#id_siswa").val();
        var idtugas1 = $("#id_tugas").val();
        var formAction = $(".formAction").attr('action');

        $('.form-action').attr('action', "<?php echo base_url();?>index.php/guru/update_kelompok/" + idtugas1 + "/" + idsiswa1);
      })
  })
</script>
    <!-- /.content -->

  <!-- Footer -->


<?php echo $footer;?> 