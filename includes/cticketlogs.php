<?php

include '../conn.php';

// Get filter values
$selected_date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');
$selected_submitter = isset($_GET['submitted_by']) ? $_GET['submitted_by'] : '';

// Get unique submitters for dropdown
$submitterQuery = "SELECT DISTINCT submitted_by FROM dbl_client_tickets";
$submitterResult = $conn->query($submitterQuery);

// Build main query
$sql = "SELECT id, subject, description, submitted_by, remarks, attachment, status, submitted_at
        FROM dbl_client_tickets
        WHERE DATE(submitted_at) = ?";

$params = [$selected_date];
$types = "s";

if (!empty($selected_submitter)) {
    $sql .= " AND submitted_by = ?";
    $params[] = $selected_submitter;
    $types .= "s";
}

$sql .= " ORDER BY submitted_at DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();
?>