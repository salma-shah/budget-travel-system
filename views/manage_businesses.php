<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Tripzly Admin - Manage Businesses</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #f0f4f8;
      padding: 20px;
    }

    h1 {
      text-align: center;
      color: #222;
    }

    .search-box {
      max-width: 400px;
      margin: 20px auto;
      display: flex;
    }

    .search-box input {
      width: 100%;
      padding: 10px;
      font-size: 16px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      background-color: white;
      margin-top: 20px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }

    th, td {
      padding: 12px;
      border-bottom: 1px solid #eee;
      text-align: center;
      font-size: 15px;
    }

    th {
      background-color: #0077cc;
      color: white;
    }

    .action-btn {
      padding: 6px 10px;
      margin: 2px;
      border: none;
      border-radius: 4px;
      font-size: 14px;
      cursor: pointer;
    }

    .view-btn {
      background-color: #00bcd4;
      color: white;
    }

    .status-btn {
      background-color: #ff9800;
      color: white;
    }

    .delete-btn {
      background-color: #e53935;
      color: white;
    }

    @media (max-width: 768px) {
      table, thead, tbody, th, td, tr {
        display: block;
      }

      th {
        display: none;
      }

      tr {
        margin-bottom: 15px;
        border: 1px solid #ccc;
        background: white;
      }

      td {
        text-align: right;
        padding-left: 50%;
        position: relative;
        border: none;
        border-bottom: 1px solid #eee;
      }

      td::before {
        content: attr(data-label);
        position: absolute;
        left: 15px;
        font-weight: bold;
        text-align: left;
      }
    }
  </style>
</head>
<body>

  <h1>Manage Businesses - Tripzly</h1>

  <div class="search-box">
    <input type="text" id="searchBusiness" placeholder="Search by business name or email..." />
    </div>
    <table>
  <thead>
    <tr>
      <th>Business ID</th>
      <th>Organization Name</th>
      <th>Contact</th>
      <th>Address</th>
      <th>Email</th>
      <th>Role</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody id="userTableBody">
    <?php include 'partials/businesses_rows.php'; ?>  
     <!-- it is going to be populated here -->
  </tbody>
</table>
</div>

 

  <script>
     document.getElementById('searchBusiness').addEventListener('input', function () {
    const searchTerm = this.value;

    fetch('/tripzly_test/search_businesses', {
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
  
    function toggleBusinessStatus(id) {
      const statusCell = document.getElementById("status-" + id);
      const currentStatus = statusCell.textContent.trim();
      const button = event.target;

      if (currentStatus === "Pending" || currentStatus === "Inactive") {
        if (confirm("Approve/Activate this business?")) {
          statusCell.textContent = "Active";
          button.textContent = "Deactivate";
        }
      } else if (currentStatus === "Active") {
        if (confirm("Deactivate this business?")) {
          statusCell.textContent = "Inactive";
          button.textContent = "Activate";
        }
      }
    }

    function deleteBusiness(userID) {
      if (confirm("Are you sure you want to delete business ID: " + userID + "?")) {
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
      alert('There was an error: ' + error);
    });
  }
    }
  </script>

</body>
</html>
