<?php
include 'db_connection.php';

if(isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($sql);
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        $row = null;
    }
} else {
    $row = null;
}

?>