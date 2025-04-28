<?php
header('Content-Type: application/json');

include '../conn.php';

$employee_id = $_POST['employee_id'] ?? '';
$location = $_POST['location'] ?? '';
$description = $_POST['description'] ?? '';

if (empty($employee_id) || empty($location) || empty($description)) {
    echo json_encode(['status' => 'error', 'message' => 'Missing required fields.']);
    exit;
}

if ($location == "Others") {
    $location = $_POST['other_location'] ?? '';
}

date_default_timezone_set('Asia/Manila');
$current_date = date('Y-m-d'); 
$current_time = date('H:i:s'); 

$stmt = $conn->prepare("INSERT INTO itinerary (employee_id, location, date, time, description) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $employee_id, $location, $current_date, $current_time, $description);

if ($stmt->execute()) {
    $response = ['status' => 'success', 'message' => 'Itinerary assigned successfully!'];
} else {
    $response = ['status' => 'error', 'message' => 'Error: ' . $stmt->error];
}

$stmt->close();
$conn->close();

echo json_encode($response);
?>
