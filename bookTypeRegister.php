<?php 
	include('connection.php');
	include('header1.php');
	session_start();
    if(!isset($_SESSION['librarianID']) || $_SESSION['accountType'] != "librarian"){
    echo "<script>window.alert('Login as Librarian to Access this Page')</script>";
    echo "<script>window.history.go(-1);</script>";
    }
    
	if(isset($_POST['btnSave'])){
		$txtbooktype_name = $_POST['txtbooktype_name'];


		$checkType = "SELECT * FROM booktype WHERE booktype_name=?";
		$stmt = mysqli_prepare($connect, $checkType);
		mysqli_stmt_bind_param($stmt, "s", $txtbooktype_name);
		mysqli_stmt_execute($stmt);
		$res = mysqli_stmt_get_result($stmt);
		$count = mysqli_num_rows($res);

		if($count > 0){
			echo "<script>window.alert('Book Type Already Exist!')</script>";
			echo "<script>window.location='bookTypeRegister.php'</script>";
		}
		else{
			$Insert = "INSERT INTO booktype(booktype_name)
			VALUES (?)";
			$stmt1 = mysqli_prepare($connect, $Insert);
			mysqli_stmt_bind_param($stmt1, "s", $txtbooktype_name);
			$res1=mysqli_stmt_execute($stmt1);
		}
		if(!$res1){
		echo "<p>Something went wrong" . mysqli_error($connect) . "</p>";
	}
		else{
			echo "<script>window.alert('Success!')</script>";
			echo "<script>window.location='bookTypeRegister.php'</script>";
	}
	}
 ?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<form action="bookTypeRegister.php" method="POST">
		<fieldset>
			<legend>Add New Book Type</legend>
			<table>
				<tr>
					<td class="bold">Type</td>
					<td><input type="text" name = "txtbooktype_name" required placeholder="novel"></td>
				</tr>
				<tr>
				<tr>
					<td></td>
					<td>
					<input type="submit" name="btnSave" value="Save" />
					<input type="reset" value="Cancel" />
				</td>
				</tr>
				
				
			</table>
	<?php 
	$query = "SELECT * FROM booktype";
	$res = mysqli_query($connect,$query);
	$count = mysqli_num_rows($res);

	if($count < 1){
		echo"<p>No Book Type currently Assigned, Add New One</p>";
	}
	else{
 ?>

 	<table id="tableid" class="display">
 		<thread>
 			<tr>
 				<th>ID</th>
 				<th>Type</th>
 				<th>Action</th>
 			</tr>
 		</thread>

 		<tbody>
 			<?php
 				for($i=0;$i<$count;$i++){
 					$row=mysqli_fetch_array($res);
 					$booktype_id=$row['booktype_id'];
 					$booktype_name=$row['booktype_name'];

 					echo "<tr>";
						echo "<td>" . $booktype_id . "</td>";
						echo "<td>" . $booktype_name . "</td>";
						echo "<td>
								<a href='bookTypeUpdate.php?uid=$booktype_id'>Edit</a>
								|
								<a href='bookTypeDelete.php?did=$booktype_id'>Delete</a>
				  			</td>";
					echo "</tr>";
 				}
 			 ?>
 		</tbody>
 	</table>

 <?php 
	}
  ?>

		</fieldset>
	</form>
</body>
</html>
<?php 
include('footer1.php');
