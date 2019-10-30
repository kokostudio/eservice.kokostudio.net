<?php
  ob_start();
  session_start();
  date_default_timezone_set("Asia/Bangkok");
  error_reporting(E_ALL);
  ini_set('display_errors', 1);
  
  include_once 'config/connection.php';
  include_once 'config/function.php';

  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;

  if(!isset($_SESSION['user_code'])){
    header('location: 404.html');
    die();
  }

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
          
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <div class="row">
                  <div class="col col-md-6 col-sm-12">
                    <div class="text-left h4">ขอใช้บริการ</div>
                  </div>
                  <div class="col col-md-6 col-sm-12 text-right">
                    <a href="?act=add" class="d-sm-inline-block btn btn-sm btn-success shadow-sm">
                      <i class="fas fa-plus mr-2"></i>เพิ่ม
                    </a>
                    <a href="?act=print" class="d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
                      <i class="fas fa-print mr-2"></i>พิมพ์
                    </a>
                    <!-- Button -->
                <?php
                  $check_level = getUserLevel($_SESSION['user_code']);

                  if($check_level == 69 || $check_level == 99):
                ?>
                     &nbsp;|&nbsp;
                    <a href="category.php" class="d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                      <i class="fas fa-list mr-2"></i>หมวดหมู่
                    </a>
                    <a href="service.php" class="d-sm-inline-block btn btn-sm btn-danger shadow-sm">
                      <i class="fas fa-chart-bar mr-2"></i>บริการ
                    </a>
                    <a href="status.php" class="d-sm-inline-block btn btn-sm btn-info shadow-sm">
                      <i class="fas fa-question mr-2"></i>สถานะ
                    </a>
                    <a href="manage.php" class="d-sm-inline-block btn btn-sm btn-warning shadow-sm">
                      <i class="fas fa-file-alt mr-2"></i>จัดการ
                    </a>
                    <?php endif ?>
                  </div>
                    
                
                 
                
                
                    
                  
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                  <div class="col-xl-4 col-md-6 mb-2">
                    <select class="form-control form-control-sm"
                      onChange="location = this.options[this.selectedIndex].value;">
                      <option value="request.php?cat=&serv=<?php echo @$_GET['serv'] ?>&stat=<?php echo @$_GET['stat'] ?>"
                        <?php if(empty(@$_GET['cat'])) echo 'selected' ?>>--- ค้นหา หมวดหมู่ ---</option>
                      <?php
                        $categorys = getCategorySelect();
                        foreach($categorys as $cat) : 
                      ?>
                      <option value="request.php?cat=<?php echo $cat['cat_id'] ?>&serv=<?php echo @$_GET['serv'] ?>&stat=<?php echo @$_GET['stat'] ?>" <?php if(@@$_GET['cat'] == $cat['cat_id']) echo 'selected' ?>><?php echo $cat['cat_name'] ?></option> 
                      <?php
                        endforeach;
                      ?>
                    </select>
                  </div>
                  <div class="col-xl-4 col-md-6 mb-2">
                    <select class="form-control form-control-sm"
                      onChange="location = this.options[this.selectedIndex].value;">
                      <option value="request.php?cat=<?php echo @$_GET['cat'] ?>&serv=&stat=<?php echo @$_GET['stat'] ?>"
                        <?php if(empty(@$_GET['serv'])) echo 'selected' ?>>--- ค้นหา บริการ ---</option>
                      <?php
                        $services = getServiceSelect();
                        foreach($services as $serv) : 
                      ?>
                      <option value="request.php?cat=<?php echo @$_GET['cat'] ?>&serv=<?php echo $serv['service_id'] ?>&stat=<?php echo @$_GET['stat'] ?>" <?php if(@@$_GET['serv'] == $serv['service_id']) echo 'selected' ?>><?php echo $serv['service_name'] ?></option> 
                      <?php
                        endforeach;
                      ?>
                    </select>
                  </div>
                  <div class="col-xl-4 col-md-6 mb-2">
                    <select class="form-control form-control-sm"
                      onChange="location = this.options[this.selectedIndex].value;">
                      <option value="request.php?cat=<?php echo @$_GET['cat'] ?>&serv=<?php echo @$_GET['serv'] ?>&stat="
                        <?php if(empty(@$_GET['stat'])) echo 'selected' ?>>--- ค้นหา สถานะ ---</option>
                      <?php
                        $statuses = getStatusSelect();
                        foreach($statuses as $status) : 
                      ?>
                      <option value="request.php?cat=<?php echo @$_GET['cat'] ?>&serv=<?php echo @$_GET['serv'] ?>&stat=<?php echo $status['status_id'] ?>" <?php if(@@$_GET['stat'] == $status['status_id']) echo 'selected' ?>><?php echo $status['status_name'] ?></option> 
                      <?php
                        endforeach;
                      ?>
                    </select>
                  </div>
                  <!--<div class="col-xl-3 col-md-6 mb-2">
                    <a href="?act=add" class="btn btn-success btn-sm btn-block">
                      <i class="fas fa-plus mr-2"></i>ขอใช้บริการ
                    </a>
                  </div>-->
                </div>

                

                <!-- Table -->
                <div class="row">
                  <div class="col-12">
                    <div class="table-responsive">
                      <table id="data" class="table table-bordered table-hover table-sm">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>เลขที่บริการ</th>
                            <th>ผู้ใช้บริการ</th>
                            <th>รายละเอียด</th>
                            <th>หมวดหมู่</th>
                            <th>วันที่</th>
                            <th>สถานะ</th>
                            <th>รายละเอียด</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            @$getCat = $_GET['cat'];
                            @$getServ = $_GET['serv'];
                            @$getStat = $_GET['stat'];
                            @$getUser = $_SESSION['user_code'];
                            @$requests = getFilterRequest($getYear,$getMonth,$getCat,$getServ,$getStat,$getUser);
                            foreach($requests as $key => $req):
                          ?>
                          <tr>
                            <td><?php echo $key+1 ?></td>
                            <td><?php echo $req['req_gen'] ?></td>
                            <td class="text-left"><?php echo getUserFullname($req['req_user']) ?></td>
                            <td class="text-left"><?php echo $req['req_text'] ?></td>
                            <td><?php echo $req['cat_name'] ?></td>
                            <td><?php echo convertDate($req['req_create']).'<br>'.date('H:i',strtotime($req['req_create'])).' น.' ?></td>
                            <td class="<?php echo colorStatus($req['req_status']) ?>">
                              <?php echo getStatusName($req['req_status']) ?>
                            </td>
                            <td>
                              <a href="request_view.php?id=<?php echo $req['req_id'] ?>" class="btn btn-info btn-sm">
                                <i class="fas fa-file-alt"></i>
                              </a>
                            </td>
                          </tr>
                          <?php 
                            endforeach; 
                            unset($req);
                          ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
          </div>
        <?php 
          endif; 
        /*

          Add Item

          */

          if($act == 'add'):
            include_once 'inc/alert.php';
        ?>
        

          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <div class="row">
                <div class="col col-md-6">
                  <div class="text-left h4">ขอใช้บริการ</div>
                </div>
                <div class="col col-md-6">
                    
                </div>
              </div>
            </div>
            <div class="card-body">
                <form action="?act=insert" method="POST" enctype="multipart/form-data">
                  <div class="form-group row" style="display: none">
                    <label class="col-sm-4 col-form-label text-md-right">รหัสผู้ใช้บริการ</label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" name="req_user" readonly
                        value="<?php echo $_SESSION['user_code'] ?>">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">ผู้ใช้บริการ</label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" readonly
                        value="<?php echo getUserFullname($_SESSION['user_code']) ?>">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">หมวดหมู่</label>
                    <div class="col-sm-3">
                      <select class="form-control form-control-sm" name="cat_id" 
                        onChange="getServiceList(this.value);" required>
                        <option value="">--- เลือก หมวดหมู่ ---</option>
                        <?php
                          $result = getCategorySelect();
                          foreach($result as $cat) : 
                        ?>
                        <option value="<?php echo $cat['cat_id'] ?>"><?php echo $cat['cat_name'] ?></option>
                        <?php
                          endforeach;
                          unset($cat);
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">บริการ</label>
                    <div class="col-sm-6">
                      <select class="form-control form-control-sm" name="service_id" id="service_list"
                        onChange="getBranch(this.value);" required>
                        <option value="">--- กรุณาเลือก บริการ ---</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">เพิ่มเอกสารหรือรูปประกอบ</label>
                    <div class="col-sm-4">
                      <input type="file" class="form-control" name="req_file">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">รายละเอียดเพิ่มเติม</label>
                    <div class="col-sm-6">
                      <textarea name="req_text" class="form-control" rows="5" required></textarea>
                    </div>
                  </div>
                  <div class="form-group row justify-content-center">
                    <div class="col-sm-3 pb-2">
                      <button class="btn btn-success btn-sm btn-block" name="btnInsert">
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

        <?php 
          endif;

          /*

          Insert Item

          */
          if($act == 'insert'):
            if(!isset($_POST['btnInsert'])){
              header('Location: index.php');
              die();
            }

            $req_user = $_POST['req_user'];
            $service_id = $_POST['service_id'];
            $service_name = getServiceName($service_id);
            $req_file = $_FILES['req_file']['name'];
            $req_text = $_POST['req_text'];
            $req_create = date('Y-m-d H:i:s');
            $req_year = date('Y');

            $data_check_last = [$req_year];
            $sql = "SELECT req_last FROM ex_request
            WHERE req_year = ?
            ORDER BY req_last DESC 
            LIMIT 1";
            $stmt = $dbcon->prepare($sql);
            $stmt->execute($data_check_last);
            $check_gen = $stmt->fetch();
            
            $req_last = STR_PAD(($check_gen['req_last']+1), 5, "0", STR_PAD_LEFT);
            $req_gen  = $req_year.$req_last;

            $data = [$req_year,$req_last,$req_gen,$req_user,$service_id,$req_text,$req_create];

            // Check Service
            if(empty($service_id)){
              alertMsg('danger','กรุณาเลือกบริการด้วยครับ','?act=add');
            }

            // Check Extension
            if($req_file){
              $file_name  = $_FILES['req_file']['name'];
              $file_tmpname  = $_FILES['req_file']['tmp_name'];
              $ext = pathinfo($file_name, PATHINFO_EXTENSION);
              $file_new_name = $req_gen.'.'.$ext;
              $path_file = "public/request/";
              $allow_extension = array('jpg','jpeg','png','xls','xlsx','doc','docx','pdf');

              if(!in_array($ext, $allow_extension)):
                alertMsg('danger','กรุณาเลือกเฉพาะไฟล์รูป JPG PNG หรือไฟล์เอกสาร Excel Word PDF เท่านั้นครับ','?act=add');
              endif;
            }

            $sql = "INSERT INTO ex_request(req_year,req_last,req_gen,req_user,service_id,req_text,req_create)
              VALUES(?,?,?,?,?,?,?)";
            $stmt = $dbcon->prepare($sql);
            $result = $stmt->execute($data);

            $last_id = $dbcon->lastInsertId();

            // Update Picture
            if($req_file):
              if($ext == 'xls' || $ext == 'xlsx' || $ext == 'doc' || $ext == 'docx' || $ext == 'pdf'){
                @move_uploaded_file($file_tmpname, iconv('UTF-8','TIS-620', $path_file.$file_new_name));
              }

              if($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png'){
                @$pictureSize   = getimagesize($file_tmpname);
                $pictureWidth   = 1000;
                @$pictureHeight = round($pictureWidth*$pictureSize[1]/$pictureSize[0]);
                $pictureType    = $pictureSize[2];

                if($pictureType == IMAGETYPE_PNG){

                  $pictureResource = imagecreatefrompng($file_tmpname);
                  $pictureX = imagesx($pictureResource);
                  $pictureY = imagesy($pictureResource);
                  $pictureTarget = imagecreatetruecolor($pictureWidth, $pictureHeight);
                  imagecopyresampled($pictureTarget, $pictureResource, 0, 0, 0, 0, $pictureWidth, $pictureHeight, $pictureX, $pictureY);
                  imagepng($pictureTarget, iconv('UTF-8','TIS-620',$path_file.$file_new_name));

                } else {

                  $pictureResource = imagecreatefromjpeg($file_tmpname);
                  $pictureX = imagesx($pictureResource);
                  $pictureY = imagesy($pictureResource);
                  $pictureTarget = imagecreatetruecolor($pictureWidth, $pictureHeight);
                  imagecopyresampled($pictureTarget, $pictureResource, 0, 0, 0, 0, $pictureWidth, $pictureHeight, $pictureX, $pictureY);
                  imagejpeg($pictureTarget, iconv('UTF-8','TIS-620',$path_file.$file_new_name));

                }
              }
                
              $data_picture = [$file_new_name,$last_id];

              $sql = "UPDATE ex_request SET
                req_file = ?
                WHERE req_id = ?";
              $stmt = $dbcon->prepare($sql);
              $stmt->execute($data_picture);

            endif;

            if($result){
              $stmt = getSystem();
              $row = $stmt->fetch();

              $user_gmail = "{$row['gmail_username']}";
              $pass_gmail = "{$row['gmail_password']}";
              $email_send = "{$row['gmail_username']}";
              $name_send  = "{$row['gmail_name']}";
              $email_receive = getUserEmail($req_user);
              $name_receive = getUserFullname($req_user);
              $date_send = date('d/m/Y');
              $time_send = date('H:i');
              $line_token = "{$row['line_token']}";

              // Load Composer's autoloader
              require 'vendor/autoload.php';

              try {
                $mail = new PHPMailer(true); 

                //Server settings
                $mail->SMTPDebug = 0;                                 // Enable verbose debug output
                $mail->isSMTP();                                      // Set mailer to use SMTP
                $mail->Host = "smtp.gmail.com";                       // Specify main and backup SMTP servers
                $mail->SMTPAuth = true;                               // Enable SMTP authentication
                $mail->Username = "{$user_gmail}";                    // SMTP username
                $mail->Password = "{$pass_gmail}";                    // SMTP password
                $mail->SMTPSecure = "tls";                            // Enable TLS encryption, `ssl` also accepted
                $mail->Port = 587;                                    // TCP port to connect to
                $mail->CharSet = "UTF-8";                             // CharSet UTF-8

                $mail->SMTPOptions = array(
                  'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                  )
                );

                //Recipients
                $mail->setFrom("{$email_send}", "{$name_send}");
                $mail->addAddress("{$email_receive}", "{$name_receive}");

                //Content
                $mail->isHTML(true);
                $mail->Subject = "ระบบแจ้งขอใช้บริการ";
                $mail->Body  = "เรียน คุณ {$name_receive} <br><br>";
                $mail->Body .= "ระบบได้รับเรื่องการแจ้งขอใช้บริการเรียบร้อยแล้วครับ<br><br>";
                $mail->Body .= "ขอใช้บริการ<br>";
                $mail->Body .= "บริการ : {$service_name}<br>";
                $mail->Body .= "รายละเอียด : {$req_text}<br>";
                $mail->Body .= "วันที่ : {$date_send}<br>";
                $mail->Body .= "เวลา : {$time_send} น.<br>";
                $mail->send();

$line_text = "
แจ้งเตือนการขอใช้บริการ
คุณ {$name_receive}
ขอใช้บริการ
เลขที่บริการ : {$req_gen}
บริการ : {$service_name}
รายละเอียด : {$req_text}
วันที่ : {$date_send}
เวลา : {$time_send} น.";

                echo lineNotify($line_text,$line_token);

                alertMsg('success','แจ้งขอใช้บริการเรียบร้อยแล้วครับ','request.php');

              } catch (Exception $e) {
                alertMsg('danger','ระบบมีปัญหา, กรุณาลองใหม่อีกครั้งครับ','request.php');
              }
              
            } else {
              alertMsg('danger','ระบบมีปัญหา, กรุณาลองใหม่อีกครั้งครับ','request.php');
            }

          endif;
        ?>

        </div>
        <!-- /.container-fluid -->
  
      </div>

      <?php include_once 'inc/footer.php'; ?>
    </div>
  </div>
  
  <script>
    $(document).ready(function() {
      $('#data').DataTable({
        "oLanguage": {
          "sLengthMenu": "แสดง _MENU_ ลำดับ ต่อหน้า",
          "sZeroRecords": "ไม่พบข้อมูลที่ค้นหา",
          "sInfo": "แสดง _START_ ถึง _END_ ของ _TOTAL_ ลำดับ",
          "sInfoEmpty": "แสดง 0 ถึง 0 ของ 0 ลำดับ",
          "sInfoFiltered": "(จากทั้งหมด _MAX_ ลำดับ)",
          "pageLength": 50,
          "sSearch": "ค้นหา :",
          "oPaginate": {
                "sFirst":    "หน้าแรก",
                "sLast":    "หน้าสุดท้าย",
                "sNext":    "ถัดไป",
                "sPrevious": "ก่อนหน้า"
            }
        }
      });
    });

    function getServiceList(val) {
      $.ajax({
        type: "POST",
        url: "getService.php",
        data:'cat_id='+val,
        success: function(data){
          $("#service_list").html(data);
        }
      });
    }
  </script>
</body>
</html>