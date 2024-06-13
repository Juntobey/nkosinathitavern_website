<?php

include("db_connect.php");
$user_id = 1;

// Database query to fetch cart items
$query = "SELECT * FROM cart_items WHERE user_id = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$cart_items = $result->fetch_all(MYSQLI_ASSOC);
$cart_items_json = json_encode($cart_items);

// Calculate subtotal 
$subtotal = 0;
foreach ($cart_items as $item) {
    $subtotal += $item['quantity'] * $item['unit_price'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nkosinathi Tavern - Your Cart</title>
    <link rel="stylesheet" href="cart.css"> 
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"> 
</head>
<body>
    <header>
    <nav>
<div class = "logo">
                <img src="C:\Users\Mashigo\Downloads\website photos\NkosinathiTavern Logo" alt = "NkosinathiTavern">   
               </div>
               <div class = "nav-links">
      <ul>
      <li><a href = "Home.html"> Home</a></li>
      <li><a href ="Beverages.php">Beverages</a></li>
      <li><a href = "AboutUs.html"> About Us</a></li>
      <li><a href ="Events.html">Events</a></li>
     <li><a href = "Contact.html"> Contact Us</a></li>
     <li><a href = "Register.html"> Sign in</a></li>
        <li class="active"><a href="Cart.html">Cart</a></li>
      </ul>
    </nav>
        </header>

    <main>
        <section class="cart">
            <h2>Your Shopping Cart</h2>
            <div id="cart-list"></div>
            <p id="empty-cart-message" style="display: none;">Your cart is currently empty.</p>
            <div class="cart-summary" style="display: none;">
                <h3>Cart Summary</h3>
                <p id="cart-subtotal">Subtotal: $<span id="subtotal-amount">0.00</span></p>
                <p id="shipping-cost">Shipping Cost: $<span id="shipping-amount">0.00</span></p>
                <p id="cart-total"><b>Total: $<span id="total-amount">0.00</span></b></p>
                <button id="checkout-btn" class="checkout-btn">Proceed to Checkout</button>
            </div>
        </section>
    </main>

    <footer>
        </footer>

    <script src="cart.js"></script>
    <script>
        const cartItems = <?php echo $cart_items_json; ?>;
        updateCartList(cartItems);
    </script>
</body>
</html>
