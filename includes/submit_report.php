<?php
include '../conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $client_name = $conn->real_escape_string($_POST['client_name']);
  $issue_type = $conn->real_escape_string($_POST['issue_type']);
  $issue_description = $conn->real_escape_string($_POST['issue_description']);
  $priority = $conn->real_escape_string($_POST['priority']);
  $date_observed = $conn->real_escape_string($_POST['date_observed']);

  
  $uploadDir = 'uploads/';
  if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

  $uploadedFiles = [];
  if (!empty($_FILES['attachments']['name'][0])) {
    foreach ($_FILES['attachments']['tmp_name'] as $index => $tmpName) {
      $fileName = basename($_FILES['attachments']['name'][$index]);
      $targetPath = $uploadDir . time() . '-' . $fileName;
      if (move_uploaded_file($tmpName, $targetPath)) {
        $uploadedFiles[] = $targetPath;
      }
    }
  }

  $attachments = implode(',', $uploadedFiles);

  $stmt = $conn->prepare("INSERT INTO reports (client_name, issue_type, issue_description, priority, date_observed, attachments) VALUES (?, ?, ?, ?, ?, ?)");
  $stmt->bind_param("ssssss", $client_name, $issue_type, $issue_description, $priority, $date_observed, $attachments);

  if ($stmt->execute()) {
    echo "<h2>Report submitted successfully!</h2><p><a href='report.html'>Submit another</a></p>";
  } else {
    echo "Error: " . $stmt->error;
  }

  $stmt->close();
} else {
  echo "Invalid request.";
}

$conn->close();
?>
