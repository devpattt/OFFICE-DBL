<?php
include '../conn.php';

if (isset($_GET['department'])) {
    $department = $_GET['department'];
    
    // Fetch employees based on the selected department
    $query = "SELECT id, full_name FROM dbl_employees_acc WHERE department = '$department'";
    $result = $conn->query($query);
    
    $employees = [];
    while ($row = $result->fetch_assoc()) {
        $employees[] = $row;
    }

    echo json_encode($employees);
}
?>
