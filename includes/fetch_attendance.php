<?php
session_start();
include '../conn.php';

header("Content-Type: application/json");

if (!isset($_SESSION['employee_id'])) {
    echo json_encode(["status" => "error", "message" => "Unauthorized"]);
    exit();
}

$employee_id = $_SESSION['employee_id'];

$query = $conn->prepare("
    SELECT 
        date,
        time_in,
        time_out,
        time_in_raw,
        time_out_raw,
        status,
        location_in
    FROM dbl_attendance_logs 
    WHERE employee_id = ? 
    ORDER BY date DESC
");
$query->bind_param("s", $employee_id);
$query->execute();
$result = $query->get_result();

$logs = [];

while ($row = $result->fetch_assoc()) {
    $formatted_date = strtotime($row['date']) ? date('F j, Y', strtotime($row['date'])) : 'N/A';
    $formatted_time_in = !empty($row['time_in']) 
        ? $row['time_in'] 
        : (!empty($row['time_in_raw']) ? date('l - h:i A', strtotime($row['time_in_raw'])) : 'N/A');
    $formatted_time_out = !empty($row['time_out']) 
        ? $row['time_out'] 
        : (!empty($row['time_out_raw']) ? date('l - h:i A', strtotime($row['time_out_raw'])) : 'N/A');
    $status = (!empty($row['status']) && !preg_match('/^\d{4}-\d{2}-\d{2}/', $row['status']))
        ? $row['status']
        : 'Pending';

    $logs[] = [
        'date' => $formatted_date,
        'time_in' => $formatted_time_in,
        'time_out' => $formatted_time_out,
        'status' => $status,
        'location_in' => $row['location_in']
    ];
}

echo json_encode($logs);
?>
