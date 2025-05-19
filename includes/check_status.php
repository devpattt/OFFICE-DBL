<?php
session_start();
include '../conn.php';

if (!isset($_SESSION['employee_id'])) {
    echo json_encode(["status" => "error", "message" => "User not logged in"]);
    exit;
}

$employee_id = $_SESSION['employee_id'];

$query = $conn->prepare("SELECT * FROM dbl_attendance_logs WHERE employee_id = ? AND time_out IS NULL ORDER BY date DESC LIMIT 1");
$query->bind_param("s", $employee_id);
$query->execute();
$result = $query->get_result();

if ($result->num_rows > 0) {
    echo json_encode(["status" => "clocked-in"]);
} else {
    echo json_encode(["status" => "clocked-out"]);
}

$conn->close();
?>
