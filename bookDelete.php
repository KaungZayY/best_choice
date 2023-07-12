<?php 
	session_start();
    if(!isset($_SESSION['librarianID']) || $_SESSION['accountType'] != "librarian"){
    echo "<script>window.alert('Login as Librarian to Access this Page')</script>";
    echo "<script>window.history.go(-1);</script>";
    }

	include('connection.php');
	if (isset($_REQUEST['did'])) {
		$book_id=$_REQUEST['did'];
		$Select="DELETE FROM book WHERE book_id='$book_id'";
		$query=mysqli_query($connect, $Select);
		if(!$query){
			echo "<script>alert(' Cannot Remove Current Book')
			window.location='bookList.php'
			</script>";
		}
		else{
			echo "<script>alert('Book was removed')
			window.location='bookList.php'
			</script>";
		}
	}
 ?>