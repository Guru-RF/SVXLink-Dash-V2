<?php
  $username = $_POST["username"];
  $password = $_POST["password"];

  // Get the existing username and password information from the Raspberry Pi
  $existing_username = exec("echo $USER");
  $existing_password = exec("cat /etc/shadow | grep $existing_username | awk -F':' '{print $2}'");

  // Check if the user input matches the stored information
  if ($username == $existing_username && password_verify($password, $existing_password)) {
    echo "Access granted!";
  } else {
    echo "Access denied.";
  }
?>
