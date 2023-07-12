<?php 
	include('connection.php');
	include('header1.php');
	session_start();
    if(!isset($_SESSION['librarianID']) || $_SESSION['accountType'] != "librarian"){
    echo "<script>window.alert('Login as Librarian to Access this Page')</script>";
    echo "<script>window.history.go(-1);</script>";
    }

	if(isset($_POST['btnSave'])){
		$txtgenre_name = $_POST['txtgenre_name'];


		$checkType = "SELECT * FROM genre WHERE genre_name=?";
		$stmt = mysqli_prepare($connect, $checkType);
		mysqli_stmt_bind_param($stmt, "s", $txtgenre_name);
		mysqli_stmt_execute($stmt);
		$res = mysqli_stmt_get_result($stmt);
		$count = mysqli_num_rows($res);

		if($count > 0){
			echo "<script>window.alert('This Genre Already Exist!')</script>";
			echo "<script>window.location='genreRegister.php'</script>";
		}
		else{
			$Insert = "INSERT INTO genre(genre_name)
			VALUES (?)";
			$stmt1 = mysqli_prepare($connect, $Insert);
			mysqli_stmt_bind_param($stmt1, "s", $txtgenre_name);
			$res1=mysqli_stmt_execute($stmt1);
		}
		if(!$res1){
		echo "<p>Something went wrong" . mysqli_error($connect) . "</p>";
	}
		else{
			echo "<script>window.alert('Success!')</script>";
			echo "<script>window.location='genreRegister.php'</script>";
	}
	}
 ?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<form action="genreRegister.php" method="POST">
		<fieldset>
			<legend>Add New Genre</legend>
			<table>
				<tr>
					<td class="bold">Type</td>
					<td><input type="text" name = "txtgenre_name" required placeholder="romance"></td>
				</tr>
				<tr>
				<td></td>
				<td>
					<input type="submit" name="btnSave" value="Save" />
					<input type="reset" value="Cancel" />
				</td>
				</tr>
			</table>
	<?php 
	$query = "SELECT * FROM genre";
	$res = mysqli_query($connect,$query);
	$count = mysqli_num_rows($res);

	if($count < 1){
		echo"<p>No Genre currently Assigned, Add New One</p>";
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
 					$genre_id=$row['genre_id'];
 					$genre_name=$row['genre_name'];

 					echo "<tr>";
						echo "<td>" . $genre_id . "</td>";
						echo "<td>" . $genre_name . "</td>";
						echo "<td>
								<a href='genreUpdate.php?uid=$genre_id'>Edit</a>
								|
								<a href='genreDelete.php?did=$genre_id'>Delete</a>
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
