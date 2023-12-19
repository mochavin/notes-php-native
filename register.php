<?php
  // get query message error
  if (isset($_GET['error'])) {
    $error = $_GET['error'];
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Register</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="./css/log_reg.css">
  <style>
    body {
      background-color: #f8f9fa;
    }

    .wrapper {
      margin-top: 50px;
    }

    .card {
      border: 0;
      border-radius: 15px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .error {
      color: red;
    }
  </style>
</head>
<body class="light">
  <div class="container mt-5">
    <div class="row justify-content-center ">
      <div class="col-md-6">
        <div class="card login-page">
          <div class="card-body">
            <h1 class="text-center mb-4">KeepNotes</h1>
            <img src="./assets/images/torch.png" alt="" class="brand-logo mx-auto d-block">
            <h3 class="mb-4 text-light">Register</h3>
            <form method="POST" action="./process/register_process.php">
              <!-- error -->
              <?php if (isset($error)): ?>
                <div class="alert alert-danger">
                  <?php echo $error; ?>
                </div>
              <?php endif; ?>

              <div class="mb-3">
                <label for="username" class="form-label">Username:</label>
                <input type="text" class="form-control" id="username" name="username" required>
              </div>

              <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>
              </div>

              <button type="submit" class="btn btn-light">Register</button>
            </form>
            <!-- login link -->
            <p class="mt-3">Sudah punya akun? <a href="login.php">Login</a></p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS (optional) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
