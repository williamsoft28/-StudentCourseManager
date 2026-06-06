<?php
// ici nous essayons de verifier si la session est dejà demarree
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

//ici nous essayons de verifier si l'utilisateur est connecté en tant qu'étudiant
if (!isset($_SESSION['student_id'])) {
    header('Location: ../pages/login.php');
    exit();
}
?>