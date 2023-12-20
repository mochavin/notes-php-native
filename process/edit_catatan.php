<?php


if (isset($_GET['logout'])) {
  session_destroy();
  unset($_SESSION['username']);
  header("Location: ../login.php");
  exit;
}
// import connect.php
require_once('../connect.php');
session_start();

// Declare $id_note as a global variable
$id_note = null;

if (!isset($_SESSION['username'])) {
  header("Location: ../login.php");
  exit;
}

// Fetch the note details for pre-filling the form
if (isset($_GET['id_note'])) {
  $id_note = $_GET['id_note'];

  // Fetch the note details
  $sql = "SELECT * FROM note WHERE id_note = '$id_note'";
  $result = $mysqli->query($sql);

  // Check if the note exists
  if ($result->num_rows > 0) {
    // Get title and content
    $note = $result->fetch_assoc();
  } else {
    // If the note doesn't exist, redirect to index.php
    header("Location: ../index.php");
    exit;
  }
} else {
  // If no id_note is provided, redirect to index.php
  header("Location: ../index.php");
  exit;
}

// Check if the 'edit' parameter is set in the form action
if (isset($_GET['edit'])) {
  // if isset edit
  if (isset($_POST['edit'])) {
    // get id_note, title, and content
    $id_note = $_POST['id_note'];
    $title = $_POST['title'];
    $content = $_POST['content'];

    // update note
    $sql = "UPDATE note SET title = '$title', content = '$content' WHERE id_note = '$id_note'";
    $result = $mysqli->query($sql);

    // Check if the query was successful
    if ($result) {
      // Redirect to index.php
      header("Location: ../index.php");
      exit;
    } else {
      // Print the error and handle it appropriately
      echo "Error updating record: " . $mysqli->error;
    }
  }
}
if (isset($_POST['deleteUser'])) {
  $usernameToDelete = $_POST['usernameToDelete'];

  // Get the user ID based on the username
  $getUserIDQuery = "SELECT id_user FROM user WHERE username = '$usernameToDelete'";
  $userIDResult = $mysqli->query($getUserIDQuery);

  if ($userIDResult->num_rows > 0) {
    $userIDRow = $userIDResult->fetch_assoc();
    $userID = $userIDRow['id_user'];

    // Delete the user's access from user_note table
    $deleteAccessQuery = "DELETE FROM user_note WHERE id_user = '$userID' AND id_note = '$id_note'";
    $deleteAccessResult = $mysqli->query($deleteAccessQuery);

    if ($deleteAccessResult) {

      header("Location: ./edit_catatan.php?edit&id_note=" . $note['id_note']);
      exit;
    } else {
      echo "Error deleting user access: " . $mysqli->error;
    }
  } else {
    echo "User not found.";
  }
}

// Fetch access details based on $id_note
$accesssql = "SELECT u.username FROM user_note un
              JOIN user u ON un.id_user = u.id_user
              WHERE un.id_note='$id_note'";
$accessresult = $mysqli->query($accesssql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Edit Catatan</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/header.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>

<body class="light">
  <?php include '../header.php'; ?>
  <div class="container mt-5">
    <h2 class='admin-title text-center'>Edit Catatan</h2>
    <form action="./edit_catatan.php?edit&id_note=<?php echo $note['id_note']; ?>" method="post">
      <input type="hidden" name="id_note" value="<?php echo $note['id_note']; ?>">
      <div class="mb-3">
        <label for="title" class="form-label">Title</label>
        <input type="text" class="form-control" name="title" placeholder="Title" value="<?php echo $note['title']; ?>" required>
      </div>
      <div class="mb-3">
        <label for="content" class="form-label">Content</label>
        <textarea class="form-control" name="content" placeholder="Content" style="height: 200px;" required><?php echo $note['content']; ?></textarea>
      </div>
      <button type="submit" class="btn btn-success save-button" name="edit">Save Changes</button>
    </form>
  </div>

  <div class="container mt-5">
    <h2 class='admin-title '>Access List</h2>
    <table class="table">
      <thead>
        <tr>
          <th scope="col">Name</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
        // Loop through the result set obtained from user_note table
        while ($accessRow = $accessresult->fetch_assoc()) {
          echo '<tr>';
          echo '<td>' . $accessRow['username'] . '</td>';
          echo '<td>
                    <form method="post" action="">
                        <input type="hidden" name="usernameToDelete" value="' . $accessRow['username'] . '">
                        <button type="submit" class="btn btn-danger" name="deleteUser">Delete</button>
                    </form>
                </td>';
          echo '</tr>';
        }
        ?>
      </tbody>
    </table>
  </div>

  <div class="container mt-5">
    <h2 class="admin-tit">Tambahkan Akses</h2>
    <form id="addUserAccessForm">
      <input type="hidden" name="id_note" value="<?php echo $note['id_note']; ?>">

      <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" class="form-control" name="username" id="username" placeholder="" required>
      </div>

      <button type="button" class="btn btn-primary acess" id="addUserAccessBtn">Tambahkan Akses</button>
    </form>
  </div>



  <script>
    $(document).ready(function() {
      $("#addUserAccessBtn").click(function() {
        // get id_note
        var id_note = $("input[name='id_note']").val();
        var username = $("#username").val();

        // ajax
        $.ajax({
          url: "./add_user_access.php",
          type: "POST",
          data: {
            id_note: id_note,
            username: username
          },
          success: function(result) {
            alert(result.message);
            location.reload();
          }
        });
      });
    });
  </script>




  <!-- Bootstrap JS and Popper.js -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>

</html>