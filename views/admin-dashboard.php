<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Tripzly | Admin Dashboard</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Poppins', sans-serif;
      display: flex;
      background-color: #f4f4f4;
      color: #333;
      min-height: 100vh;
    }

    .sidebar {
      width: 250px;
      background-color: #003366;
      color: white;
      display: flex;
      flex-direction: column;
      padding: 2rem 1.5rem;
      height: 100vh;
      position: fixed;
      left: 0;
      top: 0;
    }

    .sidebar h2 {
      margin-bottom: 2rem;
      font-size: 1.5rem;
    }

    .sidebar a {
      text-decoration: none;
      color: white;
      margin-bottom: 1rem;
      display: block;
      font-weight: 500;
      padding: 0.75rem 1rem;
      border-radius: 6px;
      transition: background 0.3s;
    }

    .sidebar a:hover,
    .sidebar a.active {
      background-color: #000266;
    }

    .main {
      margin-left: 250px;
      flex: 1;
      padding: 2rem 3rem;
    }

    .main h1 {
      font-size: 2rem;
      color: #003366;
      margin-bottom: 1.5rem;
    }

    .card {
      background-color: white;
      border-radius: 10px;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.06);
      padding: 2rem;
      margin-bottom: 2rem;
    }

    .card h3 {
      margin-bottom: 1rem;
      color: #000cb3;
      font-size: 1.2rem;
    }

    .stats-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
      gap: 1rem;
    }

    .stat-box {
      background-color: #e6f6ff;
      border: 1px solid #b3d6ff;
      padding: 1rem;
      border-radius: 8px;
    }

    .stat-title {
      font-size: 0.9rem;
      color: #000899;
    }

    .stat-value {
      font-size: 1.5rem;
      font-weight: 600;
      margin-top: 0.5rem;
    }

    .btn-group {
      margin-top: 1.5rem;
      display: flex;
      flex-wrap: wrap;
      gap: 1rem;
    }

    .btn {
      background-color: #003366;
      color: white;
      padding: 0.75rem 1.25rem;
      border: none;
      border-radius: 6px;
      font-size: 0.95rem;
      cursor: pointer;
      transition: background 0.3s;
    }

    .btn:hover {
      background-color: #080099;
    }

    @media (max-width: 768px) {
      .main {
        margin-left: 0;
        padding: 1.5rem;
      }

      .sidebar {
        position: relative;
        width: 100%;
        height: auto;
        flex-direction: row;
        justify-content: space-around;
      }

      .sidebar h2 {
        display: none;
      }

      .sidebar a {
        margin: 0.5rem;
        padding: 0.5rem;
      }
    }
  </style>
</head>
<body>

  <div class="sidebar">
    <h2>Tripzly Admin</h2>
    <a href="admin-dashboard.php" class="active">Dashboard</a>
    <a href="/tripzly_test/manage_users">Manage Users</a>
    <a href="/tripzly_test/manage_businesses">Manage Businesses</a>
    <a href="/tripzly_test/manage_listings">Manage Listings</a>
    <a href="#" onclick="confirmLogout()">Logout</a>
  </div>

  <div class="main">
    <h1>Admin Dashboard</h1>

    <div class="card">
      <h3>Platform Overview</h3>
      <div class="stats-grid">
        <div class="stat-box">
  <div class="stat-title">Total Users</div>
  <div class="stat-value"><?= number_format($dashboardStats['totalUsers']) ?></div>
</div>
<div class="stat-box">
  <div class="stat-title">Registered Businesses</div>
  <div class="stat-value"><?= number_format($dashboardStats['registeredBusinesses']) ?></div>
</div>

<div class="stat-box">
  <div class="stat-title">Pending Approvals</div>
  <div class="stat-value"><?= number_format($dashboardStats['pendingApprovals']) ?></div>
</div>

      </div>
    </div>

    <div class="card">
      <h3>Quick Actions</h3>
      <div class="btn-group">
        <button class="btn" onclick="location.href='/tripzly_test/manage_users'">Manage Users</button>
        <button class="btn" onclick="location.href='/tripzly_test/manage_businesses'">Manage Businesses</button>
        <button class="btn" onclick="location.href='/tripzly_test/manage_listings'">Approve Listings</button>
      
      </div>
    </div>
  </div>

  <script>
    function confirmLogout() {
      if (confirm("Are you sure you want to logout?")) {
        window.location.href = "/tripzly_test/logout";
      }
    }
  </script>

</body>
</html>
