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
                    <a href="<?php echo base_url();?>admin/kirim_pesan/baru" class="btn btn-primary btn-block margin-bottom">Tulis Pesan</a>

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
                          <li class="active"><a href="<?php echo base_url();?>admin/tampil_pesan/masuk"><i class="fa fa-inbox"></i> Pesan Masuk
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
                        <h3 class="box-title">Pesan Masuk</h3>
                      </div>
                      <!-- /.box-header -->
                      <div class="box-body no-padding">
                        <table id="pesan_detail" class="table">
                           <thead>
                              <tr>
                                <th style='text-align:center;vertical-align:middle' width="20px"></th>
                                <th style='text-align:center;vertical-align:middle' width="120px"></th>
                                <th style='text-align:center;vertical-align:middle' width="10px"></th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php
                                foreach ($det_pesan->result_array() as $row) {
                              ?>
                              <tr>
                                <td style='vertical-align:middle' width="20px"><?php echo $row['nama'];?>
                                  <div>
                                      <span style="display: flex; flex-wrap: wrap; font-size: 12px; padding-top: 1px;"><?php echo date("d-m-Y H:i", strtotime($row['tanggal']))?></span>
                                  </div>
                                </td>
                                <td style='vertical-align:middle; background-color: #d9edf7;' width="120px">
                                  <div  class="pull-right" style="vertical-align: top">
                                    <span><a href="<?php echo base_url();?>admin/hapus_pesan/satu/<?php echo $this->uri->segment(3); ?>/<?php echo $row['id'];?>" class="AlertaEliminarCliente fa fa-trash-o"></a></span>
                                  </div>
                                  <div>
                                    <span><?php echo $row['content'];?></span>
                                  </div>
                                </td>
                                <td style='vertical-align:middle' width="50px"><?php echo $row['tanggal'];?></td>
                              </tr>
                              <?php }?>
                            </tbody>
                          </table>
                          <div class="box box-primary">
                            <div class="box-header with-border">
                              <h3 class="box-title">Kirim Pesan</h3>
                            </div>
                            <form method="post" action="<?php echo base_url();?>admin/kirim_pesan/balas/<?php echo $this->uri->segment(3); ?>">

                              <div class="form-group">
                                  <textarea name="konten" id="konten"></textarea>
                              </div>
                              
       
                              <div class="form-group">
                                  <button type="submit" class="btn btn-primary" name="simpan">Kirim</button>
                                  <!-- <input type="submit" id="simpan" name="simpan" value="Simpan" class="btn btn-success" /> -->
                              </div>
                          </form>
                        </div>
                        <!-- /.mail-box-messages -->
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

  <script>
    $(function () {
        CKEDITOR.replace('konten');
    });
  </script>   
    <!-- /.content -->

  <!-- Footer -->

<?php echo $footer;?>