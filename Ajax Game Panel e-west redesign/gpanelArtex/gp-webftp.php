<?php
session_start();

$naslov = $jezik['text444'];
$fajl = "gp";
$return = "gp.php";
$ucp = "gp-serveri";
$gpr = "1";
$gps = "gp-webftp";

include("includes.php");

if(klijentServeri($_SESSION['klijentid']) == 0)
{
	$_SESSION['msg'] = $jezik['text300'];
	header("Location: index.php");
	die();
}

$serverid = mysql_real_escape_string($_GET['id']);

if(!isset($_SESSION['klijentid'])){
	header("Location: process.php?task=logout");
	die();
}

if(!isset($_GET['id']) or !is_numeric($_GET['id']))
{
	$_SESSION['msg'] = $jezik['text311'];
	header("Location: gp-serveri.php");
	die();
}

if(isset($_GET['path']))
{
	$lokacija = sqli($_GET['path']);
}

if(query_numrows("SELECT `id` FROM `serveri` WHERE `user_id` = '".$_SESSION['klijentid']."' AND `id` = '".$serverid."'") == 0)
{
	$_SESSION['msg'] = $jezik['text312'];
	header("Location: gp-serveri.php");
	die();
}

$server = query_fetch_assoc("SELECT * FROM `serveri` WHERE `id` = '".$serverid."'");
$boxip = query_fetch_assoc("SELECT * FROM `boxip` WHERE `ipid` = '".$server['ip_id']."'");
$box = query_fetch_assoc("SELECT * FROM `box` WHERE `boxid` = '".$server['box_id']."'");

$ip = $boxip['ip'];

if(isset($_GET["path"]))
{
	$path = $_GET["path"];
	$back_link = dirname( $path );

	$ftp_path = substr($path, 1);
	$breadcrumbs = preg_split('/[\/]+/', $ftp_path, 9);	
	$breadcrumbs = str_replace("/", "", $breadcrumbs);

	$ftp_pth = '';
	if(($bsize = sizeof($breadcrumbs)) > 0) 
	{
		$sofar = '';
		for($bi=0;$bi<$bsize;$bi++) 
		{
			if($breadcrumbs[$bi])
			{
				$sofar = $sofar . $breadcrumbs[$bi] . '/';

				$ftp_pth .= '  <i class="icon-angle-right"></i>  <a href="gp-webftp.php?id='.$serverid.'&path=/'.$sofar.'"><i class="icon-folder-open"></i> '.$breadcrumbs[$bi].'</a>';
			}
		}
	}
}
else
{
	header("Location: gp-webftp.php?id=".$serverid."&path=/");
	die();
}

$ftp = ftp_connect($ip, $box['ftpport']);
if(!$ftp)
{
	$_SESSION['msg'] = $jezik['text121'];
	header("Location: gp-server.php?id=".$serverid);
	die();
}

if (@ftp_login($ftp, $server["username"], $server["password"]))
{
	ftp_pasv($ftp, true);
	if(!isset($_GET['fajl']))
	{
		
		ftp_chdir($ftp, $path);
		$ftp_contents = ftp_rawlist($ftp, $path);
		$i = "0";

		foreach ($ftp_contents as $folder)
		{
			$broj = $i++;	
			$current = preg_split("/[\s]+/",$folder,9);

			$isdir = ftp_size($ftp, $current[8]);
			if ( substr( $current[0][0], 0 - 1 ) == "l" )
			{
				$ext = explode(".", $current[8]);
				
				$xa = explode("->", $current[8]);
				
				$current[8] = $xa[0];
				
				$current[0] = "link";
				
				$current[4] = $jezik['text445'];
				
				$ftp_fajl[]=$current;
			}
			else
			{
				if ( substr( $current[0][0], 0 - 1 ) == "d" ) $ftp_dir[]=$current;
				else 
				{
					$text = array( "txt", "cfg", "sma", "SMA", "CFG", "inf", "log", "rc", "ini", "yml", "json", "properties" );
					$ext = explode(".", $current[8]);
					if($ext[2] == "conf") $current[9] = $ext[1];
					else if(!empty($ext[1])) if (in_array( $ext[1], $text )) $current[9] = $ext[1];
					
					$ftp_fajl[]=$current;
				}
			}	
		}
    }
	else
	{
		$filename = "ftp://$server[username]:$server[password]@$ip:21".$lokacija."/$_GET[fajl]";
		$contents = file_get_contents($filename);
	}  
	if(isset($_GET["path"])) {
		$old_path = ''.$_GET["path"].'/';
		$old_path = str_replace('//', '/', $old_path);
	}	
}
else 
{
	$_SESSION['msg'] = $jezik['text446'];
	header("Location: gp-server.php?id=".$serverid);
	die();
}

