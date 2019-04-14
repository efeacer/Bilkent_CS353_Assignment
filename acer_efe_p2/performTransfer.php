<?php
require 'ConnectionFactory.class.php';
$conn = ConnectionFactory::getConnection();

// Get the form variables
$source = $_POST['source'];
$dest = $_POST['dest'];
$amount = $_POST['amount'];

session_start(); // start session to get cid and name
$cid = $_SESSION['cid'];

$query = "SELECT balance
          FROM account
          WHERE aid = '$source'";
$result = $conn->query($query) or die('Error in query: ' . $conn->error);
$data = $result->fetch_assoc();
$available = $data['balance'];

if ($available < $amount) {
    echo "<script>alert('Amount exceeds source balance.');";
    echo 'document.location = "moneyTransfer.php";</script>';
} else {
    $sourceBalance = $available - $amount;
    $query = "UPDATE account
              SET balance = $sourceBalance
              WHERE aid = '$source'";
    $result = $conn->query($query) or die('Error in query: ' . $conn->error);
    $query = "SELECT balance
              FROM account
              WHERE aid = '$dest'";
    $result = $conn->query($query) or die('Error in query: ' . $conn->error);
    $data = $result->fetch_assoc();
    $destBalance = $data['balance'] + $amount;
    $query = "UPDATE account
              SET balance = $destBalance
              WHERE aid = '$dest'";
    $result = $conn->query($query) or die('Error in query: ' . $conn->error);
    echo "<script>alert('Money successfully transferred.');";
    echo 'document.location = "moneyTransfer.php";</script>';
}
?>
