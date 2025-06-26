<!DOCTYPE html>
<html lang="ar" dir="rtl">
<?php
include("link.php");
$coon;
?>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>استوديو الإبداع</title>
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
</head>
<body>

  <header>
    <div class="logo">استوديو الإبداع</div>
    <nav class="nav-links">
      <a href="#">الرئيسية</a>
      <a href="#about">من نحن</a>
      <a href="#services">خدماتنا</a>
      <a href="#galler">معرض الأعمال</a>
      <a href="#recoset">تواصل معنا</a>
    </nav>
  </header>

  <section class="hero">
    <div class="hero-container">
      <div class="hero-image">
        <img src="https://cdn-icons-png.flaticon.com/512/3039/3039431.png" alt="كاميرا">
      </div>
      <div class="hero-text">
        <h1>نحوّل أفكارك إلى إبداع مرئي</h1>
        <p>فريق متكامل من المحترفين في مجالات التصوير والتصميم والتسويق لمساعدتك على تحقيق رؤيتك</p>
        <div class="hero-buttons">
          <a href="#recoset" class="btn-primary">احجز خدمتك الآن</a>
          <a href="#services" class="btn-outline">استكشف خدماتنا</a>
        </div>
      </div>
    </div>
  </section>

  <section class="section" id="about">
    <h2>من نحن</h2>
    <div class="cards">
      <div class="card">
        <img src="img/group-chat.png" width="40" alt="نبذة">
        <h3>نبذة عن الفريق</h3>
        <p>نحن فريق متكامل من المحترفين في مجالات التصوير والتصميم والتسويق، نسعى لتقديم خدمات بجودة عالية تلبي احتياجات عملائنا وتفوق توقعاتهم.</p>
      </div>
      <div class="card">
        <img src="img/opportunity.png" width="40" alt="رؤيتنا">
        <h3>رؤيتنا</h3>
        <p>نسعى لأن نكون الخيار الأول في مجال الخدمات الإبداعية عبر تقديم حلول مبتكرة تساهم في نجاح عملائنا وتعزيز حضورهم في السوق.</p>
      </div>
      <div class="card">
        <img src="img/email.png" width="40" alt="رسالتنا">
        <h3>رسالتنا</h3>
        <p>تقديم خدمات إبداعية متميزة بأعلى معايير الجودة، والعمل بشغف لتحويل أفكار عملائنا إلى واقع ملموس يساهم في تحقيق أهدافهم.</p>
      </div>
    </div>
  </section>

  <section class="section" id="services">
    <h2>خدماتنا</h2>
    <p>نقدم مجموعة متكاملة من الخدمات الإبداعية لتلبية احتياجاتك المختلفة</p>
    <div class="cards">
      <div class="card">
        <img src="img/photo-camera-interface-symbol-for-button.png" alt="" id="imgcard">
        <h3>التصوير الفوتوغرافي</h3>
        <p>جلسات تصوير احترافية للأفراد والشركات، مع تجهيزات كاملة.</p>
        <a href="#recoset" class="btn">احجز الآن</a>
      </div>
      <div class="card">
        <img src="img/fountain-pen-close-up.png" alt="" id="imgcard">
        <h3>تصميم جرافيكي</h3>
        <p>تصميم شعارات، هوية بصرية، منشورات ترويجية والمزيد.</p>
        <a href="#recoset" class="btn">احجز الآن</a>
      </div>
      <div class="card">
        <img src="img/megaphone.png" alt="" id="imgcard">
        <h3>مونتاج فيديو</h3>
        <p>تحرير فيديو احترافي للإعلانات، المناسبات، والمشاريع التجارية.</p>
        <a href="#recoset" class="btn">احجز الآن</a>
      </div>
    </div>
  </section>

  <section class="section" id="gallery">
    <h1 style="text-align: center;">الباقات والأسعار</h1>
    <div class="packages-container">
      <div class="package professional">
        <h2>الباقة الاحترافية</h2>
        <div class="price">ريال 1200</div>
        <ul class="features">
          <li>جلسة تصوير متعددة</li>
          <li>50 صورة معدلة</li>
          <li>تصميم شعار احترافي</li>
          <li>إدارة وسائل التواصل (3 منصات)</li>
          <li>تصميم هوية بصرية كاملة</li>
        </ul>
        <a href="#recoset" class="btn">احجز الآن</a>
      </div>
      <div class="package advanced">
        <p id="pp">الأكثر طلباً</p>
        <h2>الباقة المتقدمة</h2>
        <div class="price advanced">ريال 800</div>
        <ul class="features">
          <li>جلسة تصوير (3 ساعات)</li>
          <li>25 صورة معدلة</li>
          <li>تصميم شعار احترافي</li>
          <li>إدارة وسائل التواصل (منصتان)</li>
          <li>تصميم هوية بصرية</li>
        </ul>
        <a href="#recoset" class="btn advanced">احجز الآن</a>
      </div>
      <div class="package basic">
        <h2>الباقة الأساسية</h2>
        <div class="price basic">ريال 385</div>
        <ul class="features">
          <li>جلسة تصوير (ساعة واحدة)</li>
          <li>10 صور معدلة</li>
          <li>تصميم شعار بسيط</li>
          <li>إدارة وسائل التواصل</li>
          <li>هوية بصرية مبدئية</li>
        </ul>
        <a href="#recoset" class="btn basic">احجز الآن</a>
      </div>
    </div>
  </section>

  <section class="section" id="galler">
    <h1>معرض الأعمال</h1>
    <p>نماذج من أعمالنا السابقة في مجالات التصوير والتصميم والتسويق</p>
    <div style="display: flex; flex-wrap: wrap; justify-content: center; gap: 15px; margin-top: 20px;">
      <?php
      $images = mysqli_query($coon, "SELECT * FROM gallery ORDER BY id DESC");
      if (mysqli_num_rows($images) > 0) {
          while ($img = mysqli_fetch_assoc($images)) {
              echo '<img src="' . htmlspecialchars($img['image_url']) . '" alt="معرض" style="width:200px; height:auto; border-radius:8px; box-shadow:0 2px 10px rgba(0,0,0,0.1);">';
          }
      } else {
        //dito
          echo '<p style="color:gray;">لا يوجد صور حالياً</p>';
      }
      ?>
    </div>
  </section>

  <section class="container" id="recoset">
    <h1>احجز خدمتك</h1>
    <p class="description">املأ النموذج التالي وسنتواصل معك في أقرب وقت ممكن</p>
    <div class="divider"></div>
    <form action="gen.php" method="post">
      <div class="form-group">
        <label for="fullname">الاسم الكامل</label>
        <input type="text" name="user" id="fullname" placeholder="ادخل اسمك الكامل" required>
      </div>
      <div class="form-group">
        <label for="whatsapp">رقم الواتساب</label>
        <input type="tel" name="phon" id="whatsapp" placeholder="ادخل رقم الواتساب مع رمز الدولة" required>
      </div>
      <div class="form-group">
        <label for="email">البريد الإلكتروني</label>
        <input type="email" id="email" name="emil" placeholder="ادخل بريدك الإلكتروني" required>
      </div>
      <div class="form-group">
        <label for="service">نوع الخدمة</label>
        <select id="service" name="select" required>
          <option value="" hidden>اختر نوع الخدمة</option>
          <?php
          $query = mysqli_query($coon, "SELECT * FROM service_types ORDER BY name ASC");
          while ($row = mysqli_fetch_assoc($query)) {
              echo '<option value="' . htmlspecialchars($row['name']) . '">' . htmlspecialchars($row['name']) . '</option>';
          }
          ?>
        </select>
      </div>
      <div class="form-group">
        <label for="details">تفاصيل الطلب</label>
        <textarea id="details" name="details" rows="4" placeholder="اكتب تفاصيل إضافية عن طلبك"></textarea>
      </div>
      <div class="checkbox-group">
        <div class="checkbox-item">
          <input type="checkbox" id="terms" required>
          <label for="terms">أوافق على سياسة الخصوصية و <a href="rol.php"> الشروط والأحكام
