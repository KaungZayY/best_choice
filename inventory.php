<?php 
include('connection.php');
include('header.php');
session_start();
if(!isset($_SESSION['memberID'])){
	// member not logged in, redirect to login page
    echo "<script>window.alert('Login First!')</script>";
    echo "<script>window.location='login.php'</script>";
}
else{
	$member_id=$_SESSION['memberID'];
	$select = "SELECT DISTINCT bb.borrowbook_id FROM borrowbook bb JOIN transition t ON bb.borrowbook_id = t.borrowbook_id WHERE bb.member_id='$member_id' AND t.status='borrowed'";
	$result = mysqli_query($connect, $select); 
}

// handle "Return All" button click
if(isset($_POST['btnReturnAll'])) {
    // insert data to returnbook table
    $insertReturnBook = "INSERT INTO returnbook (member_id, returnDate) VALUES ('$member_id', NOW())";
    if(mysqli_query($connect, $insertReturnBook)) {
        $returnbook_id = mysqli_insert_id($connect); // get the auto-generated returnbook_id

        // insert data to returntransition table for each borrowed book
        while ($data = mysqli_fetch_assoc($result)) {
            $borrowbook_id = $data['borrowbook_id'];
            $select1 = "SELECT book_id FROM transition WHERE borrowbook_id='$borrowbook_id' AND status='borrowed'";
            $result1 = mysqli_query($connect, $select1);
            while ($data1 = mysqli_fetch_assoc($result1)) {
                $bookID = $data1['book_id'];
                $insertReturnTransition = "INSERT INTO returntransition (returnbook_id, book_id) VALUES ('$returnbook_id', '$bookID')";
                mysqli_query($connect, $insertReturnTransition);
                $updateStock = "UPDATE book SET instock = instock + 1 WHERE book_id = '$bookID'";
                $runSQL = mysqli_query($connect, $updateStock);
            }
        }

        // update borrowbook and transition tables
        $updateTransition = "UPDATE transition SET status='returned' WHERE borrowbook_id IN (SELECT borrowbook_id FROM borrowbook WHERE member_id='$member_id')";
        mysqli_query($connect, $updateTransition);

        // redirect to inventory page
        echo "<script>alert('Books successfully returned.')</script>";
        echo "<script>window.location='inventory.php'</script>";
        exit();
    }
    else {
        // error in inserting returnbook data
        echo "<script>alert('Failed to return books. Please try again.')</script>";
    }
}



?>
<html>
<head>
	<title></title>
</head>
<body>
	<form action="inventory.php" method="POST">
    <fieldset>
        <legend>Borrowed Books</legend>
        <?php 
        if(mysqli_num_rows($result) == 0) {
            echo "<p>No books borrowed yet.</p>";
        }
        else {
        ?>
        <table>
            <tr>
                <th>Title</th>
                <th>Image</th>
                <th>Author</th>
                <th>Publisher</th>
                <th>Edition</th>
                <th>Action</th>
            </tr>
            <?php 
            while ($data = mysqli_fetch_assoc($result)) {
                $borrowbook_id = $data['borrowbook_id'];
                $select1 = "SELECT book_id FROM transition WHERE borrowbook_id='$borrowbook_id' AND status='borrowed'";
                $result1 = mysqli_query($connect, $select1);
                while ($data1 = mysqli_fetch_assoc($result1)) {
                    $bookID = $data1['book_id'];
                    $select2 = "SELECT * FROM book WHERE book_id='$bookID'";
                    $query = mysqli_query($connect, $select2);
                    $data2 = mysqli_fetch_array($query);
                    $title = $data2['title'];
                    $coverImage = $data2['coverimage'];
                    $author = $data2['author'];
                    $publisher = $data2['publisher'];
                    $edition = $data2['edition'];
                    echo "<tr>
                    <td>$title</td>
                    <td><img src='$coverImage' width='200px' height='200px'></td>
                    <td>$author</td>
                    <td>$publisher</td>
                    <td>$edition</td>
                    <td>
            			<input type='hidden' name='borrowbook_id' value='$borrowbook_id'/>
           				<input type='hidden' name='bookID' value='$bookID' />
           				<a href='return.php?bid=$bookID&bbid=$borrowbook_id'>Return</a>
        			</td>
                    </tr>";
                }
            }
            ?>
            <tr>
                <td>
                    <input type="submit" name="btnReturnAll" value="Return All" />
                </td>
            </tr>
        </table>
        <?php } ?>
    </fieldset>
</form>
</body>
</html>
<?php 
include('footer.php');
