<?php 
include('connection.php');
include('header1.php');
session_start();
if(isset($_SESSION['librarianID'])&&$_SESSION['accountType']==="librarian"){
	$librarianID = $_SESSION['librarianID'];
	$librarianName = $_SESSION['librarianName'];

	$select = "SELECT * FROM librarian WHERE librarian_id = '$librarianID' AND librarian_name='$librarianName'";
	$query = mysqli_query($connect,$select);
	$data = mysqli_fetch_array($query);
	
	$librarian_id = $data['librarian_id'];
	$librarian_name = $data['librarian_name'];
	$librarian_email = $data['librarian_email'];
	$librarian_address = $data['librarian_address'];
	$librarian_phonenumber = $data['librarian_phonenumber'];
	$librarian_image = $data['librarian_image'];


	if(isset($_POST['btnUpdate'])){
		$librarian_id = $_POST['txtLibrarianID'];
		$librarian_name = $_POST['txtLibrarianName'];
		$librarian_email = $_POST['txtLibrarianEmail'];
		$librarian_address = $_POST['txtLibrarianAddress'];
		$librarian_phonenumber = $_POST['txtLibrarianPhoneNumber'];


		$update="UPDATE librarian SET librarian_name='$librarian_name',
		librarian_email='$librarian_email', librarian_address='$librarian_address',librarian_phonenumber='$librarian_phonenumber'
		WHERE librarian_id='$librarian_id'";
		$query1=mysqli_query($connect, $update);
		if (!$query1) {
			echo "<script>alert(' Update UnSuccessful, Try Again')
			window.location='librarianUpdate.php'
			</script>";
		}
		else{
			echo "<script>alert(' Update Successful')
			window.location='bookList.php'
			</script>";
		}

	}

}

else{
	echo "<script>window.alert('Login as a Librarian First')</script>";
	echo "<script>window.location='login.php'</script>";
}

 ?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<form action="librarianUpdate.php" method = "POST" enctype="multipart/form-data">
		<fieldset>
		<legend>Update Information</legend>
		<table>
			<tr>
				<td>Name</td>
				<td>
					<input type="text" name="txtLibrarianName" required value="<?php echo $librarian_name ?>">
				</td>
			</tr>
			<tr>
				<td>Email Address</td>
				<td>
					<input type="text" name="txtLibrarianEmail" required value="<?php echo $librarian_email ?>">
				</td>
			</tr>
			<tr>
				<td>Phone Number</td>
				<td>
					<input type="text" name="txtLibrarianPhoneNumber" required value="<?php echo $librarian_phonenumber ?>">
				</td>
			</tr>
			<tr>
				<td>Address</td>
				<td>
					<input type="text" name="txtLibrarianAddress" required value="<?php echo $librarian_address ?>">
				</td>
			</tr>
			<tr>
				<td>
					<input type="hidden" value ="<?php echo $librarian_id?>" name="txtLibrarianID"/>
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
