<?php
session_start();
include '../conn.php'; // Assume this creates $conn

// Handle form submission first
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['full_name'], $_POST['username'], $_POST['email'], $_POST['password'], $_POST['role'])) {
        $full_name = trim($_POST['full_name']);
        $username = trim($_POST['username']);
        $email = trim($_POST['email']);
        $password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);
        $role = trim($_POST['role']);
        $status = 'active';

        $employee_id = 'EMP' . str_pad(rand(1, 99999), 5, '0', STR_PAD_LEFT);

        $stmt = $conn->prepare("INSERT INTO dbl_employees_acc (employee_id, username, email, password, full_name, role, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $employee_id, $username, $email, $password, $full_name, $role, $status);

        if ($stmt->execute()) {
            header("Location: ../admin/employee.php?success=EmployeeAdded");
            exit();
        } else {
            header("Location: ../admin/employee.php?error=AddFailed");
            exit();
        }

        $stmt->close();
    } else {
        header("Location: ../admin/employee.php?error=MissingFields");
        exit();
    }
}
