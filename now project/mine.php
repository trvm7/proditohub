<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: admi.php");
    exit;
}

include("link.php");

$result = mysqli_query($coon, "SELECT * FROM recost ORDER BY id DESC");

// إحصائيات
$total = mysqli_num_rows($result);
$completed = mysqli_num_rows(mysqli_query($coon, "SELECT * FROM recost WHERE status = 'مكتمل'"));
$rejected = mysqli_num_rows(mysqli_query($coon, "SELECT * FROM recost WHERE status = 'مرفوض'"));
$in_progress = mysqli_num_rows(mysqli_query($coon, "SELECT * FROM recost WHERE status = 'جاري العمل عليه'"));
//dito ig trvm7
mysqli_data_seek($result, 0); // إعادة المؤشر لبداية النتائج
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة تحكم الأدمن</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="mine.css">
</head>
<body>

<!-- Loading Overlay -->
<div class="loader" id="loader">
    <div class="loader-content">
        <div class="loader-spinner"></div>
        <p>جاري التحميل...</p>
    </div>
</div>

<!-- Floating Action Button   //dito ig trvm7 -->
<div class="fab animate__animated animate__fadeInUp" onclick="scrollToTop()">
    <i class="fas fa-arrow-up"></i>
</div>

<header class="animate__animated animate__fadeInDown">
    <h1><i class="fas fa-tachometer-alt"></i> لوحة تحكم الأدمن</h1>
    <div style="text-align:center; margin-top:15px;">
        <button onclick="toggleDarkMode()" class="toggle-btn animate__animated animate__fadeIn">
            <span id="mode-icon">🌓</span> تبديل الوضع
        </button>
    </div>
</header>

<div class="actions animate__animated animate__fadeIn">
    <a href="manage_services.php" class="animate__animated animate__fadeInLeft"><i class="fas fa-cogs"></i> إدارة أنواع الخدمات</a>
    <a href="upload_gallery.php" class="animate__animated animate__fadeInLeft"><i class="fas fa-images"></i> رفع صور للمعرض</a>
    <a href="logout.php" class="logout animate__animated animate__fadeInRight"><i class="fas fa-sign-out-alt"></i> تسجيل خروج</a>
</div>

<div class="stats animate__animated animate__fadeIn">
    <div class="stat-card animate__animated animate__fadeInUp" style="animation-delay: 0.1s" onclick="filterRequests('all')">
        <h3><i class="fas fa-list-alt"></i> عدد الطلبات</h3>
        <div class="count"><?= $total ?></div>
    </div>
    <div class="stat-card animate__animated animate__fadeInUp" style="animation-delay: 0.2s" onclick="filterRequests('مكتمل')">
        <h3><i class="fas fa-check-circle"></i> المكتملة</h3>
        <div class="count"><?= $completed ?></div>
    </div>
    <div class="stat-card animate__animated animate__fadeInUp" style="animation-delay: 0.3s" onclick="filterRequests('مرفوض')">
        <h3><i class="fas fa-times-circle"></i> المرفوضة</h3>
        <div class="count"><?= $rejected ?></div>
    </div>
    <div class="stat-card animate__animated animate__fadeInUp" style="animation-delay: 0.4s" onclick="filterRequests('جاري العمل عليه')">
        <h3><i class="fas fa-spinner"></i> جاري العمل عليها</h3>
        <div class="count"><?= $in_progress ?></div>
    </div>
</div>

