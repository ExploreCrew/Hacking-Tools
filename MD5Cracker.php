<?php
error_reporting(0);
echo "\n___________               __                __       	";                  
echo "\n\_   _____/__  _________ |  |   ____  __  _|  |__		";
echo "\n |    __)_\  \/  /\____ \|  |  /  _ \|  |/_    _/		";
echo "\n |        \>    < |  |_> >  |_(  <_> )  |  |  |__		";
echo "\n/_______  /__/\_ \|   __/|____/\____/|__|  \____/		";
echo "\n        \/      \/|__|                             	";    
echo "\nCoded by jasman@ihsana.com\n"; 
echo "\nThank to Anaski Crewz\n";  
echo "\nFor education purphose only, If you do not agree, ";
echo "\nplease remove.\n";
function logs($reason,$ext = "txt"){
    if(!is_dir("files")):mkdir("files","0493");
    endif;
    $fp = fopen("files/".date("m-d-y").".".$ext, "a+");
    fwrite($fp, "**|md5 Cracker|".date("g:i:sA")."|".$reason."|\n");
}
if(isset($_SERVER['argv'][1])){ 
    $str = $_SERVER['argv'][1];
	echo "\n".$_SERVER['argv'][1]; 
    $charset  = "1234567890";
    $charset .= "abcdefghijklmnopqrstuvwxyz";
    $charset .= "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $charset .= " ~!@#$%^&*()_+|`\={}[]:;'<>,./?";
    $charset_length = strlen($charset);
    function check($string,$str){ 
        echo "\n=>".md5($string)."=>". $string ;
        if ($str == md5($string)){
            echo "\n\n\nHash: ".$str;
            echo "\nCrack:".$string;
			logs($string.":".md5($string),"txt");
            echo "\n" ; exit() ; 
        } 
    }
    function recurse ($width,$position,$base_str,$str){
        global $charset, $charset_length ;
        for ($i = 0 ; $i < $charset_length ; $i++) {
            if ($position < $width - 1){
               recurse($width,$position+1,$base_str.$charset[$i],$str);
            };
            check($base_str.$charset[$i],$str);
        } 
    }
	for ($i = 6 ; $i < 32 ; $i++) {
		recurse($i,0,"",$str);
	}
} else {
	echo "\nHelp";
	echo "\nphp md5.php hash";
}
?>
