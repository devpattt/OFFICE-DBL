<?php
session_start();
if (!isset($_SESSION['employee_id'])) {
    header("Location:index.php");
    exit();
}
?>
