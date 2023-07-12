<?php  
include('connection.php');
	session_start();
    if(!isset($_SESSION['librarianID']) || $_SESSION['accountType'] != "librarian"){
    echo "<script>window.alert('Login as Librarian to Access this Page')</script>";
    echo "<script>window.history.go(-1);</script>";
    }

$memberTypeID=$_GET['did'];

$delete="DELETE FROM membertype WHERE membertype_id='$memberTypeID' ";
$res=mysqli_query($connect,$delete);

if($res) 
{
	echo "<script>window.alert('Member Type Deleted!')</script>";
	echo "<script>window.location='memberTypeRegister.php'</script>";
}
else
{
	echo "<p>Something went wrong" . mysqli_error($connect) . "</p>";
}
?>