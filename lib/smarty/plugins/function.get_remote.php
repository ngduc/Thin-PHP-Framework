<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     function.get_remote.php
 * Type:     function
 * Name:     get_remote
 * Purpose:  Gets a remote file and places the contents in your
             template. The file is cached, if desired.
 * Version:  0.9
 * Creator:  Eli Van Zoeren - eli@newmediacampaigns.com
 * -------------------------------------------------------------
 *
 * Copyright (c) 2009 New Media Campaigns
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *                
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *                
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.  
 */
 
function smarty_function_get_remote($params, &$smarty)
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
    
    // Retrieve the remote file
    $content = @getRemoteFile($opts);
    
    // Make sure we actually got something
    if (!$content) die ($opts['default']);
    
    // Fix relative urls to point to the old site
    if ($opts['fix'])
    {
        $opts['patterns'][] = '/('.$opts['fix'].')=[\'"]([^(?:http)|\/].*)[\'"]/ie';
		    $opts['replacements'][] = '"${1}=\'".$domain."/".getAbsolutePath($base_url."/${2}")."\'"';
        $opts['patterns'][] = '/('.$opts['fix'].')=[\'"](\/.*)[\'"]/ie';
		    $opts['replacements'][] = '"${1}=\'".$domain."${2}\'"';
    }
    $content = fixUrls($content, $opts);
    
    // Output the contents to the template
    return $content;
}


function getRemoteFile($opts)
{
    $content = file_get_contents($opts['url']);
    
    // Set to the default text if we didn't get anything
    if (!$content) $content = $opts['default'];
    
    return $content;
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