<?php
session_start();
include __DIR__ . '/../conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, employee_id, username, password, role FROM dbl_employees_acc WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        if (password_verify($password, $row['password'])) {

            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = $row['role'];
            $_SESSION['employee_id'] = $row['employee_id']; 
            
            // RBAC
            if ($row['role'] === 'admin') {
                header("Location: ../admin/home.php"); 
            } else {
                header("Location: ../employee/home.php"); 
            }
            exit();
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "Username not found.";
    }

    $stmt->close();
}
?>
