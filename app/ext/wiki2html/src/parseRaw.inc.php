<?php

include("table-converter.inc.php");

function getPartBetween($str, $a, $b){
	$start = strpos($str,$a) + strlen($a);
	if(strpos($str,$a) === false) return false;
	$length = strpos($str,$b,$start) - $start;
	if(strpos($str,$b,$start) === false) return false;
	return substr($str,$start,$length);
}
function debug_preg($matches){
	echo "\n\n<h3 style='color=red'>PREG</h3><pre>\n\n";
	var_dump($matches);
	echo "\n\n<hr style='color=red' />n\n";
	return $matches[0];
}
function simpleText($html){

	$html = str_replace("==\r\n",'==',$html);
	$html = str_replace('&ndash;','-',$html);
	$html = str_replace('&quot;','"',$html);
	$html = preg_replace('/\&amp;(nbsp);/','&${1};',$html);

	//formatting
	// bold
	$html = preg_replace('/\'\'\'([^\n\']+)\'\'\'/','<strong>${1}</strong>',$html);
	// emphasized
	$html = preg_replace('/\'\'([^\'\n]+)\'\'?/','<em>${1}</em>',$html);
	//interwiki links
	$html = preg_replace_callback('/\[\[([^\|\n\]:]+)[\|]([^\]]+)\]\]/','helper_interwikilinks',$html);
	// without text
	$html = preg_replace_callback('/\[\[([^\|\n\]:]+)\]\]/','helper_interwikilinks',$html);
	// 
	//$html = preg_replace('/{{([^}]+)+}}/','Interwiki: ${1}+${2}+${3}',$html);
	$html = preg_replace('/{{([^\|\n\}]+)([\|]?([^\}]+))+\}\}/','Interwiki: ${1} &raquo; ${3}',$html);
	// Template
	//$html = preg_replace('/{{([^}]*)}}/',' ',$html);
	// categories
	//$html = preg_replace('/\[\[([^\|\n\]]+)([\|]([^\]]+))?\]\]/','',$html);
	$html = preg_replace('/\[\[([^\|\n\]]{2})([\:]([^\]]+))?\]\]/','Translation: ${1} &raquo; ${3}',$html);
	$html = preg_replace('/\[\[([^\|\n\]]+)([\:]([^\]]+))?\]\]/','Category: ${1} - ${2}',$html);
	// image
	$html = preg_replace('/\[\[([^\|\n\]]+)([\|]([^\]]+))+\]\]/','Image: ${0}+${1}+${2}+${3}',$html);
	
	//links
	//$html = preg_replace('/\[([^\[\]\|\n\': ]+)\]/','<a href="${1}">${1}</a>',$html);
	$html = preg_replace_callback('/\[([^\[\]\|\n\': ]+)\]/','helper_externlinks',$html);
	// with text
	//$html = preg_replace('/\[([^\[\]\|\n\' ]+)[\| ]([^\]\']+)\]/','<a href="${1}">${2}</a>',$html);
	$html = preg_replace_callback('/\[([^\[\]\|\n\' ]+)[\| ]([^\]\']+)\]/','helper_externlinks',$html);
	
	// allowed tags
	$html = preg_replace('/&lt;(\/?)(small|sup|sub|u)&gt;/','<${1}${2}>',$html);	
	
	$html = preg_replace('/\n*&lt;br *\/?&gt;\n*/',"\n",$html);
	$html = preg_replace('/&lt;(\/?)(math|pre|code|nowiki)&gt;/','<${1}pre>',$html);
	$html = preg_replace('/&lt;!--/','<!--',$html);
	$html = preg_replace('/--&gt;/',' -->',$html);

	// headings
	for($i=7;$i>0;$i--){
		$html = preg_replace(
			'/\n+[=]{'.$i.'}([^=]+)[=]{'.$i.'}\n*/',
			'<h'.$i.'>${1}</h'.$i.'>',
			$html
		);
	}
	
	//lists
	$html = preg_replace(
		'/(\n[ ]*[^#* ][^\n]*)\n(([ ]*[*]([^\n]*)\n)+)/',
		'${1}<ul>'."\n".'${2}'.'</ul>'."\n",
		$html
	);
	$html = preg_replace(
		'/(\n[ ]*[^#* ][^\n]*)\n(([ ]*[#]([^\n]*)\n)+)/',
		'${1}<ol>'."\n".'${2}'.'</ol>'."\n",
		$html
	);
	$html = preg_replace('/\n[ ]*[\*#]+([^\n]*)/','<li>${1}</li>',$html);
	
	$html = preg_replace('/----/','<hr />',$html);

	//$html = nl2br($html);
	// line breaks
	$html = preg_replace('/[\n\r]{4}/',"<br/><br/>",$html);
	$html = preg_replace('/[\n\r]{2}/',"<br/>",$html);
	$html = preg_replace('/[>]<br\/>[<]/',"><",$html);
	
	return $html;
}
function parseRaw($title,$page){
	putMilestone("ParseRaw start");
	$text = (getPartBetween($page, '<text xml:space="preserve">', '</text>'));
	$html = $text;
	//echo "<!-- " . wordwrap($text,120,"\n",1) . " -->";
	// re-html
	$html = html_entity_decode($html);
	$html = str_replace('&ndash;','-',$html);
	$html = str_replace('&quot;','"',$html);
	$html = preg_replace('/\&amp;(nbsp);/','&${1};',$html);
	
	$html = str_replace('{{PAGENAME}}',$title,$html);
	
	// Table
	$html = convertTables($html);
	
	$html = simpleText($html);
	putMilestone("ParseRaw done");
	return $html;
}
function giveSource($page){
	putMilestone("giveSource start");
	$text = (getPartBetween($page, '<text xml:space="preserve">', '</text>'));
	$text = "<pre>".$text."</pre>";
	putMilestone("giveSource done");
	return $text;
}
function helper_externlinks($matches){
	$target = $matches[1];
	$text = empty($matches[2])?$matches[1]:$matches[2];
	return '<a href="'.$target.'" target="_blank">'.$text.'</a>';
}
function helper_interwikilinks($matches){
	$target = $matches[1];
	$text = empty($matches[2])?$matches[1]:$matches[2];
	$class=" class=\"dunno\" ";
	/*static $links_checked_interwiki = 0;
	if(!$_GET["nocache"] && ++$links_checked_interwiki<10){
		$data = cachedFunc("getPos",$target);
		if($data["pos"]) $class = " class=\"exists\" "; $class = " class=\"notexists\" ";
	}*/
	return '<a '.$class.' href="?page='.$target.'">'.$text.'</a>';
}

?>
