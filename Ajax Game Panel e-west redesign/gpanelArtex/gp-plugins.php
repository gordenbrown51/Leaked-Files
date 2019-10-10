<?php
session_start();
include("includes.php");
$naslov = $jezik['text339'];
$fajl = "gp";
$return = "gp.php";
$ucp = "gp-serveri";
$gpr = "1";
$gps = "gp-plugins";



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
$serverid = mysql_real_escape_string($_GET['id']);

$server = query_fetch_assoc("SELECT * FROM `serveri` WHERE `id` = '".$serverid."'");
$box = query_fetch_assoc("SELECT * FROM `box` WHERE `boxid` = '".$server['box_id']."'");
$boxip = query_fetch_assoc("SELECT * FROM `boxip` WHERE `ipid` = '".$server['ip_id']."'");

if($server['igra'] == "1")
{
	$sql = "SELECT * FROM `plugins`";
}
else
{
	$_SESSION['msg'] = $jezik['text313'];
	header("Location: gp-server.php?id=".$serverid);
	die();
}

$mod = mysql_query($sql);

include("./assets/header.php");

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
                        <h4 class="c-red"><i class="fas fa-server"></i> Plugins</h4>
                        <p>Plugini za Vaš server</p>
                        <?php if(mysql_num_rows($mod) == 0) echo'<h3><i class="fas fa-exclamation-triangle"></i> '.$jezik['text340'].'</h3'; ?>
                    </div>

<div class="user-servers">

<?php	
		while($row = mysql_fetch_array($mod))
		{	
?>
    <div class="user-server-single">
	<table>
		<tr>
			<th><?php echo $jezik['text342']; ?></th>
			<td><?php echo $row['ime']; ?></td>
		</tr>
		
		<tr>
			<th><?php echo $jezik['text341']; ?></th>
			<td><?php echo $row['deskripcija']; ?></td>
		</tr>

		<tr>
			<th><?php echo $jezik['text334']; ?></th>
<?php
					$fajl = "ftp://$server[username]:$server[password]@$boxip[ip]:21/cstrike/addons/amxmodx/configs/{$row['prikaz']}";

					if (file_exists($fajl))
					{
?>					
					<td>
						<form action="serverprocess.php" method="post">
							<input type="hidden" name="task" value="plugin-remove" />
							<input type="hidden" name="serverid" value="<?php echo $serverid; ?>" />
							<input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
							<button onclick="loading('<?php echo $jezik['text343']; ?>...')" type="submit">
								<i class="icon-remove"></i> <?php echo $jezik['text344']; ?>
							</button>
						</form>					
					</td>
<?php
					}
					else
					{
?>
					<td>
						<form action="serverprocess.php" method="post">
							<input type="hidden" name="task" value="plugin-add" />
							<input type="hidden" name="serverid" value="<?php echo $serverid; ?>" />
							<input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
							<button onclick="loading('<?php echo $jezik['text345']; ?>...')" type="submit">
								<i class="icon-plus"></i> <?php echo $jezik['text338']; ?>
							</button>
						</form>
					</td>					
<?php
					}
?>
		</tr>
</table>
</div>
<?php	
		}				
?>					
</div></div></div></div></div>


<?php
include("./assets/footer.php");
?>