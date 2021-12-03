<?php
include("../connect.php");
if(isset($_GET['cat_del'])){

    $sql = "DELETE FROM category WHERE id_category = '".$_GET['cat_del']."'";

    if ($conn->query($sql) === TRUE) {
        header("location:category.php");  
    } else {
      echo "Error deleting record: " . $conn->error;
    }
    
    
   
}


?>
