<?php
// cek session
session_start();
if (!isset($_SESSION['username'])) {
  header("Location: login.php");
  exit;
}

if ($_SESSION['role'] == 'admin') {
  header("Location: admin_page.php");
  exit;
}

// logout user
if (isset($_GET['logout'])) {
  session_destroy();
  unset($_SESSION['username']);
  header("Location: login.php");
  exit;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Home</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="./css/header.css">
  <link rel="stylesheet" href="./css/note.css">
  <!-- Bootstrap JS dependencies -->
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script>
    // ajax untuk mengedit catatan
    $(document).ready(function() {
      // ketika edit button ditekan
      $(".edit").click(function() {
        // get id_note
        var id_note = $(this).attr("id");
        $.ajax({
          url: "./process/edit_catatan.php",
          type: "POST", // <-- Add a comma here
          data: {
            id_note: id_note
          }, // <-- Add a comma here
          success: function(result) {
            // Process the result if needed
          }
        });
        // redirect to edit_catatan.php with the id_note parameter
        window.location.href = "./process/edit_catatan.php?id_note=" + id_note;
      });

      // add button ditekan
      $(".btn-primary").click(function() {
        // get id_note
        var id_note = $(this).attr("id").split('_')[1];
        var username = $('#user_' + id_note).val();
        // ajax
        $.ajax({
          url: "./process/add_user_access.php",
          type: "POST",
          data: {
            id_note: id_note,
            username: username
          },
          success: function(result) {
            console.log(result);
            alert(result.message);
          }
        });
      });
    });
  </script>
</head>

<body class="light">
  <?php include 'header.php'; ?>
  <div class="container">
    <h2>Welcome, <?php echo $_SESSION['username']; ?></h2>
    <!-- Content -->
    <div class="container">
      <?php
      // import connect.php 
      require_once('connect.php');

      // get all notes
      $sql = "SELECT * FROM user 
                  JOIN user_note ON user.id_user = user_note.id_user
                  JOIN note ON  user_note.id_note = note.id_note 
                  WHERE user.username = '" . $_SESSION['username'] . "'
          ";
      $result = $mysqli->query($sql);

      // if the query returned any rows
      if ($result->num_rows > 0) {
        // Add Bootstrap accordion wrapper
        echo "<div>";
        // loop through each row
        while ($row = $result->fetch_assoc()) {
          echo '<div class="note">';
          echo "<h4>" . $row['title'] . "</h4>";
          echo "<p class='note-content'>" . $row['content'] . "</p>";
          echo "<hr />";
          echo "<p class='text-muted datetext'>Created at: " . date("j F Y H:i", strtotime($row['created_at'])) . "</p>";
          echo "<p class='text-muted datetext'>Last updated at: " . date("j F Y H:i", strtotime($row['updated_at'])) . "</p>";
          echo '<a href="./process/delete_catatan.php?delete=' . $row['id_note'] . '" class="btn">Delete</a>';
          echo '<a href="./process/edit_catatan.php?id_note=' . $row['id_note'] . '" class="btn edit">Edit</a>';
          echo '</div>';
        }
        echo '<a href="./process/add_catatan.php" class="d-flex align-items-center justify-content-center">
           <img src="./assets/images/add.png" alt="" class="center-vertically">
       </a>
       ';

        echo '</div>';
      }
      ?>
    </div>
  </div>
  <!-- Bootstrap JS and Popper.js -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
  <?php include "./footer.php"
  ?>

</body>

</html>