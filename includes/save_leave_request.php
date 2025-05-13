<?php
include '../conn.php';

$department_id = $_POST['department_id'];
$employee_id = $_POST['employee_id'];
$leave_type = $_POST['leave_type'];
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];
$reason = $_POST['reason'];

$sql = "INSERT INTO dbl_leave_requests (department_id, employee_id, leave_type, start_date, end_date, reason, status) 
        VALUES ('$department_id', '$employee_id', '$leave_type', '$start_date', '$end_date', '$reason', 'Pending')";

if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Leave request submitted successfully!'); window.location.href='../includes/leavemanagement.php';</script>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
