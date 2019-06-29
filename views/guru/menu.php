
  <!-- Left side column. contains the sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="">
          <img src="<?php echo base_url();?>assets/logo.png" class="center-block img-circle">
        </div>        
      </div>
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header" align="center">MENU NAVIGASI</li>
        <li class="<?php if($this->uri->segment(1)=='guru' && $this->uri->segment(2)==''){echo 'active';}?>">
          <a href="<?php echo base_url();?>index.php/guru">
            <i class="fa fa-home"></i> <span>Beranda</span>
          </a>
        </li>
        <br/>
        <li class="<?php if($this->uri->segment(1)=='guru' && $this->uri->segment(2)=='tampil_pesan'){echo 'active';}?>">
          <a href="<?php echo base_url();?>guru/tampil_pesan/masuk">
             <?php if($hitung_pesan->num_rows()>0){?>
            <span class="label pull-right bg-blue"><?php echo $hitung_pesan->num_rows();?></span><?php }?>
            <i class="fa fa-envelope-o"></i> <span>Pesan</span>
          </a>
        </li>
        <br/>
        <li class="<?php if($this->uri->segment(1)=='guru' && $this->uri->segment(2)=='tampil_jadwal'){echo 'active';}?>">
          <a href="<?php echo base_url();?>index.php/guru/tampil_jadwal">
            <i class="fa fa-calendar"></i> <span>Jadwal Mengajar</span>
          </a>
        </li>
        <br/>
        <li class="<?php if($this->uri->segment(1)=='guru' && $this->uri->segment(2)=='tampil_tugas'){echo 'active';}?>">
          <a href="<?php echo base_url();?>index.php/guru/tampil_tugas">
            <i class="fa fa-tasks"></i> <span>Tugas / Kuis</span>
          </a>
        </li>
        <li class="<?php if($this->uri->segment(1)=='guru' && $this->uri->segment(2)=='tampil_materi'){echo 'active';}?>">
          <a href="<?php echo base_url();?>guru/tampil_materi">
            <i class="fa fa-book"></i> <span>Materi</span>
          </a>
        </li>
        <br/>
        <li>
          <a href="<?php echo base_url();?>index.php/web/logout">
            <i class="fa fa-group"></i> <span>Keluar</span>
          </a>
        </li>
        </ul>
    </section>
    <!-- /.sidebar -->
  </aside>