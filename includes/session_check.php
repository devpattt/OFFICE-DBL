<?php
session_start();
if (!isset($_SESSION['employee_id'])) {
    http_response_code(401);
    echo json_encode(["status" => "expired"]);
    exit();
} else {
    $_SESSION['last_active'] = time();
    echo json_encode(["status" => "active"]);
}
?>
