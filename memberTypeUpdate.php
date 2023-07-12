<?php 
	include('connection.php');
	include('header1.php');
	session_start();
    if(!isset($_SESSION['librarianID']) || $_SESSION['accountType'] != "librarian"){
    echo "<script>window.alert('Login as Librarian to Access this Page')</script>";
    echo "<script>window.history.go(-1);</script>";
    }
	if(isset($_REQUEST['uid'])){
		$membertype_id=$_REQUEST['uid'];
		$select="SELECT * FROM membertype WHERE membertype_id=?";
		$stmt = mysqli_prepare($connect, $select);
		mysqli_stmt_bind_param($stmt, "i", $membertype_id);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);
		$data = mysqli_fetch_array($result);
		$membertype_name=$data['membertype_name'];
		$booklimit=$data['booklimit'];
		$borrowingperiod=$data['borrowingperiod'];

	}
	if (isset($_POST['btnUpdate'])) {
		$membertype_id=$_POST['txtmembertype_id'];
		$membertype_name=$_POST['txtmembertype_name'];
		$booklimit=$_POST['txtbooklimit'];
		$borrowingperiod=$_POST['txtborrowingperiod'];
		$rdoStatus=$_POST['rdoStatus'];
		$update="UPDATE membertype SET membertype_name=?, booklimit=?, borrowingperiod=?, status=? WHERE membertype_id=?";
		$stmt = mysqli_prepare($connect, $update);
		mysqli_stmt_bind_param($stmt, "ssssi", $membertype_name, $booklimit, $borrowingperiod, $rdoStatus, $membertype_id);
		$query1=mysqli_stmt_execute($stmt);
		if ($query1) {
			echo "<script>alert('Member Type Update Successful')
			window.location='memberTypeRegister.php'
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
	<form action="memberTypeUpdate.php" method="POST">
		<fieldset>
			<legend>Update Type of Member</legend>
			<table>
				<tr>
					<td class="bold">Type</td>
					<td><input type="text" name = "txtmembertype_name" required value="<?php echo $membertype_name ?>"></td>
				</tr>
				<tr>
					<td class="bold">Book Limit</td>
					<td><input type="text" name="txtbooklimit" required value="<?php echo $booklimit ?>"></td>
				</tr>
				<tr>
					<td class="bold">Borrowing Period</td>
					<td><input type="text" name="txtborrowingperiod" required value="<?php echo $borrowingperiod ?>"></td>
				</tr>
				<tr>
					<td class="bold">Status</td>
					<td>
						<input type="radio" name="rdoStatus" value="Active" checked />Active
						<input type="radio" name="rdoStatus" value="InActive" />InActive
					</td>
				</tr>
				<tr><td></td>
				<td>
					<input type="hidden" value ="<?php echo $membertype_id?>" name="txtmembertype_id"/>
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
include('footer1.php');
