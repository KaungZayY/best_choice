<?php 
	include('connection.php');
	include('header1.php');
	session_start();
    if(!isset($_SESSION['librarianID']) || $_SESSION['accountType'] != "librarian"){
    echo "<script>window.alert('Login as Librarian to Access this Page')</script>";
    echo "<script>window.history.go(-1);</script>";
    }
	if(isset($_POST['btnSave'])){
		$txtmembertype_name = $_POST['txtmembertype_name'];
		$txtbooklimit = $_POST['txtbooklimit'];
		$txtborrowingperiod = $_POST['txtborrowingperiod'];
		$txtstatus = $_POST['rdoStatus'];

		$checkType = "SELECT * FROM membertype WHERE membertype_name=?";
		$stmt = mysqli_prepare($connect, $checkType);
		mysqli_stmt_bind_param($stmt, "s", $txtmembertype_name);
		mysqli_stmt_execute($stmt);
		$res = mysqli_stmt_get_result($stmt);
		$count = mysqli_num_rows($res);

		if($count > 0){
			echo "<script>window.alert('Member Type Already Exist!')</script>";
			echo "<script>window.location='memberTypeRegister.php'</script>";
		}
		else{
			$Insert = "INSERT INTO membertype(membertype_name,booklimit,borrowingperiod,status)
			VALUES (?,?,?,?)";
			$stmt1 = mysqli_prepare($connect, $Insert);
			mysqli_stmt_bind_param($stmt1, "siss", $txtmembertype_name, $txtbooklimit, $txtborrowingperiod, $txtstatus);
			$res1=mysqli_stmt_execute($stmt1);
		}
		if(!$res1){
		echo "<p>Something went wrong" . mysqli_error($connect) . "</p>";
	}
		else{
			echo "<script>window.alert('Success!')</script>";
			echo "<script>window.location='memberTypeRegister.php'</script>";
	}
	}
 ?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<form action="memberTypeRegister.php" method="POST">
		<fieldset>
			<legend>Add New Member Type</legend>
			<table>
				<tr>
					<td class="bold">Type</td>
					<td><input type="text" name = "txtmembertype_name" required placeholder="student"></td>
				</tr>
				<tr>
					<td class="bold" class="bold">Book Limit</td>
					<td><input type="text" name="txtbooklimit" required placeholder="count (in number only)"></td>
				</tr>
				<tr>
					<td class="bold">Borrowing Period</td>
					<td><input type="text" name="txtborrowingperiod" required placeholder="days(in number only)"></td>
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
					<input type="submit" name="btnSave" value="Save" />
					<input type="reset" value="Cancel" />
				</td>
			</tr>
			</table>
	<?php 
	$query = "SELECT * FROM membertype";
	$res = mysqli_query($connect,$query);
	$count = mysqli_num_rows($res);

	if($count < 1){
		echo"<p>No Member Type currently Assigned, Create New One</p>";
	}
	else{
 ?>

 	<table id="tableid" class="display">
 		<thread>
 			<tr>
 				<th>Type ID</th>
 				<th>Type</th>
 				<th>Book Limit</th>
 				<th>Borrowing Period</th>
 				<th>Action</th>
 			</tr>
 		</thread>

 		<tbody>
 			<?php
 				for($i=0;$i<$count;$i++){
 					$row=mysqli_fetch_array($res);
 					$membertype_id=$row['membertype_id'];
 					$membertype_name=$row['membertype_name'];
 					$booklimit=$row['booklimit'];
 					$borrowingperiod=$row['borrowingperiod'];
 					$status=$row['status'];

 					echo "<tr>";
						echo "<td>" . $membertype_id . "</td>";
						echo "<td>" . $membertype_name . "</td>";
						echo "<td>" . $booklimit . "</td>";
						echo "<td>" . $borrowingperiod . "</td>";
						echo "<td>" . $status . "</td>";
						echo "<td>
								<a href='memberTypeUpdate.php?uid=$membertype_id'>Edit</a>
								|
								<a href='memberTypeDelete.php?did=$membertype_id'>Delete</a>
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
