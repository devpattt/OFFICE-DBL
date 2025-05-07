<?php
require '../conn.php';
date_default_timezone_set('Asia/Manila');
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $now = date('Y-m-d H:i:s');

    $stmt = $conn->prepare("UPDATE itinerary SET arrival_time = ? WHERE id = ?");
    $stmt->bind_param("si", $now, $id);

    if ($stmt->execute()) {
        header("Location: ../employee/iterinary.php?success=arrival");
    } else {
        header("Location: ../employee/iterinary.php?error=arrival");
    }
}
?>
