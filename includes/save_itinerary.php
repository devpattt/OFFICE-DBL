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

$imagePath = null;
if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/dbl/itinerary/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    $fileName = uniqid() . '_' . basename($_FILES['image']['name']);
    $targetFile = $uploadDir . $fileName;
    if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
        $imagePath = '/dbl/itinerary/' . $fileName;
    }
}

$stmt = $conn->prepare("INSERT INTO itinerary (employee_id, location, date, time, description, image, status) VALUES (?, ?, ?, ?, ?, ?, 'Pending')");
$stmt->bind_param("ssssss", $employee_id, $location, $current_date, $current_time, $description, $imagePath);

if ($stmt->execute()) {
    $response = ['status' => 'success', 'message' => 'Itinerary assigned successfully!'];
} else {
    $response = ['status' => 'error', 'message' => 'Error: ' . $stmt->error];
}

$stmt->close();
$conn->close();

echo json_encode($response);
?>
