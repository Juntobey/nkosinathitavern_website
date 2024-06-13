<?php
session_start();

// Check if the user is logged in as an admin
if (!isset($_SESSION['user_id']) || !isAdmin($_SESSION['user_id'])) {
    header('Location: Register.php'); // Redirect to your login page
    exit;
}

include('nkosinathitavern.php'); 

// Function to check if the logged-in user is an admin
function isAdmin($userId) {
    global $conn;
    $stmt = $conn->prepare("SELECT user_type FROM users WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return ($row['user_type'] == 'admin');
}

// Handle product and user operations (edit/delete) based on form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['delete_product'])) {
        $productId = mysqli_real_escape_string($conn, $_POST['product_id']); 

        $deleteProductQuery = $conn->prepare("DELETE FROM products WHERE id = ?");
        $deleteProductQuery->bind_param("i", $productId);
        $deleteProductQuery->execute();

        if ($deleteProductQuery->affected_rows > 0) { 
            echo '<p class="success">Product deleted successfully!</p>';
        } else {
            echo '<p class="error">Failed to delete product.</p>';
        }
    } elseif (isset($_POST['edit_product'])) {
        $productId = mysqli_real_escape_string($conn, $_POST['product_id']); 

        // Fetch product data
        $fetchProductQuery = $conn->prepare("SELECT * FROM products WHERE id = ?");
        $fetchProductQuery->bind_param("i", $productId);
        $fetchProductQuery->execute();
        $productResult = $fetchProductQuery->get_result();

        if ($productResult->num_rows == 1) {
            $product = $productResult->fetch_assoc();

            // Display edit form (you need to create this form)
            echo '<h2>Edit Product</h2>';
            echo '<form method="post" action="">';
            echo '<input type="hidden" name="product_id" value="' . $product['id'] . '">';
            echo 'Name: <input type="text" name="name" value="' . $product['name'] . '"><br>';
            echo 'Price: <input type="text" name="price" value="' . $product['price'] . '"><br>';
            // ... (add fields for other product attributes)
            echo '<button type="submit" name="update_product">Update</button>';
            echo '</form>';
        } else {
            echo '<p class="error">Product not found.</p>';
        }
    } elseif (isset($_POST['update_product'])) {
        // Update product logic here (make sure to sanitize the input)
        $productId = mysqli_real_escape_string($conn, $_POST['product_id']);
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $price = mysqli_real_escape_string($conn, $_POST['price']);
        // ... (get other updated product attributes)

        $updateProductQuery = $conn->prepare("UPDATE products SET name=?, price=? WHERE id=?"); // Update query
        $updateProductQuery->bind_param("sdi", $name, $price, $productId); // Bind parameters

        if ($updateProductQuery->execute()) {
            echo '<p class="success">Product updated successfully!</p>';
        } else {
            echo '<p class="error">Failed to update product.</p>';
        }
    } elseif (isset($_POST['delete_user'])) {
        $userId = mysqli_real_escape_string($conn, $_POST['user_id']); // Assuming you have the user's ID from the form

        $deleteUserQuery = $conn->prepare("DELETE FROM users WHERE id = ?");
        $deleteUserQuery->bind_param("i", $userId);
        $deleteUserQuery->execute();

        if ($deleteUserQuery->affected_rows > 0) {
            echo '<p class="success">User deleted successfully!</p>';
        } else {
            echo '<p class="error">Failed to delete user.</p>';
        }
    } elseif (isset($_POST['edit_user'])) {
        $userId = mysqli_real_escape_string($conn, $_POST['user_id']); 

        // Fetch user data
        $fetchUserQuery = $conn->prepare("SELECT * FROM users WHERE id = ?");
        $fetchUserQuery->bind_param("i", $userId);
        $fetchUserQuery->execute();
        $userResult = $fetchUserQuery->get_result();

        if ($userResult->num_rows == 1) {
            $user = $userResult->fetch_assoc();

            // Display edit form (you need to create this form)
            echo '<h2>Edit User</h2>';
            echo '<form method="post" action="">';
            echo '<input type="hidden" name="user_id" value="' . $user['id'] . '">';
            echo 'Username: <input type="text" name="username" value="' . $user['username'] . '"><br>';
            echo 'Email: <input type="email" name="email" value="' . $user['email'] . '"><br>';
            // ... (add fields for other user attributes)
            echo '<button type="submit" name="update_user">Update</button>';
            echo '</form>';
        } else {
            echo '<p class="error">User not found.</p>';
        }
    } elseif (isset($_POST['update_user'])) {
        $userId = mysqli_real_escape_string($conn, $_POST['user_id']);
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        // ... (get other updated user attributes)

        $updateUserQuery = $conn->prepare("UPDATE users SET username=?, email=? WHERE id=?"); // Update query
        $updateUserQuery->bind_param("ssi", $username, $email, $userId); // Bind parameters

        if ($updateUserQuery->execute()) {
            echo '<p class="success">User updated successfully!</p>';
        } else {
            echo '<p class="error">Failed to update user.</p>';
        }
    }
}

// Retrieve products from the database
$products = [];
$stmt = $conn->prepare("SELECT * FROM products");
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $products[] = $row;
}

// Retrieve users from the database
$users = [];
$stmt = $conn->prepare("SELECT * FROM users");
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $users[] = $row;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
    </head>
<body>
    <h2>Product Management</h2>
    <table>
        <tr><th>ID</th><th>Name</th><th>Price</th><th>Actions</th></tr>
        <?php foreach ($products as $product) { ?>
            <tr>
                <td><?php echo $product['id']; ?></td>
                <td><?php echo $product['name']; ?></td>
                <td><?php echo $product['price']; ?></td>
                <td>
                    <form method="post" action="">
                        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                        <button type="submit" name="edit_product">Edit</button>
                        <button type="submit" name="delete_product">Delete</button>
                    </form>
                </td>
            </tr>
        <?php } ?>
    </table>

    <h2>User Management</h2>
    <table>
        <tr><th>ID</th><th>Username</th><th>Email</th><th>User Type</th><th>Actions</th></tr>
        <?php foreach ($users as $user)  ?>
        {
            <tr>
                <td><?php echo $user['id']; ?></td>
                <td><?php echo $user['username']; ?></td>
                <td><?php echo $user['email']; ?></td>
                <td><?php echo $user['user_type']; ?></td>
                <td>
                    <form method="post" action="">
                        <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                        <button type="submit" name="edit_user">Edit</button>
        }