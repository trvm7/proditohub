<!DOCTYPE html>
<html lang="ar" dir="rtl">
    <?php
// بداية الجلسة يجب أن تكون أول شيء في الصفحة
session_start();
ob_start();

// تأكد من عدم وجود أي إخراج قبل هذا السطر
include("link.php");

// معالجة تسجيل الدخول
if (isset($_POST["in"])) {
    // تنظيف المدخلات
    $user = trim($_POST["user"]);
    $pass = trim($_POST["pass"]);

    // التحقق من الاتصال بقاعدة البيانات
    if (!$coon || !mysqli_ping($coon)) {
        $_SESSION['login_error'] = "❌ فشل الاتصال بقاعدة البيانات";
    } else {
        // استعلام أكثر أماناً مع تجهيز العبارات
        $stmt = mysqli_prepare($coon, "SELECT * FROM users WHERE user = ? LIMIT 1");
        mysqli_stmt_bind_param($stmt, "s", $user);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($result)) {
            // التحقق من كلمة المرور (يفضل استخدام password_verify إذا كانت مشفرة)
            if ($pass === $row['pass']) { // هذا مثال، يجب استخدام password_verify في التطبيقات الحقيقية
                $_SESSION["user"] = $row["user"];
                $_SESSION["authenticated"] = true;
                
                // إعادة التوجيه بعد تسجيل الدخول بنجاح
                header("Location: mine.php");
                ob_end_flush();
                exit();
            } else {
                $_SESSION['login_error'] = "❌ كلمة المرور غير صحيحة";
            }
        } else {
            $_SESSION['login_error'] = "❌ اسم المستخدم غير موجود";
        }
    }
}
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>نظام تسجيل الدخول</title>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="admi.css">
    
</head>
<body>
    <!-- جسيمات الخلفية -->
    <div class="particles" id="particles-js"></div>
    
    <!-- بطاقة تسجيل الدخول -->
    <div class="card">
        <h2>تسجيل الدخول</h2>
        <p>يرجى إدخال بياناتك لتسجيل الدخول إلى لوحة التحكم</p>
        
        <form method="POST" action="">
            <div class="form-group">
                <input type="text" name="user" placeholder="اسم المستخدم" required>
            </div>
            <div class="form-group">
                <input type="password" name="pass" placeholder="كلمة المرور" required>
            </div>
            
            <button type="submit" name="in" class="btn-login">تسجيل الدخول</button>
        </form>
    </div>
    
    <script>
        // إنشاء جسيمات الخلفية
        document.addEventListener('DOMContentLoaded', function() {
            const particlesContainer = document.getElementById('particles-js');
            const particleCount = 50;
            
            for (let i = 0; i < particleCount; i++) {
                const particle = document.createElement('div');
                particle.classList.add('particle');
                
                // أحجام عشوائية بين 2px و 8px
                const size = Math.random() * 6 + 2;
                particle.style.width = `${size}px`;
                particle.style.height = `${size}px`;
                
                // مواقع عشوائية
                particle.style.left = `${Math.random() * 100}%`;
                particle.style.top = `${Math.random() * 100}%`;
                
                // شفافية عشوائية
                particle.style.opacity = Math.random() * 0.5 + 0.1;
                
                // مدة وتأخير عشوائي للحركة
                const duration = Math.random() * 20 + 10;
                const delay = Math.random() * 10;
                particle.style.animation = `float ${duration}s ${delay}s infinite linear`;
                
                particlesContainer.appendChild(particle);
            }
            
            // تأثير عند التركيز على حقول الإدخال
            const inputs = document.querySelectorAll('input');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.style.transform = 'scale(1.02)';
                });
                
                input.addEventListener('blur', function() {
                    this.parentElement.style.transform = 'scale(1)';
                });
            });
        });
    </script>
</body>
</html>
