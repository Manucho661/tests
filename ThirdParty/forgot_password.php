<?php
// Initialize variables and error messages
$email_err = "";
$password_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate email
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter your email address.";
    } elseif (!filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL)) {
        $email_err = "Please enter a valid email address.";
    } else {
        $email = trim($_POST["email"]);
    }

    // Check if no errors and proceed with password reset request
    if (empty($email_err)) {
        // Database connection
        $conn = new mysqli("localhost", "root", "", "thirdparty");

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Generate a unique token
        $token = bin2hex(random_bytes(50));

        // Query to insert the reset token in the database
        $sql = "UPDATE users SET reset_token = ?, token_expiry = NOW() + INTERVAL 1 HOUR WHERE email = ?";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("ss", $token, $email);
            if ($stmt->execute()) {
                // Send reset email with the link
                $reset_link = "http://yourdomain.com/reset_password.php?token=" . $token;
                mail($email, "Password Reset", "Click on the link to reset your password: " . $reset_link);
                
                echo "An email has been sent to your address with instructions to reset your password.";
            } else {
                echo "No account found with that email address.";
            }
        }

        // Close connection
        $stmt->close();
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Forgot Password</title>
  <style>
  /* Global styles */
body {
  font-family: Arial, sans-serif;
  background-color: #f4f7fc;
  margin: 0;
  padding: 0;
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
}

/* Form container */
.reset-password-form {
  background-color: #fff;
  padding: 30px;
  border-radius: 8px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  width: 100%;
  max-width: 400px;
}

/* Form group */
.form-group {
  margin-bottom: 20px;
}

/* Input styling */
.form-control {
  width: 100%;
  padding: 10px;
  font-size: 16px;
  border: 1px solid #ccc;
  border-radius: 5px;
  outline: none;
  transition: border-color 0.3s ease;
}

/* Focus input */
.form-control:focus {
  border-color: #007bff;
}

/* Error message styling */
.text-danger {
  color: #e74c3c;
  font-size: 12px;
  margin-top: 5px;
}

/* Button styling */
.btn {
  background-color: #007bff;
  color: #fff;
  border: none;
  padding: 12px 20px;
  font-size: 16px;
  border-radius: 5px;
  cursor: pointer;
  width: 100%;
  transition: background-color 0.3s ease;
}

/* Button hover effect */
.btn:hover {
  background-color: #0056b3;
}
</style>
</head>
<body>
<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="reset-password-form">
  <div class="form-group">
    <label for="email">Email Address</label>
    <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email" required>
    <span class="text-danger"><?php echo $email_err; ?></span>
  </div>
  <div class="form-group">
    <label for="password">Email Address</label>
    <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password" required>
    <span class="text-danger"><?php echo $password_err; ?></span>
  </div>
  <button type="submit" class="btn btn-primary">Reset Password</button>
</form>

</body>
</html>
