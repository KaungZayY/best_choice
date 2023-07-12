<?php 

//--------------
session_start();
include('connection.php');
include('cartfunction.php');
include('header.php');

if (isset($_POST['btnCheckout'])) {//checkout start
  if (isset($_SESSION['memberID'])) {
    // form submitted
    // get input field values
    $memberID = $_SESSION['memberID'];
    
    // get member type and allowed book limit
    $sql = "SELECT membertype.booklimit FROM membertype JOIN member ON member.membertype_id = membertype.membertype_id WHERE member.member_id = '$memberID'";
    $result = mysqli_query($connect, $sql);
    $row = mysqli_fetch_assoc($result);
    $allowed_books = $row['booklimit'];

    // check if user has reached allowed book limit
    if (count($_SESSION['CartFunctions']) > $allowed_books) {
      echo "<script>window.alert('You have reached your allowed book limit!')</script>";
      echo "<script>window.location='cart.php'</script>";
      exit();
    }

    $borrow_date = date('Y-m-d'); // get current date
    $return_date = date('Y-m-d', strtotime($borrow_date. ' + 7 days')); // add 7 days to current date

    // check if all books are in stock
    $instock = true;
    foreach ($_SESSION['CartFunctions'] as $book) {
      $book_id = $book['book_id'];
      $sql = "SELECT instock FROM book WHERE book_id = '$book_id'";
      $result = mysqli_query($connect, $sql);
      $row = mysqli_fetch_assoc($result);
      $book_instock = $row['instock'];
      if ($book_instock < 1) {
        $instock = false;
        break;
      }
    }

    if ($instock) {
      // insert data into borrowedbook table
      $sql = "INSERT INTO borrowbook (member_id, borrow_date, return_date) VALUES ('$memberID', '$borrow_date', '$return_date')";
      $result = mysqli_query($connect, $sql);

      // get the last inserted ID to use as foreign key in transition table
      $borrowedbookID = mysqli_insert_id($connect);

      // insert data into borrowedbookdetail table for each book in cart
      foreach ($_SESSION['CartFunctions'] as $book) {
        $book_id = $book['book_id'];
        $quantity = 1; // assuming each book is borrowed once
        $sql = "INSERT INTO transition (borrowbook_id, book_id, quantity, status) VALUES ('$borrowedbookID', '$book_id', '$quantity','borrowed')";
        $result = mysqli_query($connect, $sql);

        // update book stock in book table
        $sql = "UPDATE book SET instock = instock - 1 WHERE book_id = '$book_id'";
        $result = mysqli_query($connect, $sql);
      }

      // redirect to success page
      echo "<script>window.alert('Successful!')</script>";
      echo "<script>window.location='bookDisplay.php'</script>";

      // clear cart after checkout
      Clear();
      exit();
    } else {
      // some books are not in stock, show error message
      echo "<script>window.alert('Some books in your cart are out of stock. Please remove them and try again.')</script>";
      echo "<script>window.location='cart.php'</script>";
      exit();
    }
  } else {
    // member not logged in, redirect to login page
    echo "<script>window.alert('Login First!')</script>";
    echo "<script>window.location='login.php'</script>";
  }
}//checkout ends


if(isset($_POST['btnadd'])) {
  // form submitted
  // get input field values
  $book_id = $_POST['txtBookID'];
  $title = $_POST['txtTitle'];
  $author = $_POST['txtAuthor'];
  $publisher = $_POST['txtPublisher'];
  $edition = $_POST['txtEdition'];
  $instock = $_POST['txtInstock'];
  $availibility = $_POST['txtAvailibility'];

}
if(isset($_REQUEST['action'])) 
{
  $Action=$_REQUEST['action'];

  if($Action === "borrow")
  {
    $txtBookID=$_REQUEST['txtBookID'];
    $txtInstock=$_REQUEST['txtInstock'];
    Add($txtBookID,$txtInstock);
  }
  else if($Action === "Remove")
  {
    $bid=$_REQUEST['book_id'];
    Remove($bid);
  }
  else
  {
    Clear();
  }
}
else
{
  $Action="";
}

?>

<html>
<head>
    <title>Selected Books</title>
</head>
<body>
<form action="cart.php" method="POST">
<fieldset>
<legend>Your Selected Books :</legend>

<?php  

if(!isset($_SESSION['CartFunctions'])) 
{
    echo "<p>No Book Selected Here, Add Some:</p>";
    echo "<a href='bookDisplay.php'>Go To Book Shelf</a>";
}
else
{
?>
<table>
<tr>
  <th>Image</th>
  <th>ID</th>
  <th>Title</th>
  <th>Author</th>
  <th>Publisher</th>
  <th>Edition</th>
  <th>Action</th>
</tr>
<?php  
$size=count($_SESSION['CartFunctions']);

for ($i=0;$i<$size;$i++) 
{    
    $coverimage=$_SESSION['CartFunctions'][$i]['coverimage'];
    $book_id=$_SESSION['CartFunctions'][$i]['book_id'];
    $title=$_SESSION['CartFunctions'][$i]['title'];
    $author=$_SESSION['CartFunctions'][$i]['author'];
    $publisher=$_SESSION['CartFunctions'][$i]['publisher'];
    $edition=$_SESSION['CartFunctions'][$i]['edition'];

    echo "<tr>";
    echo "<td><img src='$coverimage' width='200px' height='200px'/></td>";
    echo "<td>$book_id</td>";
    echo "<td>$title</td>";
    echo "<td>$author</td>";
    echo "<td>$publisher</td>";
    echo "<td>$edition</td>";
    echo "<td><a href='cart.php?book_id=$book_id&action=Remove'>Remove</a></td>";
  echo "</tr>";
}
?>
<tr>
  <td><a href="cart.php?action=Clear">Empty Cart</a></td>
  <td><a href="bookDisplay.php">Add Book</a></td> |
  <td>
    <input type="submit" name="btnCheckout" value="Check Out" />
  </td>
</tr>

</table>
<?php 
}

?>

</fieldset>

</form>
</body>
</html>
<?php 
include('footer.php');
