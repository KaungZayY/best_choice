<?php
include('connection.php');
session_start();

if(!isset($_SESSION['memberID'])){
    // member not logged in, redirect to login page
    echo "<script>window.alert('Login First!')</script>";
    echo "<script>window.location='login.php'</script>";
}

// Check if the form has been submitted
if(isset($_POST['submit'])) {
  // Get the comment, member ID, and book ID from the form
  $comment = $_POST['comment'];
  $member_id = $_SESSION['memberID'];
  $book_id = $_POST['book_id'];

  // Insert the review into the database
  $sql = "INSERT INTO review (member_id, book_id, book_review) VALUES ('$member_id', '$book_id', '$comment')";

  if(mysqli_query($connect, $sql)) {
    echo "<script>window.alert('Successful!')</script>";
    echo "<script>window.location='bookDetail.php?bid=$book_id'</script>";
  } else {
    echo "Error: " . mysqli_error($connect);
  }
  
} else if(isset($_POST['submit_rating'])) {
  // Get the rating, member ID, and book ID from the form
  $rating = $_POST['rating'];
  $member_id = $_SESSION['memberID'];
  $book_id = $_POST['book_id'];

  // Check if the member has already rated the book
  $check_sql = "SELECT * FROM rating WHERE member_id='$member_id' AND book_id='$book_id'";
  $check_result = mysqli_query($connect, $check_sql);

  if(mysqli_num_rows($check_result) > 0) {
    echo "<script>window.alert('You have already rated this book!')</script>";
    echo "<script>window.location='bookDetail.php?bid=$book_id'</script>";
  } else {
    // Insert the rating into the database
    $insert_sql = "INSERT INTO rating (member_id, book_id, rating) VALUES ('$member_id', '$book_id', '$rating')";

    if(mysqli_query($connect, $insert_sql)) {
      echo "<script>window.alert('Successful!')</script>";
      echo "<script>window.location='bookDetail.php?bid=$book_id'</script>";
    } else {
      echo "Error: " . mysqli_error($connect);
    }
  }
}

// Close the database connection
mysqli_close($connect);
?> 