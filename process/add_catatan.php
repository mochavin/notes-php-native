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
if (!isset($_SESSION['username'])) {
  header("Location: ../login.php");
  exit;
}

// if isset add
if (isset($_GET['add'])) {
  // get username
  $username = $_POST['username'];
  // get title and content
  $title = $_POST['title'];
  $content = $_POST['content'];

  // insert note
  $sql = "INSERT INTO note (title, content) VALUES ('$title', '$content')";
  $result = $mysqli->query($sql);

  // get note id
  $sql = "SELECT id_note FROM note WHERE title = '$title' AND content = '$content'";
  $result = $mysqli->query($sql);
  $row = $result->fetch_assoc();
  $id_note = $row['id_note'];

  // get user id
  $sql = "SELECT id_user FROM user WHERE username = '$username'";
  $result = $mysqli->query($sql);
  $row = $result->fetch_assoc();
  $id_user = $row['id_user'];

  // insert user_note
  $sql = "INSERT INTO user_note (id_user, id_note) VALUES ('$id_user', '$id_note')";
  $result = $mysqli->query($sql);

  // redirect to index.php
  header("Location: ../index.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Add Catatan</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/header.css">
</head>

<body class="light">
  <?php include '../header.php'; ?>
  <div class="container mt-5">
    <h2 class='admin-title text-center'>Add Catatan</h2>
    <form action="./add_catatan.php?add" method="post">
      <input type="hidden" name="username" value="<?php echo $_SESSION['username']; ?>">
      <div class="mb-3">

        <label for="title" class="form-label">Title</label>
        <input type="text" class="form-control" name="title" placeholder="Title" required>
      </div>
      <div class="mb-3">
        <label for="content" class="form-label">Content</label>
        <textarea class="form-control" name="content" placeholder="Content" style="height: 200px;" required></textarea>
      </div>
      <button type="submit" class="btn btn-primary">Add</button>
    </form>
  </div>
  <!-- <?php include "../footer.php"
        ?> -->
  <!-- Bootstrap JS and Popper.js -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

</body>

</html>