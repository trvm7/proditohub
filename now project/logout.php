<?php
session_start();
session_unset();
session_destroy();
header("Location: admi.php"); // ترجع المستخدم لصفحة تسجيل الدخول
exit;
?>