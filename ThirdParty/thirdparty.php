<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['id']) || !isset($_SESSION['email'])) {
    header("location: log.php");
    exit;
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="third.css">   
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

</head>
<body>

<div class="container mt-5">
    <h1>Welcome, <?php echo $_SESSION['email']; ?>!</h1>
    <a href="logout.php" class="btn btn-danger">Logout</a>
  </div>

  <?php
  if (isset($_SESSION['message'])) {
      echo '
      <div class="alert alert-success alert-dismissible fade show" role="alert">
          ' . $_SESSION['message'] . '
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
      
      // Clear the message after displaying
      unset($_SESSION['message']);
  }
  ?>

    <header class="header">
        <div class="logo d-flex">
            <img src="./images/logo.png" alt="BICCOUNT GROUP Logo" />
          </div>
    </header>
    
<aside >

    <div class="sidebar" id="sidebar">
Sidebar
<div class="sidebar" id="sidebar">
    <button class="sidebar-btn">
    <i class="bi bi-briefcase-fill icon"></i>
     <b>Services</b> 
    </button>
    <button class="sidebar-btn" onclick="showUploadContainer()">
        <i class="bi bi-plus me-2"> Services</i>

        </button>
        <button class="sidebar-btn" onclick="showUploadContainer()">
            <i class="bi bi-plus me-2">Plumbing</i>
            
            </button>
            <button class="sidebar-btn" onclick="showUploadContainer()">
                <i class="bi bi-plus me-2"> Gas supply</i>
           
                </button>
            <button class="sidebar-btn" onclick="showUploadContainer()">
                    <i class="bi bi-plus me-2"> Movers</i>
                   
                    </button>
            <button class="sidebar-btn" onclick="showUploadContainer()">
                        <i class="bi bi-plus me-2">Add Material</i>
                        
                        </button>
        <button class="sidebar-btn" onclick="showUploadContainer()">
            <i class="bi bi-plus me-2">Add Material</i>
            </button>

            <!-- logout -->
            <div class="logout">
        <button class="sidebar-btn" title="Logout">
        <a href="logout.php"> <i class="bi bi-box-arrow-right">LOGOUT</i></a>
            </button>
        </div>
        
        
    </div>  

</aside>

<!-- main content -->
 <div class="main">

 <div class="container-fluid">   
    <div class="row">

        <div class="col-md-9 bg-light p-3 mb-3 border text-center">
            <h2>Main Content</h2>
        </div>
        <div class="col-md-3 bg-light p-1 mb-1 border text-center" style=" overflow: scroll;">
            <div>
                
                <h5 id="grad" class="fs-6">Most Preferred Materials</h5>
                <table class="table">
                  <thead class="thead-dark">
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">Material</th>
                      <th scope="col">Amount</th>
                      <th scope="col">%</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <th scope="row">1</th>
                      <td>Mark</td>
                      <td>Otto</td>
                      <td>@mdo</td>
                    </tr>
                    <tr>
                      <th scope="row">2</th>
                      <td>Jacob</td>
                      <td>Thornton</td>
                      <td>@fat</td>
                    </tr>
                    <tr>
                      <th scope="row">3</th>
                      <td>Larry</td>
                      <td>the Bird</td>
                      <td>@twitter</td>
                    </tr>
                  </tbody>
                </table>
                
              </div>
              <div>
                <h3 id="grad" class="fs-6">Most Preferred Suppliers</h3>
                <table class="table fs-7">
                  <thead class="thead-dark">
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">Supplier</th>
                      <th scope="col">Amount</th>
                      <th scope="col">%</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <th scope="row">1</th>
                      <td>Mark</td>
                      <td>Otto</td>
                      <td>@mdo</td>
                    </tr>
                    <tr>
                      <th scope="row">2</th>
                      <td>Jacob</td>
                      <td>Thornton</td>
                      <td>@fat</td>
                    </tr>
                    <tr>
                      <th scope="row">3</th>
                      <td>Larry</td>
                      <td>the Bird</td>
                      <td>@twitter</td>
                    </tr>
                  </tbody>
                </table>
                </p>
              </div>
            </div>
    </div>
 </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
      const toggleBtn = document.getElementById("toggleBtn");
      const content = document.getElementById("contentBox");
  
      // Function to toggle the content
      function toggleContent() {
        if (content.style.display === "none" || content.style.display === "") {
          content.style.display = "block"; // Show the content
        } else {
          content.style.display = "none"; // Hide the content
        }
      }
  
      // Automatically trigger the toggle function (for example, after 1 second)
      setTimeout(toggleContent, 1000); // Show content after 1 second for demonstration
  
      // Auto-hide content after 5 seconds (when toggled on)
      let autoHideTimeout;
  
      toggleBtn.addEventListener("click", () => {
        toggleContent();
        if (content.style.display === "block") {
          // Set timeout to hide the content after 5 seconds
          autoHideTimeout = setTimeout(() => {
            content.style.display = "none";
          }, 5000); // Hide content after 5 seconds
        } else {
          // Clear any previous timeout if the content is hidden
          clearTimeout(autoHideTimeout);
        }
      });
  
      // Hide content if the mouse leaves the toggle button
      toggleBtn.addEventListener("mouseleave", function () {
        content.style.display = "none";
      });
  
      // Show content when mouse enters the toggle button
      toggleBtn.addEventListener("mouseenter", function () {
        content.style.display = "block";
      });
    });
  </script>
  
</body>
</html>