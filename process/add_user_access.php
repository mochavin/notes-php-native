<?php
// import connect.php
require_once('../connect.php');
session_start();
if (!isset($_SESSION['username'])) {
  header("Location: ../login.php");
  exit;
}

$response = new stdClass();

// get id_note and content
$id_note = $_POST['id_note'];
$username = $_POST['username'];

// check user is exist
$sql = "SELECT * FROM user WHERE username = '$username'";
$resultUser = $mysqli->query($sql);

if ($resultUser->num_rows > 0) {
  $user = $resultUser->fetch_object();
  // check user_note is exist
  $sql = "SELECT * FROM user_note WHERE id_user = '$user->id_user' AND id_note = '$id_note'";
  $resultUserNote = $mysqli->query($sql);

  // if user_note is exist
  if ($resultUserNote->num_rows > 0) {
    $response->success = false;
    $response->message = "User already added!";
  } else {
    // insert to user_note
    $sql = "INSERT INTO user_note (id_user, id_note) VALUES ('$user->id_user', '$id_note')";
    $resultInsert = $mysqli->query($sql);

    if ($resultInsert) {
      $response->success = true;
      $response->message = "User added!";
    } else {
      $response->success = false;
      $response->message = "Error adding user!";
    }
  }
} else {
  $response->success = false;
  $response->message = "User not found!";
}

header("Content-Type: application/json");
echo json_encode($response);
?>
