<?php
require 'config.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$error = '';

$stmt = $conn->prepare("SELECT * FROM members WHERE member_id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$member = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$member) {
    header('Location: members.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name  = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);

    if ($name === '' || $email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid name and email address.';
    } else {
        $update = $conn->prepare("UPDATE members SET name = ?, email = ?, phone = ? WHERE member_id = ?");
        $update->bind_param('sssi', $name, $email, $phone, $id);

        if ($update->execute()) {
            header('Location: members.php?msg=' . urlencode('Member updated successfully.'));
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
    <h1>Edit Member</h1>
</div>

<?php if ($error): ?>
    <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
<?php endif; ?>

<div class="form-card">
    <form method="post" action="edit_member.php?id=<?php echo $member['member_id']; ?>">
        <div class="form-group">
            <label for="name">Full Name</label>
            <input type="text" id="name" name="name" required
                   value="<?php echo htmlspecialchars($_POST['name'] ?? $member['name']); ?>">
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required
                   value="<?php echo htmlspecialchars($_POST['email'] ?? $member['email']); ?>">
        </div>
        <div class="form-group">
            <label for="phone">Phone</label>
            <input type="text" id="phone" name="phone"
                   value="<?php echo htmlspecialchars($_POST['phone'] ?? $member['phone']); ?>">
        </div>
        <button type="submit" class="btn btn-primary">Update Member</button>
        <a href="members.php" class="btn btn-sm" style="background:#eee;color:#333;">Cancel</a>
    </form>
</div>

<?php require 'footer.php'; ?>
