<?php 
	session_start();
    if(!isset($_SESSION['librarianID']) || $_SESSION['accountType'] != "librarian"){
    echo "<script>window.alert('Login as Librarian to Access this Page')</script>";
    echo "<script>window.history.go(-1);</script>";
    }

	include('connection.php');
	if (isset($_REQUEST['did'])) {
		$booktype_id=$_REQUEST['did'];
		$Select="DELETE FROM booktype WHERE booktype_id='$booktype_id'";
		$query=mysqli_query($connect, $Select);
		if(!$query){
			echo "<script>alert(' Cannot Remove Current Book Type')
			window.location='bookTypeRegister.php'
			</script>";
		}
		else{
			echo "<script>alert('Book Type was removed')
			window.location='bookTypeRegister.php'
			</script>";
		}
	}
 ?>