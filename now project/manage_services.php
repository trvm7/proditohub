<?php
session_start();
include("link.php");

if (!isset($_SESSION["user"])) {
    header("Location: admi.php");
    exit;
}

// إضافة نوع خدمة
if (isset($_POST['add_service'])) {
    $newService = trim($_POST['new_service']);
    if (!empty($newService)) {
        $stmt = mysqli_prepare($coon, "INSERT INTO service_types (name) VALUES (?)");
        mysqli_stmt_bind_param($stmt, "s", $newService);
        mysqli_stmt_execute($stmt);
        $message = "✅ تم إضافة الخدمة بنجاح";
    } else {
        $error = "❌ يرجى إدخال اسم صالح";
    }
}

// حذف نوع خدمة
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    mysqli_query($coon, "DELETE FROM service_types WHERE id = $id");
    header("Location: manage_services.php");
    exit;
}

$services = mysqli_query($coon, "SELECT * FROM service_types ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>إدارة أنواع الخدمات</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap');
        
        :root {
            --primary-color: #3b0d0c;
            --primary-hover: #5e1e1c;
            --secondary-color: #f8f1e5;
            --accent-color: #e6b422;
            --text-color: #333;
            --light-text: #f9f9f9;
            --success-bg: #d4edda;
            --success-text: #155724;
            --error-bg: #f8d7da;
            --error-text: #721c24;
            --transition: all 0.3s ease;
            --border-radius: 12px;
            --box-shadow: 0 8px 20px rgba(0,0,0,0.1);
            --card-bg: rgba(255, 255, 255, 0.9);
        }
        
        .dark-mode {
            --primary-color: #5e1e1c;
            --primary-hover: #7a2b28;
            --secondary-color: #121212;
            --accent-color: #e6b422;
            --text-color: #f0f0f0;
            --light-text: #f9f9f9;
            --success-bg: #1e3b24;
            --success-text: #a3d9b1;
            --error-bg: #3b1e24;
            --error-text: #f5a3b1;
            --box-shadow: 0 8px 20px rgba(0,0,0,0.3);
            --card-bg: rgba(30, 30, 30, 0.9);
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Cairo', sans-serif;
            background: var(--secondary-color);
            color: var(--text-color);
            margin: 0;
            padding: 0;
            transition: var(--transition);
            line-height: 1.6;
            min-height: 100vh;
            -webkit-text-size-adjust: 100%;
        }

        header {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-hover));
            color: white;
            padding: 20px 15px;
            text-align: center;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            position: relative;
        }

        header h1 {
            margin: 0;
            font-size: 22px;
            font-weight: 700;
            text-shadow: 0 2px 4px rgba(0,0,0,0.2);
            padding: 0 40px;
        }

        .form-container {
            max-width: 100%;
            width: 95%;
            background: var(--card-bg);
            margin: 20px auto;
            padding: 20px;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: var(--transition);
            animation: fadeIn 0.8s ease;
        }

        .form-container h2 {
            margin-bottom: 20px;
            color: var(--primary-color);
            text-align: center;
            font-size: 20px;
            position: relative;
            padding-bottom: 10px;
        }
        
        .form-container h2::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 3px;
            background: var(--accent-color);
            border-radius: 3px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        input[type="text"] {
            width: 100%;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: var(--border-radius);
            font-size: 16px;
            transition: var(--transition);
            background: rgba(255,255,255,0.8);
        }
        
        input[type="text"]:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(59, 13, 12, 0.2);
        }
        
        .dark-mode input[type="text"] {
            background: rgba(0,0,0,0.3);
            border-color: #444;
            color: var(--light-text);
        }
        
        .dark-mode input[type="text"]:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 3px rgba(230, 180, 34, 0.3);
        }

        .btn {
            display: inline-block;
            padding: 12px;
            border-radius: var(--border-radius);
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            text-align: center;
            text-decoration: none;
            border: none;
            width: 100%;
        }

        .btn-primary {
            background: var(--primary-color);
            color: white;
            letter-spacing: 1px;
        }
        
        .btn-primary:hover {
            background: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        
        .btn-primary:active {
            transform: translateY(0);
        }

        .btn-back {
            display: inline-block;
            margin-top: 15px;
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
            transition: var(--transition);
            padding: 10px 15px;
            border-radius: 6px;
            background: rgba(0,0,0,0.05);
            text-align: center;
            width: auto;
        }
        
        .btn-back:hover {
            background: rgba(0,0,0,0.1);
            text-decoration: none;
        }
        
        .dark-mode .btn-back {
            color: var(--accent-color);
            background: rgba(255,255,255,0.1);
        }
        
        .dark-mode .btn-back:hover {
            background: rgba(255,255,255,0.2);
        }

        .alert {
            padding: 12px;
            border-radius: var(--border-radius);
            text-align: center;
            margin-bottom: 15px;
            font-weight: bold;
            transition: var(--transition);
            animation: fadeIn 0.5s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-size: 14px;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .alert-success {
            background-color: var(--success-bg);
            color: var(--success-text);
            border-left: 5px solid var(--success-text);
        }

        .alert-error {
            background-color: var(--error-bg);
            color: var(--error-text);
            border-left: 5px solid var(--error-text);
        }

        .table-responsive {
            width: 95%;
            margin: 20px auto;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            background: var(--card-bg);
            box-shadow: var(--box-shadow);
            border-radius: var(--border-radius);
            overflow: hidden;
            animation: slideUp 0.6s ease;
            min-width: 300px;
        }
        
        @keyframes slideUp {
            from { 
                opacity: 0;
                transform: translateY(20px);
            }
            to { 
                opacity: 1;
                transform: translateY(0);
            }
        }

        th, td {
            padding: 12px 8px;
            text-align: center;
            border-bottom: 1px solid rgba(0,0,0,0.1);
            font-size: 14px;
        }
        
        .dark-mode th, 
        .dark-mode td {
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        th {
            background-color: var(--primary-color);
            color: white;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            position: sticky;
            top: 0;
            white-space: nowrap;
        }

        tr:nth-child(even) {
            background-color: rgba(0,0,0,0.03);
        }
        
        .dark-mode tr:nth-child(even) {
            background-color: rgba(255,255,255,0.05);
        }
        
        tr:hover {
            background-color: rgba(0,0,0,0.05);
        }
        
        .dark-mode tr:hover {
            background-color: rgba(255,255,255,0.1);
        }

        .btn-action {
            padding: 6px 12px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 13px;
            white-space: nowrap;
        }

        .btn-danger {
            color: white;
            background-color: #dc3545;
        }
        
        .btn-danger:hover {
            background-color: #c82333;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
        
        .btn-danger:active {
            transform: translateY(0);
        }

        .toggle-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            margin: 0;
            padding: 8px 12px;
            background: rgba(255,255,255,0.2);
            color: white;
            border: none;
            border-radius: 30px;
            cursor: pointer;
            font-weight: 600;
            transition: var(--transition);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 12px;
            width: auto;
        }
        
        .toggle-btn:hover {
            background: rgba(255,255,255,0.3);
            transform: translateY(-50%) scale(1.05);
        }
        
        .toggle-btn:active {
            transform: translateY(-50%) scale(1);
        }

        .empty-state {
            text-align: center;
            padding: 30px 15px;
            color: #666;
            font-size: 14px;
        }
        
        .dark-mode .empty-state {
            color: #aaa;
        }

        /* تحسينات للشاشات الصغيرة جدًا */
        @media (max-width: 480px) {
            header {
                padding: 15px 10px;
            }
            
            header h1 {
                font-size: 18px;
                padding: 0 30px;
            }
            
            .form-container {
                padding: 15px;
            }
            
            .form-container h2 {
                font-size: 18px;
                margin-bottom: 15px;
            }
            
            input[type="text"] {
                padding: 10px;
                font-size: 15px;
            }
            
            .btn {
                padding: 10px;
                font-size: 15px;
            }
            
            .btn-action {
                padding: 5px 8px;
                font-size: 12px;
            }
            
            th, td {
                padding: 8px 5px;
                font-size: 13px;
            }
            
            .toggle-btn {
                padding: 6px 10px;
                font-size: 11px;
            }
        }

        /* منع التكبير على iOS */
        @supports (-webkit-touch-callout: none) {
            input, textarea, select {
                font-size: 16px !important;
            }
        }
    </style>
</head>
<body>

<header>
    <button onclick="toggleDarkMode()" class="toggle-btn">
        <i class="fas fa-moon"></i> <span class="toggle-text">تبديل الوضع</span>
    </button>
    <h1>إدارة أنواع الخدمات</h1>
</header>

<div class="form-container">
    <h2>إضافة نوع خدمة جديد</h2>
    
    <?php if (isset($message)): ?>
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> <?= $message ?>
        </div>
    <?php endif; ?>
    
    <?php if (isset($error)): ?>
        <div class="alert alert-error">
            <i class="fas fa-exclamation-circle"></i> <?= $error ?>
        </div>
    <?php endif; ?>
    
    <form method="post">
        <div class="form-group">
            <input type="text" name="new_service" placeholder="ادخل نوع الخدمة" required>
        </div>
        <button type="submit" name="add_service" class="btn btn-primary">
            <i class="fas fa-plus"></i> إضافة الخدمة
        </button>
        <div style="text-align: center;">
            <a href="mine.php" class="btn-back">
                <i class="fas fa-arrow-right"></i> العودة إلى لوحة التحكم
            </a>
        </div>
    </form>
</div>

<div class="table-responsive">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>اسم الخدمة</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            <?php if (mysqli_num_rows($services) > 0): ?>
                <?php while($row = mysqli_fetch_assoc($services)): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td>
                        <a class="btn-action btn-danger" href="?delete=<?= $row['id'] ?>" onclick="return confirm('هل أنت متأكد من حذف هذه الخدمة؟');">
                            <i class="fas fa-trash"></i> <span class="action-text">حذف</span>
                        </a>
                    </td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3" class="empty-state">
                        <i class="fas fa-info-circle"></i> لا توجد خدمات مسجلة حالياً
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<script>
    function toggleDarkMode() {
        document.body.classList.toggle('dark-mode');
        const icon = document.querySelector('.toggle-btn i');
        const toggleText = document.querySelector('.toggle-text');
        if (document.body.classList.contains('dark-mode')) {
            icon.classList.replace('fa-moon', 'fa-sun');
            toggleText.textContent = 'وضع فاتح';
        } else {
            icon.classList.replace('fa-sun', 'fa-moon');
            toggleText.textContent = 'تبديل الوضع';
        }
        localStorage.setItem('dark-mode', document.body.classList.contains('dark-mode'));
    }

    // إخفاء النص في الأزرار على الشاشات الصغيرة
    function handleResponsive() {
        const actionTexts = document.querySelectorAll('.action-text');
        const toggleText = document.querySelector('.toggle-text');
        
        if (window.innerWidth < 400) {
            actionTexts.forEach(el => el.style.display = 'none');
            toggleText.textContent = '';
        } else {
            actionTexts.forEach(el => el.style.display = 'inline');
            if (document.body.classList.contains('dark-mode')) {
                toggleText.textContent = 'وضع فاتح';
            } else {
                toggleText.textContent = 'تبديل الوضع';
            }
        }
    }

    window.onload = function () {
        if (localStorage.getItem('dark-mode') === 'true') {
            document.body.classList.add('dark-mode');
            const icon = document.querySelector('.toggle-btn i');
            icon.classList.replace('fa-moon', 'fa-sun');
            document.querySelector('.toggle-text').textContent = 'وضع فاتح';
        }
        
        handleResponsive();
        window.addEventListener('resize', handleResponsive);
    }
</script>

</body>
</html>