</a></label>
        </div>
      </div>
      <input type="submit" name="okay" class="submit-btn" value="إرسال الطلب">
    </form>
  </section>

<section id="recoset">
  <h1>تواصل معنا</h1>
  <div class="underline"></div>
  <p class="intro">يمكنك التواصل معنا عبر إحدى وسائل الاتصال التالية</p>

  <div class="contact-container">
    <div class="left-column">
      <div class="box">
        <h3>معلومات الاتصال</h3>
        <div class="contact-item">
          <div class="icon"><img src="img/phone-call.png" alt="واتساب" /></div>
          <div>واتساب<br>966570094578+</div>
        </div>
        <div class="contact-item">
          <div class="icon"><img src="https://cdn-icons-png.flaticon.com/512/561/561127.png" alt="البريد الإلكتروني" /></div>
          <div>البريد الإلكتروني<br>hudub.team@gmail.com</div>
        </div>
       
      </div>
<br>
      <div class="box">
        <h3>ساعات العمل</h3>
        <p>الأحد - الخميس: 9:00 ص - 5:00 م</p>
        <p>الجمعة: مغلق</p>
        <p>السبت: 10:00 ص - 2:00 م</p>
        <div class="note">
          يمكن حجز مواعيد خاصة خارج أوقات العمل الرسمية عبر التواصل المباشر معنا.
        </div>
      </div>
    </div>
<br><br>
    <div class="right-column">
      <div class="box">
        <h3>تابعنا على وسائل التواصل</h3>
        
        <div class="social-item">
          <span style=""><a  href="https://www.instagram.com/team_hadb?igsh=MWVvZXlkMDdiYW5oYw==" id="LinkD">إنستغرام</a></span>
          <div class="icon"><img src="https://cdn-icons-png.flaticon.com/512/174/174855.png" alt="إنستغرام" /></div>
        </div>
        <div class="social-item">
          <span><a href="https://www.tiktok.com/@sa.hadab?_t=ZT-8xWFrfui1ok&_r=1"  id="LinkD">تك توك</a></span>
          <div class="icon"><img src="img/tik-tok.png" alt="تك توك" /></div>
        </div>
       
      </div>
    </div>
  </div>
</section>

<br>

  <footer>
    &copy; 2025 استوديو الإبداع - جميع الحقوق محفوظة
  </footer>

</body>
</html>