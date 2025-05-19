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

    // Check if already clocked in
    $stmt = $conn->prepare("SELECT * FROM dbl_attendance_logs 
                            WHERE employee_id = ? AND date = ? AND time_out IS NULL 
                            ORDER BY id DESC LIMIT 1");
    $stmt->bind_param("ss", $employee_id, $current_date);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Clock-out
        $row = $result->fetch_assoc();
        $attendance_id = $row['id'];

        // Calculate hours worked
        $time_in_raw = new DateTime($row['time_in_raw']);
        $time_out_raw = new DateTime($current_time_raw);
        $hours_worked = round(($time_out_raw->getTimestamp() - $time_in_raw->getTimestamp()) / 3600, 2);

        $status = ($hours_worked < 8) ? 'Under Hours' : (($hours_worked == 8) ? 'Complete Hours' : 'Overtime');

        $stmt = $conn->prepare("UPDATE dbl_attendance_logs 
            SET time_out = ?, time_out_raw = ?, location_out = ?, lat_out = ?, lng_out = ?, 
                hours_worked = ?, status = ? 
            WHERE id = ?");
        $stmt->bind_param("sssddsdi", 
            $current_time_display, $current_time_raw, $location, $latitude, $longitude, 
            $hours_worked, $status, $attendance_id);

        if ($stmt->execute()) {
            echo json_encode([
                "status" => "success",
                "message" => "Clocked out at $current_time_display from $location",
                "hours_worked" => $hours_worked,
                "status_detail" => $status
            ]);
        } else {
            echo json_encode(["status" => "error", "message" => $stmt->error]);
        }

    } else {
        // Clock-in
        $stmt = $conn->prepare("INSERT INTO dbl_attendance_logs 
            (employee_id, username, date, time_in, time_in_raw, location_in, lat_in, lng_in) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssdd", 
            $employee_id, $username, $current_date, 
            $current_time_display, $current_time_raw, 
            $location, $latitude, $longitude);

        if ($stmt->execute()) {
            echo json_encode([
                "status" => "success",
                "message" => "Clocked in at $current_time_display at $location"
            ]);
        } else {
            echo json_encode(["status" => "error", "message" => $stmt->error]);
        }
    }

    $stmt->close();
    $conn->close();
    exit;
}

http_response_code(405);
echo json_encode(["status" => "error", "message" => "Invalid request method"]);
?>
