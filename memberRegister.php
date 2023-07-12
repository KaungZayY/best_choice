<?php 
	include("connection.php");
	include('loginheader.php');

	if(isset($_POST['btnSave'])){
		$txtMemberName = $_POST['txtMemberName'];
		$txtMemberEmail = $_POST['txtMemberEmail'];
		$txtMemberPassword = $_POST['txtMemberPassword'];
		$txtMemberPhoneNumber = $_POST['txtMemberPhoneNumber'];
		$txtMemberAddress = $_POST['txtMemberAddress'];
		$cboMemberTypeID = $_POST['cboMemberTypeID'];

		//---Upload Img---
		$fileAdminImage=$_FILES['fileAdminImage']['name'];//Assign var to ui element
		$Destination="memberPhoto/";//file destination to copy
		$fileName=$Destination . $txtMemberName ."_". $fileAdminImage;//set file name before copy/dot is plus operator
		$copied = copy($_FILES['fileAdminImage']['tmp_name'], $fileName);//copy(from,to)/so a(temp name) copy to (b)
		if(!$copied){
			echo"<p>Error Uploading Photo</p>";
			exit();
		}
		//----------------

		//------check email already exists
		$checkEmailMember = "SELECT * FROM member WHERE member_email=?";
		$stmt = mysqli_prepare($connect, $checkEmailMember);
		mysqli_stmt_bind_param($stmt, 's', $txtMemberEmail);
		mysqli_stmt_execute($stmt);
		$res = mysqli_stmt_get_result($stmt);
		if($res === false){
			echo"Error: ".mysqli_error($connect);
		}
		elseif (mysqli_num_rows($res) > 0){
			echo"<script>window.alert('Email Already Exist')</script>";
			echo"<script>window.location='memberRegister.php'</script>";
		}
		else{
			$checkEmailAdmin = "SELECT * FROM librarian WHERE librarian_email=?";
			$stmt = mysqli_prepare($connect, $checkEmailAdmin);
			mysqli_stmt_bind_param($stmt, 's', $txtMemberEmail);
			mysqli_stmt_execute($stmt);
			$resu = mysqli_stmt_get_result($stmt);
			if($resu === false){
				echo"Error: ".mysqli_error($connect);
			}
			elseif (mysqli_num_rows($resu) > 0){
				echo"<script>window.alert('Email Already Exist')</script>";
				echo"<script>window.location='memberRegister.php'</script>";
			}
			else{
				$hashedPassword = password_hash($txtMemberPassword, PASSWORD_DEFAULT);//hash password
				$insertQuery = "INSERT INTO member (member_image, member_name, member_email, member_password, member_address, member_phonenumber,membertype_id)
				VALUES (?, ?, ?, ?, ?, ?, ?)";
				$insertStmt = mysqli_prepare($connect, $insertQuery);
				mysqli_stmt_bind_param($insertStmt, 'sssssss', $fileName, $txtMemberName, $txtMemberEmail, $hashedPassword, $txtMemberAddress, $txtMemberPhoneNumber,$cboMemberTypeID);
				$res1 = mysqli_stmt_execute($insertStmt);
				if(!$res1){
					echo"<p>Opps! Something went wrong".mysqli_error($connect)."</p>";
				}
				else{
					echo"<script>window.alert('New Member Successfully Added')</script>";
					echo"<script>window.location='login.php'</script>";
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
	<form action="memberRegister.php" method = "POST" enctype="multipart/form-data">
		<fieldset>
		<legend>Add New member</legend>
		<table>
			<tr>
				<td class="bold">Name</td>
				<td>
					<input type="text" name="txtMemberName" required placeholder="Your Name">
				</td>
			</tr>
			<tr>
				<td class="bold">Email Address</td>
				<td>
					<input type="text" name="txtMemberEmail" required placeholder="youremail@yahoo.com">
				</td>
			</tr>
			<tr>
				<td class="bold">New Password</td>
				<td>
					<input type="password" name="txtMemberPassword" required placeholder="123">
				</td>
			</tr>
			<tr>
				<td class="bold">Phone Number</td>
				<td>
					<input type="text" name="txtMemberPhoneNumber" required placeholder="01-220-330-440">
				</td>
			</tr>
			<tr>
				<td class="bold">Member Type</td>
				<td>
					<select name="cboMemberTypeID">
						<?php 
							$select="SELECT * FROM membertype";
							$query=mysqli_query($connect,$select);
							$count=mysqli_num_rows($query);
							for($i=0;$i<$count;$i++)
						{
							$data=mysqli_fetch_array($query);
							$membertype_id=$data['membertype_id'];
							$membertype_name=$data['membertype_name'];
							echo "<option value='$membertype_id'>
								$membertype_name
							</option>";
						}
						 ?>
					</select>
				</td>
			</tr>
			<tr>
				<td class="bold">Address</td>
				<td>
					<input type="text" name="txtMemberAddress" required placeholder="No-2 Baho Street Yangon">
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
include('loginfooter.php');