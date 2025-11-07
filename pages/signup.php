<?php
// Connect to the database
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
            header("Location: login.php"); // Redirect to login page after success
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
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Sign Up - Hallane</title>
  <style>
    /* Basic styling */
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      height: 100vh;
      background-color: #f4f4f4;
    }

    .container {
      display: flex;
      height: 100vh;
    }

    .left {
      width: 50%;
      background-color: #2d4930;
      color: white;
      padding: 60px;
      position: relative;
    }

    .left h1 {
      font-size: 3rem;
    }

    .right {
      width: 50%;
      background-color: white;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 60px;
    }

    .form-container {
      width: 100%;
      max-width: 400px;
    }

    .form-container h2 {
      color: #2d4930;
      text-align: center;
      margin-bottom: 30px;
    }

    .form-group {
      margin-bottom: 20px;
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
      border-color: #4a6b4d;
      outline: none;
    }
  .person-image {
        position: absolute;
        bottom: 0px;
        left: 250px;
        width: 700px;
        height: auto;
        object-fit: contain;
      }

    .login-button {
      width: 100%;
      padding: 12px;
      background-color: #2d4930;
      color: white;
      border: none;
      border-radius: 25px;
      font-size: 1rem;
      font-weight: bold;
      cursor: pointer;
    }

    .login-button:hover {
      background-color: #1f3422;
    }

    .errors {
      background-color: #ffdddd;
      border: 1px solid red;
      padding: 10px;
      margin-bottom: 20px;
      border-radius: 5px;
      color: red;
    }

    .signup-link {
      text-align: center;
      margin-top: 15px;
    }

    .signup-link a {
      color: #2d4930;
      text-decoration: underline;
    }
    .right h2{
       font-size: 3rem;
    color: #2d4930;
    font-weight: bold;
    margin-bottom: 40px;
    text-align: center;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="left">
      <h1>Welcome</h1>
      <p>Enter your details and start your journey with us.</p>
          <img
          src="../assets/images/logpers.png"
          alt="Welcome Person"
          class="person-image"
        />
    </div>

    <div class="right">
      <div class="form-container">
        <h2>Sign Up</h2>

        <!-- Display errors if any -->
        <?php if (!empty($errors)): ?>
          <div class="errors">
            <?php foreach ($errors as $error): ?>
              <p><?= htmlspecialchars($error) ?></p>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>

        <!-- Sign up form -->
        <form method="POST" action="">
          <div class="form-group">
            <input type="text" name="username" class="form-input" placeholder="Username" required>
          </div>

          <div class="form-group">
            <input type="email" name="email" class="form-input" placeholder="Email" required>
          </div>

          <div class="form-group">
            <input type="password" name="password" class="form-input" placeholder="Password" required>
          </div>

          <button type="submit" class="login-button">Sign Up</button>

          <div class="signup-link">
            Already have an account? <a href="login.php">Log In</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</body>
</html>
