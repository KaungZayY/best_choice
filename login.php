<?php
	session_start(); 
	include('loginheader.php');
	include('connection.php');
	if (isset($_POST['btnLogin'])) {
		$email = $_POST['txtEmail'];
		$password = $_POST['txtPassword'];
		
		// Create a prepared statement
		$select = "SELECT * FROM librarian WHERE librarian_email=?";
		$stmt = mysqli_prepare($connect, $select);
		
		// Bind parameters to the prepared statement
		mysqli_stmt_bind_param($stmt, "s", $email);
		
		// Execute the prepared statement
		mysqli_stmt_execute($stmt);
		
		// Store the result
		$res = mysqli_stmt_get_result($stmt);
		
		// Fetch the data row
		$data_row = mysqli_fetch_array($res);
		
		if ($data_row != null && password_verify($password, $data_row['librarian_password'])) {
			$_SESSION['librarianID']=$data_row['librarian_id'];
			$_SESSION['librarianName']=$data_row['librarian_name'];
			$_SESSION['accountType']="librarian";
			echo "<script>window.alert('Librarian Login Successful')</script>";
			echo "<script>window.location='bookList.php'</script>";
		} else {
			// Create a prepared statement
			$select1="SELECT * FROM member WHERE member_email=?";
			$stmt1 = mysqli_prepare($connect, $select1);
			
			// Bind parameters to the prepared statement
			mysqli_stmt_bind_param($stmt1, "s", $email);
			
			// Execute the prepared statement
			mysqli_stmt_execute($stmt1);
			
			// Store the result
			$res1=mysqli_stmt_get_result($stmt1);
			
			// Fetch the data row
			$data_row1 = mysqli_fetch_array($res1);
			
			if ($data_row1 != null && password_verify($password, $data_row1['member_password'])) {
				$_SESSION['memberID']=$data_row1['member_id'];
				$_SESSION['memberName']=$data_row1['member_name'];
				$_SESSION['accountType']="member";
				echo "<script>window.alert('Member Login Successful')</script>";
				echo "<script>window.location='bookDisplay.php'</script>";
			} else {
				echo "<script>window.alert('Cannot Login, check email and password again')</script>";
				echo "<script>window.location='login.php'</script>";
			}
		}

	}
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<form action="login.php" method="POST">
		<legend>Login</legend>
		<table>
			<tr>
				<td class="bold">Email</td>
				<td><input type="text" name="txtEmail" required placeholder="youremail@example.com"></td>
			</tr>
			<div>
				<a href="forgotPassword.php">Forgot password?</a>
				<span> | </span>
				<a href="memberRegister.php">Register as a member</a>
			</div>
			<tr>
				<td class="bold">Password</td>
				<td><input type="password" name="txtPassword" required placeholder="123"></td>
			</tr>
			<tr>
				<td></td>
				<td>
					<input type="submit" name="btnLogin" value="Login">
					<input type="reset" name="btnCancel" value="Cancel">
				</td>
			</tr>
		</table>
	</form>
</body>
</html>

<?php 
include('loginfooter.php');
