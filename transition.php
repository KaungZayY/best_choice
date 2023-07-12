<?php 
    include('connection.php');
    include('header1.php');
    session_start();
    if(!isset($_SESSION['librarianID']) || $_SESSION['accountType'] != "librarian"){
    echo "<script>window.alert('Login as Librarian to Access this Page')</script>";
    echo "<script>window.history.go(-1);</script>";
    }
 ?>

 <html>
 <head>
    <title></title>
 </head>
 <body>
    <button onclick="printTable()">Print Table</button>
    <form action="transition.php" method="POST">
        <fieldset>
            <legend>Search by Borrow Date</legend>
            <input type="date" name="borrow_date">
            <button type="submit" name="search">Search</button>
        </fieldset>
    </form>

    <fieldset>
        <legend>Transition History</legend>
        <table>
            <tr>
                <th>ID</th>
                <th>Book Title</th>
                <th>Quantity</th>
                <th>Member Name</th>
                <th>Borrow Date</th>
                <th>Return Date</th>
                <th>Status</th>
            </tr>
            <?php 
            if(isset($_POST['search'])) {
                $borrow_date = $_POST['borrow_date'];
                $select="SELECT * FROM transition WHERE borrowbook_id IN (SELECT borrowbook_id FROM borrowbook WHERE borrow_date='$borrow_date')";
            } else {
                $select="SELECT * FROM transition";
            }
            $query=mysqli_query($connect, $select);
            $count=mysqli_num_rows($query);
            for($i=0;$i<$count;$i++)
            {
                $data=mysqli_fetch_array($query);
                $transition_id=$data['transition_id'];
                $borrowbook_id=$data['borrowbook_id'];
                $book_id=$data['book_id'];
                $quantity=$data['quantity'];
                $status=$data['status'];

                $sel = "SELECT * FROM borrowbook WHERE borrowbook_id='$borrowbook_id'";
                $que = mysqli_query($connect, $sel);
                $dat = mysqli_fetch_array($que);
                $borrow_date = $dat['borrow_date'];
                $return_date = $dat['return_date'];
                $member_id = $dat['member_id'];

                $mselect = "SELECT member_name FROM member WHERE member_id='$member_id'";
                $mquery = mysqli_query($connect, $mselect);
                $mdata = mysqli_fetch_array($mquery);
                $member_name = $mdata['member_name'];

                $bselect = "SELECT title FROM book WHERE book_id='$book_id'";
                $bquery = mysqli_query($connect, $bselect);
                $bdata = mysqli_fetch_array($bquery);
                $title = $bdata['title'];

                echo "<tr>
                    <td>$transition_id</td>
                    <td>$title</td>
                    <td>$quantity</td>
                    <td>$member_name</td>
                    <td>$borrow_date</td>
                    <td>$return_date</td>
                    <td>$status</td>
                    </tr>";
            }
            ?>
        </table>
    </fieldset>
    <script>
        function printTable() {
            window.print();
        }
    </script>
 </body>
 </html>
<?php 
include('footer1.php');
