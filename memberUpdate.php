<?php 
include('connection.php');
include('header.php');
session_start();
if(isset($_SESSION['memberID'])&&$_SESSION['accountType']==="member"){
	$memberID = $_SESSION['memberID'];
	$memberName = $_SESSION['memberName'];

	$select = "SELECT * FROM member WHERE member_id = '$memberID'";
	$query = mysqli_query($connect,$select);
	$data = mysqli_fetch_array($query);
	
	$member_id = $data['member_id'];
	$member_name = $data['member_name'];
	$member_email = $data['member_email'];
	$member_address = $data['member_address'];
	$member_phonenumber = $data['member_phonenumber'];
	$member_image = $data['member_image'];



	if(isset($_POST['btnUpdate'])){
		$member_id = $_POST['txtMemberID'];
		$member_name = $_POST['txtMemberName'];
		$member_email = $_POST['txtMemberEmail'];
		$member_address = $_POST['txtMemberAddress'];
		$member_phonenumber = $_POST['txtMemberPhoneNumber'];


		$update="UPDATE member SET member_name='$member_name',
		member_email='$member_email', member_address='$member_address',member_phonenumber='$member_phonenumber'
		WHERE member_id='$member_id'";
		$query1=mysqli_query($connect, $update);
		if (!$query1) {
			echo "<script>alert(' Update UnSuccessful, Try Again')
			window.location='memberUpdate.php'
			</script>";
		}
		else{
			echo "<script>alert(' Update Successful')
			window.location='bookDisplay.php'
			</script>";
		}

	}

}

else{
	echo "<script>window.alert('Login as a Member First')</script>";
	echo "<script>window.location='login.php'</script>";
}

 ?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<form action="memberUpdate.php" method = "POST" enctype="multipart/form-data">
		<fieldset>
		<legend>Update Information</legend>
		<table>
			<tr>
				<td class="bold">Name</td>
				<td>
					<input type="text" name="txtMemberName" required value="<?php echo $member_name ?>">
				</td>
			</tr>
			<tr>
				<td class="bold">Email Address</td>
				<td>
					<input type="text" name="txtMemberEmail" required value="<?php echo $member_email ?>">
				</td>
			</tr>
			
			<tr>
				<td class="bold">Phone Number</td>
				<td>
					<input type="text" name="txtMemberPhoneNumber" required value="<?php echo $member_phonenumber ?>">
				</td>
			</tr>
<!--
			<tr>
				<td>Member Type</td>
				<td>
					<select name="cboMemberTypeID">
						<?php 
						/*
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
						*/
						 ?>
					</select>
				</td>
			</tr>
		//***not letting a member to update member type (will necessary for member list)***//
-->
			<tr>
				<td class="bold">Address</td>
				<td>
					<input type="text" name="txtMemberAddress" required value="<?php echo $member_address ?>">
				</td>
			</tr>
			<tr><td></td>
				<td>
					<input type="hidden" value ="<?php echo $member_id?>" name="txtMemberID"/>
					<input type="submit" name="btnUpdate" value="Update" />
					<input type="reset" value="Cancel" />
				</td>
			</tr>
		</table>
		</fieldset>
	</form>
</body>
</html>
<?php 
include('footer.php');