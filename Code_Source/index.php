<?php
session_start();
if (isset($_SESSION['student_id'])) {
    header('Location: pages/dashboard.php');
} else {
    header('Location: pages/login.php');
}
exit();
?>