ftp_close($ftp);

include("./assets/header.php");
if(isset($_GET["path"])) {
?>
    <div class="main">
        <div class="panel">
            <div class="panel-nav">
                    <ul class="light-border">
                        <a href="gp-server.php?id=<?php echo $serverid; ?>">
                            <li <?php if($gps == "gp-server") echo 'class="panel-nav-active"'; ?>>
                                <i class="icon-flag"></i> <?php echo $jezik['text20']; ?>
                            </li>
                        </a>
                        <a href="gp-webftp.php?id=<?php echo $serverid; ?>">
                            <li <?php if($gps == "gp-webftp") echo 'class="panel-nav-active"'; ?>>
                                <i class="icon-folder-open"></i> <?php echo $jezik['text21']; ?>
                            </li>
                        </a>
<?php
                        if($server['igra'] == "1") {
?>
                        <a href="gp-admini.php?id=<?php echo $serverid; ?>">
                            <li <?php if($gps == "gp-admini") echo 'class="panel-nav-active"'; ?>>
                                <i class="icon-group"></i> <?php echo $jezik['text22']; ?>
                            </li>
                        </a>
                        <a href="gp-plugins.php?id=<?php echo $serverid; ?>">
                            <li <?php if($gps == "gp-plugins") echo 'class="panel-nav-active"'; ?>>
                                <i class="icon-gear"></i> <?php echo $jezik['text23']; ?>
                            </li>
                        </a>
<?php
                        }
?>
                        <a href="gp-modovi.php?id=<?php echo $serverid; ?>">
                            <li <?php if($gps == "gp-modovi") echo 'class="panel-nav-active"'; ?>>
                                <i class="icon-gear"></i> <?php echo $jezik['text24']; ?>
                            </li>
                        </a>
                        <a href="gp-konzola.php?id=<?php echo $serverid; ?>">
                            <li <?php if($gps == "gp-konzola") echo 'class="panel-nav-active"'; ?>>
                                <i class="icon-th-list"></i> Console
                            </li>
                        </a>
                        <!--<a href="gp-backup2.php?id=<?php echo $serverid; ?>">
                            <li <?php if($gps == "gp-backup2") echo 'class="active"'; ?>>
                                <i class="icon-download"></i> Backup
                            </li>
                        </a>-->
                        <a href="gp-reinstall.php?id=<?php echo $serverid; ?>">
                            <li <?php if($gps == "gp-reinstall") echo 'class="panel-nav-active"'; ?>>
                                <i class="icon-refresh"></i> <?php echo $jezik['text25']; ?>
                            </li>
                        </a>
                        <a href="gp-transfer.php?id=<?php echo $serverid; ?>">
                            <li <?php if($gps == "gp-transfer") echo 'class="panel-nav-active"'; ?>>
                                <i class="icon-gear"></i> <?php echo "Transfer"; ?>
                            </li>
                        </a>



<?php
                        if($server['igra'] == "1") {
?>
                        <a href="gp-boost.php?id=<?php echo $serverid; ?>">
                            <li <?php if($gps == "gp-boost") echo 'class="panel-nav-active"'; ?>>
                                <i class="icon-random"></i> <?php echo $jezik['text26']; ?>
                            </li>
                        </a>

<?php
                        }
?>
                                                <a href="gp-autorestart.php?id=<?php echo $serverid; ?>">
                            <li <?php if($gps == "gp-autorestart") echo 'class="panel-nav-active"'; ?>><i class="icon-refresh"></i> AutoRR</li>
                        </a>


                    </ul>
                </div>

            <div class="panel-main">
                <div class="panel-padding">
                    <div class="panel-title">
                        <h4 class="c-red"><i class="fas fa-server"></i> WebFTP</h4>
<p>
	<i class="icon-home"></i> <?php printf("<a href='gp-webftp.php?id=%s'>Root</a>", $serverid); ?>
	<?php echo $ftp_pth; if(isset($_GET['fajl'])) { ?>  <i class="icon-angle-right"></i>  <i class="icon-file"></i> <?php echo htmlspecialchars($_GET['fajl']); } ?>
<?php } else { ?>

	<i class="icon-home"></i> <?php printf("<a href='gp-webftp.php?id=%s'>Root</a>", $serverid); ?>
	<?php if(isset($_GET['fajl'])) { ?>  <i class="icon-angle-right"></i>  <i class="icon-file"></i> <?php echo htmlspecialchars($_GET['fajl']); } ?>

<?php } ?>
</p>
                    </div>
