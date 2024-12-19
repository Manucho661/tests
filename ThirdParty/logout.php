<?php
// Start session
session_start();

// Destroy the session to log the user out
session_unset();
session_destroy();

// Set a session message for logout
session_start();  // Re-start the session to store the message
$_SESSION['message'] = "You have successfully logged out!";

// Redirect to the login page or any other page
header("Location: thirdparty.php");
exit();
?>




<?php
// Start the session
session_start();

// Destroy all session data
session_unset();
session_destroy();

// Redirect to the login page after logging out
header("Location: log.php");
exit();
?>
