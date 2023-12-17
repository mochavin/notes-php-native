<?php
// import connect.php
require_once('../connect.php');
session_start();
if (!isset($_SESSION['username'])) {
  header("Location: ../login.php");
  exit;
}

// get id_note and content
$id_note = $_POST['id_note'];
$content = $_POST['content'];

// update note
$sql = "UPDATE note SET content = '$content' WHERE id_note = '$id_note'";
$result = $mysqli->query($sql);

// redirect to index.php
header("Location: ../index.php");
exit;
