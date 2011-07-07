<?php

function ifsetor(&$variable, $defVal = null)	// if isset() set value, else set default value.
{
    if (isset($variable)) {
        $tmp = $variable;
    } else {
        $tmp = $defVal;
    }
    return $tmp;
}

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
    $sParamsInRoute = trim(removeFirstLast('/', $sParamsInRoute));
    if ($sParamsInRoute != '')
    {
        $arrParams = explode('/', $sParamsInRoute);
        return $arrParams;
    }
    else return null;
}

function parseUri($route)
{
	// example: /products/cat1/detail/123/computer-case => matched: /products/cat1/detail
	global $arr_mapping, $ext_mapping;
    $rt = removeFirst('/', $route);
    $rt = removeLast('/', $rt);
    
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
            else if (isset($ext_mapping[ $path ])) {
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

function getCurrentUrl()
{
	$pageURL = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";		
	if ($_SERVER["SERVER_PORT"] != "80")
	{
	    $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
	} 
	else 
	{
	    $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	}
	return $pageURL;
}

function explodeGet($delim, $st, $idx)
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

function dbDateTime() {
	return date( 'Y-m-d H:i:s' );
}

/**
 * Copy (and transform) array items from $sourceArr to $arr
 * Example: copyArray($_POST, $v, '*'); // copy all fields from submitted Form.
 */
function copyArray( $sourceArr, &$arr )
{
	$params = func_get_args(); // get function args

	$totalParams = count($params);
	if ($totalParams < 3) return;

	if (trim($params[2]) == '*')	// copy all array items		
	{
		foreach ($sourceArr as $key => $value) {
			$arr[$key] = $value;
		}
	}
	else {
		for ($i = 2; $i < $totalParams; $i++) {
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
					case 's_s':
						$arr[$k1] = sanitizeString($sourceArr[$k1]);
						break;
					case 's_email':
						$arr[$k1] = sanitizeEmail($sourceArr[$k1]);
						break;					
				}
			}
			else {
				$arr[$k1] = $sourceArr[$k2];
			}
		}
	}
}

function dateDiff($d1, $d2){
    $d1 = (is_string($d1) ? strtotime($d1) : $d1);
    $d2 = (is_string($d2) ? strtotime($d2) : $d2);

    $diff_secs = abs($d1 - $d2);
    $base_year = min(date("Y", $d1), date("Y", $d2));

    $diff = mktime(0, 0, $diff_secs, 1, 1, $base_year);
    return array(
        "years" => date("Y", $diff) - $base_year,
        "months_total" => (date("Y", $diff) - $base_year) * 12 + date("n", $diff) - 1,
        "months" => date("n", $diff) - 1,
        "days_total" => floor($diff_secs / (3600 * 24)),
        "days" => date("j", $diff) - 1,
        "hours_total" => floor($diff_secs / 3600),
        "hours" => date("G", $diff),
        "minutes_total" => floor($diff_secs / 60),
        "minutes" => (int) date("i", $diff),
        "seconds_total" => $diff_secs,
        "seconds" => (int) date("s", $diff)
    );
}

function outputJson($var)
{
	header("Content-type: application/json");
	header('Cache-Control: no-cache, must-revalidate');
    header("Content-Encoding: gzip");
    // output json using gzip
    ob_start("ob_gzhandler");
    echo json_encode($var);
    ob_end_flush();
}
