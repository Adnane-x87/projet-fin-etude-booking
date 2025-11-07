<?php
include "../includes/db.php"; 
$halls = $pdo->query("SELECT * FROM hall")->fetchAll();
$stmt = $pdo->query("SELECT COUNT(*) FROM hall");
$totalHalls = $stmt->fetchColumn();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Hallane - Dashboard</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
      background-color: #f8f9fa;
      display: flex;
      height: 100vh;
    }

    .sidebar {
      width: 200px;
      background-color: #2d5a3d;
      color: white;
      padding: 20px 0;
      position: fixed;
      height: 100vh;
      overflow-y: auto;
    }

    .logo {
      width: 125px;
      height: auto;
      margin-top: -16px;
    }

    .nav-item {
      padding: 12px 20px;
      cursor: pointer;
      display: flex;
      align-items: center;
      gap: 12px;
      transition: background 0.2s;
      font-size: 14px;
    }

    .nav-item:hover {
      background: rgba(255, 255, 255, 0.1);
    }

    .nav-item.active {
      background: rgba(255, 255, 255, 0.15);
      border-right: 3px solid white;
    }

    .user-info {
      position: absolute;
      bottom: 20px;
      left: 20px;
      display: flex;
      align-items: center;
      gap: 10px;
      font-size: 12px;
    }

    .user-avatar {
      width: 32px;
      height: 32px;
      border-radius: 50%;
      background: #22543d;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 14px;
    }

    .main-content {
      margin-left: 200px;
      flex: 1;
      padding: 30px;
      overflow-y: auto;
      position: relative;
    }

    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 30px;
    }

    .header h1 {
      font-size: 28px;
      font-weight: 600;
      color: #2d3748;
    }

    .header p {
      color: #718096;
      font-size: 14px;
      margin-top: 4px;
    }

    .header-actions {
      display: flex;
      gap: 15px;
    }

    .header-actions button {
      background: none;
      border: none;
      font-size: 18px;
      cursor: pointer;
      padding: 8px;
      border-radius: 8px;
      transition: background 0.2s;
      color: #4a5568;
    }

    .header-actions button:hover {
      background: #e2e8f0;
    }

    /* ✅ Stats Cards - Simple Flex Layout */
    .stats-container {
      display: flex;
      gap: 20px;
      margin-bottom: 30px;
    }

    .stat-card {
      background: white;
      padding: 24px;
      border-radius: 12px;
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
      display: flex;
      align-items: center;
      gap: 16px;
      flex: 1;
      height: 100px;
    }

    .stat-icon {
      width: 48px;
      height: 48px;
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 20px;
    }

    .stat-icon.bookings { background: #e6f3e6; color: #2d5a3d; }
    .stat-icon.halls { background: #ffe6f0; color: #c53030; }
    .stat-icon.revenue { background: #e6f7e6; color: #22543d; }
    .stat-icon.clients { background: #fff2e6; color: #c05621; }

    .stat-info h3 {
      font-size: 24px;
      font-weight: 700;
      color: #2d3748;
      margin-bottom: 4px;
    }

    .stat-info p {
      color: #718096;
      font-size: 14px;
    }

    /* Table & Buttons */
    table {
      width: 100%;
      border-collapse: collapse;
    }

    th, td {
      padding: 14px;
      text-align: left;
      border-bottom: 1px solid #e2e8f0;
    }

    th {
      background: #2d5a3d;
      color: white;
    }

    tr:hover {
      background-color: #f1f5f9;
    }

    .delete-btn {
      background: #e53e3e;
      color: white;
      border: none;
      padding: 6px 12px;
      border-radius: 4px;
      font-size: 13px;
      cursor: pointer;
      text-decoration: none;
    }

    .halls-section {
      background: white;
      border-radius: 12px;
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
      overflow: hidden;
      margin-bottom: 30px;
    }

    .halls-header {
      padding: 24px;
      border-bottom: 1px solid #e2e8f0;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .halls-header h3 {
      font-size: 18px;
      font-weight: 600;
      color: #2d3748;
    }

    .add-hall-btn {
      background: #4299e1;
      color: white;
      border: none;
      padding: 8px 16px;
      border-radius: 6px;
      font-size: 14px;
      cursor: pointer;
      display: flex;
      text-decoration: none;
      align-items: center;
      gap: 6px;
    }
    .logout-btn {
     background: #e53e3e;
     color: white;
     padding: 8px 14px;
     border-radius: 8px;
     font-size: 14px;
     text-decoration: none;
}
  </style>
</head>
<body>
  <div class="sidebar">
    <img src="../../assets/icons/hallane.png" alt="logo" class="logo" />
    <div class="nav-item active">
      <i class="fas fa-chart-pie"></i> Dashboard
    </div>
    <a href="../pages/booking.php" class="nav-item" style="color: white; text-decoration: none;">
      <i class="fas fa-calendar-check"></i> Bookings
    </a>
    <a href="client.php" class="nav-item" style="color: white; text-decoration: none;">
      <i class="fas fa-users"></i> Clients
    </a>
    <div class="user-info">
      <div class="user-avatar">AK</div>
      <div>
        <div style="font-weight: 600">adnane kesksuu</div>
        <div style="color: #a0aec0">Admin</div>
      </div>
    </div>
  </div>

  <div class="main-content">
    <div class="header">
      <div>
        <h1>Dashboard</h1>
        <p>Overview of your hall rental website</p>
      </div>
      <div class="header-actions">
        <button><i class="fas fa-bell"></i></button>
        <button><i class="fas fa-envelope"></i></button>
        <a href="../pages/logout.php" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</a>

      </div>
    </div>

    <!-- ✅ Stats Cards Section -->
    <div class="stats-container">
      <div class="stat-card">
        <div class="stat-icon bookings"><i class="fas fa-chart-bar"></i></div>
        <div class="stat-info">
          <h3>143</h3>
          <p>Active Bookings</p>
        </div>
      </div>
      <div class="stat-card">
        <div class="stat-icon halls"><i class="fas fa-building"></i></div>
        <div class="stat-info">
          <h3><?= $totalHalls ?></h3>
          <p>Total Halls</p>
        </div>
      </div>
      <div class="stat-card">
        <div class="stat-icon revenue"><i class="fas fa-dollar-sign"></i></div>
        <div class="stat-info">
          <h3>$7,850</h3>
          <p>Revenue (this month)</p>
        </div>
      </div>
    
    </div>

    <!-- ✅ Halls Table Section -->
    <div class="halls-section">
      <div class="halls-header">
        <h3>Available Halls</h3>
        <a href="add.php" class="add-hall-btn"><i class="fas fa-plus"></i> Add New Hall</a>
      </div>
      <table>
        <thead>
          <tr>
            <th>Hall Name</th>
            <th>Location</th>
            <th>Capacity</th>
            <th>Price</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($halls as $hall): ?>
            <tr>
              <td><?= htmlspecialchars($hall['title']) ?></td>
              <td><?= htmlspecialchars($hall['local']) ?></td>
              <td><?= htmlspecialchars($hall['capacity']) ?></td>
              <td><?= htmlspecialchars($hall['price']) ?>DH</td>
              <td><span class="status">Available</span></td>
              <td>
                <a class="delete-btn" href="delete.php?hall_id=<?= $hall['hall_id'] ?>" onclick="return confirm('Are you sure?');">Delete</a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>
