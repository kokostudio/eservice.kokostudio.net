<?php
  ob_start();
  session_start();
  date_default_timezone_set("Asia/Bangkok");
  include_once 'config/connection.php';
  include_once 'config/function.php';

  $user_level = getUserLevel($_SESSION['user_code']);
  if(!isset($_SESSION['user_code']) || ($user_level == 1 || empty($user_level))){
    alertMsg('danger','ไม่พบหน้านี้ในระบบ','request.php');
  }
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
        
        <?php include_once 'inc/alert.php'; ?>
        
     

        <div class="card shadow mb-4">
            <div class="card-header py-3">
              <div class="row">
                <div class="col col-md-8">
                  <div class="text-left h4">ประวัติการใช้งาน</div>
                </div>
                <div class="col col-md-4 col-sm-12">
                    <!-- Filter -->
                
                    <select class="form-control form-control-sm"
                      onChange="location = this.options[this.selectedIndex].value;">
                      <option value="log.php?status="
                        <?php if(empty(@$_GET['dep'])) echo 'selected' ?>>--- เลือก ---</option>
                      <?php
                        $status = ['1' => 'Login Success','2' => 'Login Fail','3' => 'Change Password'];
                        foreach($status as $key => $value) : 
                      ?>
                      <option value="log.php?status=<?php echo $key ?>" 
                        <?php if(@$_GET['status'] == $key) echo 'selected' ?>><?php echo $value ?></option> 
                      <?php
                        endforeach;
                      ?>
                    </select>
                  
                </div>
              </div>
            </div>
              <div class="card-body">
                

                <!-- Table -->
                <div class="row justify-content-center">
                  <div class="col-12">
                    <div class="table-responsive">
                      <table id="data" class="table table-bordered table-hover table-sm">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>ชื่อ</th>
                            <th>สถานะ</th>
                            <th>โฮส</th>
                            <th>ไอพี</th>
                            <th>วันที่</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            @$getStatus = $_GET['status'];
                            $logs = getFilterLog($getStatus);
                            foreach($logs as $key => $row):
                              $log_date = date('d/m/Y', strtotime($row['log_create']));
                              $log_time = date('H:i', strtotime($row['log_create']));
                          ?>
                          <tr>
                            <td><?php echo $key+1 ?></td>
                            <td class="text-left"><?php echo $row['log_username'] ?></td>
                            <td>
                              <?php echo ($row['log_status'] == 1 
                                ? '<i class="fas fa-check text-success"></i>' 
                                : ($row['log_status'] == 2
                                ? '<i class="fas fa-times-circle text-danger"></i>'
                                : '<i class="fas fa-exchange-alt text-primary"></i>'))
                              ?>
                            </td>
                            <td><?php echo $row['log_host'] ?></td>
                            <td><?php echo $row['log_ip'] ?></td>
                            <td><?php echo 'วันที่ '.$log_date.' เวลา '.$log_time.' น.' ?></td>
                          </tr>
                          <?php 
                            endforeach; 
                            unset($row);
                          ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <div class="col-sm-3 pb-2">
                    <a class="btn btn-danger btn-sm btn-block" href="users.php">
                      <i class="fa fa-arrow-left pr-2"></i>กลับหน้าหลัก
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
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

  </script>
</body>
</html>