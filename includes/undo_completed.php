<?php
include '../conn.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $sql = "UPDATE itinerary SET status = 'Pending' WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        header('Location: ../employee/iterinary.php?message=Undo successful');
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
} else {
    echo "Invalid Request.";
}
?>
