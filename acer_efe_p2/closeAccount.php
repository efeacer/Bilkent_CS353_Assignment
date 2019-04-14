<?php
require 'ConnectionFactory.class.php';
$conn = ConnectionFactory::getConnection();

session_start();
$cid = $_SESSION['cid'];

$aid = $_GET['aid'];

$query = "SELECT name
          FROM customer
          WHERE cid='$cid'";
$result = $conn->query($query) or die('Error in query: ' . $conn->error);
$data = $result->fetch_assoc();
$name = $data['name'];

$query = "DELETE
          FROM owns
          WHERE cid = '$cid' AND aid = '$aid'";
$result = $conn->query($query);
if (!$result) {
    echo '<script>alert("Deletion failed.");</script>';
}

$query = "DELETE
          FROM account
          WHERE aid = '$aid'";
$result = $conn->query($query);
if (!$result) {
    echo '<script>alert("Deletion failed.");</script>';
} else {
    session_start();
    $_SESSION['name'] = $name;
    $_SESSION['cid'] = $cid;
    echo '<script>alert("Account is closed.");';
    echo 'document.location = "welcome.php";</script>';
}
?>
