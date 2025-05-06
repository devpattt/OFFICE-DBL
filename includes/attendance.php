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
            
            // Convert formatted time to UNIX timestamps
            $timeInRaw = DateTime::createFromFormat('l - n/j/Y - h:i A', $row['time_in']);
            $timeOutRaw = DateTime::createFromFormat('l - n/j/Y - h:i A', $timeOut);

            if ($timeInRaw && $timeOutRaw) {
                $hoursWorked = round(($timeOutRaw->getTimestamp() - $timeInRaw->getTimestamp()) / 3600, 2);

                // Determine status based on total hours
                if ($hoursWorked < 8) {
                    $status = 'Under Hours';
                } elseif ($hoursWorked == 8) {
                    $status = 'Complete Hours';
                } else {
                    $status = 'Overtime';
                }

                // Update attendance log with clock-out and new status
                $update = $conn->prepare("UPDATE dbl_attendance_logs SET time_out = ?, location_out = ?, lat_out = ?, lng_out = ?, status = ?, hours_worked = ? WHERE id = ?");
                $update->bind_param("ssddsdi", $timeOut, $location, $latitude, $longitude, $status, $hoursWorked, $row['id']);

                if ($update->execute()) {
                    echo "Clocked Out successfully! Hours Worked: $hoursWorked hrs - $status";
                } else {
                    echo "Error: " . $update->error;
                }
            } else {
                echo "Invalid time format.";
            }

        } else {
            echo "You have already clocked out today.";
        }
    } else {
        $timeIn = date('l - n/j/Y - h:i A'); 

        // Insert clock-in
        $insert = $conn->prepare("INSERT INTO dbl_attendance_logs (employee_id, username, date, time_in, location_in, lat_in, lng_in) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $insert->bind_param("ssssddd", $employeeid, $username, $date, $timeIn, $location, $latitude, $longitude);

        if ($insert->execute()) {
            echo "Clocked In successfully!";
        } else {
            echo "Error: " . $insert->error;
        }
    }
}
?>
