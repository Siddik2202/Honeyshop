<?php
include 'connection.php';
session_start();


if(isset($_POST['submit-btn'])){

    $email = $_POST['email'];
    $password = $_POST['password'];

 // Validate inputs
 $errors = [];
 if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
     $errors[] = "Valid email is required";
 }
 if (empty($password)) {
     $errors[] = "Password is required";
 }

 if (empty($errors)) {
     // Check if email and hashed password match in the database
     $stmt = $conn->prepare("SELECT * FROM `users` WHERE email = :email");
     $stmt->bindParam(':email', $email);
     $stmt->execute();
     $user = $stmt->fetch(PDO::FETCH_ASSOC); 

     if ($user && password_verify($password, $user['password'])) {
         // Email and hashed password match, redirect to index.php
         if($user['user_type'] == 'admin'){
            $_SESSION['admin_name'] = $user['name'];
            $_SESSION['admin_email'] = $user['email'];
            $_SESSION['admin_id'] = $user['id'];
            header('Location: admin_pannel.php');
            exit; // Stop further execution

          }elseif($user['user_type'] == 'user'){
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_id'] = $user['id'];
            header('Location: index.php');
            exit; // Stop further execution
        }else {
            $errors[] = "Invalid user type";
           }
      }else{
        $errors[] = "Invalid email or password";
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
    <h1>Login Now</h1>
    <div class="input-field">
        <label>Your Email</label><br>
        <input type="text" name="email" placeholder="Enter your email">
    </div>
    <div class="input-field">
        <label>Your Password</label><br>
        <input type="text" name="password" placeholder="Enter your password">
    </div>
    
    <input type="submit" name="submit-btn" value="register now" class="btn">
    <p> do not have an account ? <a href="register.php"> register now</a></p>
    </form>
</section>
    




</body>
</html>