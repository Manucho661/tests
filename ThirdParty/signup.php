<?php

// Define variables and initialize with empty values
$username = $email = $password = $confirm_password = "";
$username_err = $email_err = $password_err = $confirm_password_err = "";

// Process form data when the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate username
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter a username.";
    } else {
        $username = trim($_POST["username"]);
    }

    // Validate email
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter an email address.";
    } elseif (!filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL)) {
        $email_err = "Please enter a valid email address.";
    } else {
        $email = trim($_POST["email"]);
    }

    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = "Password must be at least 6 characters.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate confirm password
    if (empty(trim($_POST["confirmpassword"]))) {
        $confirm_password_err = "Please confirm your password.";
    } elseif ($password !== trim($_POST["confirmpassword"])) {
        $confirm_password_err = "Passwords do not match.";
    } else {
        $confirm_password = trim($_POST["confirmpassword"]);
    }

    // Check if there are no errors, then insert the data into the database
    if (empty($username_err) && empty($email_err) && empty($password_err) && empty($confirm_password_err)) {
      
        // Database connection
        $conn = new mysqli("localhost", "root", "", "thirdparty");

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Insert query
        $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";

        if ($stmt = $conn->prepare($sql)) {
            // Hash the password before storing it
            $stmt->bind_param("sss", $username, $email, password_hash($password, PASSWORD_DEFAULT));

            if ($stmt->execute()) {
                // Redirect to the login page or success page
                header("location: log.php");
                exit();
            } else {
                echo "Something went wrong. Please try again.";
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
  <title>Sign Up</title>
  <!-- Bootstrap CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: url('./images/login.jpg') no-repeat center center fixed; /* Set image as background */
      background-size: cover; /* Ensure image covers the page */
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .card {
      background-color: rgba(255, 255, 255, 0.9); /* Semi-transparent white */
      border: none;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Subtle shadow */
    }

    .btn-primary {
      background-color: #1e3a8a; /* Deep blue */
      border-color: #1e3a8a;
    }

    .btn-primary:hover {
      background-color: #15305f; /* Darker blue */
      border-color: #15305f;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 col-sm-8 col-md-6 col-lg-4">
        <div class="card p-4">
          <h2 class="text-center text-primary mb-4">Sign Up</h2>
          <form action="" method="POST">
            <div class="mb-3">
              <label for="username" class="form-label">Username</label>
              <input type="text" class="form-control" name="username" id="username" placeholder="Enter your username" value="<?php echo $username; ?>" required>
              <span class="text-danger"><?php echo $username_err; ?></span>
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" value="<?php echo $email; ?>" required>
              <span class="text-danger"><?php echo $email_err; ?></span>
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Password</label>
              <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
              <span class="text-danger"><?php echo $password_err; ?></span>
            </div>
            <div class="mb-3">
              <label for="confirmpassword" class="form-label">Confirm Password</label>
              <input type="password" class="form-control" name="confirmpassword" id="confirmpassword" placeholder="Confirm your password" required>
              <span class="text-danger"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="d-grid">
              <button type="submit" class="btn btn-primary">Create Account</button>
            </div>
          </form>
          <p class="text-center mt-3 mb-0">
            Already have an account? <a href="log.php" class="text-decoration-none text-primary fw-bold">Log in</a>
          </p>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
