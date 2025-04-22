<?php
session_start();
include '../conn.php';

date_default_timezone_set('Asia/Manila');   

if (!isset($_SESSION['username'])) {
    echo json_encode(['error' => 'Session expired. Please log in again.']);
    exit();
}

$employeeid = $_SESSION['employee_id'];
$username = $_SESSION['username'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $location = $data['location'];
    $latitude = $data['latitude'];
    $longitude = $data['longitude'];
    $date = date('Y-m-d');

    $query = $conn->prepare("SELECT * FROM dbl_attendance_logs WHERE employee_id = ? AND date = ?");
    $query->bind_param("ss", $employeeid, $date);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($row['time_out'] === NULL) {
            $timeOut = date('l - n/j/Y - h:i A'); 
            $update = $conn->prepare("UPDATE dbl_attendance_logs SET time_out = ?, location_out = ?, lat_out = ?, lng_out = ? WHERE id = ?");
            $update->bind_param("ssddi", $timeOut, $location, $latitude, $longitude, $row['id']);
            if ($update->execute()) {
                echo "Clocked Out successfully!";
            } else {
                echo "Error: " . $update->error;
            }
        } else {
            echo "You have already clocked out today.";
        }
    } else {
        $timeIn = date('l - n/j/Y - h:i A'); 
        $currentTime = date('H:i');
        $defaultTime = '08:30';

        if ($currentTime > $defaultTime) {
            $status = 'Late';
        } else {
            $status = 'On Time';
        }

        $insert = $conn->prepare("INSERT INTO dbl_attendance_logs (employee_id, username, date, time_in, location_in, lat_in, lng_in, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $insert->bind_param("ssssddss", $employeeid, $username, $date, $timeIn, $location, $latitude, $longitude, $status);

        if ($insert->execute()) {
            echo "Clocked In successfully!";
        } else {
            echo "Error: " . $insert->error;
        }
    }
}

/**
 * Validate the time format.
 * 
 * @param string $time The time string to validate.
 * @return bool True if valid, false otherwise.
 */
function validateTime($time) {
    $format = 'Y-m-d H:i:s'; // Expected format
    $d = DateTime::createFromFormat($format, $time);
    return $d && $d->format($format) === $time;
}
?>