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
    $response = [
        "status" => "error",
        "message" => "Database connection failed: " . $conn->connect_error
    ];
    echo json_encode($response);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $json_data = file_get_contents('php://input');
    $data = json_decode($json_data, true);
    
    if (!isset($data['location']) || !isset($data['latitude']) || !isset($data['longitude'])) {
        echo "Error: Missing required data";
        exit;
    }

    if (!isset($_SESSION['employee_id']) || !isset($_SESSION['username'])) {
        echo "Error: User not logged in";
        exit;
    }

    $employee_id = $_SESSION['employee_id'];
    $username = $_SESSION['username']; 
    $location = $conn->real_escape_string($data['location']);
    $latitude = floatval($data['latitude']);
    $longitude = floatval($data['longitude']);
    $current_date = date('Y-m-d'); 
    $current_time = date('H:i:s');

    // Check if user is already clocked in today
    $sql = "SELECT * FROM dbl_attendance_logs 
            WHERE employee_id = ? AND date = ? AND time_out IS NULL 
            ORDER BY id DESC LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $employee_id, $current_date);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Clock-out
        $row = $result->fetch_assoc();
        $attendance_id = $row['id'];

        $sql = "UPDATE dbl_attendance_logs 
                SET time_out = ?, location_out = ?, lat_out = ?, lng_out = ? 
                WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssddi", $current_time, $location, $latitude, $longitude, $attendance_id);

        if ($stmt->execute()) {
            $_SESSION['clocked_in'] = false;
            echo "Successfully clocked out at " . date('h:i A') . " from " . $location;
        } else {
            echo "Error: " . $stmt->error;
        }

    } else {
        // Clock-in
        $sql = "INSERT INTO dbl_attendance_logs 
                (employee_id, username, date, time_in, location_in, lat_in, lng_in) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssdd", $employee_id, $username, $current_date, $current_time, $location, $latitude, $longitude);

        if ($stmt->execute()) {
            $_SESSION['clocked_in'] = true;
            echo "Successfully clocked in at " . date('h:i A') . " at " . $location;
        } else {
            echo "Error: " . $stmt->error;
        }
    }

    $stmt->close();
    $conn->close();
    exit;
}

http_response_code(405);
echo "Error: Invalid request method";
