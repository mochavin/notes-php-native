<?php
// import connect.php
require_once('../connect.php');
// if isset id_note
if (isset($_GET['delete'])) {
  // get id_note
  $id_note = $_GET['delete'];

  // delete user_note
  $sql = "DELETE FROM user_note WHERE id_note = '$id_note'";
  $result = $mysqli->query($sql);

  // delete note
  $sql = "DELETE FROM note WHERE id_note = '$id_note'";
  $result = $mysqli->query($sql);

  // redirect to index.php
  header("Location: ../index.php");
  exit;
}