<?php
include("../connect.php");
session_start();

if(isset($_POST['submit']))           //if upload btn is pressed
{
	

			
		  
		
		
		if(empty($_POST['menu_name']) || empty($_POST['price']) || empty($_POST['size']) || empty($_POST['about']))
		{	
											$error = 	'<div class="alert alert-danger alert-dismissible fade show">
																<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
																<strong>All fields Must be Fillup!</strong>
															</div>';
									
		
								
		}
	else
		{
		
			                 	$fname = $_FILES['file']['name'];
								$temp = $_FILES['file']['tmp_name'];
								$fsize = $_FILES['file']['size'];
								$extension = explode('.',$fname);
								$extension = strtolower(end($extension));  
								$fnew = uniqid().'.'.$extension;
   
								$store = "Menu_img/".basename($fnew);                      // the path to store the upload image
	
					if($extension == 'jpg'||$extension == 'png'||$extension == 'gif' )
					{        
									if($fsize>=1000000)
										{
		
		
												$error = 	'<div class="alert alert-danger alert-dismissible fade show">
																<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
																<strong>Max Image Size is 1024kb!</strong> Try different Image.
															</div>';
	   
										}
		
									else
										{
												
												
												$menu_name=$_POST['menu_name'];
												$sql = "UPDATE menu SET  name='$menu_name',menu_img='$fnew' where id='$_GET[menu_upd]' ";
											
                                                if($conn->query($sql) === TRUE){
                                                    move_uploaded_file($temp, $store);
                                                    $count=count($_POST["id"]);
                                                  
                                                    for($i=0;$i<$count;$i++){
			                                    	$sqll = "UPDATE menu_details SET price='" . $_POST['price'][$i] . "', size='" . $_POST['size'][$i] . "', about='" . $_POST['about'][$i] . "' WHERE id='" . $_POST['id'][$i] . "'";
                                                    $result1=$conn->query($sqll);
                                                }
                                                echo $count;
                                                  
                                                    $success = 	'<div class="alert alert-success alert-dismissible fade show">
																<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
																<strong>Congrass!</strong> New Restaurant Added Successfully.
															</div>';
                                                            header("location:display_menu.php");  
                                              
                                            }
												
                
	
										}
					}
					elseif($extension == '')
					{
						$error = 	'<div class="alert alert-danger alert-dismissible fade show">
																<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
																<strong>select image</strong>
															</div>';
					}
					else{
					
											$error = 	'<div class="alert alert-danger alert-dismissible fade show">
																<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
																<strong>invalid extension!</strong>png, jpg, Gif are accepted.
															</div>';
						
	   
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
    <!-- dataTables css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap5.min.css">
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
                            <a href="#" class="nav-link ">
                                <i class="nav-icon fas fa-copy"></i>
                                <p>
                                    Restaurant
                                    <i class="fas fa-angle-left right"></i>

                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="add_restaurant.php" class="nav-link ">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Add Restaurant</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="restaurant.php" class="nav-link ">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Display Restaurant</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link active">
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
                                    <a href="display_menu.php" class="nav-link active">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Display Menu</p>
                                    </a>
                                </li>

                            </ul>
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
                            <h1 class="m-0">Update</h1>
                        </div><!-- /.col -->

                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
   	
                <div class="row">
                    <div class="col-12">
                        
                
						
						
						     <div class="card">
                          
                             <h4 class="m-b-0 ">Update Menu</h4>
                             <?php
                                    if (isset($error) && !empty($error)) {
                                        echo $error;
                                    }
                                    if (isset($success) && !empty($success)) {
                                        echo $success;
                                    }
                                    ?>
                            <div class="card-body">
                                <form action='' method='post'  enctype="multipart/form-data">
                                    <div class="form-body">
                                       <?php $ssql ="select * from menu where id='$_GET[menu_upd]'";
                                             $result = $conn->query($ssql);
                                             $row = $result->fetch_assoc();
													?>
                                             <?php $sql ="select * from menu_details where id_menu='$_GET[menu_upd]'";
                                             $result = $conn->query($sql);
                                             $rows = $result->fetch_assoc();
													?>
                                        <hr>
                                        <div class="row p-t-20">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Menu Name</label>
                                                    <input type="text" name="menu_name" value="<?php echo $row['name'];  ?>" class="form-control" placeholder="John doe">
                                                   </div>
                                            </div>
                                            <!--/span-->
                                           	
											<div class="col-md-6">
                                                <div class="form-group has-danger">
                                                    <label class="control-label">Image</label>
                                                    <input type="file" name="file"  id="lastName"  class="form-control form-control-danger" placeholder="12n">
                                                    </div>
                                            </div>
                                        </div>
                                        <div class="row p-t-20">
                                        <div class="col-md-10 mx-auto mb-5 mt-4">
                                        <table class="table table-bordered">
  <thead>
    <tr>
    <th></th>
      <th>Price (€)</th>
      <th>Size Product</th>
      <th>About</th>

    </tr>
  </thead>
  <tbody>
      <?php
$sql ="select * from menu_details where id_menu='$_GET[menu_upd]'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    // output data of each row
    while ($rows = $result->fetch_assoc()) {
       


?>
     
  <tr>
  <td> 
      <input type="text" name="id[]"  value="<?php echo $rows['id'];  ?>">
  </td>

                <td>  <div class="form-group">
                                                    <label class="control-label">Menu Name</label>
                                                    <input type="text" name="price[]" value="<?php echo $rows['price'];  ?>" class="form-control" placeholder="John doe">
                                                   </div>
                                                  </td>
                <td><div class="form-group">
                                                    <label class="control-label">Menu Name</label>
                                                    <input type="text" name="size[]" value="<?php echo $rows['size'];  ?>" class="form-control" placeholder="John doe">
                                                   </div></td>
                <td>
                <div class="form-group">
                                                    <label class="control-label">Menu Name</label>
                                                    <input type="text" name="about[]" value="<?php echo $rows['about'];  ?>" class="form-control" placeholder="John doe">
                                                   </div></td>
             

            </tr>
            <?php
        }
    } else {
        ?>
        <td>No Item !</td>
    <?php

    }
    ?>
  </tbody>
</table>
                                        </div>
                                        </div>
                                   
                                      
                                            <!--/span-->
                                        </div>
                                    </div>
                                 
                                    <div class="d-grid gap-2 col-6 mx-auto mb-5">
                                    <input type="submit" name="submit" class="btn btn-primary" value="Update"> 
 
</div>
                                </form>
                            </div>
                        </div>
						
					
						 </div>
                      
                            </div>
                        </div>
                    </div>
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
    <!-- dataTables link -->
   <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
   <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
   <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
    $('#example').DataTable();
} );
    </script>
</body>

</html>