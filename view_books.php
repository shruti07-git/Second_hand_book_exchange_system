<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once "../config/db.php";

$user_id = $_SESSION['user_id'];

$sql = "SELECT books.book_id, books.title, books.author, books.edition, books.book_condition, books.user_id, users.name AS owner_name
        FROM books
        JOIN users ON books.user_id = users.user_id";

$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Books - Book Exchange</title>
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
    <h2>Available Books for Exchange</h2>

    <?php if (isset($_GET['success'])): ?>
        <div class="success">Book added successfully!</div>
    <?php endif; ?>

    <?php if (isset($_GET['delete'])): ?>
        <?php if ($_GET['delete'] === 'success'): ?>
            <div class="success">Book deleted successfully!</div>
        <?php else: ?>
            <div class="error">Failed to delete book.</div>
        <?php endif; ?>
    <?php endif; ?>

    <?php if ($result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Edition</th>
                    <th>Condition</th>
                    <th>Owner</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while($book = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($book['title']); ?></td>
                        <td><?php echo htmlspecialchars($book['author']); ?></td>
                        <td><?php echo htmlspecialchars($book['edition']); ?></td>
                        <td><?php echo htmlspecialchars($book['book_condition']); ?></td>
                        <td><?php echo htmlspecialchars($book['owner_name']); ?></td>
                        <td>
                            <?php if ($book['user_id'] == $user_id): ?>
                                <form method="POST" action="delete_book.php" onsubmit="return confirm('Are you sure you want to delete this book?');" style="display:inline;">
                                    <input type="hidden" name="book_id" value="<?php echo $book['book_id']; ?>">
                                    <button type="submit" class="delete-button">Delete</button>
                                </form>
                            <?php else: ?>
                                —
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No books available for exchange at the moment.</p>
    <?php endif; ?>
</div>

</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
