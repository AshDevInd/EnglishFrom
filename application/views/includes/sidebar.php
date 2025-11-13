<!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?=base_url()?>" class="brand-link">
      <img src="<?=base_url('assets/')?>dist/img/AdminLTELogo.png" alt="English From" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">English From </span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="<?=base_url('assets/')?>dist/img/user2-160x160.jpeg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?=$this->session->userdata['LoginSession']['username']?></a>
        </div>
      </div>

      <!-- SidebarSearch Form
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div> -->

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
         
          <li class="nav-item <?=($page_title=="dashboard")? "menu-open": ''?>">
            <a href="<?=base_url('admin/dashboard')?>" class="nav-link <?=($page_title=="dashboard")? "active": ''?>">
              <i class="nav-icon far fa-lock text-info"></i>
              <p>Dashboard</p>
            </a>
          </li>
          <li class="nav-item <?=($page_title=="vowels")? "menu-open": ''?>">
            <a href="<?=base_url('admin/vowels')?>" class="nav-link <?=($page_title=="vowels")? "active": ''?>">
              <i class="nav-icon far fa-lock text-info"></i>
              <p>Vowels</p>
            </a>
          </li>
          <li class="nav-item <?=($page_title=="vocabs")? "menu-open": ''?>">
            <a href="<?=base_url('admin/vocabs')?>" class="nav-link <?=($page_title=="vocabs")? "active": ''?>">
              <i class="nav-icon far fa-lock text-info"></i>
              <p>Vocabs</p>
            </a>
          </li>

          <li class="nav-item <?=($page_title=="languages")? "menu-open": ''?>">
            <a href="<?=base_url('admin/languages')?>" class="nav-link <?=($page_title=="languages")? "active": ''?>">
              <i class="nav-icon far fa-lock text-info"></i>
              <p>Languages</p>
            </a>
          </li>

          <li class="nav-item <?=($page_title=="category")? "menu-open": ''?>">
            <a href="<?=base_url('admin/category')?>" class="nav-link <?=($page_title=="category")? "active": ''?>">
              <i class="nav-icon far fa-lock text-info"></i>
              <p>Category</p>
            </a>
          </li>

          <li class="nav-item <?=($page_title=="archive")? "menu-open": ''?>">
            <a href="<?=base_url('admin/archive')?>" class="nav-link <?=($page_title=="archive")? "active": ''?>">
              <i class="nav-icon far fa-lock text-info"></i>
              <p>Archive</p>
            </a>
          </li>
        <?php if($this->session->userdata['LoginSession']['type'] == 1) { ?> 
          <li class="nav-item <?=($page_title=="users")? "menu-open": ''?>">
            <a href="<?=base_url('admin/users')?>" class="nav-link <?=($page_title=="users")? "active": ''?>">
              <i class="nav-icon far fa-users text-info"></i>
              <p>Users</p>
            </a>
          </li>
          <?php } ?>

          <li class="nav-item">
            <a href="<?=base_url('admin/dashboard/changePassword')?>" class="nav-link">
              <i class="nav-icon far fa-lock text-info"></i>
              <p>Change Password</p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>