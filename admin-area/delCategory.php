<?php
session_start();
include('../db/db.php');
if (!isset($_SESSION['email']) & empty($_SESSION['email'])) {
  header('location: ../login.php');
}
if (isset($_GET['id'])) {
  $catid = $_GET['id'];
  $sql = "DELETE FROM category WHERE cat_id='$catid'";
  $result = mysqli_query($con, $sql);
  header('location:categories.php');

}

?>