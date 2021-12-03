<?php
include("../connect.php");
if(isset($_GET['item_del'])){

    $sql = "DELETE FROM menu_details WHERE id = '".$_GET['item_del']."'";

    if ($conn->query($sql) === TRUE) {
        header("location:display_menu.php");  
    } else {
      echo "Error deleting record: " . $conn->error;
    }
    
    
   
}


?>
