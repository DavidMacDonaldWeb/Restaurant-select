<!doctype html>
<html lang="en">
<head><meta charset="utf-8">
  <title>Data Gathering</title>
  <meta name="description" content="Data Gathering">
</head>
<body>
<?php 
// RDBMS connection paramters
include "connectionres.php";
$id = $_GET['id'];
try {
	$dbh = new PDO("mysql:host=localhost;dbname=$database", $username, $password); // Connecting, selecting database
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // SQL errors will not be silent
	$stmt = $dbh->prepare( "SELECT fullname, restaurant, phonenumber FROM restaurantData WHERE id=:id;"); // prepare for execution & return a statement object
	$stmt->bindParam(':id', $id,  PDO::PARAM_INT);
	$stmt->bindColumn( 'fullname', $fullname ); 
	$stmt->bindColumn( 'restaurant', $restaurant ); 
	$stmt->bindColumn( 'phonenumber', $phonenumber ); 	 	
	$stmt->execute();
	while ( $stmt->fetch(PDO::FETCH_BOUND) ){ // fetch one row of results binding coulmn values to PHP variables
		echo "<p><b>id:</b> $id <br><b>fullname:</b> $fullname<br><b>restaurant:</b> $restaurant<br><b>phonenumber:</b> $phonenumber<br></p>";
	}
	$dbh = null; // Closing connection after success
} catch (PDOException $e) {
	$dbh = null; // Closing connection if some error has occurred
	print "Error!: " . $e->getMessage() . "<br/>"; // WARNING - error messages are potential security weakness on production sites
	print "PHP Line Number: " . $e->getLine() . "<br/>"; 
	print "PHP File: " . $e->getFile() . "<br/>";
	die();
}
?>
</body>
</html>
