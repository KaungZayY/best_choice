<?php 
	function Add($book_id, $instock){
		$connect=mysqli_connect('localhost', 'root', '','best_choice');
		$query="SELECT * FROM book WHERE book_id='$book_id'";
		$result=mysqli_query($connect,$query);
		$count=mysqli_num_rows($result);

		if($count < 1) 
		{
			echo "<p>Book Not Found.</p>";
			exit();
		}
		$row=mysqli_fetch_array($result);
		$title=$row['title'];
		$author=$row['author'];
		$publisher=$row['publisher'];
		$edition=$row['edition'];
		$instock=$row['instock'];
		$coverimage=$row['coverimage'];

		if($instock < 0) 
		{
			echo "<script>window.alert('Out of Stock (0)')</script>";
			echo "<script>window.location='cart.php'</script>";
			exit();
		}
		if(isset($_SESSION['CartFunctions'])) 
		{
			$Index=IndexOf($book_id);
		
			if($Index == -1) 
			{
				$size=count($_SESSION['CartFunctions']);

				$_SESSION['CartFunctions'][$size]['book_id']=$book_id;
				$_SESSION['CartFunctions'][$size]['title']=$title;
				$_SESSION['CartFunctions'][$size]['author']=$author;
				$_SESSION['CartFunctions'][$size]['publisher']=$publisher;
				$_SESSION['CartFunctions'][$size]['edition']=$edition;
				$_SESSION['CartFunctions'][$size]['coverimage']=$coverimage;
			}
		}
		else
		{
			$_SESSION['CartFunctions']=array();
			$_SESSION['CartFunctions'][0]['book_id']=$book_id;
			$_SESSION['CartFunctions'][0]['title']=$title;
			$_SESSION['CartFunctions'][0]['author']=$author;
			$_SESSION['CartFunctions'][0]['publisher']=$publisher;
			$_SESSION['CartFunctions'][0]['edition']=$edition;
			$_SESSION['CartFunctions'][0]['coverimage']=$coverimage;
		}
		echo"<script>window.location='cart.php'</script>";
	}//add function ends


	function Remove($book_id)
	{
		$Index=IndexOf($book_id);
		unset($_SESSION['CartFunctions'][$Index]);
		$_SESSION['CartFunctions']=array_values($_SESSION['CartFunctions']);

		echo "<script>window.location='cart.php'</script>";
	}//remove function ends

/*	function Remove($book_id){
		$index=IndexOf($book_id);
		if($index!=-1){
			unset($_SESSION['CartFunctions'][$index]);
			echo "<script>window.location='cart.php'</script>";
		}
	}*/

	function Clear(){	
		unset($_SESSION['CartFunctions']);
		echo "<script>window.location='cart.php'</script>";
	}//clear function ends

	function IndexOf($book_id){
		if (!isset($_SESSION['CartFunctions'])) 
		{
			return -1;
		}

		$size=count($_SESSION['CartFunctions']);

		if ($size < 1) 
		{
			return -1;
		}

		for ($i=0;$i<$size;$i++) 
		{ 
			if($book_id == $_SESSION['CartFunctions'][$i]['book_id']) 
			{
				return $i;
			}
		}
		return -1;
	}//index of func ends

 ?>