<?php 
include('connection.php');
include('header.php');

if(isset($_POST['search'])){
    $search_title = $_POST['search_title'];
    $sort_order = isset($_POST['sort_order']) ? $_POST['sort_order'] : 'ASC';
    $query="SELECT * FROM book WHERE title LIKE '%$search_title%' ORDER BY title $sort_order";
} else {
    $sort_order = isset($_POST['sort_order']) ? $_POST['sort_order'] : 'DESC';
    $query="SELECT * FROM book ORDER BY title $sort_order";
}

$ret=mysqli_query($connect,$query);
$count=mysqli_num_rows($ret);
?>

<html>
<head>
    <title></title>
</head>
<body>
    <form action="bookDisplay.php" method="POST">
        <fieldset>
            <legend>Books</legend>
            <table>
                <tr>
                    <td>
                        <input type="text" name="search_title" placeholder="Search by title">
                        <input type="submit" name="search" value="Search">
                    </td>
                    <td>
                        <input type="hidden" name="sort_order" value="<?php echo $sort_order == 'ASC' ? 'DESC' : 'ASC'; ?>">
                        <input type="submit" name="sort" value="<?php echo $sort_order == 'ASC' ? 'Sort a to z' : 'Sort z to a'; ?>">
                    </td>
                </tr>
                <?php 
                if ($count==0) 
                {
                    echo "<tr><td>No Book Found.</td></tr>";
                    exit();
                }
                else
                {
                    for ($a=0; $a <$count ; $a+=3) 
                    { 
                        $query1="$query LIMIT $a,3";
                        $ret1=mysqli_query($connect,$query1);
                        $count1=mysqli_num_rows($ret1);

                        echo "<tr>";
                        for ($i=0; $i <$count1 ; $i++) 
                        { 
                            $data=mysqli_fetch_array($ret1);
                            $book_id=$data['book_id'];
                            $title=$data['title'];
                            $coverimage=$data['coverimage'];
                            $author=$data['author'];
                            $edition=$data['edition'];
                            $instock=$data['instock'];
                            if($instock<0){
                                $availability="Not Available";
                            }
                            else{
                                $availability="Available";
                            }
                            echo "<td>
                            <img src='$coverimage' width='200px' height='200px'><br>
                            $title<br>
                            $author<br>
                            $edition<br>
                            $instock
                            $availability<br>
                            <a href='bookDetail.php?bid=$book_id'>Detail</a>
                            </td>";
                        }
                        echo "</tr>";
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
