   <!-- Header -->

<?php echo $header;?>

  <!-- Side Menu -->

<?php echo $menu;?>

 <!-- Main content -->
 <div class="content-wrapper">
  <section class="content-header">
      <h1>
        Daftar Soal
      </h1>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
              <div class="panel panel-default">
                <div class="panel-heading">
                    <a href="<?php echo base_url();?>guru/tambah_soal/pilgan/<?php echo $this->uri->segment(4); ?>" class="btn btn-primary btn-sm">Tambah Soal</a> 
                </div>
                <div class="panel-body">
                  <fieldset>
                    <legend>Info Tugas / Quiz</legend>
                    <?php
                    foreach ($detail_tugas->result_array() as $detail_tugas) {
                    ?>
                    <table style="margin-left: 40px;">
                      <tr>
                        <td>Judul</td>
                        <td align="center" width="50px">:</td>
                        <td><?php echo $detail_tugas['judul']; ?></td>
                      </tr>
                      <tr>
                        <td>Kelas</td>
                        <td align="center" width="50px">:</td>
                        <td><?php echo $detail_tugas['nama_kelas']; ?></td>
                      </tr>
                      <tr>
                        <td>Mata Pelajaran</td>
                        <td align="center" width="50px">:</td>
                        <td><?php echo $detail_tugas['nama_mapel']; ?></td>
                      </tr>
                      <tr>
                        <td>Waktu Pengerjaan</td>
                        <td align="center" width="50px">:</td>
                        <td><?php echo $detail_tugas['waktu_soal'] / 60 ." menit"; ?></td>
                      </tr>
                      <?php } ?>
                    </table>
                  </fieldset>
                </div>
              </div>
            </div>
          <!-- /.box -->
          </div>
        <!-- /.col -->
        </div>
      </div>

      <div class="row" id="pilgan">
        <div class="panel panel-default">
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
          <div class="panel-heading" style="width: 100%;display: flex;  align-items: center;">
            <div style="width: 90%;">
              Daftar Soal Pilihan Ganda &nbsp;                    
            </div>
            
            <div style="width: 18%;">
              <a style="align-items: right" id="salin_semua" data-toggle="modal" data-target="#modal_semua" data-idtugas="<?php echo $id_tugas; ?>" data-tipetugas="<?php echo $tipe_tugas; ?>">
                <button class="btn btn-success btn-sm">
                  <i class="fa fa-copy">
                    Salin semua soal ke tugas lain
                  </i>
                </button>
              </a>
            </div>
            
          </div>
          <div class="panel-body">
            <div class="table-responsive">
            <?php
            if($jumlah_pilgan->num_rows() > 0) {
              $no = 1;
              foreach ($detail_pilgan->result_array() as $row) {
            ?>              
              <table width="100%">
                <tr>
                  <td valign="top">Soal no. ( <?php echo $no++; ?> )</td>
                  <td>
                    <table class="table">
                      <thead>
                        <tr>
                          <td width="20%"><b>Pertanyaan</b></td>
                          <td>:</td>
                          <td width="65%"><?php echo $row['pertanyaan']; ?></td>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>Gambar</td>
                          <td>:</td>
                          <td>
                            <?php
                            if($row['gambar'] != '') {
                              
                            } else {
                              echo "<i>Tidak ada gambar</i>";
                            } ?>
                          </td>
                        </tr>
                        <tr>
                          <td>Pilihan A</td>
                          <td>:</td>
                          <td><?php echo $row['opsi_a']; ?></td>
                        </tr>
                        <tr>
                          <td>Pilihan B</td>
                          <td>:</td>
                          <td><?php echo $row['opsi_b']; ?></td>
                        </tr>
                        <tr>
                          <td>Pilihan C</td>
                          <td>:</td>
                          <td><?php echo $row['opsi_c']; ?></td>
                        </tr>
                        <tr>
                          <td>Pilihan D</td>
                          <td>:</td>
                          <td><?php echo $row['opsi_d']; ?></td>
                        </tr>
                        <tr>
                          <td>Pilihan E</td>
                          <td>:</td>
                          <td><?php echo $row['opsi_e']; ?></td>
                        </tr>
                        <tr>
                          <td>Kunci</td>
                          <td>:</td>
                          <td><?php echo $row['kunci']; ?></td>
                        </tr>
                        <tr>
                          <td>Opsi</td>
                          <td>:</td>
                          <td>
                            <a href="<?php echo base_url();?>index.php/guru/edit_pilgan/<?php echo $row['id_tugas']; ?>/<?php echo $row['id_pilgan']; ?>" style="background-color:#f60;"><button class="btn btn-primary">
                              <span class="green"><i class="fa fa-search-plus bigger-120"> Sunting</i></span></button></a></a>
                            <a href="<?php echo base_url(); ?>index.php/guru/hapus_pilgan/<?php echo $row['id_tugas']; ?>/<?php echo $row['id_pilgan']; ?>" class="AlertaEliminarCliente"><button class="btn btn-danger">
                              <span class="red"><i class="fa fa-trash-o bigger-120"> Hapus</i></span></button></a>
                            <a id="salin_satu" data-toggle="modal" data-target="#modal_satu" data-idtugas="<?php echo $id_tugas; ?>" data-idpilgan="<?php echo $row['id_pilgan']; ?>" data-tipetugas="<?php echo $tipe_tugas; ?>">
                              <button class="btn btn-success">
                               <i class="fa fa-copy"> Salin soal ke tugas lain</i>
                              </button>
                            </a>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </td>
                </tr>
              </table>
              
             <?php
              }
            } else { ?>
              <div class="alert alert-danger">Data soal pilihan ganda tidak ditemukan</div>
              <?php
            } ?>
            </div>
          </div>
        </div>
      </div>

      <div id="modal_semua" class="modal fade" role="dialog">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;
                </button>
                <h4>Salin Soal</h4>
              </div>
              <form class="form-horizontal" method="post" action="<?php echo base_url();?>guru/salin_semua_soal">
                <div class="modal-body" id="tambah-body">
                  <input type="hidden" id="id_tugas_asal" name="id_tugas_asal">
                  <input type="hidden" id="tipe_tugas" name="tipe_tugas">

                  <div class="form-group">
                      <label for="tugas" class="col-sm-3 control-label">Tugas *</label>        

                      <div class="col-sm-8">                   
                        <select name="tugas" id="tugas" class="form-control" required>
                            <option value="">- Pilih -</option>
                            <?php foreach ($tugas->result() as $row) {
                            ?>
                              <option value="<?php echo $row->id_tugas; ?>"><?php echo $row->judul; ?></option>
                            <?php } ?>
                        </select>
                      </div>
                  </div>

                  <div class="form-group">
                    <label for="kelas" class="col-sm-3 control-label">Kelas</label>

                    <div class="col-sm-8">
                      <input type="text" class="form-control" name="kelas" id="kelas" value="Pilih Tugas" readonly />
                    </div>
                  </div>

                  <div class="modal-footer">
                      <button type="submit" class="btn btn-primary" name="simpan">Simpan</button>
                      <!-- <input type="submit" id="simpan" name="simpan" value="Simpan" class="btn btn-success" /> -->
                      <button type="reset" class="btn btn-default">Reset</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>

        <div id="modal_satu" class="modal fade" role="dialog">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;
                </button>
                <h4>Salin Soal</h4>
              </div>
              <form class="form-horizontal" method="post" action="<?php echo base_url();?>guru/salin_satu_soal">
                <div class="modal-body" id="satu-body">
                  <input type="hidden" id="id_pilgan" name="id_pilgan">
                  <input type="hidden" id="id_tugas_asal" name="id_tugas_asal">
                  <input type="hidden" id="tipe_tugas" name="tipe_tugas">

                  <div class="form-group">
                      <label for="tugas" class="col-sm-3 control-label">Tugas *</label>        

                      <div class="col-sm-8">                   
                        <select name="tugas" id="tugas2" class="form-control" required>
                            <option value="">- Pilih -</option>
                            <?php foreach ($tugas->result() as $row) {
                            ?>
                              <option value="<?php echo $row->id_tugas; ?>"><?php echo $row->judul; ?></option>
                            <?php } ?>
                        </select>
                      </div>
                  </div>

                  <div class="form-group">
                    <label for="kelas" class="col-sm-3 control-label">Kelas</label>

                    <div class="col-sm-8">
                      <input type="text" class="form-control" name="kelas" id="kelas" value="Pilih Tugas" readonly />
                    </div>
                  </div>

                  <div class="modal-footer">
                      <button type="submit" class="btn btn-primary" name="simpan">Simpan</button>
                      <!-- <input type="submit" id="simpan" name="simpan" value="Simpan" class="btn btn-success" /> -->
                      <button type="reset" class="btn btn-default">Reset</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>

      <!-- /.row -->
    </section>
  </div>
    <!-- /.content -->

  <!-- Footer -->
