<?php 
session_start();
include('header.php');
include('connection.php');
    
    if (isset($_REQUEST['bid']))
    {
    $_SESSION['bid']=$_REQUEST['bid'];
    $book_id=$_REQUEST['bid'];
    $select="SELECT * FROM book
     WHERE book_id='$book_id'";
    $result=mysqli_query($connect,$select);
    $data=mysqli_fetch_array($result);
    $instock = $data['instock'];
        if($instock<0){
            $availability = "Not Available Yet";
        }
        else{
            $availability = "Available";
        }
    }
    else 
    {
        echo "<script>window.alert('View the Shelf')</script>";
        echo "<script>window.location='bookDisplay.php'</script>";
    }
   if(isset($_POST['btnadd']))
{
    $book_id=$_POST['txtBookID'];
    $title=$_POST['txtTitle'];
    $author=$_POST['txtAuthor'];
    $publisher=$_POST['txtPublisher']; 
    $edition=$_POST['txtEdition'];
    $instock=$_POST['txtInstock'];
    $availibility=$_POST['txtAvailibility'];

    // Add book to cart
    if(!isset($_SESSION['cart'])){
        $_SESSION['cart'] = array();
    }
    $book = array(
        'book_id' => $book_id,
        'title' => $title,
        'author' => $author,
        'publisher' => $publisher,
        'edition' => $edition,
        'instock' => $instock,
        'availability' => $availability
    );
    array_push($_SESSION['cart'], $book);

    echo "<script>window.alert('Book added to cart!')</script>";
    echo "<script>window.location='bookDisplay.php'</script>";
}

?>
    <!DOCTYPE html>
    <html>
    <head>
        <title></title>
    </head>
    <body>
        <a href="addtofavouriate.php?book_id=<?php echo $data['book_id']; ?>">Add to Favourite</a>
        <a href="addtowishlist.php?book_id=<?php echo $data['book_id']; ?>">Add to WishList</a>
        
        <form action="cart.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="txtBookID" value="<?php echo $data['book_id']; ?>">
            <input type="hidden" name="action" value="borrow"/>
        <table>
            <tr>
                <td><img src="<?php echo $data['coverimage']?>" width="200" height="300"></td>
                <td>
                    <table>
                        <tr>
                            <td class="bold">Title:</td>
                            <td>
                                <input type="text" readonly name="txtTitle" value="<?php echo $data['title'];?>" />
                            </td>
                        </tr>
                        <tr>
                            <td class="bold">Author:</td>
                            <td>
                                <input type="text" readonly name="txtAuthor" value="<?php echo $data['author'];?>" />
                            </td>
                        </tr>
                        <tr>
                            <td class="bold">Publisher:</td>
                            <td>
                                <input type="text" readonly name="txtPublisher" value="<?php echo $data['publisher'];?>" />
                            </td>
                        </tr>
                        <tr>
                            <td class="bold">Edition:</td>
                            <td>
                                <input type="text" readonly name="txtEdition" value="<?php echo $data['edition'];?>" />
                            </td>
                        </tr>
                        <tr>
                        <tr>
                            <td class="bold">Instock:</td>
                            <td>
                                <input type="text" readonly name="txtInstock" value="<?php echo $data['instock'];?>" />
                            </td>
                        </tr>
                        <tr>
                            <td class="bold">Availability:</td>
                            <td>
                                <input type="text" readonly name="txtAvailibility" value="<?php echo $availability;?>" />
                            </td>
                        </tr>
                        <tr>
                            <td class="bold">Book Type:</td>
                            <td>
                                <?php 
                                $booktype_id = $data['booktype_id'];
                                $select="SELECT booktype_name FROM booktype WHERE booktype_id='$booktype_id'";
                                $query=mysqli_query($connect,$select);
                                $count=mysqli_num_rows($query);
                                while($data=mysqli_fetch_array($query)) {
                                   echo '<input type="text" name="txtBookType" value="' . $data['booktype_name'] . '" readonly>';
                                }
                                ?>  
                            </td>
                        </tr>
                        <tr>
                            <td class="bold">Associated Genres:</td>
                            <td>
                                <?php 
                                $query = "SELECT genre_id FROM bookgenre WHERE book_id='$book_id'";
                                $res = mysqli_query($connect,$query);
                                $count = mysqli_num_rows($res);

                                if($count < 1){
                                    echo"<p>No Genre currently Assigned</p>";
                                }
                                else{
                                    for($i=0;$i<$count;$i++){
                                        $row=mysqli_fetch_array($res);
                                        $genre_id=$row['genre_id'];
                                        $select="SELECT genre_name FROM genre WHERE genre_id=?";
                                        $stmt = mysqli_prepare($connect, $select);
                                        mysqli_stmt_bind_param($stmt, "i", $genre_id);
                                        mysqli_stmt_execute($stmt);
                                        $result = mysqli_stmt_get_result($stmt);
                                        $data = mysqli_fetch_array($result);
                                        $genre_name=$data['genre_name'];
                                        
                                        echo '<input type="text" name="txtGenre[]" value="' . $genre_name . '"readonly>';
                                        
                                        if ($i < $count - 1) {
                                            echo ", ";
                                        }
                                    }
                                }
                                ?>   
                            </td>
                        </tr>

                    <tr>
                        <td></td>
                        <td>    <button><a href="bookDisplay.php" style="color:white">Back to Book List</a></button>
                            <input type="submit" name="btnadd" value="Add to Cart"/></td>
                    </tr>

            </table>
        </td>

        </tr>
        </table>
        </form>
