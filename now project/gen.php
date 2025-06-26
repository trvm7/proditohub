<?php

//index.php
include("link.php"); // تأكد أن الاتصال مضبوط

if (isset($_POST["okay"])) {
    $user = $_POST["user"];
    $email = $_POST["emil"];
    $phone = $_POST["phon"];
    $service = $_POST["select"];
    $details = $_POST["details"];

    // التأكد من الاتصال
    if (!$coon) {
        echo "❌ فشل الاتصال بقاعدة البيانات: " . mysqli_connect_error();
        exit;
    }

    // استعلام الإدخال
    $query = "INSERT INTO recost (name, phon, emil, service_type, details) VALUES ('$user', '$phone', '$email', '$service', '$details')";

    if (mysqli_query($coon, $query)) {
        echo "✅ تم استلام طلبك! شكراً لتواصلك معنا.";
        $good = "تم استلام طلبك بنجاح";
        // يمكنك هنا إضافة أي إجراءات إضافية مثل إرسال بريد إلكتروني أو إشعار
       header("Location: index.php?message=" . urlencode($good));
        exit;
    } else {
        $error = "حدث خطأ أثناء معالجة طلبك. يرجى المحاولة مرة أخرى.";
        header("Location: index.php?error=" . urlencode($error));
        echo "❌ خطأ في قاعدة البيانات: " . mysqli_error($coon);
    }
}
?>


<?php
//amdi.php
include("link.php"); // تأكد أن الاتصال مضبوط

if (isset($_POST["in"])) {
    $user = $_POST["user"];
    $pass = $_POST["pass"];
    


    // التأكد من الاتصال
    if (!$coon) {
        echo "❌ فشل الاتصال بقاعدة البيانات: " . mysqli_connect_error();
        exit;
    }

    // استعلام الإدخال
   $sql = "SELECT * FROM users WHERE user='$user' AND pass='$pass'";
    $result = mysqli_query($coon, $sql);

    if (mysqli_num_rows($result) > 0) {
        // تسجيل الدخول ناجح
        header("Location: mine.php");
        exit;
    } else {
        // تسجيل الدخول فشل
        echo "❌ اسم المستخدم أو كلمة المرور غير صحيحة";
        header("Location: admi.php?error=" . urlencode(" اسم المستخدم أو كلمة المرور غير صحيحة"));
    }
}
?>


