<?php
        $request = strpos($_SERVER['PHP_SELF'], "request.php");
        $view = strpos($_SERVER['PHP_SELF'], "view.php");
        $manage = strpos($_SERVER['PHP_SELF'], "manage.php");
        $category = strpos($_SERVER['PHP_SELF'], "category.php");
        $service = strpos($_SERVER['PHP_SELF'], "service.php");
        $status = strpos($_SERVER['PHP_SELF'], "status.php");
        $dashboard = strpos($_SERVER['PHP_SELF'], "dashboard.php");
        $profile = strpos($_SERVER['PHP_SELF'], "profile.php");
        $chgpwd = strpos($_SERVER['PHP_SELF'], "change_pwd.php");
        $departments = strpos($_SERVER['PHP_SELF'], "departments.php");
        $log = strpos($_SERVER['PHP_SELF'], "log.php");
        $users = strpos($_SERVER['PHP_SELF'], "users.php");
        $computers = strpos($_SERVER['PHP_SELF'], "computers.php");
        $software = strpos($_SERVER['PHP_SELF'], "software.php");
        $system = strpos($_SERVER['PHP_SELF'], "system.php");
        $check_level = getUserLevel($_SESSION['user_code']);
      ?>
<!-- Sidebar navbar-nav bg-gradient-primary sidebar sidebar-dark accordion toggled-->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
        <div class="sidebar-brand-icon rotate-n-15">
          <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3"><?php echo getCompany();?> </div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <?php if($check_level == 69 || $check_level == 99): ?>
      <li class="nav-item <?php if($dashboard) echo 'active' ?>">
        <a class="nav-link" href="dashboard.php">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>แผงควบคุม</span></a>
      </li>
      <?php endif ?>
      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Heading -->
      <!--<div class="sidebar-heading">
        Interface
      </div>-->
      <!-- Nav Item - Home -->
      <li class="nav-item <?php if($request || $category || $service || $status || $view || $manage) echo 'active' ?>">
        <a class="nav-link" href="request.php">
          <i class="fas fa-fw fa-plus"></i>
          <span>ขอใช้บริการ</span></a>
      </li>
      
      
      
      <!-- Nav Item - Users -->
      <?php if($check_level == 69 || $check_level == 99): ?>
      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">   
      <!-- Heading -->
      <div class="sidebar-heading">
        การจัดการ
      </div>
      <li class="nav-item <?php if($users || $departments || $log) echo 'active' ?>">
        <a class="nav-link" href="users.php">
          <i class="fas fa-users"></i>
          <span>สมาชิก</span></a>
      </li>
      <li class="nav-item <?php if($computers || $software) echo 'active' ?>">
        <a class="nav-link" href="computers.php">
          <i class="fas fa-desktop"></i>
          <span>คอมพิวเตอร์</span></a>
      </li>
      <?php
        endif;
        if($check_level == 99):
      ?>
      <li class="nav-item <?php if($system) echo 'active' ?>">
        <a class="nav-link" href="system.php">
          <i class="fas fa-cogs"></i>
          <span>ตั้งค่าระบบ</span></a>
      </li>
      <?php endif; ?>
      
      
      <!-- Divider -->
      <hr class="sidebar-divider my-0">
      <!-- Nav Item - Pages Collapse Menu -->
      
      <li class="nav-item <?php if($profile || $chgpwd) echo 'active' ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
          <i class="fas fa-fw fa-user"></i>
          <span>ข้อมูลสมาชิก</span>
          <i class="fas fa-angle-<?php echo ($profile || $chgpwd ? 'down' : 'down') ?> px-3"></i>
        </a>
        <div id="collapseTwo" class="collapse <?php if($profile || $chgpwd) echo 'show'; ?>" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <!--<h6 class="collapse-header">Custom Components:</h6>?>-->
            <a class="collapse-item <?php if($profile) echo 'active' ?>" href="profile.php">โปรไฟล์</a>
            <a class="collapse-item <?php if($chgpwd) echo 'active' ?>" href="change_pwd.php">เปลี่ยนรหัสผ่าน</a>
          </div>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="logout.php" data-toggle="modal" data-target="#logoutModal">
          <i class="fas fa-sign-out"></i>
          <span>ออกระบบ</span></a>
      </li>

      <?php /*?><!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div><?php */?>

    </ul>
    <!-- End of Sidebar -->