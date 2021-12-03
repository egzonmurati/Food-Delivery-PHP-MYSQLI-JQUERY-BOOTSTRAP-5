<?php
include("../connect.php");
 if(isset($_POST["id"]) && isset($_POST["check"]))   { 
    $id = $_POST['id'];
    $check = $_POST['check'];
    $sql = "UPDATE discount SET  status='$check' where id='$id' ";
   
    if($conn->query($sql) === TRUE){
        header('Location: discount.php');
        exit();
    }  

}
?>