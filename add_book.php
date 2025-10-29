<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once "../config/db.php";

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title          = trim($_POST['title']);
    $author         = trim($_POST['author']);
    $edition        = trim($_POST['edition']);
    $book_condition = $_POST['book_condition'];
    $user_id        = $_SESSION['user_id'];

    if (empty($title) || empty($author) || empty($book_condition)) {
        $error = "Please fill in all required fields.";
    } else {
        $sql = "INSERT INTO books (title, author, edition, book_condition, user_id) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $title, $author, $edition, $book_condition, $user_id);
        if ($stmt->execute()) {
            // Redirect with success
            header("Location: view_books.php?success=1");
            exit();
        } else {
            $error = "Error adding book. Please try again.";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Add Book - Book Exchange</title>
    <link rel="stylesheet" href="../assets/style.css" />
</head>
<body>

<div class="navbar">
    <a href="dashboard.php">Dashboard</a>
    <a href="add_book.php">Add Book</a>
    <a href="view_books.php">View Books</a>
    <a href="logout.php" style="color: #ff4d4d;">Logout</a>
</div>

<div class="container">
    <h2>Add a New Book</h2>

    <?php if ($error): ?>
        <div class="error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form method="POST">
        <input type="text" name="title" placeholder="Title" required />
        <input type="text" name="author" placeholder="Author" required />
        <input type="text" name="edition" placeholder="Edition" />
        
        <label for="book_condition">Condition:</label>
        <select name="book_condition" id="book_condition" required>
            <option value="">Select condition</option>
            <option value="New">New</option>
            <option value="Good">Good</option>
            <option value="Fair">Fair</option>
            <option value="Poor">Poor</option>
        </select>

        <button type="submit">Add Book</button>
    </form>
</div>

</body>
</html>


