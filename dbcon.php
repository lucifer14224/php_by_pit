<!-- dbcon.php -->
<?php
$dbServerName = "localhost"; // ip address (hostname -I)
	$dbUsername = "myuser"; // username
	$dbPassword = "root1234"; // db pass
	$dbName = "mydatabase"; // your database to connect

	$conn = mysqli_connect($dbServerName, $dbUsername, $dbPassword, $dbName) or die("Connection failed: " . $conn->connect_error);
?>