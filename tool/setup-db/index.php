<html>
<head>
	<title>Setup DB</title>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<style>
		body { font-family: verdana; padding: 5px; }
		#info { background-color: #ddd; padding: 5px; }
	</style>
</head>

<body>
<?php
	include 'connect.php';
	$dbh = connect_DB() or die('Cannot connect to DB!');
	
	$dbdriver = '';
	if ($dbenv['dbdriver'] == 1) $dbdriver = 'SQLITE';
	if ($dbenv['dbdriver'] == 2) $dbdriver = 'MYSQL';
	
	$html=<<<HTML
		<div id="info">
			/app/app_config.php<br/>
			$dbdriver - Host: $dbenv[host] - DB: $dbenv[dbname] <p/>** For MySQL, Make sure you create DB first. <br/>** Verify SQL script file: prepare_tables_*.sql files. <p/>
		</div>
HTML;
	echo $html;
?>
	<p/><h3>Recreate and Setup Database:</h3><p/>
	<ul>
		<li><a href="create_tables.php">Create Tables</a></li>
		<li><a href="create_data.php">Create Data</a></li>
	</ul>
</body>
</html>