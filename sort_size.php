<?php
include("connect.php");

if(isset($_POST['id'])){
    $id = $_POST['id'];
    
    $sql = "SELECT (price) FROM `menu_details` WHERE id = '".$id."'";
    $query = mysqli_query($conn,$sql);

    foreach ($query as  $value) {
        echo $value['price'];
    }
}

