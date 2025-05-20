<?php
include '../conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $employee_id = $_POST['employee_id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $full_name = $_POST['full_name'];
    $role = $_POST['role'];

    $stmt = $conn->prepare("UPDATE dbl_employees_acc SET employee_id = ?, username = ?, email = ?, full_name = ?, role = ? WHERE id = ?");
    $stmt->bind_param("sssssi", $employee_id, $username, $email, $full_name, $role, $id);

    if ($stmt->execute()) {
        header("Location: ../admin/employees.php?status=edited");
    } else {
        echo "Error updating record: " . $conn->error;
    }
    $stmt->close();
}
$conn->close();
