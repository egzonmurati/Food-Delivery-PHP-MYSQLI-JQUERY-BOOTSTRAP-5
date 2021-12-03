<?php
include("../connect.php");
session_start();

$_SESSION['message'] = "";

// sending query
if(isset($_GET['res_del'])){

    // sql to delete a record
$sql = "DELETE FROM restaurant WHERE rs_id = '".$_GET['res_del']."'";

if ($conn->query($sql) === TRUE) {
  $sql_menu = "SELECT * FROM menu WHERE id_restaurant = '".$_GET['res_del']."'";
  $newquery = mysqli_query($conn, $sql_menu);
  $fetchs = mysqli_fetch_array($newquery);
  $menu_id = $fetchs['id'];
  $ssql = "DELETE FROM menu WHERE id_restaurant = '".$_GET['res_del']."'";
  if ($conn->query($ssql) === TRUE) {
    $ssql = "DELETE FROM menu_details WHERE id_menu = $menu_id";
    if ($conn->query($ssql) === TRUE) {

      $_SESSION['message'] = "Restaurant deleted successfully";
      header("location:restaurant.php");  
    }
  }
  
} else {
  echo "Error deleting record: " . $conn->error;
}

}


?>
