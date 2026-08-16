<?php
require 'config.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id > 0) {
    // Find the transaction so we know which book to restock
    $stmt = $conn->prepare("SELECT book_id FROM transactions WHERE transaction_id = ? AND status = 'Issued'");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $transaction = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if ($transaction) {
        $today = date('Y-m-d');

        // Mark the transaction as returned
        $update = $conn->prepare("UPDATE transactions SET status = 'Returned', return_date = ? WHERE transaction_id = ?");
        $update->bind_param('si', $today, $id);
        $update->execute();
        $update->close();

        // Increase the available copy count for that book
        $bookUpdate = $conn->prepare("UPDATE books SET available = available + 1 WHERE book_id = ?");
        $bookUpdate->bind_param('i', $transaction['book_id']);
        $bookUpdate->execute();
        $bookUpdate->close();
    }
}

header('Location: transactions.php?msg=' . urlencode('Book marked as returned.'));
exit;
