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

  $user_level = getUserLevel($_SESSION['user_code']);
  if(!isset($_SESSION['user_code']) || ($user_level == 1 || empty($user_level))){
    alertMsg('danger','ไม่พบหน้านี้ในระบบ','request.php');
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
                  <div class="col col-md-6">
                    <div class="text-left h4">รายงานการขอใช้บริการ</div>
                  </div>
                  <div class="col col-md-6 col-sm-12 text-right">
                    <a href="report_request.php?year=<?php echo @$_GET['year'] ?>&month=<?php echo @$_GET['month'] ?>&cat=<?php echo @$_GET['cat'] ?>&serv=<?php echo @$_GET['serv'] ?>&stat=<?php echo @$_GET['stat'] ?>" target="_blank" 
                      class="d-sm-inline-block btn btn-sm btn-danger shadow-sm">
                      <i class="fas fa-file-pdf mr-2"></i>รายงาน PDF
                    </a>
                    <a href="report_excel.php?year=<?php echo @$_GET['year'] ?>&month=<?php echo @$_GET['month'] ?>&cat=<?php echo @$_GET['cat'] ?>&serv=<?php echo @$_GET['serv'] ?>&stat=<?php echo @$_GET['stat'] ?>" target="_blank" 
                      class="d-sm-inline-block btn btn-sm btn-success shadow-sm">
                      <i class="fas fa-file-excel mr-2"></i>รายงาน Excel
                    </a>
                  </div>
                </div>
            </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-xl-2 col-md-6 mb-2">
                    <select class="form-control form-control-sm"
                      onChange="location = this.options[this.selectedIndex].value;">
                      <option value="manage.php?year=&month=<?php echo @$_GET['month'] ?>&cat=<?php echo @$_GET['cat'] ?>&serv=<?php echo @$_GET['serv'] ?>&stat=<?php echo @$_GET['stat'] ?>"
                        <?php if(empty(@$_GET['year'])) echo 'selected' ?>>--- ค้นหา ปี ---</option>
                      <?php
                        $years = getYear();
                        foreach($years as $year) : 
                      ?>
                      <option value="manage.php?year=<?php echo $year ?>&month=<?php echo @$_GET['month'] ?>&cat=<?php echo @$_GET['cat'] ?>&serv=<?php echo @$_GET['serv'] ?>&stat=<?php echo @$_GET['stat'] ?>" <?php if(@@$_GET['year'] == $year) echo 'selected' ?>><?php echo $year ?></option> 
                      <?php
                        endforeach;
                      ?>
                    </select>
                  </div>
                  <div class="col-xl-2 col-md-6 mb-2">
                    <select class="form-control form-control-sm"
                      onChange="location = this.options[this.selectedIndex].value;">
                      <option value="manage.php?year=<?php echo @$_GET['year'] ?>&month=&cat=<?php echo @$_GET['cat'] ?>&serv=<?php echo @$_GET['serv'] ?>&stat=<?php echo @$_GET['stat'] ?>"
                        <?php if(empty(@$_GET['month'])) echo 'selected' ?>>--- ค้นหา เดือน ---</option>
                      <?php
                        $months = getMonth();
                        foreach($months as $key => $month) : 
                      ?>
                      <option value="manage.php?year=<?php echo @$_GET['year'] ?>&month=<?php echo $key ?>&cat=<?php echo @$_GET['cat'] ?>&serv=<?php echo @$_GET['serv'] ?>&stat=<?php echo @$_GET['stat'] ?>" <?php if(@@$_GET['month'] == $key) echo 'selected' ?>><?php echo $month ?></option> 
                      <?php
                        endforeach;
                      ?>
                    </select>
                  </div>
                  <div class="col-xl-3 col-md-6 mb-2">
                    <select class="form-control form-control-sm"
                      onChange="location = this.options[this.selectedIndex].value;">
                      <option value="manage.php?year=<?php echo @$_GET['year'] ?>&month=<?php echo @$_GET['month'] ?>&cat=&serv=<?php echo @$_GET['serv'] ?>&stat=<?php echo @$_GET['stat'] ?>"
                        <?php if(empty(@$_GET['cat'])) echo 'selected' ?>>--- ค้นหา หมวดหมู่ ---</option>
                      <?php
                        $categorys = getCategorySelect();
                        foreach($categorys as $cat) : 
                      ?>
                      <option value="manage.php?year=<?php echo @$_GET['year'] ?>&month=<?php echo @$_GET['month'] ?>&cat=<?php echo $cat['cat_id'] ?>&serv=<?php echo @$_GET['serv'] ?>&stat=<?php echo @$_GET['stat'] ?>" <?php if(@@$_GET['cat'] == $cat['cat_id']) echo 'selected' ?>><?php echo $cat['cat_name'] ?></option> 
                      <?php
                        endforeach;
                      ?>
                    </select>
                  </div>
                  <div class="col-xl-3 col-md-6 mb-2">
                    <select class="form-control form-control-sm"
                      onChange="location = this.options[this.selectedIndex].value;">
                      <option value="manage.php?year=<?php echo @$_GET['year'] ?>&month=<?php echo @$_GET['month'] ?>&cat=<?php echo @$_GET['cat'] ?>&serv=&stat=<?php echo @$_GET['stat'] ?>"
                        <?php if(empty(@$_GET['serv'])) echo 'selected' ?>>--- ค้นหา บริการ ---</option>
                      <?php
                        $services = getServiceSelect();
                        foreach($services as $serv) : 
                      ?>
                      <option value="manage.php?year=<?php echo @$_GET['year'] ?>&month=<?php echo @$_GET['month'] ?>&cat=<?php echo @$_GET['cat'] ?>&serv=<?php echo $serv['service_id'] ?>&stat=<?php echo @$_GET['stat'] ?>" <?php if(@@$_GET['serv'] == $serv['service_id']) echo 'selected' ?>><?php echo $serv['service_name'] ?></option> 
                      <?php
                        endforeach;
                      ?>
                    </select>
                  </div>
                  <div class="col-xl-2 col-md-6 mb-2">
                    <select class="form-control form-control-sm"
                      onChange="location = this.options[this.selectedIndex].value;">
                      <option value="manage.php?year=<?php echo @$_GET['year'] ?>&month=<?php echo @$_GET['month'] ?>&cat=<?php echo @$_GET['cat'] ?>&serv=<?php echo @$_GET['serv'] ?>&stat="
                        <?php if(empty(@$_GET['stat'])) echo 'selected' ?>>--- ค้นหา สถานะ ---</option>
                      <?php
                        $statuses = getStatusSelect();
                        foreach($statuses as $status) : 
                      ?>
                      <option value="manage.php?year=<?php echo @$_GET['year'] ?>&month=<?php echo @$_GET['month'] ?>&cat=<?php echo @$_GET['cat'] ?>&serv=<?php echo @$_GET['serv'] ?>&stat=<?php echo $status['status_id'] ?>" <?php if(@@$_GET['stat'] == $status['status_id']) echo 'selected' ?>><?php echo $status['status_name'] ?></option> 
                      <?php
                        endforeach;
                      ?>
                    </select>
                  </div>
                  <div class="col-xl-3 col-md-6 mb-2">
                    
                  </div>
                  <div class="col-xl-3 col-md-6 mb-2">
                    
                  </div>
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
                            <th>วันที่แจ้ง</th>
                            <th>วันที่เสร็จ</th>
                            <th>สถานะ</th>
                            <th>จัดการ</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            @$getYear = $_GET['year'];
                            @$getMonth = $_GET['month'];
                            @$getCat = $_GET['cat'];
                            @$getServ = $_GET['serv'];
                            @$getStat = $_GET['stat'];
                            @$requests = getFilterRequest($getYear,$getMonth,$getCat,$getServ,$getStat,$getUser);
                            foreach($requests as $key => $req):
                              $todate = strtotime(date('Y-m-d'));
                              $date_end = getDateEnd($req['req_id']);
                              $conv_date_end = strtotime(getDateEnd($req['req_id']));
                              $check_expire = $todate - $conv_date_end;
                          ?>
                          <tr <?php if($check_expire >= 0 && ($req['req_status'] == 2 || $req['req_status'] == 3)) echo "class='table-danger'" ?>>
                            <td><?php echo $key+1 ?></td>
                            <td><?php echo $req['req_gen'] ?></td>
                            <td class="text-left">
                                <?php echo getUserFullname($req['req_user']) ?><br>
                                <p class="small text-info"><?php echo getUserDepName($req['req_user']) ?></p>
                            </td>
                            <td class="text-left"><?php echo $req['req_text'] ?></td>
                            <td><?php echo convertDate($req['req_create']).'<br>'.date('H:i',strtotime($req['req_create'])).' น.' ?></td>
                            <td><?php echo (($req['req_status']==4) ? convertDate($date_end).' '.date('H:i',strtotime($req['req_create'])).' น.<br>ดำเนินการ '.datediff($req['req_create'],$date_end).' วัน' : '-') ?></td>
                            <td class="<?php echo colorStatus($req['req_status']) ?>">
                              <?php echo getStatusName($req['req_status']) ?>
                            </td>
                            <td>
                              <a href="request_manage.php?id=<?php echo $req['req_id'] ?>" class="btn btn-info btn-sm">
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
          </div>
        </div>
        <?php endif; ?>
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