<div class="table-container animate__animated animate__fadeIn">
    <table id="requestsTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>الاسم</th>
                <th>البريد</th>
                <th>الهاتف</th>
                <th>الخدمة</th>
                <th>الحالة</th>
                <th>تغيير الحالة</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result))://dito ig trvm7 ?>
                <tr data-status="<?= htmlspecialchars($row['status']) ?>" data-id="<?= $row['id'] ?>" class="animate__animated animate__fadeIn">
                    <td><?= htmlspecialchars($row['id']) ?></td>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= htmlspecialchars($row['emil']) ?></td>
                    <td><?= htmlspecialchars($row['phon']) ?></td>
                    <td><?= htmlspecialchars($row['service_type']) ?></td>
                    <td>
                        <span class="status <?= str_replace(' ', '_', $row['status']) ?>">
                            <?= htmlspecialchars($row['status']) ?>
                        </span>
                    </td>
                    <td>
                        <form method="post" action="update_status.php" class="status-form">
                            <input type="hidden" name="id" value="<?= $row['id'] ?>">
                            <select name="status" onchange="updateStatus(this)">
                                <option value="مرفوض" <?= $row['status'] == 'مرفوض' ? 'selected' : '' ?>>مرفوض</option>
                                <option value="قيد المراجعة" <?= $row['status'] == 'قيد المراجعة' ? 'selected' : '' ?>>قيد المراجعة</option>
                                <option value="جاري العمل عليه" <?= $row['status'] == 'جاري العمل عليه' ? 'selected' : '' ?>>جاري العمل عليه</option>
                                <option value="مكتمل" <?= $row['status'] == 'مكتمل' ? 'selected' : '' ?>>مكتمل</option>
                            </select>
                        </form>
                    </td>
                    <td style="white-space: nowrap;">
                        <button onclick="showDetails('<?= htmlspecialchars($row['details']) ?>', '<?= htmlspecialchars($row['service_type']) ?>')" class="details-btn" title="عرض التفاصيل">
                            <i class="fas fa-eye"></i> التفاصيل
                        </button>
                        <button onclick="deleteRequest(<?= $row['id'] ?>)" class="delete-btn" title="حذف الطلب">
                            <i class="fas fa-trash"></i> حذف
                        </button>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Dark Mode Toggle
    function toggleDarkMode() {
        document.body.classList.toggle('dark-mode');
        const isDarkMode = document.body.classList.contains('dark-mode');
        localStorage.setItem('dark-mode', isDarkMode);
        
        // Change icon
        const icon = document.getElementById('mode-icon');
        if (isDarkMode) {
            icon.textContent = '🌙';
        } else {
            icon.textContent = '🌓';
        }
        
        // Show centered notification
        Swal.fire({
            position: 'center',
            icon: 'success',
            title: isDarkMode ? 'تم تفعيل الوضع الليلي' : 'تم تعطيل الوضع الليلي',
            showConfirmButton: false,
            timer: 1000,
            backdrop: true,
            customClass: {
                popup: 'custom-swal-popup-center'
            }
        });
    }

    // Check for saved dark mode preference
    window.onload = function () {
        if (localStorage.getItem('dark-mode') === 'true') {
            document.body.classList.add('dark-mode');
            document.getElementById('mode-icon').textContent = '🌙';
        }
        
        // Add animation to table rows
        const rows = document.querySelectorAll('tbody tr');
        rows.forEach((row, index) => {
            row.style.animationDelay = `${index * 0.05}s`;
        });
    }

    // Show loading spinner
    function showLoader() {
        document.getElementById('loader').style.display = 'flex';
    }

    // Hide loading spinner
    function hideLoader() {
        document.getElementById('loader').style.display = 'none';
    }

    // Update status with confirmation and auto refresh
    function updateStatus(selectElement) {
        const form = selectElement.closest('form');
        const row = form.closest('tr');
        const newStatus = selectElement.value;
        const requestId = form.querySelector('input[name="id"]').value;
        
        Swal.fire({
            title: 'تأكيد تغيير الحالة',
            text: `هل أنت متأكد من تغيير حالة الطلب إلى "${newStatus}"؟`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3b0d0c',
            cancelButtonColor: '#dc3545',
            confirmButtonText: 'نعم، تغيير',
            cancelButtonText: 'إلغاء',
            position: 'center',
            backdrop: true,
            customClass: {
                popup: 'custom-swal-popup-center'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                showLoader();
                fetch(form.action, {
                    method: 'POST',
                    body: new URLSearchParams(new FormData(form)),
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.text();
                })
                .then(() => {
                    // Show success message centered
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'تم تحديث الحالة بنجاح',
                        showConfirmButton: false,
                        timer: 1500,
                        backdrop: true,
                        customClass: {
                            popup: 'custom-swal-popup-center'
                        }
                    }).then(() => {
                        location.reload();
                    });
                })
                .catch(error => {
                    hideLoader();
                    Swal.fire({
                        icon: 'error',
                        title: 'خطأ',
                        text: 'حدث خطأ أثناء تحديث الحالة',
                        position: 'center',
                        backdrop: true,
                        customClass: {
                            popup: 'custom-swal-popup-center'
                        }
                    });
                    console.error('Error:', error);
                    // Reset to original value on error
                    const originalStatus = row.getAttribute('data-status');
                    selectElement.value = originalStatus;
                });
            } else {
                // Reset to original value if canceled
                const originalStatus = row.getAttribute('data-status');
                selectElement.value = originalStatus;
            }
        });
    }

    // Filter requests by status
    function filterRequests(status) {
        const rows = document.querySelectorAll('#requestsTable tbody tr');
        let count = 0;
        
        rows.forEach(row => {
            if (status === 'all' || row.getAttribute('data-status') === status) {
                row.style.display = '';
                count++;
            } else {
                row.style.display = 'none';
            }
        });
        
        // Show centered notification
        if (status === 'all') {
            Swal.fire({
                position: 'center',
                icon: 'info',
                title: `عرض جميع الطلبات (${count})`,
                showConfirmButton: false,
                timer: 1000,
                backdrop: true,
                customClass: {
                    popup: 'custom-swal-popup-center'
                }
            });
        } else {
            Swal.fire({
                position: 'center',
                icon: 'info',
                title: `عرض الطلبات بحالة "${status}" (${count})`,
                showConfirmButton: false,
                timer: 1000,
                backdrop: true,
                customClass: {
                    popup: 'custom-swal-popup-center'
                }
            });
        }
    }

    // Delete request function
    function deleteRequest(id) {
        Swal.fire({
            title: 'هل أنت متأكد؟',
            text: "لن تتمكن من استعادة هذا الطلب بعد الحذف!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3b0d0c',
            cancelButtonColor: '#dc3545',
            confirmButtonText: 'نعم، احذفه!',
            cancelButtonText: 'إلغاء',
            position: 'center',
            backdrop: true,
            customClass: {
                popup: 'custom-swal-popup-center'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                showLoader();
                fetch('delete_request.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `id=${id}`
                })
                .then(response => response.json())
                .then(data => {
                    hideLoader();
                    if (data.success) {
                        document.querySelector(`tr[data-id="${id}"]`).remove();
                        Swal.fire({
                            title: 'تم الحذف!',
                            text: 'تم حذف الطلب بنجاح.',
                            icon: 'success',
                            position: 'center',
                            confirmButtonColor: '#3b0d0c',
                            backdrop: true,
                            customClass: {
                                popup: 'custom-swal-popup-center'
                            }
                        });
                        location.reload();
                    } else {
                        Swal.fire({
                            title: 'خطأ!',
                            text: 'حدث خطأ أثناء محاولة الحذف: ' + (data.error || ''),
                            icon: 'error',
                            position: 'center',
                            backdrop: true,
                            customClass: {
                                popup: 'custom-swal-popup-center'
                            }
                        });
                    }
                })
                .catch(error => {
                    hideLoader();
                    Swal.fire({
                        title: 'خطأ!',
                        text: 'حدث خطأ في الاتصال: ' + error,
                        icon: 'error',
                        position: 'center',
                        backdrop: true,
                        customClass: {
                            popup: 'custom-swal-popup-center'
                        }
                    });
                });
            }
        });
    }

    // Scroll to top function
    function scrollToTop() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    }

    // Show/hide floating button based on scroll position
    window.addEventListener('scroll', function() {
        const fab = document.querySelector('.fab');
        if (window.pageYOffset > 300) {
            fab.style.display = 'flex';
        } else {
            fab.style.display = 'none';
        }
    });

    // Add click animation to stat cards
    document.querySelectorAll('.stat-card').forEach(card => {
        card.addEventListener('click', function() {
            this.classList.add('animate-pop');
            setTimeout(() => {
                this.classList.remove('animate-pop');
            }, 300);
        });
    });

    // Add loading to all links
    document.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', function(e) {
            if (!this.href.includes('javascript:')) {
                showLoader();
            }
        });
    });

    // Function to show details in modal
    function showDetails(details, serviceType) {
        const modal = document.createElement('div');
        modal.className = 'modal';
        modal.innerHTML = `
            <div class="modal-content animate__animated animate__fadeInUp" style="width: 90%; max-width: 900px; height: 85vh;">
                <div class="modal-header">
                    <h3 class="modal-title" style="font-size: 1.8em; margin-bottom: 15px;">تفاصيل الطلب - ${serviceType}</h3>
                    <button class="modal-close" onclick="closeModal(this)" style="font-size: 2em;">&times;</button>
                </div>
                <div class="modal-body" style="width: 100%; height: calc(100% - 70px); overflow-y: auto; padding: 20px; font-size: 1.2em; line-height: 1.8; text-align: right; direction: rtl;">
                    ${formatDetails(details)}
                </div>
            </div>
        `;
        document.body.appendChild(modal);
        modal.style.display = 'flex';
        
        // Close modal when clicking outside
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                closeModal(modal);
            }
        });
    }

    // Helper function to format details
    function formatDetails(details) {
        // Replace new lines with paragraphs
        let formatted = details.replace(/\n/g, '<br><br>');
        
        // Add formatting for headings if found
        formatted = formatted.replace(/^(.*?:)/gm, '<strong>$1</strong>');
        
        return formatted;
    }

    // Function to close modal
    function closeModal(element) {
        const modal = element.closest ? element.closest('.modal') : element;
        const content = modal.querySelector('.modal-content');
        content.classList.remove('animate__fadeInUp');
        content.classList.add('animate__fadeOutDown');
        
        setTimeout(() => {
            modal.remove();
        }, 300);
    }
</script>

</body>
</html>