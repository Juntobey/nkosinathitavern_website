<?php
session_start();
include 'Configuration.php'; // Assuming this file contains your database connection details

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $conn->real_escape_string($_POST['username']);
  $email = $conn->real_escape_string($_POST['email']);
  $password = $conn->real_escape_string($_POST['password']);
  $phone= $conn->real_escape_string($_POST['phone']);
  $hashed_password = password_hash($password, PASSWORD_DEFAULT);
 
  // Check if the username or email already exists
  $check_user_sql = "SELECT id FROM users WHERE username = '$username' OR email = '$email'";
  $result = $conn->query($check_user_sql);
 
  if ($result->num_rows > 0) {
    echo "Username or Email already exists.";
  } else {
    $sql = "INSERT INTO users (username, email, password, phone) VALUES ('$username', '$email', '$hashed_password', 'phone')";
   }
    if ($conn->query($sql) === TRUE) {
      // Registration successful, display success message and link that redirects to login
      echo "Registration successful! Please <a href='login.php'>login</a>.";
      // Optionally, redirect the user immediately after a short delay
    echo '<script>setTimeout(function(){ window.location.href = "login.php"; }, 2000);</script>'; // Redirect after 2 seconds
      exit();
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
  }
 
  $conn->close();

?>