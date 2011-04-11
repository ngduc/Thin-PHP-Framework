<?php
defined('BASE') or exit('Direct script access is not allowed!');
include BASEEXT.'/wiki2html/src/parseRaw.inc.php';

class Wiki2html
{
	function get_pres($str){ 
	    $pretags = preg_match_all("/(<pre.*>)(.*)(<\/pre>)/isxmU", $str, $patterns);
	    $res = array(); 
	    for ($i = 0, $cnt = count($patterns[1]); $i < $cnt; $i++) {
	    	array_push($res, array('pretag' => $patterns[1][$i], 'content' => $patterns[2][$i]));
		}
	    //array_push($res, array('pretag' => $patterns[1][1], 'content' => $patterns[2][1]));
	    return $res;
	} 

	public static function process($strHTML)
	{
		$html = $strHTML;
		
		//$arr = Wiki2html::get_pres('<pre class="brush: js">p111</pre>...<pre class="brush: css">p222</pre>');
		//var_dump($arr);
		$arr = Wiki2html::get_pres($html);
		for ($i = 0, $cnt = count($arr); $i < $cnt; $i++) {
			$html = str_replace(
						$arr[$i]['pretag'].$arr[$i]['content'].'</pre>',
						'!pre'.$i.'!',
					$html);
		}
		
		// Wiki2html Parser
		$html = html_entity_decode($html);
		$html = str_replace('&ndash;','-',$html);
		$html = str_replace('&quot;','"',$html);
		$html = preg_replace('/\&amp;(nbsp);/','&${1};',$html);				
		$html = convertTables($html);
		$html = simpleText("\n".$html);
		
		$tmp = preg_match_all("/!pre(\d)!/s", $html, $patterns);
		//var_dump($patterns);
		for ($i = 0, $cnt = count($patterns[1]); $i < $cnt; $i++) {
	    	$html = str_replace('!pre'.$i.'!',
	    				"\n".$arr[$i]['pretag'].$arr[$i]['content'].'</pre>', $html);
		}
						
		return $html;
	}
}
?>