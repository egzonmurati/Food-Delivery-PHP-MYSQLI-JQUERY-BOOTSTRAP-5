<?php

include("connect.php");
session_start();
if(isset($_GET['ID_Restaurant'])){
    $id_restaurant = $_GET['ID_Restaurant'];
    $_SESSION['restaurant_id'] = $_GET['ID_Restaurant'];

   

 }
 if(isset($_POST["add_to_cart"]))  
 {  
      if(isset($_SESSION["shopping_cart"]))  
      {  
           $item_array_id = array_column($_SESSION["shopping_cart"], "item_id");  
           if(!in_array($_GET["id"], $item_array_id))  
           {  
               
                $item_array = array(  
                     'item_id'               =>     $_GET["id"],  
                     'item_name'               =>     $_POST["hidden_name"],  
                     'item_price'          =>     $_POST["hidden_price"],  
                     'item_quantity'          =>     $_POST["quantity"]  
                );  
                $_SESSION["shopping_cart"][] = $item_array;  
           }else{
               foreach($_SESSION["shopping_cart"] as $keys => $values)  
               {  
               if($_SESSION['shopping_cart'][$keys]['item_id'] == $_GET["id"]){
                   $_SESSION['shopping_cart'][$keys]['item_quantity'] =  $_SESSION['shopping_cart'][$keys]['item_quantity'] + $_POST["quantity"];
               }
             
               }
           }
           
      }  
      else  
      {  
           $item_array = array(  
                'item_id'               =>     $_GET["id"],  
                'item_name'               =>     $_POST["hidden_name"],  
                'item_price'          =>     $_POST["hidden_price"],  
                'item_quantity'          =>     $_POST["quantity"]  
           );  
           $_SESSION["shopping_cart"][] = $item_array;  
      }  
 }  
?>
<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css">
  <link rel="stylesheet" href="css/main.css">
  <title>Food Delivery</title>
</head>

<body>
  <!-- Header -->
  <header>
    <nav class="navbar navbar-expand-lg navbar-light  sticky-top" style="background-color: #FFFFFF;" id="top">
      <div class="container">
        <div class="col-xs-12 col-sm-3 logo-block">
          <figure><a href="index.php"><img class="img-responsive" src="img/logo.png" alt="Madang Logo"></a></figure>
        </div>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ms-auto mb-1 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="#">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#restaurant_section">Restaurant</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#about">About</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#contact" tabindex="-1" aria-disabled="true">Contact</a>
            </li>
          </ul>
          <button type="button" class="btn  position-relative shopping-btn" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample" style=" color: #333333; font-size: 19px;">
            <i class="fas fa-shopping-cart"></i>
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
              99+

            </span>
          </button>

          <!-- Shopping Cart Offcanvas -->
          <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
            <div class="offcanvas-header">
              <h5 class="offcanvas-title" id="offcanvasExampleLabel">Shopping Cart <i class="fas fa-cart-arrow-down"></i></h5>
              <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
          <div class="container my-4">
            <div class="row justify-content-center align-items-center">
            <div class="col-md-11 col-lg-11 order-md-last">
        <h4 class="d-flex justify-content-between align-items-center mb-3">
          <span class="text-primary">Your cart</span>
          <span class="badge bg-primary rounded-pill">3</span>
        </h4>
        <table class="table table-bordered">  
                          <tr>  
                               <th width="40%">Item Name</th>  
                               <th width="10%">Quantity</th>  
                               <th width="20%">Price</th>  
                               <th width="15%">Total</th>  
                               <th width="5%">Action</th>  
                          </tr>  
                          <?php   
                          if(!empty($_SESSION["shopping_cart"]))  
                          {  
                               $total = 0;  
                               foreach($_SESSION["shopping_cart"] as $keys => $values)  
                               {  
                          ?>  
                          <tr>  
                          <td><?php echo $values["item_id"]; ?></td>  
                               <td><?php echo $values["item_name"]; ?></td>  
                               <td><?php echo $values["item_quantity"]; ?></td>  
                               <td>$ <?php echo $values["item_price"]; ?></td>  
                               <td>$ <?php echo number_format($values["item_quantity"] * $values["item_price"], 2); ?></td>  
                               <td> <a href="restaurant_display.php?action=clear" class="btn btn-danger btn-sm">Clear All </a>/<a href="restaurant_display.php?action=delete&id=<?php echo $values["item_id"]; ?>"><span class="text-danger">Remove</span></a></td>  
                          </tr>  
                          <?php  
                                    $total = $total + ($values["item_quantity"] * $values["item_price"]);  
                               }  
                          ?>  
                          <tr>  
                               <td colspan="3" align="right">Total</td>  
                               <td align="right">$ <?php echo number_format($total, 2); ?></td>  
                               <td></td>  
                          </tr>  
                          <?php  
                          }  
                          ?>  
                     </table>  

        <form class="card p-2">
          <div class="input-group">
            <input type="text" class="form-control" placeholder="Promo code">
            <button type="submit" class="btn btn-secondary">Redeem</button>
          </div>
        </form>
      </div>
            </div>
          </div>
            </div>
          </div>
          <!-- Shopping Cart Offcanvas End -->
        </div>
      </div>
    </nav>
    <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-inner">
        <?php
        $sql = "SELECT restaurant.title,discount.id,discount.n_discount,discount.content,discount.price,discount.restaurant_id,discount.img,discount.status FROM `restaurant` RIGHT JOIN discount ON restaurant.rs_id = discount.restaurant_id WHERE status = '1' AND discount.restaurant_id = '".$_SESSION['restaurant_id']."'";
        $result = $conn->query($sql);
        ?>
        <?php foreach ($result as $index => $row) : ?>
      
          <div class="carousel-item<?= !$index ? ' active' : '' ?>">
            <img src="admin/Discount_img/<?= $row['img'] ?>" class="d-block w-100" alt="...">
            <div class="carousel-caption d-none d-md-block">
              <h4><?= $row['n_discount'] ?></h4>
              <p><?= $row['content'] ?></p>
              <div class="box">
                <h5 class="float-left mx-5 d-inline"><i class="fas fa-thumbtack"></i> <?= $row['restaurant_id'] ?></h5>
                <h5 class="float-right mx-5 d-inline"><i class="fas fa-tags"></i><?= $row['price'] ?> €</h5>
              </div>
              <button class="btn btn btn-success btn-carousel" data-bs-toggle="modal" data-bs-target="#qtyModal">Oder Now <i class="fas fa-shopping-cart"></i></button>
                            <!-- Qty Modal -->
