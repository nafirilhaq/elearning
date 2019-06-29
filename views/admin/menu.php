
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
        <li class="<?php if($this->uri->segment(1)=='admin' && $this->uri->segment(2)==''){echo 'active';}?>">
          <a href="<?php echo base_url();?>admin">
            <i class="fa fa-home"></i> <span>Beranda</span>
          </a>
        </li>
        <br/>
        <li class="<?php if($this->uri->segment(1)=='admin' && $this->uri->segment(2)=='tampil_pesan'){echo 'active';}?>">
          <a href="<?php echo base_url();?>admin/tampil_pesan/masuk">
            <?php if($hitung_pesan->num_rows()>0){?>
            <span class="label pull-right bg-blue"><?php echo $hitung_pesan->num_rows();?></span><?php }?>
            <i class="fa fa-envelope-o"></i> <span>Pesan</span>
          </a>
        </li>
        <br/>
        <li class="<?php if($this->uri->segment(1)=='admin' && $this->uri->segment(2)=='siswa' || $this->uri->segment(2)=='profile_siswa'){echo 'active';}?>">
          <a href="<?php echo base_url();?>admin/siswa">
            <i class="fa fa-group"></i> <span>Siswa</span>
          </a>
        </li>
        <li class="<?php if($this->uri->segment(1)=='admin' && $this->uri->segment(2)=='guru' || $this->uri->segment(2)=='profile_guru'){echo 'active';}?>">
          <a href="<?php echo base_url();?>admin/guru">
            <i class="fa fa-mortar-board"></i> <span>Guru</span>
          </a>
        </li>
        <br/>
        <li class="<?php if($this->uri->segment(1)=='admin' && $this->uri->segment(2)=='kelas'){echo 'active';}?>">
          <a href="<?php echo base_url();?>admin/kelas">
            <i class="fa fa-navicon"></i> <span>Kelas</span>
          </a>
        </li>
        <li class="treeview <?php if($this->uri->segment(1)=='admin' && $this->uri->segment(2)=='mapel' || $this->uri->segment(2)=='mapel_kelas'){echo 'active';}?>">
          <a href="#">
            <i class="fa fa-tasks"></i>
            <span>Mata Pelajaran</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="<?php if($this->uri->segment(1)=='admin' && $this->uri->segment(2)=='mapel'){echo 'active';}?>"><a href="<?php echo base_url();?>admin/mapel"><i class="fa fa-circle-o"></i> Manajemen Mata Pelajaran</a></li>
            <li class="<?php if($this->uri->segment(1)=='admin' && $this->uri->segment(2)=='mapel_kelas'){echo 'active';}?>"><a href="<?php echo base_url();?>admin/mapel_kelas"><i class="fa fa-circle-o"></i> Mata Pelajaran Kelas</a></li>
          </ul>
        </li>
        <br/>
        <li>
          <a href="<?php echo base_url();?>web/logout">
            <i class="fa fa-sign-out"></i> <span>Keluar</span>
          </a>
        </li>
        </ul>
    </section>
    <!-- /.sidebar -->
  </aside>