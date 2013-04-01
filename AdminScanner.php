<?php

/*
 * Admin Scanner 
 * Author c1ck0 
 * Email: riky.hasibuan@gmail.com 
 * Thanks to : ArRay,K4pT3N,Jasman,N4ck0,Vba and all explorecrews
 * www.ExploreCrew.org | ExploreCrew UnderGround Coder Team!
*/

echo '
	<h2>Admin Scanner</h2>
	<p>Input Your URL with backslashes at end. example : http://target.com/</p>
	<form action="?action=search" method="post">
	<input name="url" type="text" size="30" >
	<input name="search" value="search" type="submit">
	</form>'
	;

set_time_limit(0);
error_reporting(0);

if ($_GET['action'] == "search") {
	$url = $_POST['url'];
	echo "<br />Search : <b></b>".$url."</b><br><br>";
	
	// kosakata lokasi adminnya, bisa ditambahin lagi
	$location = array('admin.php','admin/','administrator/','moderator/','webadmin/','adminarea/','bb-admin/','adminLogin/',
					  'admin_area/','panel-administracion/','instadmin/','memberadmin/','administratorlogin/','adm/',
					  'admin/account.php','admin/index.php','admin/login.php','admin/admin.php','admin/account.php',
					  'joomla/administrator','login.php','admin_area/admin.php','admin_area/login.php','siteadmin/login.php',
					  'siteadmin/index.php','siteadmin/login.html','admin/account.html','admin/index.html','admin/login.html',
					  'admin/admin.html','admin_area/index.php','bb-admin/index.php','bb-admin/login.php','bb-admin/admin.php',
					  'admin/home.php','admin_area/login.html','admin_area/index.html','admin/controlpanel.php','admincp/index.asp',
					  'admincp/login.asp','admincp/index.html','admin/account.html','adminpanel.html','webadmin.html','webadmin/index.html',
					  'webadmin/admin.html','webadmin/login.html','admin/admin_login.html','admin_login.html','panel-administracion/login.html',
					  'admin/cp.php','cp.php','administrator/index.php','administrator/login.php','nsw/admin/login.php','webadmin/login.php',
					  'admin/admin_login.php','admin_login.php','administrator/account.php','administrator.php','admin_area/admin.html',
					  'pages/admin/admin-login.php','admin/admin-login.php','admin-login.php','bb-admin/index.html','bb-admin/login.html',
					  'bb-admin/admin.html','admin/home.html','modelsearch/login.php','moderator.php','moderator/login.php','moderator/admin.php',
					  'account.php','pages/admin/admin-login.html','admin/admin-login.html','admin-login.html','controlpanel.php','admincontrol.php',
					  'admin/adminLogin.html','adminLogin.html','admin/adminLogin.html','home.html','rcjakar/admin/login.php','adminarea/index.html',
					  'adminarea/admin.html','webadmin.php','webadmin/index.php','webadmin/admin.php','admin/controlpanel.html','admin.html',
					  'admin/cp.html','cp.html','adminpanel.php','moderator.html','administrator/index.html','administrator/login.html',
					  'user.html','administrator/account.html','administrator.html','login.html','modelsearch/login.html',
					  'moderator/login.html','adminarea/login.html','panel-administracion/index.html','panel-administracion/admin.html',
					  'modelsearch/index.html','modelsearch/admin.html','admincontrol/login.html','adm/index.html','adm.html',
					  'moderator/admin.html','user.php','account.html','controlpanel.html','admincontrol.html',
					  'panel-administracion/login.php','wp-login.php','adminLogin.php','admin/adminLogin.php','home.php',
					  'adminarea/index.php','adminarea/admin.php','adminarea/login.php','panel-administracion/index.php',
					  'panel-administracion/admin.php','modelsearch/index.php','modelsearch/admin.php','admincontrol/login.php',
					  'adm/admloginuser.php','admloginuser.php','admin2.php','admin2/login.php','admin2/index.php','adm/index.php',
					  'adm.php','affiliate.php','adm_auth.php','memberadmin.php');
	
	/*
	 * function untuk menampilkan output secara satu persatu melalui output buffering
	 * kalau ga berfungsi, bisa di set di php.ini
	 * "output_buffering = Off"
	 * "zlib.output_compression = Off"
	*/
	
	ob_implicit_flush(true);
	ob_end_flush();

	foreach ($location as $adminlocation){
		$headers = get_headers("$url$adminlocation");
		if (!$headers) {
			// kalo ga pake http:// bakal muncul error
			echo "<font color='red'>please put http:// on your url</font>";
			exit;
		} else {
			if (eregi('200', $headers[0])) {
				echo "<a href='$url$admin'>$url$adminlocation</a> <font color='green'>Found!</font><br />";
			} else {
				echo "$url$adminlocation <font color='red'>NOT Found!</font><br />";
			}
		} 
		sleep(1);
	}
}
?>
