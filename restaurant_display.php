<?php
include("connect.php");
  session_start();
 if(isset($_GET['ID_Restaurant'])){
     $id_restaurant = $_GET['ID_Restaurant'];
     $_SESSION['restaurant_id'] = $_GET['ID_Restaurant'];

     if(isset($_SESSION["shopping_cart"]))  
     {  
          $item_array_id = array_column($_SESSION["shopping_cart"], "item_id");  
          if(!in_array( $_SESSION['restaurant_id'], $item_array_id))  
          {  
              unset($_SESSION["shopping_cart"]);
           
          }  
          
     } 

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
  if(isset($_GET["action"]))  
  {  
       if($_GET["action"] == "delete")  
       {  
            foreach($_SESSION["shopping_cart"] as $keys => $values)  
            {  
                 if($values["item_id"] == $_GET["id"])  
                 {  
                      unset($_SESSION["shopping_cart"][$keys]);  
                      echo '<script>alert("Item Removed")</script>';  
                      echo '<script>window.location="restaurant_display.php"</script>';  
                 }  
            }  
       }  
       if ($_GET["action"] == "clear") {
        unset($_SESSION["shopping_cart"]);
        header("location:restaurant_display.php?clearall=1");
    }
  }  
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Restaurant</title>
</head>
<body>
<div class="container py-3">


  <main>
    <div class="row row-cols-1 row-cols-md-3 mb-3 text-center">
    
      <?php 
     
         $sql = "SELECT restaurant.rs_id,menu.id,menu.id_restaurant,menu.id_category,menu.name,menu.menu_img,category.id_category,category.name_category FROM `menu`LEFT JOIN restaurant ON menu.id_restaurant = restaurant.rs_id LEFT JOIN category ON menu.id_category = category.id_category WHERE '".$_SESSION['restaurant_id']."' = restaurant.rs_id";
         $query=mysqli_query($conn,$sql);
         while($row=mysqli_fetch_array($query))
         {
      ?>
      <div class="col">
      <form method="post" action="restaurant_display.php?action=add&id=<?php echo $row["id"]; ?>">  
        <div class="card mb-4 rounded-3 shadow-sm border-primary">
          <div class="card-header py-3 text-white bg-primary border-primary">
            <h4 class="my-0 fw-normal"><?= $row['name']; ?></h4>
          </div>
          <div class="card-body">
          <img src="admin/Menu_img/<?= $row['menu_img']; ?>" alt="Image" class="card-img-top">
            <ul class="list-unstyled mt-3 mb-4">
              <li><?= $row['name_category']; ?></li>
            </ul>
            <input type="text" name="quantity" class="form-control" value="1" />  
                               <input type="hidden" name="hidden_name" value="<?php echo $row["name"]; ?>" />  
                               <input type="text" name="hidden_price" value="5euro" />  
                               <input type="submit" name="add_to_cart" style="margin-top:5px;" class="btn btn-success" value="Add to Cart" />  
          </div>
        </div>
      </form>
      </div>
      <?php } ?>
    </div>

    <h2 class="display-6 text-center mb-4">Compare plans</h2>

    <div class="table-responsive">
    <div class="table-responsive">  
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
    </div>
  </main>


</div>
</body>
</html>