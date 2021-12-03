<?php

include("connect.php");
session_start();
if (isset($_GET['ID_Restaurant'])) {
    $id_restaurant = $_GET['ID_Restaurant'];
    $_SESSION['restaurant_id'] = $_GET['ID_Restaurant'];

    if (isset($_SESSION["shopping_cart"])) {
        $item_array_id = array_column($_SESSION["shopping_cart"], "rest_id");
        if (!in_array($_SESSION['restaurant_id'], $item_array_id)) {
            unset($_SESSION["shopping_cart"]);
        }
    }
}

if (isset($_POST["add_to_cart"])) {
    if (isset($_SESSION["shopping_cart"])) {
        $item_array_id = array_column($_SESSION["shopping_cart"], "item_id");
        if (!in_array($_POST["id_discount"], $item_array_id)) {

            $item_array = array(
                'rest_id'               =>     $_SESSION['restaurant_id'],
                'item_id'               =>     $_POST['id_discount'],
                'item_name'               =>     $_POST["hidden_name"],
                'item_price'          =>     $_POST["hidden_price"],
                'item_quantity'          =>     $_POST["quantity"]
            );
            $_SESSION["shopping_cart"][] = $item_array;
            $name = $_POST["hidden_name"];
            echo <<<term
                      
                <div class="toast  text-white fade show  align-items-center" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="true" data-bs-delay="500" data-bs-animation="true">
                <div class="d-flex">
                  <div class="toast-body">
                   $name was added successfully!
                 </div>
                  <button type="button" class="btn-close  btn-close-white  me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
              </div>
term;
        } else {
            foreach ($_SESSION["shopping_cart"] as $keys => $values) {
                if ($_SESSION['shopping_cart'][$keys]['item_id'] == $_POST["id_discount"]) {
                    $_SESSION['shopping_cart'][$keys]['item_quantity'] =  $_SESSION['shopping_cart'][$keys]['item_quantity'] + $_POST["quantity"];
                    $name = $_SESSION['shopping_cart'][$keys]['item_name'];
                    $counts = $_POST["quantity"];
                    echo <<<term
                      
                        <div class="toast  text-white fade show  align-items-center" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="true" data-bs-delay="500" data-bs-animation="true">
                        <div class="d-flex">
                          <div class="toast-body">
                           $name was added $counts times again!
                         </div>
                          <button type="button" class="btn-close  btn-close-white  me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                      </div>
term;
                }
            }
        }
    } else {
        $item_array = array(
            'rest_id'               =>     $_SESSION['restaurant_id'],
            'item_id'               =>     $_POST["id_discount"],
            'item_name'               =>     $_POST["hidden_name"],
            'item_price'          =>     $_POST["hidden_price"],
            'item_quantity'          =>     $_POST["quantity"]
        );
        $_SESSION["shopping_cart"][] = $item_array;
        $name = $_POST["hidden_name"];
        echo <<<term
                      
            <div class="toast  text-white fade show  align-items-center" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="true" data-bs-delay="500" data-bs-animation="true">
            <div class="d-flex">
              <div class="toast-body">
               $name was added successfully!
             </div>
              <button type="button" class="btn-close  btn-close-white  me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
          </div>
term;
    }
}
if (isset($_GET["action"])) {
    if ($_GET["action"] == "clear") {
        foreach ($_SESSION["shopping_cart"] as $keys => $values) {
            if ($values["item_id"] == $_GET["id"]) {
                unset($_SESSION["shopping_cart"][$keys]);
                echo '<script>alert("Item Removed")</script>';
                echo '<script>window.location="rest_display.php"</script>';
            }
        }
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
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/main.css">
    <!-- Aos css  -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
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
                            <a class="nav-link active" aria-current="page" href="http://localhost/food_2/#">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="http://localhost/food_2/#restaurant_section">Restaurant</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="http://localhost/food_2/#about">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="http://localhost/food_2/#contact" tabindex="-1" aria-disabled="true">Contact</a>
                        </li>
                    </ul>
                    <button type="button" class="btn  position-relative shopping-btn" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample" style=" color: #333333; font-size: 19px;">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            <?php

                            echo (isset($_SESSION['shopping_cart']) && count($_SESSION['shopping_cart'])) > 0 ? count($_SESSION['shopping_cart']) : '0';

                            ?>

                        </span>
                    </button>

                    <!-- Shopping Cart Offcanvas -->
                    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
                        <div class="offcanvas-header">
                            <h5 class="offcanvas-title" id="offcanvasExampleLabel">Your Shopping Cart <i class="fas fa-cart-arrow-down" style="color: #60ba62;"></i></h5>
                            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-body overflow-scroll">
                            <?php
                            if (!empty($_SESSION["shopping_cart"])) {
                                $total = 0;
                            ?>
                                <div class="card border-0">
                                    <div class="card-header border-0">
                                        <div class="row justify-content-center">
                                            <div class="col">Title</div>
                                            <div class="col">Quantity</div>
                                            <div class="col">Price</div>
                                            <div class="col">Total</div>
                                            <div class="col">#</div>
                                        </div>
                                    </div>
                                    <div class="card-body ">
                                        <?php

                                        foreach ($_SESSION["shopping_cart"] as $keys => $values) {
                                        ?>

                                            <div class="row justify-content-center align-items-center align-self-center p-0 m-0 border-bottom overflow-hidden">
                                                <div class="col"><?php echo $values["item_name"]; ?></div>
                                                <div class="col"><?php echo $values["item_quantity"]; ?></div>
                                                <div class="col text-wrap"><?php echo $values["item_price"]; ?> €</div>
                                                <div class="col"><?php echo number_format($values["item_quantity"] * $values["item_price"], 2); ?> €</div>
                                                <div class="col"><a class="navbar-cart-product-close" href="rest_display.php?action=clear&id=<?php echo $values["item_id"]; ?>"><i class="fa fa-times"> </i></a></div>
                                            </div>
                                        <?php
                                            $total = $total + ($values["item_quantity"] * $values["item_price"]);
                                        }
                                        ?>
                                    </div>
                                    <div class="card-footer bg-transparent text-muted border-0">
                                        <div class="d-grid gap-2 d-flex justify-content-between">
                                            <div class="text-center">
                                                <span class="text-uppercase text-muted">Total:</span>
                                                <strong class="text-uppercase"><?php echo number_format($total, 2); ?> €</strong>
                                            </div>
                                            <button class="btn btn-sm btn-danger" type="button">Checkout <i class="fas fa-shopping-cart"></i></button>
                                        </div>


                                    </div>
                                </div>

                            <?php
                            } else {
                                echo "<p class='text-center'>Your cart is empty!</p>";
                            }
                            ?>



                        </div>

                    </div>
                    <!-- Shopping Cart Offcanvas End -->
                </div>
            </div>
        </nav>

    </header>
    <!-- Header finish -->


    <!-- Section About-->
    <section id="display_restaurant">
        <div class="container my-5">
            <div class="row p-4 pb-0 pe-lg-0 pt-lg-5 justify-content-center align-items-center">
                <?php
                $sql = "Select * from restaurant WHERE rs_id = '" . $_SESSION['restaurant_id'] . "'";
                $query = mysqli_query($conn, $sql);
                while ($rows = mysqli_fetch_array($query)) {
                ?>
                    <div class="col-lg-6 p-3 p-lg-5 pt-lg-3" data-aos="fade-right">
                        <h1 class="display-4  lh-1"><?= $rows['title']; ?> </h1>


                        <div class="d-grid gap-2 d-md-flex justify-content-md-start mb-4 mb-lg-3">
                            <ul class="list-group list-group-horizontal" id="list_tags">
                                <?php
                                $sqll = "SELECT * FROM `category` RIGHT JOIN menu ON category.id_category = menu.id_category 
                     LEFT JOIN restaurant ON menu.id_restaurant = restaurant.rs_id
                      WHERE '" . $rows['rs_id'] . "' = restaurant.rs_id GROUP BY category.id_category;";
                                $queryy = mysqli_query($conn, $sqll);
                                while ($rowss = mysqli_fetch_array($queryy)) {
                                ?>
                                    <li class="list-group-item mx-2 border">
                                        <i class="fas fa-tags"></i> <?= $rowss['name_category']; ?>

                                    </li>
                                <?php
                                }
                                ?>
                            </ul>

                        </div>
                        <ul class="list-unstyled" id="list_second">
                            <li>
                                <label class="d-flex gap-3">
                                    <span class="pt-1 form-checked-content">
                                        <h6>Location:</h6>
                                        <small class="d-block h5">
                                            <i class="fas fa-map-pin" style="color: #60ba62;"></i>
                                            <?= $rows['address']; ?>
                                        </small>
                                    </span>
                                </label>
                            </li>
                            <li>
                                <label class="d-flex gap-3">
                                    <span class="pt-2 form-checked-content">
                                        <h6>Open And Close Time:</h6>
                                        <small class="d-block h5">
                                            <i class="far fa-clock" style="color: #60ba62;"></i> <?= $rows['o_hr']; ?>/ <?= $rows['c_hr']; ?>
                                        </small>
                                    </span>
                                </label>
                            </li>
                            <li>
                                <label class="d-flex gap-3">
                                    <span class="pt-2 form-checked-content">
                                        <h6>Week Time We Working:</h6>
                                        <small class="d-block h5">
                                            <i class="fas fa-calendar-week" style="color: #60ba62;"></i>
                                            <?= $rows['o_days']; ?>
                                        </small>
                                    </span>
                                </label>
                            </li>
                        </ul>

                    </div>
                    <div class="col-lg-4 p-0 overflow-hidden" data-aos="fade-left">
                        <figure class="figure">
                            <img src="admin/Res_img/<?= $rows['image']; ?>" class="figure-img img-fluid rounded" alt="...">
                            <figcaption class="figure-caption text-center"><a class="nav-link text-dark" href="real-estate-single.html"><?= $rows['email']; ?></a></figcaption>
                        </figure>

                    </div>
                <?php } ?>
            </div>
        </div>

    </section>
    <!-- Featured Offerts starts -->
    <section>
        <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <?php
                $sql = "SELECT restaurant.title,discount.id,discount.n_discount,discount.content,discount.price,discount.restaurant_id,discount.img,discount.status FROM `restaurant` RIGHT JOIN discount ON restaurant.rs_id = discount.restaurant_id WHERE status = '1' AND discount.restaurant_id = '" . $_SESSION['restaurant_id'] . "'";
                $result = $conn->query($sql);
                ?>
                <?php foreach ($result as $index => $row) : ?>

                    <div class="carousel-item<?= !$index ? ' active' : '' ?>">
                        <img src="admin/Discount_img/<?= $row['img'] ?>" class="d-block w-100" alt="...">
                        <div class="carousel-caption d-none d-md-block">
                            <h4><?= $row['n_discount'] ?></h4>
                            <p><?= $row['content'] ?></p>
                            <div class="box">
                                <h5 class="float-left mx-5 d-inline"><i class="fas fa-thumbtack"></i> <?php echo $row['title']; ?></h5>
                                <h5 class="float-right mx-5 d-inline"><i class="fas fa-tags"></i><?= $row['price'] ?> €</h5>

                            </div>
                            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                <div class="container">
                                    <div class="row justify-content-center">
                                        <div class="col-lg-3 col-md-3 col-sm-3">

                                            <input type="number" name="quantity" id="quantity" value="1" min="1" max="50" step="1" />
                                        </div>
                                        <input type="hidden" name="id_discount" id="id_discount" value="<?= $row["id"]; ?>">
                                        <input type="hidden" name="hidden_name" id="hidden_name" value="<?php echo $row["n_discount"]; ?>" />
                                        <input type="hidden" name="hidden_price" id="hidden_price" value="<?= $row['price'] ?>" />
                                    </div>
                                </div>

                                <button type="submit" name="add_to_cart" id="btn-submit" class="btn btn btn-success btn-carousel">Oder Now <i class="fas fa-shopping-cart"></i></button>
                            </form>

                        </div>
                    </div>

                <?php endforeach; ?>
            </div>

        </div>
    </section>
    <!-- Featured restaurants ends -->
    <section id="category" class="my-5">
        <div class="container overflow-hidden">
            <div class="col-lg-6 mx-auto">
                <h1 class="display-5 text-center">Our Products</h1>
                <p class="lead mb-4 text-center">A highly efficient slip-ring scanner for today's diagnostic requirements.</p>

            </div>
            <div class="row justify-content-center align-self-center  gx-5 gy-3">
                <div class="col-md-6">
             
                            <ul class="list-group list-group-horizontal" id="list_tags">
                            <li class="list-group-item mx-2 border list actives" data-filter="all">
                                       <i class="fas fa-tags"></i> ALL

                                    </li>
                                <?php
                                $sqll = "SELECT * FROM `category` RIGHT JOIN menu ON category.id_category = menu.id_category 
                     LEFT JOIN restaurant ON menu.id_restaurant = restaurant.rs_id
                      WHERE '" . $_SESSION['restaurant_id'] . "' = restaurant.rs_id GROUP BY category.id_category;";
                                $queryy = mysqli_query($conn, $sqll);
                                
                                while ($rowss = mysqli_fetch_array($queryy)) {
                                ?>
                                    <li class="list-group-item mx-2 border list" data-filter="<?= $rowss['id_category']; ?>">
                                  <i class="fas fa-tags"></i> <?= $rowss['name_category']; ?>

                                    </li>
                                <?php
                                }
                                ?>
                            </ul>

                      
                </div>

            </div>
        </div>
    </section>
    <!-- Category section -->


    <section id="product_item" class="my-5">
        <div class="container overflow-hidden">
            <div class="row justify-content-start align-self-start  gx-5 gy-3">
                <?php
                $sql = "SELECT * FROM `menu` WHERE id_restaurant = '" . $_SESSION['restaurant_id'] . "'  ORDER BY `menu`.`name` ASC";
                $query = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_array($query)) {
                ?>
                    <div class="col-md-3 itemBox <?= $row["id_category"] ?>">
                        <div class="card" style="width: 18rem;">
                            <img src="admin/Menu_img/<?= $row["menu_img"] ?>" class="img-fluid rounded-start p-1 mx-auto d-block" alt="..." style="width: 150px;">
                            <div class="card-body">
                                <div class="d-flex justify-content-between gx-5 gy-3">
                                    <h5 class="card-title"><?= $row["name"] ?></h5>
                                   
                                        <span class="h4 text-success result"   data-id="res_<?= $row["id"]; ?>"></span>
                                 
                                </div>
                                <p class="card-text text-muted h-5">Tomato Sauce · Mozzarella · Basil</p>
                                <div class="d-flex flex-column bd-highlight mb-1">
                                    <div class="p-0 col-md-6">
                                        <span class="d-block">Quantity:</span>
                                        <input type="number" class="form-control-sm" name="quantity" id="quantity" value="1" min="1" max="50" step="1" />
                                    </div>
                                    <div class="p-0">

                                        <?php
                                        $sqll = "SELECT * FROM `menu_details` WHERE id_menu = '" . $row['id'] . "'";
                                        $queryy = mysqli_query($conn, $sqll);
                                        if ($queryy->num_rows > 1) {

                                        ?>
                                            <span class="d-block">Size:</span>
                                            <?php
                                            while ($rows = mysqli_fetch_array($queryy)) {
                                            ?>

                                                <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                                                    <input type="radio" class="btn-check radio" name="btnradio" value="<?= $rows["id"] ?>" id="<?= $rows["id"] ?>" autocomplete="off" checked>
                                                    <label class="btn btn-sm btn-outline-success" for="<?= $rows["id"] ?>"><?= $rows["size"] ?></label>

                                                </div>
                                               
                                            <?php }
                                          
                                        } elseif ($queryy->num_rows < 2) {
                                            while ($rows = mysqli_fetch_array($queryy)) {
                                            ?>
                                                <input type="hidden" onload="show_hide_guess(this.id);" class="noraml" id="<?= $rows["id"] ?>" name="materialExampleRadios" value="<?= $rows["size"] ?>">

                                        <?php
                                            }
                                        } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-muted bg-transparent border-0">
                                <div class="d-grid gap-2 col-7 mx-auto">
                                    <button class="btn btn-outline-success" type="button">Add To Cart <i class="fas fa-cart-plus"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>

            </div>
        </div>
    </section>


    <!-- Section Contact us -->





    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>


    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="package/src/bootstrap-input-spinner.js"></script>
    <script>
        $("input[type='number']").inputSpinner();
    </script>
    <!-- Aos Animation -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 600,
        });
    </script>


    <script>
        var toastElList = [].slice.call(document.querySelectorAll('.toast'))
        var toastList = toastElList.map(function(toastEl) {
            return new bootstrap.Toast(toastEl, {
                autohide: true,
                delay: 50
            });
            setTimeout(() => toastElList.remove(), delay + 20);
        })
    </script>
    <script>
        $(document).ready(function() {
        $('.list').click(function(){
          const value = $(this).attr('data-filter');
          if(value == 'all'){
              $('.itemBox').show('1000');
          }else{
            $('.itemBox').not('.'+value).hide('1000');
            $('.itemBox').filter('.'+value).show('1000');
          }
        });
        $('.list').click(function(){
            $(this).addClass('actives').siblings().removeClass('actives');
        });
            $(".card .card-body .btn-group .radio").change(function() {
                var id = $('input[name="btnradio"]:checked').attr('id');
                var result = $(this).parent().parent().parent().prev().prev().children("span").attr("data-id");
                //  console.log(result);
                $.ajax({
                    type: 'POST',
                    url: 'sort_size.php',
                    data: {
                        id: id
                    },
                    success: function(data) {
                        $('span[data-id="' + result +'"]').html(data + '€');
                    
                    }
                });

            });

        });
    </script>
    <script>
        function show_hide_guess(id) {
            // var result = $(this).parent().parent().parent().prev().prev().children("span").attr("data-id");
            $.ajax({
                url: 'sort_size.php',
                method: "POST",
                data: {
                    id: id
                },
                success: function(data) {
                    // console.log(data);
                    // $('span[data-id="' + result +'"]').html(data + '€');
                }

            });
        }

        (function(show_hide_guess) {
            var i, inputs = document.getElementsByClassName('noraml'),
                len = inputs.length;
              
            for (i = 0; i < len; i++) {
                var input = inputs[i],
                    id = input.getAttribute("id");
                //     console.log(id);
                //   var ids =  $('span[data-id="' + id +'"]');
                //     console.log(ids);
                    show_hide_guess(id);
            }

        })(show_hide_guess);
    </script>
    
</body>

</html>