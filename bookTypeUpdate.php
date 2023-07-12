<?php 
	include('connection.php');
	include('header1.php');
	session_start();
    if(!isset($_SESSION['librarianID']) || $_SESSION['accountType'] != "librarian"){
    echo "<script>window.alert('Login as Librarian to Access this Page')</script>";
    echo "<script>window.history.go(-1);</script>";
    }
	if(isset($_REQUEST['uid'])){
		$booktype_id=$_REQUEST['uid'];
		$select="SELECT * FROM booktype WHERE booktype_id=?";
		$stmt = mysqli_prepare($connect, $select);
		mysqli_stmt_bind_param($stmt, "i", $booktype_id);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);
		$data = mysqli_fetch_array($result);
		$booktype_name=$data['booktype_name'];
	}
	if (isset($_POST['btnUpdate'])) {
		$booktype_id=$_POST['txtbooktype_id'];
		$booktype_name=$_POST['txtbooktype_name'];
		$update="UPDATE booktype SET booktype_name=? WHERE booktype_id=?";
		$stmt = mysqli_prepare($connect, $update);
		mysqli_stmt_bind_param($stmt, "si", $booktype_name, $booktype_id);
		$query1=mysqli_stmt_execute($stmt);
		if ($query1) {
			echo "<script>alert('Book Type Update Successful')
			window.location='bookTypeRegister.php'
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
	<form action="bookTypeUpdate.php" method="POST">
		<fieldset>
			<legend>Update Type of Book</legend>
			<table>
				<tr>
					<td class="bold">Type</td>
					<td><input type="text" name = "txtbooktype_name" required value="<?php echo $booktype_name ?>"></td>
				</tr>
				<tr>
				<tr>
					<td></td>
					<td>
					<input type="hidden" value ="<?php echo $booktype_id?>" name="txtbooktype_id"/>
					<input type="submit" name="btnUpdate" value="Update" />
					<input type="reset" value="Cancel" onclick="goBack()" />
					<script>
					function goBack() {
					  window.location.href = "bookTypeRegister.php";
					}
					</script>

				</td>
				</tr>
				
			</tr>
			</table>
		</fieldset>
	</form>
</body>
</html>
<?php 
include('footer1.php');
