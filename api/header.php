<?php
// Determine current page filename to highlight the active nav link
$current = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Library Management System</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="navbar">
    <div class="brand">📚 Library Management System</div>
    <nav>
        <a href="index.php" class="<?php echo $current == 'index.php' ? 'active' : ''; ?>">Dashboard</a>
        <a href="books.php" class="<?php echo in_array($current, ['books.php','add_book.php','edit_book.php']) ? 'active' : ''; ?>">Books</a>
        <a href="members.php" class="<?php echo in_array($current, ['members.php','add_member.php','edit_member.php']) ? 'active' : ''; ?>">Members</a>
        <a href="transactions.php" class="<?php echo in_array($current, ['transactions.php','issue_book.php']) ? 'active' : ''; ?>">Issue / Return</a>
    </nav>
</div>

<div class="container">
