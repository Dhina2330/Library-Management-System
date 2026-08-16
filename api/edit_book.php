<?php
require 'config.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$error = '';

// Fetch the existing book
$stmt = $conn->prepare("SELECT * FROM books WHERE book_id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$book = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$book) {
    header('Location: books.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title    = trim($_POST['title']);
    $author   = trim($_POST['author']);
    $isbn     = trim($_POST['isbn']);
    $quantity = (int) $_POST['quantity'];

    // Work out how many copies are currently issued so we never set
    // available below what is out on loan.
    $issuedStmt = $conn->prepare("SELECT COUNT(*) AS c FROM transactions WHERE book_id = ? AND status = 'Issued'");
    $issuedStmt->bind_param('i', $id);
    $issuedStmt->execute();
    $issuedCount = $issuedStmt->get_result()->fetch_assoc()['c'];
    $issuedStmt->close();

    if ($title === '' || $author === '' || $isbn === '' || $quantity < $issuedCount) {
        $error = "Quantity cannot be less than the $issuedCount copy(ies) currently issued.";
    } else {
        $newAvailable = $quantity - $issuedCount;

        $update = $conn->prepare(
            "UPDATE books SET title = ?, author = ?, isbn = ?, quantity = ?, available = ? WHERE book_id = ?"
        );
        $update->bind_param('sssiii', $title, $author, $isbn, $quantity, $newAvailable, $id);

        if ($update->execute()) {
            header('Location: books.php?msg=' . urlencode('Book updated successfully.'));
            exit;
        } else {
            $error = 'Something went wrong: ' . $update->error;
        }
        $update->close();
    }
}

require 'header.php';
?>

<div class="page-header">
    <h1>Edit Book</h1>
</div>

<?php if ($error): ?>
    <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
<?php endif; ?>

<div class="form-card">
    <form method="post" action="edit_book.php?id=<?php echo $book['book_id']; ?>">
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" id="title" name="title" required
                   value="<?php echo htmlspecialchars($_POST['title'] ?? $book['title']); ?>">
        </div>
        <div class="form-group">
            <label for="author">Author</label>
            <input type="text" id="author" name="author" required
                   value="<?php echo htmlspecialchars($_POST['author'] ?? $book['author']); ?>">
        </div>
        <div class="form-group">
            <label for="isbn">ISBN</label>
            <input type="text" id="isbn" name="isbn" required
                   value="<?php echo htmlspecialchars($_POST['isbn'] ?? $book['isbn']); ?>">
        </div>
        <div class="form-group">
            <label for="quantity">Quantity (number of copies)</label>
            <input type="number" id="quantity" name="quantity" min="1" required
                   value="<?php echo (int) ($_POST['quantity'] ?? $book['quantity']); ?>">
        </div>
        <button type="submit" class="btn btn-primary">Update Book</button>
        <a href="books.php" class="btn btn-sm" style="background:#eee;color:#333;">Cancel</a>
    </form>
</div>

<?php require 'footer.php'; ?>
