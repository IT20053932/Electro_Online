<?php
include('header.php');

if (isset($_POST['submit'])) {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $locations = $_POST['refPage'];

  // Hash the password
  $hashed_password = password_hash($password, PASSWORD_DEFAULT);

  // Check if user with the provided email already exists
  $checkQuery = "SELECT * FROM users WHERE email = '$email'";
  $checkResult = mysqli_query($con, $checkQuery);

  if (mysqli_num_rows($checkResult) > 0) {
    // User already exists, redirect to registration page with a message
    header("location:register.php?message=2");
  } else {
    // User doesn't exist, proceed with registration and store the hashed password
    $sql = "INSERT INTO users (email, passwords, name) VALUES ('$email', '$hashed_password', '$name')";
    if (mysqli_query($con, $sql)) {
      $_SESSION['customer'] = $email;
      $_SESSION['customerid'] = mysqli_insert_id($con);
      header("location:$locations");
    } else {
      header('location:login.php?message=1');
    }
  }
}


// Error handling 
/*if (mysqli_query($con, $sql)) {
  // Success
} else {
  // Error handling
  echo "Error: " . mysqli_error($con);
}*/

?>

