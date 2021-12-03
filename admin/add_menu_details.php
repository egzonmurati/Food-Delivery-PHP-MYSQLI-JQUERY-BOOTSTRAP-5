<?php

//Add new menu item
if (isset($_POST['add_details'])) {
    // $menuID = $sqlconnection->real_escape_string(ucfirst($_POST['menuID']));
    $itemPrice = $_POST['itemPrice'];
    $size = $_POST['size'];
    $about = $_POST['about'];
    $menuId =  $_POST['menuIDs'];

    foreach ($size as $key => $value) {
        //  echo $value ." - " . $itemPrice[$key] . " = " . $menuId ."<br>";

        $sizes = $value;
        $itemPrices = $itemPrice[$key];
        $itemAbout = $about[$key];

        $sql = "INSERT INTO `menu_details` (id_menu, price, size,about) VALUES ('$menuId', '$itemPrices', '$sizes','$itemAbout')";
        $run_query =   $conn->query($sql);
    }
    if ($run_query  === TRUE) {
        header("Location: display_menu.php");
        exit();
    } else {
        //handle
        echo "someting wong";
        echo $conn->error;
    }
    // $sql = "SELECT * from menu_item";

    // $result = $sqlconnection->query($sql);

    // 	while($row = $result->fetch_assoc()){
    // 		if($row['item_id'] == $menuID){
    // 			foreach($itemPrice as $key => $value){
    //                 $addItemQuery = "INSERT INTO item (id_menu,price ,size) VALUES ({$menuID},'{$value}',{$itemPrice[$key]})";

    //                 if ($sqlconnection->query($addItemQuery) === TRUE) {
    //                     header("Location: admin.php"); 
    //                     exit();

    //                 } 

    //                 else {
    //                     //handle
    //                     echo "someting wong";
    //                     echo $sqlconnection->error;
    //                 }

    //             }
    // 		}
    // 	}



}

		//No input handle
