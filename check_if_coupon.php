<?php
include("connect.php");

 if(isset($_POST['coupon'])){
     $coupon = $_POST['coupon'];
     $id_restaurant = $_POST['id_restaurant'];

     $sql = "SELECT * FROM `coupon`  WHERE coupon_code = '".$coupon."' AND restaurant_id = '".$id_restaurant."'";
     $query = mysqli_query($conn,$sql);
     foreach ($query as  $value) {
        echo $value['discount'];
    }
 }



?>