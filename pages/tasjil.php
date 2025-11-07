<?php // Connect to the database
require_once '../includes/db.php';

// If the database connection fails
if (!isset($pdo)) {
    die("Error: Database connection not established.");
}

$errors = []; // Array to store error messages

// Check if the form was submitted using POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get and sanitize the form inputs
    $username = htmlspecialchars(trim($_POST['username']));
    $email = htmlspecialchars(trim($_POST['email']));
    $password = trim($_POST['password'] ?? '');

    // Basic validation
    if (empty($username) || empty($email) || empty($password)) {
        $errors[] = "All fields are required.";
    } elseif (strlen($password) < 8) {
        $errors[] = "Password must be at least 8 characters long.";
    }

    // If no errors, insert the user into the database
    if (empty($errors)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT); // Secure password hashing

        $sql = "INSERT INTO `client` (`username`, `email`, `password`) VALUES (?, ?, ?)";

        try {
            $stmt = $pdo->prepare($sql); // Prepare SQL statement
            $stmt->execute([$username, $email, $hashed_password]); // Execute with data
            header("Location: arablogin.php"); // Redirect to login page after success
            exit();
        } catch (PDOException $e) {
            // Check for duplicate email (unique constraint violation)
            if ($e->getCode() == 23000) {
                $errors[] = "This email is already registered.";
            } else {
                $errors[] = "Registration failed: " . $e->getMessage();
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      href="https://fonts.googleapis.com/css2?family=ADLaM+Display&display=swap"
      rel="stylesheet"
    />
    <title>التسجيل - هالان</title>
    <style>
      * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
      }

      body {
        font-family: Arial, sans-serif;
        height: 100vh;
        margin: 0;
        position: relative;
        overflow: hidden;
      }

      .login-container {
        width: 100%;
        height: 100vh;
        position: relative;
      }

      .left-section {
        width: 50%;
        height: 100%;
        position: absolute;
        top: 0;
        right: 0;
        background-color: #2d4930;
        color: white;
        padding: 60px;
      }

      .logo {
        width: 170px;
        position: absolute;
        bottom: 28rem;
        left: 77%;
      }

      .welcome-text {
        position: absolute;
        top: 130px;
        right: 60px;
      }

      .welcome-text h1 {
        font-size: 4rem;
        font-weight: bold;
        margin-bottom: 20px;
      }

      .welcome-text p {
        font-size: 1.2rem;
        line-height: 1.6;
        margin-bottom: 10px;
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
        width: 50%;
        height: 100%;
        position: absolute;
        top: 0;
        left: 0;
        background-color: white;
        padding: 60px;
      }

      .login-form {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 100%;
        max-width: 400px;
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
      }

      .form-input:focus {
        background-color: white;
        color: #333;
        border-color: #4a6b4d;
      }

      .form-input::placeholder {
        color: #888;
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
    </style>
  </head>
  <body>
    <div class="login-container">
      <div class="left-section">
        <a href="arab.php">
          <img src="../assets/icons/arablogo.png" alt="logo" class="logo" />
        </a>
        <div class="welcome-text">
          <h1>مرحباً</h1>
          <p>أدخل بياناتك الشخصية و</p>
          <p>ابدأ رحلتك معنا</p>
        </div>
        <img
          src="../assets/images/logpers.png"
          alt="Welcome Person"
          class="person-image"
        />
      </div>

      <div class="right-section">
      <form class="login-form" method="POST" action="">
          <h2 class="login-title">سجل الآن</h2>
  <?php if (!empty($errors)): ?>
          <div class="errors">
            <?php foreach ($errors as $error): ?>
              <p><?= htmlspecialchars($error) ?></p>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
          <div class="form-group">
            <input
              type="text"
              class="form-input"
              name="username"
              placeholder="اسم المستخدم"
              required
            />
          </div>

          <div class="form-group">
            <input
              type="email"
              class="form-input"
              name="email"
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

          <button type="submit" class="login-button">سجل الآن</button>

          <div class="signup-link">
            <a href="arablogin.php">تسجيل الدخول</a>
          </div>
        </form>
      </div>
    </div>

   
  </body>
</html>
