<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Tripzly Admin - Manage Users</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 20px;
      background-color: #f5f7fa;
    }

    h1 {
      text-align: center;
      color: #333;
    }

    .search-box {
      max-width: 400px;
      margin: 20px auto;
      display: flex;
    }

    .search-box input {
      width: 100%;
      padding: 10px;
      border: 1px solid #bbb;
      border-radius: 5px;
      font-size: 16px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      background-color: #fff;
      margin-top: 20px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    th, td {
      padding: 12px;
      border-bottom: 1px solid #eee;
      text-align: center;
      font-size: 15px;
    }

    th {
      background-color: #1e90ff;
      color: white;
    }

    .action-btn {
      padding: 6px 10px;
      margin: 0 2px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-size: 14px;
    }

    .edit-btn {
      background-color: #4caf50;
      color: white;
    }

    .deactivate-btn {
      background-color: #ff9800;
      color: white;
    }

    .delete-btn {
      background-color: #f44336;
      color: white;
    }

    @media (max-width: 768px) {
      table, thead, tbody, th, td, tr {
        display: block;
      }

      th {
        position: sticky;
        top: 0;
        background: #1e90ff;
      }

      tr {
        margin-bottom: 15px;
        border: 1px solid #ddd;
      }

      td {
        text-align: right;
        padding-left: 50%;
        position: relative;
      }

      td::before {
        content: attr(data-label);
        position: absolute;
        left: 10px;
        text-align: left;
        font-weight: bold;
      }
    }
  </style>
</head>
<body>

  <h1>Manage Users - Tripzly</h1>

  <div class="search-box">
  <input type="text" id="userSearch" placeholder="Search by name or email...">
  </div>
<table>
  <thead>
    <tr>
      <th>User ID</th>
      <th>Full Name</th>
      <th>Address</th>
      <th>Email</th>
      <th>Contact</th>
      <th>Role</th>
      <th>Status</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody id="userTableBody">
    <?php include 'partials/user_rows.php'; ?>  
     <!-- it is going to be populated here -->
  </tbody>
</table>

  <script>

    function deleteUser(userID) {
      if (confirm("Are you sure you want to permanently delete user ID " + userID + "?")) {
        fetch('/tripzly_test/delete_user', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
      },
      body: 'userID=' + encodeURIComponent(userID)
    })
    .then(response => response.text())
    .then(data => {
      alert(data);
      location.reload(); 
    })
    .catch(error => {
      alert('Error: ' + error);
    });
  }
    }

      document.getElementById('userSearch').addEventListener('input', function () {
    const searchTerm = this.value;

    fetch('/tripzly_test/search_users', {
      method: 'POST',
      headers: {'Content-Type': 'application/x-www-form-urlencoded'},
      body: 'search=' + encodeURIComponent(searchTerm)
    })
    .then(res => res.text())
    .then(html => {
      document.getElementById('userTableBody').innerHTML = html;
    })
    .catch(err => console.error('Search error:', err));
  });
  </script>

</body>
</html>
