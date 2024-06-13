<?php
// Start session
session_start();
// Unset all session variables
session_unset();
// Destroy the session
session_destroy();
// Redirect to Register.php (since that's your combined login/register page now)
header("Location: Register.php");
exit;
?>
