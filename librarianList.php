<?php 
	include('connection.php');
	include('header1.php');
	session_start();
    if(!isset($_SESSION['librarianID']) || $_SESSION['accountType'] != "librarian"){
    echo "<script>window.alert('Login as Librarian to Access this Page')</script>";
    echo "<script>window.history.go(-1);</script>";
    }
 ?>

 <html>
 <head>
 	<title></title>
 </head>
 <body>
 	<form action="librarianList.php" method="POST">
 		<fieldset>
 			<legend>Librarians</legend>
 			<label for="search">Search by Name:</label>
	        <input type="text" name="search" id="search">
	        <input type="submit" name="submit" value="Search">
	        <br><br>
 			<table>
 				<tr>
 					<th>ID</th>
 					<th>Image</th>
 					<th>Name</th>
 					<th>Email</th>
 					<th>Address</th>
 					<th>Phone No</th>
 					<th>Action</th>
 				</tr>
 				<tr>
 					<?php 
	 					// Check for sorting parameter
						$sort = isset($_POST['sortBtn']) ? $_POST['sortBtn'] : '';
						
						// Modify query based on sorting parameter
						if ($sort == 'asc') {
							$select="SELECT * FROM librarian ORDER BY librarian_name ASC";
						} else {
							$select="SELECT * FROM librarian";
						}

						// Check for search parameter
						$search = isset($_POST['search']) ? $_POST['search'] : '';

						// Modify query based on search parameter
						if (!empty($search)) {
							$select="SELECT * FROM librarian WHERE librarian_name LIKE '%$search%'";
						}

						$query=mysqli_query($connect, $select);
						$count=mysqli_num_rows($query);
						for($i=0;$i<$count;$i++)
						{
							$data=mysqli_fetch_array($query);
							$librarianID=$data['librarian_id'];
							$librarianImage=$data['librarian_image'];
							$librarianName=$data['librarian_name'];
							$librarianEmail=$data['librarian_email'];
							$librarianPassword=$data['librarian_password'];
							$librarianAddress=$data['librarian_address'];
							$librarianPhoneNumber=$data['librarian_phonenumber'];
							echo "<tr>
								<td>$librarianID</td>
								<td>$librarianImage</td>
								<td>$librarianName</td>
								<td>$librarianEmail</td>
								<td>$librarianAddress</td>
								<td>$librarianPhoneNumber</td>
								<td>
								<a href='manageLibrarianUpdate.php?uit=$librarianID'>Update</a> | 
								<a href='manageLibrarianDelete.php?did=$librarianID'>Delete</a>
								</td>
								</tr>";
						}
 					?>
 				</tr>
 			</table>
 			<br>
 			<button type="submit" name="sortBtn" value="asc">Sort by Name (A-Z)</button>
 		</fieldset>
 	</form>
 </body>
 </html>
 <?php 
include('footer1.php');

