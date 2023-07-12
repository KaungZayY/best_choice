<?php 
	include('connection.php');
	include('header1.php');
	session_start();
    if(!isset($_SESSION['librarianID']) || $_SESSION['accountType'] != "librarian"){
    echo "<script>window.alert('Login as Librarian to Access this Page')</script>";
    echo "<script>window.history.go(-1);</script>";
    }
	if(isset($_REQUEST['uit'])){
		$memberID=$_REQUEST['uit'];
		$select="SELECT * FROM member WHERE member_id='$memberID'";
		$query=mysqli_query($connect, $select);
		$data=mysqli_fetch_array($query);
		$memberName=$data['member_name'];
		$memberEmail=$data['member_email'];
		$memberAddress=$data['member_address'];
		$memberPhoneNumber=$data['member_phonenumber'];
		$membertypeID = $data['membertype_id'];

	}
	if (isset($_POST['btnUpdate'])) {
		$memberID=$_POST['txtmemberID'];//rename from here and need to echo out for the text boxes
		$memberName=$_POST['txtmemberName'];
		$memberEmail=$_POST['txtmemberEmail'];
		$memberAddress=$_POST['txtmemberAddress'];
		$memberPhoneNumber=$_POST['txtmemberPhoneNumber'];
		$memberTypeID = $_POST['cboMemberType'];
		$update="UPDATE member SET member_name='$memberName',member_email='$memberEmail',member_address='$memberAddress',member_phonenumber='$memberPhoneNumber',membertype_id='$memberTypeID' WHERE member_id='$memberID'";
		$query1=mysqli_query($connect, $update);
		if (!$query1) {
			echo "<script>alert(' Update UnSuccessful, Try Again')
			window.location='managememberUpdate.php'
			</script>";
		}
		else{
			echo "<script>alert(' Update Successful')
			window.location='memberList.php'
			</script>";
		}
	}
 ?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<form action="managememberUpdate.php" method = "POST" enctype="multipart/form-data">
		<fieldset>
		<legend>Update member Information</legend>
		<table>
			<tr>
				<td>Name</td>
				<td>
					<input type="text" name="txtmemberName" required value="<?php echo $memberName ?>">
				</td>
			</tr>
			<tr>
				<td>Email Address</td>
				<td>
					<input type="text" name="txtmemberEmail" required value="<?php echo $memberEmail ?>">
				</td>
			</tr>
			<tr>
				<td>Phone Number</td>
				<td>
					<input type="text" name="txtmemberPhoneNumber" required value="<?php echo $memberPhoneNumber ?>">
				</td>
			</tr>
			<tr>
				<td>Address</td>
				<td>
					<input type="text" name="txtmemberAddress" required value="<?php echo $memberAddress ?>">
				</td>
			</tr>
			<tr>
				<td>Member Type</td>
				<td>
					<select name="cboMemberType">
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
				<td>
					<input type="hidden" value ="<?php echo $memberID?>" name="txtmemberID"/>
					<input type="submit" name="btnUpdate" value="Save" />
					<input type="reset" value="Cancel" />
				</td>
			</tr>
		</table>
		</fieldset>
	</form>
</body>
</html>
<?php 
include('footer1.php');
