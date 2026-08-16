<?php
require 'config.php';
require 'header.php';

$sql = "SELECT t.transaction_id, t.issue_date, t.due_date, t.return_date, t.status,
               b.title AS book_title, m.name AS member_name, t.book_id
        FROM transactions t
        JOIN books b ON t.book_id = b.book_id
        JOIN members m ON t.member_id = m.member_id
        ORDER BY t.transaction_id DESC";
$result = $conn->query($sql);
?>

<div class="page-header">
    <h1>Issue / Return Books</h1>
    <a href="issue_book.php" class="btn btn-primary">+ Issue a Book</a>
</div>

<?php if (isset($_GET['msg'])): ?>
    <div class="alert alert-success"><?php echo htmlspecialchars($_GET['msg']); ?></div>
<?php endif; ?>

<?php if ($result && $result->num_rows > 0): ?>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Book</th>
            <th>Member</th>
            <th>Issue Date</th>
            <th>Due Date</th>
            <th>Return Date</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td>#<?php echo $row['transaction_id']; ?></td>
            <td><?php echo htmlspecialchars($row['book_title']); ?></td>
            <td><?php echo htmlspecialchars($row['member_name']); ?></td>
            <td><?php echo htmlspecialchars($row['issue_date']); ?></td>
            <td><?php echo htmlspecialchars($row['due_date']); ?></td>
            <td><?php echo $row['return_date'] ? htmlspecialchars($row['return_date']) : '—'; ?></td>
            <td>
                <?php if ($row['status'] === 'Issued'): ?>
                    <span class="badge badge-danger">Issued</span>
                <?php else: ?>
                    <span class="badge badge-success">Returned</span>
                <?php endif; ?>
            </td>
            <td class="actions">
                <?php if ($row['status'] === 'Issued'): ?>
                    <a href="return_book.php?id=<?php echo $row['transaction_id']; ?>"
                       class="btn btn-accent btn-sm"
                       onclick="return confirm('Mark this book as returned?');">Mark Returned</a>
                <?php endif; ?>
            </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>
<?php else: ?>
    <div class="empty-state">No transactions yet. <a href="issue_book.php">Issue a book</a> to get started.</div>
<?php endif; ?>

<?php require 'footer.php'; ?>
