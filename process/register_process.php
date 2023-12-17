
<?php
include_once('connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate the form data (you can add more validation rules as needed)
    if (empty($username) || empty($password)) {
        $error = "Please fill in all the fields";
    } else {
        // handle duplicate username
        $sql = "SELECT * FROM user WHERE username='$username'";
        $result = $mysqli->query($sql);
        if ($result->num_rows > 0) {
            $error = "Username already exists";
            header("Location: register.php?error=$error");
        }

        // Insert the user into the database
        $sql = "INSERT INTO user (username, password) VALUES ('$username', '$password')";
        $result = $mysqli->query($sql);


        // Redirect to a success page or perform any other necessary actions
        header("Location: login.php");
        exit();
    }
}
?>