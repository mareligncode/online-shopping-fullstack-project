<?php
session_start();
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email)) $errors[] = "Email is required.";
    if (empty($password)) $errors[] = "Password is required.";

    if (empty($errors)) {
        $conn = mysqli_connect("localhost", "root", "", "shopping");
        $stmt = mysqli_prepare($conn, "SELECT id, password FROM users WHERE email = ?");
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $id, $hashedPassword);
        mysqli_stmt_fetch($stmt);

        if (password_verify($password, $hashedPassword)) {
            $_SESSION['user_id'] = $id;
            header("Location: index.php#service");
            exit;
        } else {
            $errors[] = "Invalid email or password.";
        }

        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    }
}
?>