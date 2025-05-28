<?php
session_start();
include __DIR__ . '/../conn.php';

$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, employee_id, username, password, role, status, department FROM dbl_employees_acc WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        if ($row['status'] == 'inactive') {
            $errors[] = "Your account has been deactivated. Please contact support.";
        } else {
            if (password_verify($password, $row['password'])) {
                // Set session and redirect
                $_SESSION['username'] = $row['username'];
                $_SESSION['role'] = $row['role'];
                $_SESSION['employee_id'] = $row['employee_id'];
                $_SESSION['department'] = $row['department'];

                if ($row['role'] === 'Admin') {
                    header("Location: ../admin/home.php");
                } else if ($row['role'] === 'Employee') {
                    header("Location: ../employee/home.php");
                } else {
                    header("Location: ../client/home.php");
                }
                exit();
            } else {
                $errors[] = "Invalid login credentials.";
            }
        }
    } else {
        $errors[] = "Invalid login credentials.";
    }

    $_SESSION['login_errors'] = $errors;
    header("Location: ../index.php");  
    exit();
}
