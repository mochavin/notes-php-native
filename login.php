<?php
// import connect.php
require_once('connect.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Get the submitted username and password
  $username = $_POST['username'];
  $password = $_POST['password'];

  // cek username dan password
  $sql = "SELECT * FROM user WHERE username='$username' AND password='$password'";
  $result = $mysqli->query($sql);

  // If the query returned an object
  if (is_object($result)) {
    // Get the row
    $user = $result->fetch_row();

    // If user exists
    if ($user) {
      // Start the session
      session_start();

      // Set session variables
      $_SESSION['username'] = $user[1];
      $_SESSION['role'] = $user[3];

      // Redirect to home.php
      header('Location: index.php');
      exit;
    }

    // Invalid username/password
    $invalid = "Invalid username/password";
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <!-- Tambahkan stylesheet Bootstrap -->
  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
  <link rel="stylesheet" href="./css/log_reg.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600&display=swap" rel="stylesheet">
</head>

<body class="light">
  <div class="container mt-5">
    <div class="row justify-content-center ">
      <div class="col-md-6">
        <div class="card login-page">
          <div class="card-body">
            <h1 class="text-center mb-4">KeepNotes</h1>
            <img src="./assets/images/torch.png" alt="" class="brand-logo mx-auto d-block">
            <h3 class="mb-4 text-light">Login</h3>
            <!-- error -->
            <?php if (isset($invalid)) : ?>
              <div class="alert alert-danger">
                <?php echo $invalid; ?>
              </div>
            <?php endif; ?>
            <form method="POST" action="">
              <div class="mb-2">
              
                <label for="username" class="form-label">Username:</label>
                <input type="text" class="form-control" id="username" name="username" required>
              </div>

              <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>
              </div>

              <button type="submit" class="btn btn-light">Login</button>
            </form>
            <!-- register link -->
            <p class="mt-3">Belum punya akun? <a href="register.php">Register</a></p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Tambahkan script Bootstrap (Popper.js dan Bootstrap.js) -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>