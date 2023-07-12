<?php 
	session_start();
    if(!isset($_SESSION['memberID']) || $_SESSION['accountType'] != "member"){
    echo "<script>window.alert('Login to Access this Page')</script>";
    echo "<script>window.history.go(-1);</script>";
    }

	include('connection.php');
	if (isset($_REQUEST['did'])) {
		$book_id=$_REQUEST['did'];
		$member_id=$_SESSION['memberID'];
		$Select="DELETE FROM wishlist WHERE book_id='$book_id' AND member_id='$member_id'";
		$query=mysqli_query($connect, $Select);
		if(!$query){
			echo "<script>alert(' Cannot Remove Current Book')
			window.location='wishlist.php'
			</script>";
		}
		else{
			echo "<script>alert('Book was removed')
			window.location='wishlist.php'
			</script>";
		}
	}
 ?>