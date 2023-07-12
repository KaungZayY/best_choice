<?php
session_start();
include('loginheader.php');
require_once('connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Get the new password from the form
  $new_password = $_POST['new_password'];
  
  // Get the token from the password reset link
  $token = $_GET['token'];

  // Check if the token exists in the database
  $stmt = $connect->prepare('SELECT * FROM password_reset WHERE token = ? AND expire_time >= NOW()');
  $stmt->bind_param('s', $token);
  $stmt->execute();
  $result = $stmt->get_result();
  $row = $result->fetch_assoc();

  if ($row) {
    // If the token exists and hasn't expired, update the password for the user and admin

    // Update the password for the user
    $stmt = $connect->prepare('UPDATE member SET member_password = ? WHERE member_email = ?');
    $password_hash = password_hash($new_password, PASSWORD_DEFAULT);
    $email = $row['email'];
    $stmt->bind_param('ss', $password_hash, $email);
    $stmt->execute();
    // Update the password for the admin
    $stmt = $connect->prepare('UPDATE librarian SET librarian_password = ? WHERE librarian_email = ?');
    $password_hash = password_hash($new_password, PASSWORD_DEFAULT);
    $email = $row['email'];
    $stmt->bind_param('ss', $password_hash, $email);
    $stmt->execute();

    // Delete the password reset token from the database
    $stmt = $connect->prepare('DELETE FROM password_reset WHERE token = ?');
    $stmt->bind_param('s', $token);
    $stmt->execute();

    // Display a success message
    echo "<script>alert(' Your Password has been rest, Login Again')
            window.location='logout.php'
            </script>";
    exit;
  } else {
    // If the token doesn't exist or has expired, display an error message
    echo "<script>alert(' Invalid token')
            window.location='forgotPassword.php'
            </script>";
    exit;
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Reset Password</title>
</head>
<body>
<?php
// Display error message if there is one
if (isset($_SESSION['error'])) {
  echo '<p style="color: red;">' . $_SESSION['error'] . '</p>';
  unset($_SESSION['error']);
}
?>
<form action="<?php echo $_SERVER['PHP_SELF'].'?token='.$_GET['token']; ?>" method="POST">
  <fieldset>
    <legend>Reset Password</legend>
    <table>
      <tr>
        <td class="bold">New Password:</td>
        <td><input type="password" name="new_password" required></td>
      </tr>
      <tr>
        <td colspan="2"><input type="submit" value="Reset Password"></td>
      </tr>
    </table>
  </fieldset>
</form>
</body>
</html>
<?php 
include('loginfooter.php');