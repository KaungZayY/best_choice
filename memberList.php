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
    <form action="memberList.php" method="POST">
        <fieldset>
            <legend>Members</legend>
            <label for="search">Search by Name:</label>
            <input type="text" name="search" id="search">
            <input type="submit" name="submit" value="Search">
            <br><br>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Phone No</th>
                    <th>Member Type</th>
                    <th>Action</th>
                </tr>
                <tr>
                    <?php 
                        // Check for sorting parameter
                        $sort = isset($_POST['sortBtn']) ? $_POST['sortBtn'] : '';
                        
                        // Modify query based on sorting parameter
                        if ($sort == 'asc') {
                            $select="SELECT * FROM member ORDER BY member_name ASC";
                        } else {
                            $select="SELECT * FROM member";
                        }

                        // Check for search parameter
                        $search = isset($_POST['search']) ? $_POST['search'] : '';

                        // Modify query based on search parameter
                        if (!empty($search)) {
                            $select="SELECT * FROM member WHERE member_name LIKE '%$search%'";
                        }

                        $query=mysqli_query($connect, $select);
                        $count=mysqli_num_rows($query);
                        for($i=0;$i<$count;$i++)
                        {
                            $data=mysqli_fetch_array($query);
                            $memberID=$data['member_id'];
                            $memberImage=$data['member_image'];
                            $memberName=$data['member_name'];
                            $memberEmail=$data['member_email'];
                            $memberPassword=$data['member_password'];
                            $memberAddress=$data['member_address'];
                            $memberPhoneNumber=$data['member_phonenumber'];
                            $membertype_id=$data['membertype_id'];

                            $sel = "SELECT membertype_name FROM membertype WHERE membertype_id='$membertype_id'";
                            $que = mysqli_query($connect, $sel);
                            $dat = mysqli_fetch_array($que);
                            $membertype = $dat['membertype_name'];

                            echo "<tr>
                                <td>$memberID</td>
                                <td>$memberImage</td>
                                <td>$memberName</td>
                                <td>$memberEmail</td>
                                <td>$memberAddress</td>
                                <td>$memberPhoneNumber</td>
                                <td>$membertype</td>
                                <td>
                                <a href='manageMemberUpdate.php?uit=$memberID'>Update</a> | 
                                <a href='manageMemberDelete.php?did=$memberID'>Delete</a>
                                </td>
                                </tr>";
                        }
                    ?>
                </tr>
            </table>
            <br>
            <button type="submit" name="sortBtn" value="asc">Sort by Name (A-Z)</button>
        </fieldset>
    </form>
 </body>
 </html>
<?php 
include('footer1.php');
 ?>