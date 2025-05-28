<?php
include '../conn.php';

header('Content-Type: application/json');

$subject = trim($_POST['subject'] ?? '');
$description = trim($_POST['description'] ?? '');
$submitted_by = trim($_POST['submitted_by'] ?? '');
$remarks = trim($_POST['remarks'] ?? '');

$attachment = null;
if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = '../uploads/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    $filename = uniqid() . '_' . basename($_FILES['attachment']['name']);
    $targetFile = $uploadDir . $filename;
    if (move_uploaded_file($_FILES['attachment']['tmp_name'], $targetFile)) {
        $attachment = $filename;
    }
}

$stmt = $conn->prepare("INSERT INTO dbl_client_tickets (subject, description, submitted_by, remarks, attachment) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $subject, $description, $submitted_by, $remarks, $attachment);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Ticket submitted successfully!']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to submit ticket.']);
}

$stmt->close();
$conn->close();
?>