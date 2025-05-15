<?php
include '../conn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $employee_id = $_POST['employee_id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $full_name = $_POST['full_name'];
    $role = $_POST['role'];
    $status = 'active'; 

    $sql = "INSERT INTO dbl_employees_acc (employee_id, username, email, full_name, role, status, created_at)
            VALUES ('$employee_id', '$username', '$email', '$full_name', '$role', '$status', NOW())";

    if ($conn->query($sql) === TRUE) {
        header("Location: employees.php");
        exit();
    } else {
        echo "Error adding employee: " . $conn->error;
    }
}
?>

<h1>Add Employee</h1>
<form method="POST" action="">
  Employee ID: <input type="text" name="employee_id" required><br>
  Username: <input type="text" name="username" required><br>
  Email: <input type="email" name="email" required><br>
  Full Name: <input type="text" name="full_name" required><br>
  Role: <input type="text" name="role" required><br>
  <button type="submit">Add Employee</button>
</form>
