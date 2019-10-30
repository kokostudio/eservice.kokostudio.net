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
                    <div class="text-left h4">จัดการแผนก</div>
                  </div>
                  <div class="col col-md-6">
                    <a href="?act=add" class="d-sm-inline-block btn btn-sm btn-success shadow-sm fa-pull-right"><i class="fas fa-plus fa-sm text-white-50"></i> เพิ่ม</a><!--d-none d-sm-inline-block btn btn-sm btn-success shadow-sm fa-pull-right-->
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
                            <th>Name</th>
                            <th>Status</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            $departments = getDepartment();
                            foreach($departments as $key => $row):
                          ?>
                          <tr>
                            <td><?php echo $key+1 ?></td>
                            <td class="text-left"><?php echo $row['dep_name'] ?></td>
                            <td>
                              <?php echo ($row['dep_status'] == 1 
                                ? '<i class="fas fa-check text-success"></i>' 
                                : '<i class="fas fa-times-circle text-danger"></i>') 
                              ?>
                            </td>
                            <td>
                              <a href="?act=edit&id=<?php echo $row['dep_id'] ?>" class="btn btn-info btn-sm">
                                <i class="fas fa-edit"></i>
                              </a>
                              <a class="btn btn-danger btn-sm" href="?act=delete&id=<?php echo $row['dep_id'] ?>"
                                  onClick="return confirm('Are you sure?');">
                                  <i class="fas fa-trash-alt"></i>
                              </a>
                            </td>
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
                      <i class="fa fa-arrow-left pr-2"></i>Back to Home
                    </a>
                  </div>
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
        <nav>
          <ol class="breadcrumb bg-white border">
            <li class="breadcrumb-item">
              <a href="index.php"><i class="fas fa-home"></i></a>
            </li>
            <li class="breadcrumb-item">
              <a href="users.php"><i class="fas fa-users"></i></a>
            </li>
            <li class="breadcrumb-item">
              <a href="departments.php"><i class="fas fa-building mr-2"></i></a>
            </li>
            <li class="breadcrumb-item active">
              Add Department
            </li>
          </ol>
        </nav>

        <div class="row justify-content-center">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h5 class="text-center">Add Department</h5>
              </div>
              <div class="card-body">
                <form action="?act=insert" method="POST">
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">Department Name</label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" name="dep_name" required>
                    </div>
                  </div>
                  <div class="form-group row justify-content-center">
                    <div class="col-sm-3 pb-2">
                      <button class="btn btn-success btn-sm btn-block" name="btnInsert">
                        <i class="fa fa-check pr-2"></i>Confirm
                      </button>
                    </div>
                    <div class="col-sm-3 pb-2">
                      <a class="btn btn-danger btn-sm btn-block" href="departments.php">
                        <i class="fa fa-arrow-left pr-2"></i>Back to Home
                      </a>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>

        <?php
          endif;

          /*

          Insert Item

          */

          if($act == 'insert'):
            if(!isset($_POST['btnInsert'])){
              header('location: index.php');
              die();
            }

            $dep_name = $_POST['dep_name'];
            $dep_create = date('Y-m-d H:i:s');

            $data = [$dep_name,$dep_create];

            $sql = "INSERT INTO ex_department(dep_name,dep_create)
              VALUES(?,?)";
            $stmt = $dbcon->prepare($sql);
            $result = $stmt->execute($data);

            if($result) {
              alertMsg('success','Add Successfully','departments.php');
            } else {
              alertMsg('danger','Error, Please try again.','?act=add');
            }

            $stmt = null;
          endif;

          /*

          Edit Item 

          */

          if($act == 'edit'):
            include_once 'inc/alert.php';

            @$dep_id = $_GET['id'];
            $stmt = getQueryDepartment($dep_id);
            $row = $stmt->fetch();
        ?>
        <nav>
          <ol class="breadcrumb bg-white border">
            <li class="breadcrumb-item">
              <a href="index.php"><i class="fas fa-home"></i></a>
            </li>
            <li class="breadcrumb-item">
              <a href="users.php"><i class="fas fa-users"></i></a>
            </li>
            <li class="breadcrumb-item">
              <a href="departments.php"><i class="fas fa-building mr-2"></i></a>
            </li>
            <li class="breadcrumb-item active">
              Edit Department
            </li>
          </ol>
        </nav>

        <div class="row justify-content-center">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h5 class="text-center">Edit Department</h5>
              </div>
              <div class="card-body">
                <form action="?act=update" method="POST">
                  <div class="form-group row" style="display: none">
                    <label class="col-sm-4 col-form-label text-md-right">ID</label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" name="dep_id" 
                        value="<?php echo $row['dep_id'] ?>" readonly>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">Department Name</label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" name="dep_name" 
                        value="<?php echo $row['dep_name'] ?>" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">Status</label>
                    <div class="form-check form-check-inline">
                      <label class="form-check-label mx-3">
                        <input class="form-check-input" type="radio" name="dep_status" value="1"
                          <?php if($row['dep_status'] == '1') echo 'checked' ?>>Enable
                      </label>
                      <label class="form-check-label mx-3">
                        <input class="form-check-input" type="radio" name="dep_status" value="2"
                          <?php if($row['dep_status'] == '2') echo 'checked' ?>>Disable
                      </label>
                    </div>
                  </div>
                  <div class="form-group row justify-content-center">
                    <div class="col-sm-3 pb-2">
                      <button class="btn btn-success btn-sm btn-block" name="btnUpdate">
                        <i class="fa fa-check pr-2"></i>Confirm
                      </button>
                    </div>
                    <div class="col-sm-3 pb-2">
                      <a class="btn btn-danger btn-sm btn-block" href="departments.php">
                        <i class="fa fa-arrow-left pr-2"></i>Back to Home
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

          /*

          Update Item 

          */

          if($act == 'update'):
            if(!isset($_POST['btnUpdate'])){
              header('location: index.php');
              die();
            }

            $dep_id = $_POST['dep_id'];
            $dep_name = $_POST['dep_name'];
            $dep_status = $_POST['dep_status'];

            $data = [$dep_name,$dep_status,$dep_id];

            $sql = "UPDATE ex_department SET
              dep_name = ?,
              dep_status = ?
              WHERE dep_id = ?";
            $stmt = $dbcon->prepare($sql);
            $result = $stmt->execute($data);

            if($result) {
              alertMsg('success','Update Successfully','departments.php');
            } else {
              alertMsg('danger','Error, Please try again.',"?act=edit&id={$dep_id}");
            }

            $stmt = null;
          endif;

          /*

          Delete Item 

          */

          if($act == 'delete'):
            @$dep_id = $_GET['id'];
            $dep_status = 2;

            $data = [$dep_status,$dep_id];
            
            $sql = "UPDATE ex_department SET
              dep_status = ?
              WHERE dep_id = ?";
            $stmt = $dbcon->prepare($sql);
            $result = $stmt->execute($data);

            if($result) {
              alertMsg('success','Disable Successfully','departments.php');
            } else {
              alertMsg('danger','Error, Please try again.','departments.php');
            }

            $stmt = null;
          endif;
        ?>
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