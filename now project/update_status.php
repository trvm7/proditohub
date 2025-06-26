<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: admi.php");
    exit;
}

include("link.php");

if (isset($_POST['id'], $_POST['status'])) {
    $id = (int)$_POST['id'];
    $status = mysqli_real_escape_string($coon, $_POST['status']);

    $allowed = ['مرفوض', 'قيد المراجعة', 'جاري العمل عليه', 'مكتمل'];
    if (!in_array($status, $allowed)) {
        die('حالة غير صالحة');//dito ig trvm7
    }

    $sql = "UPDATE recost SET status='$status' WHERE id=$id";
    if (mysqli_query($coon, $sql)) {
        header("Location: mine.php?updated=1");
        exit;
    } else {//Dito ig trvm7
        echo "خطأ في التحديث: " . mysqli_error($coon);
    }
} else {
    header("Location: mine.php");
    exit;
}
