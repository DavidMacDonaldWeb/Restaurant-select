<!doctype html>
<html lang="en">
<head><meta charset="utf-8">
  <title>Data Gathering</title>
  <meta name="description" content="Data Gathering">
</head>
<body>
<form action="" method="POST">
Fullname: <input type="text" name="fullname" value=""><br>
<br>
Phonenumber: <input type="numeric" name="phonenumber" value=""><br>
<br>
<select name="restaurant">
<option value="">Please select</option>
<option value="finedining">Fine Dining</option>
<option value="casualdining">Casual Dining</option>
<option value="fastcasual">Fast Casual</option>
<option value="fastfood">Fast Food</option>
<br>
<input type="submit" name="submit" value="Submit">
</form>
<?php 
// RDBMS connection paramters
include "connectionres.php";

try {
	$dbh = new PDO("mysql:host=localhost;dbname=$database", $username, $password); // Connecting, selecting database
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // SQL errors will not be silent
	if (isset($_POST['submit'])){
		var_dump($_POST);
		$fullname=$_POST['fullname'];
		$phonenumber=$_POST['phonenumber'];
		$restaurant=$_POST['restaurant'];
		$stmt = $dbh->prepare( "INSERT INTO restaurantData (fullname, restaurant, phonenumber) VALUES (:fullname, :restaurant, :phonenumber)");
		$stmt->bindParam(':fullname', $fullname, PDO::PARAM_STR, 50);
		$stmt->bindParam(':restaurant', $restaurant, PDO::PARAM_STR, 20);
		$stmt->bindParam(':phonenumber', $phonenumber, PDO::PARAM_STR, 11);
		$stmt->execute();
	}	
	$stmt = $dbh->prepare( "SELECT id, fullname, restaurant, phonenumber FROM restaurantData;"); // prepare for execution & return a statement object
	$stmt->bindColumn( 'id', $id ); // Bind named column to a named PHP variable
	$stmt->bindColumn( 'fullname', $fullname ); 
	$stmt->bindColumn( 'restaurant', $restaurant ); 
	$stmt->bindColumn( 'phonenumber', $phonenumber ); 	
	$stmt->execute();
	echo "<ul>\n";
	while ( $stmt->fetch(PDO::FETCH_BOUND) ){ // fetch one row of results binding column values to PHP variables
		echo "<li><a href='detailsres.php?id=$id'>$fullname</a> <a href='updateres.php?id=$id'>Edit</a> <a href='deleteres.php?id=$id'>DELETE</a></li>\n";
	}
	echo "</ul>\n";
	$dbh = null; // Closing connection after success
} 
	catch (PDOException $e) {
	$dbh = null; // Closing connection if some error has occurred
	print "Error!: " . $e->getMessage() . "<br/>"; // WARNING - error messages are potential security weakness on production sites
	print "PHP Line Number: " . $e->getLine() . "<br/>"; 
	print "PHP File: " . $e->getFile() . "<br/>";
	die();
   }

?>
</body>
</html>
