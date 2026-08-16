<?php
require 'config.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $book_id   = (int) $_POST['book_id'];
    $member_id = (int) $_POST['member_id'];
    $issue_date = date('Y-m-d');
    $due_date   = date('Y-m-d', strtotime('+14 days')); // 2-week loan period

    // Confirm the book has at least one available copy
    $check = $conn->prepare("SELECT available FROM books WHERE book_id = ?");
    $check->bind_param('i', $book_id);
    $check->execute();
    $book = $check->get_result()->fetch_assoc();
    $check->close();

    if (!$book || $book['available'] < 1) {
        $error = 'This book has no available copies right now.';
    } else {
        // Record the transaction
        $stmt = $conn->prepare(
            "INSERT INTO transactions (book_id, member_id, issue_date, due_date, status) VALUES (?, ?, ?, ?, 'Issued')"
        );
        $stmt->bind_param('iiss', $book_id, $member_id, $issue_date, $due_date);
        $stmt->execute();
        $stmt->close();

        // Decrease the available copy count
        $update = $conn->prepare("UPDATE books SET available = available - 1 WHERE book_id = ?");
        $update->bind_param('i', $book_id);
        $update->execute();
        $update->close();

        header('Location: transactions.php?msg=' . urlencode('Book issued successfully. Due back on ' . $due_date));
        exit;
    }
}

// Fetch books that currently have at least one available copy
$books = $conn->query("SELECT book_id, title, available FROM books WHERE available > 0 ORDER BY title");
// Fetch all members
$members = $conn->query("SELECT member_id, name FROM members ORDER BY name");

require 'header.php';
?>

<div class="page-header">
    <h1>Issue a Book</h1>
</div>

<?php if ($error): ?>
    <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
<?php endif; ?>

<div class="form-card">
    <form method="post" action="issue_book.php">
        <div class="form-group">
            <label for="book_id">Book</label>
            <select id="book_id" name="book_id" required>
                <option value="">-- Select a book --</option>
                <?php if ($books && $books->num_rows > 0): ?>
                    <?php while ($b = $books->fetch_assoc()): ?>
                        <option value="<?php echo $b['book_id']; ?>">
                            <?php echo htmlspecialchars($b['title']); ?> (<?php echo $b['available']; ?> available)
                        </option>
                    <?php endwhile; ?>
                <?php endif; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="member_id">Member</label>
            <select id="member_id" name="member_id" required>
                <option value="">-- Select a member --</option>
                <?php if ($members && $members->num_rows > 0): ?>
                    <?php while ($m = $members->fetch_assoc()): ?>
                        <option value="<?php echo $m['member_id']; ?>"><?php echo htmlspecialchars($m['name']); ?></option>
                    <?php endwhile; ?>
                <?php endif; ?>
            </select>
        </div>
        <p style="color:#6b6b6b; font-size:0.85rem;">Loan period is 14 days from today.</p>
        <button type="submit" class="btn btn-primary">Issue Book</button>
        <a href="transactions.php" class="btn btn-sm" style="background:#eee;color:#333;">Cancel</a>
    </form>
</div>

<?php require 'footer.php'; ?>
