<?php
require 'config.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title    = trim($_POST['title']);
    $author   = trim($_POST['author']);
    $isbn     = trim($_POST['isbn']);
    $quantity = (int) $_POST['quantity'];

    if ($title === '' || $author === '' || $isbn === '' || $quantity < 1) {
        $error = 'Please fill in all fields correctly (quantity must be at least 1).';
    } else {
        // Use a prepared statement to prevent SQL injection
        $stmt = $conn->prepare(
            "INSERT INTO books (title, author, isbn, quantity, available) VALUES (?, ?, ?, ?, ?)"
        );
        $stmt->bind_param('sssii', $title, $author, $isbn, $quantity, $quantity);

        if ($stmt->execute()) {
            header('Location: books.php?msg=' . urlencode('Book added successfully.'));
            exit;
        } else {
            $error = 'Something went wrong: ' . $stmt->error;
        }
        $stmt->close();
    }
}

require 'header.php';
?>

<div class="page-header">
    <h1>Add Book</h1>
</div>

<?php if ($error): ?>
    <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
<?php endif; ?>

<div class="form-card">
    <form method="post" action="add_book.php">
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" id="title" name="title" required
                   value="<?php echo isset($_POST['title']) ? htmlspecialchars($_POST['title']) : ''; ?>">
        </div>
        <div class="form-group">
            <label for="author">Author</label>
            <input type="text" id="author" name="author" required
                   value="<?php echo isset($_POST['author']) ? htmlspecialchars($_POST['author']) : ''; ?>">
        </div>
        <div class="form-group">
            <label for="isbn">ISBN</label>
            <input type="text" id="isbn" name="isbn" required
                   value="<?php echo isset($_POST['isbn']) ? htmlspecialchars($_POST['isbn']) : ''; ?>">
        </div>
        <div class="form-group">
            <label for="quantity">Quantity (number of copies)</label>
            <input type="number" id="quantity" name="quantity" min="1" required
                   value="<?php echo isset($_POST['quantity']) ? (int) $_POST['quantity'] : 1; ?>">
        </div>
        <button type="submit" class="btn btn-primary">Save Book</button>
        <a href="books.php" class="btn btn-sm" style="background:#eee;color:#333;">Cancel</a>
    </form>
</div>

<?php require 'footer.php'; ?>
