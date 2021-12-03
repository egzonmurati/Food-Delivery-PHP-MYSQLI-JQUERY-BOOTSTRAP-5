
<?php

session_start();

if (isset($_POST['id_discount']) && isset($_POST['hidden_name']) && isset($_POST['hidden_price']) && isset($_POST['quantity'])) {

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
            'item_id'               =>     $_GET["id_discount"],
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

?>