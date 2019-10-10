<?php
session_start();
include("includes.php");
$naslov = $jezik['text310'];
$fajl = "gp";
$return = "gp.php";
$ucp = "gp-serveri";
$gpr = "1";
$gps = "gp-admini";



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

if(query_numrows("SELECT `id` FROM `serveri` WHERE `user_id` = '{$_SESSION['klijentid']}' AND `id` = '{$serverid}'") == 0)
{
	$_SESSION['msg'] = $jezik['text312'];
	header("Location: gp-serveri.php");
	die();
}
$serverid = mysql_real_escape_string($_GET['id']);

$server = query_fetch_assoc("SELECT * FROM `serveri` WHERE `id` = '{$serverid}'");
$boxip = query_fetch_assoc("SELECT * FROM `boxip` WHERE `ipid` = '{$server['ip_id']}'");

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

$ip = $boxip['ip'];

include("./assets/header.php");

$filename = "ftp://$server[username]:$server[password]@$ip:21/cstrike/addons/amxmodx/configs/users.ini";
$contents = file_get_contents($filename);	

$fajla = explode("\n;", $contents);
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
                        <h4 class="c-red"><i class="fas fa-server"></i> Admini</h4>
                        <p>Instalirajte mod za Vaš server</p>
                       <?php if(empty($admin)) { ?> 
                       <h3> Nisu pronađeni admini!</h3> 
                     <?php } ?>
                        	<a href="gp-adminadd.php?id=<?php echo $serverid; ?>"><button><i class="icon-credit-card"></i> <?php echo $jezik['text319']; ?></button></a>
</div>
                    </div>

<div class="user-servers">
<?php
		foreach($fajla as $sekcija)
		{
			$linije = explode("\n", $sekcija);
			array_shift($linije);
			
			foreach($linije as $linija)
			{
				$admin = explode('"',$linija);
				if(!empty($admin[1]) && !empty($admin[5])) { ?>
<div class="user-server-single">
	<table>
		<tr>
			<th><?php echo $jezik['text314']; ?></th>
			<td><?php echo htmlspecialchars($admin[1]); ?></td>
		</tr>

		<tr>
			<th><?php echo $jezik['text315']; ?></th>
			<td><?php echo htmlspecialchars($admin[3]); ?></td>
		</tr>

		<tr>
			<th><?php echo $jezik['text316']; ?></th>
			<td><?php echo htmlspecialchars($admin[5]); ?></td>
		</tr>

		<tr>
			<th><?php echo $jezik['text317']; ?></th>
			<td><?php echo htmlspecialchars($admin[7]); ?></td>
		</tr>

		<tr>
			<th><?php echo $jezik['text318']; ?></th>
			<td><?php echo str_replace("//", "", htmlspecialchars($admin[8])); ?></td>
		</tr>
	</table>
</div>

<?php
				} 
			}
		}
?>
</div></div>
<?php
include("./assets/footer.php");
?>