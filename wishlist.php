<?php 
include('connection.php');
include('header.php');
session_start();
if(!isset($_SESSION['memberID'])){
    // member not logged in, redirect to login page
    echo "<script>window.alert('Login First!')</script>";
    echo "<script>window.location='login.php'</script>";
}

?>
<html>
<head>
    <title></title>
</head>
<body>
    <form action="wishlist.php" method="POST">
        <fieldset>
            <legend>Your Wish List</legend>
            <table>
                <tr>
                    <th>Title</th>
                    <th>Image</th>
                    <th>Author</th>
                    <th>Publisher</th>
                    <th>Edition</th>
                    <th>Number of Copy</th>
                    <th>availability</th>
                    <th>Book Type</th>
                    <th>Associated Genres</th>
                    <th>Action</th>
                </tr>
<?php 
    $member_id = $_SESSION['memberID'];
    $select = "SELECT book_id FROM wishlist WHERE member_id = '$member_id'";
    $result = mysqli_query($connect,$select);
    $count = mysqli_num_rows($result);
    
    if ($count==0) {
        echo "<tr><td>No Book Found.</td></tr>";
        exit();
    }
    else {   
        $book_ids = array();
        while($row = mysqli_fetch_assoc($result)) {
            array_push($book_ids, $row['book_id']);
        }
        
        foreach($book_ids as $book_id) {
            $sel = "SELECT * FROM book WHERE book_id='$book_id'";
            $resu = mysqli_query($connect,$sel);
            $data = mysqli_fetch_assoc($resu);
            $title = $data['title'];
            $image = $data['coverimage'];
            $author = $data['author'];
            $publisher = $data['publisher'];
            $edition = $data['edition'];
            $instock = $data['instock'];

            if($instock>0){
                $availability="Yes";
            }
            else{
                $availability="No";
            }

            $booktype_id = $data['booktype_id'];
            $bsel = "SELECT booktype_name FROM booktype WHERE booktype_id='$booktype_id'";
            $bres = mysqli_query($connect,$bsel);
            $bdata = mysqli_fetch_assoc($bres);
            $booktype = $bdata['booktype_name'];

            // Retrieve genre names for the book
            $gselect = "SELECT genre_name FROM genre INNER JOIN bookgenre ON genre.genre_id = bookgenre.genre_id WHERE bookgenre.book_id = '$book_id'";
            $gres = mysqli_query($connect,$gselect);
            $genre_names = array();
            while($gdata = mysqli_fetch_assoc($gres)) {
                array_push($genre_names, $gdata['genre_name']);
            }
            $genres = implode(", ", $genre_names);

            echo "<tr>
                    <td>$title</td>
                    <td><img src='$image' width='200px' height='200px'></td>
                    <td>$author</td>
                    <td>$publisher</td>
                    <td>$edition</td>
                    <td>$instock</td>
                    <td>$availability</td>
                    <td>$booktype</td>
                    <td>$genres</td>"; // Display genre names

            echo "<td>
                    <a href='bookDetail.php?bid=$book_id'>Borrow </a>|
                    <a href='wishlistDelete.php?did=$book_id'>Remove</a>
                </td>
                </tr>";
        }
    }
?>


            </table>
        </fieldset>
    </form>
</body>
</html>
<?php 
include('footer.php');
