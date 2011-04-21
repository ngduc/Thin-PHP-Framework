<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     function.get_url.php
 * Type:     function
 * Name:     get_url
 * Purpose:  Get content from an URI or a remote file and place it into your
             template.
 * Version:  0.1
 * Creator:  Thin PHP Framework
 * -------------------------------------------------------------
 */
 
function smarty_function_get_url($params, &$smarty)
{   
    // Default options
    $opts = array(
        'default' => 'Not found',
        'fix' => 'src|href|action'
        );
    $opts = array_merge($opts, $params);
    
    // Make sure they passed a source url
    if (isset($opts['url']))
    {
        $opts['url'] = $opts['url'];
    }
    else
    {
        die($opts['default']);
    }
    
    $sParam = '';
    if (isset($opts['param'])) $sParam = $opts['param'];
    
    // Retrieve the remote file
    $content = @getContent($opts, $sParam);
        
    // Make sure we actually got something
    // if (!$content) die($opts['default']);
    if (!$content);
    
    // Output the contents to the template
    return $content;
}

function getContent($opts, $sParam)
{
	$url = $opts['url'];
	if (strpos($url, 'http://') !== false || strpos($url, 'https://') !== false)
	{
		// load External URL		
    	$content = file_get_contents($url);
    	// Set to the default text if we didn't get anything
    	if (!$content) $content = $opts['default'];    	
		return $content;
	}
	else {
		// load Internal URL (relative URL)
		// example: /sign-in => array('ext/authentication', 'SignIn')	
		list($loc, $className) = getURIMapping($url);
		$fullpath = BASE.'/app/'.$loc.'/'.$className.'.php';
		
		if (file_exists($fullpath))
		{			
			ob_start();
	 		// load extension
			require_once $fullpath;
			$ctr = new $className();
			$ctr->handle(array($sParam));			

			$content = ob_get_contents();			
			ob_end_clean();
			return $content;
		}
	}
    return '';
}


// Change relative urls in the content to point to the old site
function fixUrls($content, $opts)
{
    $url_parts = parse_url($opts['url']);
    $domain = $url_parts['scheme'].'://'.$url_parts['host'];
    $base_url = str_replace(basename($opts['url']), '', $url_parts['path']);
		
		$content = preg_replace($opts['patterns'], $opts['replacements'], $content);
		
		return $content;
}


// Just like it says on the box
function removeDoubleSlashes($str)
{
    return str_replace(array('//', '\\', '\\\\'), '/', $str);
}


// Resolves /../ in paths. From the PHP docs.
function getAbsolutePath($path) {
    $path = str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, $path);
    $parts = array_filter(explode(DIRECTORY_SEPARATOR, $path), 'strlen');
    $absolutes = array();
    foreach ($parts as $part)
    {
        if ('.' == $part) continue;
        if ('..' == $part)
        {
            array_pop($absolutes);
        }
        else
        {
            $absolutes[] = $part;
        }
    }
    return implode('/', $absolutes);
}

?>