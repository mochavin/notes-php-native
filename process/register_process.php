
<?php
include_once('../connect.php');

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
            header("Location: ../register.php?error=$error");
        }

        // Insert the user into the database
        $sql = "INSERT INTO user (username, password) VALUES ('$username', '$password')";
        $result = $mysqli->query($sql);

        // populer user_note
        $sql = "SELECT id_user FROM user WHERE username = '$username'";
        $result = $mysqli->query($sql);
        $row = $result->fetch_assoc();
        $id_user = $row['id_user'];

        $note_title = "Welcome to Keep Notes";
        $note_content = "Selamat datang di Keep Notes, aplikasi catatan sederhana untuk mencatat hal-hal penting dalam hidupmu. Semoga aplikasi ini dapat membantu kamu dalam mengatur hidupmu. Jangan lupa untuk mengatur hidupmu dengan baik ya!";
        $sql = "INSERT INTO note (title, content) VALUES ('$note_title', '$note_content')";
        $result = $mysqli->query($sql);

        $sql = "SELECT id_note FROM note WHERE title = '$note_title' AND content = '$note_content'";
        $result = $mysqli->query($sql);
        $row = $result->fetch_assoc();
        $id_note = $row['id_note'];

        $sql = "INSERT INTO user_note (id_user, id_note) VALUES ('$id_user', '$id_note')";
        $result = $mysqli->query($sql);




        // Redirect to a success page or perform any other necessary actions
        header("Location: ../login.php");
        exit();
    }
}
?>