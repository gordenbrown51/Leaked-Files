<?php
session_start();
include("includes.php");
error_reporting(0);
$naslov = $jezik['text339'];
$fajl = "gp";
$return = "gp.php";
$ucp = "gp-serveri";
$gpr = "1";
$gps = "gp-konzola";


$serverid = mysql_real_escape_string($_GET['id']);

$server = query_fetch_assoc("SELECT * FROM `serveri` WHERE `id` = '".$serverid."'");
$box = query_fetch_assoc("SELECT * FROM `box` WHERE `boxid` = '".$server['box_id']."'");
$boxip = query_fetch_assoc("SELECT * FROM `boxip` WHERE `ipid` = '".$server['ip_id']."'");

if(klijentServeri($_SESSION['klijentid']) == 0)
{
	$_SESSION['msg'] = $jezik['text300'];
	header("Location: index.php");
}

$serverid = mysql_real_escape_string($_GET['id']);

if(!isset($_SESSION['klijentid'])){
	header("Location: process.php?task=logout");
}

if(!isset($_GET['id']) or !is_numeric($_GET['id']))
{
	$_SESSION['msg'] = $jezik['text311'];
	header("Location: gp-serveri.php");
	die();
}

if(query_numrows("SELECT `id` FROM `serveri` WHERE `user_id` = '".$_SESSION['klijentid']."' AND `id` = '".$serverid."'") == 0)
{
	$_SESSION['msg'] = $jezik['text312'];
	header("Location: gp-serveri.php");
	die();
}

?>

<style>
pre {
    white-space: pre-wrap;       /* CSS 3 */
    white-space: -moz-pre-wrap;  /* Mozilla, since 1999 */
    white-space: -pre-wrap;      /* Opera 4-6 */
    white-space: -o-pre-wrap;    /* Opera 7 */
    word-wrap: break-word;       /* Internet Explorer 5.5+ */
}
</style>
<?php
if(!empty($_GET['log']) == 'view')
{
	if($server['igra'] == "2")
	{
		$filename = "ftp://$server[username]:$server[password]@$box[ip]:$box[ftpport]/server_log.txt";
		$text = "<form><pre>Console Data (<a href='gh-console_log.php?id=$serverid'>Full view</a>) - Last 1000 lines<hr></pre></form>";
		$text .= file_get_contents($filename);
		echo $text;
	}
	else
	{
		if(!($con = ssh2_connect($boxip['ip'], $box['sshport']))) return $jezik['text292'];
		else 
		{
			if(!ssh2_auth_password($con, $server['username'], $server['password'])) return $jezik['text292'];
			else 
			{
				$stream = ssh2_exec($con,'tail -n 1000 screenlog.0'); 
				stream_set_blocking( $stream, true );
				
				$resp = '';
				
				while ($line=fgets($stream)) 
				{ 
				   if (!preg_match("/rm log.log/", $line) || !preg_match("/Creating bot.../", $line))
				   {
					   $resp .= $line; 
				   }
				} 
				
				if(empty( $resp )){ 
					$result_info = "Could not load console log";
			    }
			    else{ 
				      $result_info = $resp;
			    }
			}
		}

		$result_info = str_replace("/home", "", $result_info);
		$result_info = str_replace("/home", "", $result_info);
		$result_info = str_replace(">", "", $result_info);

		$text = "<form><pre>Console Data (<a href='gh-console_log.php?id=$serverid'>Full view</a>) - Last 1000 lines<hr></pre><form>";
		if($server['igra'] == "3") $text .= translateMCColors(htmlspecialchars($result_info));
		else $text .= htmlspecialchars($result_info);
		echo $text;
	}
}
else
{
	include("./assets/header.php"); ?>
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
                        <h4 class="c-red"><i class="fas fa-terminal"></i> Konzola</h4>
                        <p>Pošaljite komandu Vašem serveru</p>
                    </div>
                    <div class="panel-console">

<?php
	if(!($con = ssh2_connect($boxip['ip'], $box['sshport']))) return $jezik['text292'];
	else 
	{
		if(!ssh2_auth_password($con, $server['username'], $server['password'])) return $jezik['text292'];
		else 
		{
			$stream = ssh2_exec($con,'tail -n 1000 screenlog.0'); 
			stream_set_blocking( $stream, true );
			
			
			
			while ($line=fgets($stream)) 
			{ 
			   if (!preg_match("/rm log.log/", $line) || !preg_match("/Creating bot.../", $line))
			   {
				   $resp .= $line; 
			   }
			} 
			
			if(empty( $resp )){ 
				$result_info = "Could not load console log";
		    }
		    else{ 
			      $result_info = $resp;
		    }
		}
	}

	$result_info = str_replace("/home", "", $result_info);
	$result_info = str_replace("/home", "", $result_info);	
	$result_info = str_replace(">", "", $result_info);
?>

<?php
	if($server['igra'] == "2")
	{
		echo "<form><pre>";
		$filename = "ftp://$server[username]:$server[password]@$box[ip]:$box[ftpport]/server_log.txt";
		$text = "Console Data (<a href='gh-console_log.php?id=$serverid'>Full view</a>) - Last 1000 lines<hr>";
		$text .= file_get_contents($filename);
		echo $text;
		echo "</pre></form>";
	}
	else if($server['igra'] == "3")
	{
		echo "<form><pre>";
		$text = "Console Data (<a href='gh-console_log.php?id=$serverid'>Full view</a>) - Last 1000 lines<hr>";
		$text .= translateMCColors(htmlspecialchars($result_info));
		echo $text;
		echo "</pre></form>";
	}
	else
	{
		echo "<form><pre>";
		$text = "Console Data (<a href='gh-console_log.php?id=$serverid'>Full view</a>) - Last 1000 lines<hr>";
		$text .= htmlspecialchars($result_info);
		echo $text;
		echo "</pre></form>";
	}
?>
				</div>
<?php
				if($server['igra'] == "1")
				{
					$rcona24 = cscfg('rcon_password', $serverid);
					if(!empty($rcona24)) {
?>				
					<form method="post" action="serverprocess.php">
						<input type="hidden" name="task" value="rcon" />
						<input type="hidden" name="serverid" value="<?php echo $serverid; ?>" />
						<input name="rcon" type="text" placeholder="/komanda"/>
					</form>
<?php
					}
				}
				else if($server['igra'] == "3")
				{
					$rcon = mccfg('enable-rcon', $serverid);
					$rconpw = mccfg('rcon.password', $serverid);
					if($rcon == "true" AND !empty($rconpw)) {
?>				
					<form method="post" action="serverprocess.php">
						<input type="hidden" name="task" value="rcon" />
						<input type="hidden" name="serverid" value="<?php echo $serverid; ?>" />
						<input name="rcon" type="text" placeholder="/komanda"/>
					</form><?php
					}	
				}				
?>
</div></div></div>
<?php
include("./assets/footer.php");
}
?>