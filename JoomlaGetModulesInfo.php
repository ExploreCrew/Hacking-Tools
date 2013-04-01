<?php

/**
 * @author Jasman
 * @copyright ExploreCrew.Org 2012
 */


function cPOST($languagge='en_gb', $method='POST',$url,$data,$cookies=""){
    $header = array('Accept-Language: '.$languagge.',en-us;q=0.7,en;q=0.3' );
    $ch = curl_init();   
    if ($method == 'POST'){
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POST, TRUE );
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data );
    }elseif($method == 'GET'){
        curl_setopt($ch, CURLOPT_URL,$url.$data);
    }elseif($method == 'UPLOAD'){
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);       
    }
    curl_setopt($ch, CURLOPT_REFERER, $url);
    curl_setopt($ch, CURLOPT_COOKIESESSION, true);
    
    
    if ($cookies !== ""){
       curl_setopt($ch, CURLOPT_COOKIE,$cookies);
    } elseif ($cookies === ""){
		curl_setopt($ch, CURLOPT_COOKIEFILE, dirname(__FILE__).'/cookie.txt');
		curl_setopt($ch, CURLOPT_COOKIEJAR, dirname(__FILE__).'/cookie.txt');	
	}
    
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);      
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; rv:8.0) Gecko/20100101 Firefox/8.0');
    
    curl_setopt($ch, CURLOPT_HTTPHEADER,$header) ;
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
    return curl_exec($ch);
    curl_close($ch);	
}

function regex($str){
    preg_match_all("/(\/mod_|\/com_)(.*)(\/|\.)/U", $str, $matches);
    $output = array_unique($matches[0]);
    return array_values($output) ; 
}

function domain($str){
    $str = explode('/',$str);
    unset($str[count($str)-1]);
    return implode('/',$str);
}

if(isset($_POST['submit'])){
    $content = cPOST($languagge='en_gb', $method='GET',$_POST['url'],'','');
    $mod = regex($content);
    
    $output = '<table border="1" width="100%" style="border-collapse: collapse">';
    $output .= '<tr><td>No.</td><td>Name</td><td>Type</td><td>Alias</td><td>Version</td><td>Creation Date</td><td>Author Url</td></tr>';
    
    $host = domain($_POST['url']) ;
    
    for ($i=0;$i<count($mod);$i++){
        $x = $i + 1;
        if(preg_match('/mod\_/',$mod[$i])){
            $type = 'Modules';
            $modules = str_replace('/','',$mod[$i]);
            $modules = str_replace('.','',$modules);  
            $getMod = cPOST($languagge='en_gb', $method='GET',$host.'/modules/'.$modules.'/'.$modules.'.xml','','');
            preg_match_all("/\<version\>(.*)\<\/version\>/",$getMod,$InfoVersion);
            preg_match_all("/\<name\>(.*)\<\/name\>/",$getMod,$InfoName);
            preg_match_all("/\<creationDate\>(.*)\<\/creationDate\>/",$getMod,$InfoCreationDate);
            preg_match_all("/\<authorUrl\>(.*)\<\/authorUrl\>/",$getMod,$InfoAuthorUrl);
            
            $output .= '<tr><td>'.$x.'</td><td>'.$InfoName[1][0].'</td><td>'.$type.'</td><td><a href="'.$host.'/modules/'.$modules.'/'.$modules.'.xml" target="_blank" >'.$modules.'</a></td><td>'.$InfoVersion[1][0].'</td><td>'.$InfoCreationDate[1][0].'</td><td>'.$InfoAuthorUrl[1][0].'</td></tr>';      
        }elseif(preg_match('/com\_/',$mod[$i])){
            $type = 'Component';
            $component = str_replace('/','',$mod[$i]);
            $component = str_replace('.','',$component); 
            $getCom = cPOST($languagge='en_gb', $method='GET',$host.'/components/'.$component.'/'.$component.'.xml','','');
            preg_match_all("/\<version\>(.*)\<\/version\>/",$getCom,$ComVersion);
            preg_match_all("/\<name\>(.*)\<\/name\>/",$getCom,$ComName);
            preg_match_all("/\<creationDate\>(.*)\<\/creationDate\>/",$getCom,$ComCreationDate);
            preg_match_all("/\<authorUrl\>(.*)\<\/authorUrl\>/",$getCom,$ComAuthorUrl);
            $output .= '<tr><td>'.$x.'</td><td>'.$ComName[1][0].'</td><td>'.$type.'</td><td><a href="'.$host.'/components/'.$component.'/'.$component.'.xml" target="_blank" >'.$component.'</a></td><td>'.$ComVersion[1][0].'</td><td>'.$ComCreationDate[1][0].'</td><td>'.$ComAuthorUrl[1][0].'</td></tr>';   
        }
}
    $output .= '</table>';
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<meta name="author" content="Jasman" />
	<title>Joomla Get Modules Info</title>
</head>
<body>
<form action="" method="post" >
Url: <input type="text" value="" name="url" size="45"/>
<br/>
Link panjang, tidak diasumsikan pada halaman utama, <br/>contoh : http://site.com/index.php/9-berita/10-pelantikan-panitera-pengganti-a-jurusita-pengganti-pn-xxxx atau http://site.com/index.php/9-berita<br/>

<input type="submit" name="submit" value="Get Info" />
</form>
<br/>
<?php echo $output; ?>
</body>
</html>
