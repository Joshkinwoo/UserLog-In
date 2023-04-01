<?php
session_start();

// Set database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "userlogin";

$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check if connection was successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Password change functionality
if(isset($_POST['change_password'])) {
  $username = mysqli_real_escape_string($conn, $_SESSION['username']);
  $old_password = $_POST['current_password'];
  $new_password = $_POST['new_password'];
  $confirm_password = $_POST['confirm_password'];

  // Check if the old password is correct
  $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$old_password'";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    // The old password is correct
    if ($new_password == $confirm_password) {
      // The new passwords match, so update the user's password in the database
      $sql = "UPDATE users SET password = '$new_password' WHERE username = '$username'";
      if ($conn->query($sql) === TRUE) {
        echo "Password changed successfully!!!";
      } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
      }
    } else {
      // The new passwords do not match
      echo "New passwords do not match!!!";
    }
  } else {
    // The old password is incorrect
    echo "Current password is incorrect!!!";
  }

  // Close the database connection
  $conn->close();
}


// Check if logout button has been clicked
if (isset($_POST['logout'])) {
    // Unset session variables
    session_unset();
    session_destroy();

    // Redirect to login page
    header("Location: userlogin.php");
    exit();
}

// Add new user
// Get user input

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">Dashboard</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse " id="navbarNav">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item ">
          <form method="post" action="userlogin.php">
           <input class="nav-link btn btn-danger text-light" type="submit" name="logout " value="Log out ">
          </form> 
        </li>
      </ul>
    </div>
  </nav>

  <div class="container mt-5">
    <h1>Welcome to your Dashboard <?php echo $_SESSION['username'] ."!"; ?></p></h1>
    <p>This is where you can manage your account settings and view important information.</p>
  </div>
  <div class="container mt-5">
    <h3>Change Password</h3>
        <?php if (isset($error_message)) { ?>
            <p style="color: red;"><?php echo $error_message; ?></p>
        <?php } ?>
        <form method="post" action="dashboard.php">
            <label>Current Password:</label>
            <input type="password" name="current_password"><br>

            <label>New Password:</label>
            <input type="password" name="new_password"><br>

            <label>Confirm Password:</label>
            <input type="password" name="confirm_password"><br>

            <input class="nav-link btn btn-success text-light"type="submit" name="change_password" value="Change Password">
        </form>
  </div>

  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
