<?php
include "../includes/db.php";

$query = "
SELECT 
    r.*, 
    h.title AS hall_name 
FROM 
    reserve r
JOIN 
    hall h ON r.hall_id = h.hall_id
ORDER BY 
    r.date DESC
";

$bookings = $pdo->query($query)->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Dashboard - Bookings</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <style>
    body {
      font-family: sans-serif;
      background-color: #f0f2f5;
      padding: 30px;
    }
    h1 {
      margin-bottom: 20px;
      color: #2d3748;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      background: white;
      box-shadow: 0 0 10px rgba(0,0,0,0.05);
    }
    th, td {
      padding: 12px 15px;
      border: 1px solid #e2e8f0;
      text-align: left;
    }
    th {
      background: #2d5a3d;
      color: white;
    }
    tr:hover {
      background: #f7fafc;
    }
  </style>
</head>
<body>

  <h1><i class="fa-regular fa-file"></i> All Reservations</h1>

  <table>
    <thead>
      <tr>
        <th>#</th>
        <th>Client Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Hall</th>
        <th>Date</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($bookings as $b): ?>
        <tr>
          <td><?= htmlspecialchars($b['id_reserve']) ?></td>
          <td><?= htmlspecialchars($b['first_name'] . ' ' . $b['last_name']) ?></td>
          <td><?= htmlspecialchars($b['email']) ?></td>
          <td><?= htmlspecialchars($b['number']) ?></td>
          <td><?= htmlspecialchars($b['hall_name']) ?></td>
          <td><?= htmlspecialchars($b['date']) ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

</body>
</html>
