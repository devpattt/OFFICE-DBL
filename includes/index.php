<?php
session_start();
include __DIR__ . '/../conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, employee_id, username, password, role, status, department FROM dbl_employees_acc WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        // Check if the account is deactivated
        if ($row['status'] == 'inactive') {
            $error = "Your account has been deactivated. Please contact support.";
        } else {
            if (password_verify($password, $row['password'])) {
                $_SESSION['username'] = $row['username'];
                $_SESSION['role'] = $row['role'];
                $_SESSION['employee_id'] = $row['employee_id'];
                $_SESSION['department'] = $row['department'];  // Store department in session

                // RBAC based on role and department
                if ($row['role'] === 'Admin') {
                    header("Location: ../admin/home.php");
                } elseif (in_array($row['department'], ['System Integration', 'Information Technology', 'Sales', 'Intern'])) {
                    // If the department is one of the listed ones, treat as employee
                    header("Location: ../employee/home.php");
                } else {
                    // Default case, if role isn't admin, send them to employee page
                    header("Location: ../employee/home.php");
                }
                exit();
            } else {
                $error = "Invalid password.";
            }
        }
    } else {
        $error = "Username not found.";
    }

    $stmt->close();
}
?>

<?php if (isset($error)): ?>
    <p style="color: red;"><?php echo $error; ?></p>
<?php endif; ?>
