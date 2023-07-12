<?php 
	include('connection.php');
	session_start();
    if(!isset($_SESSION['librarianID']) || $_SESSION['accountType'] != "librarian"){
    echo "<script>window.alert('Login as Librarian to Access this Page')</script>";
    echo "<script>window.history.go(-1);</script>";
    }
	if (isset($_REQUEST['did'])) {
		$librarianID=$_REQUEST['did'];
		$Select="DELETE FROM librarian WHERE librarian_id='$librarianID'";
		$query=mysqli_query($connect, $Select);
		if(!$query){
			echo "<script>alert(' Cannot Remove Current User')
			window.location='librarianList.php'
			</script>";
		}
		else{
			echo "<script>alert('User was removed')
			window.location='librarianList.php'
			</script>";
		}
	}
 ?>