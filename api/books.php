<?php
require 'config.php';
require 'header.php';

$result = $conn->query("SELECT * FROM books ORDER BY book_id DESC");
?>

<div class="page-header">
    <h1>Books</h1>
    <a href="add_book.php" class="btn btn-primary">+ Add Book</a>
</div>

<?php if (isset($_GET['msg'])): ?>
    <div class="alert alert-success"><?php echo htmlspecialchars($_GET['msg']); ?></div>
<?php endif; ?>

<?php if ($result && $result->num_rows > 0): ?>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Author</th>
            <th>ISBN</th>
            <th>Quantity</th>
            <th>Available</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td>#<?php echo $row['book_id']; ?></td>
            <td><?php echo htmlspecialchars($row['title']); ?></td>
            <td><?php echo htmlspecialchars($row['author']); ?></td>
            <td><?php echo htmlspecialchars($row['isbn']); ?></td>
            <td><?php echo $row['quantity']; ?></td>
            <td>
                <?php if ($row['available'] > 0): ?>
                    <span class="badge badge-success"><?php echo $row['available']; ?> available</span>
                <?php else: ?>
                    <span class="badge badge-danger">None available</span>
                <?php endif; ?>
            </td>
            <td class="actions">
                <a href="edit_book.php?id=<?php echo $row['book_id']; ?>" class="btn btn-accent btn-sm">Edit</a>
                <a href="delete_book.php?id=<?php echo $row['book_id']; ?>"
                   class="btn btn-danger btn-sm"
                   onclick="return confirm('Delete this book? This cannot be undone.');">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>
<?php else: ?>
    <div class="empty-state">No books in the library yet. <a href="add_book.php">Add the first one</a>.</div>
<?php endif; ?>

<?php require 'footer.php'; ?>
