<?php 
	include('connection.php');
	include('header1.php');
	session_start();
    if(!isset($_SESSION['librarianID']) || $_SESSION['accountType'] != "librarian"){
    echo "<script>window.alert('Login as Librarian to Access this Page')</script>";
    echo "<script>window.history.go(-1);</script>";
    }
	if(isset($_REQUEST['uit'])){
		$librarianID=$_REQUEST['uit'];
		$select="SELECT * FROM librarian WHERE librarian_id='$librarianID'";
		$query=mysqli_query($connect, $select);
		$data=mysqli_fetch_array($query);
		$librarianName=$data['librarian_name'];
		$librarianEmail=$data['librarian_email'];
		$librarianAddress=$data['librarian_address'];
		$librarianPhoneNumber=$data['librarian_phonenumber'];

	}
	if (isset($_POST['btnUpdate'])) {
		$librarianID=$_POST['txtLibrarianID'];//rename from here and need to echo out for the text boxes
		$librarianName=$_POST['txtLibrarianName'];
		$librarianEmail=$_POST['txtLibrarianEmail'];
		$librarianAddress=$_POST['txtLibrarianAddress'];
		$librarianPhoneNumber=$_POST['txtLibrarianPhoneNumber'];
		$update="UPDATE librarian SET librarian_name='$librarianName',librarian_email='$librarianEmail', librarian_address='$librarianAddress',librarian_phonenumber='$librarianPhoneNumber' WHERE librarian_id='$librarianID'";
		$query1=mysqli_query($connect, $update);
		if (!$query1) {
			echo "<script>alert(' Update UnSuccessful, Try Again')
			window.location='manageLibrarianUpdate.php'
			</script>";
		}
		else{
			echo "<script>alert(' Update Successful')
			window.location='librarianList.php'
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
	<form action="manageLibrarianUpdate.php" method = "POST" enctype="multipart/form-data">
		<fieldset>
		<legend>Update Librarian Information</legend>
		<table>
			<tr>
				<td>Name</td>
				<td>
					<input type="text" name="txtLibrarianName" required value="<?php echo $librarianName ?>">
				</td>
			</tr>
			<tr>
				<td>Email Address</td>
				<td>
					<input type="text" name="txtLibrarianEmail" required value="<?php echo $librarianEmail ?>">
				</td>
			</tr>
			<tr>
				<td>Phone Number</td>
				<td>
					<input type="text" name="txtLibrarianPhoneNumber" required value="<?php echo $librarianPhoneNumber ?>">
				</td>
			</tr>
			<tr>
				<td>Address</td>
				<td>
					<input type="text" name="txtLibrarianAddress" required value="<?php echo $librarianAddress ?>">
				</td>
			</tr>
			<tr>
				<td>
					<input type="hidden" value ="<?php echo $librarianID?>" name="txtLibrarianID"/>
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