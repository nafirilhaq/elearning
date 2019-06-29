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
       	<script language="JavaScript">document.write(tanggallengkap);</script>
		<i id="output"></i>
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
	         		<div class="small-box bg-aqua">
			            <div class="inner">
			            	<h3><?php $query = $this->db->query("select * from tbl_siswa"); echo $query->num_rows();?></h3>
			              	<p>Siswa</p>
				        </div>
			            <div class="icon">
				              <i class="fa fa-group"></i>
			            </div>
				            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
			      	</div>
			    </div>

			    <div class="col-lg-3 col-xs-6">
			        <!-- small box -->
			        <div class="small-box bg-green">
			      	    <div class="inner">
			        	    <h3><?php $query = $this->db->query("select * from tbl_guru"); echo $query->num_rows();?></h3>
	                    	<p>Guru</p>
		             	</div>
			            <div class="icon">
			            	<i class="fa fa-mortar-board"></i>
			            </div>
			            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
			        </div>
			    </div>

			    <div class="col-lg-3 col-xs-6">
			          <!-- small box -->
			        <div class="small-box bg-yellow">
			            <div class="inner">
			                <h3><?php $query = $this->db->query("select * from tbl_siswa"); echo $query->num_rows();?></h3>
		 	                <p>Kelas</p>
			            </div>
			            <div class="icon">
			                <i class="ion ion-person-add"></i>
			            </div>
			            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
			        </div>
			    </div>

			    <div class="col-lg-3 col-xs-6">
			          <!-- small box -->
			        <div class="small-box bg-red">
			            <div class="inner">
			                <h3>65</h3>
      		                <p>Mata Pelajaran</p>
			            </div>
			            <div class="icon">
			              <i class="ion ion-pie-graph"></i>
			            </div>
			            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
			        </div>
			        </div>
			</div>

        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          Footer
        </div>
        <!-- /.box-footer-->
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


  <!-- Footer -->

<?php echo $footer?>