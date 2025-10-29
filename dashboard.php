<?php

session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'domain' => 'localhost',
    'secure' => false,
    'httponly' => true,
    'samesite' => 'Lax'
]);
session_start();
if (!isset($_SESSION['user_id'])) {
   header("Location: /book-exchange/public/dashboard.php");

    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Book Exchange</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<div class="navbar">
    <a href="dashboard.php">Dashboard</a>
    <a href="add_book.php">Add Book</a>
    <a href="view_books.php">View Books</a>
    <a href="logout.php" style="color: #ff4d4d;">Logout</a>
</div>

<div class="container">
    <h2>Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?>!</h2>
    <p>Use the navigation above to manage your book exchange listings.</p>
</div>

</body>
</html>

