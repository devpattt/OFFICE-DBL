<?php
session_start();
include '../conn.php';

if (!isset($_SESSION['employee_id'])) {
    echo json_encode([]);
    exit();
}

$employee_id = $_SESSION['employee_id'];

$query = $conn->prepare("SELECT date, time_in, time_out, status, location_in FROM dbl_attendance_logs WHERE employee_id = ? ORDER BY date DESC");
$query->bind_param("s", $employee_id);
$query->execute();
$result = $query->get_result();

$logs = [];
while ($row = $result->fetch_assoc()) {
    $row['date'] = date('F j, Y', strtotime($row['date']));
    $row['time_in'] = !empty($row['time_in']) ? $row['time_in'] : 'N/A';
    $row['time_out'] = !empty($row['time_out']) ? $row['time_out'] : 'N/A';
    $logs[] = $row;
}

echo json_encode($logs);
?>