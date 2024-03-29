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
        
        <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">แผงควบคุม</h1>
            
            <!--<a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>-->
          </div>
          

        <!-- Content Row -->
          
        <!-- Card -->
        <div class="row">
          <div class="col-xl-3 col-md-6 mb-2">
            <div class="card">
              <div class="card-body">
                <div class="row">
                  <div class="col-4 text-center">
                    <i class="fas fa-clock text-danger fa-3x"></i>
                  </div>
                  <div class="col-8 text-right">
                    <span class="right">
                      <div>วันนี้</div>
                      <div><?php echo number_format(getCountTodate()) ?></div>
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-xl-3 col-md-6 mb-2">
            <div class="card">
              <div class="card-body">
                <div class="row">
                  <div class="col-4 text-center">
                    <i class="fas fa-calendar text-primary fa-3x"></i>
                  </div>
                  <div class="col-8 text-right">
                    <span class="right">
                      <div>เดือน</div>
                      <div><?php echo number_format(getCountMonth()) ?></div>
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-xl-3 col-md-6 mb-2">
            <div class="card">
              <div class="card-body">
                <div class="row">
                  <div class="col-4 text-center">
                    <i class="fas fa-calendar-check text-success fa-3x"></i>
                  </div>
                  <div class="col-8 text-right">
                    <span class="right">
                      <div>ปี</div>
                      <div><?php echo number_format(getCountYear()) ?></div>
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-xl-3 col-md-6 mb-2">
            <div class="card">
              <div class="card-body">
                <div class="row">
                  <div class="col-4 text-center">
                    <i class="fas fa-calendar-alt text-warning fa-3x"></i>
                  </div>
                  <div class="col-8 text-right">
                    <span class="right">
                      <div>ทั้งหมด</div>
                      <div><?php echo number_format(getCountAll()) ?></div>
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-xl-3 col-md-6 mb-2">
            <div class="card">
              <div class="card-body">
                <div class="row">
                  <div class="col-4 text-center">
                    <i class="fas fa-users text-warning fa-3x"></i>
                  </div>
                  <div class="col-8 text-right">
                    <span class="right">
                      <div>ผู้ใช้งาน</div>
                      <div><?php echo number_format(getCountUser()) ?></div>
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-xl-3 col-md-6 mb-2">
            <div class="card">
              <div class="card-body">
                <div class="row">
                  <div class="col-4 text-center">
                    <i class="fas fa-desktop text-success fa-3x"></i>
                  </div>
                  <div class="col-8 text-right">
                    <span class="right">
                      <div>คอมพิวเตอร์</div>
                      <div><?php echo number_format(getCountComputer()) ?></div>
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-xl-3 col-md-6 mb-2">
            <div class="card">
              <div class="card-body">
                <div class="row">
                  <div class="col-4 text-center">
                    <i class="fas fa-list text-primary fa-3x"></i>
                  </div>
                  <div class="col-8 text-right">
                    <span class="right">
                      <div>หมวดหมู่</div>
                      <div><?php echo number_format(getCountCategory()) ?></div>
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-xl-3 col-md-6 mb-2">
            <div class="card">
              <div class="card-body">
                <div class="row">
                  <div class="col-4 text-center">
                    <i class="fas fa-briefcase text-danger fa-3x"></i>
                  </div>
                  <div class="col-8 text-right">
                    <span class="right">
                      <div>บริการ</div>
                      <div><?php echo number_format(getCountService()) ?></div>
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-xl-12 mb-2">
            <div class="card">
              <div class="card-body">
                <div class="row">
                  <div class="col-sm-6">
                    <canvas id="monthChart"></canvas>
                  </div>
                  <div class="col-sm-6">
                    <canvas id="yearChart"></canvas>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div> 
        <!-- End Card -->
        
      
        </div>
      </div>
      <?php include_once 'inc/footer.php'; ?>
    </div>
    
  </div>
 
  
  
  <script>
    var ctx = document.getElementById("monthChart").getContext('2d');
    var barChart = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: [
            <?php
              $months = getMonth();
              foreach($months as $value){ echo '"'.$value.'",'; }
            ?>
          ],
          datasets: [{
            label: "การใช้บริการรายเดือน ปี <?php echo date('Y') ?>",
            data: [
              <?php
                $months = getMonth();
                foreach($months as $key => $value){ echo '"'.getMonthChart($key).'",'; }
              ?>
            ],
            backgroundColor: [
              'rgba(62, 188, 229, 0.2)',
              'rgba(239, 104, 198, 0.2)',
              'rgba(164, 196, 0, 0.2)',
              'rgba(139, 104, 172, 0.2)',
              'rgba(241, 163, 11, 0.2)',
              'rgba(96, 170, 23, 0.2)',
              'rgba(250, 104, 1, 0.2)',
              'rgba(87, 214, 255, 0.2)',
              'rgba(1, 171, 170, 0.2)',
              'rgba(134, 121, 77, 0.2)',
              'rgba(230, 86, 122, 0.2)',
              'rgba(234, 193, 77, 0.2)'
            ],
            borderColor: [
              'rgba(62, 188, 229, 1)',
              'rgba(239, 104, 198, 1)',
              'rgba(164, 196, 0, 1)',
              'rgba(139, 104, 172, 1)',
              'rgba(241, 163, 11, 1)',
              'rgba(96, 170, 23, 1)',
              'rgba(250, 104, 1, 1)',
              'rgba(87, 214, 255, 1)',
              'rgba(1, 171, 170, 1)',
              'rgba(134, 121, 77, 1)',
              'rgba(230, 86, 122, 1)',
              'rgba(234, 193, 77, 1)'
            ],
            borderWidth: 1
          }]
        },
        options: {
          scales: {
            yAxes: [{
              ticks: {
                beginAtZero:true
              }
            }]
          }
        }
    });

    var ctx = document.getElementById("yearChart").getContext('2d');
    var barChart = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: [
            <?php
              $deps = getDepartment();
              foreach($deps as $row){ 
                $conv_dep = explode(' ', $row['dep_name']);
                echo "'{$conv_dep[0]}',"; 
              }
            ?>
          ],
          datasets: [{
            label: "การใช้บริการแยกตามฝ่าย/แผนก ปี <?php echo date('Y') ?>",
            data: [
              <?php
                $deps = getDepartment();
                foreach($deps as $row){ 
                  echo '"'.getDepartmentChart($row['dep_id']).'",';
                }
              ?>
            ],
            backgroundColor: [
              'rgba(62, 188, 229, 0.2)',
              'rgba(239, 104, 198, 0.2)',
              'rgba(164, 196, 0, 0.2)',
              'rgba(139, 104, 172, 0.2)',
              'rgba(241, 163, 11, 0.2)',
              'rgba(96, 170, 23, 0.2)',
              'rgba(250, 104, 1, 0.2)',
              'rgba(87, 214, 255, 0.2)',
              'rgba(1, 171, 170, 0.2)',
              'rgba(134, 121, 77, 0.2)',
              'rgba(230, 86, 122, 0.2)',
              'rgba(234, 193, 77, 0.2)'
            ],
            borderColor: [
              'rgba(62, 188, 229, 1)',
              'rgba(239, 104, 198, 1)',
              'rgba(164, 196, 0, 1)',
              'rgba(139, 104, 172, 1)',
              'rgba(241, 163, 11, 1)',
              'rgba(96, 170, 23, 1)',
              'rgba(250, 104, 1, 1)',
              'rgba(87, 214, 255, 1)',
              'rgba(1, 171, 170, 1)',
              'rgba(134, 121, 77, 1)',
              'rgba(230, 86, 122, 1)',
              'rgba(234, 193, 77, 1)'
            ],
            borderWidth: 1
          }]
        },
        options: {
          scales: {
            yAxes: [{
              ticks: {
                beginAtZero:true
              }
            }]
          }
        }
    });
  </script>    
</body>
</html>