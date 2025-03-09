<?php
session_start();
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $role = isset($_GET['role']) ? $_GET['role'] : '';

    if ($role) {
        $query = "SELECT username FROM users WHERE role = ?";
        
        if ($stmt = $conn->prepare($query)) {
            $stmt->bind_param("s", $role); 
            $stmt->execute();
            $result = $stmt->get_result();
            
            $usernames = [];
            while ($row = $result->fetch_assoc()) {
                $usernames[] = $row;
            }
            
            $stmt->close();
            echo json_encode($usernames);
        } else {
            echo json_encode(['error' => 'Query preparation failed']);
        }
    } else {
        echo json_encode(['error' => 'Role is required']);
    }

    $conn->close();
}
?>
