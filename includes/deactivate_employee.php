<?php
include '../conn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = intval($_POST['id']);
    $sql = "UPDATE dbl_employees_acc SET status = 'inactive' WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        header("Location: ../admin/employees.php?status=success");
        exit();
    } else {
        header("Location: ../admin/employees.php?status=error");
        exit();
    }
}
?>
