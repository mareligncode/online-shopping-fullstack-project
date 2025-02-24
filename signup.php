<?php
session_start();
$errors = [];

// Database configuration
$host = "localhost";
$user = "root"; // replace with your database username
$pass = ""; // replace with your database password
$dbname = "shopping";

// Create connection
$conn = mysqli_connect($host, $user, $pass, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $fname = trim($_POST['fname']);
    $email = trim($_POST['email']);
    $gender = $_POST['gender'];
    $password = trim($_POST['password']);
    $password2 = trim($_POST['password2']);

    // Validation
    if (empty($name)) $errors[] = "Name is required.";
    if (empty($fname)) $errors[] = "Father's name is required.";
    if (empty($email)) $errors[] = "Email is required.";
    if (empty($gender)) $errors[] = "Gender is required.";
    if (empty($password) || empty($password2)) $errors[] = "Password is required.";
    if ($password !== $password2) $errors[] = "Passwords do not match.";

    // If no errors, insert into database
    if (empty($errors)) {
        // Check if the email already exists
        $checkUser = mysqli_prepare($conn, "SELECT * FROM users WHERE email = ?");
        mysqli_stmt_bind_param($checkUser, "s", $email);
        mysqli_stmt_execute($checkUser);
        $result = mysqli_stmt_get_result($checkUser);

        if (mysqli_num_rows($result) > 0) {
            $errors[] = "User already exists with this email.";
        } else {
            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Prepare the insert statement
            $stmt = mysqli_prepare($conn, "INSERT INTO users (name, fname, email, gender, password) VALUES (?, ?, ?, ?, ?)");
            mysqli_stmt_bind_param($stmt, "sssss", $name, $fname, $email, $gender, $hashedPassword);

            // Execute the statement
            if (mysqli_stmt_execute($stmt)) {
                // Redirect to login page
                echo "registered";
                header("Location: index.php#login");
                exit;}

                


             else {
                $errors[] = "Registration failed. Please try again.";
            }

            // Close the statement
            mysqli_stmt_close($stmt);
        }

        // Close the check user statement
        mysqli_stmt_close($checkUser);
    }
}

// Include error messages in your form (if any)
foreach ($errors as $error) {
    echo "<p style='color:red;'>$error</p>";
}

// Close connection
mysqli_close($conn);
?>