<html>
<head>
	<title>Setup DB</title>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<style></style>
</head>

<body>
<?php
	include 'connect.php';
	$dbh = connect_DB() or die('Cannot connect to DB!');
	
	echo "Host: $dbenv[host] - DB: $dbenv[dbname] <p/>** For MySQL, Make sure you create DB first. <br/>** Verify: prepare_tables_*.sql files. <p/>";
?>
	Recreate and Setup Database:<p/>
	<ul>
		<li><a href="create_tables.php">Create Tables</a></li>
		<li><a href="create_data.php">Create Data</a></li>
	</ul>
</body>
</html>