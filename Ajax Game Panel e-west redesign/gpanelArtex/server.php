<?php
session_start();
include("includes.php");
$serverid = mysql_real_escape_string($_GET['id']);
$fajl = "server";
$return = "server.php";
$ucp = "server";
$gpr = "1";
$gps = "server";
$domena = $_SERVER['SERVER_NAME'];

if(!isset($_GET['id']) or !is_numeric($_GET['id']))
{
    $_SESSION['msg'] = "Server nije pronaden";
    header("Location: index.php?id=".$_SESSION['klijentid']);
    die();
}

$server = query_fetch_assoc("SELECT s.*, k.ime, k.prezime, k.klijentid FROM serveri s, klijenti k WHERE s.id = {$serverid} AND k.klijentid = s.user_id");
$metatitle = $server["ime"];
$metadesc = ipadresa($server["id"]);
$naslov = $metatitle;

        if($row['startovan'] == "1")
        {
            if($row['igra'] == "5") $serverl = lgsl_query_live($querytype, $boxip['ip'], NULL, $row['port']+123, NULL, 's');
            else $serverl = lgsl_query_live($querytype, $boxip['ip'], NULL, $row['port'], NULL, 's');

            $srvime = @$serverl['s']['name'];
            $srvigraci = @$serverl['s']['players'].'/'.@$serverl['s']['playersmax'];
        }
include("./assets/header.php");
?>
    <div class="main-other">
        <div class="panel">
<?php

$ip = ipadresa($server['id']);
$ip = explode(":", $ip);

require("./includes/libs/lgsl/lgsl_class.php");


?>
             <div class="panel-main-other">
                <div class="panel-padding">
                    <div class="panel-header light-border">
                    	<p class="bg-green c-white bold panel-header-status"><?php echo srv_status($server['status']); ?></p><p class="bold"><?php echo $server["name"]; ?></p>
                       <a target="_blank" <?php printf("href='https://www.facebook.com/sharer/sharer.php?u=%s%s'",$_SERVER['HTTP_HOST'],$_SERVER['REQUEST_URI']); ?>><button><i class="fab fa-facebook-square"></i>  Podijeli</button></a>
</div>

                    <div class="panel-status-other">
                        <ul>
                            <li>
                                <h3 class="c-blue"><i class="fas fa-users"></i> Online</h3>
                                <h4><td><?php echo $srvigraci; ?></td></h4>
                            </li>
                            <li>
                                <h3 class="c-purple"><i class="fas fa-trophy"></i> Rank</h3>
                                <h4>#<?php echo htmlspecialchars($server['rank']); ?></h4>
                            </li>
                        </ul>
                    </div>

                    <div class="panel-essentials-other light-border">
                        <ul> <?php $klijent = query_fetch_assoc("SELECT * FROM `klijenti` WHERE `klijentid` = '".$server['user_id']."'"); ?>
                            <li><font class="bold">Vlasnik servera:</font> <?php printf("<a href='profil.php?id=%s'> %s %s",$server['user_id'], htmlspecialchars($klijent['ime']), htmlspecialchars($klijent['prezime'])); ?></a></li>
                            <li><font class="bold">Ime Servera:</font> <?php echo htmlspecialchars($server['name']); ?></li>
                            <li><font class="bold">Vrsta Igre:</font> <?php echo igra($server['igra']); ?></li>
                            <li><font class="bold">IP Adresa:</font> <?php echo ipadresa($server['id']); ?></li>
                        </ul>
                    <div class="panel-grafik-other">
                        <img src="gp-banner.php?id=<?php echo $serverid; ?>" />
                    </div>
                    </div>

</div></div></div></div>
<?php
include("./assets/footer.php");
?>
