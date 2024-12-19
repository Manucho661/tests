<?php
// Start session to track the user
session_start();

// Define variables and initialize with empty values
$email = $password = "";
$email_err = $password_err = "";

// Process form data when the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate email
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter an email.";
    } else {
        $email = trim($_POST["email"]);
    }

    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Check if there are no errors, then validate credentials
    if (empty($email_err) && empty($password_err)) {
      
        // Database connection
        $conn = new mysqli("localhost", "root", "", "thirdparty");

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Query to select user from database
        $sql = "SELECT id, email, password FROM users WHERE email = ?";

        if ($stmt = $conn->prepare($sql)) {
            // Bind the email parameter to the prepared statement
            $stmt->bind_param("s", $email);

            // Execute the statement
            $stmt->execute();

            // Store result
            $stmt->store_result();

            // Check if the email exists in the database
            if ($stmt->num_rows == 1) {
                // Bind the result to variables
                $stmt->bind_result($id, $email, $hashed_password);

                // Fetch the result
                if ($stmt->fetch()) {
                    // Verify password
                    if (password_verify($password, $hashed_password)) {
                        // Password is correct, start a new session and save the user ID
                        session_start();
                        $_SESSION['id'] = $id;
                        $_SESSION['email'] = $email;
                        

   
                        // Set a session message for success
                        $_SESSION['message'] = "You have successfully logged in!";

                        // Redirect to the name page (profile page or dashboard)
                        header("location: thirdparty.php");
                        exit();
                    } else {
                        // Display an error message if the password is not valid
                        $password_err = "The password you entered was not valid.";
                    }
                }
            } else {
                // Display an error message if the email doesn't exist
                $email_err = "No account found with that email.";
            }

            // Close the statement
            $stmt->close();
        }

        // Close the connection
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
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
          <h2 class="text-center text-primary mb-4">Login</h2>
          <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="email" class="form-control" name="email" id="email" placeholder="Enter your email" required>
              <span class="text-danger"><?php echo $email_err; ?></span>
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Password</label>
              <input type="password" class="form-control" name="password" id="password" placeholder="Enter your password" required>
              <span class="text-danger"><?php echo $password_err; ?></span>
            </div>
            <div class="d-grid">
              <button type="submit" class="btn btn-primary">Login</button>
            </div>
          </form>
          <p class="text-center mt-3 mb-0">
            Don't have an account? <a href="signup.php" class="text-decoration-none text-info fw-bold">Sign up</a>
          </p>
          <p class="text-center mt-3 mb-0">
<a href="forgot_password.php" class="text-decoration-none text-info fw-bold">forgot password?</a>
          </p>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
