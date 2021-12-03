<?php
include("../connect.php");
 if(isset($_POST["id"]) && isset($_POST["check"]))   { 
    $id = $_POST['id'];
    $check = $_POST['check'];
    $sql = "UPDATE coupon SET  status_coupon='$check' where coupon_id='$id' ";
   
    if($conn->query($sql) === TRUE){
        header('Location: coupon.php');
        exit();
    }  

}
?>