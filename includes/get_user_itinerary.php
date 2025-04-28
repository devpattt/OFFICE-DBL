<?php

include '../conn.php'; // Include your database connection file

// Get the employee ID from the request
$employee_id = $_GET['employee_id'] ?? '';

if ($employee_id) {
    $stmt = $mysqli->prepare("SELECT * FROM itinerary WHERE employee_id = ? AND status = 'Pending' ORDER BY date ASC");
    $stmt->bind_param("s", $employee_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $itineraries = [];
    while ($row = $result->fetch_assoc()) {
        $itineraries[] = $row;
    }

    echo json_encode($itineraries);
} else {
    echo json_encode(["error" => "No employee_id provided"]);
}

$mysqli->close();
?>
