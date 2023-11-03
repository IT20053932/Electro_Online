<?php
session_start();
include('db/db.php');

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $locations = $_POST['refPage'];

    // Encrypt the password before storing it in the database
    $encryptedPassword = openssl_encrypt($password, 'AES-256-CBC', 'your_secret_key', 0, 'your_iv');

    // Prepare the SQL query using placeholders
    $customerQuery = "SELECT * FROM users WHERE email=? AND passwords=?";
    $customerStmt = mysqli_prepare($con, $customerQuery);
    // Bind the parameters and execute the query
    mysqli_stmt_bind_param($customerStmt, "ss", $email, $encryptedPassword);
    mysqli_stmt_execute($customerStmt);
    $customerResult = mysqli_stmt_get_result($customerStmt);

    // Fetch the results and check if the user is a customer
    $customerCount = mysqli_num_rows($customerResult);

    // ... (similar changes for admin query)

    if ($customerCount > 0) {
        // Customer login
        $_SESSION['customer'] = $email;
        $customerRow = mysqli_fetch_assoc($customerResult);
        $_SESSION['customerid'] = $customerRow['id'];
        header("location:$locations");
        exit();
    } elseif ($adminCount > 0) {
        // Admin login
        $_SESSION['email'] = $email;
        header('location: admin-area/index.php');
        exit();
    } else {
        // Redirect back to the 2nd previous page
        header("location:login.php?message=1");
        exit();
    }
} else {
    header('location: login.php');
    exit();
}
?>
