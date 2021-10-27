# php-mysql-login-system
PHP MySQL reference : thaicreate


### vmware linux server
```
cd /var/www/html;
git clone https://github.com/lucifer14224/php_by_pit; 
mv -v ./php_by_pit/* ./ ; 
rm -r php_by_pit;
```

```
nano dbcon.php
```


reference origin : https://www.thaicreate.com/community/php-mysql-login-form-check-username-password.html

reference : connect database and query

https://www.codexworld.com/connect-access-remote-mysql-database-cpanel-php/


## dbcon.php
```
<!-- dbcon.php -->
<?php
$dbServerName = "localhost"; // ip address (hostname -I)
	$dbUsername = "myuser"; // username
	$dbPassword = "root1234"; // db pass
	$dbName = "mydatabase"; // your database to connect

	$conn = mysqli_connect($dbServerName, $dbUsername, $dbPassword, $dbName) or die("Connection failed: " . $conn->connect_error);

?>
```

## login.php
```
<html>
<head>
<title>ThaiCreate.Com Tutorials</title>
</head>
<body>
<form name="form1" method="post" action="check_login.php">
  Login<br>
  <table border="1" style="width: 300px">
    <tbody>
      <tr>
        <td> &nbsp;Username</td>
        <td>
          <input name="txtUsername" type="text" id="txtUsername">
        </td>
      </tr>
      <tr>
        <td> &nbsp;Password</td>
        <td><input name="txtPassword" type="password" id="txtPassword">
        </td>
      </tr>
    </tbody>
  </table>
  <br>
  <input type="submit" name="Submit" value="Login">
</form>
</body>
</html>

```

## check_login.php
```
<?php
	session_start();
	include("dbcon.php");
	$username = $_POST['txtUsername'];
	$password = $_POST['txtPassword'];

	$strSQL="SELECT * FROM member 
                  WHERE  Username='".$username."' 
                  AND  Password='".$password."' ";

	$objQuery = $conn->query($strSQL);
	$objResult =$objQuery->fetch_assoc();
	if(!$objResult)
	{
			echo "Username and Password Incorrect!";
	}
	else
	{
			$_SESSION["UserID"] = $objResult["UserID"];
			$_SESSION["Status"] = $objResult["Status"];

			session_write_close();
			
			if($objResult["Status"] == "ADMIN")
			{
				header("location:admin_page.php");
			}
			else
			{
				header("location:user_page.php");
			}
	}
	
?>
```

## admin_page.php
```
<?php
	
	session_start();
	include "dbcon.php";
	if($_SESSION['UserID'] == "")
	{
		echo "Please Login!";
		exit();
	}

	if($_SESSION['Status'] != "ADMIN")
	{
		echo "This page for Admin only!";
		exit();
	}	
	

	$strSQL = "SELECT * FROM member WHERE UserID = '".$_SESSION['UserID']."' ";
	$objQuery = $conn->query($strSQL);
	$objResult =$objQuery->fetch_assoc();

?>
<html>
<head>
<title>ThaiCreate.Com Tutorials</title>
</head>
<body>
  Welcome to Admin Page! <br>
  <table border="1" style="width: 300px">
    <tbody>
      <tr>
        <td width="87"> &nbsp;Username</td>
        <td width="197"><?php echo $objResult["Username"];?>
        </td>
      </tr>
      <tr>
        <td> &nbsp;Name</td>
        <td><?php echo $objResult["Name"];?></td>
      </tr>
    </tbody>
  </table>
  <br>
  <a href="edit_profile.php">Edit</a><br>
  <br>
  <a href="logout.php">Logout</a>
</body>
</html>
```

## user_page.php
```
<?php
	session_start();
	include "dbcon.php";
	if($_SESSION['UserID'] == "")
	{
		echo "Please Login!";
		exit();
	}

	if($_SESSION['Status'] != "USER")
	{
		echo "This page for User only!";
		exit();
	}	


	$strSQL = "SELECT * FROM member WHERE UserID = '".$_SESSION['UserID']."' ";

	$objQuery = $conn->query($strSQL);
	$objResult =$objQuery->fetch_assoc();
  
?>
<html>
<head>
<title>ThaiCreate.Com Tutorials</title>
</head>
<body>
  Welcome to User Page! <br>
  <table border="1" style="width: 300px">
    <tbody>
      <tr>
        <td width="87"> &nbsp;Username</td>
        <td width="197"><?php echo $objResult["Username"];?>
        </td>
      </tr>
      <tr>
        <td> &nbsp;Name</td>
        <td><?php echo $objResult["Name"];?></td>
      </tr>
    </tbody>
  </table>
  <br>
  <a href="edit_profile.php">Edit</a><br>
  <br>
  <a href="logout.php">Logout</a>
</body>
</html>
```

## edit_profile.php
```
<?php
	session_start();
  include "dbcon.php";
  

	if($_SESSION['UserID'] == "")
	{
		echo "Please Login!";
		exit();
	}
	
	
  
	$strSQL = "SELECT * FROM member WHERE UserID = '".$_SESSION['UserID']."' ";

  $objQuery = $conn->query($strSQL);
	$objResult =$objQuery->fetch_assoc(); 
?>
<html>
<head>
<title>ThaiCreate.Com Tutorials</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>
<body>
<form name="form1" method="post" action="save_profile.php">
  Edit Profile! <br>
  <table width="400" border="1" style="width: 400px">
    <tbody>
      <tr>
        <td width="125"> &nbsp;UserID</td>
        <td width="180">
          <?php echo $objResult["UserID"];?>
        </td>
      </tr>
      <tr>
        <td> &nbsp;Username</td>
        <td>
          <?php echo $objResult["Username"];?>
        </td>
      </tr>
      <tr>
        <td> &nbsp;Password</td>
        <td><input name="txtPassword" type="password" id="txtPassword" value="<?php echo $objResult["Password"];?>">
        </td>
      </tr>
      <tr>
        <td> &nbsp;Confirm Password</td>
        <td><input name="txtConPassword" type="password" id="txtConPassword" value="<?php echo $objResult["Password"];?>">
        </td>
      </tr>
      <tr>
        <td>&nbsp;Name</td>
        <td><input name="txtName" type="text" id="txtName" value="<?php echo $objResult["Name"];?>"></td>
      </tr>
      <tr>
        <td> &nbsp;Status</td>
        <td>
          <?php echo $objResult["Status"];?>
        </td>
      </tr>
    </tbody>
  </table>
  <br>
  <input type="submit" name="Submit" value="Save">
</form>
</body>
</html>
```

## save_profile.php
```
<?php
	session_start();
	include "dbcon.php";
	if($_SESSION['UserID'] == "")
	{
		echo "Please Login!";
		exit();
	}
	
	if($_POST["txtPassword"] != $_POST["txtConPassword"])
	{
		echo "Password not Match!";
		exit();
	}
	$strSQL = "UPDATE member SET Password = '".trim($_POST['txtPassword'])."' 
	,Name = '".trim($_POST['txtName'])."' WHERE UserID = '".$_SESSION["UserID"]."' ";
	
	$objQuery = $conn->query($strSQL);

	echo "Save Completed!<br>";		
	
	if($_SESSION["Status"] == "ADMIN")
	{
		echo "<br> Go to <a href='admin_page.php'>Admin page</a>";
	}
	else
	{
		echo "<br> Go to <a href='user_page.php'>User page</a>";
	}
	
	
?>
```

## logout.php
```
<?php
	session_start();
	session_destroy();
	header("location:login.php");
?>
```
