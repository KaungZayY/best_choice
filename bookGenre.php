<?php 
include('connection.php');
include('header1.php');
if(isset($_REQUEST['gid'])){
		$bookID=$_REQUEST['gid'];
		$select="SELECT * FROM book WHERE book_id=?";
		$stmt = mysqli_prepare($connect, $select);
		mysqli_stmt_bind_param($stmt, "i", $bookID);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);
		$data = mysqli_fetch_array($result);
		$title=$data['title'];
		$book_id=$data['book_id'];
	}

	if(isset($_POST['btnSave'])){
    	$title = $_POST['title'];
    	$cboGenreID = $_POST['cboGenreID'];
   		$book_id = $_POST['book_id'];
		$checkbookgenre = "SELECT genre_id, book_id FROM bookgenre WHERE genre_id=? AND book_id=?";
		$stmt = mysqli_prepare($connect, $checkbookgenre);
		mysqli_stmt_bind_param($stmt, 'ii', $cboGenreID, $book_id);
		mysqli_stmt_execute($stmt);
		$res = mysqli_stmt_get_result($stmt);
		if($res === false){
			echo"Error: ".mysqli_error($connect);
		}
		elseif (mysqli_num_rows($res) > 0){
			echo"<script>window.alert('This book is assigned to this genre')</script>";
			
		}
		else{
			$insertQuery = "INSERT INTO bookgenre (genre_id, book_id)
				VALUES (?, ?)";
				$insertStmt = mysqli_prepare($connect, $insertQuery);
				mysqli_stmt_bind_param($insertStmt, 'ii', $cboGenreID, $book_id);
				$res1 = mysqli_stmt_execute($insertStmt);
				if(!$res1){
					echo"<p>Opps! Something went wrong".mysqli_error($connect)."</p>";
				}
				else{
					echo "<script>alert('New Genre Successfully Assigned')
					window.location='bookGenre.php?gid=$book_id'
					</script>";
				}
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<form action="bookGenre.php" method="POST">
		<fieldset>
			<legend>Add Genres to Book</legend>
			<table>
				<tr>
					<td class="bold">Title</td>
					<td><input type="text" name = "title" value="<?php echo $title ?>" readonly></td>
					<td><input type="hidden" name = "book_id" value="<?php echo $book_id ?>"></td>
				</tr>
				<tr>
				<td class="bold">Genre</td>
				<td>
					<select name="cboGenreID">
						<?php 
							$select="SELECT * FROM genre";
							$query=mysqli_query($connect,$select);
							$count=mysqli_num_rows($query);
							for($i=0;$i<$count;$i++)
						{
							$data=mysqli_fetch_array($query);
							$genre_id=$data['genre_id'];
							$genre_name=$data['genre_name'];
							echo "<option value='$genre_id'>
								$genre_name
							</option>";
						}
						 ?>
					</select>
				</td>
			</tr>
				<tr>
				<td>
					<td></td>
					<input type="submit" name="btnSave" value="Save" />
					<input type="reset" value="Cancel" />
				</td>
				</tr>
			</table>
<?php 
	$query = "SELECT genre_id FROM bookgenre WHERE book_id='$book_id'";
	$res = mysqli_query($connect,$query);
	$count = mysqli_num_rows($res);

	if($count < 1){
		echo"<p>No Genre currently Assigned, Add New One</p>";
	}
   	else{
 ?>

 	<table>
 		<thread>
 			<tr>
 				<th>ID</th>
 				<th>Genre</th>
 				<th>Action</th>
 			</tr>
 		</thread>

 		<tbody>
 			<?php
 				for($i=0;$i<$count;$i++){
 					$row=mysqli_fetch_array($res);
 					$genre_id=$row['genre_id'];
 					$select="SELECT * FROM genre WHERE genre_id=?";
					$stmt = mysqli_prepare($connect, $select);
					mysqli_stmt_bind_param($stmt, "i", $genre_id);
					mysqli_stmt_execute($stmt);
					$result = mysqli_stmt_get_result($stmt);
					$data = mysqli_fetch_array($result);
					$genre_name=$data['genre_name'];

 					echo "<tr>";
						echo "<td>" . $genre_id . "</td>";
						echo "<td>" . $genre_name . "</td>";
						echo "<td>
								<a href='bookGenreDelete.php?gid=$genre_id&bid=$book_id'>Delete</a>
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
