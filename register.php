<?php
include 'connection.php';

if (isset($_POST['submit-btn'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate inputs
    $errors = [];
    if (empty($name)) {
        $errors[] = "Name is required";
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Valid email is required";
    }
    if (empty($password)) {
        $errors[] = "Password is required";
    }
    if ($confirm_password !== $password) {
        $errors[] = "Passwords do not match";
    }

    if (empty($errors)) {
        // Check Email already exists or not.
        $check = $conn->prepare("SELECT * FROM users WHERE email = :email");
        $check->bindParam(':email', $email);
        $check->execute();
        $result = $check->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $errors[] = "User email already exists";
        } else {

            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            // Prepare and execute the INSERT query So, each input value is treated as a single parameter, which prevents SQL injection attacks against your application.
            $stmt = $conn->prepare("INSERT INTO `users` (name, email, password) VALUES (:name, :email, :password)");
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashedPassword);

            if ($stmt->execute()) {
                header('location: login.php');
                exit; // Exit to prevent further execution
            } else {
                $errors[] = "Error inserting user data";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Honeyshop</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
</head>
<body>
<section class="form-control">
    <?php
    if (!empty($errors)) {
        // Display validation errors
        foreach ($errors as $error) {
            echo ' 
        <div class="message">
        <span>' . $error . '</span>
        <i class="bi bi-x-circle" onclick="this.parentElement.remove()"> </i>
        </div>
        ';
        }
    }
    ?>
    <form method="POST">
        <h1>Register Now</h1>
        <input type="text" name="name" placeholder="Enter your name">
        <input type="text" name="email" placeholder="Enter your email">
        <input type="password" name="password" placeholder="Enter your password">
        <input type="password" name="confirm_password" placeholder="Confirm your password">
        <input type="submit" name="submit-btn" value="Register Now" class="btn">
        <p>Already have an account? <a href="login.php">Login now</a></p>
    </form>
</section>


</body>
</html>
