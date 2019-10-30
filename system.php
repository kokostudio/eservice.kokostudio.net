<?php
  ob_start();
  session_start();
  date_default_timezone_set("Asia/Bangkok");
  include_once 'config/connection.php';
  include_once 'config/function.php';

  $user_level = getUserLevel($_SESSION['user_code']);
  if(!isset($_SESSION['user_code']) || $user_level != 99 || empty($user_level)){
    alertMsg('danger','ไม่พบหน้านี้ในระบบ','request.php');
  }

  $act = isset($_GET['act']) ? $_GET['act'] : 'index';

  $stmt = getSystem();
  $row = $stmt->fetch();
?>
<?php include_once 'inc/header.php' ?>
<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">
    
  <?php include_once 'inc/sidemenu.php' ?>

  <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">
        
      <?php include_once 'inc/navbar.php' ?>
  
      <!-- Begin Page Content -->
        <div class="container-fluid">
        <?php include_once 'inc/alert.php'; ?>

        <?php 
          /*

          Index

          */
          if($act == 'index'): 
            include_once 'inc/alert.php';
        ?>

        
        <div class="row justify-content-center">
          <div class="col-12">
            <div class="card">
              <div class="card-header py-3">
              <div class="row">
                  <div class="col col-md-6">
                    <div class="text-left h4">ข้อมูลระบบ</div>
                  </div>
                  <div class="col col-md-6">
                    
                  </div>
                </div>
              </div>
              <div class="card-body">
                <form action="?act=update" method="POST">
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">ชื่อแบรน</label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" name="company_name" 
                        value="<?php echo $row['company_name'] ?>" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">ชื่อ Gmail</label>
                    <div class="col-sm-3">
                      <input type="text" class="form-control" name="gmail_name" 
                        value="<?php echo $row['gmail_name'] ?>" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">ชื่อผู้ใช้ระบบ Gmail</label>
                    <div class="col-sm-3">
                      <input type="email" class="form-control" name="gmail_username" 
                        value="<?php echo $row['gmail_username'] ?>" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">รหัสผ่าน Gmail</label>
                    <div class="col-sm-3">
                      <input type="password" class="form-control" name="gmail_password" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">Line Token</label>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="line_token" 
                        value="<?php echo $row['line_token'] ?>">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">ค่าเริ่มต้นรหัสผ่าน</label>
                    <div class="col-sm-3">
                      <input type="text" class="form-control" name="password_default" 
                        value="<?php echo $row['password_default'] ?>">
                    </div>
                  </div>
                  <div class="form-group row justify-content-center">
                    <div class="col-sm-3 pb-2">
                      <button class="btn btn-success btn-sm btn-block" name="btnUpdate">
                        <i class="fa fa-check pr-2"></i>ยืนยัน
                      </button>
                    </div>
                    <div class="col-sm-3 pb-2">
                      <a class="btn btn-danger btn-sm btn-block" href="request.php">
                        <i class="fa fa-arrow-left pr-2"></i>กลับหน้าหลัก
                      </a>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>

      <?php
        $stmt = null;
        endif;

        if($act == 'update'):
            if(!isset($_POST['btnUpdate'])){
              header('location: index.php');
              die();
            }

            $system_id = 1;
            $company_name = $_POST['company_name'];
            $gmail_name = $_POST['gmail_name'];
            $gmail_username = $_POST['gmail_username'];
            $gmail_password = $_POST['gmail_password'];
            $line_token = $_POST['line_token'];
            $password_default = $_POST['password_default'];
            $user_code = $_SESSION['user_code'];

            $data_update = [$company_name,$gmail_name,$gmail_username,$gmail_password,$line_token,$password_default,$user_code,$system_id];

            $sql = "UPDATE ex_system SET
              company_name = ?,
              gmail_name = ?,
              gmail_username = ?,
              gmail_password = ?,
              line_token = ?,
              password_default = ?,
              user_code = ?
              WHERE system_id = ?";
            $stmt = $dbcon->prepare($sql);
            $result = $stmt->execute($data_update);

            if($result){
              alertMsg('success','แก้ไขข้อมูลเรียบร้อยแล้วครับ','system.php');
            } else {
              alertMsg('danger','ระบบมีปัญหา, กรุณาลองใหม่อีกครั้งครับ','system.php');
            }

            $stmt = null;
          endif;
      ?>

    </div>
  </div>

  
  <?php include_once 'inc/footer.php'; ?>
</body>
</html>