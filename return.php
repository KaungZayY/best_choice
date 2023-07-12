<?php 
	include('connection.php');
	session_start();
if(!isset($_SESSION['memberID'])){
	// member not logged in, redirect to login page
    echo "<script>window.alert('Login First!')</script>";
    echo "<script>window.location='login.php'</script>";
}
else{
	$member_id=$_SESSION['memberID'];
}	

	if(isset($_GET['bid'])&&isset($_GET['bbid'])){
		$bookID=$_GET['bid'];
		$borrowbook_id=$_GET['bbid'];
		
		$insertReturnBook = "INSERT INTO returnbook (member_id, returnDate) VALUES ('$member_id', NOW())";
    if(mysqli_query($connect, $insertReturnBook)) {
        $returnbook_id = mysqli_insert_id($connect); // get the auto-generated returnbook_id
        
        
       if (isset($borrowbook_id)) {
            $insertReturnTransition = "INSERT INTO returntransition (returnbook_id, book_id) VALUES ('$returnbook_id', '$bookID')";
            mysqli_query($connect, $insertReturnTransition);
            $updateStock = "UPDATE book SET instock = instock + 1 WHERE book_id = '$bookID'";
            $runSQL = mysqli_query($connect, $updateStock);
            
            // update borrowbook and transition tables
            $updateTransition = "UPDATE transition SET status='returned' WHERE book_id='$bookID' AND borrowbook_id='$borrowbook_id'";
            mysqli_query($connect, $updateTransition);
            
            // redirect to inventory page
            echo "<script>alert('Book successfully returned.')</script>";
            echo "<script>window.location='inventory.php'</script>";
            exit();
        }
        else {
            // error in inserting returntransition data
            echo "<script>alert('Failed to return book. Please try again.')</script>";
        }
    }
    else {
        // error in inserting returnbook data
        echo "<script>alert('Failed to return book. Please try again.')</script>";
    }

	}
?>