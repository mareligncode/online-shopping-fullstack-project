<?php
session_start();
$errors = [];

// Database configuration
$host = "localhost";
$user = "root"; // Replace with your database username
$pass = ""; // Replace with your database password
$dbname = "shopping";

// Create connection without selecting the database
$conn = mysqli_connect($host, $user, $pass);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Create database if it doesn't exist
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if (mysqli_query($conn, $sql)) {
    // Comment out or remove this echo to avoid header issues
    // echo "Database created successfully or already exists.<br>";
} else {
    die("Error creating database: " . mysqli_error($conn));
}

// Select the database
mysqli_select_db($conn, $dbname);

// Rest of your code...


// Rest of your code...


// Create product_selections table if it doesn't exist
$tableCreationQuery = "
CREATE TABLE IF NOT EXISTS product_selections (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    size VARCHAR(10) NOT NULL,
    quality ENUM('High', 'Medium', 'Low') NOT NULL,
    product_type VARCHAR(50) NOT NULL,
    price varchar(255) NOT NULL
)";

// Alter the table to change the price column to VARCHAR
$alterTableQuery = "ALTER TABLE product_selections MODIFY price VARCHAR(255);";
if (mysqli_query($conn, $alterTableQuery)) {
   // echo "Table altered successfully.<br>";
} else {
    echo "Error altering table: " . mysqli_error($conn) . "<br>";
}


if (!mysqli_query($conn, $tableCreationQuery)) {
    echo "Error creating table: " . mysqli_error($conn);
}

// Handle product selection form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    // Debugging: Print POST data
    // echo "<pre>";
    // print_r($_POST);
    // echo "</pre>";

    // Validate and sanitize input
    $size = isset($_POST['size']) ? trim($_POST['size']) : '';
    $quality = isset($_POST['quality']) ? trim($_POST['quality']) : '';
    $product_type = isset($_POST['product_type']) ? trim($_POST['product_type']) : '';
    $price = isset($_POST['price']) ? trim($_POST['price']) : '';

    // Check if all fields are filled
    if (empty($size) || empty($quality) || empty($product_type) || empty($price)) {
        $errors[] = "All fields are required.";
    }

    // If no errors, insert into database
    if (empty($errors)) {
        // Prepare the SQL statement
        $stmt = mysqli_prepare($conn, "INSERT INTO product_selections (size, quality, product_type, price) VALUES (?, ?, ?, ?)");
        if (!$stmt) {
            die("Prepare failed: " . mysqli_error($conn));
        }

        // Bind parameters
        mysqli_stmt_bind_param($stmt, "ssss", $size, $quality, $product_type, $price);

        // Execute the statement
        if (mysqli_stmt_execute($stmt)) {
          //  echo "<p style='color:green;'>Product selection added successfully.</p>";
        } else {
            echo "<p style='color:red;'>Error adding selection: " . mysqli_error($conn) . "</p>";
        }

        // Close the statement
        mysqli_stmt_close($stmt);
    } else {
        // Display errors
        foreach ($errors as $error) {
            echo "<p style='color:red;'>$error</p>";
        }
    }
}


// Close connection
mysqli_close($conn);
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>online shoping</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
     rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
      crossorigin="anonymous">
      <link rel="stylesheet" href="style.css">
      <!-- FontAwesome CDN -->
      <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
      rel="stylesheet">
<!-- <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script> -->

<script src="https://kit.fontawesome.com/your-unique-kit-code.js" crossorigin="anonymous"></script>


</head>
<body>
<!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
rel="stylesheet"> -->
 <section class="header  " id="header">
    <nav class="navbar navbar-expand-lg bg-info">
  <div class="container-fluid">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll"
     aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarScroll">
      <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
        <li class="nav-item">
          <a class="nav-link active " aria-current="page" href="#header">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link  " href="#contact">contact</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle  " href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            workspace
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#signup" class="a">signup</a></li>
            <li><a class="dropdown-item" href="#login" class="a">login</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#service" class="a">get all service</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a href="#about" class="nav-link  " aria-disabled="true">about me</a>
        </li>
        <h4>marelign.yimer</h4>
      </ul>
      <form class="d-flex" role="search">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
      <img src="images/me.jpg" class="rounded-circle px-2" height=70 width=65>
    </div>
  </div>
  </nav>
</section>

<!-- Add this toggle button to your navbar or any desired location -->
<div class="form-check form-switch  bg-success" >
    <input class="form-check-input" type="checkbox" id="darkModeToggle">
    <label class="form-check-label text-light" for="darkModeToggle">Dark Mode</label>
</div>