<?php 
    // query to get average rating and rating count for book
    if(isset($_REQUEST['bid'])){
    $book_id=$_REQUEST['bid'];
    $query = "SELECT AVG(rating) as average_rating, COUNT(*) as rating_count FROM rating WHERE book_id=$book_id";
    $result = mysqli_query($connect, $query);
    $data = mysqli_fetch_assoc($result);
    $average_rating = round($data['average_rating']);
    $rating_count = $data['rating_count'];
}

    // function to display rating stars
    function display_rating_stars($rating) {
  $stars = '';
  for ($i = 1; $i <= 5; $i++) {
    if ($i <= $rating) {
      $stars .= '<span class="star">&#9733;</span>';
    } else {
      $stars .= '<span class="star">&#9734;</span>';
    }
  }
  return $stars;
}

?>

<form action="addreview.php" method="POST">
    <input type="hidden" value="<?php echo $book_id; ?>" name="book_id">
    <div class="ratingDisplay">
        <p>Rating: <?php echo display_rating_stars(round($average_rating)); ?> (<?php echo $rating_count; ?> ratings)</p>
    </div>
    <button type="button" onclick="showCommentBox()">Add Review</button>
    <button type="button" onclick="showRatingBox()">Rate Book</button>
    <div id="commentBox" style="display:none;">
        <textarea id="comment" name="comment"></textarea>
        <button type="submit" name="submit">Submit Review</button>
    </div>
    <div id="ratingBox" style="display:none;">
        <label for="rating">Rate this book:</label>
        <select id="rating" name="rating">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
        </select>
        <button type="submit" name="submit_rating">Submit Rating</button>
    </div>
    <script>
        function showCommentBox() {
            var commentBox = document.getElementById("commentBox");
            var ratingBox = document.getElementById("ratingBox");
            if (commentBox.style.display === "none") {
                commentBox.style.display = "block";
                ratingBox.style.display = "none";
            } else {
                commentBox.style.display = "none";
            }
        }
        function showRatingBox() {
            var commentBox = document.getElementById("commentBox");
            var ratingBox = document.getElementById("ratingBox");
            if (ratingBox.style.display === "none") {
                ratingBox.style.display = "block";
                commentBox.style.display = "none";
            } else {
                ratingBox.style.display = "none";
            }
        }
    </script>
</form>



        <?php 
        if (isset($_REQUEST['bid'])) {
            $book_id = $_REQUEST['bid'];
            $select = "SELECT * FROM review WHERE book_id = '$book_id'";
            $result = mysqli_query($connect,$select);
            $count = mysqli_num_rows($result);
            if($count < 1){
                echo "<p style='color: red;'>No Review here, add new one</p>";
            } else {
                for($i=0;$i<$count;$i++){
                    $row=mysqli_fetch_array($result);
                    $member_id = $row['member_id'];
                    $review = $row['book_review'];
                    $mselect = "SELECT member_name FROM member WHERE member_id='$member_id'";
                    $mresult = mysqli_query($connect,$mselect);
                    $mdata = mysqli_fetch_array($mresult);
                    $member_name = $mdata['member_name'];
                    echo "<p style='font-weight: bold;'>$member_name</p>";
                    echo "<p>$review</p>";
                }
            }
        }
    ?>


    </body>
    </html>
<?php 
include('footer.php');

