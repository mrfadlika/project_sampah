<?php
session_start();

include 'db_connection.php';

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$db_name", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $input_password = $_POST['password'];

        $stmt = $pdo->prepare("SELECT password FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $stored_password = $row['password'];

            if ($input_password === $stored_password) {
                $_SESSION['username'] = $username;
                $_SESSION['success'] = "Login Berhasil";

                if (str_starts_with($username, "admin")) {
                    header('Location: ../admin.php');
                    exit();
                } elseif (str_starts_with($username, "bank_sampah")) {
                    header('Location: ../bank_sampah.php');
                    exit();
                } else {
                    header('Location: ../index.php');
                    exit();
                }
                exit();
            } else {
                $_SESSION['error'] = "Password Salah";
            }
        } else {
            $_SESSION['error'] = "Username Salah";
        }
        header('Location: ../login.php');
        exit();
    }
} catch (PDOException $e) {
    echo "Koneksi gagal: " . $e->getMessage();
}
?>
