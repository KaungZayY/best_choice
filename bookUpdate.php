<?php 
include('connection.php');
include('header1.php');
	session_start();
    if(!isset($_SESSION['librarianID']) || $_SESSION['accountType'] != "librarian"){
    echo "<script>window.alert('Login as Librarian to Access this Page')</script>";
    echo "<script>window.history.go(-1);</script>";
    }
if(isset($_REQUEST['uit'])){
    $book_id = $_REQUEST['uit'];
    $select = "SELECT * FROM book WHERE book_id=?";
    $stmt = mysqli_prepare($connect, $select);
    mysqli_stmt_bind_param($stmt, 'i', $book_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $data = mysqli_fetch_array($result);
    $book_id = $data['book_id'];
    $title = $data['title'];
    $author = $data['author'];
    $publisher = $data['publisher'];
    $edition = $data['edition'];
    $numberofcopy = $data['numberofcopy'];
    $instock = $data['instock'];
    $booktype_id = $data['booktype_id'];
}
if(isset($_POST['btnUpdate'])){
    $book_id = $_POST['txtBookID'];
    $title = $_POST['txtTitle'];
    $author = $_POST['txtAuthor'];
    $publisher = $_POST['txtPublisher'];
    $edition = $_POST['txtEdition'];
    $numberofcopy = $_POST['txtNumberOfCopy'];
    $instock = $_POST['txtInstock'];
    $booktype_id = $_POST['cboBookTypeID'];

    $update = "UPDATE book SET title=?, author=?, publisher=?, edition=?, numberofcopy=?, instock=?, booktype_id=? WHERE book_id=?";
    $stmt = mysqli_prepare($connect, $update);
    mysqli_stmt_bind_param($stmt, 'ssssiiii', $title, $author, $publisher, $edition, $numberofcopy, $instock, $booktype_id, $book_id);
    $query1 = mysqli_stmt_execute($stmt);
    if (!$query1) {
        echo "<script>alert('Update Unsuccessful, Try Again')
        window.location='bookList.php'
        </script>";
    }
    else{
        echo "<script>alert('Update Successful')
        window.location='bookList.php'
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
	<form action="bookUpdate.php" method = "POST">
		<fieldset>
		<legend>Book Update</legend>
		<table>
			<tr>
				<td class="bold">Title</td>
				<td>
					<input type="text" name="txtTitle" required value="<?php echo $title ?>">
				</td>
			</tr>
			<tr>
				<td class="bold">author</td>
				<td>
					<input type="text" name="txtAuthor" required value="<?php echo $author ?>">
				</td>
			</tr>
			<tr>
				<td class="bold">Publisher</td>
				<td>
					<input type="text" name="txtPublisher" required value="<?php echo $publisher ?>">
				</td>
			</tr>
			<tr>
				<td class="bold">Edition</td>
				<td>
					<input type="number" name="txtEdition" min="0" max="100" required value="<?php echo $edition ?>">
				</td>
			</tr>
			<tr>
				<td class="bold">Book Type</td>
				<td>
					<select name="cboBookTypeID">
						<?php 
							$select="SELECT * FROM booktype";
							$query=mysqli_query($connect,$select);
							$count=mysqli_num_rows($query);
							for($i=0;$i<$count;$i++)
						{
							$data=mysqli_fetch_array($query);
							$booktype_id=$data['booktype_id'];
							$booktype_name=$data['booktype_name'];
							echo "<option value='$booktype_id'>
								$booktype_name
							</option>";
						}
						 ?>
					</select>
				</td>
			</tr>
			<tr>
				<td class="bold">Number of Copy</td>
				<td>
					<input type="number" name="txtNumberOfCopy" min="0" max="1000" required value="<?php echo $numberofcopy ?>">
				</td>
			</tr>
			<tr>
				<td class="bold">Instock</td>
				<td>
					<input type="number" name="txtInstock" min="0" max="1000" required value="<?php echo $instock ?>">
				</td>
			</tr>
			<tr>
				<td>
					<input type="hidden" name="txtBookID" required value="<?php echo $book_id ?>">
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
