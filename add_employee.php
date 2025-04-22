<?php
session_start();
include 'conn.php';
    function generateEmployeeId($conn) {
        $result = $conn->query("SELECT employee_id FROM dbl_employees_acc ORDER BY id DESC LIMIT 1");

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $lastId = intval(substr($row['employee_id'], 3));
            $newId = $lastId + 1; 
        } else {
            $newId = 1;
        }

        return 'EMP' . str_pad($newId, 3, '0', STR_PAD_LEFT); 
    }

    function generateAdminId($conn) {
        $result = $conn->query("SELECT employee_id FROM dbl_employees_acc ORDER BY id DESC LIMIT 1");

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $lastId = intval(substr($row['employee_id'], 3));
            $newId = $lastId + 1; 
        } else {
            $newId = 1;
        }

        return 'ADM' . str_pad($newId, 3, '0', STR_PAD_LEFT); 
    }

    $role = 'admin';
    if ($role === 'admin') {
        $employee_id = generateAdminId($conn);
    } else {
        $employee_id = generateEmployeeId($conn);
    }

        $username = 'employee';
        $email = 'employee@example.com';
        $raw_password = 'employee';
        $hashed_password = password_hash($raw_password, PASSWORD_DEFAULT);
        $full_name = 'Juan Dela Cruz';
        $role = 'employee';

        $stmt = $conn->prepare("INSERT INTO dbl_employees_acc (employee_id, username, email, password, full_name, role) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $employee_id, $username, $email, $hashed_password, $full_name, $role);

        if ($stmt->execute()) {
            echo "Employee account created with ID: $employee_id";
        } else {
            echo "Error: " . $stmt->error;
}
?>
