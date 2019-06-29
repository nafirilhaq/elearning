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
        Pesan
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
              <section class="content">
                <div class="row">
                  <div class="col-md-3">
                    <a href="<?php echo base_url();?>admin/tampil_pesan/masuk" class="btn btn-primary btn-block margin-bottom">Kembali</a>

                    <div class="box box-solid">
                      <div class="box-header with-border">
                        <h3 class="box-title">Menu</h3>

                        <div class="box-tools">
                          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                          </button>
                        </div>
                      </div>
                      <div class="box-body no-padding">
                        <ul class="nav nav-pills nav-stacked">
                          <li><a href="<?php echo base_url();?>admin/tampil_pesan/masuk"><i class="fa fa-inbox"></i> Pesan Masuk
                            <?php if($hitung_pesan->num_rows()>0){?>
                            <span class="label label-primary pull-right"><?php echo $hitung_pesan->num_rows();?></span>
                            <?php } ?>
                          <li><a href="<?php echo base_url();?>admin/tampil_pesan/keluar"><i class="fa fa-envelope-o"></i> Pesan Terkirim</a></li>
                        </ul>
                      </div>
                      <!-- /.box-body -->
                    </div>
                    <!-- /. box -->
                  </div>
                  <!-- /.col -->
                  <div class="col-md-9">
                    <div class="box box-primary">
                      <div class="box-header with-border">
                        <h3 class="box-title">Kirim Pesan</h3>
                      </div>
                      <!-- /.box-header -->
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
                        <form method="post" action="<?php echo base_url();?>admin/kirim_pesan/kirim">
                            <div class="form-group">
                              <input name="username" id="username" class="form-control" placeholder="Penerima:">
                              <input name="id_login" id="id_login" hidden>
                            </div>
                           
                            <div class="form-group">
                                <textarea name="konten" id="konten"></textarea>
                            </div>
                            <div class="box-footer">
                            <div class="pull-right">
                              <button type="submit" class="btn btn-primary"><i class="fa fa-envelope-o"></i> Kirim</button>
                            </div>
                          </div>
                        </form>
                      </div>
                      <!-- /.box-body -->
                    </div>
                    <!-- /. box -->
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
              </section>
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
    $(function () {
        CKEDITOR.replace('konten');
    });

    $(document).ready(function(){

       $('#username').autocomplete({
            source: "<?php echo site_url('admin/ambil_recipient');?>",
 
            select: function (event, ui) {
                $('[name="username"]').val(ui.item.label); 
                $('[name="id_login"]').val(ui.item.id_login); 
            }
        });

    });
  </script>
    <!-- /.content -->
<?php echo $footer;?>
  <!-- Footer -->

