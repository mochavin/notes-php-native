<?php
require_once('../connect.php');
session_start();
if (!isset($_SESSION['username'])) {
  header("Location: login.php");
  exit;
}

if ($_SESSION['role'] == 'user') {
  header("Location: ../index.php");
  exit;
}

// get isset id_user
if (isset($_GET['delete'])) {
  // get id_user
  $id_user = $_GET['delete'];

  // delete user_note
  $sql = "DELETE FROM user_note WHERE id_user = '$id_user'";
  $result = $mysqli->query($sql);

  // delete user
  $sql = "DELETE FROM user WHERE id_user = '$id_user'";
  $result = $mysqli->query($sql);

  // redirect to admin_page.php
  header("Location: ../admin_page.php");
  exit;
}