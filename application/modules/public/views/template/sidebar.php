 <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?php echo base_url(); ?>user/dashboard" class="brand-link">
      <img src="<?php echo FRONT_DESIGN.'img/AdminLTELogo.png' ?>" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">
        <?php if($this->session->userdata('user_logged_in')) {
          echo 'User';
      } ?></span>
    </a>
   <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
        <?php if(isset($profile_pic) && !empty($profile_pic) && isset($register_type)) { ?>

        <?php if($register_type != 1) { ?>
        <?php

              // Variable to check
              $url = $profile_pic;
              // Validate url
              if (filter_var($url, FILTER_VALIDATE_URL)) { ?>
                  <img src="<?php echo $profile_pic; ?>" class="img-circle elevation-2" alt="User Image">
              <?php } else { ?>
                <img src="<?php echo base_url(); ?>uploads/profile/<?php echo $profile_pic; ?>" class="img-circle elevation-2" alt="User Image">
              <?php }
              ?>
        <?php }else{ ?> 

          <img src="<?php echo base_url(); ?>uploads/profile/<?php echo $profile_pic; ?>" class="img-circle elevation-2" alt="User Image">

        <?php } ?>

        <?php }else{ ?>

        <img src="<?php echo FRONT_DESIGN.'img/user2-160x160.jpg' ?>" class="img-circle elevation-2" alt="User Image">

        <?php } ?>
       </div>
        <div class="info">
          <a href="#" class="d-block">
          <?php if(isset($first_name) && isset($last_name)){
              echo $first_name.' '. $last_name;
          } ?></a>
        </div>
      </div>
     <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>
     <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="<?php echo PUBLIC_PATH.'dashboard' ?>" class="nav-link <?php if(isset($active_link) && $active_link == 'dashboard') { echo 'active'; } ?>">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
             </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link <?php if(isset($active_link) && $active_link == 'settings') { echo 'active'; } ?>">
              <i class="nav-icon fas fa-cog"></i>
              <p>
                Settings
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo base_url(); ?>user/changepassword" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Change Password</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url(); ?>user/profile-edit" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Manage Profile</p>
                </a>
              </li>
            </ul>
          </li>  
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>