<div class="modal fade" id="qtyModal" tabindex="-1" aria-labelledby="qtyModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="qtyModalLabel">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form method="post" action="res_display.php?action=add&id=<?php echo $row["id"]; ?>">  
      <div class="row g-3 align-items-center">

  <div class="col-auto">
    <input type="text" name="quantity" class="form-control" value="1" />  
    <input type="hidden" name="hidden_name" value="<?php echo $row["n_discount"]; ?>" />  
    <input type="hidden" name="hidden_price" value="<?= $row['price'] ?>" />  
  </div>
  <div class="col-auto">
    <span id="passwordHelpInline" class="form-text">
      Must be 1 -8 characters long.
    </span>
  </div>
</div>

 
      </div>
      <div class="modal-footer">
      <button type="submit"   name="add_to_cart" class="btn btn-primary">Confirm Order</button>
     </form>
     
      </div>
    </div>
  </div>
</div>
            </div>
          </div>
          
        <?php endforeach; ?>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>
  </header>
  <!-- Header finish -->
  <!-- Section Main -->
  <section class="main">
    <div class="container">
      <h4 class="text-uppercase text-lt text-sp text-center">HOW IT WORKS</h4>
      <div class="row">
        <div class="col-xs-12 col-sm-4 choose wow fadeInLeft animated" style="visibility: visible; animation-name: fadeInLeft;">
          <div class="feature-item-wrap text-center">
            <figure><a href="#"><img class="img-responsive" src="img/restaurant.png" alt="Meal icon"></a></figure>
            <h5><a class="text-lt" href="#">Choose Restaurant</a></h5>
            <p>Choose your favorite meals and order online or by phone. It's easy to customize your order.</p>
          </div>
        </div>
        <div class="col-xs-12 col-sm-4 deliver wow fadeInUp animated" style="visibility: visible; animation-name: fadeInUp;">
          <div class="feature-item-wrap text-center">
            <figure><a href="#"><img class="img-responsive" src="img/meal.svg" alt="Meal icon"></a></figure>
            <h5><a class="text-lt" href="#">Choose Your Favorite</a></h5>
            <p>Choose your favorite meals and order online or by phone. It's easy to customize your order.</p>
          </div>
        </div>
        <div class="col-xs-12 col-sm-4 eat wow fadeInRight animated" style="visibility: visible; animation-name: fadeInRight;">
          <div class="feature-item-wrap text-center">
            <figure><a href="#"><img class="img-responsive" src="img/delivery.svg" alt="Delivery icon"></a></figure>
            <h5><a class="text-lt" href="#">We Deliver Your Food</a></h5>
            <p>We prepared and delivered meals arrive at your door. Duis autem vel eum iriure dolor in hendrerit in vulputate.</p>
          </div>
        </div>
      </div>
    </div>
    </div>


  </section>
  <!-- Section Main Finish-->
  <!-- Section About-->
  <sction id="about">
    <div class="container col-xxl-8 px-4 py-5">
      <div class="row flex-lg-row-reverse align-items-center g-5 py-5">
        <div class="col-10 col-sm-8 col-lg-6">
          <img src="img/Food Delivery.png" class="d-block mx-lg-auto img-fluid" alt="Bootstrap Themes" width="700" height="500" loading="lazy">
        </div>
        <div class="col-lg-6">
          <h1 class="display-5 fw-bold lh-1 mb-3">Delivered On Right Time & Place</h1>
          <p class="lead">Quickly design and customize responsive mobile-first sites with Bootstrap, the world’s most popular front-end open source toolkit, featuring Sass variables and mixins, responsive grid system, extensive prebuilt components, and powerful JavaScript plugins.</p>
          <div class="d-grid gap-2 d-md-flex justify-content-md-start">
            <div class="wrapper">
              <h4 class="text-center mb-4 fs-5">Follow Us</h4>
              <div class="buttons">
                <div class="icons">
                  <i class="fab fa-facebook"></i>
                </div>
                <span>Facebook</span>
              </div>
              <div class="buttons">
                <div class="icons">
                  <i class="fab fa-instagram"></i>
                </div>
                <span>Instagram</span>
              </div>
              <div class="buttons">
                <div class="icons">
                  <i class="fab fa-youtube"></i>
                </div>
                <span>Youtube</span>
              </div>
            </div>
          </div>
        </div>
      </div>
  </sction>
  <!-- Featured restaurants starts -->
  <section id="restaurant_section">
    <div class="container px-4 py-5" id="hanging-icons">
      <h1 class="display-4 fw-normal text-center">Display All Restaurant</h1>
      <div class="row mt-4">
        <?php 

        $sql = "Select * from restaurant";
        $query=mysqli_query($conn,$sql);
        while($rows=mysqli_fetch_array($query))
				{

        ?>
        <div class="col-lg-4">
          <div class="card shadow-sm card-hover border-0 h-100 ">
            <div class="card-img-top card-img-hover">
              <div class="position-absolute start-0 top-0 pt-3 ps-3"><span class="d-table badge bg-success mb-1"><?= $rows['title']; ?></span></div>
              <img src="admin/Res_img/<?= $rows['image']; ?>" alt="Image" class="card-img-top">
            </div>
            <div class="card-body position-relative pb-3">

              <h3 class="h6 mb-2 fs-base text-center"><a class="nav-link stretched-link" href="real-estate-single.html"><?= $rows['email']; ?></a></h3>

              <div class="row">
                <div class="col-6">
                  <ul class="list-unstyled text-center">
                    <li><i class="fas fa-map-pin"></i><span> <?= $rows['address']; ?> </span></li>
                    <?php 
                     $sqll = "SELECT * FROM `category` RIGHT JOIN menu ON category.id_category = menu.id_category 
                     LEFT JOIN restaurant ON menu.id_restaurant = restaurant.rs_id
                      WHERE '".$rows['rs_id']."' = restaurant.rs_id";
                     $queryy=mysqli_query($conn,$sqll);
                     while($rowss=mysqli_fetch_array($queryy))
                     {
                    ?>
                    <li><i class="fas fa-tags"></i><span> <?= $rowss['name_category']; ?></span></li>
                    <?php 
                     }
                    ?>
                  </ul>
                </div>
                <div class="col-6">
                  <ul class="list-unstyled text-center">
                    <li><i class="far fa-clock"></i><span> <?= $rows['o_hr']; ?>/  <?= $rows['c_hr']; ?></span></li>
                    <li><i class="fas fa-calendar-week"></i><span> <?= $rows['o_days']; ?></span></li>
                  </ul>
                </div>
              </div>
            </div>
           
              <div class="card-footer d-flex align-items-center justify-content-center mx-3 pt-3 text-nowrap">
              <a href="res_display.php?ID_Restaurant=<?= $rows['rs_id'];?>" class="btn btn-rest btn-outline-success" type="button">Order Now <i class="fas fa-cart-arrow-down"></i></a>
            </div>
            
            
          </div><!--  -->
        </div>
        <?php 
        };
        ?>
   

        <!-- End col -->

      </div>
    </div>
  </section>
  <!-- Featured restaurants ends -->

  <!-- subsctribe section -->
  <section class="block subscribe-block text-center">


    <div class="container">
      <div class="subscribe-wrap">
        <img src="img/sub.png" alt="" class="sub">
        <div class="top-text text-center wow fadeInUp text-sp text-lt animated" style="visibility: visible; animation-name: fadeInUp;">
          Be the lucky winner to get FREE Madang premium meals for one week. We are also offer you latest deal in your inbox!
        </div>
        <div class="subscribe-form wow fadeInDown animated" style="visibility: visible; animation-name: fadeInDown;">
          <form>
            <div class="input-group mb-3">
              <input type="text" class="form-control form-control-lg" placeholder="Enter your e-mail address here" aria-label="Recipient's username" aria-describedby="basic-addon2">
              <button type="button" class="btn-lg btn btn-outline-success">Subscribe</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>

  <!-- Section Contact us -->
  <section class="contact-section" id="contact">
    <div class="container">
      <h1 class="display-4 text-center my-5">Contact us</h1>
      <div class="row  justify-content-center  align-items-center">
        <div class="col-4 left ">
          <h4>Let's get in touch</h4>
          <p class="mb-4">We're open for any suggestion or just to have a chat</p>

          <ul class="list-unstyled">
            <li><i class="fas fa-map-pin"></i>
              <p><span>Address:</span> 198 West 21th Street</p>
            </li>
            <li><i class="fas fa-phone"></i>
              <p><span>Phone:</span> <a href="tel://1234567920">+ 1235 2355 98</a></p>
            </li>
            <li><i class="fas fa-paper-plane"></i>
              <p><span>Email:</span> <a href="mailto:info@yoursite.com">info@yoursite.com</a></p>
            </li>
            <li><i class="fas fa-globe"></i>
              <p><span>Website</span> <a href="#">yoursite.com</a></p>
            </li>
          </ul>
        </div>
        <div class="col-8 right">
          <h4>Get in touch</h4>
          <form class="row g-3 ">
            <div class="col-md-6">
              <label for="validationDefault01" class="form-label">Full Name</label>
              <input type="text" class="form-control  form-control-lg" id="validationDefault01" placeholder="Full Name" required>
            </div>
            <div class="col-md-6">
              <label for="validationDefault02" class="form-label">Email</label>
              <input type="email" class="form-control  form-control-lg" id="validationDefault02" placeholder="Email" required>
            </div>

            <div class="col-12">
              <label for="exampleFormControlTextarea1" class="form-label">Message</label>
              <textarea class="form-control  form-control-lg" id="exampleFormControlTextarea1" rows="3" placeholder="Message"></textarea>
            </div>
            <div class="col-12">
              <button class="btn btn-outline-success btn-lg" type="submit">Send Message</button>
            </div>
          </form>
        </div>

      </div>
    </div>
  </section>
  <section style="margin-top: 150px;">
    <div class="container-fluid mt-5">
      <div class="text-center mt-4">
        <h2>Delivery maps zone</h2>
        <p class="lead text-muted">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Quam, obcaecati.</p>
      </div>
      <iframe src="https://www.google.com/maps/d/embed?mid=1DNVDINHjXhATmHiz23Qp8kMwTqV4IqBi" width="100%" height="480"></iframe>

    </div>
  </section>
  <footer>
    <div class="container-fluid bg-dark mt-5">
      <div class="row justify-content-center align-items-center g-3">
        <div class="col-md-3 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4 text-center">
        <figure><a href="index.php"><img class="img-responsive" src="img/logo.png" alt="Madang Logo"></a></figure>
        </div>
        <div class="col-md-4 col-lg-4 col-xl-4 mx-auto mb-md-0 mb-4">
        <h5 class="text-uppercase fw-bold mb-4 text-center">Pages</h5>
        <ul class="list-unstyled text-small text-center">
          <li class="mb-2"><a class="link-secondary text-decoration-none" href="#top">Home</a></li>
          <li class="mb-2"><a class="link-secondary text-decoration-none" href="#restaurant_section">Restaurant</a></li>
          <li class="mb-2"><a class="link-secondary text-decoration-none" href="#about">About</a></li>
          <li class="mb-2"><a class="link-secondary text-decoration-none" href="#contact">Contact</a></li>
        </ul>
        </div>
        <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
                <!-- Links -->
                <h6 class="text-uppercase fw-bold mb-4 text-start">Contact</h6>
                <p class="text-start"><i class="fas fa-home me-3"></i> New York, NY 10012, US</p>
                <p  class="text-start">
                  <i class="fas fa-envelope me-3"></i>
                  info@example.com
                </p>
                <p  class="text-start"><i class="fas fa-phone me-3"></i> + 01 234 567 88</p>
                <p  class="text-start"><i class="fas fa-print me-3"></i> + 01 234 567 89</p>
              </div>
        <div class="col-md-4 col-lg-2 col-xl-2 mx-auto mb-md-0 mb-4 text-center">
        <a href="#top"  class="text-decoration-none"><i class="fas fa-arrow-alt-circle-up fa-2x" style="color: #60ba62;"></i></a>
        </div>
      </div>
    </div>
  </footer>


  <!-- Optional JavaScript; choose one of the two! -->

  <!-- Option 1: Bootstrap Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

  <!-- Option 2: Separate Popper and Bootstrap JS -->
  <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
</body>

</html>