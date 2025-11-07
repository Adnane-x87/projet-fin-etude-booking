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

        // If password is hashed, use password_verify
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['user_type'] = 'client';
            header('Location: index.php');
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
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link
  href="https://fonts.googleapis.com/css2?family=ADLaM+Display&display=swap"
  rel="stylesheet"
/>
<title>Log In - Hallane</title>
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
    left: 0;
    background-color: #2d4930;
    color: white;
    padding: 60px;
  }

  .logo {
    width: 150px;
    position: absolute;
    top: 3px;
    left: 24px;
  }

  .welcome-text {
    position: absolute;
    top: 130px;
    left: 60px;
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
    bottom: 0px;
    left: 170px;
    width: 700px;
    height: auto;
    object-fit: contain;
  }

  .right-section {
    width: 50%;
    height: 100%;
    position: absolute;
    top: 0;
    right: 0;
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
  }

  .message {
    margin-bottom: 20px;
    padding: 12px 15px;
    border-radius: 8px;
    text-align: center;
    font-weight: bold;
  }
  .message.error {
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
  }
  .message.success {
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
  }
</style>
</head>
<body>
<div class="login-container">
  <div class="left-section">
    <a href="index.php">
      <img src="../assets/icons/hallane.png" alt="logo" class="logo" />
    </a>
    <div class="welcome-text">
      <h1>Welcome</h1>
      <p>Enter your personal details and</p>
      <p>start journey with us</p>
    </div>
    <img
      src="../assets/images/logpers.png"
      alt="Welcome Person"
      class="person-image"
    />
  </div>

  <div class="right-section">
    <form class="login-form" method="POST" action="">
      <h2 class="login-title">LOG IN</h2>

      <?php if ($message): ?>
        <div class="message <?php echo htmlspecialchars($messageType); ?>">
          <?php echo htmlspecialchars($message); ?>
        </div>
      <?php endif; ?>

      <div class="form-group">
        <input
          type="email"
          name="email"
          class="form-input"
          placeholder="Email"
          required
          value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"
        />
      </div>

      <div class="form-group">
        <input
          type="password"
          name="password"
          class="form-input"
          placeholder="Password"
          required
        />
      </div>

      <div class="forgot-password">
        <a href="#">Forgot your password?</a>
      </div>

      <div class="signup-link">
        <a href="signup.php">Sign up</a>
      </div>

      <button type="submit" class="login-button">Log In</button>
    </form>
  </div>
</div>
</body>
</html>
