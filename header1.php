<!DOCTYPE html>
<html>
<head>
	<title>Best Choice Library</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</head>
<body>
	<header>
		<nav class="navbar navbar-inverse">
			<div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="transition.php">Best Choice Admin Pannel</a>
				</div>
				<div class="collapse navbar-collapse" id="myNavbar">
					<ul class="nav navbar-nav">
						<li class="dropdown">
					    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Books <span class="caret"></span></a>
					    <ul class="dropdown-menu">
					      <li><a href="bookRegister.php">Add Book</a></li>
					      <li><a href="bookList.php">Book List</a></li>
					    </ul>
					  </li>
					  <li class="dropdown">
					    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Genres<span class="caret"></span></a>
					    <ul class="dropdown-menu">
					      <li><a href="genreRegister.php">Add Genre</a></li>
					      <li><a href="bookTypeRegister.php">Add Book Type</a></li>
					    </ul>
					  </li>
					  <li class="dropdown">
					    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Members<span class="caret"></span></a>
					    <ul class="dropdown-menu">
					      <li><a href="memberList.php">Member List</a></li>
					      <li><a href="memberTypeRegister.php">Add Member Type</a></li>
					    </ul>
					  </li>
					  <li class="dropdown">
					    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Librarian<span class="caret"></span></a>
					    <ul class="dropdown-menu">
					      <li><a href="librarianRegister.php">Add Librarian</a></li>
					      <li><a href="librarianList.php">Librarian List</a></li>
					    </ul>
					  </li>
					  <li><a href="librarianUpdate.php">Account Info</a></li>
					  <li><a href="transition.php">Transitions</a></li>
					</ul>

					<ul class="nav navbar-nav navbar-right">
						<li><a href="logout.php">Logout</a></li>
					</ul>
				</div>
			</div>
		</nav>
	</header>
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-LbV/0+0u4xtV8/nyJfZmXhzwVI6xALdW8sT6JlkbrHZFKLMT6UFGQ6U07ZDzve9X" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script>
	$(document).ready(function(){
		$('.dropdown-toggle').dropdown();
	});
</script>

</body>
</html>
