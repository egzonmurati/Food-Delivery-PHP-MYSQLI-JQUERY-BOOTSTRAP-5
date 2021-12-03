<?php
include("connect.php");
 if(isset($_POST['submit'])){
     $email = $_POST['email'];
     $sql = "SELECT email FROM subscribe WHERE email='".$email."'";
     $result = $conn->query($sql);
     if ($result->num_rows > 0) {
        header("location:index.php?subscribe=2");
     }else{
        $sql = "INSERT INTO subscribe (email)
        VALUES ('$email')";
        
        if ($conn->query($sql) === TRUE) {
           header("location:index.php?subscribe=1");
        } else {
          echo "Error: " . $sql . "<br>" . $conn->error;
        }
     }  
   
 }

?>