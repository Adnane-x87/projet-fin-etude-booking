<?php
require_once '../includes/db.php';

$errors = [];
$success = "";

$hall_id = $_GET['hall_id'] ?? '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name = trim($_POST['last_name'] ?? '');
    $number = trim($_POST['number'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $submitted_hall_id = trim($_POST['hall_id'] ?? '');
    $client_id = trim($_POST['client_id'] ?? '');
    $date = trim($_POST['date'] ?? '');

    $final_hall_id = !empty($submitted_hall_id) ? $submitted_hall_id : $hall_id;

    if (empty($first_name) || empty($last_name) || empty($number) || empty($email) || empty($final_hall_id) || empty($client_id) || empty($date)) {
        $errors[] = "All fields are required.";
    }

    if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please enter a valid email address.";
    }

    if (!empty($date) && strtotime($date) < strtotime('today')) {
        $errors[] = "Please select a future date.";
    }

    if (empty($errors)) {
        $sql = "INSERT INTO reserve (first_name, last_name, number, email, hall_id, client_id, date)
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$first_name, $last_name, $number, $email, $final_hall_id, $client_id, $date]);
            $success = "Reservation saved successfully!";
            $first_name = $last_name = $number = $email = $date = '';
        } catch (PDOException $e) {
            $errors[] = "Error while saving: " . $e->getMessage();
        }
    }
    
    $hall_id = $final_hall_id;
}

$selected_hall_name = '';
if ($hall_id) {
    $stmt = $pdo->prepare('SELECT title FROM hall WHERE hall_id = ?');
    $stmt->execute([$hall_id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row) {
        $selected_hall_name = $row['title'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Venue Booking</title>
    <link
      href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;600;700&display=swap"
      rel="stylesheet"
    />
    <script src="../assets/js/main.js"></script>

    <style>
      body {
        margin: 0;
        font-family: "Rubik", sans-serif;
        background-color: #ffffff;
      }

      header {
        background-color: #2d4930;
        height: 70px;
        padding: 0 2rem;
        display: flex;
        align-items: center;
      }

      .logo {
        width: 150px;
        height: auto;
        margin-top: 36px;
      }

      .container {
        text-align: center;
        padding: 2rem;
      }

      .container h2 {
        font-size: 2.2rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
      }

      .container p {
        font-weight: 600;
        margin-bottom: 2rem;
        font-size: 1rem;
      }

      .selected-hall {
        background-color: #f0f8f0;
        color: #2d4930;
        padding: 1rem;
        border-radius: 6px;
        margin-bottom: 1rem;
        font-weight: 600;
      }

      form {
        max-width: 700px;
        margin: 0 auto;
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        justify-content: center;
      }

      input,
      select {
        padding: 1rem;
        border: 2px solid #2d4930;
        border-radius: 6px;
        font-weight: 600;
        background-color: #d8d8d8;
        color: #2d4930;
        font-size: 1rem;
        flex: 1 1 300px;
      }

      input::placeholder {
        color: #2d4930;
        opacity: 1;
      }

      select {
        appearance: none;
      }

      .full-width {
        flex: 1 1 100%;
      }

      button {
        background-color: #2d4930;
        color: white;
        font-size: 1.2rem;
        font-weight: 700;
        padding: 0.8rem 2rem;
        border: none;
        border-radius: 999px;
        margin-top: 1.5rem;
        cursor: pointer;
      }

      button:hover {
        opacity: 0.95;
      }

      .error {
        background-color: #ffebee;
        color: #c62828;
        padding: 1rem;
        border-radius: 6px;
        margin-bottom: 1rem;
        border: 1px solid #ffcdd2;
      }

      .success {
        background-color: #e8f5e8;
        color: #2e7d32;
        padding: 1rem;
        border-radius: 6px;
        margin-bottom: 1rem;
        border: 1px solid #c8e6c9;
      }

      .error p, .success p {
        margin: 0;
      }
    </style>
  </head>
  <body>
    <header>
      <a href="index.php"
        ><img src="../assets/icons/hallane.png" alt="logo" class="logo"
      /></a>
    </header>

    <div class="container">
      <h2>Reserve now</h2>
      
      <?php if ($selected_hall_name): ?>
        <div class="selected-hall">
          Selected Hall: <?= htmlspecialchars($selected_hall_name) ?>
        </div>
      <?php endif; ?>

      <?php if (!empty($errors)): ?>
        <div class="error">
          <?php foreach ($errors as $error): ?>
            <p><?= htmlspecialchars($error) ?></p>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>

      <?php if ($success): ?>
        <div class="success">
          <p><?= htmlspecialchars($success) ?></p>
        </div>
      <?php endif; ?>
      
      <p>Complete the form below to book your venue</p>

      <form method="POST" action="">
        <input type="text" name="first_name" placeholder="First name" value="<?= htmlspecialchars($first_name ?? '') ?>" required />
        <input type="text" name="last_name" placeholder="Last name" value="<?= htmlspecialchars($last_name ?? '') ?>" required />
        <input type="tel" name="number" placeholder="Phone number" value="<?= htmlspecialchars($number ?? '') ?>" required />
        <input type="email" name="email" placeholder="Email" value="<?= htmlspecialchars($email ?? '') ?>" required />
        <input type="date" name="date" value="<?= htmlspecialchars($date ?? '') ?>" min="<?= date('Y-m-d') ?>" required />
        
        <select name="hall_id" class="full-width" required readonly>
          <?php if ($hall_id && $selected_hall_name): ?>
            <option value="<?= htmlspecialchars($hall_id) ?>" selected><?= htmlspecialchars($selected_hall_name) ?></option>
          <?php else: ?>
            <option value="">▶ Select Hall</option>
          <?php endif; ?>
        </select>
        
        <input type="hidden" name="client_id" value="1">
        <button type="submit">Reserve</button>
      </form>
    </div>
  </body>
</html>