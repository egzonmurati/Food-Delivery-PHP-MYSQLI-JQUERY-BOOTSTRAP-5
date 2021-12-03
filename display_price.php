<?php
include("connect.php");

if(isset($_POST['id'])){
    $id = $_POST['id'];
    
    $sql = "SELECT  MIN(menu_details.price) AS SmallestPrice  FROM `menu_details` WHERE id_menu = '".$id."'";
    $query = mysqli_query($conn,$sql);

    foreach ($query as  $value) {
        echo $value['SmallestPrice'];
    }
}
