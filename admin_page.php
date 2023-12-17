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
  <style>
    body {
      padding: 20px;
    }

    h1 {
      margin-bottom: 20px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    table,
    th,
    td {
      border: 2px solid #dee2e6;
    }

    th,
    td {
      padding: 10px;
      text-align: left;
    }

    th {
      background-color: #f8f9fa;
    }

    td a {
      margin-right: 10px;
    }
  </style>
</head>

<body>

  <div class="container">
    <h1 class="mt-3">Admin Page</h1>
    <p>Welcome, <?php echo $_SESSION['username']; ?></p>
    <a href="?logout" class="btn btn-danger">Logout</a>
    <div class="my-3">
      <form method="GET" action="admin_page.php">
        <div class="input-group">
          <input type="text" class="form-control" placeholder="Search by username" name="search" />
          <button type="submit" class="btn btn-primary">Search</button>
        </div>
      </form>
    </div>

    <table class="table">
      <thead>
        <tr>
          <th>Username</th>
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
            // role
            echo "<td" . ($row['role'] == 'admin' ? ' style="font-weight: bold; color: blue;"' : '') . ">" . $row['role'] . "</td>";
            // add row for delete
            echo "<td><a href='./process/delete_user.php?delete=" . $row['id_user'] . "' class='btn btn-danger'>Delete</a>";
            // change role
            $searchQuery = isset($_GET['search']) ? $_GET['search'] : '';
            echo "<a href='admin_page.php?change=" . $row['id_user'] . "&search=" . $searchQuery . "' class='btn btn-primary'>Change Role</a></td>";

            echo "</tr>";
          }
        } else {
          echo "<tr><td colspan='3'>No users found</td></tr>";
        }
        ?>
      </tbody>
    </table>
  </div>

  <!-- Bootstrap JS and Popper.js -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

</body>

</html>