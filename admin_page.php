<?php
// import connect.php
require_once('connect.php');
session_start();
if (!isset($_SESSION['username'])) {
  header("Location: login.php");
  exit;
}

if ($_SESSION['role'] == 'user') {
  header("Location: index.php");
  exit;
}

// logout user
if (isset($_GET['logout'])) {
  session_destroy();
  unset($_SESSION['username']);
  header("Location: login.php");
  exit;
}

if (isset($_GET['change'])) {
  $id_user = $_GET['change'];
  $sql = "SELECT role FROM user WHERE id_user = '$id_user'";
  $result = $mysqli->query($sql);
  $row = $result->fetch_assoc();
  $role = $row['role'];
  if ($role == 'user') {
    $sql = "UPDATE user SET role = 'admin' WHERE id_user = '$id_user'";
    $result = $mysqli->query($sql);
  } else {
    $sql = "UPDATE user SET role = 'user' WHERE id_user = '$id_user'";
    $result = $mysqli->query($sql);
  }
  $searchQuery = isset($_GET['search']) ? $_GET['search'] : '';
  header("Location: admin_page.php?search={$searchQuery}");
  exit;
}

// get all users
$sql = "SELECT * FROM user";
$result = $mysqli->query($sql);

// search user
if (isset($_GET['search'])) {
  $search = $_GET['search'];
  $sql = "SELECT * FROM user WHERE username LIKE '%$search%'";
  $result = $mysqli->query($sql);
} else {
  // get all users if no search query
  $sql = "SELECT * FROM user";
  $result = $mysqli->query($sql);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Page</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="./css/header.css">
  <style>
    h1 {
      margin-bottom: 20px;
    }

    .table-admin {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
      overflow: hidden;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
      border-radius: 10px;
      padding: 100px;
    }

    .table-admin,
    .table-admin th,
    .table-admin td {
      border: 1px solid #dee2e6;
    }

    .table-admin th,
    .table-admin td {
      padding: 10px;
      text-align: left;
      background-color: #f8f9fa;
    }

    .table-admin th {
      background-color: #f8f9fa;
    }
    
    .table-admin td a {
      margin-right: 10px;
    }

    .btn-action {
      display: flex;
      gap: 4px;
    }

    @media (max-width: 768px) {
      .btn-action {
        flex-direction: column;
      }
    }
  </style>
</head>

<body class="light">
  <?php include 'header.php'; ?>
  <div class="container">
    <h1>Admin Page</h1>
    <h3>Welcome, <span style="color:red"><?php echo $_SESSION['username']; ?></span> </h3>
    <div class="my-3">
      <form method="GET" action="admin_page.php">
        <div class="input-group">
          <input type="text" class="form-control" placeholder="Search by username" name="search" />
          <button type="submit" class="btn btn-primary">Search</button>
        </div>
      </form>
    </div>

    <table class="table-admin">
      <thead>
        <tr>
          <th>Username</th>
          <th>Password</th>
          <th>Role</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
        // if the query returned any rows
        if ($result->num_rows > 0) {
          // loop through each row
          while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            // username
            echo "<td>" . $row['username'] . "</td>";
            // password
            echo "<td>" . $row['password'] . "</td>";
            // role
            echo "<td" . ($row['role'] == 'admin' ? ' style="font-weight: bold; color: red;"' : '') . ">" . $row['role'] . "</td>";
            // change role
            $searchQuery = isset($_GET['search']) ? $_GET['search'] : '';
            echo "<td class='btn-action'><a href='admin_page.php?change=" . $row['id_user'] . "&search=" . $searchQuery . "' class='btn btn-primary'>Change Role</a>";
            // add row for delete
            echo "<a href='./process/delete_user.php?delete=" . $row['id_user'] . "' class='btn btn-danger'>Delete</a></td>";
            echo "</tr>";
          }
        } else {
          echo "<tr><td colspan='3'>No users found</td></tr>";
        }
        ?>
      </tbody>
    </table>
  </div>
  <?php include "./footer.php"
  ?>

  <!-- Bootstrap JS and Popper.js -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

</body>

</html>