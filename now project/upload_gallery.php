<?php
session_start();
include("link.php");

// تحقق من الجلسة
if (!isset($_SESSION["user"])) {
    header("Location: admi.php");
    exit;
}

// التحقق من تفضيل الوضع المظلم
if (isset($_POST['toggle-dark-mode'])) {
    $_SESSION['dark_mode'] = !isset($_SESSION['dark_mode']) || !$_SESSION['dark_mode'];
}

$dark_mode = isset($_SESSION['dark_mode']) && $_SESSION['dark_mode'];

$message = "";

// حذف صورة
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    
    $stmt = mysqli_prepare($coon, "SELECT image_url FROM gallery WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $imgPath);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    if ($imgPath && file_exists($imgPath)) {
        unlink($imgPath);
    }

    $del = mysqli_prepare($coon, "DELETE FROM gallery WHERE id = ?");
    mysqli_stmt_bind_param($del, "i", $id);
    mysqli_stmt_execute($del);
    mysqli_stmt_close($del);

    $message = "✅ تم حذف الصورة بنجاح";
}

// رفع صورة جديدة
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
    if ($_FILES['image']['error'] === 0) {
        $allowed = ['jpg','jpeg','png','gif'];
        $fileName = $_FILES['image']['name'];
        $fileTmp = $_FILES['image']['tmp_name'];
        $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        if (in_array($ext, $allowed)) {
            $uploadDir = 'uploads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            $newFileName = uniqid() . '.' . $ext;
            $destination = $uploadDir . $newFileName;

            if (move_uploaded_file($fileTmp, $destination)) {
                $imgUrl = $destination;
                $stmt = mysqli_prepare($coon, "INSERT INTO gallery (image_url) VALUES (?)");
                mysqli_stmt_bind_param($stmt, "s", $imgUrl);
                if (mysqli_stmt_execute($stmt)) {
                    $message = "✅ تم رفع الصورة وحفظها بنجاح";
                } else {
                    $message = "❌ خطأ في حفظ الرابط بقاعدة البيانات";
                }
            } else {
                $message = "❌ فشل في رفع الصورة";
            }
        } else {
            $message = "❌ نوع الملف غير مدعوم (jpg, jpeg, png, gif فقط)";
        }
    } else {
        $message = "❌ لم يتم رفع أي صورة";
    }
}

