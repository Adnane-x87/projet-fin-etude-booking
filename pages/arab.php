<?php 
session_start();
include '../includes/db.php'; 
$information = $pdo->query("SELECT * FROM hall"); 

// Get client info if logged in
$clientName = '';
if (isset($_SESSION['user_id']) && isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'client') {
    $stmt = $pdo->prepare("SELECT username FROM client WHERE user_id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $row = $stmt->fetch();
    if ($row) {
        $clientName = $row['username'];
    }
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../assets/css/arab.css" />
    <link
      href="https://fonts.googleapis.com/css2?family=ADLaM+Display&display=swap"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
    />

    <title>Hallane</title>
  </head>
  <body>
    <section id="one">
      <div class="navbar">
        <div class="links">
          <a href="index.php" class="mr"> ع</a>
          <a href="arablogin.php" class="login"> تسجيل الدخول</a>
        </div>
        <nav>
          <ul>
            <li><a href="#one">الرئيسية</a></li>
            <li><a href="#two">من نحن</a></li>
            <li><a href="#three"> القاعات</a></li>
            <li><a href="#five">اتصل بنا</a></li>
          </ul>
        </nav>
        <img src="../assets/icons/arablogo.png" alt="logo" class="logo" />
      </div>

      <div class="header">
        <div class="header-text">
          <h1 class="welcom" style="position: absolute; left: 238px">
            مرحباً بكم في موقعنا
          </h1>
          <p class="welcom-text">
            ابدأ رحلتك معنا الآن واحجز قاعاتك وملاعبك الرياضية بسهولة. سجّل الآن
            لتجربة حجز سلسة وسريعة
          </p>
          <a class="welcom-btn" href="tasjil.php">سجل الآن</a>
        </div>
        <div class="header-img">
          <img src="../assets/images/hedar-image.jpg" alt="House image" class="house" />
        </div>
      </div>
    </section>

    <section id="two">
      <div class="about-section">
        <h1>من نحن</h1>

        <div class="about-content">
          <h2>من هي هالان؟</h2>

          <div class="cards-container">
            <div class="card">
              <div class="card-icon">
                <img src="../assets/icons/Checkmark.png" alt="Team Icon" />
              </div>
              <h3>فريق متخصص</h3>
              <p>
                نحن فريق متخصص يهدف إلى توفير منصة إلكترونية سهلة وفعّالة لحجز
                القاعات والملاعب الرياضية في مختلف المدن. من خلال موقعنا، يمكن
                للمستخدمين استكشاف أفضل القاعات، ومقارنة الأسعار، والتحقق من
                التوافر، ثم إجراء الحجز بسرعة وسهولة.
              </p>
            </div>

            <div class="card">
              <div class="card-icon">
                <img src="../assets/icons/Price Tag USD.png" alt="Goal Icon" />
              </div>
              <h3>هدفنا</h3>
              <p>
                هدفنا هو تبسيط عملية الحجز للأفراد والمؤسسات، وتوفير تجربة
                مستخدم سلسة وآمنة. نؤمن بأن التكنولوجيا يجب أن تخدم الناس، ولذلك
                نعمل على تطوير حلول ذكية لجعل الحجز أكثر مرونة وراحة.
              </p>
            </div>

            <div class="card">
              <div class="card-icon">
                <img src="../assets/icons/Goal.png" alt="Vision Icon" />
              </div>
              <h3>رؤيتنا</h3>
              <p>
                رؤيتنا هي أن نصبح المنصة الرائدة لحجز القاعات والملاعب الرياضية
                في جميع أنحاء العالم والمساهمة في تحسين جودة الخدمات الرياضية
                والاجتماعية من خلال التقنيات الحديثة وواجهة مستخدم بسيطة
                ومباشرة.
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section id="three">
      <div class="halls-section">
        <br />
        <h1>قاعاتنا</h1>
        <br /><br />
        <p class="tit1">
          نقدم لكم مجموعة مختارة من أفضل القاعات المصممة لتناسب جميع مناسباتكم،
          سواءً كانت حفلات أو اجتماعات أو مناسبات خاصة. تصفحوا القاعات المتاحة
          في مختلف المدن، واختروا ما يناسبكم من حيث الموقع والسعة والسعر. احجزوا
          الآن بسهولة واستمتعوا بتجربة مميزة.
        </p>
        <br /><br />
        <div class="venue-cards-container">
          <?php foreach ($information as $key => $value): ?>
            <div class="venue-card">
              <div class="image-section">
                <img class="image-section" src="../assets/images/<?= $value['image'] ?>" />
                <div class="top-tags">
                  <span class="tag"><i class="fas fa-map-marker-alt"></i> <?= $value['arabic_local'] ?></span>
                  <span class="tag"><i class="fas fa-users"></i> <?= $value['capacity']  ?></span>
                </div>
              </div>
              <div class="content">
                <div class="header">
                  <h3 class="title"><?= $value['arabic_title'] ?></h3>
                  <div class="price">
                    <div class="price-amount"><?= $value['price'] ?> درهم</div>
                    <div class="price-period"><?= $value['arabic_time'] ?></div>
                  </div>
                </div>
                <p class="description">
                  <?= $value['arabic_description'] ?>
                </p>
                <a href="arbresrv.php?hall_id=<?= $value['hall_id'] ?>" class="reserve-btn">احجز الآن</a>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
        <br /><br />
      </div>
    </section>
    <br /><br />
    <section class="four">
      <div class="stories-section">
        <h1>قصص سعيدة</h1>
        <br /><br />
        <h2>دعونا نسمع ما يقوله عملاؤنا السعداء!</h2>
        <br />
        <p>
          لا تصدقونا، دعونا نسمع من عملائنا الذين حجزوا أماكن لدينا وما يقولونه
          عن تجربتهم.
        </p>
        <br /><br />
        <div class="testimonial-card">
          <p class="testimonial-text">
            كنت أبحث عن مكان مناسب لحفل تخرجي، وكانت جميع الأماكن إما محجوزة أو
            باهظة الثمن. من خلال هذا الموقع، وجدتُ قاعة جميلة بسعر رائع! كان كل
            شيء مُنظمًا، من الحجز وحتى يوم الحفل... كانت ليلة لا تُنسى!
          </p>
          <div class="author">
            <div class="author-avatar">
              <img src="../assets/images/profil1.png" alt="profil" />
            </div>
            <span class="author-name"> ريم العتيبي</span>
          </div>
        </div>
        <div class="testimonial-card">
          <p class="testimonial-text">
            نظمتُ حفلة عيد ميلاد لأختي الصغيرة، وكنتُ قلقةً من عدم العثور على
            مكان مناسب. زرتُ الموقع الإلكتروني ووجدتُ خياراتٍ عديدة! حجزتُ قاعةً
            مع منطقة لعب، وكانت التجربة رائعة!
          </p>
          <div class="author">
            <div class="author-avatar">
              <img src="../assets/images/profil.png" alt="profil" />
            </div>
            <span class="author-name">عبدالله منصور</span>
          </div>
        </div>
      </div>
    </section>
    <br /><br />

    <section id="five">
      <div class="contact-section">
        <br /><br />
        <h1>اتصل بنا</h1>
        <br /><br /><br /><br />
        <p>
          يسعدنا تواصلكم معنا! سواءً كنتم ترغبون في حجز قاعة لفعاليتكم القادمة،
          أو تحتاجون إلى مزيد من التفاصيل حول قاعاتنا، أو حتى لديكم اقتراح، فنحن
          هنا لمساعدتكم. فريقنا ملتزم بجعل تجربتكم سلسة لا تُنسى قدر الإمكان. من
          حفلات الزفاف إلى فعاليات الشركات، نحن على أتم الاستعداد للإجابة على أي
          استفسارات أو طلبات خاصة. لا تترددوا في التواصل معنا. ملاحظاتكم تساعدنا
          على النمو وخدمتكم بشكل أفضل. لنجعل فعاليتكم القادمة لا تُنسى.
        </p>
      </div>
      <div class="messgae-section">
        <div class="contact-container">
          <br /><br />
          <div class="contact-info">
            <br /><br />
            <h2>تواصل معنا</h2>
            <br />
            <p>
              يسعدنا تواصلك معنا! املأ النموذج أو تواصل معنا مباشرةً عبر
              التفاصيل أدناه.
            </p>
            <br /><br />

            <div class="info-item">
              <span class="icon"><i class="fas fa-map-marker-alt"></i></span>
              <div>
                <h4>المكتب الرئيسي</h4>
                <p>SOLICOD-TANGIER</p>
              </div>
            </div>

            <div class="info-item">
              <span class="icon"><i class="fas fa-envelope"></i></span>
              <div>
                <h4>راسلنا عبر البريد الإلكتروني</h4>
                <p>tangerinoh40@gmail.com</p>
              </div>
            </div>

            <div class="info-item">
              <span class="icon"
                ><i class="fa fa-phone" aria-hidden="true"></i>
              </span>
              <div>
                <h4>اتصل بنا</h4>
                <p>+212 688 1991 81</p>
              </div>
            </div>
            <br /><br />

            <h4>تابعنا على وسائل التواصل الاجتماعي</h4>
            <br />
            <div class="social-icons">
              <span><i class="fa-brands fa-facebook"></i> </span>
              <span><i class="fa-brands fa-twitter"></i></span>
              <span><i class="fa-brands fa-instagram"></i> </span>
              <span><i class="fa-brands fa-linkedin"></i></span>
            </div>
          </div>

          <!-- Contact Form -->
          <div class="contact-form">
            <br /><br />
            <h2>أرسل لنا رسالة</h2>
            <br /><br />
            <form>
              <span><label>اسم</label></span
              ><br /><br />
              <input type="text" placeholder="اسمك الكامل" />
              <label>بريد إلكتروني</label>
              <input type="email" placeholder="أنت@البريد الإلكتروني.com" />
              <label>رسالة</label>
              <textarea placeholder="كيف يمكننا مساعدتك؟"></textarea>
              <button type="submit">
                <i class="fa-solid fa-paper-plane"></i>إرسال رسالة
              </button>
            </form>
          </div>
        </div>
        <br />
      </div>
    </section>
    <iframe
      src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3086.3969911708136!2d-5.827968524394334!3d35.7462080725663!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd0b87c216892bc7%3A0x48bdf85995e9c186!2sSolicode%20Tanger!5e1!3m2!1sfr!2sma!4v1748963270636!5m2!1sfr!2sma"
      width="600"
      height="450"
      style="border: 0"
      allowfullscreen=""
      loading="lazy"
      referrerpolicy="no-referrer-when-downgrade"
    ></iframe
    ><br /><br />
    <section class="six">
      <footer class="site-footer">
        <div class="footer-content">
          <div class="footer-column">
            <h4>شركة</h4>
            <ul>
              <li><a href="#two">من نحن</a></li>
              <li><a href="#three">قاعاتنا</a></li>
              <li><a href="#">Our services</a></li>
              <li><a href="#five">اتصل بنا</a></li>
            </ul>
          </div>

          <div class="footer-column">
            <h4>شريط التنقل</h4>
            <ul>
              <li><a href="#one">الرئيسية</a></li>
              <li><a href="#two">من نحن</a></li>
              <li><a href="#three">قاعاتنا</a></li>
              <li><a href="#">قصص سعيدة</a></li>
            </ul>
          </div>

          <div class="footer-column">
            <h4>اتصل بنا</h4>
            <p>tangerinoh40@gmail.com</p>
            <p>+212688199181</p>
            <p>Soli code tangier</p>
          </div>

          <div class="footer-column">
            <h4>تابعنا</h4>
            <div class="social-icons">
              <i class="fab fa-facebook-f"></i>
              <i class="fab fa-instagram"></i>
              <i class="fab fa-twitter"></i>
              <i class="fab fa-youtube"></i>
            </div>
          </div>
        </div>

        <hr />
        <p class="copyright">&copy; 2025 عدنان كسكسو. جميع الحقوق محفوظة.</p>
      </footer>
    </section>
  </body>
</html>
