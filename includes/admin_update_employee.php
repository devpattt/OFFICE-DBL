<?php
session_start();
$conn = new mysqli("localhost", "root", "", "dbl");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['id'], $_POST['full_name'], $_POST['email'], $_POST['role'])) {
    $id = intval($_POST['id']);
    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $role = trim($_POST['role']);

    $stmt = $conn->prepare("UPDATE dbl_employees_acc SET full_name = ?, email = ?, role = ? WHERE id = ?");
    $stmt->bind_param("sssi", $full_name, $email, $role, $id);

    if ($stmt->execute()) {
        header("Location: ../admin/employee.php?success=EmployeeUpdated");
        exit();
    } else {
        header("Location: ../admin/employee.php?error=UpdateFailed");
        exit();
    }

    $stmt->close();
} else {
    header("Location: ../admin/employee.php?error=MissingFields");
    exit();
}

$conn->close();
?>
