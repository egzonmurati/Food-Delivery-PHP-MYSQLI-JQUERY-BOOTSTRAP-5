<?php

if(isset($_POST['submit'])){
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $email_resaurant = $_POST['email_restaurant'];
    $msg = $_POST['msg'];

    $headers = "From: $email" . "\r\n" .
    "CC: $email";

    if (mail($email_resaurant, $full_name, $msg,  $headers)) {
        header("location:index.php?email_send=1");
    }
}

?>