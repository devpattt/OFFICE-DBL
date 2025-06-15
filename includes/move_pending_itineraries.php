<?php

include '../conn.php';
date_default_timezone_set('Asia/Manila');

$today = date('Y-m-d');
$tomorrow = date('Y-m-d', strtotime('+1 day'));

$check = $conn->query("SELECT itinerary_id, date, status, auto_moved FROM itinerary WHERE status = 'Pending' AND DATE(date) = CURDATE() AND auto_moved = 0");
echo "Rows to move: " . $check->num_rows . "\n";
while ($row = $check->fetch_assoc()) {
    print_r($row);
}

$sql = "UPDATE itinerary 
SET date = CURDATE() + INTERVAL 1 DAY, auto_moved = 1 
WHERE status = 'Pending' AND DATE(date) = CURDATE() AND auto_moved = 0;";

if ($conn->query($sql) === TRUE) {
    echo "Moved " . $conn->affected_rows . " pending itineraries.\n";
} else {
    echo "SQL Error: " . $conn->error;
}

$conn->close();
?>