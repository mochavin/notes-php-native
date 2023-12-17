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
  <!-- Bootstrap JS dependencies -->
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script>
    // ajax untuk mengedit catatan
    $(document).ready(function() {
      // ketika focus out dari textarea
      $("textarea").focusout(function() {
        // get id_note
        var id_note = $(this).attr("id");
        // get content
        var content = $(this).val();
        // ajax
        $.ajax({
          url: "./process/edit_catatan.php",
          type: "POST",
          data: {
            id_note: id_note,
            content: content
          },
          success: function(result) {
            alert("Note updated!");
          }
        });
      });
    });
  </script>
</head>

<body class="bg-light">

  <div class="container-fluid">
    <div class="row">
      <!-- Sidebar -->
      <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-light sidebar">
        <div class="position-sticky">
          <ul class="nav flex-column">
            <li class="nav-item">
              <h1 class="mb-4">Home</h1>
            </li>
            <li class="nav-item">
              <p class="nav-link">Welcome, <?php echo $_SESSION['username']; ?></p>
            </li>
            <li class="nav-item">
              <a href="?logout" class="btn btn-danger">Logout</a>
            </li>
          </ul>
        </div>
      </nav>

      <!-- Content -->
      <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div class="container mt-5">
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
            echo '<div id="accordion" class=accordion>';

            // loop through each row
            while ($row = $result->fetch_assoc()) {
              echo '<div class="accordion-item">';
              echo '<h5 class="my-0 accordion-header" id="heading' . $row['id_note'] . '">';
              echo '<button class="accordion-button collapsed" data-toggle="collapse" data-target="#collapse' . $row['id_note'] . '" aria-expanded="true" aria-controls="collapse' . $row['id_note'] . '">';
              echo $row['title'];
              echo '</button>';
              echo '</h5>';

              echo '<div id="collapse' . $row['id_note'] . '" class="collapse" aria-labelledby="heading' . $row['id_note'] . '" data-parent="#accordion">';
              echo '<div class="accordion-body">';
              echo "<p class='fw-bold'>Created at: " . date("j F Y H:i", strtotime($row['created_at'])) . "</p>";
              echo "Last updated at: " . date("j F Y H:i", strtotime($row['updated_at'])) . "</p>";
              echo '<textarea class="form-control" style = "height: 200px;"
               id="' . $row['id_note'] . '">' . $row['content'] . '</textarea><br>';
              echo '<a href="./process/delete_catatan.php?delete=' . $row['id_note'] . '" class="btn btn-danger">Delete</a>';
              echo '</div>';
              echo '</div>';
              echo '</div>';

            }

            // Close Bootstrap accordion wrapper
            echo '</div>';
          }


          ?>

          <!-- add note -->
          <?php
          ?>
          <!-- button to add note -->
          <a href="./process/add_catatan.php" class="btn btn-primary my-3
          ">Add Catatan</a>
        </div>
      </main>
    </div>
  </div>

  <!-- Bootstrap JS and Popper.js -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

</body>

</html>