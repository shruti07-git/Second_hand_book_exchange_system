<?php
session_start();
require_once "../config/db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name       = $_POST['name'];
    $email      = $_POST['email'];
    $university = $_POST['university'];
    $course     = $_POST['course'];
    $contact    = $_POST['contact'];
    $password   = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (name, email, university, course, contact, password)
            VALUES ('$name', '$email', '$university', '$course', '$contact', '$password')";

    if ($conn->query($sql) === TRUE) {
        header("Location: login.php");
        exit();
    } else {
        $error = "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - Book Exchange</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<div class="navbar">
    <a href="login.php">Login</a>
    <a href="register.php">Register</a>
</div>

<div class="container">
    <h2>Register to Book Exchange</h2>

    <?php if (!empty($error)): ?>
        <div class="error"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST">
        <input type="text" name="name" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="text" name="university" placeholder="University">
        <input type="text" name="course" placeholder="Course">
        <input type="text" name="contact" placeholder="Contact Number">
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Register</button>
    </form>
</div>

</body>
</html>
