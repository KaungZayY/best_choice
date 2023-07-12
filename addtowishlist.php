<?php 
include('connection.php');
session_start();
if(!isset($_SESSION['memberID'])){
    // member not logged in, redirect to login page
    echo "<script>window.alert('Login First!')</script>";
    echo "<script>window.location='login.php'</script>";
}
if(isset($_REQUEST['book_id'])){
    $book_id = $_REQUEST['book_id'];
    $member_id = $_SESSION['memberID'];
    $select="SELECT * FROM wishlist WHERE member_id='$member_id' AND book_id='$book_id'";
    $result=mysqli_query($connect,$select);
    if($result) {
        $count=mysqli_num_rows($result);
        if($count > 0) {
            // Book is already in the wishlist list, show message to the user
            echo "<script>window.alert('Book is already in the wishlist list.')</script>";
            echo "<script>window.location='bookDisplay.php'</script>";
            exit();
        }
        else{
            // Add book to wishlist list
            $insert="INSERT INTO wishlist(member_id, book_id) VALUES ('$member_id','$book_id')";
            mysqli_query($connect,$insert);

            echo "<script>window.alert('Book added to wishlist list.')</script>";
            echo "<script>window.location='bookDisplay.php'</script>";
            exit();
        }
    } else {
        echo "<script>window.alert('Query execution failed.')</script>";
        echo "<script>window.location='bookDisplay.php'</script>";
        exit();
    }
}
else{
    echo "<script>window.alert('Select the book First!')</script>";
    echo "<script>window.location='bookDisplay.php'</script>";
    exit();
}
?>