<section class="form  bg-secondary m-1" id="signup">
        <div class="row p-3 gap-2">
            <div class="col-md-6 bg-warning-subtle pr-2 py-3">
              <form method="post" action="signup.php" class="mt-5" name="myform">
                 <h2>Signup here</h2>
    
      
    Name: <input type="text" name="name" class="name" required placeholder="Enter your name"><br>
    Father's Name: <input type="text" name="fname" class="fname" required placeholder="Enter your father's name"><br>
    Email: <input type="email" name="email" placeholder="Email" class="email" required><br>
    Gender: <input type="radio" name="gender" value="male" required> Male
    <input type="radio" name="gender" value="female" required> Female<br><br>
    Password: <input type="password" name="password" class="password" placeholder="Enter password" required><br>
    Confirm Password: <input type="password" name="password2" class="password2" placeholder="Confirm password" required><br>
    <input type="submit" name="signup" value="Signup" class="signup btn btn-info"><br><br>
    If you have an account: <a href="#login" class="btn btn-info pt-2">Login</a>
   </form>  </div>
        <!-- </div> -->
        <div class="col-md-5 bg-danger-subtle px-2">
          <h2>put any text int his area</H2>
          <textarea cols="40" rows="5" class="p-3"></textarea>
        </div>
  </section> 
    <section class="login p-3 bg-info-subtle my-2" id="login">
        <div class="row">
            <div class="col-md-10">
                <div class="form" id="login">
                </div> 
   <form method="post" action="login.php" name="login">
                   <h2>Login here</h2>
    
    Email: <input type="email" name="email" placeholder="Enter your email" required><br><br>
    Password: <input type="password" name="password" placeholder="Enter your password" required><br><br>
    <input type="submit" name="login" value="Login" class="login btn btn-success">
    If you do not have an account, please <a href="#signup" class="btn btn-success">Signup</a>
     </form>

            </div>
            <div class="col-md-2 bg-light">
                <h1>m.y</h1>
            </div>
        </div>
   </section>
<section class="about bg-success-subtle m-2" id="about">
      <center>  <h3>about me</h3></center>
        <div class="row gap-5">
         <div class="col-md-4 bg-danger-subtle">
          <div class="card" style="width: 18rem;">
           <img src="images/kobo.jpg" class="card-img-top rounded img-fluid" alt="..." >
             <div class="card-body">
            <h5 class="card-title">Card title</h5>
         <p class="card-text">i am  third year student of computer scince in bahirdar international university
         in my time of living at bahirdar unversity i am tring d/t thing s but the amin purpose is study 
        computer science web development and other scinces like android development
  </p>
    <a href="http://maruman.free.nf/?i=1" class="btn btn-primary">Go somewhere</a>
  </div>
    </div></div>
       <div class="col-md-3 bg-dark">
        <div class="card" style="width:14rem">
          <img src="images/bdu.jpg" class="card-img-top" alt="...">
              <div class="card-body">
    <h5 class="card-title">Card title</h5>
    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
    <a href="#" class="btn btn-primary">Go somewhere</a>
  </div>
       </div>
        </div>

     <div class="col-md-3 bg-warning-subtle">
     <div class="card" style="width: 18rem;">
      <img src="images/BDU2123.jpg" class="card-img-top" alt="...">
     <div class="card-body">
    <h5 class="card-title">Card title</h5>
    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
    <a href="#" class="btn btn-primary">Go somewhere</a>
  </div>
    </div>
      </div>
      </div>
 </section>


</section>

