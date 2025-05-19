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

        if ($row['time_out_raw'] === NULL) {
            // Clocking out
            $timeOutDisplay = date('l - h:i A');         
            $timeOutRaw = date('Y-m-d H:i:s');             

            $timeInRaw = new DateTime($row['time_in_raw']);
            $timeOutObj = new DateTime($timeOutRaw);

            $hoursWorked = round(($timeOutObj->getTimestamp() - $timeInRaw->getTimestamp()) / 3600, 2);

            if ($hoursWorked < 8) {
                $status = 'Under Hours';
            } elseif ($hoursWorked == 8) {
                $status = 'Complete Hours';
            } else {
                $status = 'Overtime';
            }

            $update = $conn->prepare("UPDATE dbl_attendance_logs 
                SET time_out = ?, time_out_raw = ?, location_out = ?, lat_out = ?, lng_out = ?, status = ?, hours_worked = ? 
                WHERE id = ?");

            $update->bind_param("sssdsdsi", $timeOutDisplay, $timeOutRaw, $location, $latitude, $longitude, $status, $hoursWorked, $row['id']);

            if ($update->execute()) {
                echo "Clocked Out successfully! Hours Worked: $hoursWorked hrs - $status";
            } else {
                echo "Error: " . $update->error;
            }

        } else {
            echo "You have already clocked out today.";
        }
    } else {
        // Clocking in
        $timeInDisplay = date('l - h:i A');             
        $timeInRaw = date('Y-m-d H:i:s');                

        $insert = $conn->prepare("INSERT INTO dbl_attendance_logs 
            (employee_id, username, date, time_in, time_in_raw, location_in, lat_in, lng_in) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

        $insert->bind_param("ssssssdd", $employeeid, $username, $date, $timeInDisplay, $timeInRaw, $location, $latitude, $longitude);

        if ($insert->execute()) {
            echo "Clocked In successfully!";
        } else {
            echo "Error: " . $insert->error;
        }
    }
}
?>
