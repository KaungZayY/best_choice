<?php 
	include('connection.php');
	if (isset($_REQUEST['gid']) && isset($_REQUEST['bid'])) {
		$genre_id=$_REQUEST['gid'];
		$book_id = $_REQUEST['bid'];
		$Select="DELETE FROM bookgenre WHERE genre_id='$genre_id' AND book_id='$book_id'";
		$query=mysqli_query($connect, $Select);
		if(!$query){
			echo "<script>alert('Cannot Remove the genre from this book')
					window.location='bookGenre.php?bid=$book_id'
					</script>";
		}
		else{
			echo "<script>alert('Genre was removed from this book')
					window.location='bookGenre.php?gid=$book_id'
					</script>";
		}
	}
 ?>
