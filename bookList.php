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
 	<form action="bookList.php" method="POST">
 		<fieldset>
 			<legend>Books</legend>
 			<label for="search">Search by Title:</label>
	        <input type="text" name="search" id="search">
	        <input type="submit" name="submit" value="Search">
	        <a href="bookList.php?sort=title">Sort by Title</a>
	        <br><br>
 			<table>
 				<tr>
 					<th>ID</th>
 					<th>Title</th>
 					<th>Image</th>
 					<th>Author</th>
 					<th>Publisher</th>
 					<th>Edition</th>
 					<th>Number of Copy</th>
 					<th>availability</th>
 					<th>Book Type</th>
 					<th>Action</th>
 				</tr>
 				<tr>
 					<?php 
                        
                        // Check for sorting parameter
                        $sort = isset($_POST['sortBtn']) ? $_POST['sortBtn'] : '';
                        
                        // Modify query based on sorting parameter
                        if ($sort == 'asc') {
                            $select="SELECT * FROM book ORDER BY title ASC";
                        } else {
                            $select="SELECT * FROM book";
                        }

                        // Check for search parameter
                        $search = isset($_POST['search']) ? $_POST['search'] : '';

                        // Modify query based on search parameter
                        if (!empty($search)) {
                            $select="SELECT * FROM book WHERE title LIKE '%$search%'";
                        }
                        $query = mysqli_query($connect, $select);
                        $count = mysqli_num_rows($query);
                        
                        for($i = 0; $i < $count; $i++) {
                            $data = mysqli_fetch_array($query);
                            $bookID = $data['book_id'];
                            $title = $data['title'];
                            $coverImage = $data['coverimage'];
                            $author = $data['author'];
                            $publisher = $data['publisher'];
                            $edition = $data['edition'];
                            $numberOfCopy = $data['numberofcopy'];
                            $instock = $data['instock'];
                            $bookTypeID = $data['booktype_id'];
                            
                            $select1 = "SELECT booktype_name FROM booktype WHERE booktype_id='$bookTypeID'";
                            $query1 = mysqli_query($connect, $select1);
                            $data1 = mysqli_fetch_array($query1);
                            $bookType = $data1['booktype_name'];
                            
                            echo "<tr>
                                <td>$bookID</td>
                                <td>$title</td>
                                <td>$coverImage</td>
                                <td>$author</td>
                                <td>$publisher</td>
                                <td>$edition</td>
                                <td>$numberOfCopy</td>
                                <td>$instock</td>
                                <td>$bookType</td>
                                <td>
                                    <a href='bookUpdate.php?uit=$bookID'>Update</a> | 
                                    <a href='bookDelete.php?did=$bookID'>Remove</a> |
                                    <a href='bookGenre.php?gid=$bookID'>Add Genre</a>
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
