<?php
include("../connect.php");
session_start();
if (isset($_POST['submit'])) {
  if (empty($_POST['n_discount']) ||  $_POST['content'] == '' || $_POST['price'] == ''  || $_POST['restaurant'] == '') {
    $_SESSION['error'] =   '
        <div class="d-grid gap-2 col-11 mx-auto mt-2">
<div class="alert alert-warning d-flex align-items-center alert-dismissible fade show" role="alert">
  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Warning:">
    <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
  </svg>
  <div>
  All fields Must be Fill Up!
    <button type="button" class="btn-close" onClick="resetForm()" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
</div>
</div>
    ';
  } else {
    $fname = $_FILES['file']['name'];
    $temp = $_FILES['file']['tmp_name'];
    $fsize = $_FILES['file']['size'];
    $extension = explode('.', $fname);
    $extension = strtolower(end($extension));
    $fnew = uniqid() . '.' . $extension;
    $store = "Discount_img/" . basename($fnew);
    if ($extension == 'jpg' || $extension == 'png' || $extension == 'gif') {
      if ($fsize >= 1000000) {
        $_SESSION['error'] =   '
                <div class="d-grid gap-2 col-11 mx-auto mt-2">
        <div class="alert alert-warning d-flex align-items-center alert-dismissible fade show" role="alert">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Warning:">
            <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
          </svg>
          <div>
          <strong>Max Image Size is 1024kb!</strong> Try different Image!
            <button type="button" class="btn-close" onClick="resetForm()" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        </div>
        </div>
            ';
      } else {
        $n_discount = $_POST['n_discount'];
        $content = $_POST['content'];
        $price = $_POST['price'];
        $restaurant = $_POST['restaurant'];
        $sql =  "INSERT INTO discount (n_discount,content,price,img,restaurant_id) VALUES ('$n_discount','$content','$price','$fnew','$restaurant')";
        if ($conn->query($sql) === TRUE) {
          move_uploaded_file($temp, $store);
          $_SESSION['success'] =     '   
       <div class="d-grid gap-2 col-11 mx-auto mt-2">
<div class="alert alert-success d-flex align-items-center alert-dismissible fade show" role="alert">
  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Warning:">
  <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>  </svg>
  <div>
  New Discount Added Successfully!
    <button type="button"  onClick="resetForm()" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
</div>
</div>
       ';
       $sql = "SELECT email FROM subscribe";
       $result = $conn->query($sql);
       while($row = $result->fetch_assoc())
       {
         $addresses[] = $row['email'];
        }
        $to = implode(", ", $addresses);
        $subject=" Email Subscribe";
        $msg = "Thank for you"; 
        $message = "Discount with the name '".$n_discount."' in food_delivery!
        Visit the website for more discounts";    
        mail($to,$subject,$msg,$message); 
          header('Location: discount.php');
          exit();
        }
      }
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Food Order| Dashboard</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/overlayscrollbars/1.13.1/css/OverlayScrollbars.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <!-- Toggle button status css link -->
  <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
</head>

<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
  <div class="wrapper">


    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-dark">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>

      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <!-- Navbar Search -->
        <li class="nav-item">
          <a class="nav-link" data-widget="navbar-search" href="#" role="button">
            <i class="fas fa-search"></i>
          </a>
          <div class="navbar-search-block">
            <form class="form-inline">
              <div class="input-group input-group-sm">
                <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                  <button class="btn btn-navbar" type="submit">
                    <i class="fas fa-search"></i>
                  </button>
                  <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
            </form>
          </div>
        </li>

        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
          <a class="nav-link  dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="far fa-bell"></i>
          </a>

          <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
            <li><a class="dropdown-item" href="#">Action</a></li>
            <li><a class="dropdown-item" href="#">Another action</a></li>
            <li><a class="dropdown-item" href="#">Something else here</a></li>
          </ul>
        </li>

        <li class="nav-item">
          <a class="nav-link" data-widget="fullscreen" href="#" role="button">
            <i class="fas fa-expand-arrows-alt"></i>
          </a>
        </li>

      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="index.php" class="brand-link">
        <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">AdminLTE 3</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">


        <!-- Sidebar Menu -->
        <nav class="mt-3">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
            <li class="nav-item">
              <a href="index.php" class="nav-link ">
                <i class="far fa-circle nav-icon"></i>
                <p>Dashboard </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="category.php" class="nav-link">
                <i class="nav-icon fas fa-th"></i>
                <p>
                  Category

                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-copy"></i>
                <p>
                  Restaurant
                  <i class="fas fa-angle-left right"></i>

                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="add_restaurant.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Add Restaurant</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="restaurant.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Display Restaurant</p>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-chart-pie"></i>
                <p>
                  Menu
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="add_menu.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Add Menu</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="display_menu.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Display Menu</p>
                  </a>
                </li>

              </ul>
            </li>
            <li class="nav-item">
              <a href="discount.php" class="nav-link active">
                <i class="nav-icon fas fa-cart-arrow-down"></i>
                <p>
                  Discount

                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="coupon.php" class="nav-link">
                <i class="nav-icon fas fas fa-percentage"></i>
                <p>
                  Coupon

                </p>
              </a>
            </li>



            <li class="nav-header">REPORTS</li>
            <li class="nav-item">
              <a href="pages/calendar.html" class="nav-link">
                <i class="nav-icon fas fa-calendar-alt"></i>
                <p>
                  New Sales

                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="pages/calendar.html" class="nav-link">
                <i class="nav-icon fas fa-calendar-alt"></i>
                <p>
                  Total Sales

                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="pages/gallery.html" class="nav-link">
                <i class="nav-icon far fa-image"></i>
                <p>
                  Report
                </p>
              </a>
            </li>

          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Discount</h1>
            </div><!-- /.col -->

          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">





          <!-- Main row -->
          <div class="row">
            <!-- Left col -->
            <div class="col-md-8">


              <!-- /.row -->

              <!-- TABLE: LATEST ORDERS -->
              <div class="card">
                <div class="card-header border-transparent">
                  <h3 class="card-title">Latest Discount</h3>

                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                      <i class="fas fa-times"></i>
                    </button>
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                  <div class="table-responsive">
                    <table class="table m-0">
                      <thead>
                        <tr>
                          <th>Name</th>
                          <th>Content</th>
                          <th>Price</th>
                          <th>Image</th>
                          <th>Restaurant</th>
                          <th>Status</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php

                        $sql = "SELECT restaurant.title,discount.id,discount.n_discount,discount.content,discount.price,discount.restaurant_id,discount.img,discount.status FROM `restaurant` RIGHT JOIN discount ON restaurant.rs_id = discount.restaurant_id WHERE status = 1";
                        $result = $conn->query($sql);

                        if (!$result->num_rows > 0) {
                          echo '<td colspan="7"><center>No Categories-Data!</center></td>';
                        } else {
                          while ($row = $result->fetch_assoc()) {

                        ?>
                            <tr>
                              <td><?php echo $row['n_discount']; ?></td>
                              <td><?php echo $row['content']; ?></td>
                              <td><?php echo $row['price']; ?> €</td>
                              <td>
                                <div class="col-md-3 col-lg-8 m-b-10">
                                  <img src="Discount_img/<?php echo $row['img'] ?>" class="img-thumbnail" style="width:70px;height:70px;" />
                                </div>
                              </td>

                              <td><?php echo $row['title']; ?></td>

                              <td><input type="checkbox" data-toggle="toggle" data-on="Active" data-off="Block" data-size="small" data-onstyle="success" data-offstyle="danger" id='<?php echo $row['id'] ?>' class="change " <?php echo $row['status'] == '1' ? 'checked' : '' ?> /></td>
                            </tr>
                        <?php
                          }
                        }
                        ?>
                      </tbody>
                    </table>
                  </div>
                  <!-- /.table-responsive -->
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">
                  <button type="button" class="btn btn-danger float-right" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    View Deactive Discount <i class="fas fa-cart-arrow-down"></i>
                  </button>
                  <!-- Modal  View Deactive Discount -->
                  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" style=" min-width: 800px;">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          <div class="card-body p-0">
                            <div class="table-responsive">
                              <table class="table m-0">
                                <thead>
                                  <tr>
                                    <th>Name</th>
                                    <th>Content</th>
                                    <th>Price</th>
                                    <th>Image</th>
                                    <th>Restaurant</th>
                                    <th>Status</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php

                                  $sql = "SELECT restaurant.title,discount.id,discount.n_discount,discount.content,discount.price,discount.restaurant_id,discount.img,discount.status FROM `restaurant` RIGHT JOIN discount ON restaurant.rs_id = discount.restaurant_id WHERE status = '0'";
                                  $result = $conn->query($sql);

                                  if (!$result->num_rows > 0) {
                                    echo '<td colspan="7"><center>No Categories-Data!</center></td>';
                                  } else {
                                    while ($row = $result->fetch_assoc()) {

                                  ?>
                                      <tr>
                                        <td><?php echo $row['n_discount']; ?></td>
                                        <td><?php echo $row['content']; ?></td>
                                        <td><?php echo $row['price']; ?> €</td>
                                        <td>
                                          <div class="col-md-3 col-lg-8 m-b-10">
                                            <img src="Discount_img/<?php echo $row['img'] ?>" class="img-thumbnail" style="width:70px;height:70px;" />
                                          </div>
                                        </td>

                                        <td><?php echo $row['title']; ?></td>

                                        <td><input type="checkbox" data-toggle="toggle" data-on="Active" data-off="Block" data-size="small" data-onstyle="success" data-offstyle="danger" id='<?php echo $row['id'] ?>' class="change " <?php echo $row['status'] == '1' ? 'checked' : '' ?> /></td>
                                      </tr>
                                  <?php
                                    }
                                  }
                                  ?>
                                </tbody>
                              </table>
                            </div>
                            <!-- /.table-responsive -->
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                         
                        </div>
                      </div>
                    </div>
                  </div>


                </div>
                <!-- /.card-footer -->
              </div>
              <!-- /.card -->
            </div>
            <!-- /.col -->

            <div class="col-md-4">


              <!-- PRODUCT LIST -->
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Add Discount Products</h3>

                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                      <i class="fas fa-times"></i>
                    </button>
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                  <?php
                  if (isset($_SESSION['error']) && !empty($_SESSION['error'])) {
                    echo   $_SESSION['error'];
                  }
                  if (isset($_SESSION['success']) && !empty($_SESSION['success'])) {
                    echo $_SESSION['success'];
                  }
                  ?>
                  <form action='' method='post' enctype="multipart/form-data" class="mt-2">
                    <div class="d-grid gap-2 col-10 mx-auto mb-1">
                      <label for="validationCustom01" class="form-label">Name</label>
                      <input type="text" class="form-control" id="validationCustom01" name="n_discount" placeholder="Discount name..">

                    </div>
                    <div class="d-grid gap-2 col-10 mx-auto mb-1">
                      <label for="validationCustom01" class="form-label">Content</label>
                      <input type="text" class="form-control" id="validationCustom01" name="content" placeholder="Content..">

                    </div>
                    <div class="d-grid gap-2 col-10 mx-auto mb-1">
                      <label for="validationCustom01" class="form-label">Price</label>
                      <input type="text" class="form-control" id="validationCustom01" name="price" placeholder="1.5€">

                    </div>
                    <div class="d-grid gap-2 col-10 mx-auto mb-1">
                      <div class="form-group">
                        <label class="control-label">Select Restaurant</label>
                        <select name="restaurant" class="form-control custom-select" data-placeholder="Choose a Restaurant">
                          <option>--Select Restaurant--</option>
                          <?php
                          $ssql = "select * from restaurant";
                          $res = $conn->query($ssql);

                          while ($rows = $res->fetch_assoc()) {
                          ?>
                            <option value="<?php echo $rows["rs_id"]; ?>"><?php echo $rows["title"]; ?></option>
                          <?php } ?>
                        </select>
                      </div>

                    </div>
                    <div class="d-grid gap-2 col-10 mx-auto mb-4">
                      <div class="form-group has-danger">
                        <label class="control-label">Image</label>
                        <input type="file" name="file" id="lastName" class="form-control form-control-danger" placeholder="12n">
                      </div>
                    </div>
                    <div class="d-grid gap-2 col-6 mx-auto mb-4">
                      <button type="submit" name="submit" class="btn btn-info">Save Discount &nbsp
                        <i class="fas fa-save"></i></button>
                    </div>
                </div>
                <!-- /.card-body -->

                <!-- /.card-footer -->
              </div>
              <!-- /.card -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
        <!--/. container-fluid -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->

    <!-- /.control-sidebar -->


  </div>
  <!-- ./wrapper -->

  <!-- REQUIRED SCRIPTS -->
  <!-- jQuery -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <!-- Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <!-- overlayScrollbars -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/overlayscrollbars/1.13.1/js/OverlayScrollbars.min.js"></script>
  <!-- AdminLTE App -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.1.0/js/adminlte.min.js"></script>

  <!-- PAGE PLUGINS -->

  <!-- ChartJS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.4.1/chart.min.js"></script>
  <!-- Toggle PLUGINS -->
  <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
  <script type="text/javascript">
    function resetForm() {
      <?php

      unset($_SESSION['success']);
      unset($_SESSION['error']);

      ?>

    }
  </script>
  <script type="text/javascript">
    $(document).ready(function() {
      $('.change').change(function() {
        var id = $(this).attr("id");
        var check = ($(this).is(':checked')) ? '1' : '0';
        $.ajax({
          type: 'POST',
          url: 'changeStatus.php',
          data: {
            id: id,
            check: check
          },
          success: function(result) {
            setTimeout(function() {
              location.reload();
            }, 1000);
          }

        });
      });
    });
  </script>

</body>

</html>