<script>
  $('#pilgan').show();  
  $('#essay').hide();  
  $("#toggle_pg").click(function(){
    $('#essay').hide();
    $("#pilgan").slideToggle("slow");
  });
  $("#toggle_essay").click(function(){
    $('#pilgan').hide();
    $("#essay").slideToggle("slow");
  });
</script>

<script>
  $(document).ready(function(){
   $('#tugas').change(function(){
    var id_tugas = $('#tugas').val();
    if(id_tugas != '')
    {
     $.ajax({
      url:"<?php echo base_url(); ?>guru/ambil_kelas_salin",
      method:"POST",
      data:{id_tugas:id_tugas},
      success:function(data)
      {
       $('#tambah-body #kelas').val(data);
      }
     });
    } else{
      $('#tambah-body #kelas').val('Pilih Tugas');
    }
   });

  });

   $(document).ready(function(){
   $('#tugas2').change(function(){
    var id_tugas = $('#tugas2').val();
    if(id_tugas != '')
    {
     $.ajax({
      url:"<?php echo base_url(); ?>guru/ambil_kelas_salin",
      method:"POST",
      data:{id_tugas:id_tugas},
      success:function(data)
      {
       $('#satu-body #kelas').val(data);
      }
     });
    } else{
      $('#satu-body #kelas').val('Pilih Tugas');
    }
   });
  });

  $(document).on("click", "#salin_semua", function(){
      var idtugas = $(this).data('idtugas');
      var tipetugas = $(this).data('tipetugas');
      $("#tambah-body #id_tugas_asal").val(idtugas);
      $("#tambah-body #tipe_tugas").val(tipetugas);
  })

  $(document).on("click", "#salin_satu", function(){
      var idpilgan  = $(this).data('idpilgan');
      var idtugas   = $(this).data('idtugas');
      var tipetugas = $(this).data('tipetugas');
      $("#satu-body #id_tugas_asal").val(idtugas);
      $("#satu-body #id_pilgan").val(idpilgan);
      $("#satu-body #tipe_tugas").val(tipetugas);
  })
</script>

<?php echo $footer;?>