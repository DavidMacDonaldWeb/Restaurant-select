<!doctype html>
<html lang="en">
<head><meta charset="utf-8">
  <titleDelete</title>
  <meta name="description" content="Delete">
</head>
<body>
<?php 
// RDBMS connection paramters
include "connectionres.php";

try {
	$dbh = new PDO("mysql:host=localhost;dbname=$database", $username, $password); // Connecting, selecting database
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // SQL errors will not be silent
	if (isset($_GET['id'])){
		var_dump($_GET);
		$id=$_GET['id'];
		$stmt = $dbh->prepare( "DELETE FROM restaurantData WHERE id=:id");
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		$stmt->execute();
		if ($stmt->rowCount()===1) {
			echo "Record $id gone!";	
		} elseif ($stmt->rowCount()>1) {
			echo "OUCH! ERROR! rowCount to big {$stmt->rowCount()}";
		} else {
			echo "Nothing done";
		}
	} else {
		echo "No record selected for deletion";
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