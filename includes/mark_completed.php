<?php
session_start();
$conn = new mysqli("localhost", "root", "", "dbl");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['employee_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $stmt = $conn->prepare("UPDATE itinerary SET status = 'Completed', updated_at = NOW() WHERE id = ? AND employee_id = ?");
    $stmt->bind_param("is", $id, $_SESSION['employee_id']);
    
    if ($stmt->execute()) {
        header("Location: ../employee/iterinary.php?success=MarkedCompleted");
        exit();
    } else {
        header("Location: ../employee/iterinary.php?error=FailedUpdate");
        exit();
    }
}

$conn->close();
?>
