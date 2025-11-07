<?php
include '../includes/db.php';

try {
    $stmt = $pdo->query("SELECT user_id, username, email FROM  client");  
    $clients = $stmt->fetchAll();
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    die();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Clients - Admin Dashboard</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      padding: 30px;
      background-color: #f1f5f9;
    }
    h1 {
      margin-bottom: 20px;
      color: #2d3748;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      background-color: white;
      border-radius: 8px;
      overflow: hidden;
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    th, td {
      padding: 14px;
      text-align: left;
      border-bottom: 1px solid #e2e8f0;
    }
    th {
      background-color: #2d5a3d;
      color: white;
    }
    tr:hover {
      background-color: #f7fafc;
    }
  </style>
</head>
<body>
  <h1>Client List</h1>
  <table>
    <thead>
      <tr>
        <th>User ID</th>
        <th>Username</th>
        <th>Email</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($clients as $client): ?>
        <tr>
          <td><?= htmlspecialchars($client['user_id']) ?></td>
          <td><?= htmlspecialchars($client['username']) ?></td>
          <td><?= htmlspecialchars($client['email']) ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</body>
</html>
