<?php
session_start();
include("includes.php");
$naslov = $jezik['text368'];
$fajl = "gp";
$return = "gp.php";
$ucp = "gp-serveri";
$gpr = "1";
$gps = "gp-server";
$domena = $_SERVER['SERVER_NAME'];

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

if(query_numrows("SELECT `id` FROM `serveri` WHERE `user_id` = '".$_SESSION['klijentid']."' AND `id` = '".$serverid."'") == 0)
{
	$_SESSION['msg'] = $jezik['text312'];
	header("Location: gp-serveri.php");
	die();
}

include("./assets/header.php");
$server = query_fetch_assoc("SELECT s.*, k.ime, k.prezime, k.klijentid FROM serveri s, klijenti k WHERE s.id = {$serverid} AND k.klijentid = s.user_id");
?>
    <div class="main">
        <div class="panel">
<?php

$ip = ipadresa($server['id']);
$ip = explode(":", $ip);

require("./includes/libs/lgsl/lgsl_class.php");

$box = query_fetch_assoc("SELECT * FROM `box` WHERE `boxid` = '".$server['box_id']."'");
$boxip = query_fetch_assoc("SELECT * FROM `boxip` WHERE `ipid` = '".$server['ip_id']."'");

if($server['igra'] == "1") $querytype = "halflife";
else if($server['igra'] == "2") $querytype = "samp";
else if($server['igra'] == "3") $querytype = "minecraft";
else if($server['igra'] == "4") $querytype = "samp";
else if($server['igra'] == "5") $querytype = "mta";

if($server['startovan'] == "1")
{
	if($server['igra'] == "5") $serverl = lgsl_query_live($querytype, $boxip['ip'], NULL, $server['port']+123, NULL, 's');
	else $serverl = lgsl_query_live($querytype, $boxip['ip'], NULL, $server['port'], NULL, 's');
	
	$srvmapa = @$serverl['s']['map'];
	$srvime = @$serverl['s']['name'];
	$srvigraci = @$serverl['s']['players'].'/'.@$serverl['s']['playersmax'];
}

if(@$serverl['b']['status'] == '1') $srvonline = $jezik['text218'];
else $srvonline = $jezik['text219'];


?>

<?php
            if(isset($gpr)) {
                if($gpr=="1"){
?>

<?php       if($gps != "server") { ?>
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
						<a href="gp-podrska.php?pokazi=sve">
                            <li <?php if($gps == "tiketi") echo 'class="panel-nav-active"'; ?>>
                                <i class="fas fa-ticket-alt"></i> Tiketi
                            </li>
                        </a>
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
                    <div class="panel-header light-border">
                    	<p class="bg-green c-white bold panel-header-status"><?php echo srv_status($server['status']); ?></p><p class="bold"><?php echo $server["ime"]; ?></p>
                <?php
                        if($server['startovan'] == "0") {
?>
                        <form method="POST" action="serverprocess.php">
                            <input type="hidden" name="task" value="server-start" />
                            <input type="hidden" name="serverid" value="<?php echo $serverid; ?>" />
                            <button type="submit"><i class="icon-power-off"></i> <?php echo $jezik['text28']; ?></button>
                        </form>
<?php
                        } else {
?>
                        <form method="POST" action="serverprocess.php">
                            <input type="hidden" name="task" value="server-stop" />
                            <input type="hidden" name="serverid" value="<?php echo $serverid; ?>" />
                            <button type="submit" class="bg-red c-white"><i class="icon-off"></i> <?php echo $jezik['text29']; ?></button>
                        </form>

                        <form method="POST" action="serverprocess.php">
                            <input type="hidden" name="task" value="server-restart" />
                            <input type="hidden" name="serverid" value="<?php echo $serverid; ?>" />
                            <button type="submit" class="bg-yellow c-white"><i class="icon-refresh"></i> <?php echo $jezik['text30']; ?></form>
                            </button>
                        </form>
<?php
                        }

?>
</div>

                    <div class="panel-status">
                        <ul>
                            <li>
                                <h3 class="c-red"><i class="fas fa-map"></i> Mapa</h3>
                                <h4><?php echo $server['map']; ?></h4>
                            </li>
                            <li>
                                <?php if($server['igra'] == "3") { ?>
                                <h3 class="c-blue"><i class="fas fa-memory"></i> Memorija</h3>
                                <h4><?php echo $server['slotovi']; ?> GB</h4>
                                <?php } else { ?>
                                <h3 class="c-blue"><i class="fas fa-users"></i> Slotovi</h3>
                                <h4><?php echo $server['slotovi']; ?></h4>
                                <?php } ?>
                            </li>
                            <li>
                                <h3 class="c-purple"><i class="fas fa-trophy"></i> Rank</h3>
                                <h4>#<?php echo htmlspecialchars($server['rank']); ?></h4>
                            </li>
                            <li>
                                <h3 class="c-yellow"><i class="fab fa-modx"></i> Mod</h3>
                                <h4><?php echo srv_mod($server['mod']); ?></h4>
                            </li>
                        </ul>
                    </div>
<?php
                }
                }
            }
?>

<?php
		if($server['status'] == "Istekao")
		{
			$ist = strtotime($server['istice']);
			$ist = $ist+432000;
			$ist = date("H:i, d.m.Y", $ist);

		$_SESSION['msg'] = "Server Vam ubrzo ističe ili je istekao.!"
?>
<?php
		}
		if($server['igra'] == "1" AND cscfg("rcon_password", $serverid) == NULL)
		{
			$_SESSION['msg'] = $jezik['text373'];
?>
<?php		
		}
?>
                    <div class="panel-essentials light-border">
                        <ul>
                            <li><font class="bold">Ime Servera:</font> <?php echo htmlspecialchars($server['name']); ?></li>
                            <li><font class="bold">Trajanje:</font> <?php echo srv_istekao($server['id']); ?></li>
                            <li><font class="bold">Vrsta Igre:</font> <?php echo igra($server['igra']); ?></li>
                            <li><font class="bold">IP Adresa:</font> <?php echo ipadresa($server['id']); ?></li>
                        </ul>

                        <ul>
                            <li><font class="bold">FTP IP:</font> <?php echo $boxip['ip']; ?></li>
                            <li><font class="bold">FTP User:</font> <?php echo $server['username']; ?></li>
                            <li><font class="bold">FTP Password:</font> <?php echo $server['password']; ?></li>
                            <li><font class="bold">FTP Port:</font> <?php echo $box['ftpport']; ?></li>
                        </ul>
                    <div class="panel-grafik">
                        <img src="gp-banner.php?id=<?php echo $serverid; ?>" />
                    </div>
                    </div>

</div></div></div></div>
<?php
include("./assets/footer.php");
?>
