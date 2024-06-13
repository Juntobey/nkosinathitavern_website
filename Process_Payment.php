<?php
$servername = 'localhost';
$username = 'root';
$password =  ''; 
$dbname = 'nkosinathitavern';

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$full_name = filter_input(INPUT_POST, 'full_name', FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_STRING);
$city = filter_input(INPUT_POST, 'city', FILTER_SANITIZE_STRING);
$province = filter_input(INPUT_POST, 'province', FILTER_SANITIZE_STRING);
$zip_code = filter_input(INPUT_POST, 'zip_code', FILTER_SANITIZE_STRING);
$card_type = filter_input(INPUT_POST, 'card_type', FILTER_SANITIZE_STRING);
$name_on_card = filter_input(INPUT_POST, 'name_on_card', FILTER_SANITIZE_STRING);

$total_amount = 100.00; 

$payment_status = "success";


if ($payment_status === "success") {
    $sql = "INSERT INTO orders (full_name, email, address, city, province, zip_code, card_type, name_on_card, total_amount) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssss", $full_name, $email, $address, $city, $province, $zip_code, $card_type, $name_on_card, $total_amount);
    
    if ($stmt->execute()) {
        echo "Order placed successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    
    $stmt->close();
} else {
    echo "Payment failed. Please try again.";
}

$conn->close();
?>