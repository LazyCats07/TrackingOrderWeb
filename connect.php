<?php
  $host = 'localhost';
  $user = 'root';
  $pass = '';
  $db = 'db_cust';
  $conn = mysqli_connect($host, $user, $pass, $db);

  // Check connection
  if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
  }
//   echo "Connected successfully";

  mysqli_select_db($conn, $db)
?>