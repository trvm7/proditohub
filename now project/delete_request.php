<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: admi.php");
    exit;
}

include("link.php");

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $query = "DELETE FROM recost WHERE id = ?";
    $stmt = mysqli_prepare($coon, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    
    if (mysqli_stmt_affected_rows($stmt) > 0) {
        echo json_encode(['success' => true]);
    } else {
        //trvm7
        echo json_encode(['success' => false, 'error' => mysqli_error($coon)]);
    }
    exit;
}
?>