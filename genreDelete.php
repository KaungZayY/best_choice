<?php 
	include('connection.php');
	session_start();
    if(!isset($_SESSION['librarianID']) || $_SESSION['accountType'] != "librarian"){
    echo "<script>window.alert('Login as Librarian to Access this Page')</script>";
    echo "<script>window.history.go(-1);</script>";
    }
	if (isset($_REQUEST['did'])) {
		$genre_id=$_REQUEST['did'];
		$Select="DELETE FROM genre WHERE genre_id='$genre_id'";
		$query=mysqli_query($connect, $Select);
		if(!$query){
			echo "<script>alert(' Cannot Remove Current Genre')
			window.location='genreRegister.php'
			</script>";
		}
		else{
			echo "<script>alert('Genre was removed')
			window.location='genreRegister.php'
			</script>";
		}
	}
 ?>