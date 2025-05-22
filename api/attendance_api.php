<?php 

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");

session_start();
date_default_timezone_set('Asia/Manila');

$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "dbl";

$response = [];

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    echo json_encode([
        "status" => "error",
        "message" => "Database connection failed: " . $conn->connect_error
    ]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (!isset($data['location']) || !isset($data['latitude']) || !isset($data['longitude'])) {
        echo json_encode(["status" => "error", "message" => "Missing required data"]);
        exit;
    }

    if (!isset($_SESSION['employee_id']) || !isset($_SESSION['username'])) {
        echo json_encode(["status" => "error", "message" => "User not logged in"]);
        exit;
    }

    $employee_id = $_SESSION['employee_id'];
    $username = $_SESSION['username']; 
    $location = $conn->real_escape_string($data['location']);
    $latitude = floatval($data['latitude']);
    $longitude = floatval($data['longitude']);
    
    $current_date = date('Y-m-d');
    $current_time_display = date('l - h:i A');     
    $current_time_raw = date('Y-m-d H:i:s');    

    $today_5am = date('Y-m-d 05:00:00');
    $now = strtotime($current_time_raw);

    if ($now < strtotime($today_5am)) {
        $attendance_date = date('Y-m-d', strtotime('-1 day'));
    } else {
        $attendance_date = $current_date;
    }

    // Get the latest attendance record for today
    $stmt = $conn->prepare("SELECT * FROM dbl_attendance_logs 
                            WHERE employee_id = ? AND date = ? 
                            ORDER BY id DESC LIMIT 1");
    $stmt->bind_param("ss", $employee_id, $attendance_date);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // If already clocked in and out, block further actions
        if (!empty($row['time_in']) && !empty($row['time_out'])) {
            echo json_encode([
                "status" => "error",
                "message" => "You have already clocked in and out for today. Please try again after 5am."
            ]);
            exit;
        }

        // If clocked in but not out, allow clock-out
        if (!empty($row['time_in']) && empty($row['time_out'])) {
            $attendance_id = $row['id'];
            $time_in_raw = new DateTime($row['time_in_raw']);
            $time_out_raw = new DateTime($current_time_raw);

            $hours_worked = ($time_out_raw->getTimestamp() - $time_in_raw->getTimestamp()) / 3600;

            if ($hours_worked < 7.99) {
                $status = 'Under Hours';
            } elseif ($hours_worked >= 7.99 && $hours_worked <= 8.01) {
                $status = 'Complete Hours';
            } else {
                $status = 'Overtime';
            }

            $hours_worked = round($hours_worked, 2); 

            $update_stmt = $conn->prepare("UPDATE dbl_attendance_logs 
                SET time_out = ?, time_out_raw = ?, location_out = ?, lat_out = ?, lng_out = ?, 
                    hours_worked = ?, status = ? 
                WHERE id = ?");

            if (!$update_stmt) {
                echo json_encode(["status" => "error", "message" => "Prepare failed: " . $conn->error]);
                exit;
            }

            $update_stmt->bind_param("sssddssi", 
                $current_time_display, $current_time_raw, $location, $latitude, $longitude, 
                $hours_worked, $status, $attendance_id);

            if ($update_stmt->execute()) {
                echo json_encode([
                    "status" => "success",
                    "message" => "Clocked out at $current_time_display from $location",
                    "hours_worked" => $hours_worked,
                    "status_detail" => $status
                ]);
            } else {
                echo json_encode(["status" => "error", "message" => $update_stmt->error]);
            }
            exit;
        }
        
        echo json_encode([
            "status" => "error",
            "message" => "You have already clocked in and out for today. Please try again after 5am."
        ]);
        exit;
    } 

    // If not clocked in yet, allow clock-in
    $stmt = $conn->prepare("INSERT INTO dbl_attendance_logs 
        (employee_id, username, date, time_in, time_in_raw, location_in, lat_in, lng_in) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssdd", 
        $employee_id, $username, $attendance_date, 
        $current_time_display, $current_time_raw, 
        $location, $latitude, $longitude);

    if ($stmt->execute()) {
        $locationDisplay = !empty($location) ? $location : "$latitude, $longitude";
        echo json_encode([
            "status" => "success",
            "message" => "Clocked in at $current_time_display at $locationDisplay"
        ]);
    } else {
        echo json_encode(["status" => "error", "message" => $stmt->error]);
    }

    $stmt->close();
    $conn->close();
    exit;
}

http_response_code(405);
echo json_encode(["status" => "error", "message" => "Invalid request method"]);
?>
