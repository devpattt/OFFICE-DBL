<?php
session_start();
$conn = new mysqli("localhost", "root", "", "dbl");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id']) && isset($_GET['action'])) {
    $id = intval($_GET['id']);
    $action = $_GET['action'];

    if ($action == "deactivate") {
        $new_status = "inactive";
    } elseif ($action == "activate") {
        $new_status = "active";
    } else {

        header("Location: ../admin/employee.php?error=InvalidAction");
        exit();
    }


    $stmt = $conn->prepare("UPDATE dbl_employees_acc SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $new_status, $id);

    if ($stmt->execute()) {
        header("Location:  ../admin/employee.php?success=StatusUpdated");
        exit();
    } else {
        header("Location:  ../admin/employee.php?error=UpdateFailed");
        exit();
    }

    $stmt->close();
} else {
    // Missing parameters
    header("Location: admin_employees.php?error=MissingParameters");
    exit();
}

$conn->close();
?>
