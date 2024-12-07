<?php

// Path: api/auth.php
include 'db_connection.php';

echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Login berhasil
        echo "
            <script>
                window.onload = function() {
                    Swal.fire({
                        title: 'Login Successful!',
                        text: 'You will be redirected to the dashboard.',
                        icon: 'success',
                        timer: 3000,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.href = '../index.php';
                    });
                }
            </script>
        ";
    } else {
        // Login gagal
        echo "
            <script>
                window.onload = function() {
                    Swal.fire({
                        title: 'Invalid Username or Password',
                        text: 'Please try again.',
                        icon: 'error',
                        timer: 3000,
                        showConfirmButton: false
                    }).then(() => {
                        window.history.back();
                    });
                }
            </script>
        ";
    }
}
?>
