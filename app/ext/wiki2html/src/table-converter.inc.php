<?php

function convertTables($text){
	$lines = explode("\n",$text);
	$innertable = 0;
	$innertabledata = array();
	foreach($lines as $line){
		//echo "<pre>".++$i.": ".htmlspecialchars($line)."</pre>";
		$line = str_replace("position:relative","",$line);
		$line = str_replace("position:absolute","",$line);
		if(substr($line,0,2) == '{|'){
			// inner table
			//echo "<p>beginning inner table #$innertable</p>";
			$innertable++;
		}
		$innertabledata[$innertable] .= $line . "\n";
		if($innertable){
			// we're inside
			if(substr($line,0,2) == '|}'){
				$innertableconverted = convertTable($innertabledata[$innertable]);
				$innertabledata[$innertable] = "";
				$innertable--;
				$innertabledata[$innertable] .= $innertableconverted."\n";
			}
		}
	}
	return $innertabledata[0];
}
function convertTable($intext){
	$text = $intext;
	$lines = explode("\n",$text);
	$intable = false;
	
	//var_dump($lines);
	foreach($lines as $line){
		$line = trim($line);
		if(substr($line,0,1) == '{'){
			//begin of the table
			$stuff = explode('| ',substr($line,1),2);
			$tableopen = true;
			$table = "<table ".$stuff[0].">\n";
		} else if(substr($line,0,1) == '|'){
			// table related
			$line = substr($line,1);
			if(substr($line,0,5) == '-----'){
				// row break
				if($thopen)
					$table .="</th>\n";
				if($tdopen)
					$table .="</td>\n";
				if($rowopen)
					$table .="\t</tr>\n";
				$table .= "\t<tr>\n";
				$rowopen = true;
				$tdopen = false;
				$thopen = false;
			}else if(substr($line,0,1) == '}'){
				// table end
				break;
			}else{
				// td
				$stuff = explode('| ',$line,2);
				if($tdopen)
					$table .="</td>\n";
				if(count($stuff)==1)
					$table .= "\t\t<td>".simpleText($stuff[0]);
				else
					$table .= "\t\t<td ".$stuff[0].">".
						simpleText($stuff[1]);
				$tdopen = true;
			}
		} else if(substr($line,0,1) == '!'){
			// th
			$stuff = explode('| ',substr($line,1),2);
			if($thopen)
				$table .="</th>\n";
			if(count($stuff)==1)
				$table .= "\t\t<th>".simpleText($stuff[0]);
			else
				$table .= "\t\t<th ".$stuff[0].">".
					simpleText($stuff[1]);
			$thopen = true;
		}else{
			// plain text
			$table .= simpleText($line) ."\n";
		}
		//echo "<pre>".++$i.": ".htmlspecialchars($line)."</pre>";
		//echo "<p>Table so far: <pre>".htmlspecialchars($table)."</pre></p>";
	}
	if($thopen)
		$table .="</th>\n";
	if($tdopen)
		$table .="</td>\n";
	if($rowopen)
		$table .="\t</tr>\n";
	if($tableopen)
		$table .="</table>\n";
	//echo "<hr />";
	//echo "<p>Table at the end: <pre>".htmlspecialchars($table)."</pre></p>";
	//echo $table;	
	return $table;
}

?>
