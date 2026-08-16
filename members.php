<?php
require 'config.php';
require 'header.php';

$result = $conn->query("SELECT * FROM members ORDER BY member_id DESC");
?>

<div class="page-header">
    <h1>Members</h1>
    <a href="add_member.php" class="btn btn-primary">+ Add Member</a>
</div>

<?php if (isset($_GET['msg'])): ?>
    <div class="alert alert-success"><?php echo htmlspecialchars($_GET['msg']); ?></div>
<?php endif; ?>

<?php if ($result && $result->num_rows > 0): ?>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td>#<?php echo $row['member_id']; ?></td>
            <td><?php echo htmlspecialchars($row['name']); ?></td>
            <td><?php echo htmlspecialchars($row['email']); ?></td>
            <td><?php echo htmlspecialchars($row['phone']); ?></td>
            <td class="actions">
                <a href="edit_member.php?id=<?php echo $row['member_id']; ?>" class="btn btn-accent btn-sm">Edit</a>
                <a href="delete_member.php?id=<?php echo $row['member_id']; ?>"
                   class="btn btn-danger btn-sm"
                   onclick="return confirm('Delete this member? This cannot be undone.');">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>
<?php else: ?>
    <div class="empty-state">No members registered yet. <a href="add_member.php">Add the first one</a>.</div>
<?php endif; ?>

<?php require 'footer.php'; ?>
