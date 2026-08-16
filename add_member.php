<?php
require 'config.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name  = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);

    if ($name === '' || $email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid name and email address.';
    } else {
        $stmt = $conn->prepare("INSERT INTO members (name, email, phone) VALUES (?, ?, ?)");
        $stmt->bind_param('sss', $name, $email, $phone);

        if ($stmt->execute()) {
            header('Location: members.php?msg=' . urlencode('Member added successfully.'));
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
    <h1>Add Member</h1>
</div>

<?php if ($error): ?>
    <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
<?php endif; ?>

<div class="form-card">
    <form method="post" action="add_member.php">
        <div class="form-group">
            <label for="name">Full Name</label>
            <input type="text" id="name" name="name" required
                   value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>">
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required
                   value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
        </div>
        <div class="form-group">
            <label for="phone">Phone</label>
            <input type="text" id="phone" name="phone"
                   value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ''; ?>">
        </div>
        <button type="submit" class="btn btn-primary">Save Member</button>
        <a href="members.php" class="btn btn-sm" style="background:#eee;color:#333;">Cancel</a>
    </form>
</div>

<?php require 'footer.php'; ?>
