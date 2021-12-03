<?php
include("../connect.php");
session_start();

$_SESSION['message'] = "";

// sending query
if(isset($_GET['menu_del'])){

    // sql to delete a record
$sql = "DELETE FROM menu WHERE id = '".$_GET['menu_del']."'";

if ($conn->query($sql) === TRUE) {
    $ssql = "DELETE FROM menu_details WHERE id_menu = '".$_GET['menu_del']."'";
    if ($conn->query($ssql) === TRUE) {

    $_SESSION['message'] = "Menu deleted successfully";
    header("location:display_menu.php");  
    }
} else {
  echo "Error deleting record: " . $conn->error;
}

}


?>
