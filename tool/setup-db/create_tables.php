<?php	
	include 'connect.php';
	$dbh = connect_DB() or die('Cannot connect to DB!');
	
	switch ($dbenv['dbdriver']) {
		case DB_PDO_MYSQL:
			$sqlfile = 'prepare_tables_mysql.sql'; break;
		case DB_PDO_SQLITE:
			$sqlfile = 'prepare_tables_sqlite.sql'; break;
	}	
	$dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES,false); // to use $dbh->errorInfo() for prepare()

	if ($arr = @file($sqlfile))		// Do this if file exists
	{
		$cnt = 0;
		foreach ($arr as $line) {
			$cnt++;
			if ($cnt == 1 && strpos($line, '# ') !== false) continue; // skip first line (UTF8 sign will break query)
			$sql .= $line;
		}
	}
	echo "<textarea cols=120 rows=20>$sql</textarea><p/>";

	$arr = explode (";", $sql);
	try {
		foreach ($arr as $query)
		{
			if (strlen($query) < 10) continue;

			$stmt = $dbh->prepare($query.';');
			if (!$stmt) {
			    $erri = $dbh->errorInfo();
			}
			else {
				$stmt->execute();
				//echo $stmt->debugDumpParams();
			}
			$queryName = left_from($query, '(').' - done!'; // ex: query = CREATE TABLE `category` (...	
			echo "$queryName <span style='color: #f00'>$erri[2]</span> <p/>";
		}
	}
	catch(PDOException $e)
	{
		die('Error: '.$e->getMessage());
	}
	$dbh = null;

	echo "<br/>&nbsp;<br/><a href='create_data.php'>Create Data</a><p/>";	
