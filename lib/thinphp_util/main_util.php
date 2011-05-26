<?php

// Flags for copy_fields()
define('F_ENCODE',	1);
define('F_DECODE',	2);
define('F_AS_IS',	3);

function isLocalhost()
{
	if (in_array($_SERVER['SERVER_ADDR'], array('127.0.0.1','::1'))) return true;
	return false;
}

function isDemoMode()
{
	global $app_i;
	if ($app_i['demo_mode']  == 1) return true;
	return false;
}

function formatControllerName($name)
{
	$name[0] = strtoupper($name[0]); 		// uppercase the first char
	$len = strlen($name);
	if (strpos($name, '-') !== false) {		// transform. ex: sign-up => SignUp
		for ($i = 1; $i < $len; $i++) {
			if ($name[$i-1] == '-') $name[$i] = strtoupper($name[$i]);
		}
		$name = str_replace('-', '', $name);
	}
	return $name;
}

function extractParams($parsedPath, $fullRoute)
{
    $sParamsInRoute = str_replace($parsedPath, '', $fullRoute);
    $sParamsInRoute = trim(remove_first_last('/', $sParamsInRoute));
    if ($sParamsInRoute != '')
    {
        $arrParams = explode('/', $sParamsInRoute);
        return $arrParams;
    }
    else return null;
}

function parseURI($route)
{
	// example: /products/cat1/detail/123/computer-case => matched: /products/cat1/detail
	global $arr_mapping, $ext_mapping;
    $rt = remove_first('/', $route);
    $rt = remove_last('/', $rt);
    
	$arr = explode ('/', $rt);
    for ($i = count($arr)-1; $i >= 0; $i--) {
        $path = '';
        for ($j = 0; $j < $i; $j++) {
            $path .= '/'.$arr[$j];
        }
        $testCtlName = formatControllerName($arr[$j]);
        $testCtlPath = $path;
        $testCtlFullPath = BASECTL.$testCtlPath.'/'.$testCtlName.'.php';
        //echo $testCtlFullPath.'<p/>';

        $path .= '/'.$arr[$j];
        
        if (file_exists($testCtlFullPath)) {
            //echo 'Controller.php exists!'
            return array('controller'.$testCtlPath, $testCtlName, extractParams($path, $route));
        }
        else {
            if (isset($arr_mapping[ $path ])) {
                //echo 'Controller Mapping matched!';
                $retArr = $arr_mapping[ $path ];
                if (isset($retArr[2])) {
                    return $retArr;
                } else {
                    return array($retArr[0], $retArr[1], extractParams($path, $route));
                }
            }
            if (isset($ext_mapping[ $path ])) {
                //echo 'Extension Mapping Matched!';
                $retArr = $ext_mapping[ $path ];
                if (isset($retArr[2])) {
                    return $retArr;
                } else {                    
                    return array($retArr[0], $retArr[1], extractParams($path, $route));
                }
            }
        }
    }
    return null;
}

function remove_first($ch, $s)
{
    // remove the first character (if any). Example: '/dir/' => 'dir/'
    if (strlen($s) == 0) return $s;
    if ($s[0] == $ch) return substr($s, 1, strlen($s));
	return $s;
}

function remove_last($ch, $s)
{
	// remove the last character (if any). Example: '/dir/' => '/dir'
	$len = strlen($s);
	if ($len == 0) return $s;
	if ($s[$len-1] == $ch) return substr($s, 0, $len-1);
	return $s;
}

function remove_first_last($ch, $s)
{
    $ret = remove_first($ch, $s);
    $ret = remove_last($ch, $ret);
    return $ret;
}

function explode_get($delim, $st, $idx)
{
	if (strpos($st, $delim) === false) return $st;

	$arr = explode($delim, $st);
	if ($idx >= 0) {
		if (isset($arr[$idx])) return $arr[$idx];
	} else {
		$idx2 = count($arr) + $idx; // $idx < 0, get from the right
		if (isset($arr[$idx2])) return $arr[$idx2];
	}
	return null;
}

function copy_fields( $sourceArr, &$arr, $flag )
{
	$params = func_get_args(); // get function args

	$totalParams = count($params);
	if ($totalParams < 3) return;

	for ($i = 3; $i < $totalParams; $i++) {
		$k1 = $params[$i];
		$k2 = $params[$i];

		if (strpos($k1, '|') !== false) {	// when $arr & sourceArr don't have the same columnName (ex: 'businessName=name')
			$tmp = explode('|', $k1);
			$k1 = $tmp[0];
			$k2 = $tmp[1];
		}

		if ($k2 == 'checkbox') {
			$arr[$k1] = ($sourceArr[$k1] == 'on' ? 1 : 0); // convert HTML Checkbox value to 0/1 (to store to DB)
		}
		else if (strpos($k2, 'df_') !== false)
		{
			$dateformat = str_replace('df_', '', $k2);
			if ($dateformat == 'mysql') $dateformat = 'Y-m-d';
			$arr[$k1] = date($dateformat, strtotime($sourceArr[$k1]));
		}
		else if (strpos($k2, 'html_decode') !== false)
		{
			$arr[$k1] = html_entity_decode( $sourceArr[$k1] );
		}
		else if (strpos($k2, 's_') !== false)
		{
			switch ($k2) {
				case 's_str':
					$arr[$k1] = sanitize_str($sourceArr[$k1]);
					break;
				case 's_email':
					$arr[$k1] = sanitize_email($sourceArr[$k1]);
					break;					
			}
		}
		else {
			if (isset($sourceArr[$k2]) && $flag == F_ENCODE) $arr[$k1] = htmlentities($sourceArr[$k2], ENT_QUOTES); // usually for Copying POST fields
			if (isset($sourceArr[$k2]) && $flag == F_DECODE) $arr[$k1] = html_entity_decode($sourceArr[$k2]);
			if (isset($sourceArr[$k2]) && $flag == F_AS_IS) $arr[$k1] = $sourceArr[$k2]; // usually for Copying DB fields
		}
	}
}

function header_json($sjason)
{
	header("Content-type: application/json");
	header('Cache-Control: no-cache, must-revalidate');
	echo json_encode($sjason);
}
