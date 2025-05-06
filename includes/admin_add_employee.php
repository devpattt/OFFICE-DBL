<?php
session_start();
include '../conn.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['full_name'], $_POST['username'], $_POST['email'], $_POST['password'], $_POST['department'])) {
        $full_name = trim($_POST['full_name']);
        $username = trim($_POST['username']);
        $email = trim($_POST['email']);
        $password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);
        $department = trim($_POST['department']);
        $role = $department; // still storing department in 'role' field as before
        $status = 'active';

        // Determine prefix: ADM for Admins, EMP for others
        $prefix = (strtolower($department) === 'admin') ? 'ADM' : 'EMP';

        // Get the latest ID with the same prefix
        $stmt = $conn->prepare("SELECT employee_id FROM dbl_employees_acc WHERE employee_id LIKE ? ORDER BY id DESC LIMIT 1");
        $likePrefix = $prefix . '%';
        $stmt->bind_param("s", $likePrefix);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            // Extract numeric part and increment
            $lastNum = (int)substr($row['employee_id'], 3);
            $newNum = $lastNum + 1;
        } else {
            $newNum = 1;
        }

        // Format new ID like EMP001 or ADM001
        $employee_id = $prefix . str_pad($newNum, 3, '0', STR_PAD_LEFT);

        $stmt->close();

        // Now insert the new employee
        $stmt = $conn->prepare("INSERT INTO dbl_employees_acc 
            (username, email, password, full_name, department, role, status, employee_id) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssss", $username, $email, $password, $full_name, $department, $role, $status, $employee_id);

        if ($stmt->execute()) {
            header("Location: ../admin/employees.php?success=EmployeeAdded");
            exit();
        } else {
            header("Location: ../admin/employees.php?error=InsertFailed");
            exit();
        }

        $stmt->close();
    } else {
        header("Location: ../admin/employees.php?error=MissingFields");
        exit();
    }
}
?>
