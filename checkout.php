<?php

include("connect.php");
session_start();
if (isset($_SESSION['restaurant_id'])) {
    if (isset($_SESSION["shopping_cart"])) {
        $item_array_id = array_column($_SESSION["shopping_cart"], "rest_id");
        if (!in_array($_SESSION['restaurant_id'], $item_array_id)) {
            unset($_SESSION["shopping_cart"]);
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css">
    <title>Checkout</title>
</head>

<body>

    <div class="container mb-5">
        <main class="mb-5">
            <div class="py-5 text-center">

                <span class="d-block mx-auto mb-4" style="font-size: 3em; color: Dodgerblue;">
                    <i class="fas fa-credit-card"></i>
                </span>
                <h2>Checkout form</h2>
                <p class="lead">Below is an example form built entirely with Bootstrap’s form controls. Each required form group has a validation state that can be triggered by attempting to submit the form without completing it.</p>
            </div>

            <div class="row g-5">
                <div class="col-md-5 col-lg-4 order-md-last">
                    <h4 class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-primary">Your cart</span>
                        <span class="badge bg-primary rounded-pill"> <?php

                                                                        echo (isset($_SESSION['shopping_cart']) && count($_SESSION['shopping_cart'])) > 0 ? count($_SESSION['shopping_cart']) : '0';

                                                                        ?></span>
                    </h4>
                    <?php
                    if (!empty($_SESSION["shopping_cart"])) {
                        $total = 0;
                    ?>
                        <div class="card border-0">
                            <div class="card-header border-0">
                                <div class="row justify-content-center">
                                    <div class="col">Title</div>
                                    <div class="col">Size</div>
                                    <div class="col">Quantity</div>
                                    <div class="col">Price</div>
                                    <div class="col">Total</div>

                                </div>
                            </div>
                            <div class="card-body ">
                                <?php

                                foreach ($_SESSION["shopping_cart"] as $keys => $values) {
                                ?>

                                    <div class="row justify-content-start align-items-center align-self-center border-bottom overflow-hidden">
                                        <div class="col"><?php echo $values["item_name"]; ?></div>
                                        <div class="col"><?php echo $values["item_size"]; ?></div>
                                        <div class="col"><?php echo $values["item_quantity"]; ?></div>
                                        <div class="col text-wrap"><?php echo $values["item_price"]; ?> €</div>
                                        <div class="col"><?php echo number_format($values["item_quantity"] * $values["item_price"], 2); ?> €</div>
                                    </div>
                                <?php
                                    $total = $total + ($values["item_quantity"] * $values["item_price"]);
                                }
                                ?>
                            </div>
                            <div class="card-footer bg-transparent text-muted border-0">
                                <div class="d-grid gap-2 d-flex justify-content-end">
                                    <div class="text-end">
                                        <span class="text-uppercase text-muted">Total:</span>
                                        <strong class="text-uppercase" id="total_price"><?php echo number_format($total, 2); ?> €</strong>
                                        <input type="hidden" id="total_prices" value="<?php echo number_format($total, 2); ?>">
                                    </div>

                                </div>


                            </div>
                        </div>

                    <?php
                    } else {
                        echo "<p class='text-center'>Your cart is empty!</p>";
                    }
                    ?>


                    <form class="card p-2" method="POST" action="#">
                    <h5 class="text-center">Find promo code for gift: <span class="badge bg-success">50%</span></h5>
                        <div class="input-group">
                            <input type="hidden" id="id_restaurant" name="id_restaurant" value="<?= $_SESSION['restaurant_id']; ?>">
                            <input type="text" name="coupon" id="coupon" class="form-control" placeholder="Promo Code">
                            <button type="submit" id="submit" class="btn btn-primary">Coupon <i class="fas fa-percentage"></i></button>
                        </div>
                    </form>
                    <div id="succes_alert" style="display:none;">
                        <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                            <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                            </symbol>

                        </svg>
                        <div class="alert alert-success d-flex align-items-center" role="alert">
                            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:">
                                <use xlink:href="#check-circle-fill" />
                            </svg>
                            <div id="message">
                                An example success alert with an icon
                            </div>
                        </div>
                    </div>
                    <div id="danger_alert" style="display: none;">
                        <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                            <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                            </symbol>

                        </svg>
                        <div class="alert alert-danger d-flex align-items-center" role="alert">
                            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:">
                                <use xlink:href="#exclamation-triangle-fill" />
                            </svg>
                            <div>
                            This code does not exist on this storie!
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-7 col-lg-8">
                    <h4 class="mb-3">Billing address</h4>
                    <form class="needs-validation" action="finish_order.php" method="POST">
                        <input type="hidden" name="total_finish_price" id="total_finish_price" value="<?php echo number_format($total, 2); ?>">
                        <input type="hidden" name="total_coupon_price" id="total_coupon_price" value="<?php echo number_format($total, 2); ?>">
                        <div class="row g-3">
                            <div class="col-sm-6">
                                <label for="firstName" class="form-label">First name</label>
                                <input type="text" name="firstName" class="form-control" id="firstName" placeholder="" value="" required>
                                <div class="invalid-feedback">
                                    Valid first name is required.
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <label for="lastName" class="form-label">Last name</label>
                                <input type="text" name="lastName" class="form-control" id="lastName" placeholder="" value="" required>
                                <div class="invalid-feedback">
                                    Valid last name is required.
                                </div>
                            </div>



                            <div class="col-12">
                                <label for="email" class="form-label">Email <span class="text-muted">(Optional)</span></label>
                                <input type="email" name="email" class="form-control" id="email" placeholder="you@example.com">
                                <div class="invalid-feedback">
                                    Please enter a valid email address for shipping updates.
                                </div>
                            </div>

                            <div class="col-12">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" name="address" class="form-control" id="address" placeholder="1234 Main St" required>
                                <div class="invalid-feedback">
                                    Please enter your shipping address.
                                </div>
                            </div>

                            <div class="col-12">
                                <label for="address2" class="form-label">Address 2 <span class="text-muted">(Optional)</span></label>
                                <input type="text" name="address2" class="form-control" id="address2" placeholder="Apartment or suite">
                            </div>

                            <div class="col-md-6">
                                <label for="zip" class="form-label">Phone Number</label>
                                <input type="text" name="phone" class="form-control" id="phone" placeholder="" required>
                                <div class="invalid-feedback">
                                    Phone number required.
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="zip" class="form-label">Phone Number <span class="text-muted">(Optional)</span></label>
                                <input type="text" name="phone2" class="form-control" id="zip" placeholder="">
                                <div class="invalid-feedback">
                                    Phone number required.
                                </div>
                            </div>
                        </div>



                        <div class="form-check mt-3 mb-3">
                            <input type="checkbox" name="check" class="form-check-input" id="same-address" required>
                            <label class="form-check-label" for="same-address">Shipping address is the same as my billing address</label>
                        </div>


                        <hr class="my-4">


                        <button class="w-100 btn btn-primary btn-lg" name="submit" type="submit">Finish checkout</button>
                    </form>
                </div>
            </div>
        </main>

    </div>


    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#submit').click(function(event) {
                event.preventDefault();
                var coupon = $("#coupon").val();
                var id_restaurant = $("#id_restaurant").val();

                $.ajax({
                    type: 'POST',
                    url: 'check_if_coupon.php',
                    data: {
                        coupon: coupon,
                        id_restaurant: id_restaurant
                    },
                    success: function(data) {
                        var alert = '   <svg xmlns="http://www.w3.org/2000/svg" style="display: none;"><symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16"><path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/></symbol></svg><div class="alert alert-success d-flex align-items-center" role="alert"><svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg><div>An example success alert with an icon</div></div>';
                        var total = $('#total_prices').val();
                        var dec = (data / 100).toFixed(2); //its convert 10 into 0.10
                        var mult = total * dec;
                        var discont = total - mult;
                        totaldiscont = discont.toFixed(2);
                        if (data !== '') {
                            $('#total_coupon_price').val(totaldiscont);
                            $('#total_price').html("<del>" + total + "€" + "</del>").append("  " + totaldiscont + "€");
                            $('#succes_alert').fadeIn();
                            $('#message').html("You are winner " + data +" %" + " discount in total");
                            $('#coupon').val('');
                        } else {
                            $('#danger_alert').fadeIn();
                            
                            $('#coupon').val('');

                        }


                    }
                });
            });
        });
    </script>
</body>

</html>