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
                    <a href="<?php echo base_url();?>siswa/kirim_pesan/baru" class="btn btn-primary btn-block margin-bottom">Kirim Pesan</a>

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
                          <li><a href="<?php echo base_url();?>siswa/tampil_pesan/masuk"><i class="fa fa-inbox"></i> Pesan Masuk
                            <span class="label label-primary pull-right">12</span></a></li>
                          <li class="active"><a href="<?php echo base_url();?>siswa/tampil_pesan/keluar"><i class="fa fa-envelope-o"></i> Pesan Terkirim</a></li>
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
                        <h3 class="box-title">Pesan Keluar</h3>
                      </div>
                      <!-- /.box-header -->
                      <div class="box-body no-padding">
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
                        <table id="pesan_all" class="table">
                           <thead>
                              <tr>
                                <th style='text-align:center;vertical-align:middle' width="20px"></th>
                                <th style='text-align:center;vertical-align:middle' width="120px"></th>
                                <th style='text-align:center;vertical-align:middle' width="10px"></th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php
                                foreach ($ambil_pesan->result_array() as $row) {
                              ?>
                              <tr>
                                  <td style='vertical-align:middle' width="20px"><a href="<?php echo base_url();?>siswa/tampil_pesan_detail/<?php echo $row['id_login']; ?>" style="color: black"><?php if($row['opened']==0){?><b><?php echo $row['username'];?></b>
                                    <div>
                                        <span style="display: flex; flex-wrap: wrap; font-size: 12px; padding-top: 1px;"><b><?php echo date("d-m-Y H:i", strtotime($row['tanggal']))?></b></span>
                                    </div>
                                  <?php }else {
                                    echo $row['username'];?>
                                    <div>
                                        <span style="display: flex; flex-wrap: wrap; font-size: 12px; padding-top: 1px;"><?php echo date("d-m-Y H:i", strtotime($row['tanggal']))?></span>
                                    </div>
                                  <?php }?>
                                  </a>
                                  </td>
                                  <td style='vertical-align:middle; background-color: #d9edf7;' width="120px">
                                    <div  class="pull-right" style="vertical-align: top">
                                      <span><a href="<?php echo base_url();?>siswa/hapus_pesan/keluar/<?php echo $row['sender_receiver_id'];?>" class="AlertaEliminarCliente fa fa-trash-o"></a></span>
                                    </div>
                                    <div>
                                      <span><a href="<?php echo base_url();?>siswa/tampil_pesan_detail/<?php echo $row['id_login']; ?>" style="color: black"><?php if($row['opened']==0){?><b><?php echo $row['content'];?></b><?php }else { echo $row['content']; }?></a></span>
                                    </div>
                                  </td>
                                  <td style='vertical-align:middle' width="50px"><?php echo $row['tanggal'];?></td>
                              </tr>
                              <?php }?>
                            </tbody>
                          </table>
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
    <!-- /.content -->

  <!-- Footer -->

<?php echo $footer;?>