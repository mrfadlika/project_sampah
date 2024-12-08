<?php

// Path: api/add_user.php

session_start();

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $nama = $_POST["nama"];
    $email = $_POST["email"];
    $input_username = $_POST["username"];
    $input_password = $_POST["password"]; 
    $role = $_POST["role"];
    $nomor_telp = $_POST["nomor_telp"];

    include "db_connection.php";

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO users (nama, username, email, password, role, nomor_telp) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssssss', $nama, $input_username, $email, $input_password, $role, $nomor_telp);
    
    if ($stmt->execute()) {
        $stmt->close();
        $conn->close();
        header("Location: ../tables.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
