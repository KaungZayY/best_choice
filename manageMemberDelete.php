<?php 
	include('connection.php');
	session_start();
    if(!isset($_SESSION['librarianID']) || $_SESSION['accountType'] != "librarian"){
    echo "<script>window.alert('Login as Librarian to Access this Page')</script>";
    echo "<script>window.history.go(-1);</script>";
    }
	if (isset($_REQUEST['did'])) {
		$memberID=$_REQUEST['did'];
		$Select="DELETE FROM member WHERE member_id='$memberID'";
		$query=mysqli_query($connect, $Select);
		if(!$query){
			echo "<script>alert(' Cannot Remove Current member')
			window.location='memberList.php'
			</script>";
		}
		else{
			echo "<script>alert('Memeber was removed from the system')
			window.location='memberList.php'
			</script>";
		}
	}
 ?>