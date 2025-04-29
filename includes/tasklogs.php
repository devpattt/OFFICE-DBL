<?php

include '../conn.php';

$selected_date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');
$selected_employee = isset($_GET['employee']) ? $_GET['employee'] : '';


$employeeQuery = "SELECT employee_id, full_name FROM dbl_employees_acc WHERE status = 'active'";
$employeeResult = $conn->query($employeeQuery);


$sql = "SELECT itinerary.id, dbl_employees_acc.full_name AS employee_name, itinerary.location, itinerary.time AS start_time, itinerary.description, itinerary.status, itinerary.updated_at 
        FROM itinerary 
        JOIN dbl_employees_acc ON itinerary.employee_id = dbl_employees_acc.employee_id
        WHERE itinerary.date = '$selected_date'";

if (!empty($selected_employee)) {
    $sql .= " AND itinerary.employee_id = '$selected_employee'";
}

$sql .= " ORDER BY itinerary.time ASC";

$result = $conn->query($sql);
?>


