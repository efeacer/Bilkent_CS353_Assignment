<?php
require 'ConnectionFactory.class.php';
$conn = ConnectionFactory::getConnection();

// Get the form variables
$username = strtolower($_POST['username']);
$password = $_POST['password'];

$query = "SELECT COUNT(*) AS count
          FROM customer
          WHERE LOWER(name) = '$username' AND cid = '$password'";

$result = $conn->query($query) or die('Error in query: ' . $conn->error);
$data = $result->fetch_assoc();

if ($data['count'] > 0) {
    session_start();
    $_SESSION['cid'] = $password; // pass the cid to the other pages
    header('Location: welcome.php');
} else {
    echo '<script>alert("Login failed, wrong credentials.");';
    echo 'document.location = "index.php";</script>';
}
$conn->close();
?>
