<?php 
	include("connection.php");
	include('header1.php');

	if(isset($_POST['btnSave'])){
		$txtLibrarianName = $_POST['txtLibrarianName'];
		$txtLibrarianEmail = $_POST['txtLibrarianEmail'];
		$txtLibrarianPassword = $_POST['txtLibrarianPassword'];
		$txtLibrarianPhoneNumber = $_POST['txtLibrarianPhoneNumber'];
		$txtLibrarianAddress = $_POST['txtLibrarianAddress'];

		//---Upload Img---
		$fileAdminImage=$_FILES['fileAdminImage']['name'];//Assign var to ui element
		$Destination="adminPhoto/";//file destination to copy
		$fileName=$Destination . $txtLibrarianName ."_". $fileAdminImage;//set file name before copy/dot is plus operator
		$copied = copy($_FILES['fileAdminImage']['tmp_name'], $fileName);//copy(from,to)/so a(temp name) copy to (b)
		if(!$copied){
			echo"<p>Error Uploading Photo</p>";
			exit();
		}
		//----------------

		//------check email already exists
		$checkEmailAdmin = "SELECT * FROM librarian WHERE librarian_email=?";
		$stmt = mysqli_prepare($connect, $checkEmailAdmin);
		mysqli_stmt_bind_param($stmt, 's', $txtLibrarianEmail);
		mysqli_stmt_execute($stmt);
		$res = mysqli_stmt_get_result($stmt);
		if($res === false){
			echo"Error: ".mysqli_error($connect);
		}
		elseif (mysqli_num_rows($res) > 0){
			echo"<script>window.alert('Email Already Exist')</script>";
			echo"<script>window.location='librarianRegister.php'</script>";
		}
		else{
			$checkEmail = "SELECT * FROM member WHERE member_email=?";
			$stmt = mysqli_prepare($connect, $checkEmail);
			mysqli_stmt_bind_param($stmt, 's', $txtLibrarianEmail);
			mysqli_stmt_execute($stmt);
			$resu = mysqli_stmt_get_result($stmt);
			if($resu === false){
				echo"Error: ".mysqli_error($connect);
			}
			elseif (mysqli_num_rows($resu) > 0){
				echo"<script>window.alert('Email Already Exist')</script>";
				echo"<script>window.location='librarianRegister.php'</script>";
			}
			else{
				$hashedPassword = password_hash($txtLibrarianPassword, PASSWORD_DEFAULT);//hash password
				$insertQuery = "INSERT INTO librarian (librarian_image, librarian_name, librarian_email, librarian_password, librarian_address, librarian_phonenumber)
				VALUES (?, ?, ?, ?, ?, ?)";
				$insertStmt = mysqli_prepare($connect, $insertQuery);
				mysqli_stmt_bind_param($insertStmt, 'ssssss', $fileName, $txtLibrarianName, $txtLibrarianEmail, $hashedPassword, $txtLibrarianAddress, $txtLibrarianPhoneNumber);
				$res1 = mysqli_stmt_execute($insertStmt);
				if(!$res1){
					echo"<p>Opps! Something went wrong".mysqli_error($connect)."</p>";
				}
				else{
					echo"<script>window.alert('New Librarian Successfully Added')</script>";
					session_start();
					if(isset($_SESSION['librarianID'])&&$_SESSION['accountType']==="librarian"){
						echo"<script>window.location='librarianList.php'</script>";
					}
					else{
						echo"<script>window.alert('Login Now')</script>";
						echo"<script>window.location='login.php'</script>";
					}
				}
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
	<form action="librarianRegister.php" method = "POST" enctype="multipart/form-data">
		<fieldset>
		<legend>Add New Librarian</legend>
		<table>
			<tr>
				<td class="bold">Name</td>
				<td>
					<input type="text" name="txtLibrarianName" required placeholder="Your Name">
				</td>
			</tr>
			<tr>
				<td class="bold">Email Address</td>
				<td>
					<input type="text" name="txtLibrarianEmail" required placeholder="youremail@yahoo.com">
				</td>
			</tr>
			<tr>
				<td class="bold">New Password</td>
				<td>
					<input type="password" name="txtLibrarianPassword" required placeholder="123">
				</td>
			</tr>
			<tr>
				<td class="bold">Phone Number</td>
				<td>
					<input type="text" name="txtLibrarianPhoneNumber" required placeholder="01-220-330-440">
				</td>
			</tr>
			<tr>
				<td class="bold">Address</td>
				<td>
					<input type="text" name="txtLibrarianAddress" required placeholder="No-2 Baho Street Yangon">
				</td>
			</tr>
			<tr>
				<td class="bold">Upload Image</td>
				<td>
					<input type="file" name="fileAdminImage" required>
				</td>
			</tr>
			<tr><td></td>
				<td>
					<input type="submit" name="btnSave" value="Save" />
					<input type="reset" value="Cancel" />
				</td>
			</tr>
		</table>
		</fieldset>
	</form>
</body>
</html>
<?php 
	include('footer1.php')
 ?>