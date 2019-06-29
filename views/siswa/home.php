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
        Beranda
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
        <div class="box-header with-border">
          <h5 class="callout callout-success">Selamat Datang <strong class="blue"><?php echo $nama; ?>,</strong>
                anda masuk sebagai <strong class="blue"><?php echo $status; ?>
                </strong></h5>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                    title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-lg-3 col-xs-6">
              <div class="small-box bg-gray">
                  <div class="inner">
                    <h3><?php echo $hitung_pesan->num_rows();?></h3>
                      <p>Pesan Baru</p>
                </div>
                  <div class="icon">
                      <i class="fa fa-envelope-o"></i>
                  </div>
                    <a href="<?php echo base_url();?>siswa/tampil_pesan/masuk" class="small-box-footer">Selengkapnya <i class="fa fa-arrow-circle-right"></i></a>
              </div>
          </div>

          <div class="col-lg-3 col-xs-6">
              <div class="small-box bg-aqua">
                  <div class="inner">
                    <h3><?php echo $jadwal->num_rows();?></h3>
                      <p>Jadwal</p>
                </div>
                  <div class="icon">
                      <i class="fa fa-calendar"></i>
                  </div>
                    <a href="<?php echo base_url();?>siswa/tampil_jadwal" class="small-box-footer">Selengkapnya <i class="fa fa-arrow-circle-right"></i></a>
              </div>
          </div>

          <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-green">
                  <div class="inner">
                    <h3><?php $query = $this->db->query("select * from tbl_tugas where id_kelas = $kelas and status='aktif'"); echo $query->num_rows();?></h3>
                        <p>Tugas</p>
                  </div>
                  <div class="icon">
                    <i class="fa fa-tasks"></i>
                  </div>
                  <a href="<?php echo base_url();?>siswa/tampil_tugas" class="small-box-footer">Selengkapnya <i class="fa fa-arrow-circle-right"></i></a>
              </div>
          </div>

          <div class="col-lg-3 col-xs-6">
                <!-- small box -->
              <div class="small-box bg-yellow">
                  <div class="inner">
                      <h3><?php $query = $this->db->query("select * from tbl_materi where id_kelas = $kelas"); echo $query->num_rows();?></h3>
                      <p>Materi</p>
                  </div>
                  <div class="icon">
                      <i class="fa fa-book"></i>
                  </div>
                  <a href="<?php echo base_url();?>siswa/tampil_materi" class="small-box-footer">Selengkapnya <i class="fa fa-arrow-circle-right"></i></a>
              </div>
          </div>
      </div>

        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


  <!-- Footer -->

<?php echo $footer?>