<?php
include 'db_connection.php';

$id = $_GET['id'];
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $sql1 = "SELECT * from users WHERE id = ?";
    $stmt = $conn->prepare($sql1);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0){
        $row = $result->fetch_assoc();
        $current_name = $row['nama'];
        $current_email = $row['email'];
        $current_username = $row['username'];
        $current_password = $row['password'];
        $current_role = $row['role'];
        $current_nomor_telp = $row['nomor_telp'];
        $current_instansi = $row['lembaga'];
    }
    $nama_baru = !empty($_POST['nama']) ? htmlspecialchars($_POST['nama'], ENT_QUOTES, 'UTF-8') : $current_name;
    $email_baru = !empty($_POST['email']) ? htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8') : $current_email;
    $username_baru = !empty($_POST['username']) ? htmlspecialchars($_POST['username'], ENT_QUOTES, 'UTF-8') : $current_username;
    $password_baru = !empty($_POST['password']) ? htmlspecialchars($_POST['password'], ENT_QUOTES, 'UTF-8') : $current_password;
    $role_baru = !empty($_POST['role']) ? htmlspecialchars($_POST['role'], ENT_QUOTES, 'UTF-8') : $current_role;
    $nomor_telp_baru = !empty($_POST['nomor_telp']) ? htmlspecialchars($_POST['nomor_telp'], ENT_QUOTES, 'UTF-8') : $current_nomor_telp;
    $instansi_baru = !empty($_POST['lembaga']) ? htmlspecialchars($_POST['lembaga'], ENT_QUOTES, 'UTF-8') : $current_instansi;

    $query = "UPDATE users SET nama = '$nama_baru', email = '$email_baru', username = '$username_baru', password = '$password_baru', role = '$role_baru', nomor_telp = '$nomor_telp_baru', instansi = '$instansi_baru' WHERE id = '$id'";
    mysqli_query($conn, $query);

    if($conn->query($query) === true) {
        header("Location: ../tables.php");
        exit();
    } else {
        echo "Error: " . $query . "<br>" . $conn->error;
    }
}

$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows > 0){
  $baris = $result->fetch_assoc();
} else {
  exit;
}

$conn->close();

?>