<?php
if(!isset($_GET['fajl'])){
?>
<div class="panel-header light-border" style="margin: 10px 0 0 0">
<div class="ftp-buttons">
<form action="process.php" method="post" enctype="multipart/form-data" id="auto-submit">
	<input type="hidden" name="task" value="uploadfajla" />
	<input type="hidden" name="serverid" value="<?php echo $serverid; ?>" />
	<input type="hidden" name="lokacija" value="<?php echo $lokacija; ?>" />
	<input type="file" name="file" id="file">
</form>
<script>
document.getElementById("file").onchange = function() {
    document.getElementById("auto-submit").submit();
};
</script>
		 <button class="ftp-button-option c-4d4d4d" style="color: #4d4d4d;text-align: right;padding: 5px 10px;margin: 5px 5px;"><a rel="modal:open" style="color: #4d4d4d" href="#mex3" type="button"><i class="icon-credit-card"></i> <?php echo $jezik['text450']; ?></a></button>
</div>
</div>
<?php
}
?>
<?php
if(!isset($_GET['fajl'])) {
?>
<div class="user-files">
<div class="user-server-single" style="overflow-x:auto;">
<table>
	<tr>
		<th><?php echo $jezik['text453']; ?></th>
		<th><?php echo $jezik['text454']; ?></th>
		<th><?php echo $jezik['text455']; ?></th>
		<th><?php echo $jezik['text456']; ?></th>
		<th><?php echo $jezik['text457']; ?></th>
		<th><?php echo $jezik['text458']; ?></th>
		<th><?php echo $jezik['text459']; ?></th>
	</tr>
<?php
	$back_link = str_replace("\\", '/', $back_link);
	if($path != "/")
	{
?>
	<tr>
		<td onClick="window.location='?id=<?php echo $serverid; ?><?php if ($back_link != "/") { ?>&path=<?php echo $back_link; } ?>'">
		<z><i class="icon-arrow-left"></i></z>  ...
		</td>
	</tr>
<?php
	}
	foreach($ftp_dir as $x)
	{
?>
	<tr>
		<td>
			<a href="gp-webftp.php?id=<?php echo $serverid; ?>&path=<?php echo $old_path."".$x[8]; ?>">
				<i class='icon-folder-open' style="color: yellow;"></i>
<?php
				echo $x[8];
?>
			</a>
		</td>	
		<td>-</td>
		<td>
		<?php echo $x[2]; ?>
		</td>
		<td>
		<?php echo $x[3]; ?>
		</td>
		<td>
		<?php echo $x[0]; ?>
		</td>
		<td>
		<?php echo $x[5].' '.$x[6].' '.$x[7]; ?>
		</td>		
		<td>
			<form method="POST" action="process.php" id="izbrisi-folder">
				<a rel="modal:open" href="#mex2" onclick='imefoldera("<?php echo $x[8]; ?>");'>
					<button class="bg-red c-white" style="padding: 2px 3px; font-size: 14px; margin: 0 2px;"><i class="icon-remove"></i></button>
				</a>
			</form>
			<form method="POST" action="serverprocess.php">
				<a rel="modal:open" href="#mex4" onclick='imeftpf("<?php echo $x[8]; ?>");'>
					<button class="bg-blue c-white" style="padding: 2px 3px; font-size: 14px; margin: 0 2px;"><i class="icon-edit"></i></button>
				</a>
			</form>			
		</td>
	</tr>
<?php
	}
?>
<?php
	if(!empty($ftp_fajl))
	{
		foreach($ftp_fajl as $x)
		{
?>
		<tr>
			<td title="<?php echo $x[8]; ?>">
<?php
			if(isset($x[9]))
			{
?>
			<a href="gp-webftp.php?id=<?php echo $serverid; ?>&path=<?php echo $old_path; ?>&fajl=<?php echo $x[8]; ?>">
				<i class='icon-file-text'></i>
<?php
				limittext($x[8]);
?>
			</a>
<?php
			}
			else
			{
?>
				<i class='icon-file'></i>
<?php
				limittext($x[8]);
?>
<?php		
			}
?>
			</td>
			<td>
<?php

			if($x[4] == $jezik['text445']) echo $x[4];
			else {			
				if($x[4] < 1024) echo $x[4]." byte";
				else if($x[4] < 1048576) echo round(($x[4]/1024), 0)." KB";
				else echo round(($x[4]/1024/1024), 0)." MB";
			}
?>
			</td>
			<td>
			<?php echo $x[2]; ?>
			</td>
			<td>
			<?php echo $x[3]; ?>
			</td>
			<td>
			<?php echo $x[0]; ?>
			</td>
			<td>
			<?php echo $x[5].' '.$x[6].' '.$x[7]; ?>
			</td>
			<td>
				<form method="POST" action="process.php" id="izbrisi-fajl">
					<a href="#mex1" rel="modal:open" onclick='imefajla("<?php echo $x[8]; ?>");'>
						<button style="padding: 2px; margin: 0 2px;" class="bg-red c-white"><i class="icon-remove"></i></button>
					</a>
				</form>
				<form method="POST" action="process.php">
					<a href="#mex4" rel="modal:open" onclick='imeftpf("<?php echo $x[8]; ?>");'>
						<button style="padding: 2px; margin: 0 2px;" class="bg-blue c-white"><i class="icon-edit"></i></button>
					</a>
				</form>
			</td>
		</tr>
<?php
		}
	}
?>
</table>
</div>
<?php
}
else
{
?>
<div class="panel-file-edit">
		<form action="process.php" method="POST" class="light-border" style="border-radius: 10px">
			<input type="hidden" name="task" value="spremanjefajla" />
			<input type="hidden" name="fajl2" value="<?php echo htmlspecialchars($_GET['fajl']); ?>" />
			<input type="hidden" name="lokacija" value="<?php echo $lokacija; ?>" />
			<input type="hidden" name="serverid" value="<?php echo $serverid; ?>" />
			<textarea name="tekstf" height="auto"><?php echo htmlspecialchars($contents); ?></textarea><br /><br />
			<button style="margin: 10px 5px;" type="submit"><?php echo $jezik['text460']; ?></button>
		</form>		
	</div>
<?php
}
?>
</div></div></div></div>
<?php
include("./assets/footer.php");
?>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-46634717-1', 'e-trail.eu');
  ga('send', 'pageview');

</script>