   <!-- Header -->

<?php echo $header;?>

  <!-- Side Menu -->

<?php echo $menu;?>

 <!-- Main content -->
 <div class="content-wrapper">
  <section class="content-header">
      <h1>
        Data Mata Pelajaran
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
              <button class="btn btn-primary" data-toggle="modal" data-target="#tambah_mapel" data-backdrop="static">TAMBAH MATA PELAJARAN</button>
            </div>

            <div id="tambah_mapel" class="modal fade" role="dialog">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;
                    </button>
                    <h4>Tambah Data</h4>
                  </div>
                  <form method="post" action="<?php echo base_url();?>index.php/admin/tambah_mapel" enctype="multipart/form-data">
                    <div class="modal-body">
                        <label class="control-label" for="kd_mapel">Kode Mata Pelajaran</label>
                        <input type="text" name="kd_mapel" class="form-control" id="kd_mapel" required>
                        </br>
                    </div>
                    <div class="modal-body">
                        <label class="control-label" for="nama_mapel">Nama Mata Pelajaran</label>
                        <input type="text" name="nama_mapel" class="form-control" id="nama_mapel" required>
                        </br>
                    </div>
                    <div class="modal-footer">
                      <button type="reset" class="btn btn-default">Reset</button>
                      <button type="submit" class="btn btn-primary" name="simpan">Simpan</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
               <thead>
                  <tr>
                    <th style='text-align:center;vertical-align:middle' width="30px"> No.</th>
                    <th style='text-align:center;vertical-align:middle' width="150px"> Kode Mata Pelajaran </th>
                    <th style='text-align:center;vertical-align:middle'> Nama Mata Pelajaran </th>
                    <th style='text-align:center;vertical-align:middle' width="200px"> Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $no = 1;
                  foreach ($data_mapel->result_array() as $mapel) {
                  ?>
                  <tr>
                    <td style='text-align:center;vertical-align:middle'><?php echo $no++;?></td>
                    <td style='text-align:center;vertical-align:middle'><?php echo $mapel['kd_mapel']; ?></td>
                    <td style='text-align:center;vertical-align:middle'><?php echo $mapel['nama_mapel']; ?></td>
                    <td style='text-align:center;vertical-align:middle'>
                      <a id="edit_mapel" data-toggle="modal" data-target="#modal_edit" data-backdrop="static" data-idmapel="<?php echo $mapel['id_mapel']; ?>" data-kdmapel="<?php echo $mapel['kd_mapel']; ?>" data-namamapel="<?php echo $mapel['nama_mapel']; ?>">
                        <button class="btn btn-primary">
                          <span class="green"><i class="fa fa-search-plus bigger-120"> Sunting</i></span>
                        </button>
                      </a>
                      <a href="<?php echo site_url('admin/hapus_mapel/'.$mapel['id_mapel']); ?>"  class="AlertaEliminarCliente">
                          <button class="btn btn-danger">
                          <span class="red"><i class="fa fa-trash-o bigger-120"> Hapus</i></span></button>
                      </a>
                   </td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>

              <div id="modal_edit" class="modal fade" role="dialog">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;
                    </button>
                    <h4>Sunting Data</h4>
                  </div>
                  <form method="post" action="<?php echo base_url();?>index.php/admin/edit_mapel">
                    <div class="modal-body" id="edit-body">
                        <input type="hidden" name="id_mapel" class="form-control" id="id_mapel">
                        <label class="control-label" for="kd_mapel">Kode Mata Pelajaran</label>
                        <input type="text" name="kd_mapel" class="form-control" id="kd_mapel"   required>
                        </br>
                        <label class="control-label" for="nama_mapel">Nama Mata Pelajaran</label>
                        <input type="text" name="nama_mapel" class="form-control" id="nama_mapel" required>
                        </br>
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
              $(document).on("click", "#edit_mapel", function(){
                  var idmapel = $(this).data('idmapel');
                  var kdmapel = $(this).data('kdmapel');
                  var namamapel = $(this).data('namamapel');
                  $("#edit-body #id_mapel").val(idmapel);
                  $("#edit-body #kd_mapel").val(kdmapel);
                  $("#edit-body #nama_mapel").val(namamapel);
              })
            </script>

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