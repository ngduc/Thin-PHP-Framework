<?php
	include 'connect.php';
	$dbh = connect_DB() or die('Cannot connect to DB!');

	if ($arr = @file ('prepare_data.sql'))		// Do this if file exists
	{
		foreach ($arr as $line) $sql .= $line;
	}

	echo '<a href="create_tables.php">Recreate Tables</a><p/>';
	echo "<textarea cols=120 rows=20>$sql</textarea><p/>";
	
	$arr = explode (";", $sql);
	foreach ($arr as $query)
	{
		if (strlen($query) < 10) continue;
		
		$err = null;
		$cnt = $dbh->exec($query.';') or $err = $dbh->errorInfo();
		$queryName = left_from($query, '('); // ex: query = INSERT INTO `category` (...

		echo "$queryName - $cnt done! <span style='color: #f00'>$err[2]</span> <p/>";
	}
	$dbh = null;
?>