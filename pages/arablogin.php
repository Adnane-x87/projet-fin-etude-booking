<?php
session_start();
require_once '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $_SESSION['login_message'] = 'Email and password are required.';
        $_SESSION['login_message_type'] = 'error';
    } else {
        // Check only in client table
        $stmt = $pdo->prepare("SELECT user_id, password FROM client WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        // If password is plain (not hashed), use ===
        if ($user && $password === $user['password']) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['user_type'] = 'client';
            header('Location: arab.php');
            exit;
        }
        
         // Try to authenticate as an admin
        $stmt = $pdo->prepare("SELECT id_admin, password FROM admin WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();



        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id_admin'];
            $_SESSION['user_type'] = 'admin';
            header('Location: ../admin/dashbord.php');
            exit;
        }


        $_SESSION['login_message'] = 'Email or password is incorrect.';
        $_SESSION['login_message_type'] = 'error';
    }

    header('Location:' . $_SERVER['PHP_SELF']);
    exit;
}

$message = $_SESSION['login_message'] ?? '';
$messageType = $_SESSION['login_message_type'] ?? '';
unset($_SESSION['login_message'], $_SESSION['login_message_type']);
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link
      href="https://fonts.googleapis.com/css2?family=ADLaM+Display&display=swap"
      rel="stylesheet"
    />
    <title>تسجيل الدخول - هالان</title>
    <style>
      * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
      }

      body {
        height: 100%;
        font-family: Arial, sans-serif;
      }

      .login-container {
        position: relative;
        width: 100%;
        height: 100vh;
      }

      .left-section {
        position: absolute;
        top: 0;
        right: 0;
        width: 50%;
        height: 100%;
        background-color: #2d4930;
        color: white;
        padding: 60px;
        text-align: right;
        overflow: hidden;
      }

      .welcome-text {
        margin-bottom: 40px;
        position: relative;
        z-index: 10;
      }

      .welcome-text h1 {
        font-size: 4rem;
        font-weight: bold;
        margin-bottom: 40px;
        font-family: Arial, sans-serif;
        margin-right: 12px;
      }

      .welcome-text p {
        font-size: 1.2rem;
        line-height: 1.6;
        margin-bottom: 10px;
        margin-right: 12px;
      }

      .person-image {
        position: absolute;
        bottom: 0;
        left: -205px;
        width: 650px;
        height: auto;
        object-fit: contain;
        transform: scaleX(-1);
      }

      .right-section {
        position: absolute;
        top: 0;
        left: 0;
        width: 50%;
        height: 100%;
        background-color: white;
        padding: 60px;
        text-align: right;
        overflow-y: auto;
      }

      .login-form {
        max-width: 400px;
        margin: auto;
      }

      .login-title {
        font-size: 3rem;
        color: #2d4930;
        font-weight: bold;
        margin-bottom: 40px;
        text-align: center;
      }

      .form-group {
        margin-bottom: 25px;
      }

      .form-input {
        width: 100%;
        padding: 15px 20px;
        border: 2px solid #2d4930;
        border-radius: 10px;
        font-size: 1rem;
        background-color: #e8e8e8;
        color: #666;
        outline: none;
        text-align: right;
      }

      .form-input:focus {
        background-color: white;
        color: #333;
      }

      .form-input::placeholder {
        color: #888;
      }

      .forgot-password {
        text-align: center;
        margin: 15px 0;
      }

      .forgot-password a {
        color: #888;
        text-decoration: underline;
        font-size: 0.9rem;
      }

      .signup-link {
        text-align: center;
        margin: 20px 0;
      }

      .signup-link a {
        color: #888;
        text-decoration: underline;
        font-size: 1rem;
      }

      .login-button {
        width: 100%;
        padding: 15px;
        background-color: #2d4930;
        color: white;
        border: none;
        border-radius: 25px;
        font-size: 1.1rem;
        font-weight: bold;
        cursor: pointer;
      }

      .login-button:hover {
        background-color: #1f3422;
        transform: translateY(-2px);
      }

      .logo {
        width: 170px;
        position: absolute;
        top: -100px;
        left: 80%;
      }
    </style>
  </head>
  <body>
    <div class="login-container">
      <div class="left-section">
        <div class="welcome-text">
          <a href="arab.php"
            ><img src="../assets/icons/arablogo.png" alt="شعار" class="logo" /></a
          ><br /><br />
          <h1>مرحبًا بك</h1>
          <p>أدخل معلوماتك الشخصية</p>
          <p>وابدأ رحلتك معنا</p>
        </div>
        <img src="../assets/images/logpers.png" alt="شخص ترحيبي" class="person-image" />
      </div>

      <div class="right-section">
      <form class="login-form" method="POST" action="">
          <h2 class="login-title">تسجيل الدخول</h2>
             <?php if ($message): ?>
              <div class="message <?php echo htmlspecialchars($messageType); ?>">
                <?php echo htmlspecialchars($message); ?>
        </div>
      <?php endif; ?>
          <div class="form-group">
            <input
              type="text"
              class="form-input"
              name = "email"
              placeholder="البريد الإلكتروني"
              required
            />
          </div>

          <div class="form-group">
            <input
              type="password"
              class="form-input"
              name="password"
              placeholder="كلمة المرور"
              required
            />
          </div>

          <div class="forgot-password">
            <a href="#">هل نسيت كلمة المرور؟</a>
          </div>

          <div class="signup-link">
            <a href="tasjil.php">إنشاء حساب</a>
          </div>

          <button type="submit" class="login-button">دخول</button>
        </form>
      </div>
    </div>
  </body>
</html>
