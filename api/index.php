<?php
require 'config.php';
require 'header.php';

// Count total books (sum of quantity)
$totalBooks = $conn->query("SELECT COALESCE(SUM(quantity),0) AS total FROM books")->fetch_assoc()['total'];

// Count available books
$availableBooks = $conn->query("SELECT COALESCE(SUM(available),0) AS total FROM books")->fetch_assoc()['total'];

// Count members
$totalMembers = $conn->query("SELECT COUNT(*) AS total FROM members")->fetch_assoc()['total'];

// Count currently issued (not yet returned) books
$issuedBooks = $conn->query("SELECT COUNT(*) AS total FROM transactions WHERE status = 'Issued'")->fetch_assoc()['total'];
?>

<div class="page-header">
    <h1>Dashboard</h1>
</div>

<div class="card-grid">
    <div class="stat-card">
        <div class="number"><?php echo $totalBooks; ?></div>
        <div class="label">Total Books (all copies)</div>
    </div>
    <div class="stat-card">
        <div class="number"><?php echo $availableBooks; ?></div>
        <div class="label">Copies Available</div>
    </div>
    <div class="stat-card">
        <div class="number"><?php echo $totalMembers; ?></div>
        <div class="label">Registered Members</div>
    </div>
    <div class="stat-card">
        <div class="number"><?php echo $issuedBooks; ?></div>
        <div class="label">Books Currently Issued</div>
    </div>
</div>

<div class="page-header" style="margin-top:36px;">
    <h1 style="font-size:1.2rem;">Quick Actions</h1>
</div>
<p>
    <a href="add_book.php" class="btn btn-primary">+ Add Book</a>
    <a href="add_member.php" class="btn btn-accent">+ Add Member</a>
    <a href="issue_book.php" class="btn btn-primary">Issue a Book</a>
</p>

<?php require 'footer.php'; ?>
