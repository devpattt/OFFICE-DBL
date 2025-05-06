<?php
include '../conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = intval($_POST['id']);

    $sql = "UPDATE dbl_employees_acc SET status = 'Active' WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: /DBL/admin/employees.php?status=activated");
        exit();
    } else {
        echo "Error activating employee: " . $conn->error;
    }

    $stmt->close();
} else {
    echo "Invalid request.";
}

$conn->close();
?>
