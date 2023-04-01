<?php
session_start(); // Start session for user authentication

// Connect to database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "userlogin";

$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


if (isset($_POST['create'])) {
  $username = $_POST['newuser'];
  $password = $_POST['newpass'];
  $confirm_password = $_POST['confirmpass'];
  
  // Check if the user already exists
  $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($sql);
  
    if ($result->num_rows > 0) {
      // The username already exists
      echo "Username already exists!!!";
    } else {
      // The username does not exist, so add the user to the database
      if ($password == $confirm_password) {
        // The passwords match, so insert the user into the database
        $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
        if ($conn->query($sql) === TRUE) {
          echo "User created successfully!!!";
        } else {
          echo "Error: " . $sql . "<br>" . $conn->error;
        }
      } else {
        // The passwords do not match
        echo "Passwords do not match!!!";
      }
    }
  
    // Close the database connection
    $conn->close();
  }

?>

<!-- HTML form for user login -->


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign-up</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">SIGNUP</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>


      <div class="collapse navbar-collapse " id="navbarNav">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item ">
          <form method="post" action="userlogin.php">
           <input class="nav-link btn btn-danger text-light" type="submit" name="logout " value="Back">
          </form> 
        </li>
      </ul>
    </div>

  </nav>
  <br>
  <br>
  <br>
  <div class="container mt-5 d-flex justify-content-center">

        <form method="post" action="signup.php">
            <h3>Create New User</h3> <br>
            <label>Username</label>
            <input type="text" name="newuser"><br>

            <label>Password:</label>
            <input type="password" name="newpass"><br>

            <label>Confirm Password:</label>
            <input type="password" name="confirmpass"><br>

            <input class="nav-link btn btn-success text-light"type="submit" name="create" value="Create New Password">
        </form>
  </div>

  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>