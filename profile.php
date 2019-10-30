<?php
  ob_start();
  session_start();
  date_default_timezone_set("Asia/Bangkok");
  error_reporting(E_ALL);
  ini_set('display_errors', 1);
  include_once 'config/connection.php';
  include_once 'config/function.php';

  if(!isset($_SESSION['user_code'])){
    header('location: 404.html');
    die();
  }

  $user_code = $_SESSION['user_code'];
  $stmt = getQueryUser($user_code);
  $row = $stmt->fetch();

  $act = isset($_GET['act']) ? $_GET['act'] : 'index';
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
                    <div class="text-left h4">โปรไฟล์</div>
                  </div>
                  <div class="col col-md-6">
                    
                  </div>
                </div>
              </div>
              <div class="card-body">
                <form action="?act=update" method="POST" enctype="multipart/form-data">
                  <div class="form-group row" style="display: none">
                    <label class="col-sm-4 col-form-label text-md-right">ID</label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" name="user_id" 
                        value="<?php echo $row['user_id'] ?>" readonly>
                    </div>
                  </div>
                  <div class="form-group row justify-content-center">
                    <div class="col-sm-3">
                      <img src="public/images/users/<?php echo $row['user_picture'] ? $row['user_picture'] : 'no_picture.jpg' ?>" class="img-fluid img-profile rounded-circle">
                    </div>
                  </div>
                  <div class="form-group row justify-content-center">
                    <div class="col-sm-4">
                      <img src="" id="profile-picture-tag" class="img-fluid">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">เปลี่ยนรูป</label>
                    <div class="col-sm-4">
                      <input type="file" class="form-control" name="user_picture" id="profile-picture" accept="image/*">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">รหัสพนักงาน</label>
                    <div class="col-sm-3">
                      <input type="text" class="form-control" name="user_code"
                        value="<?php echo $row['user_code'] ?>" readonly>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">ชื่อ - นามสกุล</label>
                    <div class="input-group col-sm-6">
                      <input type="text" class="form-control" name="user_name" 
                        value="<?php echo $row['user_name'] ?>" required>
                      <input type="text" class="form-control" name="user_surname" 
                        value="<?php echo $row['user_surname'] ?>" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">ชื่อเล่น</label>
                    <div class="col-sm-3">
                      <input type="text" class="form-control" name="user_nickname" 
                        value="<?php echo $row['user_nickname'] ?>" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">ฝ่าย/แผนก</label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" 
                        value="<?php echo getDepartmentName($row['dep_id']) ?>" readonly>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">ชื่อผู้ใช้ระบบ</label>
                    <div class="col-sm-3">
                      <input type="text" class="form-control" 
                        value="<?php echo $row['user_username'] ?>" readonly>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">อีเมล</label>
                    <div class="col-sm-4">
                      <input type="email" class="form-control" name="user_email" required
                        value="<?php echo $row['user_email'] ?>">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">เบอร์โทรศัพท์</label>
                    <div class="col-sm-3">
                      <input type="text" class="form-control" name="user_telephone"
                        value="<?php echo $row['user_telephone'] ?>">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">มือถือ</label>
                    <div class="col-sm-3">
                      <input type="text" class="form-control" name="user_mobile"
                        value="<?php echo $row['user_mobile'] ?>">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">Line ID</label>
                    <div class="col-sm-3">
                      <input type="text" class="form-control" name="user_line" 
                        value="<?php echo $row['user_line'] ?>">
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

            $user_id = $_POST['user_id'];
            $user_code = $_POST['user_code'];
            $user_name = $_POST['user_name'];
            $user_surname = $_POST['user_surname'];
            $user_picture = $_FILES['user_picture']['name'];
            $user_nickname = $_POST['user_nickname'];
            $user_email = $_POST['user_email'];
            $user_telephone = $_POST['user_telephone'];
            $user_mobile = $_POST['user_mobile'];
            $user_line = $_POST['user_line'];

            $data_update = [$user_name,$user_surname,$user_nickname,$user_email,$user_telephone,$user_mobile,$user_line,$user_id];

            // Check Picture Extension
            if($user_picture){
              $picture_file_name  = $_FILES['user_picture']['name'];
              $picture_file_tmpname  = $_FILES['user_picture']['tmp_name'];
              $picture_ext = pathinfo($picture_file_name, PATHINFO_EXTENSION);
              $picture_file_new_name = $user_code.'.'.$picture_ext;
              $picture_file_path = "public/images/users/";
              $picture_allow_extension = array('jpg','jpeg','png');

              if(!in_array($picture_ext, $picture_allow_extension)):
                alertMsg('danger','กรุณาเลือกรูป JPG หรือ PNG เท่านั้นครับ','profile.php');
              endif;
            }

            $sql = "UPDATE ex_user SET
              user_name = ?,
              user_surname = ?,
              user_nickname = ?,
              user_email = ?,
              user_telephone = ?,
              user_mobile = ?,
              user_line = ?
              WHERE user_id = ?";
            $stmt = $dbcon->prepare($sql);
            $result = $stmt->execute($data_update);

            if($user_picture){
              $data_old_picture = [$user_id];
              $sql = "SELECT user_picture FROM ex_user WHERE user_id = ?";
              $stmt   = $dbcon->prepare($sql);
              $stmt->execute($data_old_picture);
              $check_picture_old  = $stmt->fetch();
              @unlink("public/images/users/".$check_picture_old['user_picture']);

              @$pictureSize   = getimagesize($picture_file_tmpname);
              $pictureWidth   = 500;
              @$pictureHeight = round($pictureWidth*$pictureSize[1]/$pictureSize[0]);
              $pictureType    = $pictureSize[2];

              if($pictureType == IMAGETYPE_PNG){

                $pictureResource = imagecreatefrompng($picture_file_tmpname);
                $pictureX = imagesx($pictureResource);
                $pictureY = imagesy($pictureResource);
                $pictureTarget = imagecreatetruecolor($pictureWidth, $pictureHeight);
                imagecopyresampled($pictureTarget, $pictureResource, 0, 0, 0, 0, $pictureWidth, $pictureHeight, $pictureX, $pictureY);
                imagepng($pictureTarget,$picture_file_path.$picture_file_new_name);

              } else {

                $pictureResource = imagecreatefromjpeg($picture_file_tmpname);
                $pictureX = imagesx($pictureResource);
                $pictureY = imagesy($pictureResource);
                $pictureTarget = imagecreatetruecolor($pictureWidth, $pictureHeight);
                imagecopyresampled($pictureTarget, $pictureResource, 0, 0, 0, 0, $pictureWidth, $pictureHeight, $pictureX, $pictureY);
                imagejpeg($pictureTarget,$picture_file_path.$picture_file_new_name);

              }

              $data_update_picture = [$picture_file_new_name,$user_code];

              $sql = "UPDATE ex_user SET
                user_picture    = ?
                WHERE user_code = ?";
              $stmt = $dbcon->prepare($sql);
              $stmt->execute($data_update_picture);
            }

            if($result){
              alertMsg('success','แก้ไขข้อมูลเรียบร้อยแล้วครับ','profile.php');
            } else {
              alertMsg('danger','ระบบมีปัญหา, กรุณาลองใหม่อีกครั้งครับ','profile.php');
            }

            $stmt = null;
          endif;
        ?>
      
    </div>
  </div>

  
  <?php include_once 'inc/footer.php'; ?>
    
    
  <script>
    function pictureShow(input) {
      if (input.files && input.files[0]){
          var reader = new FileReader();
          reader.onload = function(e){
              $('#profile-picture-tag').attr('src', e.target.result);
          }
          reader.readAsDataURL(input.files[0]);
      }
    }
    $("#profile-picture").change(function(){
      pictureShow(this);
    });
  </script>
</body>
</html>