// بحث عن الصور
$searchTerm = isset($_GET['search']) ? trim($_GET['search']) : '';
$searchSql = "SELECT id, image_url FROM gallery";
if (!empty($searchTerm)) {
    $searchSql .= " WHERE image_url LIKE '%" . mysqli_real_escape_string($coon, $searchTerm) . "%'";
}
$searchSql .= " ORDER BY id DESC";
$result = mysqli_query($coon, $searchSql);
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>إدارة المعرض</title>
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
    }
    
    .dark-mode {
        --primary-color: #e6b422;
        --primary-hover: #f8c63d;
        --secondary-color: #1a1a1a;
        --accent-color: #3b0d0c;
        --text-color: #f0f0f0;
        --light-text: #f9f9f9;
        --success-bg: #1e4620;
        --success-text: #a3d9a5;
        --error-bg: #5c1a1d;
        --error-text: #f5c6cb;
        --box-shadow: 0 8px 20px rgba(0,0,0,0.3);
    }
    
    body {
        font-family: 'Cairo', sans-serif;
        background: var(--secondary-color);
        color: var(--text-color);
        margin: 0;
        padding: 20px;
        transition: var(--transition);
    }

    .container {
        max-width: 800px;
        margin: 30px auto;
        background: rgba(255, 255, 255, 0.9);
        padding: 30px;
        border-radius: var(--border-radius);
        box-shadow: var(--box-shadow);
        backdrop-filter: blur(5px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        transition: var(--transition);
    }
    
    .dark-mode .container {
        background: rgba(30, 30, 30, 0.9);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    h2 {
        color: var(--primary-color);
        text-align: center;
        margin-bottom: 25px;
        position: relative;
        padding-bottom: 10px;
    }
    
    h2::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 80px;
        height: 3px;
        background: var(--accent-color);
        border-radius: 3px;
    }

    .upload-form {
        margin-bottom: 30px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    input[type="file"] {
        width: 100%;
        padding: 15px;
        border: 2px dashed var(--primary-color);
        border-radius: var(--border-radius);
        background: rgba(255,255,255,0.8);
        cursor: pointer;
        transition: var(--transition);
    }
    
    .dark-mode input[type="file"] {
        background: rgba(30, 30, 30, 0.8);
        color: var(--text-color);
    }
    
    input[type="file"]:hover {
        background: rgba(255,255,255,0.9);
        border-color: var(--primary-hover);
    }
    
    .dark-mode input[type="file"]:hover {
        background: rgba(40, 40, 40, 0.9);
    }

    .btn {
        display: inline-block;
        padding: 14px;
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

    .alert {
        padding: 15px;
        border-radius: var(--border-radius);
        text-align: center;
        margin-bottom: 20px;
        font-weight: bold;
        transition: var(--transition);
        animation: fadeIn 0.5s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
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

    .search-container {
        margin: 30px auto;
        max-width: 600px;
    }

    .search-form {
        display: flex;
        gap: 10px;
    }

    .search-input {
        flex: 1;
        padding: 12px;
        border: 2px solid #ddd;
        border-radius: var(--border-radius);
        font-size: 16px;
        transition: var(--transition);
        background: rgba(255,255,255,0.8);
    }
    
    .dark-mode .search-input {
        background: rgba(30, 30, 30, 0.8);
        border-color: #444;
        color: var(--text-color);
    }
    
    .search-input:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(59, 13, 12, 0.2);
    }
    
    .dark-mode .search-input:focus {
        box-shadow: 0 0 0 3px rgba(230, 180, 34, 0.3);
    }

    .gallery-container {
        margin-top: 40px;
    }

    .gallery {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        gap: 20px;
        margin-top: 20px;
    }

    .image-card {
        background: white;
        border-radius: var(--border-radius);
        box-shadow: var(--box-shadow);
        overflow: hidden;
        transition: var(--transition);
    }
    
    .dark-mode .image-card {
        background: #2a2a2a;
    }
    
    .image-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    }

    .image-card img {
        width: 100%;
        height: 160px;
        object-fit: cover;
        border-bottom: 1px solid #eee;
    }
    
    .dark-mode .image-card img {
        border-bottom: 1px solid #444;
    }

    .image-actions {
        padding: 10px;
        text-align: center;
    }

    .btn-danger {
        color: white;
        background-color: #dc3545;
        padding: 8px 16px;
        border-radius: var(--border-radius);
        text-decoration: none;
        font-weight: 600;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }
    
    .btn-danger:hover {
        background-color: #c82333;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    }
    
    .btn-danger:active {
        transform: translateY(0);
    }

    .back-link {
        display: inline-block;
        margin-top: 30px;
        padding: 12px 24px;
        background: var(--primary-color);
        color: white;
        border-radius: var(--border-radius);
        text-decoration: none;
        font-weight: 600;
        transition: var(--transition);
        text-align: center;
    }
    
    .back-link:hover {
        background: var(--primary-hover);
        text-decoration: none;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    .empty-state {
        text-align: center;
        padding: 40px;
        color: #666;
        grid-column: 1 / -1;
    }
    
    .dark-mode .empty-state {
        color: #aaa;
    }

    .dark-mode-toggle {
        position: fixed;
        bottom: 20px;
        left: 20px;
        background: var(--primary-color);
        color: white;
        border: none;
        border-radius: 50%;
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        z-index: 1000;
        transition: var(--transition);
    }
    
    .dark-mode-toggle:hover {
        background: var(--primary-hover);
        transform: translateY(-3px);
    }
    
    .dark-mode-toggle:active {
        transform: translateY(0);
    }

    @media (max-width: 768px) {
        .container {
            width: 95%;
            padding: 20px;
        }
        
        .gallery {
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        }
        
        .search-form {
            flex-direction: column;
            gap: 10px;
        }
        
        .dark-mode-toggle {
            bottom: 10px;
            left: 10px;
            width: 40px;
            height: 40px;
            font-size: 14px;
        }
    }
</style>
</head>
<body class="<?= $dark_mode ? 'dark-mode' : '' ?>">

<button class="dark-mode-toggle" onclick="toggleDarkMode()">
    <i class="fas <?= $dark_mode ? 'fa-sun' : 'fa-moon' ?>"></i>
</button>

<div class="container">
    <h2><i class="fas fa-images"></i> إدارة معرض الصور</h2>

    <?php if ($message): ?>
        <div class="alert <?= strpos($message, '✅') !== false ? 'alert-success' : 'alert-error' ?>">
            <i class="fas <?= strpos($message, '✅') !== false ? 'fa-check-circle' : 'fa-exclamation-circle' ?>"></i>
            <?= htmlspecialchars($message) ?>
        </div>
    <?php endif; ?>

    <div class="upload-form">
        <form method="post" enctype="multipart/form-data">
            <div class="form-group">
                <input type="file" name="image" accept="image/*" required>
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-upload"></i> رفع الصورة
            </button>
        </form>
    </div>

    <div class="search-container">
        <form method="get" class="search-form">
            <input type="text" name="search" class="search-input" placeholder="ابحث عن صورة..." value="<?= htmlspecialchars($searchTerm) ?>">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-search"></i> بحث
            </button>
        </form>
    </div>

    <div class="gallery-container">
        <div class="gallery">
            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <div class="image-card">
                        <img src="<?= htmlspecialchars($row['image_url']) ?>" alt="صورة المعرض">
                        <div class="image-actions">
                            <a href="?delete=<?= $row['id'] ?>" class="btn-danger" onclick="return confirm('هل أنت متأكد من حذف هذه الصورة؟');">
                                <i class="fas fa-trash"></i> حذف
                            </a>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="empty-state">
                    <i class="fas fa-image" style="font-size: 50px; opacity: 0.5;"></i>
                    <p>لا توجد صور متاحة</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div style="text-align: center;">
        <a href="mine.php" class="back-link">
            <i class="fas fa-arrow-right"></i> العودة للوحة التحكم
        </a>
    </div>
</div>

<script>
function toggleDarkMode() {
    const form = document.createElement('form');
    form.method = 'post';
    form.action = '';
    
    const input = document.createElement('input');
    input.type = 'hidden';
    input.name = 'toggle-dark-mode';
    input.value = '1';
    
    form.appendChild(input);
    document.body.appendChild(form);
    form.submit();
}
</script>

</body>
</html>