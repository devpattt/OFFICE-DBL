<?php
include '../conn.php';

$department = $_GET['department'] ?? '';

$stmt = $conn->prepare("SELECT employee_id, full_name FROM dbl_employees_acc WHERE status = 'active' AND department = ?");
$stmt->bind_param("s", $department);
$stmt->execute();
$result = $stmt->get_result();

$employees = [];
while ($row = $result->fetch_assoc()) {
    $employees[] = $row;
}

echo json_encode($employees);
?>
