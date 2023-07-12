<?php 
	include('connection.php');
	include('header1.php');
	session_start();
    if(!isset($_SESSION['librarianID']) || $_SESSION['accountType'] != "librarian"){
    echo "<script>window.alert('Login as Librarian to Access this Page')</script>";
    echo "<script>window.history.go(-1);</script>";
    }
	if(isset($_REQUEST['uid'])){
		$genre_id=$_REQUEST['uid'];
		$select="SELECT * FROM genre WHERE genre_id=?";
		$stmt = mysqli_prepare($connect, $select);
		mysqli_stmt_bind_param($stmt, "i", $genre_id);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);
		$data = mysqli_fetch_array($result);
		$genre_name=$data['genre_name'];
	}
	if (isset($_POST['btnUpdate'])) {
		$genre_id=$_POST['txtgenre_id'];
		$genre_name=$_POST['txtgenre_name'];
		$update="UPDATE genre SET genre_name=? WHERE genre_id=?";
		$stmt = mysqli_prepare($connect, $update);
		mysqli_stmt_bind_param($stmt, "si", $genre_name, $genre_id);
		$query1=mysqli_stmt_execute($stmt);
		if ($query1) {
			echo "<script>alert('Genre Update Successful')
			window.location='genreRegister.php'
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
	<form action="genreUpdate.php" method="POST">
		<fieldset>
			<legend>Update Genre</legend>
			<table>
				<tr>
					<td class="bold">Type</td>
					<td><input type="text" name = "txtgenre_name" required value="<?php echo $genre_name ?>"></td>
				</tr>
				<tr>
					<td></td>
				<td>
					<input type="hidden" value ="<?php echo $genre_id?>" name="txtgenre_id"/>
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