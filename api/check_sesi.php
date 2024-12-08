<?php
session_start();

if (!isset($_SESSION['username'])) {
  $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
    header('Location: ../login.php'); 
    exit();
}

$username = $_SESSION['username'];

include "db_connection.php";

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$stmt->close();
$conn->close(); 

?>