<!-- services ection -->
<section class="services bg-info py-5 m-2" id="service">
    <div class="container">
        <h2 class="text-center mb-4">my services</h2>
       <center>  <h6 style="color:yellow;">are you interested to buy fasion and quality brand? this is for you</h6></center>
        <div class="row" id="product-container">
            <!-- Initial Products -->
            <div class="col-sm-4 mb-4 bg-success-subtle" id="product1">
                <div class="card">
                    <img src="images/jeans.jpg" class="card-img-top" alt="Jeans">
                    <div class="card-body">
                        <h5 class="card-title">Jeans</h5>
                        <h5>high quality</h5>

                        <p class="card-text">2500</p>
                    </div>
                </div>
            <button class="btn btn-primary load-more" data-type="Jeans">Load More Styles</button>
          </div>
            <div class="col-sm-4 mb-4 bg-info-subtle" id="product2">
                <div class="card">
                    <img src="images/sh2.jpg" class="card-img-top" alt="Shirt">
                    <div class="card-body">
                        <h5 class="card-title">Shirt</h5>
                        <h5>high quality</h5>

                        <p class="card-text">2000</p>
                    </div>
                </div>
                <button class="btn btn-primary load-more" data-type="Shirt">Load More Styles</button>
            </div>
            <div class="col-sm-4 mb-4 bg-dark-subtle" id="product3">
                <div class="card">
                    <img src="images/jct.jpg" class="card-img-top" alt="Jacket">
                    <div class="card-body">
                        <h5 class="card-title">Jacket</h5>
                        <h5>high quality</h5>

                        <p class="card-text">700</p>
                    </div>
                </div>
                <button class="btn btn-primary load-more" data-type="Jacket">Load More Styles</button>
            </div>
            <div class="col-sm-4 mb-4 bg-warning-subtle" id="product4">
                <div class="card">
                    <img src="images/shoes.jpg" class="card-img-top" alt="Shoes">
                    <div class="card-body">
                        <h5 class="card-title">Shoes</h5>
                        <h5>high quality</h5>
                        <p class="card-text">1200</p>
                    </div>
                </div>
                <button class="btn btn-primary load-more" data-type="Shoes">Load More Styles</button>
            </div>
            <div class="col-sm-4 mb-4 bg-danger-subtle" id="product5">
                <div class="card">
                    <img src="images/T-Shirt.jpg" class="card-img-top" alt="T-Shirt">
                    <div class="card-body">
                        <h5 class="card-title">T-Shirt</h5>
                        <h5>high quality</h5>

                        <p class="card-text">1000</p>
                    </div>
                </div>
                <button class="btn btn-primary load-more" data-type="T-Shirt">Load More Styles</button>
            </div>
            <div class="col-sm-4 mb-4 bg-dark-subtle" id="product6">
                <div class="card">
                    <img src="images/belt.jpg" class="card-img-top" alt="Belt">
                    <div class="card-body">
                        <h5 class="card-title">Belt</h5>
                        <h5>high quality</h5>

                        <p class="card-text">150</p>
                    </div>
                </div>
                <button class="btn btn-primary load-more" data-type="Belt">Load More Styles</button>
            </div>
        </div>

        <div class="my-4">
        
        <form method="post" action="index.php#service" class="my-4">
         <h4>Select Product Options</h4>
            <div class="form-group">
                <label for="size">Size:</label>
                <select id="size" class="form-control" name="size">
                    <option value="S">Small</option>
                    <option value="M">Medium</option>
                    <option value="L">Large</option>
                    <option value="XL">Extra Large</option>
                </select>
            </div>
            <div class="form-group">
                <label for="quality">Quality:</label>
                <select id="quality" class="form-control" name="quality">
                    <option value="High">High</option>
                    <option value="Medium">Medium</option>
                    <option value="Low">Low</option>
                </select>
            </div>
            <div class="form-group">
                <label for="product-type">Product Type:</label>
                <select id="product-type" class="form-control" name="product_type">
                    <option value="Jeans">Jeans</option>
                    <option value="Shirt">Shirt</option>
                    <option value="Jacket">Jacket</option>
                    <option value="Shoes">Shoes</option>
                    <option value="T-Shirt">T-Shirt</option>
                    <option value="Belt">Belt</option>
                </select>
            </div>
            <div class="form-group">
                <label for="price">full name:</label>
                <!-- <input type="text" id="price" class="form-control" disabled> -->
                <input type="text" id="price" name="price"  
               placeholder="fullname:mobile" class="form-control" >
            </div>
            <button id="submit" class="btn btn-success sub" name="submit">Submit Selection</button>
        </div>
</form>
        <h5 id="pro"></h5>
    </div>
</section>

 <!-- Contact Section -->

   <section class="contact bg-secondary-subtle py-5 m-2" id="contact">
     <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 text-center">
                <h2 class="mb-4">Contact Us</h2>
                <p class="lead mb-5">We'd love to hear from you! Reach out to us for any questions or feedback.</p>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form method="post" action="contact.php" name="contactForm">
                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                    </div>
                    <div class="mb-3">
                        <label for="subject" class="form-label">boject</label>
                        <input type="text" class="form-control" id="subject" name="subject" placeholder="Enter the object you want" required>
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Message</label>
                        <textarea class="form-control" id="message" name="message" rows="5" placeholder="Enter quality,size,product type of the matarial" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary " id="send">Send Message</button>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- footer section -->

<section>
     <footer class="bg-dark text-white py-4">
    <div class="container">
        <div class="row">
            <!-- Left Section -->
            <div class="col-md-6">
                <p>&copy; <span id="year"></span>marelign yimer. All Rights Reserved.</p>
            </div>
            <!-- Right Section (Social Media Links) -->
            <div class="col-md-6 text-end">
                <a href="https://www.facebook.com/profile.php?id=100070214702976&mibextid=rS40aB7S9Ucbxw6v" class="text-white mx-2" target="_blank">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="https://www.instagram.com/ma.y4534" class="text-white mx-2" target="_blank">
                    <i class="fab fa-instagram"></i>
                </a>
                <a href="https://www.tiktok.com/@maru.man1?_t=ZM-8tzPMST9y8U&_r=1" class="text-white mx-2" target="_blank">
                    <i class="fab fa-tiktok"></i>
                </a>
                <a href="https://t.me/marelignY" class="text-white mx-2" target="_blank">
                <i class="fab fa-telegram-plane"></i>
                <a href="mailto:yimermarelign@gmail.com-email@gmail.com" class="text-white mx-2">
                    <i class="fas fa-envelope"></i>
                </a>
                <a href="tel:+123456789" class="text-white mx-2">
                    <i class="fas fa-phone-alt">-251 945342453</i>
                </a>
            </div>
        </div>
    </div>
  </footer>
</section>

<script src="script.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
          integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
           crossorigin="anonymous"></script>
  
</body>
</html>
