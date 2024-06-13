<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
    $servername = "localhost";
    $username = "root";
    $password = "HewSawchemi90@"; 
    $dbname = "nkosinathitavern";

    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $name = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    $sql = "INSERT INTO users (username, email, password) VALUES ('$name', '$email', '$hashed_password')";

    if (mysqli_query($conn, $sql)) {
        echo '<p class="success">Registration successful!</p>';
    } else {
        echo '<p class="error">Error: ' . mysqli_error($conn) . '</p>';
    }

    mysqli_close($conn); 
}
?>
