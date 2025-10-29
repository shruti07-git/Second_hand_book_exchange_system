<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once "../config/db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['book_id'])) {
    $book_id = (int)$_POST['book_id'];
    $user_id = $_SESSION['user_id'];

    // Delete only if the book belongs to the logged-in user
    $sql = "DELETE FROM books WHERE book_id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $book_id, $user_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        header("Location: view_books.php?delete=success");
    } else {
        header("Location: view_books.php?delete=fail");
    }
    exit();
} else {
    header("Location: view_books.php");
    exit();
}
?>