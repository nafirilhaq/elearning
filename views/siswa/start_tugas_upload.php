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
        Unggah Berkas
      </h1>
      <ol class="breadcrumb">
        <strong><script language="JavaScript">document.write(tanggallengkap);</script>
        <i id="output"></i>
        </strong>
      </ol>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-lg-12">
          <!-- general form elements -->
          <div class="box box-primary">
            <!-- /.box-header -->
            <!-- form start -->
            <form action="<?php echo base_url();?>siswa/mulai_tugas_upload/simpan_akhir/<?php echo $uri3; ?>" enctype="multipart/form-data" method="post"  onsubmit="return confirm('Apakah anda yakin ingin mengunggah berkas ini?');" accept-charset="utf-8">
              <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputFile">Unggah Berkas Tugas Anda :</label>
                  <input type="file" name="userfile" required>
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
              </div>
            </form>
          </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
  </div>
    <!-- /.content -->

  <!-- Footer -->

<?php echo $footer;?>